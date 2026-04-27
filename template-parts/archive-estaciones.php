<!-- Barra de controles de estaciones -->
<div class="row-controls wp-block-group is-position-sticky">
    <button id="toggle-filter-box" class="btn-filtros">
        <?php echo file_get_contents(get_template_directory() . '/assets/icons/sliders.svg'); ?>
        <?php esc_html_e( 'Ver filtro', 'zoilo-rios' ); ?>
    </button>

    <div class="active-filters">
        <div class="tag">Filtro activo</div>
    </div>

    <div class="toggle-views" id="toggle-views-estaciones">
        <div class="toggle-btn--slider"></div>
        <div class="toggle-btn" data-view="list">
            <?php echo file_get_contents(get_template_directory() . '/assets/icons/list.svg'); ?>
            <?php esc_html_e( 'Lista', 'zoilo-rios' ); ?>
        </div>
        <div class="toggle-btn" data-view="map">
            <?php echo file_get_contents(get_template_directory() . '/assets/icons/map.svg'); ?>
            <?php esc_html_e( 'Mapa', 'zoilo-rios' ); ?>
        </div>
        <div class="toggle-btn" data-view="grid">
            <?php echo file_get_contents(get_template_directory() . '/assets/icons/grid.svg'); ?>
            <?php esc_html_e( 'Grid', 'zoilo-rios' ); ?>
        </div>
    </div>
</div>

<div class="row-results wp-block-group is-style-group-horizontal-scroll" id="estacionesContent">



<?php // Define the query arguments
    $args = [
        "post_type"      => 'estacion-de-servicio',
        "posts_per_page" => -1,
        "orderby"        => ["title" => "ASC"],
        "facetwp"        => true //This flags this custom query as the one to be used by FacetWP
    ];
 
    // Run the query
    $estaciones_query = new WP_Query( $args );

        if ( $estaciones_query->have_posts() ) :
        while ( $estaciones_query->have_posts() ) :
            $estaciones_query->the_post(); // Use only here, NOT outside the loop.
            
            get_template_part( 'template-parts/card-eess');
        
            endwhile;
        else : ?>
        <p><?php  _e( 'Sorry, no posts matched your criteria.' ); ?></p>
        <?php
        endif;
        wp_reset_postdata();
    
    // get_footer(); // Make sure to include footer.php in your template, and make sure the wp_footer(); function is present in it.

    ?>

</div>
