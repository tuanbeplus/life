<?php


if( function_exists('acf_add_options_page') ) {
  add_action('acf/init', function() {
    acf_add_options_page(
      [
        'page_title'  => __('Our Team'),
        'menu_title'  => __('Our Team'),
        'menu_slug'  => 'our-team',
        'redirect'    => false,
      ],
    );
  });
}




add_shortcode( 'team', function( $atts ) {
  ob_start();
  if (have_rows('team_members', 'option')) {
    include 'template/our-team.php';
  } else {
    echo '[team] - Cannot find Team members in database';
  }
  return ob_get_clean();
});


