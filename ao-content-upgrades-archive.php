<?php
/**
 * Plugin Name:       Content Upgrades Archive
 * Description:       Display all Content Upgrades by Audience Ops on a single page.
 * Version:           1.0.0
 * Author:            AudioTheme
 * Author URI:        https://audiotheme.com
 * Text Domain:       aops-content-upgrades-archive
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Set a constant path to the plugin's root directory.
 */
if ( ! defined( 'AOCU_ARCHIVE_DIR' ) ) {
	define( 'AOCU_ARCHIVE_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * Set a constant URL to the plugin's root directory.
 */
if ( ! defined( 'AOCU_ARCHIVE_URL' ) ) {
	define( 'AOCU_ARCHIVE_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * Load functions and libraries.
 */
require( AOCU_ARCHIVE_DIR . 'includes/general-template.php' );

/**
 * Load the plugin.
 */
function aocu_archive_init() {
	if ( class_exists( 'Aops' ) ) {
		require_once( AOCU_ARCHIVE_DIR . 'includes/class.AopsContentUpgradesArchive.php' );

		$aopsContentUpgradesArchive = new AopsContentUpgradesArchive();
		$aopsContentUpgradesArchive->load();
	}
}
add_action( 'plugins_loaded', 'aocu_archive_init' );
