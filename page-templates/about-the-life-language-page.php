<?php
/**
 * Template Name: About the Life - Language Page
 */

setup_postdata($post);

get_header(null, ['bodyClass' => 'template-about-the-life-language-page']);

// get_template_part('partials/language-page/block', 'feature-hero');
echoTemplate('hero-banner/hero-banner-lrg', [
  'slides' => get_field('lpo_slides')['slides'] ?: [],
  'slideTextTemplate' => 'slide-text-double',
  'curveColor' => 'var(--colorOffWhite)',
]);

?>
<div class="background-grey">
  
<?php

echoTemplate('language-page/block-video-content-alt', [
  'title' => get_the_title(),
  'videos' => (get_field('lpo_videos')['videos'] ?? null) ?: [],
]);

$contentMultiBlocks = [];
if ($chineseSimplified = get_field('lpo_content')['chinese_simplified'] ?? null) {
  $contentMultiBlocks[] = $chineseSimplified;
}
if ($chineseTraditional = get_field('lpo_content')['chinese_traditional'] ?? null) {
  $contentMultiBlocks[] = $chineseTraditional;
}
// get_field('lpo_content')['image']['url'] ?? null
if (count($contentMultiBlocks) > 0) {
  echoTemplate('language-page/content-multi-block', [
    'blocks' => $contentMultiBlocks,
  ]);
}

?>
</div>
<?php
// Global footer
get_footer();
