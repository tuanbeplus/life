<?php
return [
  'general' => [
    'heading' => '让我们开始吧，看看我是否合资格',
    'subHeading' => null,
  ],
  'steps' => [
    'step1' => [
      'title' => '步骤1',
      'questions' => [
        'gender' => [
          'number' => 'Q1',
          'label' => '您的性别?',
          'options' => [
            'Male' => '男',
            'Female' => '女',
          ],
        ],
        'age' => [
          'number' => 'Q2',
          'label' => '您的年龄?',
          'options' => [
            'Under 35 years' => '35 岁以下',
            '35 - 44 years' => '35至44岁',
            '45 - 54 years' => '45至54岁',
            '55 - 64 years' => '55至64岁',
            '65 years or over' => '超过65岁',
          ],
        ],
        'background' => [
          'number' => 'Q3',
          'label' => '您是否为澳大利亚原住民、托雷斯海峡岛民、 太平洋岛民或毛利人后裔?',
          'options' => [
            'Yes' => '是',
            'No' => '否',
          ],
        ],
        'birthplace' => [
          'number' => 'Q4',
          'label' => '您的出生地?',
          'options' => [
            'Australia' => '澳大利亚',
            'Asia (including the Indian sub-continent)' => '亚洲(包括印度次大陆)',
            'Southern Europe' => '南欧',
            'Middle East' => '中东',
            'North Africa' => '北非',
            'Other' => '其他',
          ],
        ],
        'diabetes' => [
          'number' => 'Q5',
          'label' => '您的父母或兄弟姐妹中是否有人被诊断患有(1 型或 2 型)糖尿病?',
          'options' => [
            'Yes' => '是',
            'No' => '否',
          ],
        ],
        'pregnancy' => [
          'number' => 'Q6',
          'label' => '您是否曾被验出血糖过高，比如在健康检查、 患病期间或妊娠时?',
          'options' => [
            'Yes' => '是',
            'No' => '否',
          ],
        ],
        'blood_pressure_medication' => [
          'number' => 'Q7',
          'label' => '您目前正在服用治疗高血压的药物吗?',
          'options' => [
            'Yes' => '是',
            'No' => '否',
          ],
        ],
        'smoker' => [
          'number' => 'Q8',
          'label' => '您是否每天吸烟?',
          'options' => [
            'Yes' => '是',
            'No' => '否',
          ],
        ],
        'vegetables' => [
          'number' => 'Q9',
          'label' => '您多久吃一次蔬菜或水果?',
          'options' => [
            'Everyday' => '每天',
            'Not everyday' => '不是每天',
          ],
        ],
        'exercise' => [
          'number' => 'Q10',
          'label' => '一般情况下，您会每周至少进行 2.5 小时的身 体锻炼吗(每周有 5 天或以上每天锻炼半小时)?',
          'options' => [
            'Yes' => '是',
            'No' => '否',
          ],
        ],
      ],
    ],
    'step2' => [
      'title' => '步骤2',
      'questions' => [
        'waist_range' => [
          'number' => 'Q11',
          'label' => '您的腰围是多少?',
          'label_with_size' => '您的腰围是多少?',
          'measurement_tables' => [
            'measurement-table-one' => [
              'heading_suffix' => '(亚裔、澳大利亚原住民或托雷斯海峡岛 民后裔)',
            ],
            'measurement-table-two' => [
              'heading_suffix' => '(亚裔、澳大利亚原住民或托雷斯海峡岛 民后裔)',
            ],
          ],
          'genders' => [
            'Female' => '女性',
            'Male' => '男性',
          ],
          'table_column_headers' => [
            // 'size' => 'Clothing Size',
            'measurement' => '腰围(厘米)',//<!-- Waist (cm) -->
            'val' => '范围',//<!-- scope/range -->
          ],
          'miscText' => [
            'select' => '是的，我在这个范围内',
          ],
          'classicButtons' => [
            '1' => '范围 1',
            '2' => '范围 2',
            '3' => '范围 3',
          ],
          'ranges' => [
            'Female' => [
              'measurement-table-one' => [
                'waist_ranges' => [
                  '1' => [
                    // 'size' => '10 &mdash; 12',
                    'measurement' => '小于 88 厘米',
                    'postVal' => 'Less than 88 cm',
                  ],
                  '2' => [
                    // 'size' => '14 &mdash; 16',
                    'measurement' => '88至100厘米',
                    'postVal' => '88cm-100cm',
                  ],
                  '3' => [
                    // 'size' => '18+',
                    'measurement' => '超过 100 厘米',
                    'postVal' => 'More than 100cm',
                  ],
                ],
              ],
              'measurement-table-two' => [
                'waist_ranges' => [
                  '1' => [
                    'measurement' => '小于 80 厘米',
                    'postVal' => 'Less than 80cm',
                  ],
                  '2' => [
                    'measurement' => '80至90厘米',
                    'postVal' => '80-90cm',
                  ],
                  '3' => [
                    'measurement' => '超过 90 厘米',
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
                    'measurement' => '小于 102 厘米',
                    'postVal' => 'Less than 102 cm',
                  ],
                  '2' => [
                    // 'size' => 'L, XL',
                    'measurement' => '102至110厘米',
                    'postVal' => '102-110cm',
                  ],
                  '3' => [
                    // 'size' => 'XXL+',
                    'measurement' => '超过 110 厘米',
                    'postVal' => 'More than 110cm',
                  ],
                ],
              ],
              'measurement-table-two' => [
                'waist_ranges' => [
                  '1' => [
                    'measurement' => '小于 90 厘米',
                    'postVal' => 'Less than 90cm',
                  ],
                  '2' => [
                    'measurement' => '90至100厘米',
                    'postVal' => '90 - 100cm',
                  ],
                  '3' => [
                    'measurement' => '超过 100 厘米',
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
          'label' => '您是否被诊断出患有以下一种或多种疾病？',
          'multiselect' => true,
          'options' => [
            '' => [
              'label' => '无下列情况',
              'female_only' => false,
              'is_positive' => false,
            ],
            'History_of_CVD__c' => [
              'label' => '心脏病或中风（如心脏病发作、心律失常、心绞痛、心力衰竭）',
              'female_only' => false,
              'is_positive' => true,
            ],
            'Had_GDM__c' => [
              'label' => '妊娠期糖尿病',
              'female_only' => true,
              'is_positive' => true,
            ],
            'Moderate_Severe_Chronic_Kidney_Disease__c' => [
              'label' => '慢性肾病',
              'female_only' => false,
              'is_positive' => true,
            ],
            'Systolic_BP_180mmHg_diastolic_BP_110__c' => [
              'label' => '高血压',
              'female_only' => false,
              'is_positive' => true,
            ],
            'Impaired_glucose_tolerance__c' => [
              'label' => '糖尿病前期',
              'female_only' => false,
              'is_positive' => true,
            ],
            'Polycystic_ovary_syndrome__c' => [
              'label' => '多囊卵巢综合征',
              'female_only' => true,
              'is_positive' => true,
            ],
            'Serum_total_cholesterol_7_5mmol_L__c' => [
              'label' => '高胆固醇',
              'female_only' => false,
              'is_positive' => true,
            ],
          ],
        ],
      ],
    ],
  ],
  'confirm' => '计算我的风险',
  'riskLevels' => [
    'low' => [
      'desc' => '0 - 5',
      't' => '低级',
      'statistic' => '大约 <span class="fg-primary wt-sb"> 每 14 人中就有 1 人 </span> 会在 5 年内患上 糖尿病.',
    ],
    'medium' => [
      'desc' => '6 - 11',
      't' => '中级',
      'statistic' => '大约 <span class="fg-primary wt-sb">每 7 人中就有 1 人</span> 会在 5 年内患上 糖尿病.',
    ],
    'high' => [
      'desc' => '12 +',
      't' => '高级',
      'statistic' => '大约 <span class="fg-primary wt-sb">每 3 人中就有 1 人</span> 会在五年内患上 糖尿病.',
    ],
  ],
  'results' => [ /* modal-health-check-chinese-simplified :362 */
    'oldLayout' => [
      'yourScoreIs' => '您的分数是',
      'yourRiskLevelIs' => '您的风险等级为',
      'youMayBeEligible' => '您可能有资格参加<em>Life!</em>计划.',
      'contactUsAboutJoining' => '联系我们参加计划', // risk-high-or-diagnosis
      // 'statistic' => '大约 <span class="fg-primary wt-sb"> 每 _NUMBER_OF_PEOPLE_ 人中就有 1 人 </span> 会在五年内患上 糖尿病.',
      'lifeHasHelpedOver' => '<em>Life!</em> 已帮助超过 75000 名维多利亚州 居民改善饮食习惯、身体活动和压力管理.',
      'youAreNotEligible' => '抱歉，您没有符合参加 <em>Life!</em> 计划的要求',
      'contactOptions' => [ // risk-high-or-diagnosis
        'button' => '联系我们参加计划',
        'orCall' => '或者致电<a href="tel:137475">13 74 75</a>与我们联系',
        // if you required an interpreter... 如果您需要口译员, 请拨打<a href="tel:131450">131 450</a>并向他们提供我们的电话号码13 74 75。
        'flexDirection' => 'col',
      ],
    ],
    // 'yourScoreIs' => '您的分数是',
    // 'headerEligibility' => [
    //   'risk-high' => [
    //     'heading' => '您可能有资格参加<em>Life!</em>计划.', // you may be eligible for the Life! program
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
      'heading' => '还有一步就大功告成了', // You\'re only one step away
      'subheading' => '请提交您的详细资料, 我们将很快与您联系.', // Submit your details and we will get back to you shortly.
    ],
    'fields' => [
      'first_name' => [
        'label' => '名',
      ],
      'last_name' => [
        'label' => '姓',
      ],
      'phone' => [
        'label' => '电话',
        'type' => 'tel',
        'title' => '10位數字',
        'validation_macro' => 'phone',
      ],
      'postcode' => [
        'label' => '邮政编码',
        'title' => '4位数字',
        'validation_macro' => 'postcode',
      ],
      'email' => [
        'label' => '电邮地址',
        'type' => 'email',
      ],
      'heard_about_via' => [
        'label' => '您是如何得知我们的？',
        'placeholder' =>'请选择',
        'type' => 'select',
        'options' => [
            '' => '请选择',
            'Social Media' => '社交媒体',
            'Community Group' => '社区团体',
            'Event' => '活动',
            'Health Professional' => '卫生专业人员',
            'GP' => '全科医生',
            'Word of mouth' => '口口相传',
            'Workplace' => '工作场所',
            'Other' => '其他方式',
        ],
      ],
      'speaks_english' => [
        'label' => '您可以用英语交流吗？',
        'type' => 'radios',
        'options' => [
            'Yes' => '是的',
            'No' => '不',
        ],
      ],
      'consent' => [
        'label' => '本人同意 Diabetes Victoria 为 <em>Life!</em> 计划 工作的人员就 <em>Life!</em> 计划 与我联系, 并收集本人的个人资料, 用于必要的 <em>Life!</em> 计划 行政管理操作.',
        'validation' => [
          'message_required' => '要继续注册，请同意',
        ],
      ],
    ],
    'return_to_site_button_text' => '返回网站',
    'submit_button_text' => '提交详细资料',
  ],
];