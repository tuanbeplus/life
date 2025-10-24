<?php

$related = get_field('related_pages');
$heading = get_field('related_heading');

if ( $related ): ?>
  <section class="bg-white related-links">
    <div class="center-frame">
      <h3 class="wt-bold font-lgr lh-std"><?= ($heading) ? $heading : 'You might also be interested in' ?></h3>
      <ul class="listing link-list">
        <?php foreach ( $related as $related_page ): ?>
          <li><a href="<?= get_the_permalink($related_page) ?>"><?= apply_filters('the_brand', esc_html(get_the_title($related_page))) ?></a></li>
        <?php endforeach ?>
      </ul>
    </div>
  </section>
<?php endif ?>
