<?php

$per_page = 8;
$page = isSet($_GET['pg']) ? max((int)$_GET['pg'], 1) : 1;


$options = new ServiceLocatorOptions;
// dd($options->suburbs, $options->types);


$filter = new ServiceLocatorFilter($options->suburbs, $options->types);
// dd($filter->constraints);

// NB.
// the ACF field group for these is called 'Location Details'
$results = new WP_Query([
  'post_type'     => 'page',
  'post_status'    => ['publish'],
  'order'       => 'ASC',
  'orderby'       => 'title',
  'posts_per_page'   => $per_page,
  'offset'      => (($page - 1) * $per_page),
  'meta_query'     => array_merge(['relation' => 'AND'], $filter->constraints),
]);

$pagination = new ServiceLocatorPagination(
  $page,
  ceil($results->found_posts / $per_page),
  $filter->vars
)

?>
<section class="service-locator bg-white padded">
  <div class="center-frame">
    <div class="formatted main-content">
      <form action="#" method="get" class="filter-form">
        <div class="column flex-3">
          <div class="form-group placeholder-field">
            <label for="location-suburb">Service Location</label>
            <select-sml
              :opts="<?= vueProp(selectOpts($options->suburbs, true)) ?>"
              init-key="<?= $filter->vars['suburb'] ?>"
              fieldname="suburb"
              placeholder="Any Suburb"
            ></select-sml>
          </div>
        </div>
        <div class="column flex-3">
          <div class="form-group placeholder-field">
            <label for="location-type">Type of Service</label>
            <select-sml
              :opts="<?= vueProp(selectOpts($options->types, true)) ?>"
              init-key="<?= $filter->vars['type'] ?>"
              fieldname="type"
              placeholder="All Service Types"
            ></select-sml>
          </div>
        </div>
        <div class="column submit">
          <div class="form-group submit">
            <button type="submit" class="button orange block" aria-label="Search">Search</button>
          </div>
        </div>
      </form>

      <?php if (!$filter->vars['suburb'] && $filter->vars['type'] == 'Online Service'): ?>
        <div class="filter-form__online-services-notice alert warning">
          Only online services match your search
        </div>
      <?php endif ?>
    </div>

    <?php if ($pagination->pages): ?>
      <div class="services">
        <?php while ( $results->have_posts() ): ?>
          <?php $results->the_post() ?>
          <div class="service bg-off-white">
            <div class="-overview">
              <h3 class="title wt-sb font-middling lh-std"><?= apply_filters('the_brand', get_the_title()) ?></h3>
              <div class="description lh-std">
                <?= apply_filters('the_content', get_the_excerpt()) ?>
              </div>
            </div>
            <div class="-cta">
              <a href="<?= get_the_permalink() ?>" class="button white bdr-orange tight"><?= life_icon('binoculars-filled') ?><span>Discover Service</span></a>
            </div>
            <div class="-address">
              <?php if ( get_field('location_type') == 'Online Service' ): ?>
                <h4 class="title wt-sb font-std lh-std">Website</h4>
                <div class="address-formatted lh-std">
                  <a href="<?= get_field('website') ?>" class="external"><?= get_field('website') ?></a>
                </div>
              <?php else: ?>
                <h4 class="title wt-sb font-std lh-std">Address</h4>
                <div class="address-formatted lh-std">
                  <?php if ( get_field('location_address') ): ?>
                    <p><?= get_field('location_address') ?></p>
                  <?php endif ?>
                  <p><?= get_field('location_suburb') ?>, <?= get_field('location_state') ?> <?= get_field('location_postcode') ?></p>
                </div>
              <?php endif ?>
            </div>
          </div>
          <?php wp_reset_postdata() ?>
        <?php endwhile ?>
      </div>
    <?php else: ?>
      <div class="no-results lh-std">
        <p>Unfortunately there are no results to show at this time. Please try amending your search or check out these <a href="/find-a-health-service/?suburb=&type=Online+Service&search_locations=#">online services</a>.</p>
      </div>
    <?php endif ?>

    <div class="page-pagination">
      <ul>
        <li class="relative-nav">
          <?php if ( $page > 1 ): ?>
            <a href="<?= get_the_permalink() ?>?pg=<?= ($page - 1).$pagination->qStr ?>" title="Previous page"><?= life_icon('arrow-left') ?></a>
          <?php else: ?>
            <span><?= life_icon('arrow-left') ?></span>
          <?php endif ?>
        </li>
        <?php foreach ( $pagination->pageNumbers as $x ): ?>
          <li class="page-num<?= ($x == $page) ? ' current' : '' ?><?= ($x == $page - 1) ? ' prev' : '' ?><?= ($x == $page + 1) ? ' next' : '' ?>">
            <?php if ( $x != $page ): ?>
              <a href="<?= get_the_permalink() ?>?pg=<?= $x.$pagination->qStr ?>" title="To page <?= $x ?>"><?= $x ?></a>
            <?php else: ?>
              <span><?= $x ?></span>
            <?php endif ?>
          </li>
        <?php endforeach ?>
        <li class="relative-nav">
          <?php if ( $page < $pagination->pages ): ?>
            <a href="<?= get_the_permalink() ?>?pg=<?= ($page + 1).$pagination->qStr ?>" title="Previous page"><?= life_icon('arrow-right') ?></a>
          <?php else: ?>
            <span><?= life_icon('arrow-right') ?></span>
          <?php endif ?>
        </li>
      </ul>
    </div>
  </div>
</section>
