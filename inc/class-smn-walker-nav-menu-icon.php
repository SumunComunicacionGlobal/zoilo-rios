<?php
/**
 * Walker simple para inyectar iconos ACF en los menús (sin grupos ni widget)
 */
class SMN_Walker_Nav_Menu_Icon extends Walker_Nav_Menu {
    
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $icon_url = get_field('icon-item-menu', $item);
        
        $output .= '<li id="menu-item-'. $item->ID . '" class="' . implode(' ', $item->classes ) . '">';
        $output .= '<a href="' . esc_url( $item->url ) . '"';
        
        if ( $item->attr_title ) {
            $output .= ' title="' . esc_attr( $item->attr_title ) . '"';
        }
        if ( $item->target ) {
            $output .= ' target="' . esc_attr( $item->target ) . '"';
        }
        if ( $item->xfn ) {
            $output .= ' rel="' . esc_attr( $item->xfn ) . '"';
        }
        
        $output .= '>';
        
        if ( $icon_url ) {
            // Si es un nombre de archivo simple (ej: "menu"), cargar desde assets/icons/
            if ( !filter_var($icon_url, FILTER_VALIDATE_URL) && !strpos($icon_url, '/') ) {
                $icon_path = get_template_directory() . '/assets/icons/' . $icon_url . '.svg';
                if ( file_exists($icon_path) ) {
                    $svg_content = file_get_contents($icon_path);
                    $output .= '<span class="menu-item-icon">' . $svg_content . '</span> ';
                }
            } else {
                // Fallback para URLs completas
                $output .= '<span class="menu-item-icon"><img src="' . esc_url( $icon_url ) . '" alt="" /></span> ';
            }
        }
        
        $output .= apply_filters( 'the_title', $item->title, $item->ID );
        $output .= '</a>';
    }
    
    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        $output .= '</li>';
    }
}
