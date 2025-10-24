<?php


if (function_exists('acf_add_options_page')) {
  add_action('acf/init', function() {
    acf_add_options_page(
      [
        'page_title' => __('Footer CTA banner'),
        'menu_title' => __('Footer CTA banner'),
        'menu_slug' => 'footer-cta-banner',
        'redirect' => false,
      ],
    );
  });
}
if (function_exists('acf_add_local_field_group')) {
  add_action('acf/init', function() {
    acf_add_local_field_group([
      'key' => 'footer-cta-banner',
      'title' => 'Footer CTA Banner',
      'fields' => [
        [
          'key' => 'footer_cta_banner_title',
          'label' => 'Title',
          'name' => 'footer_cta_banner_title',
          'type' => 'text',
        ],
        [
          'key' => 'right_column_content',
          'label' => 'Right column content',
          'name' => 'right_column_content',
          'type' => 'text',
        ],
        [
          'key' => 'right_column_button_url',
          'label' => 'Right column button url',
          'name' => 'right_column_button_url',
          'type' => 'text',
        ],
        [
          'key' => 'right_column_button_text',
          'label' => 'Right column button text',
          'name' => 'right_column_button_text',
          'type' => 'text',
        ],
      ],
      'location' => [
        [
          [
            'param' => 'options_page',
            'operator' => '==',
            'value' => 'footer-cta-banner',
          ],
        ],
      ],
    ]);
    acf_add_local_field_group([
      'key' => 'subscribe',
      'title' => 'Subscribe',
      'fields' => [
        [
          'key' => 'subscribe_intro',
          'label' => 'Intro',
          'name' => 'subscribe_intro',
          'type' => 'wysiwyg',
        ],
        [
          'key' => 'subscribe_button_text',
          'label' => 'Button text',
          'name' => 'subscribe_button_text',
          'type' => 'text',
        ],
      ],
      'location' => [
        [
          [
            'param' => 'options_page',
            'operator' => '==',
            'value' => 'footer-cta-banner',
          ],
        ],
      ],
    ]);
  });
}



add_shortcode( 'subscribe', function($atts, $content = null) {
  return incTemplateShortcode('subscribe-form-shortcode-block', [
    'heading' => $content,
  ]);
});


