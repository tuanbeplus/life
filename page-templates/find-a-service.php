<?php
/**
 * Template Name: Location Listing
 */

setup_postdata($post);

// Global header
get_header(null, ['bodyClass' => 'template-find-a-service']);

echoTemplate('hero-banner/hero-banner-sml');

echoTemplate('widget/breadcrumbs');

if ($sectionLevel2Content = get_the_content()) {
  echoTemplate('section-level2', [
    'content' => $sectionLevel2Content,
    'sidebarBlocks' => get_field('sidebar_blocks'),
  ]);
}

get_template_part('partials/section', 'service-locator');

// Global footer
get_footer();
