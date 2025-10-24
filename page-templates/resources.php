<?php
/**
 * Template Name: Resources
 */

setup_postdata($post);

get_header(null, ['bodyClass' => 'template-resources']);

echoTemplate('hero-banner/hero-banner-sml');

echoTemplate('widget/breadcrumbs');

echoTemplate('blog/blog-index', [
  'headerContent' => get_the_content(),
  'articlesQuery' => new WP_Query([
    'post_type' => 'post',
    'post_status' => ['publish'],
    'order' => 'DESC',
    'orderby' => 'publish_date',
    'posts_per_page' => -1,
  ]),
]);

get_footer();
