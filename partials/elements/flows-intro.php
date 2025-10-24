<div class="intro">
  <?php if ( $flows['flow_intro_icon'] ): ?>
    <div class="icon-feature">
      <?= life_icon($flows['flow_intro_icon']) ?>
    </div>
  <?php endif ?>
  <?php if ( $flows['flow_intro'] ): ?>
    <div class="content formatted">
      <?= apply_filters('the_content', $flows['flow_intro']) ?>
    </div>
  <?php endif ?>
</div>
