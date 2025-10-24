<?php

return [
    'contact' => [
        'notification' => [
            'html' => true,
            'subject' => 'Form Submission - Life! Program Contact Us',
            'to' => get_field('form_notifications', 'option')['contact_us'] ?? 'sdube@diabetesvic.org.au',
            'form_name' => 'Life! Program Contact Us',
        ],
        'api' => true,
        'success' => 'Thank you for your enquiry. One of our friendly staff will be in contact with you within the next 24-48 hours.',
        'fields' => [
            'first_name' => ['sf' => 'FirstName', 'validate' => ['required']],
            'last_name' => ['sf' => 'LastName', 'validate' => ['required']],
            'email' => ['sf' => 'Email', 'validate' => ['required', 'email']],
            'phone' => ['sf' => 'Phone', 'validate' => ['required']],
            'contact_method' => [
                'sf' => 'Preferred_method_of_contact__c',
                'validate' => ['in' => ['Email', 'Phone'], 'required']
            ],
            'speaks_english' => [
                'sf' => 'Comfortable_speaking_English__c',
                'validate' => ['in' => ['Yes', 'No'], 'required']
            ],
            'home_language' => ['sf' => 'Other_Language_s__c'],
            'contact_message' => ['sf' => 'Comments__c', 'validate' => ['required']],
            'record_type' => ['sf' => 'RecordTypeId', 'static' => '0120o0000017hG9'],
            'lead_source' => ['sf' => 'LeadSource', 'static' => 'Web Contact Us Page'],
            //'oid' 				=> ['sf' => 'oid',									'static'	=> '00D6D0000008fIM'],
        ],
    ],
    
    'newsletter_subscribe' => [
        'notification' => [
            'html' => true,
            'subject' => 'Form Submission - Life! Program Newsletter Subscribe',
            'to' => get_field('form_notifications', 'option')['contact_us'] ?? 'sdube@diabetesvic.org.au',
            'form_name' => 'Life! Program Newsletter Subscribe',
        ],
        'api' => true,
        'success' => 'Thank you for subscribing.',
        'fields' => [
            'first_name' => ['sf' => 'FirstName', 'validate' => ['required']],
            'email' => ['sf' => 'Email', 'validate' => ['required', 'email']],
            'record_type' => ['sf' => 'RecordTypeId', 'static' => '0120o0000017hG9'], // same as contact?
            'lead_source' => ['sf' => 'LeadSource', 'static' => 'Web footer newsletter subscribe'],
        ],
    ],
    
    
    'ausdrisk' => include('sf_field_mappings/ausdrisk.php'),
    'gestational' => include('sf_field_mappings/gestational.php'),
    'pcos' => include('sf_field_mappings/pcos.php'),
    
    
    'ausdriskSend' => [
        'confirmation' => [
            'html' => true,
            'subject' => 'Life! Program AUSDRISK test results',
            'recipient' => 'email',
        ],
        'success' => 'Thank you for your submission, we\'ve sent a copy of your screening to your nominated email address.',
        'fields' => [
            'first_name' => ['sf' => 'FirstName', 'validate' => ['required']],
            'last_name' => ['sf' => 'LastName', 'validate' => ['required']],
            'email' => ['sf' => 'Email', 'validate' => ['required', 'email']],
    
            'risk_score' => ['sf' => 'AUSDRISK_Score__c'],
        ],
    ],
    
    'communityRequest' => [
        'notification' => [
            'html' => true,
            'subject' => 'Form Submission - Request a Community Session',
            'to' => get_field('form_notifications', 'option')['communityRequest'] ?? 'sdube@diabetesvic.org.au',
            'form_name' => 'Request a Community Session',
        ],
        'api' => true,
        'success' => 'Thank you for your request to get Life! to deliver a free healthy living session for your community group or organisation. One of our team members will be in contact with you to discuss this shortly.',
        'fields' => [
            'Company' => ['sf' => 'Company', 'validate' => ['required']],
            'FirstName' => ['sf' => 'FirstName', 'validate' => ['required']],
            'LastName' => ['sf' => 'LastName', 'validate' => ['required']],
            'How_did_you_hear_about_the_Life_program__c' => ['sf' => 'How_did_you_hear_about_the_Life_program__c', 'validate' => ['required']],
            'Phone' => ['sf' => 'Phone', 'validate' => ['required']],
            'Email' => ['sf' => 'Email', 'validate' => ['required', 'email']],
            // 'session_dates' => ['sf' => 'Proposed_session_dates_for_HLS__c', 'validate' => ['required']],
            'Number_of_participants__c' => ['sf' => 'Number_of_participants__c', 'validate' => ['required']],
            //'session_type'					=> ['sf' => 'Would_you_like_a_face_to_face_session_or__c', 		'validate' => ['required', 'in' => ['Face-to-face session', 'Webinar']]],
            // 'session_type' => ['sf' => 'Would_you_like_a_face_to_face_session_or__c', 'static' => 'Webinar'],
            
            'Street' => ['sf' => 'Street', 'validate' => ['required']],
            'City' => ['sf' => 'City', 'validate' => ['required']],
            'PostalCode' => ['sf' => 'PostalCode', 'validate' => ['required']],
    
            'StreetAddress__c' => ['sf' => 'StreetAddress__c'],
            'Suburb__c' => ['sf' => 'Suburb__c'],
            'Postcode__c' => ['sf' => 'Postcode__c'],
            'Healthy_Living_Session_delivery_method__c' => ['sf' => 'Healthy_Living_Session_delivery_method__c', 'validate' => ['required', 'in' => [
                'Face to face',
                'Webinar',
                'Either'
            ]]],
            'Do_you_have_a_projector_screen__c' => ['sf' => 'Do_you_have_a_projector_screen__c', 'validate' => ['in' => ['Yes', 'No']]],
            'Preferred_languages_HLS__c' => ['sf' => 'Preferred_languages_HLS__c', 'validate' => ['in' => [
                'English',
                'Vietnamese',
                'Cantonese',
                'Mandarin',
                'Arabic',
            ]]],
            'First_preferred_session_date_time_HLS__c' => ['sf' => 'First_preferred_session_date_time_HLS__c', 'validate' => ['required']],
            'Second_preferred_session_date_time_HLS__c' => ['sf' => 'Second_preferred_session_date_time_HLS__c', 'validate' => ['required']],
    
            'group_type' => ['sf' => 'HLS_Group_Type__c', 'static' => 'Community'],
            'record_type' => ['sf' => 'RecordTypeId', 'static' => '0120o0000017hGA'],
            'lead_source' => ['sf' => 'LeadSource', 'static' => 'Web Request'],
            //'oid' 						=> ['sf' => 'oid',												'static' => '00D6D0000008fIM'],
        ],
    ],
    
    'facilitatorEoi' => [
        'notification' => [
            'html' => true,
            'subject' => 'Form Submission - Deliver the Life! Program',
            'to' => get_field('form_notifications', 'option')['facilitatorEoi'] ?? 'sdube@diabetesvic.org.au',
            'form_name' => 'Deliver the Life! Program',
        ],
        'api' => true,
        'success' => 'Thank you, We have received your Expression of Interest. Training to become a Life! facilitator happens 1-2 times a year, applications are reviewed prior to training dates.<br></br>Your expression of interest will be reviewed based on several criteria. If you have any further questions, please contact us at <a href="mailto:life@diabetesvic.org.au">life@diabetesvic.org.au</a>',
        'fields' => [
            'first_name' => ['sf' => 'FirstName', 'validate' => ['required']],
            'last_name' => ['sf' => 'LastName', 'validate' => ['required']],
            'gender' => [
                'sf' => 'Gender__c',
                'validate' => ['required', 'in' => ['Female', 'Male', 'Indeterminate', 'Intersex', 'Other']]
            ],
            'address' => ['sf' => 'Street', 'validate' => ['required']],
            'suburb' => ['sf' => 'City', 'validate' => ['required']],
            'postcode' => ['sf' => 'PostalCode', 'validate' => ['required', 'numeric']],
            'state' => ['sf' => 'State', 'validate' => ['required']],
            'postal_address' => ['sf' => 'Other_Postal_Address__c', 'validate' => ['required']],
            'email' => ['sf' => 'Email', 'validate' => ['required', 'email']],
            'mobile' => ['sf' => 'MobilePhone', 'validate' => ['required']],
            'phone' => ['sf' => 'Work_Phone__c', 'validate' => ['required']],
            'contact_method' => [
                'sf' => 'Preferred_method_of_contact__c',
                'validate' => ['required', 'in' => ['Phone', 'Email'], 'required']
            ],
            'qualification' => [
                'sf' => 'Qualification__c',
                'validate' => [
                    'required',
                    'in' => [
                        'Bachelor of Applied Science - Human Movement',
                        'Bachelor of Nutrition and Dietetics',
                        'Bachelor of Science - Nursing',
                        'Bachelor of Science - Physiotherapy',
                        'Bachelor of Sports Science',
                        'Master of Nutrition and Dietetics',
                        'Master of Public Health',
                        'Master of Science - Nursing',
                        'Master of Science - Physiotherapy',
                        'Masters of Exercise Physiology',
                        'Other'
                    ]
                ]
            ],
            'other_qualification' => ['sf' => 'Qualifications_Other__c'],
            'professional_accreditation' => ['sf' => 'Professional_Accreditation__c', 'validate' => ['required']],
            'work_experience' => ['sf' => 'General_work_experience__c', 'validate' => ['required']],
            'facilitation_experience' => ['sf' => 'Group_facilitation_work_experience__c', 'validate' => ['required']],
            'cultural_experience' => ['sf' => 'Experience_working_CALD_people__c', 'validate' => ['required']],
            'langauges_other_than_en' => [
                'sf' => 'Language_other_than_English__c',
                'validate' => ['required', 'in' => ['Yes', 'No']]
            ],
            'languages' => ['sf' => 'If_yes_other_language__c'],
            'deliver_cald' => [
                'sf' => 'CALD_languages_interested_in__c',
                'validate' => ['in' => ['Chinese - Mandarin', 'Chinese - Cantonese', 'Vietnamese', 'Arabic']]
            ],
            'computer_access' => ['sf' => 'Access_to_a_computer__c', 'validate' => ['required', 'in' => ['Yes', 'No']]],
            'internet_access' => [
                'sf' => 'Broadband_internet_connection__c',
                'validate' => ['required', 'in' => ['Yes', 'No']]
            ],
            'org_name' => ['sf' => 'Provider_Name__c', 'validate' => ['required']],
            'existing_provider' => [
                'sf' => 'Organisation_existing_life_provider__c',
                'validate' => ['required', 'in' => ['Yes', 'No']]
            ],
            'comments' => ['sf' => 'Comments__c'],
            'ineligible_comments' => ['sf' => 'Ineligible_Comments__c', 'static' => '(blank)'],
    
            'record_type' => ['sf' => 'RecordTypeId', 'static' => '01290000000skon'],
            'lead_source' => ['sf' => 'LeadSource', 'static' => 'Web Request'],
            //'oid' 						=> ['sf' => 'oid',										'static' => '00D6D0000008fIM'],
        ],
    ],
    
    'providerSignup' => include('sf_field_mappings/providerSignup.php'),
    
    'thcEoi' => [
        'notification' => [
            'html' => true,
            'subject' => 'Form Submission - Become A Life! Tele-Health Coach',
            'to' => get_field('form_notifications', 'option')['thcEoi'] ?? 'sdube@diabetesvic.org.au',
            'form_name' => 'Become A Life! Tele-Health Coach',
        ],
        'api' => true,
        'success' => 'Thank you, We have received your Expression of Interest. Training to become a Telephone Health Coach happens 1-2 times a year, applications are reviewed prior to training dates.<br></br>Your expression of interest will be reviewed based on several criteria. If you have any further questions, please contact us at <a href="mailto:life@diabetesvic.org.au">life@diabetesvic.org.au</a>',
        'fields' => [
            //'date' 							=> ['sf' => '00N900000058Ze3',						'static' => '{currentDate}'],
            'first_name' => ['sf' => 'FirstName', 'validate' => ['required']],
            'last_name' => ['sf' => 'LastName', 'validate' => ['required']],
            'gender' => [
                'sf' => 'Gender__c',
                'validate' => ['required', 'in' => ['Female', 'Male', 'Indeterminate', 'Intersex', 'Other']]
            ],
            'address' => ['sf' => 'Street', 'validate' => ['required']],
            'suburb' => ['sf' => 'City', 'validate' => ['required']],
            'postcode' => ['sf' => 'PostalCode', 'validate' => ['required', 'numeric']],
            'state' => ['sf' => 'State', 'validate' => ['required']],
            'postal_address' => ['sf' => 'Other_Postal_Address__c', 'validate' => ['required']],
            'email' => ['sf' => 'Email', 'validate' => ['required', 'email']],
            'mobile' => ['sf' => 'MobilePhone', 'validate' => ['required']],
            'phone' => ['sf' => 'Work_Phone__c', 'validate' => ['required']],
            'contact_method' => [
                'sf' => 'Preferred_method_of_contact__c',
                'validate' => ['required', 'in' => ['Phone', 'Email'], 'required']
            ],
            'qualification' => [
                'sf' => 'Qualification__c',
                'validate' => [
                    'required',
                    'in' => [
                        'Bachelor of Applied Science - Human Movement',
                        'Bachelor of Nutrition and Dietetics',
                        'Bachelor of Science - Nursing',
                        'Bachelor of Science - Physiotherapy',
                        'Bachelor of Sports Science',
                        'Master of Nutrition and Dietetics',
                        'Master of Public Health',
                        'Master of Science - Nursing',
                        'Master of Science - Physiotherapy',
                        'Masters of Exercise Physiology',
                        'Other'
                    ]
                ]
            ],
            'other_qualification' => ['sf' => 'Qualifications_Other__c'],
            'professional_accreditation' => ['sf' => 'Professional_Accreditation__c', 'validate' => ['required']],
            'hca_model_training' => [
                'sf' => 'Australia_model_trainings__c',
                'validate' => ['required', 'in' => ['Yes', 'No']]
            ],
            'motivational_interviewing' => [
                'sf' => 'Certification_of_Motivational_Interview__c',
                'validate' => ['required', 'in' => ['Yes', 'No']]
            ],
    
            'pl_insurance' => [
                'sf' => 'Public_Liability_Insurance_coverage__c',
                'validate' => ['required', 'in' => ['Yes', 'No']]
            ],
            'pl_insurer' => ['sf' => 'Company_Name_Public_Liability_Insurance__c', 'validate' => ['required']],
            'pi_insurance' => [
                'sf' => 'Professional_Indemnity_Insurance_cover__c',
                'validate' => ['required', 'in' => ['Yes', 'No']]
            ],
            'pi_insurer' => ['sf' => 'Company_Professional_Indemnity_Insurance__c', 'validate' => ['required']],
            'ineligible_comments' => ['sf' => 'Ineligible_Comments__c', 'static' => '(blank)'],
    
            'record_type' => ['sf' => 'RecordTypeId', 'static' => '01290000000skom'],
            'lead_source' => ['sf' => 'LeadSource', 'static' => 'Web Request'],
            //'oid' 						=> ['sf' => 'oid',											'static' => '00D6D0000008fIM'],
        ],
    ],
    
    
    'workplaceRequest' => [
        'notification' => [
            'html' => true,
            'subject' => 'Form Submission - Request a Workplace Session',
            'to' => get_field('form_notifications', 'option')['workplaceRequest'] ?? 'sdube@diabetesvic.org.au',
            'form_name' => 'Request a Workplace Session',
        ],
        'api' => true,
        'success' => 'Thank you for your request to get Life! to deliver a free healthy living session in your workplace. One of our team members will be in contact with you to discuss this shortly.',
        'fields' => [
            'Company' => ['sf' => 'Company', 'validate' => ['required']],
            'FirstName' => ['sf' => 'FirstName', 'validate' => ['required']],
            'LastName' => ['sf' => 'LastName', 'validate' => ['required']],
            'How_did_you_hear_about_the_Life_program__c' => ['sf' => 'How_did_you_hear_about_the_Life_program__c', 'validate' => ['required']],
            'Phone' => ['sf' => 'Phone', 'validate' => ['required']],
            'Email' => ['sf' => 'Email', 'validate' => ['required', 'email']],
            // 'session_dates' => ['sf' => 'Proposed_session_dates_for_HLS__c', 'validate' => ['required']],
            //'session_type'					=> ['sf' => 'Would_you_like_a_face_to_face_session_or__c', 		'validate' => ['required', 'in' => ['Face-to-face session', 'Webinar']]],
            // 'session_type' => ['sf' => 'Would_you_like_a_face_to_face_session_or__c', 'static' => 'Webinar'],
    
            // 'Number_of_participants__c' => ['sf' => 'Number_of_participants__c', 'validate' => ['required']],
    
            'Position__c' => ['sf' => 'Position__c', 'validate' => ['required']],
    
            'Street' => ['sf' => 'Street', 'validate' => ['required']],
            'City' => ['sf' => 'City', 'validate' => ['required']],
            'PostalCode' => ['sf' => 'PostalCode', 'validate' => ['required']],
    
            'Number_of_sites__c' => ['sf' => 'Number_of_sites__c', 'validate' => ['required']],
            'Number_of_employees_across_all_sites__c' => ['sf' => 'Number_of_employees_across_all_sites__c', 'validate' => ['required']],
            'StreetAddress__c' => ['sf' => 'StreetAddress__c'],
            'Suburb__c' => ['sf' => 'Suburb__c'],
            'Postcode__c' => ['sf' => 'Postcode__c'],
            'Healthy_Living_Session_delivery_method__c' => ['sf' => 'Healthy_Living_Session_delivery_method__c', 'validate' => ['required', 'in' => [
                'Face to face', 'Webinar', 'Either'
            ]]],
            'Do_you_have_a_projector_screen__c' => ['sf' => 'Do_you_have_a_projector_screen__c', 'validate' => ['in' => ['Yes', 'No']]],
    
            'First_preferred_session_date_time_HLS__c' => ['sf' => 'First_preferred_session_date_time_HLS__c', 'validate' => ['required']],
            'Second_preferred_session_date_time_HLS__c' => ['sf' => 'Second_preferred_session_date_time_HLS__c', 'validate' => ['required']],
    
            'group_type' => ['sf' => 'HLS_Group_Type__c', 'static' => 'Workplace'],
            'record_type' => ['sf' => 'RecordTypeId', 'static' => '0120o0000017hGA'],
            'lead_source' => ['sf' => 'LeadSource', 'static' => 'Web Request'],
            //'oid' 						=> ['sf' => 'oid',												'static' => '00D6D0000008fIM'],
        ],
    ],
    
    
    'resourceRequest' => [
        'notification' => [
            'html' => true,
            'to' => get_field('form_notifications', 'option')['resourceRequest'] ?? 'sdube@diabetesvic.org.au',
            'subject' => 'Resource Request',
            'form_name' => 'Resource Request',
        ],
        'success' => 'Thank you for placing this order. Your resources will be dispatched shortly. ',
        'fields' => [
            'org_name' => ['validate' => ['required']],
            'full_name' => ['validate' => ['required']],
            'address' => ['validate' => ['required']],
            'suburb' => ['validate' => ['required']],
            'postcode' => ['validate' => ['required', 'numeric']],
            'state' => ['validate' => ['required']],
            'phone' => ['validate' => ['required']],
            'email' => ['validate' => ['required', 'email']],
    
            'event' => ['validate' => ['required', 'in' => ['Yes', 'No']]],
            'event_type' => [],
            'comments' => [],
        ],
    ],
];