<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Zoilo Ríos
 */

?>

<div id="eess-<?php the_ID(); ?>" class="card-eess wp-block-cover has-custom-content-position is-position-bottom-left">
    <?php the_post_thumbnail( 'size-full', array( 'class' => 'wp-block-cover__image-background size-full' ) ); ?>
    
    <span aria-hidden="true" class="wp-block-cover__background has-neutral-black-background-color has-background-dim-0 has-background-dim"></span>
    
    <div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">
        <div class="wp-block-group is-vertical is-content-justification-right is-layout-flex wp-block-group-is-layout-flex" style="min-height:100%">
            <div class="wp-block-group card-eess--content is-layout-flow wp-block-group-is-layout-flow">
                
                <div class="mb-1 terms-list petrolera-list">
                    <?php
                    $petrolera_terms = get_the_terms( get_the_ID(), 'petrolera' );
                    if ( $petrolera_terms && ! is_wp_error( $petrolera_terms ) ) {
                        $petrolera_names = wp_list_pluck( $petrolera_terms, 'name' );
                        echo esc_html( implode( ', ', $petrolera_names ) );
                    }
                    ?>
                </div>
                <h2 class="has-heading-6-font-size stretched-link card-eess--title">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title();?></a>
                </h2>
                <?php 
                $location = get_field('eess-map');
                    if( $location && isset( $location['address'] ) ) {
                        // Mostrar la dirección completa tal como aparece en el editor
                        echo '<p class="has-small-font-size">' . esc_html( $location['address'] ) . '</p>';
                    }
                ?>
                
            </div>
           <!-- <div class="wp-block-group">
                <?php
                // Condicional: si estamos en CPT empresas, usar 'eess_profesionales', sino usar 'eess_particulares'
                // if (get_post_type() === 'empresa' || is_post_type_archive('empresa') || (is_page() && get_page_template_slug() === 'page-empresa.php')) {
                if ( isset($_COOKIE['audience']) && $_COOKIE['audience'] === 'empresas' ) {
                    $field_name = 'eess_profesionales';
                } else {
                    $field_name = 'eess_particulares';
                }
                
                // Obtener el objeto del campo para acceder a las etiquetas
                $field_object = get_field_object($field_name);
                $selected_values = get_field($field_name);
                
                // Mostrar las etiquetas si hay alguna
                if ($field_object && $selected_values && is_array($selected_values)) : ?>
                <div class="estacion-tags">
                    <div class="tags-container">
                        <?php foreach ($selected_values as $value) : ?>
                            <?php if (!empty($value) && isset($field_object['choices'][$value])) : ?>
                                <span class="tag"><?php echo esc_html($field_object['choices'][$value]); ?></span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div> -->
        </div> 
    </div>
</div>