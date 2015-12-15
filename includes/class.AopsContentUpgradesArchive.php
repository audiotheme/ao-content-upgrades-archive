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
 * Main plugin class.
 */
class AopsContentUpgradesArchive extends Aops {
	/**
	 * Load the plugin.
	 */
	public function load() {
		add_action( 'init', array( $this, 'register_shortcode' ) );
	}

	/**
	 * Registers the [content_upgrades_archive] shortcode.
	 */
	public function register_shortcode() {
		add_shortcode( 'content_upgrades_archive', array( $this, 'do_shortcode' ) );
	}

	/**
	 * Returns the content of the column shortcode.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array  $atts The user-inputted arguments.
	 * @param  string $content The content to wrap in a shortcode.
	 * @return string
	 */
	public function do_shortcode( $atts ) {
		/* Set up the default arguments. */
		$defaults = apply_filters(
			'ao_content_upgrades_archive_defaults',
			array(
				'order'   => 'DESC',
				'orderby' => 'menu_order',
				'count'   => 20,
				'include' => '',
				'exclude' => '',
				'before'  => '',
				'after'   => '',
				'type'    => '',
			)
		);

		$args = shortcode_atts( $defaults, $atts );
		$args = apply_filters( 'ao_content_upgrades_archive_args', $args );

		$loop_args = array(
			'post_type'      => self::$postTypeName,
			'order'          => $args['order'],
			'orderby'        => $args['orderby'],
			'posts_per_page' => ( empty( $args['count'] ) ) ? 20 : $args['count'],
		);

		if ( ! empty( $args['include'] ) ) {
			$loop_args['post__in'] = array( $args['include'] );
		} elseif ( ! empty( $args['exclude'] ) ) {
			$loop_args['post__not_in'] = array( $args['exclude'] );
		}

		$data         = array();
		$data['args'] = $args;
		$data['loop'] = new WP_Query( $loop_args );

		$templates = array();
		if ( ! empty( $args['type'] ) ) {
			$templates[] = "shortcodes/archive-{$args['type']}.php";
		}
		$templates[] = 'shortcodes/archive.php';

		$output = $args['before'];

		ob_start();
		$template = aocu_archive_locate_template( $templates );
		aocu_archive_load_template( $template, $data );
		$output .= ob_get_clean();

		$output .= $args['after'];

		return $output;
	}
}
