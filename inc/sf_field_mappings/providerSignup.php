<?php
return [
    'notification' => [
        'html' => true,
        'subject' => 'Form Submission - Become a Life! Program Provider',
        'to' => get_field('form_notifications', 'option')['providerSignup'] ?? 'sdube@diabetesvic.org.au',
        'form_name' => 'Become a Life! Program Provider',
    ],
    'api' => true,
    'success' => 'Thank you, We have received your Expression of Interest. Training to become a Life! provider happens 1-2 times a year, applications are reviewed prior to training dates.<br></br>Your expression of interest will be reviewed based on several criteria. If you have any further questions, please contact us at <a href="mailto:life@diabetesvic.org.au">life@diabetesvic.org.au</a>',
    'fields' => [
        //'date' 							=> ['sf' => 'Date_of_EOI',									'static' => '{currentDate}'],

        'org_name' => ['sf' => 'Company', 'validate' => ['required']],
        'building' => ['sf' => 'Building_Name__c'],
        'address' => ['sf' => 'Street', 'validate' => ['required']],
        'suburb' => ['sf' => 'City', 'validate' => ['required']],
        'postcode' => ['sf' => 'PostalCode', 'validate' => ['required', 'numeric']],
        'state' => ['sf' => 'State', 'validate' => ['required']],
        'postal_address' => ['sf' => 'Other_Postal_Address__c', 'validate' => ['required']],
        'abn' => ['sf' => 'ABN__c', 'validate' => ['required']],
        'describe_org' => ['sf' => 'Describe_your_provider_organisation__c', 'validate' => ['required']],

        'first_name' => ['sf' => 'FirstName', 'validate' => ['required']],
        'last_name' => ['sf' => 'LastName', 'validate' => ['required']],
        'phone' => ['sf' => 'Work_Phone__c', 'validate' => ['required']],
        'mobile' => ['sf' => 'MobilePhone'],
        'email' => ['sf' => 'Email', 'validate' => ['required', 'email']],
        'position' => ['sf' => 'Position__c'],    // @todo maybe re-enable
        'fax' => ['sf' => 'Fax'],

        'manager_first_name' => ['sf' => 'Manager_Contact_FName__c', 'validate' => ['required']],
        'manager_last_name' => ['sf' => 'Manager_Contact_Last_name__c', 'validate' => ['required']],
        'manager_phone' => ['sf' => 'Manager_Contact_Phone__c', 'validate' => ['required']],
        'manager_mobile' => ['sf' => 'Manager_Contact_Mobile__c'],
        'manager_email' => ['sf' => 'Manager_Contact_Email__c', 'validate' => ['required', 'email']],

        'appropriate_space' => [
            'sf' => 'Appropriate_space_and_access__c',
            'validate' => ['required', 'in' => ['Yes', 'No']]
        ],
        'referral_pathways' => ['sf' => 'Available_referral_pathways__c', 'validate' => ['required']],
        'delivery_areas' => ['sf' => 'Areas_org_can_run_Life_course__c', 'validate' => ['required']],
        'data_entry' => ['sf' => 'Data_entry_staff__c', 'validate' => ['required']],
        'community_events' => [
            'sf' => 'Interested_in_attending_community_events__c',
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

        'gst_registration' => [
            'sf' => 'Is_this_organisation_registered_for_GST__c',
            'validate' => ['required', 'in' => ['Yes', 'No']],
            'cast' => ['Yes' => true, 'No' => false],
        ],
        'facilitator_names' => ['sf' => 'Facilitator_HC_Name_to_attend_Training__c', 'validate' => ['required']],

        'record_type' => ['sf' => 'RecordTypeId', 'static' => '01290000000sizP'],
        'lead_source' => ['sf' => 'LeadSource', 'static' => 'Web Request'],
        //'oid' 						=> ['sf' => 'oid',												'static' => '00D6D0000008fIM'],
    ],
];