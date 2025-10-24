<div class="table-waist-measurement -desktop">
  <?php $has_clothing_size = isset($waist_ranges['1']['size']) ?>
  <table class="greyscale-table -desktop <?= $css_class ?>">
    <thead>
      <tr>
        <?php if ($has_clothing_size): ?>
          <th class="-size"><?= $table_column_headers['size'] ?></th>
        <?php endif ?>
        <th class="-measurement"><?= $table_column_headers['measurement'] ?></th>
        <th class="-button">&nbsp;</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($waist_ranges as $val => $range): ?>
        <tr>
          <?php if ($has_clothing_size): ?>
            <td class="-size"><?= $range['size'] ?></td>
          <?php endif ?>
          <td class="-measurement"><?= $range['measurement'] ?></td>
          <td class="-button block-radio">
            <label class="option label">
              <input
                type="radio"
                name="waist_range"
                value="<?= $val ?>"
                <?php if ($val == '1'): // needs to be here for checkSectionValid in frontend.js. Also, keep as loose comparison ?>
                  required
                <?php endif ?>
              />
              <span class="option-label">
                <span><?= $miscText['select'] ?></span>
              </span>
            </label>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
<div class="table-waist-measurement -mobile">
  <?php foreach ($waist_ranges as $val => $range): ?>
    <table class="greyscale-table -mobile <?= $css_class ?>">
      <tbody>
        <?php if ($has_clothing_size): ?>
          <tr class="-size -key-val">
            <td><?= $table_column_headers['size'] ?></td>
            <td><?= $range['size'] ?></td>
          </tr>
          <?php endif ?>
          <tr class="-measurement -key-val">
            <td><?= $table_column_headers['measurement'] ?></td>
            <td><?= $range['measurement'] ?></td>
          </tr>
          <tr class="-button block-radio">
            <td colspan="2">
              <label class="option label">
                <input
                  type="radio"
                  name="waist_range"
                  value="<?= $val ?>"
                  <?php if ($val == '1'): // needs to be here for checkSectionValid in frontend.js. Also, keep as loose comparison ?>
                    required
                  <?php endif ?>
                />
                <span class="option-label">
                  <span><?= $miscText['select'] ?></span>
                </span>
              </label>
            </td>
          </tr>
      </tbody>
    </table>
  <?php endforeach ?>
</div>