
<section class="block-image-feature<?= $content ? ' has-message' : '' ?>">
  <div class="center-frame">
    <div class="container">
      <?php if ($headline): ?>
        <h2 class="lh-std fg-white"><?= apply_filters('the_brand', esc_html($headline)) ?></h2>
      <?php else: ?>
        <h2 class="lh-std fg-white">
          <a href="<?= get_the_permalink($ctaLink->ID) ?>">
            <?= apply_filters('the_brand', esc_html($ctaLabel)) ?>
          </a>
        </h2>
      <?php endif ?>
      <?php if ($content): ?>
        <div class="message font-mdish wt-sb lh-std fg-white">
          <p><?= apply_filters('the_brand', esc_html($content)) ?></p>
        </div>
      <?php endif ?>
    </div>
  </div>
  <div class="background tinted tint-black even-darker tint-left">
    <img
      src="<?= $background['url'] ?>"
      class="cover mobile-hidden" alt="" role="presentation"
      loading="lazy"
    />
    <?php if (false && $backgroundMobile): ?>
      <img
        src="<?= $backgroundMobile['url'] ?>"
        class="cover mobile-only block" alt="" role="presentation"
        loading="lazy"
      />
    <?php endif ?>
  </div>
</section>
