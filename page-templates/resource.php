<?php
/**
 * Template Name: Resource
 */

// Sigh
setup_postdata($post);

// Global header
get_header(null, ['bodyClass' => 'template-resource']);

echoTemplate('hero-banner/hero-banner-sml');

echoTemplate('widget/breadcrumbs');

get_template_part('partials/section', 'resource');

get_template_part('partials/block', 'related-articles');

get_template_part('partials/block', 'related-links');

// Global footer
get_footer();
