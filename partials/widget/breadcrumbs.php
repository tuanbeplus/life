<?php
$postType = get_post(get_the_ID())->post_type ?? '';

if (is_search()) {
  $ancestors = [
    (object)[
      'id' => null,
      'title' => 'Home',
      'url' => '/',
    ],
    (object)[
      'id' => null,
      'title' => 'Search Results',
      'url' => '/?s='.esc_html($_GET['s']),
    ],
  ];
} else {
  $post = get_post();
  if ($postType == 'post') {
    $ancestors = [
      (object)['id' => null, 'title' => 'Home', 'url' => '/'],
      (object)['id' => null, 'title' => 'Health hub', 'url' => '/health-hub/'],
      (object)['id' => null, 'title' => get_the_title($post), 'url' => null],
    ];
  } else {
    if (isset($args['title']) && $args['title']) {
      $ancestors = [
        (object)[
          'id' => 0,
          'title' => $args['title'],
          'url' => $_SERVER['REQUEST_URI'],
        ],
      ];
    } else {
      $ancestors = [
        (object)[
          'id' => $post->id,
          'title' => get_the_title($post),
          'url' => get_the_permalink($post),
        ],
      ];
    }
    while ( $post->post_parent ) {
      $post = get_post($post->post_parent);
      $ancestors[] = (object)[
        'id' => $post->id,
        'title' => get_the_title($post),
        'url' => get_the_permalink($post),
      ];
    }
    wp_reset_postdata();
    $ancestors[] = (object)[
      'id' => null,
      'title' => 'Home',
      'url' => '/',
    ];
    $ancestors = array_reverse($ancestors);
  }
}
?>
<section
  class="block-breadcrumbs curve-top center-frame bg-white"
>
  <svg-edge-curve-1></svg-edge-curve-1>
  <div id="breadcrumbs">
    <ul>
      <?php foreach ($ancestors as $idx => $ancestor): ?>
        <?php if ($idx == (count($ancestors) - 1)): ?>
          <li><?= apply_filters('the_brand', esc_html($ancestor->title)) ?></li>
        <?php else: ?>
          <li><a href="<?= $ancestor->url ?>"><?= apply_filters('the_brand', esc_html($ancestor->title)) ?></a></li>
        <?php endif ?>
      <?php endforeach ?>
    </ul>
  </div>
</section>