<?php
/**
 * The template for displaying empresa CTP pages
 *
 * This is the template that displays empresa CTP pages by default.
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
		
		<?php get_template_part( 'template-parts/hero-page' ); ?>
        
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
