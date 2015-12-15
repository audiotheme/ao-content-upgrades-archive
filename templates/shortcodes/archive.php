<?php
/**
 * Template to display a Content Upgrades Archive shortcode.
 *
 * @package ContentUpgradesArchive\Template
 * @since 1.0.0
 */

if ( $loop->have_posts() ) :
?>

	<div class="cu-archive-wrapper">

		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

			<?php
			$aops = new Aops;
			$meta = $aops::getMeta( get_the_ID() );
			?>

			<div id="content-upgrade-<?php the_ID(); ?>" class="cu-wrapper">
				<div class="cu-content">
					<h3 class="cu-headline"><?php echo apply_filters( 'the_title', $meta['headline'] ); ?></h3>

					<?php echo wpautop( $meta['description'] ); ?>
				</div>

				<div class="cu-button">
					<a class="button button-primary button-large" href="<?php echo esc_url( $meta['bonus_content_path'] ); ?>"><?php echo esc_html( $meta['button_text'] ); ?></a>
				</div>
			</div>

		<?php endwhile; ?>

	</div>

<?php
endif;
