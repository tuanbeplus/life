<div class="testimonial <?= ($idx == 0) ? 'active' : '' ?>">
  <?php if ($testimonial['image']): ?>
    <div class="-image">
      <div class="inner masked">
        <img src="<?= $testimonial['image']['sizes']['testimonial'] ?>" class="cover" alt="" role="presentation" />
        <div class="mask"><?= life_svg('backgrounds/testimonial-mask') ?></div>
      </div>
    </div>
  <?php endif ?>
  <div class="-text">
    <h3 class="-title"><?= apply_filters('the_brand', $testimonial['headline']) ?></h3>
    <blockquote class="quoted">
      <?= life_icon('quote-left') ?><p><?= apply_filters('the_brand', $testimonial['quote']) ?></p><?= life_icon('quote-right') ?>
    </blockquote>
    <div class="attribution lh-std">
      <?php
      $att_type = $testimonial['attribution_type'] ?? false;
      $att_company = $testimonial['attribution_company'] ?? false;
      if ($att_type && $att_company):
      ?>
        <p>Say hello to <?= $testimonial['attribution'] ?> a <em>Life!</em> <?= $att_type ?> at <?= $att_company ?></p>
      <?php elseif ($att_type): ?>
        <p>Say hello to <?= $testimonial['attribution'] ?> a <em>Life!</em> <?= $att_type ?></p>
      <?php else: ?>
        <p>Say hello to <?= $testimonial['attribution'] ?></p>
      <?php endif ?>
    </div>
  </div>
</div>
