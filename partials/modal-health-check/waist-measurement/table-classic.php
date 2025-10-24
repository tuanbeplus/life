<?php $has_clothing_size = isset($waist_ranges['1']['size']) ?>
<table class="mobile-hidden <?= $css_class ?>">
  <thead>
    <tr>
      <th><?= $table_column_headers['val'] ?></th>
      <th>1</th>
      <th>2</th>
      <th>3</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($has_clothing_size): ?>
      <tr>
        <td><?= $table_column_headers['size'] ?></td>
        <?php foreach ($waist_ranges as $val => $range): ?>
          <td><?= $range['size'] ?></td>
        <?php endforeach ?>
      </tr>
    <?php endif ?>
    <tr>
      <td><?= $table_column_headers['measurement'] ?></td>
      <?php foreach ($waist_ranges as $val => $range): ?>
        <td><?= $range['measurement'] ?></td>
      <?php endforeach ?>
    </tr>
  </tbody>
</table>
<table class="mobile-only table <?= $css_class ?>">
  <tbody>
    <?php if ($has_clothing_size): ?>
      <tr>
        <th><?= $table_column_headers['size'] ?></th>
        <th><?= $table_column_headers['val'] ?></th>
      </tr>
      <?php foreach ($waist_ranges as $val => $range): ?>
        <tr>
          <td><?= $range['size'] ?></td>
          <td><?= $val ?></td>
        </tr>
      <?php endforeach ?>
    <?php endif ?>
    <tr>
      <th><?= $table_column_headers['measurement'] ?></th>
      <th><?= $table_column_headers['val'] ?></th>
    </tr>
    <?php foreach ($waist_ranges as $val => $range): ?>
      <tr>
        <td><?= $range['measurement'] ?></td>
        <td><?= $val ?></td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>
