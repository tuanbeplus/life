
<?php if (get_field('popout_content')): ?>
  <section
    class="block-colored-side-boxes"
    data-scroll-trigger
  >
    <div class="-cols">
      <div class="-text">
        <div class="formatted -bolder-li-lighter-h3">
          <?= apply_filters('the_content', get_field('popout_content')) ?>
        </div>
        <?php if (false && get_field('popout_call_to_action_link')): ?>
          <div class="cta step-cta">
            <?php if (get_field('popout_pre_action_label')): ?>
              <h4 class="font-mdish wt-sb">
                <?= life_icon(get_field('popout_pre_action_icon')) ?>
                <?= apply_filters('the_brand', esc_html(get_field('popout_pre_action_label'))) ?>
              </h4>
            <?php endif ?>
            <div class="action">
              <a href="<?= get_field('popout_call_to_action_link') ?>" class="button <?= get_field('popout_call_to_action_colour') ?>"><?= (get_field('popout_call_to_action_label')) ? apply_filters('the_brand', esc_html(get_field('popout_call_to_action_label'))) : 'Explore More' ?></a>
            </div>
          </div>
        <?php endif ?>
      </div>
      <div class="-side-boxes">
        <?php if (get_field('popouts')): ?>
          <ul>
            <?php foreach (get_field('popouts') as $i => $popout): ?>
              <li class="colored-block <?= ($i < 1) ? 'current' : '' ?><?= ($popout['colour']) ? " {$popout['colour']}" : '' ?>">
                <h3 class="font-lg "><?= apply_filters('the_brand', esc_html($popout['header'])) ?></h3>
                <?php if ($popout['content']): ?>
                  <div class="message lh-std">
                    <?= apply_filters('the_content', $popout['content']); ?>
                  </div>
                <?php endif ?>
              </li>
            <?php endforeach ?>
          </ul>
        <?php endif ?>
      </div>
    </div>
    <?= incTemplate('elements/modal-trigger-buttons', [
      'dialogId' => 'colored-side-boxes',
    ]) ?>
  </section>
<?php endif ?>
