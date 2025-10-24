<?php
return [
  'general' => [
    'heading' => 'Hãy bắt đầu và kiểm tra tiêu chuẩn hội đủ điều kiện của tôi',
    'subHeading' => null,
  ],
  'steps' => [
    'step1' => [
      'title' => 'Bước 1',
      'questions' => [
        'gender' => [
          'number' => 'Q1',
          'label' => 'Giới tính của quý vị là gì?',
          'options' => [
            'Male' => 'Nam',
            'Female' => 'Nữ',
          ],
        ],
        'age' => [
          'number' => 'Q2',
          'label' => 'Quý vị bao nhiêu tuổi?',
          'options' => [
            'Under 35 years' => 'Dưới 35 tuổi',
            '35 - 44 years' => '35-44 nuổi',
            '45 - 54 years' => '45-54 tuổi',
            '55 - 64 years' => '55-64 tuổi',
            '65 years or over' => 'Trên 65 tuổi',
          ],
        ],
        'background' => [
          'number' => 'Q3',
          'label' => 'Có phải quý vị là người gốc Thổ dân, dân đảo Torres Strait, Thái Bình Dương hay Maori hay không?',
          'options' => [
            'Yes' => 'Có',
            'No' => 'Không',
          ],
        ],
        'birthplace' => [
          'number' => 'Q4',
          'label' => 'Quý vị sinh ra ở đâu?',
          'options' => [
            'Australia' => 'Úc',
            'Asia (including the Indian sub-continent)' => 'Châu Á (kể cả tiểu lục địa Ấn Độ)',
            'Southern Europe' => 'Nam Âu',
            'Middle East' => 'Trung Đông',
            'North Africa' => 'Bắc Phi',
            'Other' => 'Nơi khác',
          ],
        ],
        'diabetes' => [
          'number' => 'Q5',
          'label' => 'Có cha hay mẹ, hoặc bất kỳ anh chị em nào của quý vị đã nhận được chẩn đoán bị tiểu đường (loại 1 hoặc loại 2) hay không?',
          'options' => [
            'Yes' => 'Có',
            'No' => 'Không',
          ],
        ],
        'pregnancy' => [
          'number' => 'Q6',
          'label' => 'Quý vị có từng bị phát hiện lượng đường trong máu cao, chẳng hạn như khi khám sức khỏe, khi bị bệnh/ốm, khi mang thai hay không?',
          'options' => [
            'Yes' => 'Có',
            'No' => 'Không',
          ],
        ],
        'blood_pressure_medication' => [
          'number' => 'Q7',
          'label' => 'Hiện tại quý vị có đang uống thuốc trị cao huyết áp hay không?',
          'options' => [
            'Yes' => 'Có',
            'No' => 'Không',
          ],
        ],
        'smoker' => [
          'number' => 'Q8',
          'label' => 'Quý vị có hút thuốc mỗi ngày hay không?',
          'options' => [
            'Yes' => 'Có, tôi có hút thuốc',
            'No' => 'Không, tôi không hút thuốc',
          ],
        ],
        'vegetables' => [
          'number' => 'Q9',
          'label' => 'Quý vị ăn rau hoặc trái cây thường xuyên như thế nào?',
          'options' => [
            'Everyday' => 'Mỗi ngày',
            'Not everyday' => 'Không phải mỗi ngày',
          ],
        ],
        'exercise' => [
          'number' => 'Q10',
          'label' => 'Trung bình, quý vị có vận động cơ thể ít nhất 2.5 giờ mỗi tuần (ví dụ: nửa giờ trong từ 5 ngày trở lên) hay không?',
          'options' => [
            'Yes' => 'Có, tôi có',
            'No' => 'Không, tôi không',
          ],
        ],
      ],
    ],
    'step2' => [
      'title' => 'Bước 2',
      'questions' => [
        'waist_range' => [
          'number' => 'Q11',
          'label' => 'Số đo vòng eo của quý vị là bao nhiêu?',
          'label_with_size' => 'Số đo vòng eo của quý vị là bao nhiêu?',
          'measurement_tables' => [
            'measurement-table-one' => [
              'heading_suffix' => '',
            ],
            'measurement-table-two' => [
              'heading_suffix' => '(gốc châu Á, Thổ dân hoặc dân đảo Torres Strait)',
            ],
          ],
          'genders' => [
            'Female' => 'Phụ nữ',
            'Male' => 'Đàn ông',
          ],
          'table_column_headers' => [
            'size' => 'Kích cỡ quần áo',
            'measurement' => 'Vòng eo (cm)',
            'val' => 'Phạm vi',
          ],
          'miscText' => [
            'select' => 'Tôi ở trong phạm vi này',
          ],
          'classicButtons' => [
            '1' => 'Phạm vi 1',
            '2' => 'Phạm vi 2',
            '3' => 'Phạm vi 3',
          ],
          'ranges' => [
            'Female' => [
              'measurement-table-one' => [
                'waist_ranges' => [
                  '1' => [
                    'size' => '10 &mdash; 12',
                    'measurement' => 'Dưới 88cm',
                    'postVal' => 'Less than 88 cm',
                  ],
                  '2' => [
                    'size' => '14 &mdash; 16',
                    'measurement' => '88 - 100cm',
                    'postVal' => '88cm-100cm',
                  ],
                  '3' => [
                    'size' => '18+',
                    'measurement' => 'Hơn 100cm',
                    'postVal' => 'More than 100cm',
                  ],
                ],
              ],
              'measurement-table-two' => [
                'waist_ranges' => [
                  '1' => [
                    'measurement' => 'Dưới 80cm',
                    'postVal' => 'Less than 80cm',
                  ],
                  '2' => [
                    'measurement' => '80 - 90cm',
                    'postVal' => '80-90cm',
                  ],
                  '3' => [
                    'measurement' => 'Hơn 90cm',
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
                    'measurement' => 'Dưới 102cm',
                    'postVal' => 'Less than 102 cm',
                  ],
                  '2' => [
                    'size' => 'L, XL',
                    'measurement' => '102cm - 110cm',
                    'postVal' => '102-110cm',
                  ],
                  '3' => [
                    'size' => 'XXL+',
                    'measurement' => 'Hơn 110cm',
                    'postVal' => 'More than 110cm',
                  ],
                ],
              ],
              'measurement-table-two' => [
                'waist_ranges' => [
                  '1' => [
                    'measurement' => 'Dưới 90cm',
                    'postVal' => 'Less than 90cm',
                  ],
                  '2' => [
                    'measurement' => '90cm - 100cm',
                    'postVal' => '90 - 100cm',
                  ],
                  '3' => [
                    'measurement' => 'Hơn 100cm',
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
      'title' => 'Bước 3',
      'questions' => [
        'diagnosis' => [
          'number' => 'Q12',
          // 'label' => 'Have you been diagnosed with one or more of the following?',
          'label' => 'Bạn đã từng được chẩn đoán mắc một hoặc nhiều bệnh sau đây không?',
          'multiselect' => true,
          'options' => [
            '' => [
              'label' => 'Không bệnh nào dưới đây',
              'female_only' => false,
              'is_positive' => false,
            ],
            'History_of_CVD__c' => [
              'label' => 'Bệnh tim hoặc đột quỵ (ví dụ như nhồi máu cơ tim, rối loạn nhịp tim, đau thắt ngực, suy tim)',
              'female_only' => false,
              'is_positive' => true,
            ],
            'Had_GDM__c' => [
              'label' => 'Tiểu đường thai kỳ',
              'female_only' => true,
              'is_positive' => true,
            ],
            'Moderate_Severe_Chronic_Kidney_Disease__c' => [
              'label' => 'Bệnh thận mãn tính',
              'female_only' => false,
              'is_positive' => true,
            ],
            'Systolic_BP_180mmHg_diastolic_BP_110__c' => [
              'label' => 'Huyết áp cao',
              'female_only' => false,
              'is_positive' => true,
            ],
            'Impaired_glucose_tolerance__c' => [
              'label' => 'Tiền tiểu đường',
              'female_only' => false,
              'is_positive' => true,
            ],
            'Polycystic_ovary_syndrome__c' => [
              'label' => 'Hội chứng buồng trứng đa nang',
              'female_only' => true,
              'is_positive' => true,
            ],
            'Serum_total_cholesterol_7_5mmol_L__c' => [
              'label' => 'Cholesterol cao',
              'female_only' => false,
              'is_positive' => true,
            ],
          ],
        ],
      ],
    ],
  ],
  'confirm' => 'Tính toán Nguy cơ của tôi',
  'riskLevels' => [
    'low' => [
      'desc' => '0 - 5',
      't' => 'Thấp',
      'statistic' => 'Khoảng <span class="fg-primary wt-sb">1 người trong 14</span> người sẽ bị tiểu đường trong vòng 5 năm.',
    ],
    'medium' => [
      'desc' => '6 - 11',
      't' => 'Trung bình',
      'statistic' => 'Cứ <span class="fg-primary wt-sb">7 người thì có khoảng 1</span> người bị tiểu đường trong vòng 5 năm.',
    ],
    'high' => [
      'desc' => '12 +',
      't' => 'Cao',
      'statistic' => 'Khoảng <span class="fg-primary wt-sb">1 trong 3</span> người sẽ bị tiểu đường trong vòng 5 năm.',
    ],
  ],
  'results' => [ /* modal-health-check-vietnamese :367 */
    'oldLayout' => [
      'yourScoreIs' => 'Số điểm của quý vị là',
      'yourRiskLevelIs' => 'và mức độ nguy cơ của quý vị',
      'youMayBeEligible' => 'Quý vị có thể hội đủ điều kiện tham gia Chương trình <em>Life!</em> Program.', // div.eligibility.formatted.risk-high
      'contactUsAboutJoining' => 'Liên lạc với chúng tôi về việc tham gia', // risk-high-or-diagnosis
      // 'statistic' => 'Khoảng <span class="fg-primary wt-sb">1 người trong _NUMBER_OF_PEOPLE_</span> người sẽ bị tiểu đường trong vòng 5 năm.',
      'lifeHasHelpedOver' => '<em>Life!</em> Đã giúp hơn 75 000 người dân Victoria cải thiện thói quen ăn uống, vận động cơ thể và đối phó với tình trạng căng thẳng.',
      'youAreNotEligible' => 'Xin lỗi, quý vị không hội đủ điều kiện để tham gia chương trình <em>Life!</em> Program.',
      'contactOptions' => [ // risk-high-or-diagnosis
        'button' => 'Liên lạc với nhóm của chúng tôi',
        'orCall' => 'Hoặc gọi cho nhóm của chúng tôi qua số <a href="tel:137475">13 74 75</a>',
        'flexDirection' => 'row',
      ],
    ],
    // 'yourScoreIs' => 'Số điểm của quý vị là',
    // 'headerEligibility' => [
    //   'risk-high' => [
    //     'heading' => 'Quý vị có thể hội đủ điều kiện tham gia Chương trình <em>Life!</em>.', // you may be eligible for the Life! program
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
      'heading' => 'Quý vị chỉ còn một bước nữa thôi', // You\'re only one step away
      'subheading' => 'Hãy gửi chi tiết của quý vị và chúng tôi sẽ liên lạc lại với quý vị sau đó không lâu.', // Submit your details and we will get back to you shortly.
    ],
    'fields' => [
      'first_name' => [
        'label' => 'Tên',
      ],
      'last_name' => [
        'label' => 'Họ',
      ],
      'phone' => [
        'label' => 'Điện thoại',
        'type' => 'tel',
        'title' => 'Nhập số điện thoại gồm 10 số không cách quãng',
        'validation_macro' => 'phone',
      ],
      'postcode' => [
        'label' => 'mã bưu điện',
        'title' => 'Nhập mã bưu điện gồm 4 số không có dấu cách',
        'validation_macro' => 'postcode',
      ],
      'email' => [
        'label' => 'Email',
        'type' => 'email',
      ],
      'heard_about_via' => [
        'label' => 'Làm sao quý vị biết về chúng tôi?',
        'placeholder' => 'Vui lòng chọn...',
        'type' => 'select',
        'options' => [
          '' => 'Vui lòng chọn...',
          'Social Media' => 'Truyền thông xã hội',
          'Community Group' => 'Nhóm cộng đồng',
          'Event' => 'Sự kiện',
          'Health Professional' => 'Chuyên viên y tế',
          'GP' => 'Bác sĩ gia đình (GP)',
          'Word of mouth' => 'Lời truyền miệng',
          'Workplace' => 'Nơi làm việc',
          'Other' => 'khác',
        ],
      ],
      'speaks_english' => [
        'label' => 'Bạn có thoải mái nói chuyện bằng Tiếng Anh không? ',
        'type' => 'radios',
        'options' => [
          'Yes' => 'Có',
          'No' => 'Không',
        ],
        // 'validation' => [
        //   'message_required' => 'Vui lòng cho biết bạn có cần thông dịch viên hay không',
        // ],
      ],
      'consent' => [
        'label' => 'Tôi đồng ý cho nhân viên của Diabetes Victoria trong chương trình <em>Life!</em> Program liên lạc với tôi về chương trình <em>Life!</em> Program và cho phép thu thập mọi thông tin cá nhân để sử dụng cho các công việc hành chính liên quan đến chương trình <em>Life!</em> Program.',
        'validation' => [
          'message_required' => 'Để tiếp tục đăng ký, vui lòng đồng ý',
        ],
      ],
    ],
    'return_to_site_button_text' => 'Quay trở lại trang mạng.',
    'submit_button_text' => 'Gửi chi tiết',
  ],
];