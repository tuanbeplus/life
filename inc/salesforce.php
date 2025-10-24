<?php
require_once('SfFuncs.php');
require_once('SfDebug.php'); // global $sf_field_mappings


add_action('life_ajax_submit_form', 'life_ajax_submit_form');

require_once('form-field-labels.php');

// copy these to /env.php - DON'T CHANGE THEM HERE
defined('DISABLE_RECAPTCHA') || define('DISABLE_RECAPTCHA', false);
defined('PRINT_FIELDS') || define('PRINT_FIELDS', false);
defined('PRINT_EMAIL') || define('PRINT_EMAIL', false);
defined('DISABLE_EMAIL') || define('DISABLE_EMAIL', false);
defined('DISABLE_SALESFORCE') || define('DISABLE_SALESFORCE', false);
defined('PRINT_SALESFORCE_RESPONSE') || define('PRINT_SALESFORCE_RESPONSE', false);
defined('EXIT_BEFORE_JSON') || define('EXIT_BEFORE_JSON', false);
defined('TEST_EMAIL_ADDRESS') || define('TEST_EMAIL_ADDRESS', false);


/**
 * Handle submitting a form via AJAX, validating our data and submitting to SalesForce as required.
 *
 * @param array $data
 */
function life_ajax_submit_form($data)
{
    $sf_field_mappings = include('salesforce-field-mappings.php'); /* todo - rename to salesforce-mappings.php */
    $form = isset($sf_field_mappings[$data['form_id']]) ? $sf_field_mappings[$data['form_id']] : null;
    $return = ['status' => 'error', 'messages' => []];
    $language = isset($data['language']) && $data['language'] !== '' ? $data['language'] : null;

    if ($form) {
        if (($validation = \SfFuncs\validateData($data, $form['fields'])) === true) {
            $sfPostErrors = [];
            if ($form['api'] ?? false) {
                if (PRINT_FIELDS) {
                    \SfDebug\dumpFieldsRaw($data, $form);
                }
                $sf_data = \SfFuncs\mappedFields($form['fields'], $data);
                if ($data['form_id'] === 'gestational') {
                    if ($data['currently_gdm'] === 'No') {
                        if ($sf_data['What_is_your_due_date__c']) {
                            $sf_data['What_is_your_due_date__c'] = '';
                        }
                    }
                }
                if (PRINT_FIELDS) {
                    \SfDebug\dumpFieldsMapped($sf_data);
                    exit;
                }

                if ( ! DISABLE_SALESFORCE) {
                    $sfPostErrors = \SfFuncs\postDataToSalesforce($sf_data);
                    \SfFuncs\logSubmission($data['form_id'], $sf_data);
                }
            } else {
                \SfFuncs\logSubmission($data['form_id'], $data);
            }

            if (count($sfPostErrors) === 0) {
                if ($form['notification'] ?? false) {
                    \SfFuncs\emailAdmin($form, $data, 'admin-notification');
                }
                
                if ($form['confirmation'] ?? false) {
                    \SfFuncs\emailUser($form, $data);
                }
                
                $return['status'] = 'ok';
                $return['lang'] = $language;
                $successMessage = $language && isset($form["success_$language"]) && $form["success_$language"] !== ''
                    ? $form["success_$language"]
                    : $form['success'];
                $return['messages'][] = str_replace('Life!', '<em>Life!</em>', $successMessage);
            } else {
                $return['validation'] = $sfPostErrors;
            }
        } else {
            $return['validation'] = $validation;
        }
    } else {
        $return['messages'][] = 'Invalid form submission. Please contact our support team for assistance.';
    }
    if (EXIT_BEFORE_JSON) {
        \SfDebug\dumpFinalJson($data, $return);
        exit;
    } else {
        if (false) {
            echo '<h1>data</h1>';
            echo '<pre>';
            print_r($data);
            echo '</pre>';
            // echo '<h1>form</h1>';
            // echo '<pre>';
            // print_r($form);
            // echo '</pre>';
            exit;
        }
    
        wp_send_json($return, ($return['status'] === 'ok') ? 200 : 400);
    }
}


// Execute our AJAX submission handler
if (isset($_POST['action']) && ($_POST['action'] == 'life_ajax_submit_form')) {
    do_action('life_ajax_submit_form', $_POST);
}


