<?php
/**
 * Template Name: Service Details
 */

// Sigh
setup_postdata($post);

// Global header
get_header(null, ['bodyClass' => 'template-service-display']);

echoTemplate('hero-banner/hero-banner-sml');

echoTemplate('widget/breadcrumbs');

get_template_part('partials/section', 'service-details');

// Global footer
get_footer();
