<?php

get_header(null, ['bodyClass' => 'template-front-page']);

echoTemplate('hero-banner/hero-banner-lrg', [
  'slides' => get_field('slides') ?: [],
  'slideTextTemplate' => 'slide-text-single',
  'curveColor' => 'var(--colorOffWhite)',
]);

echoTemplate('section-feature-content', [
  'contentText' => get_the_content(),
  'contentImage' => get_the_post_thumbnail_url(null, 'full-size'),
  'keyLinks' => get_field('key_links'),
]);

echoTemplate('block-colored-side-boxes');

echoTemplate('section-grid-cols-3', [
  'footer' => false,
]);

echoTemplate('section-video-content');

if ($ctas = get_field('icon_calls_to_action')) {
  echoTemplate('block-cta-strip', [
    'ctas' => $ctas,
    'supporting' => get_field('icon_cta_supporting_text'),
    'topCurve' => true,
  ]);
}

if ($steps = get_field('steps')) {
  echoTemplate('block-steps-feature', [
    'steps' => $steps,
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

if ($testimonials = life_global_testimonials() ?? null ?: []) {
  echoTemplate('testimonials/block-testimonials', [
    'testimonials' => $testimonials,
  ]);
}

get_footer();
