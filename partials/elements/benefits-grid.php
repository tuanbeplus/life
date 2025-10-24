<div class="benefits-grid">
  <h2><?= get_field('benefits_title', 'option') ?></h2>
  <div class="-grid">
    <?php if (have_rows('benefits_cells', 'option')): ?>
      <?php while (have_rows('benefits_cells', 'option')): the_row() ?>
        <div class="-benefit">
          <h3><?= get_sub_field('title') ?></h3>
          <p><?= get_sub_field('content') ?></p>
        </div>
      <?php endwhile ?>
    <?php endif ?>
  </div>
</div>