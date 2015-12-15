<?php
/**
 * General template tags and functions.
 *
 * @package   ContentUpgradesArchive\Template
 * @copyright Copyright 2015 AudioTheme
 * @license   GPL-2.0+
 * @link      https://audiotheme.com/
 * @since     1.0.0
 */

/**
 * Retrieve the name of the highest priority template file that exists.
 *
 * Searches in the STYLESHEETPATH before TEMPLATEPATH so that themes which
 * inherit from a parent theme can just overload one file. Falls back to
 * the built-in template.
 *
 * @since 1.0.0
 * @see locate_template()
 *
 * @param string|array $template_names Template file(s) to search for, in order.
 * @param bool         $load If true the template file will be loaded if it is found.
 * @param bool         $require_once Whether to require_once or require. Default true. Has no effect if $load is false.
 * @return string The template path if one is located.
 */
function aocu_archive_locate_template( $template_names, $load = false, $require_once = true ) {
	$template = '';

	foreach ( (array) $template_names as $template_name ) {
		if ( ! $template_name ) {
			continue;
		}

		if ( file_exists( get_stylesheet_directory() . '/content-upgrades/' . $template_name ) ) {
			$template = get_stylesheet_directory() . '/content-upgrades/' . $template_name;
			break;
		} elseif ( is_child_theme() && file_exists( get_template_directory() . '/content-upgrades/' . $template_name ) ) {
			$template = get_template_directory() . '/content-upgrades/' . $template_name;
			break;
		} elseif ( file_exists( AOCU_ARCHIVE_DIR . 'templates/' . $template_name ) ) {
			$template = AOCU_ARCHIVE_DIR . 'templates/' . $template_name;
			break;
		}
	}

	if ( $load && ! empty( $template ) ) {
		load_template( $template, $require_once );
	}

	return $template;
}

/**
 * Load a template file.
 *
 * @since 1.0.0
 *
 * @param string|array $template_file Absolute path to a file or list of template parts.
 * @param array        $data Optional. List of variables to extract into the template scope.
 * @param bool         $locate Optional. Whether the $template_file argument should be located. Default false.
 * @param bool         $require_once Optional. Whether to require_once or require. Default false.
 */
function aocu_archive_load_template( $template_file, $data = array(), $locate = false, $require_once = false ) {
	if ( is_array( $data ) && ! empty( $data ) ) {
		extract( $data, EXTR_SKIP );
		unset( $data );
	}

	// Locate the template file specified as the first parameter.
	if ( $locate ) {
		$template_file = aocu_archive_locate_template( $template_file );
	}

	if ( $require_once ) {
		require_once( $template_file );
	} else {
		require( $template_file );
	}
}

/**
 * Determine if a template file is being loaded from the plugin.
 *
 * @since 1.0.0
 *
 * @param string $template Template path.
 * @return bool
 */
function aocu_archive_is_default_template( $template ) {
	return ( false !== strpos( $template, AOCU_ARCHIVE_DIR ) );
}
