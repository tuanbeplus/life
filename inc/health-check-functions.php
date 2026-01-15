<?php
/**
 * Health Check Functions
 */

function life_enqueue_main() {
  $theme_dir = get_template_directory_uri();
  $theme_ver = time();
  wp_enqueue_style('life-main-css', $theme_dir . '/assets/css/main.css', array(), $theme_ver, 'all');
  wp_enqueue_script('life-main-js', $theme_dir . '/assets/js/main.js', array('jquery'), $theme_ver, true);
  
  // Localize script with AJAX URL and nonce
  wp_localize_script('life-main-js', 'lifeAjax', array(
    'ajaxurl' => admin_url('admin-ajax.php'),
    'updateLeadEOINonce' => wp_create_nonce('life_update_lead_eoi_nonce'),
    'updateLeadDetailsNonce' => wp_create_nonce('life_update_lead_details_nonce'),
  ));
  
  // Localize CALD languages and gravity form ID for health check page
  if (is_page_template('page-templates/life-health-check.php')) {
    $post_id = get_the_ID();
    $events_prefix_arr = [
      'english' => 'English',
      'chinese_s' => 'ChineseS',
      'chinese_t' => 'ChineseT',
      'arabic' => 'Arabic',
      'vietnamese' => 'Vietnamese',
    ];
    $cald_languages = get_field('cald_languages', $post_id);
    $gravity_form_id = get_field('gravity_form_id', $post_id) ?: 2;
    $dv_redirect_url = get_field('diabetes_victoria_redirect_url', 'options') ?: 'https://www.diabetesvic.org.au/';
    $ausdrisk_language = get_field('ausdrisk_language', $post_id);
    $tracking_event_prefix = $events_prefix_arr[$ausdrisk_language] ?? 'English';

    wp_localize_script('life-main-js', 'lifeHealthCheck', array(
      'gravityFormId' => $gravity_form_id,
      'caldLanguages' => $cald_languages ?: array(),
      'dvRedirectUrl' => $dv_redirect_url,
      'ausdriskLanguage' => $ausdrisk_language,
      'trackingEventPrefix' => $tracking_event_prefix,
    ));
  }
}
add_action('wp_enqueue_scripts', 'life_enqueue_main');

/**
 * AJAX handler to update Salesforce Lead EOI (Expression of Interest) by email
 */
add_action('wp_ajax_life_update_lead_eoi', 'life_ajax_update_lead_eoi');
add_action('wp_ajax_nopriv_life_update_lead_eoi', 'life_ajax_update_lead_eoi');
function life_ajax_update_lead_eoi() {
  // Verify nonce for security
  if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'life_update_lead_eoi_nonce')) {
    wp_send_json_error([
      'message' => 'Security check failed.'
    ]);
    return;
  }
  
  // Check if required parameters are provided
  $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
  $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
  $entry_id = isset($_POST['entry_id']) ? absint($_POST['entry_id']) : 0;
  $phone_field_id = isset($_POST['phone_field_id']) ? absint($_POST['phone_field_id']) : 0;
  $result_field_id = isset($_POST['result_field_id']) ? absint($_POST['result_field_id']) : 0;
  $ausdrisk_result = isset($_POST['ausdrisk_result']) ? sanitize_text_field($_POST['ausdrisk_result']) : 'EOI received';

  // Validate email
  if (empty($email) || !is_email($email)) {
    wp_send_json_error([
      'message' => 'Valid email is required.'
    ]);
    return;
  }
  // Validate phone
  if (empty($phone)) {
    wp_send_json_error([
      'message' => 'Phone number is required.'
    ]);
    return;
  }
  // Validate entry ID
  if (empty($entry_id)) {
    wp_send_json_error([
      'message' => 'Entry ID is required.'
    ]);
    return;
  }
  // Validate phone field ID
  if (empty($phone_field_id)) {
    wp_send_json_error([
      'message' => 'Phone field ID is required.'
    ]);
    return;
  }
  // Validate result field ID
  if (empty($result_field_id)) {
    wp_send_json_error([
      'message' => 'Result field ID is required.'
    ]);
    return;
  }
  // Check if Gravity Forms API is available
  if (!class_exists('GFAPI')) {
    wp_send_json_error([
      'message' => 'Gravity Forms is not available.'
    ]);
    return;
  }
  
  // Get the phone entry to verify it exists and get the form ID
  $gform_entry = GFAPI::get_entry($entry_id);
  
  if (is_wp_error($gform_entry)) {
    wp_send_json_error([
      'message' => 'Phone Entry not found.'
    ]);
    return;
  }
  
  // Update the phone field in the phone entry
  $phone_updated = GFAPI::update_entry_field($entry_id, $phone_field_id, $phone);

  // Update the result field in the result entry
  $result_updated = GFAPI::update_entry_field($entry_id, $result_field_id, $ausdrisk_result);

  if (is_wp_error($phone_updated)) {
    wp_send_json_error([
      'message' => 'Failed to update phone number: ' . $phone_updated->get_error_message()
    ]);
    return;
  }
  if (is_wp_error($result_updated)) {
    wp_send_json_error([
      'message' => 'Failed to update AUSDRISK result: ' . $result_updated->get_error_message()
    ]);
    return;
  }
  
  // Get the form ID from the phone entry
  $form_id = $gform_entry['form_id'];
  
  // Resend admin notifications
  // Get the updated entry for notification
  $updated_entry = GFAPI::get_entry($entry_id);
  
  // Get the form to access its notifications
  $form = GFAPI::get_form($form_id);
  
  // Send each notification individually (bypassing conditional logic)
  if (isset($form['notifications']) && is_array($form['notifications'])) {
    foreach ($form['notifications'] as $notification_id => $notification) {
      // Send the notification
      GFCommon::send_notification($notification, $form, $updated_entry);
    }
  }
  
  
  // Update Salesforce Lead EOI
  $sf_errors = [];
  $sf_lead_id = null;
  $sf_update_attempted = false;
  $sf_lead_found = false;
  
  // Query Salesforce for Lead by email
  if (function_exists('\SfFuncs\queryLeadByEmail')) {
    $lead = \SfFuncs\queryLeadByEmail($email);
    
    if ($lead && isset($lead['Id'])) {
      $sf_lead_found = true;
      $sf_lead_id = $lead['Id'];
      
      // Prepare data for update (Phone field in Salesforce)
      $sf_data = [
        'Phone' => $phone,
        'MobilePhone' => $phone,
        'Status' => $ausdrisk_result,
        'User_Status_Detail__c' => '',
      ];
      
      // Update Lead in Salesforce
      if (function_exists('\SfFuncs\updateLeadById')) {
        $sf_update_attempted = true;
        $sf_errors = \SfFuncs\updateLeadById($lead['Id'], $sf_data);
      }
    }
  }
  
  wp_send_json_success([
    'message' => 'Lead updated and notification sent successfully.',
    'entry_id' => $entry_id,
    'sf_lead_id' => $sf_lead_id,
    'sf_lead_found' => $sf_lead_found,
    'sf_update_attempted' => $sf_update_attempted,
    'sf_errors' => $sf_errors,
    'ausdrisk_result' => $ausdrisk_result,
    'phone_number' => $phone,
  ]);
}

/**
 * AJAX handler to insert Salesforce Lead details by email
 */
add_action('wp_ajax_life_update_lead_details', 'life_ajax_update_lead_details');
add_action('wp_ajax_nopriv_life_update_lead_details', 'life_ajax_update_lead_details');
function life_ajax_update_lead_details() {
  // Verify nonce for security
  if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'life_update_lead_details_nonce')) {
    wp_send_json_error([
      'message' => 'Security check failed.'
    ]);
    return;
  }

  // Check if required parameters are provided
  $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
  $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
  $last_name = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
  $postcode = isset($_POST['postcode']) ? sanitize_text_field($_POST['postcode']) : '';

  // Validate email
  if (empty($email) || !is_email($email)) {
    wp_send_json_error([
      'message' => 'Valid email is required. Please enter a valid email address.'
    ]);
    return;
  }
  // Validate first name
  if (empty($first_name)) {
    wp_send_json_error([
      'message' => 'First name is required. Please enter a valid first name.'
    ]);
    return;
  }
  // Validate last name
  if (empty($last_name)) {
    wp_send_json_error([
      'message' => 'Last name is required. Please enter a valid last name.'
    ]);
    return;
  }
  // Validate postcode
  if (empty($postcode)) {
    wp_send_json_error([
      'message' => 'Postcode is required. Please enter a valid postcode.'
    ]);
    return;
  }

  // Insert Lead in Salesforce
  $sf_errors = [];
  $sf_lead_id = null;
  
  if (function_exists('\SfFuncs\postDataToSalesforce')) {
      // Prepare data for insert 
      $sf_insert_data = [
        'RecordTypeId' => '01290000000sizUAAQ',
        'Status' => 'No Score',
        'User_Status_Detail__c' => 'Warm',
        'Email' => $email,
        'FirstName' => $first_name,
        'LastName' => $last_name,
        'PostalCode' => $postcode,
        'CONSENT_TO_OBTAIN_INFORMATION__c' => true,
        'History_of_CVD__c' => 'No',
        'Had_GDM__c' => 'No',
        'LeadSource' => 'Web Request',
      ];
      
      // Insert Lead into Salesforce
      $sf_errors = \SfFuncs\postDataToSalesforce($sf_insert_data);
      
      // Check if insertion was successful (no errors)
      if (!empty($sf_errors)) {
        // Salesforce returned errors - return error response with details
        $error_messages = [];
        foreach ($sf_errors as $error) {
          if (isset($error['message'])) {
            $error_messages[] = $error['message'];
          }
        }
        
        wp_send_json_error([
          'message' => 'Failed to insert Lead: ' . implode(', ', $error_messages),
          'sf_errors' => $sf_errors,
          'email' => $email,
          'first_name' => $first_name,
          'last_name' => $last_name,
          'postcode' => $postcode,
        ]);
        return;
      }

  } else {
    wp_send_json_error([
      'message' => 'Salesforce functions not available.',
      'sf_errors' => [['message' => 'Salesforce functions not available.']],
    ]);
    return;
  }
  
  wp_send_json_success([
    'message' => 'Lead inserted successfully.',
    'email' => $email,
    'first_name' => $first_name,
    'last_name' => $last_name,
    'postcode' => $postcode,
  ]);
}

/**
 * Update Salesforce Lead after Gravity Forms submission
 * 
 * This function hooks into gform_after_submission to automatically update
 * Salesforce Lead records by email after form submission.
 * 
 * @param array $entry The submitted form entry
 * @param array $form The form object
 * @return void
 */
add_action('gform_after_submission', 'life_update_lead_after_gform_submission', 10, 2);
function life_update_lead_after_gform_submission($entry, $form) {
  
  // ============================================
  // CONFIGURATION - Customize these settings
  // ============================================ 
  
  // Specify form IDs to process (leave empty array to process all forms)
  // Example: $allowed_form_ids = [2, 3, 5];
  $allowed_form_ids = [2];
  
  // Skip if form ID is restricted and current form is not in the list
  if (!empty($allowed_form_ids) && !in_array($form['id'], $allowed_form_ids)) {
    return;
  }
  
  // ============================================
  // FIELD MAPPING CONFIGURATION
  // ============================================
  
  // Map Gravity Forms field IDs to Salesforce Lead fields
  $field_mapping = [
    // 'salesforce_field_name' => 'gform_field_id',
    // 'Phone' => '5',
  ];
  
  // Map Salesforce fields using Gravity Forms field CSS classes
  $field_mapping_by_class = [
    // 'salesforce_field_name' => 'css_class_name',
    'AUSDRISK_Test_language__c' => 'AUSDRISK_Test_language__c',
    'Gender__c' => 'Gender__c',
    'AUSDRISK_Q1_Age_Group__c' => 'AUSDRISK_Q1_Age_Group__c',
    'Q3_ATSI_Status__c' => 'Q3_ATSI_Status__c',
    'AUSDRISK_Q3b_Country_Of_Birth__c' => 'AUSDRISK_Q3b_Country_Of_Birth__c',
    'AUSDRISK_Q4_Family_History_Diabetes__c' => 'AUSDRISK_Q4_Family_History_Diabetes__c',
    'AUSDRISK_Q5_High_Blood_Glucose__c' => 'AUSDRISK_Q5_High_Blood_Glucose__c',
    'AUSDRISK_Q6_Medicatn_High_Blood_Pressure__c' => 'AUSDRISK_Q6_Medicatn_High_Blood_Pressure__c',
    'AUSDRISK_Q7_Current_Smoker__c' => 'AUSDRISK_Q7_Current_Smoker__c',
    'AUSDRISK_Q8_Eat_Vegetables_Fruit__c' => 'AUSDRISK_Q8_Eat_Vegetables_Fruit__c',
    'AUSDRISK_Q9_2_5_Hrs_Exercise_A_Week__c' => 'AUSDRISK_Q9_2_5_Hrs_Exercise_A_Week__c',
    'Q10a_Waist_Asian_or_Aboriginal__c' => 'Q10a_Waist_Asian_or_Aboriginal__c',
    'AUSDRISK_Q10_b_Waist_Measurement__c' => 'AUSDRISK_Q10_b_Waist_Measurement__c',
    'History_of_CVD__c' => 'History_of_CVD__c',
    'Had_GDM__c' => 'Had_GDM__c',
    'Moderate_Severe_Chronic_Kidney_Disease__c' => 'Moderate_Severe_Chronic_Kidney_Disease__c',
    'Polycystic_ovary_syndrome__c' => 'Polycystic_ovary_syndrome__c',
    'Serum_total_cholesterol_7_5mmol_L__c' => 'Serum_total_cholesterol_7_5mmol_L__c',
    'Impaired_glucose_tolerance__c' => 'Impaired_glucose_tolerance__c',
  ];
  
  // Static Salesforce field values (applied to ALL updates)
  // These are hardcoded values that don't come from form fields
  // Example: Always set LeadSource, or default values for certain fields
  $static_field_values = [
    // 'salesforce_field_name' => 'value',
  ];
  
  // ============================================
  // EXTRACT EMAIL FROM ENTRY
  // ============================================
  
  // Try to find email field - check common field IDs and labels
  $email = '';
  
  // Method 1: Look for email field by type
  foreach ($form['fields'] as $field) {
    if ($field->type === 'email' && !empty($entry[$field->id])) {
      $email = sanitize_email($entry[$field->id]);
      break;
    }
  }
  
  // Method 2: If no email field found, check for specific field labels
  if (empty($email)) {
    foreach ($form['fields'] as $field) {
      $label = strtolower($field->label);
      if (strpos($label, 'email') !== false && !empty($entry[$field->id])) {
        $email = sanitize_email($entry[$field->id]);
        break;
      }
    }
  }
  // If no email found, cannot proceed
  if (empty($email) || !is_email($email)) {
    error_log('Life GForm to SF: No valid email found in entry ID ' . $entry['id']);
    return;
  }
  
  // ============================================
  // QUERY SALESFORCE FOR LEAD
  // ============================================
  
  if (!function_exists('\\SfFuncs\\queryLeadByEmail')) {
    error_log('Life GForm to SF: Salesforce functions not available');
    return;
  }
  
  $lead = \SfFuncs\queryLeadByEmail($email);
  
  // If Lead doesn't exist, log and return
  if (!$lead || !isset($lead['Id'])) {
    error_log('Life GForm to SF: No Lead found for email ' . $email . ' (Entry ID: ' . $entry['id'] . ')');
    return;
  }
  
  // ============================================
  // BUILD SALESFORCE DATA FROM ENTRY 
  // ============================================ 
  
  $sf_data = [];
  
  // Map fields by ID
  foreach ($field_mapping as $sf_field => $gf_field_id) {
    if (isset($entry[$gf_field_id]) && $entry[$gf_field_id] !== '') {
      $value = $entry[$gf_field_id];
      
      // Apply boolean conversion if needed
      if (strtolower(trim($value)) === 'true') {
        $value = true;
      } elseif (strtolower(trim($value)) === 'false') {
        $value = false;
      }
      
      $sf_data[$sf_field] = $value;
    }
  }
  
  // Map fields by CSS class (if configured) - RECOMMENDED METHOD
  if (!empty($field_mapping_by_class)) {
    foreach ($form['fields'] as $field) {
      // Get CSS classes for this field
      $field_classes = isset($field->cssClass) ? explode(' ', $field->cssClass) : [];
      
      foreach ($field_mapping_by_class as $sf_field => $search_class) {
        // Check if this field has the target CSS class
        if (in_array($search_class, $field_classes)) {
          if (isset($entry[$field->id]) && $entry[$field->id] !== '') {
            $value = $entry[$field->id];
            
            // Apply boolean conversion
            if (strtolower(trim($value)) === 'true') {
              $value = true;
            } elseif (strtolower(trim($value)) === 'false') {
              $value = false;
            }
            
            $sf_data[$sf_field] = $value;
            break; // Found the field, no need to continue
          }
        }
      }
    }
  }
  
  // ============================================
  // CONDITIONAL FIELD MAPPING
  // ============================================
  // Apply conditional logic to set Salesforce fields based on specific conditions
  // This runs AFTER regular field mapping, allowing you to override values conditionally
  
  // Find fields by CSS class and apply conditional mapping
  foreach ($form['fields'] as $field) {
    $field_classes = isset($field->cssClass) ? explode(' ', $field->cssClass) : [];
    $field_value = isset($entry[$field->id]) ? trim($entry[$field->id]) : '';
    
    // Skip if field has no value
    if ($field_value === '') {
      continue;
    }
    // Example: Map AUSDRISK_Results_Ineligible field to Status
    if (in_array('AUSDRISK_Results_Ineligible', $field_classes)) {
      if ( !empty($field_value) ) {
        $sf_data['Status'] = $field_value;
        $sf_data['User_Status_Detail__c'] = 'Cold';
      }
    }
    // Example: Map AUSDRISK_Results_Eligible field to Status
    if (in_array('AUSDRISK_Results_Eligible', $field_classes)) {
      if ( !empty($field_value) ) {
        $sf_data['Status'] = $field_value;
        $sf_data['User_Status_Detail__c'] = 'Hot';
      }
    }
    if (in_array('History_of_CVD__c', $field_classes)) {
      if ( !empty($field_value) ) {
        $sf_data['I_can_provide_evidence_for_CVD_GDM_FH__c'] = true;
      }
    }
    if (in_array('Had_GDM__c', $field_classes)) {
      if ( !empty($field_value) ) {
        $sf_data['I_can_provide_evidence_for_CVD_GDM_FH__c'] = true;
      }
    }
  }
  
  // Merge static field values (these override any mapped values)
  if (!empty($static_field_values)) {
    $sf_data = array_merge($sf_data, $static_field_values);
  }
  
  // If no data to update, return
  if (empty($sf_data)) {
    error_log('Life GForm to SF: No data to update for Lead ' . $lead['Id'] . ' (Entry ID: ' . $entry['id'] . ')');
    return;
  }
  
  // ============================================
  // UPDATE LEAD IN SALESFORCE
  // ============================================
  
  if (!function_exists('\\SfFuncs\\updateLeadById')) {
    error_log('Life GForm to SF: updateLeadById function not available');
    return;
  }
  
  $sf_errors = \SfFuncs\updateLeadById($lead['Id'], $sf_data);
  
  // Log results
  if (!empty($sf_errors)) {
    error_log('Life GForm to SF: Error updating Lead ' . $lead['Id'] . ' - ' . print_r($sf_errors, true));
  }
}

/**
 * Shortcode for AUSDRISK Eligible Result
 * Usage: [hc_ausdrisk_result_eligible]
 */
// add_shortcode('hc_ausdrisk_result_eligible', 'hc_ausdrisk_result_eligible_shortcode');
function hc_ausdrisk_result_eligible_shortcode($atts) {
  ob_start();
  return ob_get_clean();
}

/**
 * Convert "true"/"false" string values to Boolean before sending to Salesforce
 * Only applies to checkbox, radio, text, and select field types
 * 
 * @param mixed  $field_value The field value to be sent to Salesforce
 * @param array  $form        The form object
 * @param array  $entry       The entry object
 * @param string $field_id    The field ID
 * @param array  $feed        The feed object
 * 
 * @return mixed The converted field value (Boolean if "true"/"false" string from supported fields, otherwise original value)
 */
function life_convert_gform_entry_booleans($field_value, $form, $entry, $field_id, $feed) {
  // Only process if value is a string
  if (!is_string($field_value)) {
    return $field_value;
  }
  // Get the field object from the form
  $field = GFFormsModel::get_field($form, $field_id);
  
  // Only convert for checkbox, radio, text, and select fields
  if (!$field || !in_array($field->type, array('checkbox', 'radio', 'text', 'select'))) {
    return $field_value;
  }
  // Convert "true" string to Boolean true
  if (strtolower(trim($field_value)) === 'true') {
    return true;
  }
  // Convert "false" string to Boolean false
  if (strtolower(trim($field_value)) === 'false') {
    return false;
  }
  // Return original value if not "true" or "false"
  return $field_value;
}
add_filter('gform_salesforce_field_value', 'life_convert_gform_entry_booleans', 10, 5); 
