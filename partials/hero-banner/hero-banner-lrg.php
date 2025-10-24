<?php
$slide = $slides[0] ?? null ?>
<section
  class="hero-banner-lrg"
  style="--curveColor: <?= $curveColor ?>"
>
  <div class="-bg">
    <?php if (isset($slide['image']['url'])): ?>
      <img
        src="<?= $slide['image']['url'] ?>"
        class="cover"
        alt=""
        role="presentation"
      />
    <?php endif ?>
  </div>
  <div class="-content-overlay">
    <?= incTemplate('hero-banner/slide-text/'.$slideTextTemplate, ['slide' => $slide]) ?>
  </div>
  <svg-edge-curve-1></svg-edge-curve-1>
</section>
