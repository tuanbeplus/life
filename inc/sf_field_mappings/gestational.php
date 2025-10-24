<?php
return [
    // 'confirmation' => [
    // 	'html' 		=> true,
    // 	'subject' 	=> 'Thank you for your enquiry into Gestational Diabetes',
    // 	'recipient'	=> 'email',
    // ],
    'notification' => [
        'html' => true,
        'subject' => 'Form Submission - New Gestational Diabetes Life! Program registration',
        'to' => get_field('form_notifications', 'option')['ausdrisk'] ?? 'sdube@diabetesvic.org.au',
        'form_name' => 'Gestational Diabetes Life! Program',
    ],
    'api' => true,
    'success' => 'Thank you for your enquiry. One of our friendly staff will be in contact with you within the next 24-48 hours.',
    'success_vi' => 'Cảm ơn bạn đã điền thông tin. Một trong những nhân viên thân thiện của chúng tôi sẽ liên hệ với bạn trong vòng 24-48 giờ tới. Nếu bạn cần thông dịch viên, hãy liên hệ với số 131 450 và cung cấp cho họ số điện thoại của chúng tôi 13 74 75.',
    'fields' => [
        'record_type' => ['sf' => 'RecordTypeId', 'static' => '0129g0000004LKv'],
        'lead_source' => ['sf' => 'LeadSource', 'static' => 'Web Request'],
        'language' => [
            'sf' => 'AUSDRISK_Test_language__c',
            'validate' => ['required'],
        ],


        'first_name' => ['sf' => 'FirstName', 'validate' => ['required']],
        'last_name' => ['sf' => 'LastName', 'validate' => ['required']],
        'email' => ['sf' => 'Email', 'validate' => ['required', 'email']],
        'phone' => ['sf' => 'Phone', 'validate' => ['required']],
        'heard_about_via' => [
            'sf' => 'How_did_you_hear_about_us__c',
            'validate' => [
                'required',
                'in' => [
                    'NDSS email',
                    'Maternal Child Health',
                    'GDM Flyer',
                    'GDM Brochure',
                    'Hospital',
                    'GP',
                    'Google Search',
                    'Word of Mouth',
                    'Health Professional',
                    'Other',
                ],
            ],
        ],
        'health_professional' => [
            'sf' => 'How_did_you_hear_about_us_if_WP_HP__c',
        ],
        'currently_gdm' => [
            'sf' => 'Are_you_currently_pregnant_with_gestatio__c',
            'validate' => [
                'required',
                'in' => [
                    'No',
                    'Yes',
                ],
            ],
        ],
        'due_date' => [
            'sf' => 'What_is_your_due_date__c',
            'date_format' => 'Y-m-d',
        ],
        'consent' => ['sf' => 'CONSENT_TO_OBTAIN_INFORMATION__c', 'static' => 'bool:true'],
        
        // vietnamese
        'Do_you_need_an_interpreter__c' => [
            'sf' => 'Do_you_need_an_interpreter__c',
            'validate' => [
                // 'required',
                'in' => [
                    'No',
                    'Yes',
                ],
            ],
        ],
        'Vietnamese_woman__c' => [
            'sf' => 'Vietnamese_woman__c',
            'cast' => ['yes' => true, 'default' => false],
        ],
        'Program_to_be_deliver_Vietnamese__c' => [
            'sf' => 'Program_to_be_deliver_Vietnamese__c',
            'validate' => [
                // 'required',
                'in' => [
                    'No',
                    'Yes',
                ],
            ],
        ],
    ],
];
