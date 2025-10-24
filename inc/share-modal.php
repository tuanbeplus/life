<?php

if (function_exists('acf_add_options_page')) {
  add_action('acf/init', function() {
    acf_add_options_page(
      [
        'page_title' => __('Share popup'),
        'menu_title' => __('Share popup'),
        'menu_slug' => 'share-popup',
        'redirect' => false,
      ],
    );
  });
}
