<?php
/**
 * The template for displaying proyecto CTP pages
 *
 * This is the template that displays proyecto CTP pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package zoilo-rios
 */

get_header();
?>
	<main id="primary" class="site-main">
		
		<?php 
	 		$block = get_page_by_title( 'Hero Proyecto', OBJECT, 'wp_block' );
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

			get_template_part( 'template-parts/content', 'servicios' );

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();

<?php
/**
 * The template for displaying particular CTP pages
 *
 * This is the template that displays particular CTP pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package zoilo-rios
 */

get_header();
?>
	<main id="primary" class="site-main">
		
		<?php get_template_part( 'template-parts/hero-mini' ); ?>
        
		<div class="breadcrumbs has-global-padding">
            <?php if (function_exists("rank_math_the_breadcrumbs")) rank_math_the_breadcrumbs(); ?>
        </div>
		
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'proyecto' );

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

	<?php get_template_part( 'template-parts/filter-box' ); ?>

<?php
get_footer();
