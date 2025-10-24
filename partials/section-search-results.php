<?php
global $wp_the_query;

// Work out pagination
$current = max(get_query_var('paged'), 1);
$total_results = $wp_the_query->found_posts;
$total_pages = ceil($total_results / 9);
$search_term = esc_html($_GET['s']);


// Work out pagination links
$page_range = 3;
$page_divisions = 4;
$division_size = $total_pages / $page_divisions;

$page_numbers = [1, $current, max(1, $total_pages)];

// Add pages within x places of the current page
for ( $x = max(1, $current - $page_range); $x <= min($total_pages, $current + $page_range); $x++ ) {
  $page_numbers[] = $x;
}

// And the numbers per page division
for ( $x = 1; $x < $page_divisions; $x++ ) {
  $page_number = round($division_size * $x);
  
  if ( $page_number > 0 ) {
    $page_numbers[] = $page_number;
  }
}

$page_numbers = array_unique($page_numbers);
sort($page_numbers);
?>

<section class="search-results bg-white padded">
  <div class="center-frame">
    <div class="content fg-near-black">
      <?php if (have_posts()) { ?>
        <ol class="listing search-results">
          <?php
            while (have_posts()) {
              the_post();
              $post = get_post();
              $ancestor_title = $post->post_title;
              $title = get_the_title();
              $excerpt = get_the_excerpt();
              $permalink = get_the_permalink();
              
              // Find the 'category' we live in
              while ( $post->post_parent ) {
                $post = get_post($post->post_parent);
                $ancestor_title = $post->post_title;
              }
              //wp_reset_postdata();
          ?>
          <li>
            <div class="inner bg-white">
              <h3 class="title wt-sb lh-std font-md fg-primary"><?= $title ?></h3>
              <div class="summary font-std wt-std lh-std">
                <?= ($excerpt) ? $excerpt : '(No summary available)' ?>
              </div>
              <div class="view-more wt-std">
                <a href="<?= $permalink ?>" class="echo-link"><i class="echo-circle"></i>Discover More</a>
              </div>
            </div>
          </li>
        <?php
            wp_reset_postdata();
          }
        ?>
        </ol>
      <?php } else { ?>
        <p>Unfortunately we couldn't find any results for your search.</p>
      <?php } ?>
      
    </div>
    
    <?php if (have_posts()) { ?>
    <div class="page-pagination">
      <ul>
        <li class="relative-nav">
          <?php if ($current > 1): ?>
            <a href="/page/<?= max($current - 1, 1) ?>/?s=<?= $search_term ?>" title="Previous page"><?= life_icon('arrow-left') ?></a>
          <?php else: ?>
            <span><?= life_icon('arrow-left') ?></span>
          <?php endif ?>
        </li>
        <?php foreach ( $page_numbers as $x ) { ?>
        <li class="page-num<?= ($x == $current) ? ' current' : '' ?><?= ($x == $current - 1) ? ' prev' : '' ?><?= ($x == $current + 1) ? ' next' : '' ?>">
          <?php if ( $x != $current ) { ?>
          <a href="/page/<?= $x ?>/?s=<?= $search_term ?>" title="To page <?= $x ?>"><?= $x ?></a>
          <?php } else { ?>
          <span><?= $x ?></span>
          <?php } ?>
        </li>
        <?php } ?>
        <li class="relative-nav">
          <?php if ( $current < $total_pages ) { ?>
          <a href="/page/<?= min($current + 1, $total_pages) ?>/?s=<?= $search_term ?>" title="Previous page"><?= life_icon('arrow-right') ?></a>
          <?php } else { ?>
          <span><?= life_icon('arrow-right') ?></span>
          <?php } ?>
        </li>
      </ul>
    </div>
    <?php } ?>
    
  </div>
</section>
