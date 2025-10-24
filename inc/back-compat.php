<?php
/**
 * life back compat functionality
 *
 * Prevents life from running on WordPress versions prior to 3.6,
 * since this theme is not meant to be backward compatible beyond that
 * and relies on many newer functions and markup changes introduced in 3.6.
 *
 * @package WordPress
 * @subpackage life
 * @since life 1.0
 */

/**
 * Prevent switching to life on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since life 1.0
 */
function life_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'life_upgrade_notice' );
}
add_action( 'after_switch_theme', 'life_switch_theme' );

/**
 * Add message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * life on WordPress versions prior to 3.6.
 *
 * @since life 1.0
 */
function life_upgrade_notice() {
	$message = sprintf( __( 'life requires at least WordPress version 3.6. You are running version %s. Please upgrade and try again.', 'life' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevent the Theme Customizer from being loaded on WordPress versions prior to 3.6.
 *
 * @since life 1.0
 */
function life_customize() {
	wp_die( sprintf( __( 'life requires at least WordPress version 3.6. You are running version %s. Please upgrade and try again.', 'life' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'life_customize' );

/**
 * Prevent the Theme Preview from being loaded on WordPress versions prior to 3.4.
 *
 * @since life 1.0
 */
function life_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'life requires at least WordPress version 3.6. You are running version %s. Please upgrade and try again.', 'life' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'life_preview' );
