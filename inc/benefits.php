<?php


if (function_exists('acf_add_options_page')) {
  add_action('acf/init', function() {
    acf_add_options_page(
      [
        'page_title'  => __('Benefits'),
        'menu_title'  => __('Benefits'),
        'menu_slug'  => 'benefits',
        'redirect'    => false,
      ],
    );
  });
}
if (function_exists('acf_add_local_field_group')) {
  add_action('acf/init', function() {
    acf_add_local_field_group([
      'key' => 'benefits',
      'title' => 'Benefits',
      'fields' => [
        [
          'key' => 'benefits_title',
          'label' => 'Title',
          'name' => 'benefits_title',
          'type' => 'text',
        ],
        [
          'key' => 'benefits_cells',
          'label' => 'Cells',
          'name' => 'benefits_cells',
          'type' => 'repeater',
          'sub_fields' => [
            [
              'key' => 'title',
              'label' => 'Title',
              'name' => 'title',
              'type' => 'text',
            ],
            [
              'key' => 'content',
              'label' => 'Content',
              'name' => 'content',
              'type' => 'text',
            ],
          ],
        ],
      ],
      'location' => [
        [
          [
            'param' => 'options_page',
            'operator' => '==',
            'value' => 'benefits',
          ],
        ],
      ],
    ]);
  });
}






