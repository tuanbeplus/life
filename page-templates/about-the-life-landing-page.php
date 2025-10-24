<?php
/**
 * Template Name: About the Life - Landing Page
 */

setup_postdata($post);

get_header(null, ['bodyClass' => 'template-about-the-life-landing-page']);

$slides = get_field('lpo_slides') ?: [];
echoTemplate('hero-banner/hero-banner-lrg', [
  'slides' => $slides['slides'] ?? [],
  'slideTextTemplate' => 'slide-text-single',
  'curveColor' => 'var(--colorOffWhite)',
]);

?>
<div class="background-grey">
  <?php
  
  if ($featureContent = get_field('lpo_top_content')['content'] ?? null) {
    echoTemplate('section-feature-content', [
      'contentText' => $featureContent,
      'contentImage' => get_field('lpo_top_content')['image']['url'] ?? null,
      'centeredLink' => get_field('lpo_top_content')['link'] ?? null,
    ]);
  }

  if ($lowerContent = get_field('lower_content')) {
    echoTemplate('landing-page/section-lower-content', [
      'content' => $lowerContent,
    ]);
  }

  echoTemplate('section-grid-cols-3', [
    'footer' => ($benefits = get_field('benefits_section'))
      ? [
        'benefitsLowerText' => $benefits['benefits_lower_text'] ?? '',
      ]
      : false,
    'bgColor' => (!$lowerContent) ? 'bg-white' : 'bg-off-white',
  ]);
  echoTemplate('section-video-content');
  echoTemplate('testimonials/block-testimonials', [
    'testimonials' => life_global_testimonials(),
  ]);

  ?>
</div>
<?php

get_footer();
