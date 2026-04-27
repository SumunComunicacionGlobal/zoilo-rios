<!-- Mapa de la estación -->
<div class="wp-block-group mt-3 mb-3 alignfull is-layout-flow wp-block-group-is-layout-flow" style="border-radius:0px;padding-right:var(--wp--preset--spacing--10);padding-left:var(--wp--preset--spacing--10)">
    <div class="wp-block-group full-width has-neutral-white-background-color has-background has-global-padding is-layout-constrained wp-container-core-group-is-layout-306daf7c wp-block-group-is-layout-constrained" style="border-radius:32px;padding-top:0;padding-right:var(--wp--preset--spacing--10);padding-bottom:0;padding-left:var(--wp--preset--spacing--10)">
        <div class="wp-block-group is-style-margin-vertical is-layout-flow wp-block-group-is-layout-flow">
            <h2 class="has-foreground-medium-color has-heading-3-font-size">Ubicación de <?php echo esc_html( get_the_title() ); ?></h2>
            
            <?php 
            $location = get_field('eess-map');
            if( $location ): ?>
                <div class="estacion-map-container">
                    <div class="acf-map" data-zoom="10">
                        <div class="marker" data-lat="<?php echo esc_attr($location['lat']); ?>" data-lng="<?php echo esc_attr($location['lng']); ?>">
                            <h4><?php echo esc_html( get_the_title() ); ?></h4>
                            <?php if( isset( $location['address'] ) ): ?>
                                <p><?php echo esc_html( $location['address'] ); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <?php if( isset( $location['address'] ) ): ?>
                        <div class="estacion-address">
                            <p><strong>Dirección:</strong> <?php echo esc_html( $location['address'] ); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <p>No hay ubicación disponible para esta estación de servicio.</p>
            <?php endif; ?>
            
        </div>
    </div>
</div>