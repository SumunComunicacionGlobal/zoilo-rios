<?php
    // Bloque Reusable "Hero Mini" para el Hero de la página
    
    $block = get_page_by_title( 'Hero Mini', OBJECT, 'wp_block' );

    if ( $block ) {
        $block_content = apply_filters( 'the_content', $block->post_content );
        
        // Verificar si existe el campo ACF hero-title
        $hero_title = get_field( 'hero-title' );
        
        if ( $hero_title ) {
            // Usar DOMDocument para manipular el HTML de forma segura
            $dom = new DOMDocument();
            libxml_use_internal_errors( true ); // Suprimir warnings de HTML malformado
            $dom->loadHTML( mb_convert_encoding( $block_content, 'HTML-ENTITIES', 'UTF-8' ), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
            
            // Buscar el H2 con la clase específica
            $xpath = new DOMXPath( $dom );
            $h2_nodes = $xpath->query( "//h2[contains(@class, 'wp-block-post-title') and contains(@class, 'has-display-font-size')]" );
            
            if ( $h2_nodes->length > 0 ) {
                // Reemplazar el contenido del H2 con el valor del campo ACF
                $h2_nodes->item(0)->nodeValue = esc_html( $hero_title );
                $block_content = $dom->saveHTML();
            }
            
            libxml_clear_errors(); // Limpiar errores de libxml
        }
        
        echo $block_content;
    }
?>