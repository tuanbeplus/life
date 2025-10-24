<?php
$chineseSimplified = get_field('lpo_content')['chinese_simplified'] ?? '';
$chineseTraditional = get_field('lpo_content')['chinese_traditional'] ?? '';
$content_image = get_field('lpo_content')['image'] ?? null;
$content_link = get_field('lpo_top_content')['link'] ?? null;
?>
<section class="triggered trigger-complete lpo-feature-content lpo__language-page lpo__language-feature-content featured-content bg-off-white curved-in<?= ($feature_image) ? ' has-image' : '' ?>" data-scroll-trigger>
  <div class="center-frame content-feature">
    <div class="content formatted">
      <?= apply_filters('the_content', $chineseSimplified) ?>
      <hr>
      <?= apply_filters('the_content', $chineseTraditional) ?>
    </div>
    <?php if ( $content_image ) { ?>
      <div class="image tighter of-bottom lpo__language-feature-content--wrapper">
        <div class="inner">
          <img src="<?= $content_image['url'] ?>" class="contain ia-bottom lpo-feature-content__image lpo__language-feature-content--image" alt="" role="presentation" />
        </div>
        <?php if ( $content_link ) { ?>
          <div class="cta-links">
            <ul>
              <li>
                <a href="<?= $content_link['target'] ?>" class="button circled-icon teal">
                  <span class="is-flex">
                    <span><?= $content_link['label'] ?></span>
                    <?= life_icon('chevron-right') ?>
                  </span>
                </a>
              </li>
            </ul>
          </div>
        <?php } ?>
      </div>
    <?php } ?>
  </div>
  <div class="curve v1"><?= life_svg('backgrounds/curve-01') ?></div>
</section>
