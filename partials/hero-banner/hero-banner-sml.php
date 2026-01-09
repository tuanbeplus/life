<?php
$feature_image = get_the_post_thumbnail_url(null, 'level2-hero');
$feature_image_id = get_post_thumbnail_id();
$feature_image_alt = $feature_image_id ? get_post_meta($feature_image_id, '_wp_attachment_image_alt', true) : '';
// Fallback to page title if no alt text is set
if (empty($feature_image_alt)) {
  $feature_image_alt = get_the_title();
}
$sectionClass = '';
if ($feature_image) {
  $sectionClass .= ' -has-image';
}
if (is_singular( 'post' )) {
  $sectionClass .= ' -is-post';
} else {
  $sectionClass .= ' -not-post';
}
?>
<section class="hero-banner-sml <?= $sectionClass ?>">
  <?php if ($feature_image): ?>
    <div class="-bg tinted tint-black tint-bottom">
      <img
        src="<?= $feature_image ?>"
        alt="<?= esc_attr($feature_image_alt) ?>"
      >
    </div>
  <?php endif ?>
  <div class="-text">
    <div class="-bottom-pos">
      <?php
        /**
         * /learn-about-life/for-arabic-communities/
         * Change text direction to rtl
         */
        $headingClass = 'font-huge wt-sb lh-tight';
        if (get_the_ID() == 1926) {
          $headingClass .= ' text-direction-rtl';
        }
      ?>
      <h1 class="<?= $headingClass ?>">
        <?= apply_filters('the_brand', esc_html((isset($title) ?? $title) ? $title : get_the_title())) ?>
      </h1>
    </div>
  </div>
</section>
