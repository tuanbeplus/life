<?php $buttonText = apply_filters('the_brand', esc_html($slide['call_to_action_label'] ? $slide['call_to_action_label'] : '')) ?>
<div class="slide-text-single">
  <?php if ($slide['headline'] ?? null): ?>
    <h1 class="font-huge lh-tight">
      <?= apply_filters('the_brand', esc_html($slide['headline'])) ?>
    </h1>
  <?php endif ?>
  <?php if ($slide['content'] ?? null): ?>
    <div class="-body-copy">
      <?= apply_filters('the_content', $slide['content']) ?>
    </div>
  <?php endif ?>
  <div class="cta">
    <?php if (pageIsGestational()): ?>
      <contact-trigger-gestational
        class="button -padx-sml"
        button-text="<?= $buttonText ?: 'Join' ?>"
      ></contact-trigger-gestational>
    <?php elseif (pageIsPcos()): ?>
      <contact-trigger-pcos
        class="button -padx-sml"
        button-text="<?= $buttonText ?: 'Join' ?>"
      ></contact-trigger-pcos>
    <?php else: ?>
      <?php if ($slide['call_to_action_link'] ?? null): ?>
        <a
          href="<?= $slide['call_to_action_link'] ?>"
          class="button -padx-sml"
        >
          <?= $buttonText ?: 'Explore more' ?>
        </a>
      <?php else: ?>
        <a href="#health-check" class="button -padx-sml">Take the QUICK health check</a>
      <?php endif ?>
    <?php endif ?>
  </div>
</div>