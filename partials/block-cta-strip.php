<section
  class="block-cta-strip curve-top bg-off-white"
  data-scroll-trigger
>
  <?php if ($topCurve): ?>
    <svg-edge-curve-1></svg-edge-curve-1>
  <?php endif ?>
  <div class="center-frame">
    <ul class="listing ctas">
      <?php foreach ($ctas as $cta): ?>
        <li class="text-center">
          <div class="graphic fg-<?= ($cta['colour']) ? $cta['colour'] : 'green' ?>">
            <?= life_icon($cta['icon']) ?>
          </div>
          <div class="main">
            <?php if ($cta['title']): ?>
              <h3 class="title font-mdish lh-tight"><?= apply_filters('the_brand', esc_html($cta['title'])) ?></h3>
            <?php endif ?>
            <?php if ($cta['content']): ?>
              <div class="content formatted">
                <?= apply_filters('the_content', $cta['content']) ?>
              </div>
            <?php endif ?>
            <?php if ($cta['link_to']): ?>
              <div class="link">
                <a
                  href="<?= $cta['link_to'] ?>"
                  class="button sm orange nc"
                ><?= $cta['link_label'] ? $cta['link_label'] : 'Explore more' ?></a>
              </div>
            <?php endif ?>
          </div>
        </li>
      <?php endforeach ?>
    </ul>
    <?php if ($supporting): ?>
      <div class="supporting font-tiny lh-loose align-center">
        <?= apply_filters('the_content', $supporting) ?>
      </div>
    <?php endif ?>
  </div>
</section>
