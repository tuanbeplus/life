<?php
$conf = include get_template_directory().'/inc/waist-measurements/'.$lang.'.php';

$textDirectionRtl = $conf['textDirectionRtl'] ?? false;

$tableStyle = 'classic'; // 'classic' or 'greyscale'
$withHeading = false;

foreach ($conf['genders'] as $gender_class => $gender_heading): ?>
  <div class="tables-waist-range-for-gender gender-details <?= $gender_class ?> <?= $textDirectionRtl ? 'text-direction-rtl' : '-ltr' ?>">
    <?php foreach($conf['measurement_tables'] as $measurement_table_class => $measurement_table): ?>
      <?php if ($withHeading): ?>
        <h5 class="wt-md font-middling <?= $measurement_table_class ?>">
          <?= $gender_heading . ' ' . $measurement_table['heading_suffix'] ?>
        </h5>
      <?php endif ?>
      <?= incTemplate('modal-health-check/waist-measurement/table-'.$tableStyle, [
        'css_class' => $measurement_table_class,
        'table_column_headers' => $conf['table_column_headers'],
        'waist_ranges' => $conf['ranges'][$gender_class][$measurement_table_class]['waist_ranges'],
        'miscText' => $conf['miscText'],
      ]) ?>
    <?php endforeach ?>
  </div>
<?php endforeach ?>
<?php if ($tableStyle === 'classic'): ?>
  <div class="block-radio-group thirds">
    <?php foreach ($conf['classicButtons'] as $val => $text): ?>
      <div class="block-radio">
        <label class="option label">
          <input
            type="radio"
            name="waist_range"
            value="<?= $val ?>"
            <?php if ($val == '1'): // needs to be here for checkSectionValid in frontend.js ?>
              required
            <?php endif ?>
          >
            <span class="option-label">
              <span><?= $text ?></span>
            </span>
          </label>
      </div>
    <?php endforeach ?>
  </div>
<?php endif ?>