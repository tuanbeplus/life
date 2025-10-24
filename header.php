<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage life
 * @since life 1.0
 */

$has_current_nav = ($_SERVER['REQUEST_URI'] != '/');

// Work out the post ancestry
$post = get_post();
$parent_path_items = [$post->ID];

while ( $post->post_parent ) {
  $post = get_post($post->post_parent);
  $parent_path_items[] = $post->ID;
}
wp_reset_postdata();

?><!DOCTYPE html>
<html lang="<?= pageLang()->lang ?>">
  <head>
    <script>
    window.dataLayer = window.dataLayer || [];
    </script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer', '<?= defined('GTM_ID') ? GTM_ID : 'GTM-WDNW5H7' ?>');</script>
    <!-- End Google Tag Manager -->
    <title><?php wp_title( '|', true, 'right' ) ?></title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="preconnect" href="https://www.google.com/" crossorigin />
    <link rel="preconnect" href="https://www.google.com.au/" crossorigin />
    <link rel="preconnect" href="https://www.google-analytics.com/" crossorigin />
    <link rel="preconnect" href="https://www.googletagmanager.com/" crossorigin />

    <!-- <link rel="manifest" href="/manifest.json" /> -->
    <meta name="theme-color" content="#f47b20" />

    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?= get_template_directory_uri() ?>/images/favicon/ati-57.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= get_template_directory_uri() ?>/images/favicon/ati-114.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= get_template_directory_uri() ?>/images/favicon/ati-72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= get_template_directory_uri() ?>/images/favicon/ati-144.png" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?= get_template_directory_uri() ?>/images/favicon/ati-120.png" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?= get_template_directory_uri() ?>/images/favicon/ati-152.png" />
    <link rel="icon" type="image/png" href="<?= get_template_directory_uri() ?>/images/favicon/196.png" sizes="196x196" />
    <link rel="icon" type="image/png" href="<?= get_template_directory_uri() ?>/images/favicon/96.png" sizes="96x96" />
    <link rel="icon" type="image/png" href="<?= get_template_directory_uri() ?>/images/favicon/32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?= get_template_directory_uri() ?>/images/favicon/16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="<?= get_template_directory_uri() ?>/images/favicon/128.png" sizes="128x128" />
    <meta name="application-name" content="life"/>
    <meta name="msapplication-TileColor" content="#F7F7F7" />
    <meta name="msapplication-TileImage" content="<?= get_template_directory_uri() ?>/images/favicon/mstile-144x144.png" />
    <?= viteIncludes('app.js') ?>
    <?php wp_head() ?>
    <style>
      [v-cloak] {
        opacity: 0 !important;
      }
      #app {
        transition: opacity 0.6s;
        transition-delay: 0.5s;
      }
    </style>
  </head>

  <body class="page-<?= get_the_ID() ?> <?= $args['bodyClass'] ?? '' ?>">
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WDNW5H7" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <div id="app" v-cloak>
      <div id="wrapper">
        <?= incTemplate('top-nav/top-nav') ?>
