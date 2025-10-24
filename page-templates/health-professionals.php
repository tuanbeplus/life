<?php
/**
 * Template Name: Health Professionals
 */

setup_postdata($post);

get_header(null, ['bodyClass' => 'template-health-professionals']);

echoTemplate('hero-banner/hero-banner-sml');

echoTemplate('widget/breadcrumbs');

if ($sectionLevel2Content = get_the_content()) {
  echoTemplate('section-level2', [
    'content' => $sectionLevel2Content,
    'sidebarBlocks' => get_field('sidebar_blocks'),
    'cssClass' => '-pb-90',
  ]);
}

if ($sections = get_field('hp_sections')) {
  echoTemplate('section-health-professionals', [
    'sections' => $sections,
  ]);
}

get_footer();
