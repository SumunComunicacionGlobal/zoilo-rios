<?php
    // Bloque Reusable "Hero Page" para el Hero de la página
    
    $block = get_page_by_title( 'Hero Page', OBJECT, 'wp_block' );

    if ( $block ) {
        $block_content = apply_filters( 'the_content', $block->post_content );
        
        // Verificar si existe el campo ACF hero-title o hero-video
        $hero_h1 = get_field( 'hero-h1' );
        $hero_title = get_field( 'hero-title' );
        $hero_video = get_field( 'hero-video' );
        
        if ( $hero_h1 || $hero_title || $hero_video ) {
            // Usar DOMDocument para manipular el HTML de forma segura
            $dom = new DOMDocument();
            libxml_use_internal_errors( true ); // Suprimir warnings de HTML malformado
            $dom->loadHTML( mb_convert_encoding( $block_content, 'HTML-ENTITIES', 'UTF-8' ), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
            $xpath = new DOMXPath( $dom );

            if ( $hero_h1 ) {
                // Buscar el H1 con la clase específica
                $h1_nodes = $xpath->query( "//h1[contains(@class, 'wp-block-post-title')]" );
                
                if ( $h1_nodes->length > 0 ) {
                    // Reemplazar el contenido del H1 con el valor del campo ACF
                    $h1_nodes->item(0)->nodeValue = esc_html( $hero_h1 );
                }
            }
            
            // Reemplazar el título si existe
            if ( $hero_title ) {
                // Buscar el H2 con la clase específica
                $h2_nodes = $xpath->query( "//h2[contains(@class, 'wp-block-post-title')]" );
                
                if ( $h2_nodes->length > 0 ) {
                    // Reemplazar el contenido del H2 con el valor del campo ACF
                    $h2_nodes->item(0)->nodeValue = esc_html( $hero_title );
                }
            }
            
            // Añadir video si existe
            if ( $hero_video ) {
                // Buscar el elemento con id="hero"
                $hero_element = $xpath->query( "//*[@id='hero']" );
                
                if ( $hero_element->length > 0 ) {
                    // Crear el elemento video
                    $video_element = $dom->createElement( 'video' );
                    $video_element->setAttribute( 'class', 'wp-block-cover__video-background intrinsic-ignore' );
                    $video_element->setAttribute( 'autoplay', '' );
                    $video_element->setAttribute( 'muted', '' );
                    $video_element->setAttribute( 'loop', '' );
                    $video_element->setAttribute( 'playsinline', '' );
                    $video_element->setAttribute( 'src', esc_url( $hero_video ) );
                    $video_element->setAttribute( 'data-object-fit', 'cover' );
                    
                    // Insertar el video como primer hijo del elemento hero
                    $hero_element->item(0)->insertBefore( $video_element, $hero_element->item(0)->firstChild );
                }
            }
            
            $block_content = $dom->saveHTML();
            libxml_clear_errors(); // Limpiar errores de libxml
        }
        
        echo $block_content;
    }
?>