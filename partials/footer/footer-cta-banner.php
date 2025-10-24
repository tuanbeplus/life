<section class="footer-cta-banner">
  <div class="-box">
    <h2><?= get_field('footer_cta_banner_title', 'option') ?></h2>
    <div class="-cols">
      <?= incTemplateShortcode('subscribe-form') ?>
      <div class="-col">
        <p><?= get_field('right_column_content', 'option') ?></p>
        <a class="button black" href="<?= get_field('right_column_button_url', 'option') ?>"><?= get_field('right_column_button_text', 'option') ?></a>
      </div>
    </div>
  </div>
  <div class="-overlay-image">
    <img
      src="<?php echo get_template_directory_uri(); ?>/images/backgrounds/newsletter.png"
      loading="lazy"
      decoding="async"
      alt="Happy people"
    />
  </div>
</section>