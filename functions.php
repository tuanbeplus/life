<?php
/**
 * life functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage life
 * @since life 1.0
 */

require_once('inc/salesforce.php');

function env($key, $default = null) {
  static $_env = null;
  if ($_env === null) {
    $_env = parse_ini_file('.env');
  }
  return $_env[$key] ?? $default;
}

// Some custom rewrites for our resource area
add_action( 'init',  function() {
  add_rewrite_rule('(.?.+?)/(fact-sheet|article|recipe)s?/?$', 'index.php?pagename=$matches[1]&resource_type=$matches[2]', 'top');
  add_rewrite_rule('(.?.+?)/(who-its-for|how-it-works|am-i-eligible)?/?$', 'index.php?pagename=$matches[1]&resource_type=$matches[2]', 'top');
});


function life_custom_mime_types($mime_types){
    $mime_types['4w7'] = 'application/octet-stream';
    return $mime_types;
}
add_filter('upload_mimes', 'life_custom_mime_types', 1, 1);


/**
 * Set up the content width value based on the theme's design.
 *
 * @see life_content_width()
 *
 * @since life 1.0
 */
if ( ! isset( $content_width ) ) {
  $content_width = 474;
}

/**
 * life only works in WordPress 3.6 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '3.6', '<' ) ) {
  require get_template_directory() . '/inc/back-compat.php';
}



// Admin menu / setting extensions
require get_template_directory().'/inc/admin-settings.php';



if ( ! function_exists( 'life_setup' ) ) :
/**
 * life setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 * @since life 1.0
 */
function life_setup() {
  /*
   * Make life available for translation.
   *
   * Translations can be added to the /languages/ directory.
   * If you're building a theme based on life, use a find and
   * replace to change 'life' to the name of your theme in all
   * template files.
   */
  load_theme_textdomain( 'life', get_template_directory() . '/languages' );

  // This theme styles the visual editor to resemble the theme style.
  add_editor_style(array('css/editor-style.css', life_font_url()));

  // Enable support for Post Thumbnails, and declare two sizes.
  add_theme_support('post-thumbnails');
  add_image_size('resource-mini', 110, 150, true);
  add_image_size('resource-tile', 250, 210, true);
  add_image_size('testimonial', 400, 435, true);
  add_image_size('tab-feature', 1060, 400, true);
  add_image_size('level2-hero', 1700, 435, true);

  set_post_thumbnail_size(250, 210, true);

  // This theme uses wp_nav_menu() in three locations.
  register_nav_menus([
    'upper'       => __('Upper Navigation', 'life'),
    'primary'     => __('Primary Navigation', 'life'),
    'primary-buttons'     => __('Primary Nav Buttons', 'life'),
    'footer'     => __('Footer Menu', 'life'),
    'legals'     => __('Footer Legals', 'life'),
  ]);

  // Add support for featured content.
  add_theme_support('featured-content', [
    'featured_content_filter' => 'life_get_featured_posts',
    'max_posts' => 6,
  ]);

  // This theme uses its own gallery styles.
  add_filter( 'use_default_gallery_style', '__return_false' );
  add_filter( 'the_content', 'remove_empty_p', 20, 1);

  // Because I'm sick of typing this and no one else will
  function life_em_brand($src) {
    return preg_replace(
      [
        '#Life\! flex#si',
        '#Life\!#si',
        '#<em>Life\!</em> Online#si',
      ],
      [
        '<i><em>Life!</em> flex</i>',
        '<em>Life!</em>',
        '<em>Life! Online</em>',
      ],
      $src
    );
  }
  add_filter('the_brand', 'life_em_brand');
  add_filter('the_content', 'life_em_brand');

  // Dynamically populate some selects
  add_filter('acf/load_field/type=select', 'life_dynamic_select_choices');
}
endif; // life_setup
add_action( 'after_setup_theme', 'life_setup' );


function life_dynamic_select_choices($field) {
  if ( preg_match('/^icon_|_icon_|_icon$|^icon$/', $field['name']) ) {
    $choices = [];

    foreach ( glob(__DIR__.'/images/icons/*.svg') as $filename ) {
      $key = preg_replace('/\.svg$/si', '', basename($filename));
      $label = ucwords(preg_replace('/[^a-z0-9]/', ' ', $key));
      $field['choices'][$key] = $label;
    }
  } else if ( preg_match('/^colour_|_colour_|_colour$|^colour$/', $field['name']) ) {
    $field['choices']['green'] = 'Green';
    $field['choices']['purple'] = 'Purple';
    $field['choices']['teal'] = 'Teal';
    $field['choices']['orange'] = 'Orange';

    ksort($field['choices']);
  }

  return $field;
}


function remove_empty_p($content){
  $content = preg_replace('#<p></div>#', '</div>', $content);
  $content = preg_replace('#<p>\s*</p>#', '', $content);
  $content = preg_replace('#<div class="omsc-toggle-inner"></p>#', '<div class="omsc-toggle-inner">', $content);

  return $content;
}

/**
 * Adjust content_width value for image attachment template.
 *
 * @since life 1.0
 */
function life_content_width() {
  if ( is_attachment() && wp_attachment_is_image() ) {
    $GLOBALS['content_width'] = 810;
  }
}
add_action( 'template_redirect', 'life_content_width' );

/**
 * Getter function for Featured Content Plugin.
 *
 * @since life 1.0
 *
 * @return array An array of WP_Post objects.
 */
function life_get_featured_posts() {
  /**
   * Filter the featured posts to return in life.
   *
   * @since life 1.0
   *
   * @param array|bool $posts Array of featured posts, otherwise false.
   */
  return apply_filters( 'life_get_featured_posts', array() );
}

/**
 * A helper conditional function that returns a boolean value.
 *
 * @since life 1.0
 *
 * @return bool Whether there are featured posts.
 */
function life_has_featured_posts() {
  return ! is_paged() && (bool) life_get_featured_posts();
}

/**
 * Register life widget areas.
 *
 * @since life 1.0
 */
function life_widgets_init() {
}
add_action( 'widgets_init', 'life_widgets_init' );



/**
 * Register testimonial post types.
 *
 * @since life 1.0
 */
function life_initialize_testimonials() {
  register_post_type('testimonial', [
    'labels' => [
      'name'           => 'Testimonials',
      'singular_name'     => 'Testimonial',
      'add_new_item'       => 'Add New Testimonial',
      'edit_item'       => 'Edit Testimonial',
      'new_item'         => 'New Testimonial',
      'view_item'       => 'View Testimonial',
      'search_items'       => 'Search Testimonials',
      'not_found'       => 'No testimonials found',
      'not_found_in_trash'   => 'No testimonials found in Trash',
      'view'          => 'View Testimonial'
    ],
    'menu_icon'          => 'dashicons-format-quote',
    'publicly_queryable'     => false,
    'exclude_from_search'     => true,
    'public'           => true,
    'rewrite'           => false,
    'supports'           => ['title', 'editor', 'page-attributes', 'custom-fields', 'thumbnail'],
    'taxonomies'         => []
  ]);
}
add_action('init', 'life_initialize_testimonials');



/**
 * Register resource post types.
 *
 * @since life 1.0
 */
function life_initialize_resources() {
  register_post_type('resource', [
    'labels' => [
      'name'           => 'Resources',
      'singular_name'     => 'Resource',
      'add_new_item'       => 'Add New Resource',
      'edit_item'       => 'Edit Resource',
      'new_item'         => 'New Resource',
      'view_item'       => 'View Resource',
      'search_items'       => 'Search Resources',
      'not_found'       => 'No resources found',
      'not_found_in_trash'   => 'No resources found in Trash',
      'view'          => 'View Resource'
    ],
    'menu_icon'          => 'dashicons-download',
    'publicly_queryable'     => false,
    'exclude_from_search'     => true,
    'public'           => true,
    'rewrite'           => false,
    'supports'           => ['title', 'editor', 'page-attributes', 'custom-fields', 'thumbnail'],
    'taxonomies'         => []
  ]);
}
add_action('init', 'life_initialize_resources');



/**
 * Register Poppins Google font for life.
 *
 * @since life 1.0
 *
 * @return string
 */
function life_font_url() {
  $font_url = '';
  /*
   * Translators: If there are characters in your language that are not supported
   * by Poppins, translate this to 'off'. Do not translate into your own language.
   */
  if ( 'off' !== _x( 'on', 'Poppins font: on or off', 'life' ) ) {
    $font_url = add_query_arg('family', urlencode('Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400;1,700'), "//fonts.googleapis.com/css2" );
  }

  return $font_url;
}

/**
 * Get our global testimonial list
 *
 * @since life 1.0
 *
 * @return string
 */
function life_global_testimonials() {
  $testimonials = [];

  $query = new WP_Query(['post_type' => 'testimonial', 'order' => 'ASC', 'orderby' => 'menu_order', 'posts_per_page' => 8]);

  while ( $query->have_posts() ) {
    $query->the_post();

    $testimonials[] = [
      'headline'        => get_the_title(),
      'image'          => get_field('image'),
      'quote'          => get_field('quote'),
      'attribution'      => get_field('attribution'),
      'attribution_type'    => get_field('attribution_type'),
      'attribution_company'  => get_field('attribution_company'),
    ];

    wp_reset_postdata();
  }

  return $testimonials;
}

/**
 * Get our resource list
 *
 * @since life 1.0
 *
 * @return string
 */
function life_resource_entries() {
  $resources = [];

  $query = new WP_Query(['post_type' => 'resource', 'order' => 'ASC', 'orderby' => 'menu_order', 'posts_per_page' => -1]);

  while ( $query->have_posts() ) {
    $query->the_post();

    $resources[get_the_ID()] = [
      'id'          => get_the_ID(),
      'title'       => get_the_title(),
      'content'     => get_the_content(),
      'image'       => get_the_post_thumbnail_url(null, 'resource-mini'),
      'file'        => get_field('resource_file'),
      'maxQty'      => get_field('max_quantity') ?? 50,
    ];

    wp_reset_postdata();
  }

  return $resources;
}

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since life-program 1.0
 */
// function mytheme_enqueue_scripts() {
//   $version = wp_get_theme()->get('Version');
//   $appEnv = env('APP_ENV', 'production');
//   if ($appEnv === 'dev') {
//     $vitePort = env('VITE_PORT', '5173');
//     $script_url = 'http://localhost:' . $vitePort;
//     wp_enqueue_script('THEME______LIFE', $script_url, ['type' => 'module'], null);
//   } else {
//     $script_url = get_template_directory_uri() . '/dist/main.js';
//     wp_enqueue_script('mytheme-script', $script_url, array(), $version, true);
//     $style_url = get_template_directory_uri() . '/dist/main.css';
//     wp_enqueue_style('mytheme-style', $style_url, array(), $version);
//   }
// }
// add_action('wp_enqueue_scripts', 'mytheme_enqueue_scripts');

function viteIncludes($srcFileName) {
  $appEnv = env('APP_ENV', 'production');
  if ($appEnv === 'dev') {
    $vitePort = env('VITE_PORT', '5173');
    return '<script type="module" src="http://localhost:' . $vitePort .'/' . $srcFileName . '"></script>';
  } else {
    $includes = '';
    $outDir = '/public/dist/';
    $urlDir = get_template_directory_uri() . $outDir;
    $manifest = json_decode(file_get_contents(__DIR__.$outDir.'.vite/manifest.json'), true);
    if (isset($manifest[$srcFileName])) {
      $props = $manifest[$srcFileName];
      $includes .= '<script rel="modulepreload" src="'. $urlDir . $props['file'] . '"></script>';
      foreach (($props['css'] ?? []) as $css) {
        $includes .= '<link rel="stylesheet" href="'. $urlDir . $css . '" type="text/css" >';
      }
    } else {
      $includes .= '<!-- no script in manifest named '.$srcFileName.' -->';
    }
    return $includes;
  }
}

/**
 * Enqueue Google fonts style to admin screen for custom header display.
 *
 * @since life 1.0
 */
function life_admin_fonts() {
}
add_action( 'admin_print_scripts-appearance_page_custom-header', 'life_admin_fonts' );

if ( ! function_exists( 'life_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since life 1.0
 */
function life_the_attached_image() {
  $post                = get_post();
  /**
   * Filter the default life attachment size.
   *
   * @since life 1.0
   *
   * @param array $dimensions {
   *     An array of height and width dimensions.
   *
   *     @type int $height Height of the image in pixels. Default 810.
   *     @type int $width  Width of the image in pixels. Default 810.
   * }
   */
  $attachment_size     = apply_filters( 'life_attachment_size', array( 810, 810 ) );
  $next_attachment_url = wp_get_attachment_url();

  /*
   * Grab the IDs of all the image attachments in a gallery so we can get the URL
   * of the next adjacent image in a gallery, or the first image (if we're
   * looking at the last image in a gallery), or, in a gallery of one, just the
   * link to that image file.
   */
  $attachment_ids = get_posts( array(
    'post_parent'    => $post->post_parent,
    'fields'         => 'ids',
    'numberposts'    => -1,
    'post_status'    => 'inherit',
    'post_type'      => 'attachment',
    'post_mime_type' => 'image',
    'order'          => 'ASC',
    'orderby'        => 'menu_order ID',
  ) );

  // If there is more than 1 attachment in a gallery...
  if ( count( $attachment_ids ) > 1 ) {
    foreach ( $attachment_ids as $attachment_id ) {
      if ( $attachment_id == $post->ID ) {
        $next_id = current( $attachment_ids );
        break;
      }
    }

    // get the URL of the next image attachment...
    if ( $next_id ) {
      $next_attachment_url = get_attachment_link( $next_id );
    }

    // or get the URL of the first image attachment.
    else {
      $next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
    }
  }

  printf( '<a href="%1$s" rel="attachment">%2$s</a>',
    esc_url( $next_attachment_url ),
    wp_get_attachment_image( $post->ID, $attachment_size )
  );
}
endif;

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since life 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function life_wp_title( $title, $sep ) {
  global $paged, $page;

  if ( is_feed() ) {
    return $title;
  }

  // Add the site name.
  $title .= get_bloginfo( 'name', 'display' );

  // Add the site description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );
  if ( $site_description && ( is_home() || is_front_page() ) ) {
    $title = "$title $sep $site_description";
  }

  // Add a page number if necessary.
  if ( $paged >= 2 || $page >= 2 ) {
    $title = "$title $sep " . sprintf( __( 'Page %s', 'life' ), max( $paged, $page ) );
  }

  return $title;
}
add_filter( 'wp_title', 'life_wp_title', 10, 2 );


// We don't want Contact Forms 7 wrapping elements
add_filter('wpcf7_form_elements', function($content) {
    $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);

    return $content;
});



/**
 * Get the specified $key POST variable, or return $default.
 *
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function life_post_var($key, $default = null) {
  if ( isSet($_POST[$key]) ) {
    return esc_attr(trim($_POST[$key]));
  }

  return $default;
}



/**
 * Obscure the passed $email address into entity encoded format.
 *
 * @param string $email
 * @return string
 */
function life_obscure_email($email) {
  $email_obfuscated = '';

  for ( $x = 0; $x < strlen($email); $x++ ) {
    $email_obfuscated .= '\\'.'u00'.base_convert(ord($email[$x]), 10, 16);
  }

  return $email_obfuscated;
}

/**
 * Return a phone number with all non-numeric characters stripped.
 *
 * @param string $phone
 * @return string
 */
function life_strip_phone($phone) {
  return preg_replace('/[^\+0-9]/', '', $phone);
}

/**
 * Get a value from a specified custom $field_name on the current page or fall back to interpreting
 * the except for the current page.
 *
 * @param string $field_name
 * @return string
 */
function life_custom_field_or_summary($field_name, $id = null) {
  $summary = get_field($field_name, $id);

  if ( !$summary ) {
    $summary = get_the_excerpt($id);
  }

  return $summary;
}

// So annoying...
add_filter('excerpt_more', function($more) {
    return '...';
});

add_filter('excerpt_length', function($length) {
    return 60;
});

add_action('pre_get_posts', function($query) {
  global $wp_the_query;

  if ( !is_admin() && ($query === $wp_the_query) && $query->is_search() ) {
    $query->set( 'posts_per_page', 9);
  }

  return $query;
});


/**
 * Attempt to load the passed custom field $key for the current page.
 * Return $default doesn't exist.
 *
 * @param string $property
 * @param string $block_id
 * @param mixed $default
 * @return mixed
 */
function life_get_page_field($key, $default = null) {
  if ( get_field($key) ) {
    return get_field($key);
  }

  return $default;
}


/**
 * Output an SVG-based icon.
 *
 * @param string $svg_filename
 * @param string $class
 * @param string $icon_class
 * @return string
 */
function life_icon($svg_filename, $class = null, $icon_class = '') {
  // Strip out everything we don't want by parsing it as a DOMDocument
  $svg = new DOMDocument();
  $svg->load(get_template_directory()."/images/icons/{$svg_filename}.svg");
  $filenameAsClass = str_replace('/', '-', $svg_filename);
  $svg->documentElement->setAttribute('class', $filenameAsClass.($class ? " {$class}" : ''));
  $svg->documentElement->setAttribute('fill', 'currentColor');
  $svg->documentElement->removeAttribute('id');

  return '<i class="icon '.$filenameAsClass.' '.$icon_class.'">'.$svg->saveXML($svg->documentElement).'</i>';
}

/**
 * Output an SVG-based image.
 *
 * @param string $svg_filename
 * @param string $class
 * @return string
 */
function life_svg($svg_filename, $class = null) {
  // Strip out everything we don't want by parsing it as a DOMDocument
  $svg = new DOMDocument();
  $svg->load(get_template_directory()."/images/{$svg_filename}.svg");

  return '<div class="svg-image">'.$svg->saveXML($svg->documentElement).'</div>';
}


/**
 * Add form notifications option page
 */
if( function_exists('acf_add_options_page') ) {
  add_action('acf/init', function() {
    $parent = acf_add_options_page(array(
        'page_title'  => __('Form Notifications'),
        'menu_title'  => __('Form Notifications'),
        'menu_slug'  => 'form-notifications',
        'redirect'    => false,
    ));
  });
}

/**
 * Allow rtf file type on media uploader
 */
add_filter('wp_check_filetype_and_ext', 'np_allow_rtf_mime_types', 99, 3);
function np_allow_rtf_mime_types($check, $file, $filename) {
  if(empty($check['ext']) || empty($check['type'])) {
    $rtfMimes = [
      ['rtf' => 'text/html'],
      ['rtf' => 'text/rtf'],
      ['rtf' => 'application/rtf'],
    ];

    foreach($rtfMimes as $mime) {
      remove_filter('wp_check_filetype_and_ext', 'np_allow_rtf_mime_types', 99);
      $mimeFilter = function($mimes) use ($mime) {
        return array_merge($mimes, $mime);
      };

      add_filter('upload_mimes', $mimeFilter, 99);
      $check = wp_check_filetype_and_ext( $file, $filename, $mime );
      remove_filter('upload_mimes', $mimeFilter, 99);
      if (!empty($check['ext']) || !empty($check['type'])) {
        return $check;
      }
    }
  }

  return $check;
}

if (defined('DISABLE_UPDATE_LANGUAGE_JSON') && DISABLE_UPDATE_LANGUAGE_JSON) {
  if( function_exists('add_filter') ){
    add_filter( 'auto_update_translation', '__return_false' );
  }
}

function incTemplate($name, $vars = []) {
  extract($vars);
  ob_start();
  include get_template_directory().'/partials/'.$name.'.php';
  return ob_get_clean();
}
function incTemplateShortcode($name, $vars = []) {
  extract($vars);
  ob_start();
  include get_template_directory().'/inc/template/'.$name.'.php';
  return ob_get_clean();
}
function echoTemplate($name, $vars = []) {
  echo incTemplate($name, $vars);
}

function italizeLifeText($text) {
  return preg_replace(
    '#Life\!#si', '<em>Life!</em>',
    $text
  );
}

require get_template_directory().'/inc/navigation.php';
require get_template_directory().'/inc/lang.php';
require get_template_directory().'/inc/moderate-risk.php';
require get_template_directory().'/inc/our-team.php';
require get_template_directory().'/inc/content-banners.php';
require get_template_directory().'/inc/benefits.php';
require get_template_directory().'/inc/footer-cta-banner.php';
require get_template_directory().'/inc/share-modal.php';
require get_template_directory().'/inc/health-check-api.php';
require get_template_directory().'/inc/service-locator.php';

/**
 * AJAX handler to update Salesforce Lead phone number by email
 */
add_action('wp_ajax_life_update_lead_phone', 'life_ajax_update_lead_phone');
add_action('wp_ajax_nopriv_life_update_lead_phone', 'life_ajax_update_lead_phone');

function life_ajax_update_lead_phone() {
    // Check if email and phone are provided
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    
    if (empty($email)) {
        wp_send_json_error([
            'message' => 'Email is required.'
        ]);
        return;
    }
    
    if (empty($phone)) {
        wp_send_json_error([
            'message' => 'Phone number is required.'
        ]);
        return;
    }
    
    // Validate email format
    if (!is_email($email)) {
        wp_send_json_error([
            'message' => 'Invalid email format.'
        ]);
        return;
    }
    
    // Query Salesforce for Lead by email
    $lead = \SfFuncs\queryLeadByEmail($email);
    
    if (!$lead || !isset($lead['Id'])) {
        wp_send_json_error([
            'message' => 'Lead not found with the provided email address.'
        ]);
        return;
    }
    
    // Prepare data for update (Phone field in Salesforce)
    $sf_data = [
        'Phone' => $phone
    ];
    
    // Update Lead in Salesforce
    $errors = \SfFuncs\updateLeadById($lead['Id'], $sf_data);
    
    if (empty($errors)) {
        wp_send_json_success([
            'message' => 'Phone number updated successfully.',
            'leadId' => $lead['Id']
        ]);
    } else {
        $errorMessage = isset($errors[0]['message']) 
            ? $errors[0]['message'] 
            : 'Failed to update phone number in Salesforce.';
        
        wp_send_json_error([
            'message' => $errorMessage,
            'errors' => $errors
        ]);
    }
}

add_action( 'wp_enqueue_scripts', function () {
  wp_dequeue_style( 'wp-block-library' );
});

// Enqueue Block Editor styles
add_action('enqueue_block_editor_assets', function () {
  wp_enqueue_style('example-editor', get_template_directory_uri() . '/editor.css', array('wp-edit-blocks'));
});

// Enqueue Block Editor script
add_action('enqueue_block_editor_assets', function () {
  wp_enqueue_script('your-theme-editor-customisations', get_template_directory_uri() . '/editor.js', array('wp-edit-post', 'wp-blocks', 'wp-dom-ready'), '', true);
});


function life_guttenberg_enqueue_styles() {
  wp_enqueue_style( 'gutenberg-block-styles', includes_url( 'css/dist/block-library/style.min.css' ), array(), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'life_guttenberg_enqueue_styles' );

// Define AUTOFILL_CONTACT_FORM constant if not already defined
if (!defined('AUTOFILL_CONTACT_FORM')) {
    define('AUTOFILL_CONTACT_FORM', false);
}

function vueProp($val, $mapFunc = null) {
  if ($mapFunc) {
    return htmlentities(json_encode(array_map($mapFunc, $val)));
  } else {
    return htmlentities(json_encode($val));
  }
}
function selectOpts($val, $associative, $placeholder = null) {
  $opts = [];
  if ($placeholder !== null) {
    $opts[] = [
      'text' => $placeholder,
      'val' => '',
    ];
  }
  foreach ($val as $val => $text) {
    $opts[] = [
      'text' => $text,
      'val' => ($associative ? $val : $text),
    ];
  }
  return ['value' => $opts];
}

function thumbnail($size, $placeholder, $post = null) {
  if ($image = get_the_post_thumbnail_url($post, $size)) {
    return $image;
  } else {
    return get_template_directory_uri().'/images/placeholders/'.$placeholder;
  }
}

function postCategories($postId) {
  return array_reduce(get_the_category($postId), function($acc, $cat) {
    $acc[$cat->slug] = $cat->name;
    return $acc;
  }, []);
}
function blogCategories($justLabel = false) {
  static $cats = [
    [
      'slug' => 'all',
      'navButtonText' => 'Discover All',
      'unfiltered' => true,
    ],
    [
      'slug' => 'fact-sheet',
      'label' => 'Fact Sheet',
      'navButtonText' => 'Fact Sheets',
    ],
    [
      'slug' => 'article',
      'label' => 'Article',
      'navButtonText' => 'Articles',
    ],
    [
      'slug' => 'recipe',
      'label' => 'Recipe',
      'navButtonText' => 'Recipes',
    ],
  ];
  static $catsAssoc = null;
  if ($justLabel) {
    if ($catsAssoc === null) {
      $catsAssoc = [];
      foreach ($cats as $cat) {
        if ($cat['unfiltered'] ?? false) {
          continue;
        }
        $catsAssoc[$cat['slug']] = $cat['label'];
      }
    }
    return $catsAssoc;
  } else {
    return $cats;
  }
}
function blogCategoryLabels($categories) {
  $labels = [];
  foreach (blogCategories(true) as $slug => $label) {
    if (isset($categories[$slug])) {
      $labels[] = $label;
    }
  }
  return count($labels) ? implode(', ', $labels) : 'Blog';
}


function _dumpSingle($val) {
  echo '<pre style="background: #222; color: #fff; padding: 10px;overflow-x: auto">';
  // print_r(htmlentities(str_replace('"', '', json_encode($val, JSON_PRETTY_PRINT))));
  print_r(htmlentities(var_export($val, true)));
  // print_r($val);
  echo '</pre>';
}

function dump(...$vals) {
  if (env('APP_ENV', 'production') === 'production') {
    return true;
  }
  foreach ($vals as $val) {
    _dumpSingle($val);
  }
}
function dd(...$vals) {
  dump(...$vals);
  exit;
}

function slugify($str) {
  return str_replace(' ', '-', preg_replace('/ +/', ' ', preg_replace('/[^a-zA-Z0-9 ]/', '', strtolower($str))));
}

function contentTabsNavProp($tabs) {
  return array_map(fn($tab) => [
    'title' => apply_filters('the_brand', $tab['title']),
    'slug' => slugify($tab['title']),
    'type' => $tab['content_type'] ?? null,
    'href' => $tab['link_to'] ?? null,
    'flows_steps' => is_array($tab['flows'] ?? null)
      ? array_map(fn($flow) => ['num_of_steps' => (is_array($flow['steps'] ?? null) ? count($flow['steps']) : 0), 'slug' => slugify($flow['title'])], $tab['flows'])
      : null,
  ], $tabs);
}


function pageIsGestational() {
  static $isPage = null;
  if ($isPage === null) {
    $isPage = get_field('right_side_fixed_panel_for_health_checks') === 'no_panel_gestational';
  }
  return $isPage;
}

function pageIsPcos() {
  static $isPage = null;
  if ($isPage === null) {
    $isPage = get_field('right_side_fixed_panel_for_health_checks') === 'no_panel_pcos';
  }
  return $isPage;
}

/**
 * ================= TomYSN fucntions =================
 */

function life_enqueue_main() {
  $theme_dir = get_template_directory_uri();
  $theme_ver = time();
  wp_enqueue_style('life-main-css', $theme_dir . '/assets/css/main.css', array(), $theme_ver, 'all');
  wp_enqueue_script('life-main-js', $theme_dir . '/assets/js/main.js', array('jquery'), $theme_ver, true);
  
  // Localize script with AJAX URL
  wp_localize_script('life-main-js', 'lifeAjax', array(
    'ajaxurl' => admin_url('admin-ajax.php')
  ));
}
add_action('wp_enqueue_scripts', 'life_enqueue_main');


function life_breadcrumbs() {
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
  <div id="breadcrumbs">
    <ul>
      <?php foreach ($ancestors as $idx => $ancestor): ?>
        <?php
          // Wrap 'Life!' in <em> if present in the title.
          $title = $ancestor->title;
          if (strpos($title, 'Life!') !== false) {
            $title = str_replace('Life!', '<em style="margin-right:5px;">Life!</em>', $title);
          }
        ?>
        <?php if ($idx == (count($ancestors) - 1)): ?>
          <li><?php echo $title; ?></li>
        <?php else: ?>
          <li><a href="<?= $ancestor->url ?>"><?php echo $title; ?></a></li>
        <?php endif ?>
      <?php endforeach ?>
    </ul>
  </div>
<?php
}
