<?php
/**
 * Health Check Functions
 */

function life_enqueue_main() {
  $theme_dir = get_template_directory_uri();
  $theme_ver = '2.0.0';
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
    $dv_redirect_url = get_field('diabetes_victoria_redirect_url', 'options') ?: '/living-with-diabetes/';
    $ausdrisk_language = get_field('ausdrisk_language', $post_id);
    $tracking_event_prefix = $events_prefix_arr[$ausdrisk_language] ?? 'English';
    $eligible_result_acf = get_field('eligible_result', get_the_ID());
    $eoi_form = $eligible_result_acf ['eoi_form'] ?? '';
    $submit_button_text = $eoi_form['submit_button_text'] ?? '';
    $submit_loading_text = $eoi_form['submit_loading_text'] ?? '';

    wp_localize_script('life-main-js', 'lifeHealthCheck', array(
      'gravityFormId' => $gravity_form_id,
      'caldLanguages' => $cald_languages ?: array(),
      'dvRedirectUrl' => $dv_redirect_url,
      'ausdriskLanguage' => $ausdrisk_language,
      'trackingEventPrefix' => $tracking_event_prefix,
      'submitButtonText' => $submit_button_text,
      'submitLoadingText' => $submit_loading_text,
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
  $form_id = $gform_entry['form_id'] ?? 0;

  /**
   * Heavy work moved async:
   * - Resending Gravity Forms notifications (can be slow due to wp_mail/SMTP)
   * - Salesforce update (already async)
   */

  // Schedule notifications resend in the background
  wp_schedule_single_event(time(), 'life_async_resend_gform_notifications', [$entry_id, $form_id]);

  // Update Salesforce Lead EOI - ASYNC
  // Schedule the event to run immediately in the background
  wp_schedule_single_event(time(), 'life_async_lead_eoi_update', [$email, $phone, $ausdrisk_result]);

  // Trigger cron immediately (fire and forget) so async tasks start ASAP
  if (function_exists('spawn_cron')) {
    spawn_cron(time());
  }
  
  $sf_update_attempted = true; // Assumed true as it's scheduled
  $sf_lead_found = true; // Assumed
  $sf_lead_id = 'pending_async';
  $sf_errors = [];

  wp_send_json_success([
    'message' => 'Lead updated and notification sent successfully (SF update scheduled).',
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
 * Async handler to resend Gravity Forms notifications for an entry.
 * This is intentionally async to keep the EOI submit response fast.
 */
add_action('life_async_resend_gform_notifications', 'life_handle_async_resend_gform_notifications', 10, 2);
function life_handle_async_resend_gform_notifications($entry_id, $form_id) {
  if (!class_exists('GFAPI') || !class_exists('GFCommon')) {
    return;
  }

  $entry_id = absint($entry_id);
  $form_id  = absint($form_id);

  if (!$entry_id || !$form_id) {
    return;
  }

  $updated_entry = GFAPI::get_entry($entry_id);
  if (is_wp_error($updated_entry)) {
    return;
  }

  $form = GFAPI::get_form($form_id);
  if (!$form || !isset($form['notifications']) || !is_array($form['notifications'])) {
    return;
  }

  // Send each notification individually (bypassing conditional logic)
  foreach ($form['notifications'] as $notification_id => $notification) {
    GFCommon::send_notification($notification, $form, $updated_entry);
  }
}

/**
 * Async handler for EOI Update
 */
add_action('life_async_lead_eoi_update', 'life_handle_async_lead_eoi_update', 10, 3);
function life_handle_async_lead_eoi_update($email, $phone, $ausdrisk_result) {
    if (!function_exists('\SfFuncs\queryLeadByEmail')) {
        return; 
    }

    $lead = \SfFuncs\queryLeadByEmail($email);
    
    if ($lead && isset($lead['Id'])) {
      // Prepare data for update (Phone field in Salesforce)
      $sf_data = [
        'Phone' => $phone,
        'MobilePhone' => $phone,
        'Status' => $ausdrisk_result,
        'User_Status_Detail__c' => '',
      ];
      
      // Update Lead in Salesforce
      if (function_exists('\SfFuncs\updateLeadById')) {
        \SfFuncs\updateLeadById($lead['Id'], $sf_data);
      }
    }
}

/**
 * AJAX handler to update or insert Salesforce Lead details by email
 * If lead exists, updates the latest one; otherwise inserts a new lead
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

  // Check if Lead already exists in Salesforce - ASYNC MOVED
  
  // Schedule the background task
  $args = [
    $email,
    $first_name,
    $last_name,
    $postcode
  ];
  wp_schedule_single_event(time(), 'life_async_lead_details_update', $args);
  
  // Return success immediately
  wp_send_json_success([
    'message' => 'Lead update scheduled successfully.',
    'action' => 'scheduled',
    'sf_lead_id' => 'pending_async',
    'email' => $email,
    'first_name' => $first_name,
    'last_name' => $last_name,
    'postcode' => $postcode,
  ]);
}

/**
 * Async handler for Lead Details Update
 */
add_action('life_async_lead_details_update', 'life_handle_async_lead_details_update', 10, 4);
function life_handle_async_lead_details_update($email, $first_name, $last_name, $postcode) {
    if (!function_exists('\SfFuncs\queryLeadByEmail') || !function_exists('\SfFuncs\updateLeadById') || !function_exists('\SfFuncs\postDataToSalesforce')) {
        error_log('Salesforce functions not available for async details update.');
        return;
    }

    $existing_lead = \SfFuncs\queryLeadByEmail($email);
    $sf_lead_id = $existing_lead['Id'] ?? '';
    $sf_lead_status = $existing_lead['Status'] ?? '';

    // Prepare Base Salesforce Data
    $sf_data = [
      'FirstName'                        => $first_name,
      'LastName'                         => $last_name,
      'PostalCode'                       => $postcode,
      'Status'                           => 'No Score',
      'User_Status_Detail__c'            => 'Warm',
      'CONSENT_TO_OBTAIN_INFORMATION__c' => true,
    ];

    // Determine if we should UPDATE or INSERT
    // We update if a lead exists AND it hasn't reached "EOI received" status
    $should_update = (!empty($sf_lead_id) && $sf_lead_status !== 'EOI received');

    if ($should_update) {
        // --- UPDATE LOGIC ---
        if ($sf_lead_status === 'No EOI' || $sf_lead_status === 'Waiting for Eligibility') {
            $sf_data['Status'] = 'No EOI';
            $sf_data['User_Status_Detail__c'] = 'Hot';
        }

        $errors = \SfFuncs\updateLeadById($sf_lead_id, $sf_data);
        if (!empty($errors)) {
            error_log('SF Async Update Error (' . $email . '): ' . print_r($errors, true));
        }
    } else {
        // --- INSERT LOGIC --- 
        // Handles "No Lead Found" OR "Existing Lead is EOI received" cases
        $insert_data = array_merge($sf_data, [
            'RecordTypeId'          => '01290000000sizUAAQ',
            'Email'                 => $email,
            'History_of_CVD__c'     => 'No',
            'Had_GDM__c'            => 'No',
            'LeadSource'            => 'Web Request',
        ]);

        $errors = \SfFuncs\postDataToSalesforce($insert_data);
        if (!empty($errors)) {
            error_log('SF Async Insert Error (' . $email . '): ' . print_r($errors, true));
        }
    }
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
// Replaced with async scheduler
add_action('gform_after_submission', 'life_schedule_gform_salesforce_sync', 10, 2);
function life_schedule_gform_salesforce_sync($entry, $form) {
    // Schedule the event to run immediately in the background
    // Pass $entry and $form. Note: passing full objects to cron args can be heavy or problematic serialization-wise.
    // However, for single event it is usually handled. Better to pass entry ID and reconstruct form if needed,
    // but gform_after_submission provides full array.
    // Let's pass entry and form ID to stay safe and lightweight.
    
    wp_schedule_single_event(time(), 'life_async_gform_submission', [$entry, $form]);
    
    // Trigger cron immediately (fire and forget)
    spawn_cron(time());
}

add_action('life_async_gform_submission', 'life_process_gform_submission_salesforce_sync', 10, 2);
function life_process_gform_submission_salesforce_sync($entry, $form) {
  
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
    if (in_array('Q10a_Waist_Asian_or_Aboriginal__c', $field_classes)) {
      if ( !empty($field_value) ) {
        $sf_data['AUSDRISK_Q10_b_Waist_Measurement__c'] = '';
      }
    }
    if (in_array('AUSDRISK_Q10_b_Waist_Measurement__c', $field_classes)) {
      if ( !empty($field_value) ) {
        $sf_data['Q10a_Waist_Asian_or_Aboriginal__c'] = '';
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

/**
 * Shortcode for AUSDRISK Eligible Result
 * Usage: [hc_ausdrisk_result_eligible]
 */
add_shortcode('hc_ausdrisk_result_eligible', 'hc_ausdrisk_result_eligible_shortcode');
function hc_ausdrisk_result_eligible_shortcode($atts) {
  ob_start();
  $eligible_result_acf = get_field('eligible_result', get_the_ID());
  $content_before_eoi = $eligible_result_acf['content_before_eoi_form'] ?? '';
  $eoi_form = $eligible_result_acf ['eoi_form'] ?? '';
  $phone_placeholder = $eoi_form['phone_placeholder'] ?? '';
  $phone_validation = $eoi_form['phone_validation'] ?? '';
  $submit_button_text = $eoi_form['submit_button_text'] ?? '';
  $submit_loading_text = $eoi_form['submit_loading_text'] ?? '';
  $content_after_eoi = $eligible_result_acf ['content_after_eoi_form'] ?? '';
  ?>
  
  <?php echo wpautop($content_before_eoi); ?>
  <form class="final-step-form">
    <div class="field">
        <label for="phone-number"><?php echo $phone_placeholder; ?></label>
        <input id="phone-number" name="phone_number" type="tel" placeholder="<?php echo $phone_placeholder; ?>">
    </div>
    <div class="input-container">
        <input id="btn-submit-eoi" type="submit" value="<?php echo $submit_button_text; ?>">
    </div>
    <div class="validate-mess"><?php echo $phone_validation; ?></div>
  </form>
  <hr>
  <?php echo wpautop($content_after_eoi); ?>
  <?php
  return ob_get_clean();
}

/**
 * Shortcode for AUSDRISK Ineligible Result
 * Usage: [hc_ausdrisk_result_ineligible]
 */
add_shortcode('hc_ausdrisk_result_ineligible', 'hc_ausdrisk_result_ineligible_shortcode');
function hc_ausdrisk_result_ineligible_shortcode($atts) {
  ob_start();
  $ineligible_result_acf = get_field('ineligible_result', get_the_ID());
  echo wpautop($ineligible_result_acf);
  return ob_get_clean();
}

/**
 * Get the ID of a GForm field by its CSS class
 *
 * @param int    $form_id     The ID of the form
 * @param string $css_class   The CSS class of the field
 *
 * @return int|null The ID of the field, or null if not found
 */
function hc_get_gform_field_id_by_css_class($form_id, $css_class) {
  $form = GFAPI::get_form($form_id);
  if (!$form) return null;

  foreach ($form['fields'] as $field) {
    if (!empty($field->cssClass) && strpos($field->cssClass, $css_class) !== false) {
      return $field->id;
    }
  }

  return null;
}

/**
 * Get the latest entry for a specific email address in a GForm
 *
 * @param int    $form_id     The ID of the form
 * @param string $email       The email address to search for
 * @param string $email_field_class The CSS class of the email field
 *
 * @return array|null The latest entry for the email address, or null if not found
 */
function hc_get_latest_gform_entry_by_email($form_id, $email, $email_field_class) {

  $email_field_id = hc_get_gform_field_id_by_css_class($form_id, $email_field_class);
  if (!$email_field_id) return null;

  $search_criteria = [
    'status' => 'active',
    'field_filters' => [
      [
        'key'   => (string) $email_field_id,
        'value' => $email
      ]
    ]
  ];

  $sorting = [
    'key'       => 'date_created',
    'direction' => 'DESC'
  ];

  $paging = [
    'offset'    => 0,
    'page_size' => 1
  ];

  $entries = GFAPI::get_entries($form_id, $search_criteria, $sorting, $paging);

  return !empty($entries) ? $entries[0] : null;
}
