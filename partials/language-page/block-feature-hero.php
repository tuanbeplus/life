<?php
$slides = get_field('lpo_slides')['slides'] ?? null;
?>

<?php if ($slides): ?>
  <section
    id="hero-feature"
    class="lpo__hero-feature triggered trigger-complete lpo__language-page"
  >
    <div class="slide-container inner" data-slideshow data-autochange-delay="0">
      <div class="slides" data-slides>
        <?php foreach ($slides as $idx => $slide): ?>
          <div class="slide<?= ($idx == 0) ? ' active' : '' ?> lpo__slide">
            <div class="center-frame lpo__lp-grid">
              <div class="content">
                <?php if ($slide['headline_one']): ?>
                  <h2 class="font-huge fg-white wt-sb lh-tight lpo__lp-headline-one"><?= apply_filters('the_brand', esc_html($slide['headline_one'])) ?></h2>
                <?php endif ?>
                <?php if ($slide['content_one']): ?>
                  <div class="message fg-white lh-mder">
                    <?= apply_filters('the_content', $slide['content_one']) ?>
                  </div>
                <?php endif ?>
                <?php if ($slide['button_one']['label']): ?>
                  <div class="cta">
                    <a href="<?= $slide['button_one']['target'] ?>" class="button"><?= apply_filters('the_brand', esc_html($slide['button_one']['label'] ? $slide['button_one']['label'] : 'Explore more')) ?></a>
                  </div>
                <?php endif ?>
              </div>
              <div class="content">
                <?php if ($slide['headline_two']): ?>
                  <h2 class="font-huge fg-white wt-sb lh-tight"><?= apply_filters('the_brand', esc_html($slide['headline_two'])) ?></h2>
                <?php endif ?>
                <?php if ($slide['content_two']): ?>
                  <div class="message fg-white lh-mder">
                    <?= apply_filters('the_content', $slide['content_two']) ?>
                  </div>
                <?php endif ?>
                <?php if ($slide['button_two']['label']): ?>
                  <div class="cta">
                    <a href="<?= $slide['button_two']['target'] ?>" class="button"><?= apply_filters('the_brand', esc_html($slide['button_two']['label'] ? $slide['button_two']['label'] : 'Explore more')) ?></a>
                  </div>
                <?php endif ?>
              </div>
            </div>
            <div class="background tinted tint-black even-darker">
              <img src="<?= $slide['image']['url'] ?>" class="cover" alt="" role="presentation" />
            </div>
          </div>
        <?php endforeach ?>
      </div>
      <?php if (count($slides) > 1): ?>
        <div class="pagination">
          <div class="center-frame">
            <ul>
              <?php foreach ($slides as $idx => $slide): ?>
                <li class="<?= ($idx == 0) ? 'active' : '' ?>" data-page="<?= $idx + 1 ?>"></li>
              <?php endforeach ?>
            </ul>
          </div>
        </div>
      <?php endif ?>
    </div>
  </section>
<?php endif ?>