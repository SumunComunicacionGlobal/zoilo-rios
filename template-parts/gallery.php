<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$gallery_ids = get_field('gallery');
if ( !$gallery_ids ) return false;

$count = count($gallery_ids);

$columns = 8; // Default to 3 columns


$html = '';
$r = '';

$texto_boton = __('Ver galería', 'zoilo');
if ( is_singular('estacion-de-servicio') ) {
    $texto_boton = __('Ver instalaciones', 'zoilo');
}

// Prepare image data for Gutenberg gallery block
$images = [];

    $html .= '<!-- wp:group {"align":"full","layout":{"type":"constrained"}} -->';
    $html .= '<div class="wp-block-group alignfull has-global-padding is-layout-constrained wp-block-group-is-layout-constrained">';

        $html .= '<!-- wp:group {"layout":{"type":"flex"}} -->';
        $html .= '<div class="wp-block-group has-global-padding is-layout-flex wp-block-group-is-layout-flex">';

            $html .= '<!-- wp:gallery {"className":"page-gallery","columns":'. $columns .',"imageCrop":false,"linkTo":"media","sizeSlug":"large","aspectRatio":"1"} -->';
            $html .= '<figure class="wp-block-gallery has-nested-images columns-'. $columns .' is-cropped page-gallery">';

            foreach ($gallery_ids as $id) {
                $html .= '<!-- wp:image {"id":' . $id . ',"sizeSlug":"thumbnail","linkDestination":"media","aspectRatio":"1"} -->';
                $html .= '<figure class="wp-block-image size-thumbnail">';
                    $html .= '<a href="' . wp_get_attachment_url($id) . '">';
                        $html .= wp_get_attachment_image($id, 'thumbnail', false, ['style' => 'aspect-ratio: 1', 'alt' => get_post_meta($id, '_wp_attachment_image_alt', true)]);
                    $html .= '</a>';
                $html .= '</figure>';
                $html .= '<!-- /wp:image -->';
            }

            $html .= '</figure>';
            $html .= '<!-- /wp:gallery -->';

            $html .= '<!-- wp:paragraph {"align":"center","className":"gallery-button"} -->';
            $html .= '<p class="has-text-align-center gallery-button"><a href="' . wp_get_attachment_url($gallery_ids[0]) . '" class="gallery-block-link">' . $texto_boton . '</a></p>';
            $html .= '<!-- /wp:paragraph -->';

        $html .= '</div>';
        $html .= '<!-- /wp:group -->';

    $html .= '</div>';
    $html .= '<!-- /wp:group -->';

$blocks = parse_blocks($html);
foreach ($blocks as $block) {
    $r .= render_block($block);
}

echo $r;

