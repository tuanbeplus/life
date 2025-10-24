<section class="section-content-icon-grid content bg-white padded">
  <div class="center-frame">
    <div class="formatted main-content">
      <?= apply_filters('the_content', $introContent) ?>
    </div>
    <?php if ($gridItems): ?>
      <ul class="listing ctas">
        <?php foreach ($gridItems as $grid_item): ?>
          <li class="text-center<?= (!$grid_item['link_to']) ? ' no-cta' : '' ?>">
            <div class="graphic fg-<?= $grid_item['colour'] ? $grid_item['colour'] : 'green' ?>">
              <?= life_icon($grid_item['icon'] ? $grid_item['icon'] : 'hug') ?>
            </div>
            <div class="main">
              <?php if ($grid_item['title']): ?>
                <h3 class="title font-mdish wt-md lh-tight">
                  <?= apply_filters('the_brand', esc_html($grid_item['title'])) ?>
                </h3>
              <?php endif ?>
              <?php if ($grid_item['content']): ?>
                <div class="content formatted">
                  <?= apply_filters('the_content', $grid_item['content']) ?>
                </div>
              <?php endif ?>
              <?php if ($grid_item['link_to']): ?>
                <div class="link">
                  <a href="<?= $grid_item['link_to'] ?>" class="button sm orange nc"><?= $grid_item['link_label'] ? apply_filters('the_brand', esc_html($grid_item['link_label'])) : 'Explore more' ?></a>
                </div>
              <?php endif ?>
            </div>
          </li>
        <?php endforeach ?>
      </ul>
    <?php endif ?>
    <?php if ($gridSupporting): ?>
      <div class="supporting font-tiny lh-loose align-center">
        <?= apply_filters('the_content', $gridSupporting) ?>
      </div>
    <?php endif ?>
  </div>
</section>
