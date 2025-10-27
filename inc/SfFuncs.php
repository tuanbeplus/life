<?php
namespace SfFuncs;

require_once( ABSPATH . 'sf-config.php');

require_once('SfDebug.php');

function languageStringForSalesforce($lang) {
    switch ($lang) {
        case 'en':
            return 'English';
        case 'vi':
            return 'Vietnamese';
        case 'ar':
            return 'Arabic';
        case 'zh-Hans':
            return 'Simplified Chinese';
        case 'zh-Hant':
            return 'Traditional Chinese';
        default:
            return null;
    }
}

function recaptchaCheck($data) {
    $recaptcha_secret = InvRecaptchaSettings::getInstance()->getOption(InvRecaptchaAdminSettings::OPTION_SECRET_KEY);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'secret' => $recaptcha_secret,
        'response' => $data['recaptcha'],
        'remoteip' => $_SERVER['REMOTE_ADDR']
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($ch, CURLOPT_HEADER, true);
    return json_decode(curl_exec($ch));
}

function getSalesforceAccessToken($ch) {
    $auth_params = [
        'grant_type' => 'password',
        'client_id' => SF_CLIENT_ID,
        'client_secret' => SF_CLIENT_SECRET,
        'username' => SF_USERNAME,
        'password' => SF_PASSWORD . SF_TOKEN,
    ];
    curl_setopt(
        $ch,
        CURLOPT_URL,
        SF_ENV . '/services/oauth2/token?' . http_build_query($auth_params)
    );
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($ch, CURLOPT_HEADER, true);
    return curl_exec($ch);
}

function postDataToSalesforce($sf_data) {
    $curlHandleForToken = curl_init();
    $response = getSalesforceAccessToken($curlHandleForToken);
    // print_r($response);
    $responseStatus = curl_getinfo($curlHandleForToken, CURLINFO_HTTP_CODE);
    // print_r($responseStatus);
    // exit();
    if ($responseStatus == 200) {
        $auth = json_decode($response);
        $ch = curl_init();
        // $auth->instance_url: https://lifeprogram.my.salesforce.com
        curl_setopt($ch, CURLOPT_URL, $auth->instance_url . '/services/data/v52.0/sobjects/Lead/');
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($sf_data));
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            [
                'Authorization: Bearer ' . $auth->access_token,
                'Content-Type: application/json',
            ]
        );
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $response = curl_exec($ch);
        
        if (PRINT_SALESFORCE_RESPONSE) {
            \SfDebug\printSalesforceResponse($sf_data, $ch, $response);
        }
        $sfPostErrors = [];
        foreach (explode("\r\n\r\n", $response) as $part) {
            $data = json_decode($part, true);
            if ($data) {
                foreach ($data as $d) {
                    if (isset($d['errorCode'])) {
                        $sfPostErrors[] = $d;
                    }
                }
            }
        }
        return $sfPostErrors;
    } else {
        if (PRINT_SALESFORCE_RESPONSE) {
            echo '<h2>$responseStatus</h2>';
            echo '<h1>CURLINFO_HTTP_CODE: '.$responseStatus.'</h1>';
        }
        return ['message' => 'CURLINFO_HTTP_CODE: '.$responseStatus];
    }
}

function mappedFields($fields, $data) {
    $sf_data = [];
    foreach ($fields as $src_name => $def) {
        if (PRINT_FIELDS) echo str_pad($src_name, 44) . $def['sf'];
        $value = null;
        if ($src_name === 'language') {
            $value = languageStringForSalesforce($data[$src_name]);
        } elseif ($def['static'] ?? false) {
            if ($def['static'] === '') {
                $value = date('Y-m-d');
            } elseif ($def['static'] === 'bool:true') {
                $value = true;
            // } elseif ($def['static'] === 'bool:false') {
            //     $value = $data[$src_name] ? true : false; // rubbish
            } else {
                $value = $def['static'];
            }
            if (PRINT_FIELDS) echo ' ***STATIC*** '.$def['static'];
        } elseif (isset($def['date_format'])) {
            if (trim($data[$src_name] ?? '')) {
                $value = date($def['date_format'], strtotime($data[$src_name]));
            }
            if (PRINT_FIELDS) echo ' ***date_format*** '.$def['date_format'];
        } elseif (($data[$src_name] ?? '') !== '') {
            $value = $data[$src_name];

            if (isset($def['cast']) && $value !== '' && isset($def['cast'][$value])) {
                if (PRINT_FIELDS) echo " -CAST- " . $value;
                if (PRINT_FIELDS) echo " -TO- " . json_encode($def['cast'][$value]);
                $value = $def['cast'][$value];
            }
        } elseif (isset($def['cast']['default'])) {
            $value = $def['cast']['default'];
        }
        if (PRINT_FIELDS) echo "\n";
        if ($value !== null) {
            $sf_data[$def['sf']] = $value;
        }
    }
    return $sf_data;
}

/**
 * @param string $form_id
 * @param array $data
 */
function generateEmailBody($form_id, $data, $template = null)
{
    if ($template === null) {
        $template = strtolower(preg_replace('/([A-Z])/', '-\1', $form_id));
    }
    ob_start();
    $data; // used in template
    require(WP_CONTENT_DIR . '/themes/life/emails/' . $template . '.php');
    $body = ob_get_clean();
    ob_end_clean();
    return $body;
}

function emailUser($form, $data, $template = null) {
    if ($form['confirmation']['html']) {
        add_filter('wp_mail_content_type', function () {
            return 'text/html';
        });
    }
    if ( ! DISABLE_EMAIL) {
        wp_mail(
            $data[$form['confirmation']['recipient']],
            $form['confirmation']['subject'],
            generateEmailBody(
                $data['form_id'],
                $data,
                $template
            )
        );
    } else if (TEST_EMAIL_ADDRESS) {
        \SfDebug\testEmail([
            'subject' => $form['confirmation']['subject'],
            'body' => generateEmailBody(
                $data['form_id'],
                $data,
                $template
            )
        ]);
    }
}

function emailAdmin($form, $data, $template = null) {
    if ($form['notification']['html']) {
        add_filter('wp_mail_content_type', function () {
            return 'text/html';
        });
    }
    $emaildata['fields'] = $form['fields'];
    $emaildata['data'] = $data;
    $emaildata['labels'] = get_form_field_labels();
    $emaildata['resources'] = life_resource_entries();
    $emaildata['form_name'] = $form['notification']['form_name'];

    if (isset($emaildata['data']['qty'])) {
        $tempQtyData = $emaildata['data']['qty'];
        unset($emaildata['data']['qty']);
        $emaildata['data']['qty'] = $tempQtyData;
    }
    if ( ! DISABLE_EMAIL) {
        wp_mail(
            $form['notification']['to'],
            $form['notification']['subject'],
            generateEmailBody(
                $data['form_id'],
                $emaildata,
                $template
            )
        );
    } else if (TEST_EMAIL_ADDRESS) {
        \SfDebug\testEmail([
            'subject' => $form['notification']['subject'],
            'body' => generateEmailBody(
                $data['form_id'],
                $emaildata,
                $template
            )
        ]);
    }
}

/**
 * Log a successful form submission.
 *
 * @param string $form_id
 * @param array $data
 */
function logSubmission($form_id, $data)
{
    $fp = fopen(get_template_directory() . '/form-submissions/log.json', 'a');
    if ($fp !== false) {
        fwrite($fp, json_encode(['type' => $form_id, 'date' => date('r'), 'data' => $data]) . "\n");
        fclose($fp);
    }
}

/**
 * Validate a set of $src data aginst $rules. Returns a field-mapped array of
 * validation failures or an empty array on success.
 *
 * @param array $src
 * @param array $rules
 * @return array
 */
function validateData($src, $rules)
{
    $errors = [];

    foreach ($rules as $field_name => $rule) {
        if ($rule['validate'] ?? false) {
            $value = $src[$field_name];

            foreach ($rule['validate'] as $validation_rule => $settings) {
                if (is_numeric($validation_rule)) {
                    $validation_rule = $settings;
                }

                switch ($validation_rule) {
                    case 'in':
                        if (trim($value) && !in_array($value, $settings)) {
                            $errors[$field_name][] = 'This is not a valid selection.';
                        }
                        break;

                    case 'numeric':
                        if (!is_numeric($value)) {
                            $errors[$field_name][] = 'Please only enter numbers here.';
                        }
                        break;

                    case 'required':
                        if (!trim($value)) {
                            $errors[$field_name][] = 'Please complete this field.';
                        }
                        break;

                    case 'email':
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $errors[$field_name][] = 'Please enter a valid email address.';
                        }
                        break;
                }
            }
        }
    }

    return (!$errors) ? true : $errors;
}
