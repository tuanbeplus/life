
<section
  class="block-steps-feature"
  data-scroll-trigger
>
  <div class="center-frame">
    <div class="-text">
      <?php if (get_field('steps_heading')): ?>
        <h2 class="font-lgr"><?= apply_filters('the_brand', esc_html(get_field('steps_heading'))) ?></h2>
      <?php endif ?>
      <div class="-steps">
        <?php foreach ($steps as $idx => $step): ?>
          <div class="-step">
            <?php if ($step['title']): ?>
              <h3 class="font-mdish"><?= apply_filters('the_brand', esc_html($step['title'])) ?></h3>
            <?php endif ?>
            <?php if ($step['content']): ?>
              <div class="message lh-mder">
                <?= apply_filters('the_content', $step['content']) ?>
              </div>
            <?php endif ?>
            <?php if ($step['call_to_action_link']): ?>
              <div class="cta">
                <a
                  href="<?= $step['call_to_action_link'] ?>"
                  class="button primary sm nc"
                ><?= $step['call_to_action_label'] ? $step['call_to_action_label'] : 'Explore more' ?></a>
              </div>
            <?php endif ?>
          </div>
        <?php endforeach ?>
      </div>
    </div>
    <?php if (get_field('steps_side_image')): ?>
      <div class="-image">
        <div>
          <img
            src="<?= get_field('steps_side_image')['url'] ?>"
            class="contain ia-bottom"
            role="presentation"
            alt="Happy new family"
          />
        </div>
      </div>
    <?php endif ?>
  </div>
</section>