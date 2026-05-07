<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package zoilo-rios
 */

get_header();
?>

	<main id="primary" class="site-main">

		<div class="entry-content wp-block-post-content has-global-padding is-layout-constrained">

			<div class="breadcrumbs has-global-padding">
				<?php if (function_exists("rank_math_the_breadcrumbs")) rank_math_the_breadcrumbs(); ?>
			</div>

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Ups, se ha acabado la gasolina.', 'zoilo-rios' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'Parece que no podemos encontrar la página solicitada. Tal vez pueda ayudar usar los siguientes enlaces o el cuadro de búsqueda.', 'zoilo-rios' ); ?></p>

						<?php
						get_search_form();

						the_widget( 'WP_Widget_Recent_Posts' );
						?>

						<div class="widget widget_categories">
							<h2 class="widget-title"><?php esc_html_e( 'Categorías más usadas', 'zoilo-rios' ); ?></h2>
							<ul>
								<?php
								wp_list_categories(
									array(
										'orderby'    => 'count',
										'order'      => 'DESC',
										'show_count' => 1,
										'title_li'   => '',
										'number'     => 10,
									)
								);
								?>
							</ul>
						</div><!-- .widget -->

						<?php
						/* translators: %1$s: smiley */
						$smn_hybrid_archive_content = '<p>' . sprintf( esc_html__( 'Intenta buscar en los archivos mensuales. %1$s', 'zoilo-rios' ), convert_smilies( ':)' ) ) . '</p>';
						the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$smn_hybrid_archive_content" );

						the_widget( 'WP_Widget_Tag_Cloud' );
						?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</div><!-- .entry-content -->

	</main><!-- #main -->

<?php
get_footer();
