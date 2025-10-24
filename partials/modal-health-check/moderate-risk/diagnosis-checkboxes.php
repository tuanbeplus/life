<div
    class="question -no-num"
    data-moderate-risk-section="diagnosis"
>
  <div class="form-group">
    <div class="label"><?= $heading ?></div>
    <?php $diagnoses = [
      [
        'label' => [
          'en' => 'None of the below',
          'vi' => 'Không bệnh nào dưới đây',
          'zh-Hant' => '無下列情況',
          'zh-Hans' => '无下列情况',
          'ar' => 'ولا واحدة مما يلي',
        ],
        'null_diagnosis' => true,
      ],
      [
        'label' => [
          'en' => 'Heart disease or stroke (e.g. heart attack, arrythmia, angina, heart failure)',
          'vi' => 'Bệnh tim hoặc đột quỵ (ví dụ như nhồi máu cơ tim, rối loạn nhịp tim, đau thắt ngực, suy tim)',
          'zh-Hant' => '心臟病或中風（如心臟病髮作、心律失常、心絞痛、心力衰竭）',
          'zh-Hans' => '心脏病或中风（如心脏病发作、心律失常、心绞痛、心力衰竭）',
          'ar' => 'مرض القلب أو السكتة الدماغية (على سبيل المثال النوبة القلبية، عدم انتظام دقات القلب، الذبحة الصدرية، قصور القلب)',
        ],
        'salesforcename' => 'History_of_CVD__c',
      ],
      [
        'label' => [
          'en' => 'Gestational Diabetes',
          'vi' => 'Tiểu đường thai kỳ',
          'zh-Hant' => '妊娠期糖尿病',
          'zh-Hans' => '妊娠期糖尿病',
          'ar' => 'سكري الحمل',
        ],
        'salesforcename' => 'Had_GDM__c',
        'female_only' => true,
      ],
      [
        'label' => [
          'en' => 'Chronic kidney disease',
          'vi' => 'Bệnh thận mãn tính',
          'zh-Hant' => '慢性腎病',
          'zh-Hans' => '慢性肾病',
          'ar' => 'فشل كلوي مزمن',
        ],
        'salesforcename' => 'Moderate_Severe_Chronic_Kidney_Disease__c',
      ],
      [
        'label' => [
          'en' => 'High blood pressure',
          'vi' => 'Huyết áp cao',
          'zh-Hant' => '高血壓',
          'zh-Hans' => '高血压',
          'ar' => 'ضغط دم مرتفع',
        ],
        'salesforcename' => 'Systolic_BP_180mmHg_diastolic_BP_110__c',
      ],
      [
        'label' => [
          'en' => 'Prediabetes',
          'vi' => 'Tiền tiểu đường',
          'zh-Hant' => '糖尿病前期',
          'zh-Hans' => '糖尿病前期',
          'ar' => 'مقدمات السكري',
        ],
        'salesforcename' => 'Impaired_glucose_tolerance__c',
      ],
      [
        'label' => [
          'en' => 'Polycystic ovarian syndrome',
          'vi' => 'Hội chứng buồng trứng đa nang',
          'zh-Hant' => '多囊卵巢綜合徵',
          'zh-Hans' => '多囊卵巢综合征',
          'ar' => 'متلازمة المبيض المتعدد الكيسات',
        ],
        'salesforcename' => 'Polycystic_ovary_syndrome__c',
        'female_only' => true,
      ],
      [
        'label' => [
          'en' => 'High cholesterol',
          'vi' => 'Cholesterol cao',
          'zh-Hant' => '高膽固醇',
          'zh-Hans' => '高胆固醇',
          'ar' => 'كولسترول مرتفع',
        ],
        'salesforcename' => 'Serum_total_cholesterol_7_5mmol_L__c',
      ],
    ] ?>
    <div class="checkbox-lines diagnosis-checkboxes">
      <?php foreach ($diagnoses as $i => $diagnosis): ?>
        <?php
          $classes = [];
          if ($diagnosis['female_only'] ?? false) {
            $classes[] = 'female-only';
          }
          if ($diagnosis['null_diagnosis'] ?? false) {
            $classes[] = '-null-diagnosis';
          } else {
            $classes[] = '-is-diagnosis';
          }
        ?>
        <label
          <?= data_attr('diagnosis', $diagnosis) ?>
          class="<?= implode(' ', $classes) ?>"
        >
          <input
            type="checkbox"
            name="diagnosis-<?= $i ?>"
            value="Yes"
          />
          <span><?= $diagnosis['label'][$lang] ?></span>
        </label>
      <?php endforeach ?>
    </div>
  </div>
</div>
