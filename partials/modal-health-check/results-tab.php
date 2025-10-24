<div class="tab-inner results" data-tab-number="results" data-tab-set="health-check">
  <div class="inner program-info">
    <header>
      <div class="-bg">
        <h2><?= $your_score_is ?> <span id="<?= $form_id ?>-risk-score">0</span></h2>
        <?php foreach ($header_eligibility as $cssClass => $text): ?>
          <h3 class="<?= $cssClass ?>"><?= $text['heading'] ?></h3>
          <?php if (isset($text['post_heading'])): ?>
            <h4 class="-post-heading <?= $cssClass ?>"><?= $text['post_heading'] ?></h4>
          <?php else: ?>
            <?= incTemplate('modal-health-check/results-tab/contact2', [
              'outerClass' => 'mobile-contact-options block '.$cssClass,
            ]) ?>
          <?php endif ?>
        <?php endforeach ?>
      </div>
      <div class="-wave-graphic">
        <svg width="100%" height="100%" viewBox="0 0 830 40" version="1.1">
          <path d="M292.126,40C172.186,40 56.736,31.286 0,23.937L0,0L830,0L830,31.811C716.401,17.953 586.164,23.628 478.111,31.811C473.329,32.132 344.24,40 292.126,40Z" style="fill:currentColor;fill-rule:nonzero;"/>
        </svg>
      </div>
    </header>
    <section>
      <?php foreach ($bodies as $cssClass => $body): ?>
        <?php if (isset($body['points'])): ?>
          <div class="-breakdown <?= $cssClass ?>">
            <h3><?= $body_intro ?></h3>
            <?php foreach ($body['points'] as $point): ?>
              <div class="-point">
                <div class="-icon">
                  <img
                    src="<?= get_template_directory_uri() . '/images/' . $point['icon'] ?>"
                    loading="lazy"
                    decoding="async"
                    alt="<?= $point['icon_alt'] ?>"
                  />
                </div>
                <div class="-text">
                  <p><?= $point['text'] ?></p>
                </div>
              </div>
            <?php endforeach ?>
          </div>
        <?php elseif (isset($body['splash_image'])): ?>
          <div class="-splash-image <?= $cssClass ?>">
            <picture>
              <source
                media="(max-width: 800px)"
                type="image/webp"
                srcset="<?= get_template_directory_uri() . $body['splash_image']['mobile'] ?>"
              />
              <img
                src="<?= get_template_directory_uri() . $body['splash_image']['desktop'] ?>"
                alt="happy healthy people"
              />
            </picture>
          </div>
        <?php elseif (isset($body['template'])): ?>
          <div class="-template <?= $cssClass ?> <?= $body['template']['cssClass'] ?>">
            <?= incTemplate($body['template']['path'], $body['template']['vars'] ?? []) ?>
          </div>
        <?php endif ?>
      <?php endforeach ?>
    </section>
    <footer class="hide-if-not-eligible">
      <?php include 'results-tab/'.$footer_stats_template.'.php' ?>
      <?php foreach ($footer_by_completing as $cssClass => $text): ?>
        <p class="-by-completing <?= $cssClass ?>"><?= $text ?></p>
      <?php endforeach ?>
    </footer>
  </div>
</div>