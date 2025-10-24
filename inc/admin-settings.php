<?php

/**
 * Add the WF settings option to our menus
 */
function life_theme_admin_menus() {
	add_submenu_page('options-general.php', 
					 'Life! Settings',
					 'Life! Settings',
					 'manage_options',
					 'theme-settings',
					 'life_theme_settings'
				    );
}
add_action("admin_menu", "life_theme_admin_menus");



/**
 * Handle the settings page layout
 */
function life_theme_settings() {
	global $wpdb;
	$feedback = array();
	
    if ( !current_user_can('manage_options') ) {
		wp_die('You do not have sufficient permissions to access this page.');
	}
	
	// Submitted?
	if ( isset($_POST["life_settings_save"]) ) {
		update_option("life_facebook_link", life_post_var('life_facebook_link'));
		update_option("life_linkedin_link", life_post_var('life_linkedin_link'));
		update_option("life_instagram_link", life_post_var('life_instagram_link'));
	}
?>

    <div class="wrap">
        <?php screen_icon('themes'); ?> <h2>Life! Program Settings</h2>

        <form method="POST" action="" enctype="multipart/form-data">
			
            <table class="form-table">
				
                <tr valign="top">
                    <th scope="row">
						<label for="es_life_facebook_link">
							Facebook Link
						</label> 
                    </th>
                    <td>
						<input type="text" name="life_facebook_link" id="es_life_facebook_link" value="<?php echo get_option("life_facebook_link"); ?>" />
                    </td>
                </tr>
				
                <tr valign="top">
                    <th scope="row">
						<label for="es_life_linkedin_link">
							LinkedIn Profile
						</label> 
                    </th>
                    <td>
						<input type="text" name="life_linkedin_link" id="es_life_linkedin_link" value="<?php echo get_option("life_linkedin_link"); ?>" />
                    </td>
                </tr>
				
                <tr valign="top">
                    <th scope="row">
						<label for="es_life_instagram_link">
							Instagram Link
						</label> 
                    </th>
                    <td>
						<input type="text" name="life_instagram_link" id="es_life_instagram_link" value="<?php echo get_option("life_instagram_link"); ?>" />
                    </td>
                </tr>
				
            </table>
			
			<p>
				<input type="hidden" name="life_settings_save" value="Y" />
				<input type="submit" value="Save Settings" class="button-primary" />
			</p>
			
        </form>
		
    </div>

<?php
}