<?php

if ( ! function_exists('data_attr')) {
    function data_attr($name, $data) {
        return sprintf('data-%s="%s"', $name, htmlentities(json_encode($data)));
    }
}

if ( ! function_exists('opt')) {
    function opt($option_group, $option_name, $default = null) {
        $options = get_option($option_group);
        return $options[$option_name] ?? $default;
    }
}

function moderate_risk_accepted_regions($encoded = true) {
    $str = opt('moderate_risk_options', 'accepted_regions', '');
    $output = [];
    foreach (explode("\n", $str) as $line) {
        $split = explode(' ', trim($line));
        $output[] = [array_shift($split), implode(' ', $split)];
    }
    return $encoded
        ? htmlentities(json_encode($output))
        : $output;
}

// if( function_exists('acf_add_options_page') ) {
//     acf_add_options_page();
// }
add_action('admin_init', function() {
    register_setting('moderate_risk_options', 'moderate_risk_options', function($post){
        return $post;
    });
    add_settings_section( 'moderate_risk_options_general', 'General', function() {}, 'moderate_risk' );
    add_settings_field('accepted_regions', 'Accepted regions', function() {
        $options = get_option( 'moderate_risk_options' );
        ?><label>
            <p style="margin-top: 4px">postcode, a space then suburb name; one per line</p>
            <textarea
                name="moderate_risk_options[accepted_regions]"
                style="width: 300px; height: 600px; font-family: monospace"
            ><?= $options['accepted_regions'] ?? "2213 Picnic Point\n2550 Yambulla\n" ?></textarea>
        </label><?php
    }, 'moderate_risk', 'moderate_risk_options_general');
});

add_action('admin_menu', function() {
    
    add_options_page(
        'Moderate Risk Options',
        'Moderate Risk Options',
        'manage_options',
        'moderate_risk_options',
        function() {
            ?><div class="wrap">
                <h1>Moderate Risk Test Options</h1>
                <form method="post" action="options.php">
                    <?php //wp_nonce_field('update-options') ?>
                    <!-- <p>
                        <input
                            type="submit"
                            name="Submit"
                            value="Save Changes"
                            style="height: 60px; border: none; background: #0073aa; color: #fff; font-size: 20px;padding: 5px 30px;cursor: pointer;"
                        />
                    </p>
                    <input type="hidden" name="action" value="update" />
                    <input type="hidden" name="page_options" value="moderate_risk_options" /> -->
                    <?php
                    settings_fields('moderate_risk_options');
                    do_settings_sections('moderate_risk');
                    submit_button();
                    ?>
                </form>
            </div><?php
        }
    );
});




add_shortcode( 'health-check-start', function( $atts ) {
    returnincTemplate('shortcodes/health-check-start', []);
});




