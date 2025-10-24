<?php
return [
  'general' => [
    'heading' => 'Let\'s get started',
    // 'subHeading' => 'and check my eligibility',
    'subHeading' => null,
  ],
  'steps' => [
    'step1' => [
      'title' => 'Step 1',
      'questions' => [
        'gender' => [
          'number' => 'Q1',
          'label' => 'What is your gender?',
          'options' => [
            'Male' => 'Male',
            'Female' => 'Female',
          ],
        ],
        'age' => [
          'number' => 'Q2',
          'label' => 'How old are you?',
          'options' => [
            'Under 35 years' => 'Under 35 Years',
            '35 - 44 years' => '35 - 44 Years',
            '45 - 54 years' => '45 - 54 Years',
            '55 - 64 years' => '55 - 64 Years',
            '65 years or over' => 'Over 65 Years',
          ],
        ],
        'background' => [
          'number' => 'Q3',
          'label' => 'Are you of Aboriginal, Torres Strait Islander, Pacific or Maori descent?',
          'options' => [
            'Yes' => 'Yes I am',
            'No' => 'No I\'m not',
          ],
        ],
        'birthplace' => [
          'number' => 'Q4',
          'label' => 'Where were you born?',
          'options' => [
            'Australia' => 'Australia',
            'Asia (including the Indian sub-continent)' => 'Asia (including the Indian sub-continent)',
            'Southern Europe' => 'Southern Europe',
            'Middle East' => 'Middle East',
            'North Africa' => 'North Africa',
            'Other' => 'Other',
          ],
        ],
        'diabetes' => [
          'number' => 'Q5',
          'label' => 'Have either of your parents, or any of your brothers or sisters been diagnosed with diabetes (type 1 or type 2)?',
          'options' => [
            'Yes' => 'Yes',
            'No' => 'No',
          ],
        ],
        'pregnancy' => [
          'number' => 'Q6',
          'label' => 'Have you ever been found to have high blood glucose sugar for example, in a health examination, during an illness, during pregnancy?',
          'options' => [
            'Yes' => 'Yes',
            'No' => 'No',
          ],
        ],
        'blood_pressure_medication' => [
          'number' => 'Q7',
          'label' => 'Are you currently taking medication for high blood pressure?',
          'options' => [
            'Yes' => 'Yes I am',
            'No' => 'No I\'m not',
          ],
        ],
        'smoker' => [
          'number' => 'Q8',
          'label' => 'Do you smoke tobacco every day?',
          'options' => [
            'Yes' => 'Yes I do',
            'No' => 'No I don\'t',
          ],
        ],
        'vegetables' => [
          'number' => 'Q9',
          'label' => 'How often do you eat vegetables or fruit?',
          'options' => [
            'Everyday' => 'Everyday',
            'Not everyday' => 'Not everyday',
          ],
        ],
        'exercise' => [
          'number' => 'Q10',
          'label' => 'On average, would you do at least 2.5 hours of physical activity per week (for example half an hour on 5 or more days)?',
          'options' => [
            'Yes' => 'Yes I do',
            'No' => 'No I don\'t',
          ],
        ],
      ],
    ],
    'step2' => [
      'title' => 'Step 2',
      'questions' => [
        'waist_range' => [
          'number' => 'Q11',
          'label' => 'What is your waist measurement OR clothing size?',
          'label_with_size' => 'What is your waist measurement OR clothing size?',
          'measurement_tables' => [
            'measurement-table-one' => [
              'heading_suffix' => '',
            ],
            'measurement-table-two' => [
              'heading_suffix' => '(Asian, Aboriginal or Torres Strait Islander descent)',
            ],
          ],
          'genders' => [
            'Female' => 'Women',
            'Male' => 'Men',
          ],
          'table_column_headers' => [
            'size' => 'Clothing Size',
            'measurement' => 'Waist (cm)',
            'val' => 'Range',
          ],
          'miscText' => [
            'select' => 'Yes, I am within this range',
          ],
          'classicButtons' => [
            '1' => 'Range 1',
            '2' => 'Range 2',
            '3' => 'Range 3',
          ],
          'ranges' => [
            'Female' => [
              'measurement-table-one' => [
                'waist_ranges' => [
                  '1' => [
                    'size' => '10 &mdash; 12',
                    'measurement' => 'Less than 88 cm',
                    'postVal' => 'Less than 88 cm',
                  ],
                  '2' => [
                    'size' => '14 &mdash; 16',
                    'measurement' => '88cm - 100cm',
                    'postVal' => '88-100cm',
                  ],
                  '3' => [
                    'size' => '18+',
                    'measurement' => 'More than 100cm',
                    'postVal' => 'More than 100cm',
                  ],
                ],
              ],
              'measurement-table-two' => [
                'waist_ranges' => [
                  '1' => [
                    'measurement' => 'Less than 80cm',
                    'postVal' => 'Less than 80cm',
                  ],
                  '2' => [
                    'measurement' => '80 &mdash; 90cm',
                    'postVal' => '80-90cm',
                  ],
                  '3' => [
                    'measurement' => 'More than 90cm',
                    'postVal' => 'More than 90cm',
                  ],
                ],
              ],
            ],
            'Male' => [
              'measurement-table-one' => [
                'waist_ranges' => [
                  '1' => [
                    'size' => 'S &mdash; M',
                    'measurement' => 'Less than 102cm',
                    'postVal' => 'Less than 102 cm',
                  ],
                  '2' => [
                    'size' => 'L &mdash; XL',
                    'measurement' => '102cm &mdash; 110cm',
                    'postVal' => '102-110cm',
                  ],
                  '3' => [
                    'size' => 'XXL+',
                    'measurement' => 'More than 110cm',
                    'postVal' => 'More than 110cm',
                  ],
                ],
              ],
              'measurement-table-two' => [
                'waist_ranges' => [
                  '1' => [
                    'measurement' => 'Less than 90cm',
                    'postVal' => 'Less than 90cm',
                  ],
                  '2' => [
                    'measurement' => '90 &mdash; 100cm',
                    'postVal' => '90 - 100cm',
                  ],
                  '3' => [
                    'measurement' => 'More than 100cm',
                    'postVal' => 'More than 100cm',
                  ],
                ],
              ],
            ],
          ],
        ]
      ],
    ],
    'step3' => [
      'title' => 'Step 3',
      'questions' => [
        'diagnosis' => [
          'number' => 'Q12',
          'label' => 'Have you been diagnosed with one or more of the following?',
          'multiselect' => true,
          'options' => [
            '' => [
              'label' => 'None of the below',
              'female_only' => false,
              'is_positive' => false,
            ],
            'History_of_CVD__c' => [
              'label' => 'Heart disease or stroke (e.g. heart attack, arrythmia, angina, heart failure)',
              'female_only' => false,
              'is_positive' => true,
            ],
            'Had_GDM__c' => [
              'label' => 'Gestational Diabetes',
              'female_only' => true,
              'is_positive' => true,
            ],
            'Moderate_Severe_Chronic_Kidney_Disease__c' => [
              'label' => 'Chronic kidney disease',
              'female_only' => false,
              'is_positive' => true,
            ],
            'Systolic_BP_180mmHg_diastolic_BP_110__c' => [
              'label' => 'High blood pressure',
              'female_only' => false,
              'is_positive' => true,
            ],
            'Impaired_glucose_tolerance__c' => [
              'label' => 'Prediabetes',
              'female_only' => false,
              'is_positive' => true,
            ],
            'Polycystic_ovary_syndrome__c' => [
              'label' => 'Polycystic ovarian syndrome',
              'female_only' => true,
              'is_positive' => true,
            ],
            'Serum_total_cholesterol_7_5mmol_L__c' => [
              'label' => 'High cholesterol',
              'female_only' => false,
              'is_positive' => true,
            ],
          ],
        ],
      ],
    ],
  ],
  'confirm' => 'Check my score',
  'riskLevels' => [
    'low' => [
      'desc' => '0 - 5',
      't' => 'Low',
    ],
    'medium' => [
      'desc' => '6 - 11',
      't' => 'Medium',
    ],
    'high' => [
      'desc' => '12 +',
      't' => 'High',
    ],
  ],
  'results' => [
    'oldLayout' => false,
    'yourScoreIs' => 'Your score is',
    'headerEligibility' => [
      'risk-high-or-diagnosis' => [
        'cssClass' => 'risk-high', // GTag: English Eligible for Program New 05032024
        'heading' => 'You may be eligible for the FREE <em>Life!</em> program.',
        'register' => [
          'buttonText' => 'Register your interest',
          'orCall' => 'or call our team on <a href="tel:137475">13 74 75</a>',
        ],
      ],
      'risk-not-high-no-diagnosis' => [
        'cssClass' => 'not-eligible', // GTag: English Not Eligible for Program New 05032024
        'heading' => 'Sorry, you are not eligible for the <em>Life!</em> program.',
        'post_heading' => 'Please visit the <a href="https://lifeprogram.org.au/health-hub/">Health Hub</a> for other healthy living programs and helpful resources.',
      ],
    ],
    'body_intro' => '<em>Life!</em> helps you to exercise more, eat healthier and manage stress.',
    'bodies' => [
      'risk-high-or-diagnosis' => [
        'points' => [
          [
            'icon' => '/icons/result-phone-operator.svg',
            'icon_alt' => 'Phone operator',
            'text' => 'Get access to dietitians and exercise physiologists.',
          ],
          [
            'icon' => '/icons/result-speech.svg',
            'icon_alt' => 'Speech bubbles',
            'text' => 'Tailored support over 7 sessions.',
          ],
          [
            'icon' => '/icons/result-checklist.svg',
            'icon_alt' => 'Checklist',
            'text' => 'Learn how to set goals and stick to them.',
          ],
        ],
      ],
      'risk-not-high-no-diagnosis' => [
        'splash_image' => [
          'desktop' => '/images/modal-splash/healthy-score.jpg',
          'mobile' => '/images/modal-splash/healthy-score-mobile.webp',
        ],
      ],
    ],
    'statistic' => 'Approximately <span class="wt-sb">1 person in _NUMBER_OF_PEOPLE_</span> with your score will develop diabetes within 5 years.',
    'footer_by_completing' => [
      'risk-high-or-diagnosis' => 'By completing the <em>Life!</em> program you can reduce this risk, feel great and get more energy to do the things you love. <em>Life!</em> is supported by the Victorian government.',
      'risk-not-high-no-diagnosis' => '',
    ],
  ],
  'contact' => [
    'intro' => [
      'heading' => 'You\'re only one step away',
      'subheading' => 'Submit your details and we will get back to you shortly.',
    ],
    'fields' => [
      'first_name' => [
        'label' => 'First name',
      ],
      'last_name' => [
        'label' => 'Last name',
      ],
      'phone' => [
        'label' => 'Phone',
        'type' => 'tel',
        'validation_macro' => 'phone',
      ],
      'postcode' => [
        'label' => 'Postcode',
        'validation_macro' => 'postcode',
      ],
      'email' => [
        'label' => 'Email',
        'type' => 'email',
      ],
      'heard_about_via' => [
        'label' => 'How did you first hear about us?',
        'placeholder' => 'Please select...',
        'type' => 'select',
        'options' => [
          '' => 'Please select...',
          'A friend or family member' => 'A friend or family member',
          'Social Media' => 'Social Media',
          'Community Group' => 'Community Group',
          'Event' => 'Event',
          'Health Professional' => 'Health Professional',
          'GP' => 'GP',
          'Word of mouth' => 'Word of mouth',
          'Workplace' => 'Workplace',
          'Google search' => 'Google search',
          'Other' => 'Other',
        ],
      ],
      // 'speaks_english' => ...obvi
      'consent' => [
        'label' => 'I give my consent for Diabetes Victoria staff from the <em>Life!</em> program to contact me regarding the <em>Life!</em> program and for any personal information collected to be used for necessary <em>Life!</em> program administrative operations.',
        'validation' => [
          'message_required' => 'To proceed with registering, please give your consent',
        ],
      ],
    ],
    'return_to_site_button_text' => 'Return to Site',
    'submit_button_text' => 'Submit details',
  ],
];