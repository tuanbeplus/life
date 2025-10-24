<?php
/**
 * Template Name: Learn About
 */

setup_postdata($post);

get_header(null, ['bodyClass' => 'template-how-it-works']);

echoTemplate('hero-banner/hero-banner-sml');

echoTemplate('widget/breadcrumbs');

if ($sectionLevel2Content = get_the_content()) {
  echoTemplate('section-level2', [
    'content' => $sectionLevel2Content,
    'sidebarBlocks' => get_field('sidebar_blocks'),
    // 'cssClass' => '-pb-90',
  ]);
}
echoTemplate('sml-tabs-over-giant', [
  'heading' => get_field('tabs_heading'),
  'tabs' => get_field('tabs'),
]);

get_footer();
