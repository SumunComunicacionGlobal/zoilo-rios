<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package zoilo-rios
 */

?>

	<footer id="colophon" class="site-footer">

		<?php
			$block = get_page_by_title( 'Footer Global', OBJECT, 'wp_block' );

			if ( $block ) {
				echo apply_filters( 'the_content', $block->post_content );
			}
		?>

	</footer><!-- #colophon -->

	<button id="back-to-top" class="back-to-top btn-icon has-primary-background-color" type="button" aria-label="<?php echo esc_attr__( 'Volver arriba', 'zoilo-rios' ); ?>">
		<?php echo file_get_contents( get_template_directory() . '/assets/icons/chevron-up.svg' ); ?>
	</button>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
