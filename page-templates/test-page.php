<?php
/**
 * Template Name: Form Test Page
 */

// Sigh
setup_postdata($post);
  
// Global header
get_header(null, ['bodyClass' => 'template-test-page']);

echoTemplate('hero-banner/hero-banner-sml');

echoTemplate('widget/breadcrumbs');

get_template_part('partials/section', 'test-page');

// Global footer
get_footer();
