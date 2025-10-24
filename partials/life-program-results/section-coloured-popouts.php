<?php
$colouredPopout = get_field('coloured_popouts_section');
?>
<?php if ($colouredPopout['content']): ?>
  <section class="section-coloured-popouts bg-white coloured-popouts">
    <div class="-text">
      <div class="formatted">
        <?= apply_filters('the_content', $colouredPopout['content']) ?>
      </div>
    </div>
    <?php if ($colouredPopout['popouts']): ?>
      <div class="-popouts">
        <?php foreach ($colouredPopout['popouts'] as $idx => $popout): ?>
          <slide-in-block
            class="<?= $popout['colour'] ?: '' ?>"
          >
            <h3 class="font-lg"><?= apply_filters('the_brand', esc_html($popout['header'])) ?></h3>
            <?php if ($popout['content']): ?>
              <div class="message lh-std">
                <?= apply_filters('the_content', $popout['content']) ?>
              </div>
            <?php endif ?>
          </slide-in-block>
        <?php endforeach ?>
      </div>
    <?php endif ?>
  </section>
<?php endif ?>