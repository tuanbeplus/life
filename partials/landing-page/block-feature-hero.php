<?php
$slides = get_field('lpo_slides')['slides'] ?? null;
$gestational = get_field('right_side_fixed_panel_for_health_checks') === 'no_panel_gestational';
$pcos = get_field('right_side_fixed_panel_for_health_checks') === 'no_panel_pcos';
?>
<?php if ($slides): ?>
  <section
    id="hero-feature"
    class="landing-page-hero-static"
    data-scroll-trigger
    class="lpo__hero-feature triggered trigger-complete <?= ($gestational || $pcos) ? '-slide-container-top' : '' ?>"
  >
    <a
      href="<?= healthCheckModalHref() ?>"
      class="lpo__hero-feature-hidden-button"
      <?php if ($gestational): ?>
        data-trigger-gestational
      <?php endif ?>
      <?php if ($pcos): ?>
        data-trigger-pcos
      <?php endif ?>
    ></a>
    <div
      class="slide-container inner"
      data-slideshow data-autochange-delay="0"
    >
      <div class="slides" data-slides>
        <?php foreach ($slides as $idx => $slide): ?>
          <div class="slide<?php echo ($idx == 0) ? ' active' : ''; ?> lpo__slide">
            <div class="center-frame-wide">
              <div class="content">
                <?php if ($slide['headline']) : ?>
                  <h2 class="font-huge fg-white wt-sb lh-tight"><?php echo apply_filters('the_brand', esc_html($slide['headline'])); ?></h2>
                <?php endif ?>
                <?php if ($slide['content']): ?>
                  <div class="message fg-white lh-mder">
                    <?php echo apply_filters('the_content', $slide['content']); ?>
                  </div>
                <?php endif ?>
                <?php if ($slide['call_to_action_link']): ?>
                  <div class="cta">
                    <a
                      href="<?php echo $slide['call_to_action_link']; ?>"
                      class="button"
                      <?php if ($gestational): ?>
                        data-trigger-gestational
                      <?php endif ?>
                      <?php if ($pcos): ?>
                        data-trigger-pcos
                      <?php endif ?>
                    ><?php echo apply_filters('the_brand', esc_html($slide['call_to_action_label'] ? $slide['call_to_action_label'] : 'Explore more')); ?></a>
                  </div>
                <?php endif ?>
              </div>
            </div>
            <div class="background tinted tint-black even-darker">
              <img src="<?php echo $slide['image']['url']; ?>" class="cover" alt="" role="presentation" />
            </div>
          </div>
        <?php endforeach ?>
      </div>
      <?php if (count($slides) > 1): ?>
        <div class="pagination">
          <div class="center-frame">
            <ul>
              <?php foreach ($slides as $idx => $slide): ?>
                <li class="<?php echo ($idx == 0) ? 'active' : ''; ?>" data-page="<?php echo $idx + 1; ?>"></li>
              <?php endforeach ?>
            </ul>
          </div>
        </div>
      <?php endif ?>
    </div>
    <div class="-bottom-edge-wavy"><?php echo life_svg('backgrounds/curve-01'); ?></div>
  </section>
<?php endif ?>