<?php
require get_template_directory().'/inc/content-banners/contentBannerProps.php';
require get_template_directory().'/inc/content-banners/ContentBanner.php';


if( function_exists('acf_add_options_page') ) {
    add_action('acf/init', function() {
        acf_add_options_page(
            [
                'page_title'  => __('Content banners'),
                'menu_title'  => __('Content banners'),
                'menu_slug'  => 'content-banners',
                'redirect'    => false,
            ],
        );
    });
}




add_shortcode( 'banner', function( $atts ) {
    static $bannerTypes = []; // acfOptionName => ContentBannerType
    $errMessage = '';
    $props = null;
    $html = null;
    $slug = $atts['slug'] ?? '?';
    try {
        $props = contentBannerProps($atts);
    } catch (Exception $e) {
        $errMessage = $e->getMessage();
    }
    if ($props) {
        $acfOptionName = $props['acfOptionName'];
        $id = $props['id'];
        if ( ! isset($bannerTypes[$acfOptionName]) ) {
            $bannerTypes[$acfOptionName] = (new ContentBannerType(
                $props['title'],
                $props['template'],
                $acfOptionName,
                $props['vars']
            ))->fetchBanners();
        }
        $banner = $bannerTypes[$acfOptionName]->banners[$id] ?? null;
        if ($banner) {
            $html = $banner->templated();
        }
    }
    if ($html === null) {
        $type = isset($props) ? ' > ' . $props['title'] : '';
        return (current_user_can('administrator'))
            ? "<h5><br><br>Cannot find a row in <code style=\"font-size: 18px;padding: 0 10px\">Content banners{$type}</code> with slug: <code style=\"font-size: 18px;padding: 0 10px\">{$slug}</code><br><br>{$errMessage}<br><br></h5>"
            : '';
    } else {
        return $html;
    }
});


