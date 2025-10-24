<?php
return [
    // 'confirmation' => [
    // 	'html' 		=> true,
    // 	'subject' 	=> 'Life! Program AUSDRISK test results',
    // 	'recipient'	=> 'email',
    // ],
    'notification' => [
        'html' => true,
        'subject' => 'Form Submission - Life! Program AUSDRISK test',
        'to' => get_field('form_notifications', 'option')['ausdrisk'] ?? 'sdube@diabetesvic.org.au',
        'form_name' => 'Life! Program AUSDRISK test',
    ],
    'api' => true,
    'success' => 'Thank you for your enquiry. One of our friendly staff will be in contact with you within the next 24-48 hours.',
    'success_zh-Hans' => '感谢您的查询。我们友好的工作人员将在 24 至 48 小时内与您联系。',
    'success_zh-Hant' => '感謝您的查詢。我們友好的工作人員將在 24 至 48 小時內與您聯繫。',
    'success_ar' => 'شكرا لاستفسارك. سيتواصل معك أحد موظفينا الودودين في غضون 24-48 ساعة القادمة.',
    'success_vi' => 'Cảm ơn quý vị đã nêu thắc mắc. Một trong những nhân viên thân thiện của chúng tôi sẽ liên lạc với quý vị trong vòng 24-48 giờ tới.',
    'fields' => [
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
                    'Advertising campaign April/May 2024',
                    'A friend or family member',
                    'Social Media',
                    'Community Group',
                    'Event',
                    'Health Professional',
                    'GP',
                    'Word of mouth',
                    'Workplace',
                    'Google search',
                    'Other',
                ],
            ],
        ],
        'contact_time' => ['sf' => 'Preferred_day_time_to_be_called__c'],
        'gender' => ['sf' => 'Gender__c'],
        'consent' => ['sf' => 'CONSENT_TO_OBTAIN_INFORMATION__c', 'static' => 'bool:true'],

        'risk_score' => ['sf' => 'AUSDRISK_Score__c'],
        'height_cm' => ['sf' => 'Height__c'],
        'weight_kg' => ['sf' => 'Weight__c'],

        'age' => [
            'sf' => 'AUSDRISK_Q1_Age_Group__c',
            'validate' => [
                'required',
                'in' => ['Under 35 years', '35 - 44 years', '45 - 54 years', '55 - 64 years', '65 years or over'],
            ]
        ],
        'background' => ['sf' => 'Q3_ATSI_Status__c', 'validate' => ['required', 'in' => ['Yes', 'No']]],
        'birthplace' => [
            'sf' => 'AUSDRISK_Q3b_Country_Of_Birth__c',
            'validate' => [
                'required',
                'in' => [
                    'Australia',
                    'Asia (including the Indian sub-continent)',
                    'North Africa',
                    'Middle East',
                    'Southern Europe',
                    'Other',
                ],
            ],
        ],
        'diabetes' => [
            'sf' => 'AUSDRISK_Q4_Family_History_Diabetes__c',
            'validate' => ['required', 'in' => ['Yes', 'No']],
        ],
        'pregnancy' => ['sf' => 'AUSDRISK_Q5_High_Blood_Glucose__c', 'validate' => ['required', 'in' => ['Yes', 'No']]],
        'blood_pressure_medication' => [
            'sf' => 'AUSDRISK_Q6_Medicatn_High_Blood_Pressure__c',
            'validate' => ['required', 'in' => ['Yes', 'No']],
        ],
        'smoker' => ['sf' => 'AUSDRISK_Q7_Current_Smoker__c', 'validate' => ['required', 'in' => ['Yes', 'No']]],
        'vegetables' => [
            'sf' => 'AUSDRISK_Q8_Eat_Vegetables_Fruit__c',
            'validate' => ['required', 'in' => ['Everyday', 'Not everyday']],
        ],
        'exercise' => [
            'sf' => 'AUSDRISK_Q9_2_5_Hrs_Exercise_A_Week__c',
            'validate' => ['required', 'in' => ['Yes', 'No']],
        ],
        'waist_atsi' => [
            'sf' => 'Q10a_Waist_Asian_or_Aboriginal__c',
            'validate' => [
                'in' => [
                    'Less than 90cm',
                    'Less than 80cm',
                    '90 - 100cm',
                    '80-90cm',
                    'More than 100cm',
                    'More than 90cm',
                ],
            ],
        ],
        'waist_other' => [
            'sf' => 'AUSDRISK_Q10_b_Waist_Measurement__c',
            'validate' => [
                'in' => [
                    'Less than 102 cm',
                    'Less than 88 cm',
                    '102-110cm',
                    '88-100cm',
                    'More than 110cm',
                    'More than 100cm'
                ],
            ],
        ],

        'record_type' => ['sf' => 'RecordTypeId', 'static' => '01290000000sizU'],
        'lead_source' => ['sf' => 'LeadSource', 'static' => 'Web Request'],
        //'oid' 						=> ['sf' => 'oid',											'static' => '00D6D0000008fIM'],
        
        // moderateRisk
        'Any_medical_history__c' => [
            'sf' => 'Any_medical_history__c',
            'cast' => ['Yes' => true, 'No' => false],
        ],
        'weight_gain_five' => [
            'sf' => 'Weight_gain_meets_criteria__c',
            'cast' => ['Yes' => true, 'No' => false],
        ],
        'Waist_Circumference_meets_criteria__c' => [
            'sf' => 'Waist_Circumference_meets_criteria__c',
            'cast' => ['Yes' => true, 'No' => false],
        ],
        'workplace' => [
            'sf' => 'How_did_you_hear_about_us_if_WP_HP__c',
        ],
        'health_professional' => [
            'sf' => 'How_did_you_hear_about_us_if_WP_HP__c',
        ],
        // 'Height__c' => ['sf' => 'Height__c'],
        // 'Weight__c' => ['sf' => 'Weight__c'],
        'eligible_for_flex' => [
            'sf' => 'Life_Flex_Lead__c',
            'cast' => ['Yes' => true, 'No' => false],
        ],
        
        'address' => [
            'sf' => 'Street',
        ],
        'postcode' => [
            'sf' => 'PostalCode',
        ],

        'History_of_CVD__c' => [
            'sf' => 'History_of_CVD__c',
        ],
        'Had_GDM__c' => [
            'sf' => 'Had_GDM__c',
        ],
        'Moderate_Severe_Chronic_Kidney_Disease__c' => [
            'sf' => 'Moderate_Severe_Chronic_Kidney_Disease__c',
            'cast' => ['Yes' => true, 'No' => false],
        ],
        'Systolic_BP_180mmHg_diastolic_BP_110__c' => [
            'sf' => 'Systolic_BP_180mmHg_diastolic_BP_110__c',
            'cast' => ['Yes' => true, 'No' => false],
        ],
        'Impaired_glucose_tolerance__c' => [
            'sf' => 'Impaired_glucose_tolerance__c',
            'cast' => ['Yes' => true, 'No' => false],
        ],
        'Polycystic_ovary_syndrome__c' => [
            'sf' => 'Polycystic_ovary_syndrome__c',
            'cast' => ['Yes' => true, 'No' => false],
        ],
        'Serum_total_cholesterol_7_5mmol_L__c' => [
            'sf' => 'Serum_total_cholesterol_7_5mmol_L__c',
            'cast' => ['Yes' => true, 'No' => false],
        ],
        'I_can_provide_evidence_for_CVD_GDM_FH__c' => [
            'sf' => 'I_can_provide_evidence_for_CVD_GDM_FH__c',
            'cast' => ['Yes' => true, 'No' => false],
            // 'static' => 'bool:true',
        ],
        'speaks_english' => [
            'sf' => 'Comfortable_speaking_English__c',
            // 'validate' => ['in' => ['Yes', 'No'], 'required']
        ],
    ],
];