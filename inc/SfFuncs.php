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

function getSalesforceAccessToken() {
    $ch = curl_init();

    $password = SF_PASSWORD;
    if (defined('SF_TOKEN') && !empty(SF_TOKEN)) {
        $password .= SF_TOKEN;
    }

    $auth_params = [
        'grant_type'    => 'password',
        'client_id'     => SF_CLIENT_ID,
        'client_secret' => SF_CLIENT_SECRET,
        'username'      => SF_USERNAME,
        'password'      => $password,
    ];

    curl_setopt_array($ch, [
        CURLOPT_URL            => rtrim(SF_ENV, '/') . '/services/oauth2/token',
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => http_build_query($auth_params),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/x-www-form-urlencoded'
        ],
        CURLOPT_TIMEOUT        => 30,
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

function postDataToSalesforce($sf_data) {

    // -------------------------
    // 1. Get access token
    // -------------------------
    $response = getSalesforceAccessToken();
    if ($response === false) {
        return [
            ['message' => 'Failed to get Salesforce token']
        ];
    }

    $auth = json_decode($response);

    if (empty($auth->access_token) || empty($auth->instance_url)) {
        return [
            [
                'message'  => 'Invalid auth response',
                'response' => $response
            ]
        ];
    }

    // -------------------------
    // 2. Insert Lead
    // -------------------------
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL            => rtrim($auth->instance_url, '/') . '/services/data/v52.0/sobjects/Lead',
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => json_encode($sf_data),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => [
            'Authorization: Bearer ' . $auth->access_token,
            'Content-Type: application/json',
        ],
        CURLOPT_TIMEOUT        => 30,
    ]);

    $response = curl_exec($ch);

    if ($response === false) {
        $err = curl_error($ch);
        curl_close($ch);
        return [
            [
                'message' => 'cURL error',
                'error'   => $err
            ]
        ];
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // -------------------------
    // 3. Handle Salesforce response
    // -------------------------
    if ($httpCode >= 200 && $httpCode < 300) {
        // SUCCESS
        return [];
    }

    // Salesforce error format: array of { errorCode, message }
    $decoded = json_decode($response, true);

    if (is_array($decoded)) {
        $sfErrors = [];
        foreach ($decoded as $e) {
            if (isset($e['errorCode'])) {
                $sfErrors[] = $e;
            }
        }

        if (!empty($sfErrors)) {
            return $sfErrors;
        }
    }

    // Fallback error
    return [
        [
            'message'   => 'Salesforce unknown error',
            'http_code' => $httpCode,
            'response'  => $response
        ]
    ];
}

/**
 * Query Salesforce Lead by email address
 * 
 * When multiple duplicate leads exist with the same email, this function
 * returns the latest lead based on CreatedDate (newest first).
 *
 * @param string $email
 * @return array|false Returns the latest Lead record with Id on success, false on failure
 */
function queryLeadByEmail($email) {
    $response = getSalesforceAccessToken();
    $auth = json_decode($response);
    
    if (isset($auth->access_token) && isset($auth->instance_url)) {
        $ch = curl_init();
        
        // Escape single quotes in email for SOQL query
        $escapedEmail = str_replace("'", "\\'", $email);
        
        // Query all leads with this email, ordered by CreatedDate (newest first)
        // This ensures we get the latest lead when duplicates exist
        $query = "SELECT Id, Email, Phone, CreatedDate, Status FROM Lead WHERE Email = '" . $escapedEmail . "' ORDER BY CreatedDate DESC";
        $queryUrl = $auth->instance_url . '/services/data/v52.0/query/?q=' . urlencode($query);
        
        curl_setopt($ch, CURLOPT_URL, $queryUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            [
                'Authorization: Bearer ' . $auth->access_token,
                'Content-Type: application/json',
            ]
        );
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode == 200) {
            $data = json_decode($response, true);
            // Return the first record (latest by CreatedDate) if any exist
            if (isset($data['records']) && count($data['records']) > 0) {
                return $data['records'][0] ?? false;
            }
        }
    }
    return false;
}

/**
 * Get Lead by ID
 *
 * @param string $leadId
 * @return array|false Returns the Lead record with Id on success, false on failure
 */
function getLeadById($leadId) {
    if (empty($leadId)) {
        return false;
    }

    $response = getSalesforceAccessToken();
    $auth = json_decode($response);
    
    if (isset($auth->access_token) && isset($auth->instance_url)) {
        $ch = curl_init();
        
        $url = $auth->instance_url . '/services/data/v52.0/sobjects/Lead/' . $leadId;
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            [
                'Authorization: Bearer ' . $auth->access_token,
                'Content-Type: application/json',
            ]
        );
        
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode == 200) {
            return json_decode($result, true);
        }
    }
    return false;
}

/**
 * Update Salesforce Lead by ID
 *
 * @param string $leadId
 * @param array $sf_data
 * @return array Returns array of errors, empty array on success
 */
function updateLeadById($leadId, $sf_data) {
    $response = getSalesforceAccessToken();
    $auth = json_decode($response);
    
    if (isset($auth->access_token) && isset($auth->instance_url)) {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $auth->instance_url . '/services/data/v52.0/sobjects/Lead/' . $leadId);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
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
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if (PRINT_SALESFORCE_RESPONSE) {
            \SfDebug\printSalesforceResponse($sf_data, $ch, $response);
        }
        
        $sfPostErrors = [];
        if ($httpCode == 204 || $httpCode == 200) {
            // Success - no content or OK
            return $sfPostErrors;
        } else {
            // Parse error response
            foreach (explode("\r\n\r\n", $response) as $part) {
                $data = json_decode($part, true);
                if ($data) {
                    if (isset($data['errorCode'])) {
                        $sfPostErrors[] = $data;
                    } elseif (is_array($data)) {
                        foreach ($data as $d) {
                            if (isset($d['errorCode'])) {
                                $sfPostErrors[] = $d;
                            }
                        }
                    }
                }
            }
            if (empty($sfPostErrors)) {
                $sfPostErrors[] = ['message' => 'HTTP Code: ' . $httpCode];
            }
        }
        
        return $sfPostErrors;
    } else {
        if (PRINT_SALESFORCE_RESPONSE) {
            echo '<h2>Failed to get access token</h2>';
        }
        return [['message' => 'Failed to get access token: ' . $response]];
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
