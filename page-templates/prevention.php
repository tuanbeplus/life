<?php
/**
 * Template Name: Prevention
 */

setup_postdata($post);

get_header(null, ['bodyClass' => 'template-prevention']);

echoTemplate('hero-banner/hero-banner-sml');

echoTemplate('widget/breadcrumbs');

echoTemplate('section-content-icon-grid', [
  'introContent' => get_the_content(),
  'gridItems' => get_field('icon_calls_to_action'),
  'gridSupporting' => get_field('icon_cta_supporting_text'),
]);

if ($tabSections = get_field('tab_sections')) {
  echoTemplate('section-tabbed-content', [
    'tabSections' => $tabSections,
    'heading' => 'Discover steps to prevention',
    // 'tabHeading' => get_field('tab_section_heading'),
  ]);
}

get_footer();
