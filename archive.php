<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package zoilo-rios
 */

get_header();
?>

	<main id="primary" class="site-main">

	 	<?php 
	 		$block = get_page_by_title( 'Hero Archive', OBJECT, 'wp_block' );
                if ( $block ) {
                    $block_content = apply_filters( 'the_content', $block->post_content );
                    echo $block_content;
                }
		?>

		<div class="breadcrumbs has-global-padding">
            <?php if (function_exists("rank_math_the_breadcrumbs")) rank_math_the_breadcrumbs(); ?>
        </div>

		<div class="entry-content wp-block-post-content has-global-padding is-layout-constrained wp-block-post-content-is-layout-constrained">

			<?php
			if ( have_posts() ) :

				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					/*
					* Include the Post-Type-specific template for the content.
					* If you want to override this in a child theme, then include a file
					* called content-___.php (where ___ is the Post Type name) and that will be used instead.
					*/
					get_template_part( 'template-parts/loop', get_post_type() );

				endwhile;

				the_posts_navigation();

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>
		</div><!-- .entry-content -->

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
