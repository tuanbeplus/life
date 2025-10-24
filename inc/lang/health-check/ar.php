<?php
return [
  'general' => [
    'heading' => 'دعنا نبدأ ونتحقّق من أهليتي',
    'subHeading' => null,
  ],
  'steps' => [
    'step1' => [
      'title' => 'الخطوة ١',
      'questions' => [
        'gender' => [
          'number' => 'Q1',
          'label' => 'ما هو جنسك؟',
          'options' => [
            'Male' => 'ذكر',
            'Female' => 'أنثى',
          ],
        ],
        'age' => [
          'number' => 'Q2',
          'label' => 'كم عمرك؟',
          'options' => [
            'Under 35 years' => 'أقل من 35 سنة',
            '35 - 44 years' => '35-44 سنة',
            '45 - 54 years' => '45-54 سنة',
            '55 - 64 years' => '55-64 سنة',
            '65 years or over' => 'أكثر من 65 سنة',
          ],
        ],
        'background' => [
          'number' => 'Q3',
          'label' => 'هل أنت من السكان الأصليين، أو من سكان جزر مضيق توريس، أو من أصول المحيط الهادئ أو الماوري؟',
          'options' => [
            'Yes' => 'نعم انا كذلك',
            'No' => 'لا لستُ كذلك',
          ],
        ],
        'birthplace' => [
          'number' => 'Q4',
          'label' => 'أينَ وُلدتَ؟',
          'options' => [
            'Australia' => 'أستراليا',
            'Asia (including the Indian sub-continent)' => 'آسيا (بما في ذلك شبه القارة الهندية)',
            'Southern Europe' => 'جنوب اوروبا',
            'Middle East' => 'الشرق الأوسط',
            'North Africa' => 'شمال أفريقيا',
            'Other' => 'مكان آخر',
          ],
        ],
        'diabetes' => [
          'number' => 'Q5',
          'label' => 'هل تمّ تشخيص إصابة أحد والديْك أو أي من إخوتك أو أخواتك بمرض السكري (النوع 1 أو النوع 2)؟',
          'options' => [
            'Yes' => 'نعم',
            'No' => 'لا',
          ],
        ],
        'pregnancy' => [
          'number' => 'Q6',
          'label' => 'هل سبق أن وُجد أن لديك ارتفاع في نسبة السكر في الدم على سبيل المثال، في الفحص الصحي، أثناء المرض، أثناء الحمل؟',
          'options' => [
            'Yes' => 'نعمى',
            'No' => 'لا',
          ],
        ],
        'blood_pressure_medication' => [
          'number' => 'Q7',
          'label' => 'هل تتناول حالياً أدوية لارتفاع ضغط الدم؟',
          'options' => [
            'Yes' => 'نعم انا كذلك',
            'No' => 'لا لستُ كذلك',
          ],
        ],
        'smoker' => [
          'number' => 'Q8',
          'label' => 'هل تدخن التبغ كل يوم؟',
          'options' => [
            'Yes' => 'نعم أدخِّن',
            'No' => 'كلا لا أدخِّن',
          ],
        ],
        'vegetables' => [
          'number' => 'Q9',
          'label' => 'كم مرة تأكل الخضار أو الفاكهة؟',
          'options' => [
            'Everyday' => 'كل يوم',
            'Not everyday' => 'ليس كل يوم',
          ],
        ],
        'exercise' => [
          'number' => 'Q10',
          'label' => 'في المتوسط، هل تمارس 2.5 ساعة على الأقل من النشاط البدني في الأسبوع (على سبيل المثال نصف ساعة في 5 أيام أو أكثر من خمسة أيام)؟',
          'options' => [
            'Yes' => 'نعم',
            'No' => 'لا',
          ],
        ],
      ],
    ],
    'step2' => [
      'title' => 'الخطوة ٢',
      'questions' => [
        'waist_range' => [
          'number' => 'Q11',
          'label' => 'ما هو قياس خصرك؟',
          'label_with_size' => 'ما هو قياس خصرك؟',
          'measurement_tables' => [
            'measurement-table-one' => [
              'heading_suffix' => '',
            ],
            'measurement-table-two' => [
              'heading_suffix' => '(من أصول آسيوية أو من السكان الأصليين أو من سكان جزر مضيق توريس)',
            ],
          ],
          'genders' => [
            'Female' => 'النساء',
            'Male' => 'رجال',
          ],
          'table_column_headers' => [
            'size' => 'حجم الملابس',
            'measurement' => 'الخصر (سم)',
            'val' => 'تصنيف',
          ],
          'miscText' => [
            'select' => 'أنا ضمن هذا النطاق',
          ],
          'classicButtons' => [
            '1' => 'فينصالت 1',
            '2' => 'فينصالت 2',
            '3' => 'فينصالت 3',
          ],
          'ranges' => [
            'Female' => [
              'measurement-table-one' => [
                'waist_ranges' => [
                  '1' => [
                    'size' => '10 &mdash; 12',
                    'measurement' => 'أقل من 88 سم',
                    'postVal' => 'Less than 88 cm',
                  ],
                  '2' => [
                    'size' => '14 &mdash; 16',
                    'measurement' => '88-100سم',
                    'postVal' => '88cm-100cm',
                  ],
                  '3' => [
                    'size' => '18+',
                    'measurement' => 'أكثر من 100 سم',
                    'postVal' => 'More than 100cm',
                  ],
                ],
              ],
              'measurement-table-two' => [
                'waist_ranges' => [
                  '1' => [
                    'measurement' => 'أقل من 80 سم',
                    'postVal' => 'Less than 80cm',
                  ],
                  '2' => [
                    'measurement' => '90-80 سم',
                    'postVal' => '80-90cm',
                  ],
                  '3' => [
                    'measurement' => 'أكثر من 90 سم',
                    'postVal' => 'More than 90cm',
                  ],
                ],
              ],
            ],
            'Male' => [
              'measurement-table-one' => [
                'waist_ranges' => [
                  '1' => [
                    'size' => 'S, M',
                    'measurement' => 'أقل من 102 سم',
                    'postVal' => 'Less than 102 cm',
                  ],
                  '2' => [
                    'size' => 'L, XL',
                    'measurement' => '102 سم - 110 سم',
                    'postVal' => '102-110cm',
                  ],
                  '3' => [
                    'size' => 'XXL+',
                    'measurement' => 'أكثر من 110 سم',
                    'postVal' => 'More than 110cm',
                  ],
                ],
              ],
              'measurement-table-two' => [
                'waist_ranges' => [
                  '1' => [
                    'measurement' => 'أقلىمنىى90ىمسى',
                    'postVal' => 'Less than 90cm',
                  ],
                  '2' => [
                    'measurement' => 'ىمس100-ى90',
                    'postVal' => '90 - 100cm',
                  ],
                  '3' => [
                    'measurement' => 'أكثر من 100 سم',
                    'postVal' => 'More than 100cm',
                  ],
                ],
              ],
            ],
          ],
          'textDirectionRtl' => true,
        ],
      ],
    ],
    'step3' => [
      'title' => 'الخطوه 3',
      'questions' => [
        'diagnosis' => [
          'number' => 'Q12',
          // 'Have you been diagnosed with one or more of the following?',
          'label' => 'هل تمّ تشخيص إصابتك بواحدة أو أكثر مما يلي؟',
          'multiselect' => true,
          'options' => [
            '' => [
              'label' => 'ولا واحدة مما يلي',
              'female_only' => false,
              'is_positive' => false,
            ],
            'History_of_CVD__c' => [
              'label' => 'مرض القلب أو السكتة الدماغية (على سبيل المثال النوبة القلبية، عدم انتظام دقات القلب، الذبحة الصدرية، قصور القلب)',
              'female_only' => false,
              'is_positive' => true,
            ],
            'Had_GDM__c' => [
              'label' => 'سكري الحمل',
              'female_only' => true,
              'is_positive' => true,
            ],
            'Moderate_Severe_Chronic_Kidney_Disease__c' => [
              'label' => 'فشل كلوي مزمن',
              'female_only' => false,
              'is_positive' => true,
            ],
            'Systolic_BP_180mmHg_diastolic_BP_110__c' => [
              'label' => 'ضغط دم مرتفع',
              'female_only' => false,
              'is_positive' => true,
            ],
            'Impaired_glucose_tolerance__c' => [
              'label' => 'مقدمات السكري',
              'female_only' => false,
              'is_positive' => true,
            ],
            'Polycystic_ovary_syndrome__c' => [
              'label' => 'متلازمة المبيض المتعدد الكيسات',
              'female_only' => true,
              'is_positive' => true,
            ],
            'Serum_total_cholesterol_7_5mmol_L__c' => [
              'label' => 'كولسترول مرتفع',
              'female_only' => false,
              'is_positive' => true,
            ],
          ],
        ],
      ],
    ],
  ],
  'confirm' => 'احسب مستوى الخطر عندي',
  'riskLevels' => [
    'high' => [
      'desc' => '12 +',
      't' => 'مرتفع',
      'statistic' => 'سيصاب شخص  <span class="fg-primary wt-sb"> 1 من كل 14 </span> بمرض السكري في غضون 5 سنوات',
    ],
    'medium' => [
      'desc' => '6 - 11',
      't' => 'متوسط',
      'statistic' => 'سيصاب شخص  <span class="fg-primary wt-sb"> 1 من كل 7 </span> بمرض السكري في غضون 5 سنوات',
    ],
    'low' => [
      'desc' => '0 - 5',
      't' => 'منخفض',
      'statistic' => 'سيصاب شخص  <span class="fg-primary wt-sb"> 1 من كل 14 </span> بمرض السكري في غضون 5 سنوات',
    ],
  ],
  'results' => [ /* modal-health-check-chinese-arabic :519 */
    'oldLayout' => [
      'yourScoreIs' => 'نتيجتك هي',
      'yourRiskLevelIs' => 'ومستوى الخطر عندك',
      'youMayBeEligible' => 'قد تكون مؤهلاً لبرنامج الحياة(<em>Life!</em> Program)', // div.eligibility.formatted.risk-high
      'contactUsAboutJoining' => 'اتصل بنا بخصوص الانضمام', // risk-high
      // todo
      'statistic' => 'سيصاب شخص  <span class="fg-primary wt-sb"> 1 من كل _NUMBER_OF_PEOPLE_ </span> بمرض السكري في غضون 5 سنوات',
      'lifeHasHelpedOver' => 'لقد ساعد برنامج <em>Life!</em> أكثر من 75 000 من سكان ولاية فيكتوريا على تحسين عاداتهم الغذائية والنشاط البدني وإدارة التوتر.',
      'youAreNotEligible' => '(Life! Program)عذرا, انت لست مؤهلا لبرنامج الحياة', // for risk-low if no risk-low below
      'contactOptions' => [ // risk-high-or-diagnosis
        'button' => 'اتصل بفريقنا',
         'orCall' => 'أو اتصل بفريقنا على <a href="tel:137475">75 74 13</a>',
        'flexDirection' => 'row',
      ],
    ],
    // 'yourScoreIs' => 'نتيجتك هي',
    // 'headerEligibility' => [
    //   'risk-high' => [
    //     'heading' => 'XXXX', // you may be eligible for the Life! program
    //     'register' => [
    //       'buttonText' => 'xxx',
    //       'orCall' => 'xxx',
    //     ],
    //   ],
    //   'risk-not-high' => [
    //     'heading' => 'XXX', // Sorry, you are not eligible for the Life! program
    //     'post_heading' => 'XXX <a href="https://lifeprogram.org.au/health-hub/">Health Hub</a>',
    //   ],
    // ],
    // 'body_intro' => 'XXX', // Life! helps you to exercise more, eat healthier and manage stress
    // 'bodies' => [
    //   'risk-high' => [
    //     'points' => [
    //       [
    //         'icon' => '/icons/result-phone-operator.svg',
    //         'icon_alt' => 'Phone operator',
    //         'text' => 'xxxx',
    //       ],
    //       [
    //         'icon' => '/icons/result-speech.svg',
    //         'icon_alt' => 'Speech bubbles',
    //         'text' => 'xxxx',
    //       ],
    //       [
    //         'icon' => '/icons/result-checklist.svg',
    //         'icon_alt' => 'Checklist',
    //         'text' => 'xxxx',
    //       ],
    //     ],
    //   ],
    //   'risk-not-high' => [
    //     'splash_image' => [
    //       'desktop' => '/images/modal-splash/healthy-score.jpg',
    //       'mobile' => '/images/modal-splash/healthy-score-mobile.webp',
    //     ],
    //   ],
    // ],
    // 'footer_stats_template' => 'approximately-x-will-develop-diabetes2',
    // 'footer_by_completing' => [
    //   'risk-high' => 'XXX',
    //   'risk-not-high' => '',
    // ],
  ],
  'contact' => [
    'intro' => [
      'heading' => 'أنت على بُعد خطوة واحدة فقط', // You\'re only one step away
      'subheading' => 'أرسل تفاصيلك وسنعاود الاتصال بك قريباً.', // Submit your details and we will get back to you shortly.
    ],
    'fields' => [
      'first_name' => [
        'label' => 'الاسم الأول',
      ],
      'last_name' => [
        'label' => 'اسم العائلة',
      ],
      'phone' => [
        'label' => 'الهاتف',
        'type' => 'tel',
        'title' => 'أدخل رقم هاتف مؤلف من 10 أرقام بدون فراغات',
        'validation_macro' => 'phone',
      ],
      'postcode' => [
        'label' => 'شفرة البريد',
        'title' => 'أدخل الرمز البريدي المكون من 4 أرقام بدون مسافات',
        'validation_macro' => 'postcode',
      ],
      'email' => [
        'label' => 'البريد الإلكتروني',
        'type' => 'email',
      ],
      'heard_about_via' => [
        'label' => 'كيف سمعت عنا؟',
        'placeholder' => 'الرجاء تحديد',
        'type' => 'select',
        'options' => [
          '' => 'الرجاء تحديد',
          'Social Media' => 'وسائل التواصل الاجتماعي',
          'Community Group' => 'مجموعة المجتمع',
          'Event' => 'مناسبة',
          'Health Professional' => 'أخصائي صحي',
          'GP' => 'طبيب العائلة',
          'Word of mouth' => 'حديث الناس',
          'Workplace' => 'مكان العمل',
          'Other' => 'وسيلة أخرى',
        ],
      ],
      'speaks_english' => [
        'label' => 'هل تشعر بالراحة عند التحدث باللغة الإنجليزية؟',
        'type' => 'radios',
        'options' => [
          'Yes' => 'نعم',
          'No' => 'لا',
        ],
      ],
      'consent' => [
        'label' => 'أعطي موافقتي لموظفيDiabetes Victoria  من برنامج <em>Life!</em>  للاتصال بي بخصوص برنامج <em>Life!</em> وأي معلومات شخصية تمّ جمعها لاستخدامها عند الضرورة في الإجراءات الإدارية لبرنامج<em>Life!</em>.</span>',
        'validation' => [
          'message_required' => 'للمتابعة بالتسجيل، يرجى إعطاء موافقتك',
        ],
      ],
    ],
    'return_to_site_button_text' => 'ارجع إلى الموقع',
    'submit_button_text' => 'أرسل التفاصيل',
  ],
];