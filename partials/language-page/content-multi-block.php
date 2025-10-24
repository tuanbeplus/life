<section class="content-multi-block">
  <div class="center-frame grid-container">
    <?php foreach ($blocks as $block): ?>
      <div class="content-wrapper">
        <div class="formatted main-content">
          <?php echo apply_filters('the_content', $block); ?>
        </div>
      </div>
    <?php endforeach ?>
  </div>
</section>