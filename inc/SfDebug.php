<?php
namespace SfDebug;

function simpleDump($var) {
    echo '<pre style="white-space: pre-wrap;">';
    if (is_array($var)) {
        foreach ($var as $key => $val) {
            echo str_pad($key, 44) . $val . "\n";
        }
    } else {
        var_dump($var);
    }
    echo '</pre>';
}
function dumpFieldsRaw($data, $form) {
    echo '<h1>sent from contact form : '.count($data).'</h1>';
    echo '<pre>';
    foreach ($data as $fieldId => $val) {
        echo str_pad($fieldId, 44) . $val . "\n";
    }
    echo '</pre>';
    echo "\n<br>\n<br>\n";
    echo '<h1>fields in salesforce-field-mappings.php : '.count($form['fields'] ?? []).'</h1>';
    echo '<pre>';
}

function dumpFieldsMapped($sf_data) {
    echo '</pre>';
    echo "\n<br>\n<br>\n";
    
    echo '<h1>$sf_data CURLOPT_POSTFIELDS ('.count($sf_data).' fields)</h1>';
    echo '<pre>';
    foreach ($sf_data as $fieldId => $val) {
        echo str_pad($fieldId, 44) . json_encode($val) . "\n";
    }
    echo '</pre>';
}

function printSalesforceResponse($sf_data, $ch, $response) {
    echo "<h3>sf_data:</h3>";
    echo '<pre>';
    print_r($sf_data);
    echo '</pre>';
    
    $split = explode("\r\n\r\n", $response);
    echo "<h3>response:</h3>";
    foreach ($split as $part) {
        echo "<pre>";
        $data = json_decode($part, true);
        if ($data) {
            echo count($data)." elements of json:\n";
            foreach ($data as $d) {
                print_r($d);
            }
        } else {
            echo "\n";
            print_r($part);
            echo "\n";
        }
        echo "</pre>";
    }

}

function dumpEmail($data, $mailUser, $mailAdmin) {
    echo '<h1>eligible_for_flex: '.$data['eligible_for_flex'].'</h1>';
    echo '<h2>Subject: '. $mailUser['subject'] .'</h2>';
    echo $mailUser['body'];
    echo '<h2>Subject: '. $mailAdmin['subject'] .'</h2>';
    echo $mailAdmin['body'];
}

function testEmails($mailUser, $mailAdmin) {
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';
    $headers[] = 'To: Lee <lee@brightlabs.com.au>';
    $headers[] = 'From: Life! Program <lee@brightlabs.com.au>';
    mail(
        TEST_EMAIL_ADDRESS,
        $mailUser['subject'],
        $mailUser['body'],
        implode("\r\n", $headers)
    );
    mail(
        TEST_EMAIL_ADDRESS,
        $mailAdmin['subject'],
        $mailAdmin['body'],
        implode("\r\n", $headers)
    );
}

function testEmail($mail) {
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';
    $headers[] = 'To: Lee <lee@brightlabs.com.au>';
    $headers[] = 'From: Life! Program <lee@brightlabs.com.au>';
    mail(
        TEST_EMAIL_ADDRESS,
        $mail['subject'],
        $mail['body'],
        implode("\r\n", $headers)
    );
}


function dumpFinalJson($data, $return) {
    echo '<h1>form_id: '.$data['form_id'].'</h1><pre>';
    echo '<h2>$return:</h2><pre>';
    print_r($return);
    echo '</pre>';
}
