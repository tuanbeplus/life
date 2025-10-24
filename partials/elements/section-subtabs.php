<?php
if (!$tabs) {
  $tabs = [];
}
$tabNav = array_map(fn($tab) => [
  'title' => apply_filters('the_brand', esc_html($tab['tab_heading'])),
  'slug' => slugify($tab['tab_heading']),
], $tabs);
?>
<content-tabs
  class="section-subtabs -tablet-head-nav-grid -center-frame-head"
  :tabs="<?= vueProp($tabNav) ?>"
  :mobile-accordion="true"
>
  <?php foreach ($tabs as $i => $tab): ?>
    <template #tab-<?= $i ?>>
      <?= incTemplate('elements/section-subtabs-tab', [
        'idx' => $i,
        'tab' => $tab,
      ]) ?>
    </template>
  <?php endforeach ?>
</content-tabs>
