<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage life
 * @since life 1.0
 */

// Global header
get_header(null, ['bodyClass' => 'template-404']);

echoTemplate('hero-banner/hero-banner-sml', ['title' => 'Page Not Found']);

echoTemplate('widget/breadcrumbs', ['title' => 'Page Not Found']);

get_template_part('partials/section', 'not-found');

// Global footer
get_footer();
