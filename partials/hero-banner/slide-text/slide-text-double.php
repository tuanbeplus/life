<div class="slide-text-double">
  <?php foreach (['one', 'two'] as $suffix): ?>
    <div class="-col">
      <?php if ($slide['headline_'.$suffix] ?? null): ?>
        <h1 class="font-huge lh-tight">
          <?= apply_filters('the_brand', esc_html($slide['headline_'.$suffix])) ?>
        </h1>
      <?php endif ?>
      <?php if ($slide['content_'.$suffix] ?? null): ?>
        <div class="-body-copy">
          <?= apply_filters('the_content', $slide['content_'.$suffix]) ?>
        </div>
      <?php endif ?>
      <?php if ($slide['button_'.$suffix]['label']): ?>
        <div class="cta">
          <a
            href="<?= $slide['button_'.$suffix]['target'] ?>"
            class="button"
          ><?= apply_filters('the_brand', esc_html($slide['button_'.$suffix]['label'] ? $slide['button_'.$suffix]['label'] : 'Explore more')) ?></a>
        </div>
      <?php endif ?>
    </div>
  <?php endforeach ?>
</div>