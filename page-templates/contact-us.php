<?php
/**
 * Template Name: Contact Us
 */

setup_postdata($post);
  
get_header(null, ['bodyClass' => 'template-contact-us']);

echoTemplate('hero-banner/hero-banner-sml');

echoTemplate('widget/breadcrumbs');

echoTemplate('section-contact-us');

get_footer();
