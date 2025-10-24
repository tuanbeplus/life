<?php

function get_form_field_labels(): array
{
  return [
    // Life! Program AUSDRISK test results
    'FirstName' => 'First Name',
    'LastName' => 'Last Name',
    'Email' => 'Email',
    'Phone' => 'Phone',
    'Gender__c' => 'What is your gender?',
    'Height__c' => 'Your height',
    'Weight__c' => 'Your weight',
    'How_did_you_hear_about_us__c' => 'How did you hear about us?',
    'Preferred_day_time_to_be_called__c' => 'Best time of the day to contact you?',
    'CONSENT_TO_OBTAIN_INFORMATION__c' => 'Consent to obtain information?',
    'AUSDRISK_Test_language__c' => 'AUSDRISK Test language',
    'AUSDRISK_Score__c' => 'AUSDRISK Score',
    'AUSDRISK_Q1_Age_Group__c' => 'How old are you?',
    'Q3_ATSI_Status__c' => 'Q3 ATSI Status',
    'AUSDRISK_Q3b_Country_Of_Birth__c' => 'Where were you born?',
    'AUSDRISK_Q4_Family_History_Diabetes__c' => 'Have either of your parents, or any of your brothers or sisters been diagnosed with diabetes (type 1 or type 2)?',
    'AUSDRISK_Q5_High_Blood_Glucose__c' => 'Have you ever been found to have high blood glucose sugar for example, in a health examination, during an illness, during pregnancy?',
    'AUSDRISK_Q6_Medicatn_High_Blood_Pressure__c' => 'Are you currently taking medication for high blood pressure?',
    'AUSDRISK_Q7_Current_Smoker__c' => 'Do you smoke tobacco every day?',
    'AUSDRISK_Q8_Eat_Vegetables_Fruit__c' => 'How often do you eat vegetables or fruit?',
    'AUSDRISK_Q9_2_5_Hrs_Exercise_A_Week__c' => 'On average, would you do at least 2.5 hours of physical activity per week (for example half an hour on 5 or more days)?',
    'Q10a_Waist_Asian_or_Aboriginal__c' => 'What is your waist measurement? (Asian or Aboriginal)',
    'AUSDRISK_Q10_b_Waist_Measurement__c' => 'What is your waist measurement?',
    'message' => 'Message',

    // Become a Life! Program Provider
    'Company' => 'Organisation Name',
    'Building_Name__c' => 'Building Name',
    'PostalCode' => 'Postcode',
    'Other_Postal_Address__c' => 'Other Postal Address',
    'ABN__c' => 'ABN',
    'Describe_your_provider_organisation__c' => 'How would you best describe your provider organisation?',
    'Work_Phone__c' => 'Phone',
    'MobilePhone' => 'Mobile',
    'Position__c' => 'Position',
    'Manager_Contact_FName__c' => 'Manager First Name',
    'Manager_Contact_Last_name__c' => 'Manager Last Name',
    'Manager_Contact_Phone__c' => 'Manager Phone',
    'Manager_Contact_Mobile__c' => 'Manager Mobile',
    'Manager_Contact_Email__c' => 'Manager Email',
    'Appropriate_space_and_access__c' => 'Is there an appropriate space at your organisation or do you have access to an appropriate venue within the community for you to deliver the Life! course (i.e. private space for 8-15 people, chairs, computer/laptop and projector/screen)?',
    'Available_referral_pathways__c' => 'What referral pathways or networking opportunities are available to you in order to receive eligible participants for your Life! courses?',
    'Areas_org_can_run_Life_course__c' => 'Which area/s would your organisation be interested in delivering the Life! course?',
    'Data_entry_staff__c' => 'Will each facilitator be responsible for entry of participant data assigned to them; or will there be staff (i.e. administration/reception) responsible for this?',
    'Interested_in_attending_community_events__c' => 'Is there an appropriate space at your organisation or do you have access to an appropriate venue within the community for you to deliver the Life! course (i.e. private space for 8-15 people, chairs, computer/laptop and projector/screen)?',
    'Public_Liability_Insurance_coverage__c' => 'Do you have Professional Indemnity Insurance coverage for at least $1,000,000 for any one claim and will this continue to be maintained for at least two years after the End Date* stated in the PSA?',
    'Company_Name_Public_Liability_Insurance__c' => 'What is the name of the company you have Public Liability Insurance with?',
    'Professional_Indemnity_Insurance_cover__c' => 'Do you have Professional Indemnity Insurance coverage for at least $1,000,000 for any one claim and will this continue to be maintained for at least two years after the End Date* stated in the PSA?',
    'Company_Professional_Indemnity_Insurance__c' => 'What is the name of the company you have Professional Indemnity Insurance with?',
    'Is_this_organisation_registered_for_GST__c' => 'Is this organisation registered for GST?',
    'Facilitator_HC_Name_to_attend_Training__c' => 'Facilitator/s name (Life! trained facilitator/s or health professional/s to attend Life! facilitator training)',

    // Deliver the Life! Program
    'postal_as_above' => 'Postal address same as above?',
    'Preferred_method_of_contact__c' => 'Preferred method of contact',
    'Qualification__c' => 'Qualification',
    'Qualifications_Other__c' => 'Other qualification',
    'Professional_Accreditation__c' => 'Professional Accreditation',
    'General_work_experience__c' => 'General work experience',
    'Group_facilitation_work_experience__c' => 'Group facilitation work experience',
    'Experience_working_CALD_people__c' => 'Experience working with people from culturally and linguistically diverse backgrounds',
    'Language_other_than_English__c' => 'Do you speak a language other than English?',
    'If_yes_other_language__c' => 'If yes, which languages?',
    'deliver_cald_q' => 'Are you interested in delivering the CALD Life! program?',
    'CALD_languages_interested_in__c' => 'If yes, In which language?',
    'Access_to_a_computer__c' => 'Do you have regular access to a computer?',
    'Broadband_internet_connection__c' => 'Do you have broadband internet connection?',
    'Provider_Name__c' => 'Name of organisation',
    'Organisation_existing_life_provider__c' => 'Is the organisation an existing Life! provider?',
    'Comments__c' => 'Comments',
    // 'Comments__c' => 'Comments',

    // Become A Life! Tele-Health Coach
    'Australia_model_trainings__c' => 'Certification of the Health Change Australia model trainings',
    'Certification_of_Motivational_Interview__c' => 'Certification of Motivational Interviewing',

    // Request a Workplace Session
    'How_did_you_hear_about_the_Life_program__c' => 'How did you hear about the <em>Life!</em> program?',
    'Proposed_session_dates_for_HLS__c' => 'Proposed session dates - please provide at least two dates',
    'Number_of_participants__c' => 'Number of participants',

    // Resource Request
    'full_name' => 'Full Name',
    'org_name' => 'Name of Organisation',
    'address' => 'Address',
    'suburb' => 'Suburb',
    'state' => 'State',
    'postcode' => 'Post code',
    'event' => 'Are the resources for a specific event?',
    'event_type' => 'What type of event is it?',
    'email' => 'Email',
    'phone' => 'Phone',
    'comments' => 'Any comments or enquiries?',
    'qty' => 'Items',

    // Contact Us
    'Comfortable_speaking_English__c' => 'Are you comfortable speaking English?',
    'Other_Language_s__c' => 'Language spoken at home (if not English)'
  ];
}