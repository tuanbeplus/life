<?php


add_action('rest_api_init', function () {
  register_rest_route('health-check/v1', '/(?P<lang>[\w-]+)', [
    'methods' => 'GET',
    'permission_callback' => '__return_true',
    'callback' => 'healthCheckData',
    'args' => [
      'lang' => [
        'validate_callback' => function($param, $request, $key) {
          return is_string($param) && in_array($param, ['en', 'zh-Hans', 'zh-Hant', 'ar', 'vi']);
        }
      ],
    ],
  ]);
});

function healthCheckData($data) {
  return new WP_REST_Response([
    'translations' => include(get_template_directory() . '/inc/lang/health-check/' . $data['lang'] . '.php'),
  ], 200);
}
