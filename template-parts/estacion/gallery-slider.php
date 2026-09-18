<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$image_ids = get_field( 'gallery' );
if ( ! $image_ids ) {
    return false;
}
?>

<div id="galeria-imagenes" class="wp-block-group estacion-installations mt-3 mb-3 alignfull is-layout-flow wp-block-group-is-layout-flow" style="border-radius:0px;padding-right:var(--wp--preset--spacing--10);padding-left:var(--wp--preset--spacing--10)">
    <div class="wp-block-group full-width has-neutral-white-background-color has-background has-global-padding is-layout-constrained wp-container-core-group-is-layout-306daf7c wp-block-group-is-layout-constrained" style="border-radius:32px;padding-top:0;padding-right:var(--wp--preset--spacing--10);padding-bottom:0;padding-left:var(--wp--preset--spacing--10)">
        <div class="wp-block-group is-style-margin-vertical is-layout-flow wp-block-group-is-layout-flow">
            <h2 class="has-foreground-medium-color has-heading-3-font-size">Instalaciones</h2>

            <div class="wp-block-cb-carousel estacion-installations-slider">
                <?php foreach ( $image_ids as $image_id ) : ?>
                    <div class="estacion-installations-slide">
                        <figure class="wp-block-image">
                        <?php
                        echo wp_get_attachment_image(
                            $image_id,
                            'large',
                            false,
                            array(
                                'alt' => get_post_meta( $image_id, '_wp_attachment_image_alt', true ),
                            )
                        );
                        ?>
                        </figure>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>