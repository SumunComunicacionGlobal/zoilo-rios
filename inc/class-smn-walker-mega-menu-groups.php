<?php
/**
 * Walker personalizado para agrupar items por título de grupo, manejar iconos ACF y submenus
 */
class SMN_Walker_Mega_Menu_Groups extends Walker_Nav_Menu {
    
    public function walk( $elements, $max_depth, ...$args ) {
        $output = '';
        
        if ( $max_depth < -1 ) {
            return $output;
        }
        
        if ( empty( $elements ) ) {
            return $output;
        }
        
        // Obtener argumentos del menú
        $menu_args = !empty($args) ? $args[0] : null;
        $is_mega_menu = ($menu_args && isset($menu_args->theme_location) && 
                        ($menu_args->theme_location === 'particulares-menu' || $menu_args->theme_location === 'empresas-menu'));
        $menu_type = ($menu_args && isset($menu_args->theme_location)) ? $menu_args->theme_location : '';
        
        // 1. Agregar toggle para los mega menús (particulares y empresas)
        if ( $is_mega_menu ) {
            ob_start();
            get_template_part( 'template-parts/toggle-nav', null, array('context' => 'megamenu') );
            $toggle_html = ob_get_clean();
            $output .= '<div class="menu-toggle-container">' . $toggle_html . '</div>';
        }
        
        $parent_field = $this->db_fields['parent'];
        
        // Crear índice de todos los elementos por ID
        $elements_by_id = array();
        $children_elements = array();
        
        foreach ( $elements as $e ) {
            $elements_by_id[$e->ID] = $e;
            if ( !empty( $e->$parent_field ) ) {
                $children_elements[$e->$parent_field][] = $e;
            }
        }
        
        // Filtrar solo elementos de nivel superior
        $top_level_elements = array();
        foreach ( $elements as $e ) {
            if ( empty( $e->$parent_field ) ) {
                // Detectar si tiene hijos y agregar clase correspondiente
                if ( isset( $children_elements[$e->ID] ) ) {
                    $e->classes[] = 'menu-item-has-children';
                }
                $top_level_elements[] = $e;
            }
        }
        
        // Agrupar elementos por título de grupo
        $groups = array();
        $current_group = array();
        $current_group_title = '';
        
        foreach ( $top_level_elements as $item ) {
            $group_title = get_field('group-title-item-menu', $item);
            
            if ( $group_title ) {
                // Guardar grupo anterior si existe
                if ( !empty( $current_group ) ) {
                    $groups[] = array(
                        'title' => $current_group_title,
                        'items' => $current_group
                    );
                }
                // Empezar nuevo grupo
                $current_group = array( $item );
                $current_group_title = $group_title;
            } else {
                // Agregar al grupo actual
                $current_group[] = $item;
            }
        }
        
        // Guardar último grupo
        if ( !empty( $current_group ) ) {
            $groups[] = array(
                'title' => $current_group_title,
                'items' => $current_group
            );
        }
        
        // 2. Generar HTML por grupos
        foreach ( $groups as $group ) {
            if ( $group['title'] ) {
                $output .= '<div class="menu-group">';
                $output .= '<div class="menu-group-title">' . esc_html( $group['title'] ) . '</div>';
            }
            
            foreach ( $group['items'] as $item ) {
                $output .= $this->build_menu_item( $item, $children_elements );
            }
            
            if ( $group['title'] ) {
                $output .= '</div>';
            }
        }
        
        // 3. Agregar widget específico según el tipo de menú
        if ( $is_mega_menu ) {
            $widget_id = '';
            if ( $menu_type === 'particulares-menu' && is_active_sidebar( 'widget-megamenu-particulares' ) ) {
                $widget_id = 'widget-megamenu-particulares';
            } elseif ( $menu_type === 'empresas-menu' && is_active_sidebar( 'widget-megamenu-empresas' ) ) {
                $widget_id = 'widget-megamenu-empresas';
            }
            
            if ( $widget_id ) {
                ob_start();
                dynamic_sidebar( $widget_id );
                $widget_html = ob_get_clean();
                $output .= '<div class="menu-widget-container menu-widget-' . str_replace('-menu', '', $menu_type) . '">' . $widget_html . '</div>';
            }
        }
        
        return $output;
    }
    
    private function build_menu_item( $item, $children_elements = array() ) {
        $icon_url = get_field('icon-item-menu', $item);
        $has_children = isset( $children_elements[$item->ID] ) && !empty( $children_elements[$item->ID] );
        
        $output = '<li id="menu-item-'. $item->ID . '" class="' . implode(' ', $item->classes ) . '">';
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
        
        // Agregar submenú si tiene hijos
        if ( $has_children ) {
            $output .= '<ul class="sub-menu">';
            foreach ( $children_elements[$item->ID] as $child ) {
                $output .= $this->build_menu_item( $child );
            }
            $output .= '</ul>';
        }
        
        $output .= '</li>';
        
        return $output;
    }
    
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        // Este método ya no se usa, la lógica está en walk()
    }
    
    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        // Este método ya no se usa, la lógica está en walk()
    }
}
