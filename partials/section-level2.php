<?php
$cssClasses = [];
if ($cssClass ?? false) {
  $cssClasses[] = $cssClass;
}
if (!$sidebarBlocks) {
  $cssClasses[] = '-no-sidebar';
}
?>
<section
  class="section-level2 content bg-white <?= implode(' ', $cssClasses) ?>"
>
  <div class="center-frame">
    <div class="content-wrapper">
      <div class="formatted main-content page-<?= get_the_ID() ?>">
        <?= apply_filters('the_content', $content) ?>
      </div>
      <?php if ($sidebarBlocks): ?>
        <div class="content-sidebar">
          <box-slideshow
            :slides="<?= vueProp($sidebarBlocks, fn($block) => [
              'color' => $block['colour'],
              'header' => apply_filters('the_brand', $block['header']),
              'content' => $block['content'] ? apply_filters('the_content', $block['content']) : null,
            ]) ?>"
          ></box-slideshow>
        </div>
      <?php endif ?>
    </div>
  </div>
</section>
