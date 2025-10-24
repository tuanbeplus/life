<?php
$tabNav = array_map(fn($tab) => [
  'title' => apply_filters('the_brand', esc_html($tab['title'])),
  'slug' => slugify($tab['title']),
], $tabs);
// dd($tabs);
?>
<content-tabs
  class="-tablet-head-nav-grid -center-frame-head -sml-tabs-grey"
  :tabs="<?= vueProp($tabNav) ?>"
>
  <?php foreach ($tabs as $i => $tab): ?>
    <template #tab-<?= $i ?>>
      <?php
        if ($tab['type'] == 'list') {
          echoTemplate(
            'life-program-results/section-resource-items', [
              'resources' => $tab['content'] ?? [],
            ]
          );
        } elseif ($tab['type'] == 'textarea') {
          echoTemplate(
            'life-program-results/section-resource-content', [
              'content' => $tab['text_content'] ?? '',
            ]
          );
        }
      ?>
    </template>
  <?php endforeach ?>
</content-tabs>