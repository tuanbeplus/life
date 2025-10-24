<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage life
 * @since life 1.0
 */

setup_postdata($post);

get_header(null, ['no_hero' => true, 'bodyClass' => 'template-page']);

echoTemplate('hero-banner/hero-banner-sml');

echoTemplate('widget/breadcrumbs');

$sectionLevel2Content = get_the_content();
echoTemplate('section-level2', [
  'content' => $sectionLevel2Content,
  'sidebarBlocks' => get_field('sidebar_blocks'),
  'cssClass' => '-pb-90',
]);

get_template_part('partials/block', 'register-interest');

if ($testimonials = get_field('testimonials')) {
  echoTemplate('testimonials/block-testimonials', [
    'testimonials' => $testimonials,
  ]);
}

if ($ctas = get_field('icon_calls_to_action')) {
  echoTemplate('block-cta-strip', [
    'ctas' => $ctas,
    'supporting' => get_field('icon_cta_supporting_text'),
  ]);
}

$imageSubFeatureHeadline = get_field('image_subfeature_headline');
$imageSubFeatureCtaLink = get_field('image_subfeature_cta_link');
if (
  ($imageSubFeatureHeadline || $imageSubFeatureCtaLink)
  && $background = get_field('image_subfeature_background')
) {
  echoTemplate('block-image-feature', [
    'headline' => $imageSubFeatureHeadline,
    'ctaLink' => $imageSubFeatureCtaLink ?? false,
    'ctaLabel' => get_field('image_subfeature_cta_label'),
    'background' => $background,
    'backgroundMobile' => get_field('image_subfeature_background_mobile'),
    'content' => get_field('image_subfeature_content'),
  ]);
}

get_template_part('partials/block', 'panel-strip');

get_template_part('partials/block', 'related-links');

get_footer();
