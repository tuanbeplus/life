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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

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
    <script>
      (function () {
        "use strict";

        var redirected = false;

        /* ===============================
        * HASH → URL MAP (EXACT MATCH)
        * =============================== */
        var map = {
          "#health-check": "<?php echo home_url('/health-check/'); ?>",
          "#health-check-chinese-simplified": "<?php echo home_url('/health-check/chinese-simplified/'); ?>",
          "#health-check-chinese-traditional": "<?php echo home_url('/health-check/chinese-traditional/'); ?>",
          "#health-check-arabic": "<?php echo home_url('/health-check/arabic/'); ?>",
          "#health-check-vietnamese": "<?php echo home_url('/health-check/vietnamese/'); ?>"
        };

        /* ===============================
        * SAFE REDIRECT FUNCTION
        * =============================== */
        function redirectTo(url) {
          if (redirected) return;
          redirected = true;

          var qs = window.location.search || "";
          window.location.replace(url + qs);
        }

        /* ===============================
        * ON LOAD — HASH ONLY
        * =============================== */
        var hash = window.location.hash.toLowerCase();
        if (map.hasOwnProperty(hash)) {
          redirectTo(map[hash]);
          return;
        }
        /* ===============================
        * CLICK HANDLER — HASH LINKS (FULL URL SAFE)
        * =============================== */
        document.addEventListener("click", function (e) {
          if (e.button !== 0) return;

          var link = e.target.closest("a");
          if (!link) return;

          if (
            link.target === "_blank" ||
            link.hasAttribute("download") ||
            link.hasAttribute("data-no-redirect")
          ) {
            return;
          }

          var href = link.getAttribute("href");
          if (!href) return;

          var hash = "";

          /* CASE 1: href="#health-check" */
          if (href.charAt(0) === "#") {
            hash = href.toLowerCase();
          }

          /* CASE 2: full URL with hash */
          else {
            try {
              var url = new URL(href, window.location.origin);

              /* only same-origin URLs */
              if (url.origin !== window.location.origin) return;

              hash = url.hash.toLowerCase();
            } catch (err) {
              return;
            }
          }

          if (!hash || !map.hasOwnProperty(hash)) return;

          e.preventDefault();
          e.stopImmediatePropagation();

          redirectTo(map[hash]);
        }, true);

        /* ===============================
        * BUTTON HANDLER — LANGUAGE AWARE
        * =============================== */
        document.addEventListener("click", function (e) {
          if (e.button !== 0) return;

          var btn = e.target.closest(".health-check-trigger .-button");
          if (!btn) return;

          var trigger = btn.closest(".health-check-trigger");
          if (!trigger) return;

          e.preventDefault();
          e.stopImmediatePropagation();

          /* ENGLISH */
          if (trigger.classList.contains("-lang-en")) {
            redirectTo("<?php echo home_url('/health-check/'); ?>");
            return;
          }

          /* CHINESE (ORDER BASED) */
          if (trigger.classList.contains("-lang-zh")) {
            var langBlock = btn.closest(".-lang");
            if (!langBlock) return;

            var langBlocks = trigger.querySelectorAll(".-lang");

            if (langBlocks[0] === langBlock) {
              redirectTo("<?php echo home_url('/health-check/chinese-simplified/'); ?>");
              return;
            }

            if (langBlocks[1] === langBlock) {
              redirectTo("<?php echo home_url('/health-check/chinese-traditional/'); ?>");
              return;
            }

            return;
          }

          /* ARABIC */
          if (trigger.classList.contains("-lang-ar")) {
            redirectTo("<?php echo home_url('/health-check/arabic/'); ?>");
            return;
          }

          /* VIETNAMESE */
          if (trigger.classList.contains("-lang-vi")) {
            redirectTo("<?php echo home_url('/health-check/vietnamese/'); ?>");
            return;
          }

        }, true);

      })();
    </script>
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
