<?php
return [
  'general' => [
    'heading' => '讓我們開始吧，看看我是否合資格',
    'subHeading' => null,
  ],
  'steps' => [
    'step1' => [
      'title' => '步驟1',
      'questions' => [
        'gender' => [
          'number' => 'Q1',
          'label' => '您的性別？',
          'options' => [
            'Male' => '男',
            'Female' => '女',
          ],
        ],
        'age' => [
          'number' => 'Q2',
          'label' => '您的年齡？',
          'options' => [
            'Under 35 years' => '35 歲以下',
            '35 - 44 years' => '35 至 44 歲',
            '45 - 54 years' => '45 至 54 歲',
            '55 - 64 years' => '55 至 64 歲',
            '65 years or over' => '超過 65 歲',
          ],
        ],
        'background' => [
          'number' => 'Q3',
          'label' => '您是否為澳洲原住民、托雷斯海峽島民、太平 洋島民或毛利人後裔？',
          'options' => [
            'Yes' => '是',
            'No' => '否',
          ],
        ],
        'birthplace' => [
          'number' => 'Q4',
          'label' => '您的出生地？',
          'options' => [
            'Australia' => '澳洲',
            'Asia (including the Indian sub-continent)' => '亞洲 (包括印度次大陸)',
            'Southern Europe' => '南歐',
            'Middle East' => '中東',
            'North Africa' => '北非',
            'Other' => '其他',
          ],
        ],
        'diabetes' => [
          'number' => 'Q5',
          'label' => '您的父母或兄弟姐妹中是否有人被診斷患有（1 型或 2 型）糖尿病？',
          'options' => [
            'Yes' => '是',
            'No' => '否',
          ],
        ],
        'pregnancy' => [
          'number' => 'Q6',
          'label' => '您是否曾被驗出血糖過高，比如在健康檢查、患 病期間或妊娠時？',
          'options' => [
            'Yes' => '是',
            'No' => '否',
          ],
        ],
        'blood_pressure_medication' => [
          'number' => 'Q7',
          'label' => '您目前正在服用治療高血壓的藥物嗎？',
          'options' => [
            'Yes' => '是',
            'No' => '否',
          ],
        ],
        'smoker' => [
          'number' => 'Q8',
          'label' => '您是否每天吸煙？',
          'options' => [
            'Yes' => '是',
            'No' => '否',
          ],
        ],
        'vegetables' => [
          'number' => 'Q9',
          'label' => '您多久吃一次蔬菜或水果？',
          'options' => [
            'Everyday' => '每天',
            'Not everyday' => '不是每天',
          ],
        ],
        'exercise' => [
          'number' => 'Q10',
          'label' => '一般情況下，您會每週至少進行 2.5 小時的身 體鍛煉嗎（每週有 5 天或以上每天鍛煉半小時）？',
          'options' => [
            'Yes' => '是',
            'No' => '否',
          ],
        ],
      ],
    ],
    'step2' => [
      'title' => '步驟2',
      'questions' => [
        'waist_range' => [
          'number' => 'Q11',
          'label' => '您的腰圍是多少？',
          'label_with_size' => '您的腰圍是多少？',
          'measurement_tables' => [
            'measurement-table-one' => [
              'heading_suffix' => '(亞裔、澳洲原住民或托雷斯海峽島民後 裔)',
            ],
            'measurement-table-two' => [
              'heading_suffix' => '(亞裔、澳洲原住民或托雷斯海峽島民後 裔)',
            ],
          ],
          'genders' => [
            'Female' => '女性',
            'Male' => '男性',
          ],
          'table_column_headers' => [
            // 'size' => 'Clothing Size',
            'measurement' => '腰圍 (釐米)',
            'val' => '範圍',//<!-- scope/range -->
          ],
          'miscText' => [
            'select' => '是的，我在這個範圍內',
          ],
          'classicButtons' => [
            '1' => '範圍 1',
            '2' => '範圍 2',
            '3' => '範圍 3',
          ],
          'ranges' => [
            'Female' => [
              'measurement-table-one' => [
                'waist_ranges' => [
                  '1' => [
                    // 'size' => '10 &mdash; 12',
                    'measurement' => '小於 88 釐米',
                    'postVal' => 'Less than 88 cm',
                  ],
                  '2' => [
                    // 'size' => '14 &mdash; 16',
                    'measurement' => '88 至 100 釐米',
                    'postVal' => '88cm-100cm',
                  ],
                  '3' => [
                    // 'size' => '18+',
                    'measurement' => '超過 100 釐米',
                    'postVal' => 'More than 100cm',
                  ],
                ],
              ],
              'measurement-table-two' => [
                'waist_ranges' => [
                  '1' => [
                    'measurement' => '小於 80 釐米',
                    'postVal' => 'Less than 80cm',
                  ],
                  '2' => [
                    'measurement' => '80 至 90 釐米',
                    'postVal' => '80-90cm',
                  ],
                  '3' => [
                    'measurement' => '超過 90 釐米',
                    'postVal' => 'More than 90cm',
                  ],
                ],
              ],
            ],
            'Male' => [
              'measurement-table-one' => [
                'waist_ranges' => [
                  '1' => [
                    // 'size' => 'S, M',
                    'measurement' => '小於 102 釐米',
                    'postVal' => 'Less than 102 cm',
                  ],
                  '2' => [
                    // 'size' => 'L, XL',
                    'measurement' => '102 至 110 釐米',
                    'postVal' => '102-110cm',
        
                  ],
                  '3' => [
                    // 'size' => 'XXL+',
                    'measurement' => '超過 110 釐米',
                    'postVal' => 'More than 110cm',
        
                  ],
                ],
              ],
              'measurement-table-two' => [
                'waist_ranges' => [
                  '1' => [
                    'measurement' => '小於 90 釐米',
                    'postVal' => 'Less than 90cm',
                  ],
                  '2' => [
                    'measurement' => '90 至 100 釐米',
                    'postVal' => '90 - 100cm',
                  ],
                  '3' => [
                    'measurement' => '超過 100 釐米',
                    'postVal' => 'More than 100cm',
                  ],
                ],
              ],
            ],
          ],
        ],
      ],
    ],
    'step3' => [
      'title' => '第3步',
      'questions' => [
        'diagnosis' => [
          'number' => 'Q12',
          // 'label' => 'Have you been diagnosed with one or more of the following?',
          'label' => '您是否被診斷出患有以下一種或多種疾病？',
          'multiselect' => true,
          'options' => [
            '' => [
              'label' => '無下列情況',
              'female_only' => false,
              'is_positive' => false,
            ],
            'History_of_CVD__c' => [
              'label' => '心臟病或中風（如心臟病髮作、心律失常、心絞痛、心力衰竭）',
              'female_only' => false,
              'is_positive' => true,
            ],
            'Had_GDM__c' => [
              'label' => '妊娠期糖尿病',
              'female_only' => true,
              'is_positive' => true,
            ],
            'Moderate_Severe_Chronic_Kidney_Disease__c' => [
              'label' => '慢性腎病',
              'female_only' => false,
              'is_positive' => true,
            ],
            'Systolic_BP_180mmHg_diastolic_BP_110__c' => [
              'label' => '高血壓',
              'female_only' => false,
              'is_positive' => true,
            ],
            'Impaired_glucose_tolerance__c' => [
              'label' => '糖尿病前期',
              'female_only' => false,
              'is_positive' => true,
            ],
            'Polycystic_ovary_syndrome__c' => [
              'label' => '多囊卵巢綜合徵',
              'female_only' => true,
              'is_positive' => true,
            ],
            'Serum_total_cholesterol_7_5mmol_L__c' => [
              'label' => '高膽固醇',
              'female_only' => false,
              'is_positive' => true,
            ],
          ],
        ],
      ],
    ],
  ],
  'confirm' => '計算我的風險',
  'riskLevels' => [
    'low' => [
      'desc' => '0 至 5',
      't' => '為低級',
      'statistic' => '低級：大約<span class="fg-primary wt-sb">每 14 人中就有 1 人</span>會在 5 年內患 上糖尿病',
    ],
    'medium' => [
      'desc' => '6 至 11',
      't' => '為中級',
      'statistic' => '中級：大約<span class="fg-primary wt-sb">每 7 人中就有 1 人</span>會在 5 年內患上 糖尿病。',
    ],
    'high' => [
      'desc' => '12 +',
      't' => '為高級',
      'statistic' => '高級：大約<span class="fg-primary wt-sb">每 3 人中就有 1 人</span>會在五年內患上糖 尿病。',
    ],
  ],
  'results' => [ /* modal-health-check-chinese-traditional :374 */
    'oldLayout' => [
      'yourScoreIs' => '您的分數是',
      'yourRiskLevelIs' => '您的風險等級',
      'youMayBeEligible' => '您可能合資格參加<em>Life!</em>計畫。', // div.eligibility.formatted.risk-high
      'contactUsAboutJoining' => '聯絡我們參加計畫', // risk-high-or-diagnosis
      // 'statistic' => '低級：大約<span class="fg-primary wt-sb">每 _NUMBER_OF_PEOPLE_ 人中就有 1 人</span>會在 5 年內患 上糖尿病',
      'lifeHasHelpedOver' => '<em>Life!計畫</em>已幫助超過 75000 名維多利亞州 居民改善飲食習慣、身體活動和壓力管理。',
      'youAreNotEligible' => '抱歉，您沒有符合參與 <em>Life!</em> 計劃的要求',
      'contactOptions' => [ // risk-high-or-diagnosis
        'button' => '聯絡我們的團隊',
         'orCall' => '或者致電<a href="tel:137475">13 74 75</a>聯絡我們',
        'flexDirection' => 'row',
      ],
    ],
    // 'yourScoreIs' => '您的分數是',
    // 'headerEligibility' => [
    //   'risk-high' => [
    //     'heading' => '您可能合資格參加<em>Life!>計畫</em>。', // you may be eligible for the Life! program
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
      'heading' => '還有一步就大功告成了', // You\'re only one step away
      'subheading' => '請提交您的詳細資料, 我們將很快聯絡您。', // Submit your details and we will get back to you shortly.
    ],
    'fields' => [
      'first_name' => [
        'label' => '名',
      ],
      'last_name' => [
        'label' => '姓',
      ],
      'phone' => [
        'label' => '電話',
        'type' => 'tel',
        'title' => 'Enter 10 digit phone number without spaces',
        'validation_macro' => 'phone',
      ],
      'postcode' => [
        'label' => '郵遞區號',
        'title' => 'Enter 4 digit postcode without spaces',
        'validation_macro' => 'postcode',
      ],
      'email' => [
        'label' => '電郵地址',
        'type' => 'email',
      ],
      'heard_about_via' => [
        'label' => '您是如何得知我們的？',
        'placeholder' => '請選擇',
        'type' => 'select',
        'options' => [
          '' => '請選擇',
          'Social Media' => '社群媒體',
          'Community Group' => '社區團組',
          'Event' => '活動',
          'Health Professional' => '醫務人員',
          'GP' => '全科醫生',
          'Word of mouth' => '口口相傳',
          'Workplace' => '工作場所',
          'Other' => '其他方式',
        ],
      ],
      'speaks_english' => [
        'label' => '您可以用英語交流嗎？',
        'type' => 'radios',
        'options' => [
            'Yes' => '是的',
            'No' => '不',
        ],
      ],
      'consent' => [
        'label' => '本人同意 Diabetes Victoria 為<em>Life!</em>計畫 工作的人員就<em>Life!計畫</em>與我聯繫, 並收集本人的個人資料, 用於必要的 <em>Life!計畫</em>行政管理操作。',
        'validation' => [
          'message_required' => '要繼續註冊，請同意',
        ],
      ],
    ],
    'return_to_site_button_text' => '返回網站。',
    'submit_button_text' => '提交詳細資料',
  ],
];