<?php

setup_postdata($post);

get_header(null, ['no_hero' => true, 'bodyClass' => 'template-single']);

echoTemplate('hero-banner/hero-banner-sml');

echoTemplate('widget/breadcrumbs');

// todo - gestational form
// get_template_part('partials/modal', 'gestational-form');

echoTemplate('section-resource');

echoTemplate('block-related-articles');

echoTemplate('block-register-interest');

if ($testimonials = get_field('testimonials')) {
  echoTemplate('testimonials/block-testimonials', [
    'testimonials' => $testimonials,
  ]);
}

if ($ctas = get_field('icon_calls_to_action')) {
  echoTemplate('block-cta-strip', [
    'ctas' => $ctas,
    'supporting' => get_field('icon_cta_supporting_text'),
    'topCurve' => true,
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

echoTemplate('block-panel-strip');

echoTemplate('block-related-links');

get_footer();