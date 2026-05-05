<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package zoilo-rios
 */

get_header();
?>

	<main id="primary" class="site-main">
		
		<?php 
	 		$block = get_page_by_title( 'Hero Single', OBJECT, 'wp_block' );
                if ( $block ) {
                    $block_content = apply_filters( 'the_content', $block->post_content );
                    echo $block_content;
                }
		?>

		<div class="breadcrumbs has-global-padding">
            <?php if (function_exists("rank_math_the_breadcrumbs")) rank_math_the_breadcrumbs(); ?>
        </div>

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() ); ?>

			<div class="has-global-padding is-layout-constrained">
				<?php the_post_navigation(
					array(
						'prev_text' => '<div class="nav-subtitle">' . esc_html__( 'Anterior:', 'zoilo-rios' ) . '</div> <div class="nav-title">%title</div>',
						'next_text' => '<div class="nav-subtitle">' . esc_html__( 'Siguiente:', 'zoilo-rios' ) . '</div> <div class="nav-title">%title</div>',
					)
				); ?>
			</div>

		<?php
		
		endwhile; // End of the loop.

			get_template_part( 'template-parts/related', 'post' );
		?>

	</main><!-- #main -->

<?php
get_footer();

