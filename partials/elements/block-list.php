
<ul class="block-content listing">
  <?php foreach ($blocks as $block): ?>
    <li>
      <?php if ( $block['link_to'] ) { ?>
        <a href="<?= $block['link_to'] ?>" class="inner">
      <?php } else { ?>
        <div class="inner">
      <?php } ?>
        <h3 class="wt-sb font-middling lh-tight block-title"><?= apply_filters('the_brand', esc_html($block['title'])) ?></h3>
        <div class="content formatted lh-std">
          <?= apply_filters('the_content', $block['content']) ?>
        </div>
      <?php if ( $block['link_to'] ) { ?>
        </a>
      <?php } else { ?>
        </div>
      <?php } ?>
    </li>
  <?php endforeach ?>
</ul>
