<?php
/**
 * The template for displaying Estaciones de Servicio CTP pages
 *
 * This is the template that displays Estaciones de Servicio CTP pages by default.
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
		
		<?php get_template_part( 'template-parts/hero-estaciones' ); ?>
        
		<div class="breadcrumbs has-global-padding">
            <?php if (function_exists("rank_math_the_breadcrumbs")) rank_math_the_breadcrumbs(); ?>
        </div>

		<?php
            get_template_part( 'template-parts/estacion/nav-bar' ); 

            get_template_part( 'template-parts/gallery' );
            
            while ( have_posts() ) :
                the_post();

                get_template_part( 'template-parts/content', 'page' );

            endwhile; // End of the loop.
            
            get_template_part( 'template-parts/estacion/servicios-list' );
            get_template_part( 'template-parts/estacion/map' );
            get_template_part( 'template-parts/estacion/servicios-para' );
        
        ?>
        
        

	</main><!-- #main -->

<?php
get_footer();