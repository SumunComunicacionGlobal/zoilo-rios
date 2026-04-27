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
            while ( have_posts() ) :
                the_post();

                get_template_part( 'template-parts/content', 'page' );

            endwhile; // End of the loop.
            
            get_template_part( 'template-parts/estacion/nav-bar' ); 
            get_template_part( 'template-parts/estacion/servicios-list' );
            get_template_part( 'template-parts/estacion/map' );
        
        ?>
        
        <div class="wp-block-group mb-3 alignfull is-layout-flow wp-block-group-is-layout-flow" style="border-radius:0px;padding-right:var(--wp--preset--spacing--10);padding-left:var(--wp--preset--spacing--10)">
            <div class="wp-block-group full-width has-neutral-30-background-color has-background has-global-padding is-layout-constrained wp-container-core-group-is-layout-306daf7c wp-block-group-is-layout-constrained" style="border-radius:32px;padding-top:0;padding-right:var(--wp--preset--spacing--10);padding-bottom:0;padding-left:var(--wp--preset--spacing--10)">
                <div class="wp-block-group is-style-margin-vertical is-layout-flow wp-block-group-is-layout-flow">
                        
                    <?php
                        // Array de todos los campos ACF a mostrar
                        $acf_fields_services_for = [
                            'eess_petrolera' => 'Petrolera',
                            'eess_particulares' => 'Servicios para Particulares',
                            'eess_profesionales' => 'Servicios para Profesionales',
                        ];
                    ?>

                    <div class="estacion-services-grid">
                        <?php foreach ($acf_fields_services_for as $field_name => $field_title) : 
                            // Obtener el objeto del campo para acceder a las etiquetas
                            $field_object = get_field_object($field_name);
                            $selected_values = get_field($field_name);
                            
                            // Mostrar las etiquetas si hay alguna
                            if ($field_object && $selected_values && is_array($selected_values) && !empty($selected_values)) : ?>
                            <div class="estacion-service-section">
                                <p class="has-caption-font-size has-neutral-60-color uppercase"><strong><?php echo esc_html($field_title); ?></strong></p>
                                <ul class="estacion-service-list--for">
                                    <?php foreach ($selected_values as $value) : ?>
                                        <?php if (!empty($value) && isset($field_object['choices'][$value])) : 
                                            // Ruta al archivo de icono
                                            $icon_path = get_template_directory() . '/assets/icons/' . $value . '.svg';
                                        ?>
                                            <li>
                                                <?php if (file_exists($icon_path)) : ?>
                                                    <?php echo file_get_contents($icon_path); ?>
                                                <?php endif; ?>
                                                <?php echo esc_html($field_object['choices'][$value]); ?>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>	
                    
                </div>
            </div>
        </div>

	</main><!-- #main -->

	<?php get_template_part( 'template-parts/filter-box' ); ?>

<?php
get_footer();