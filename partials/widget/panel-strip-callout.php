<?php if ($title ?? false): ?>
  <h4 class="title font-mdish wt-sb lh-tight">
    <?php echo apply_filters('the_brand', $title); ?>
  </h4>
<?php endif ?>
<?php if ($content ?? false): ?>
  <div class="content formatted">
    <?php echo apply_filters('the_content', $content); ?>
  </div>
<?php endif ?>
