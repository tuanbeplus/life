<div class="content-feature stepped-content">
  <div class="content">
    <?php if ($stepped['steps_intro']): ?>
      <div class="intro formatted">
        <?= apply_filters('the_content', $stepped['steps_intro']) ?>
      </div>
    <?php endif ?>
    <?php foreach ($stepped['steps'] as $i => $step): ?>
      <div class="step">
        <h3 class="wt-bold font-lgr lh-tight fg-primary">Step <?= ($i + 1) ?></h3>
        <?php if ($step['heading']): ?>
          <h4 class="wt-sb font-md lh-std"><?= apply_filters('the_brand', esc_html($step['heading'])) ?></h4>
        <?php endif ?>
        <?php if ($step['content']): ?>
          <div class="content formatted">
            <?= apply_filters('the_content', $step['content']) ?>
          </div>
        <?php endif ?>
        <?php if ($step['call_to_action']): ?>
          <div class="cta step-cta">
            <?php if ($step['pre_action_label']): ?>
              <h5 class="font-mdish wt-sb"><?= life_icon($step['pre_action_icon']) ?><?= apply_filters('the_brand', esc_html($step['pre_action_label'])) ?></h5>
            <?php endif ?>
            <?php if ($step['call_to_action_phone']): ?>
              <ul class="contact-options">
                <li>
                  <a href="<?= $step['call_to_action'] ?>" class="button primary"><?= ($step['call_to_action_label']) ? apply_filters('the_brand', esc_html($step['call_to_action_label'])) : 'Contact Us' ?></a>
                </li>
                <li>
                  <h5 class="font-mdish wt-bold fg-dark-grey">or call our team on <a href="tel:<?= preg_replace('/[^0-9\+]/', '', $step['call_to_action_phone']) ?>"><?= apply_filters('the_brand', esc_html($step['call_to_action_phone'])) ?></a></h5>
                </li>
              </ul>
            <?php else: ?>
              <div class="action">
                <a href="<?= $step['call_to_action'] ?>" class="button <?= $step['call_to_action_colour'] ?>"><?= ($step['call_to_action_label']) ? apply_filters('the_brand', esc_html($step['call_to_action_label'])) : 'Explore More' ?></a>
              </div>
            <?php endif ?>
          </div>
        <?php endif ?>
      </div>
    <?php endforeach ?>
  </div>
  <?php if ($stepped['steps_image']): ?>
    <div class="image">
      <div class="inner">
        <img
          src="<?= $stepped['steps_image']['url'] ?>"
          class="contain ia-bottom"
          alt=""
          role="presentation"
          loading="lazy"
          decoding="async"
        />
      </div>
    </div>
  <?php endif ?>
</div>
