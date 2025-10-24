<?php
/**
 * Template Name: Success Stories
 */

// Sigh
setup_postdata($post);

// Global header
get_header(null, ['bodyClass' => 'template-success-stories']);

echoTemplate('hero-banner/hero-banner-sml');

echoTemplate('widget/breadcrumbs');


echoTemplate('section-success-stories', [
  'curves' => [3, 2, 1],
  'sections' => get_field('sections'),
]);

// get_template_part('partials/section', 'audrisk-cta');

// Global footer
get_footer();
