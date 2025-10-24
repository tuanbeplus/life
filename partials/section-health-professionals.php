<?php

$tabsData = [];
foreach ($sections as $section) {
  $tab = [
    'heading' => ($section['heading'] ?? false) ? apply_filters('the_brand', $section['heading']) : null,
    'slug' => ($section['heading'] ?? false) ? slugify($section['heading']) : null,
    'description' => ($section['description'] ?? false) ? apply_filters('the_content', $section['description']) : null,
    'type' => $section['type'],
    '_smlTabs' => [],
    'resources' => [],
  ];
  if ($section['type'] === 'content') {
    if (is_array($section['children'])) {
      $tab['_smlTabs'] = array_map(fn($subTab) => [
        'title' => apply_filters('the_brand', $subTab['tab_heading']),
        'slug' => slugify($subTab['tab_heading']),
      ], $section['children']);
    } elseif (WP_DEBUG) {
      throw new Exception('Section type:content must have `children` array');
    }
  } elseif ($section['type'] === 'resources') {
    $resources = [];
    foreach (life_resource_entries() as $res) {
      $res['title'] = apply_filters('the_brand', $res['title']);
      $res['content'] = apply_filters('the_content', $res['content']);
      $resources[] = $res;
    }
    $tab['resources'] = $resources;
  }
  $tabsData[] = $tab;
}
// dd($tabsData);
?>

<giant-tabs-over-sml
  :tabs-data="<?= vueProp($tabsData) ?>"
  class="-sml-tabs-grey"
>
  <?php foreach ($sections as $i => $tab): ?>
    <?php foreach (($tab['children'] ?? []) as $subTabI => $subTab): ?>
      <template #tab-<?= $i ?>-smltab-<?= $subTabI ?>>
        <?= incTemplate('elements/section-subtabs-tab', [
          'idx' => $subTabI,
          'tab' => $subTab,
        ]) ?>
      </template>
    <?php endforeach ?>
  <?php endforeach ?>
</giant-tabs-over-sml>
