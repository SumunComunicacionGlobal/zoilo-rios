<?php 
// Shortcodes 

/**
 * Shortcode para mostrar las estaciones de servicio
 * 
 * Uso: [estaciones_servicio]
 */
function mostrar_estaciones_shortcode() {
    ob_start();
    get_template_part( 'template-parts/archive-estaciones' );
    return ob_get_clean();
}
add_shortcode( 'estaciones_servicio', 'mostrar_estaciones_shortcode' );

/**
 * Shortcode para mostrar el campo ACF petrolera con su icono
 * 
 * Parámetros:
 * - class: Clase CSS para el contenedor (opcional)
 * 
 * Uso: 
 * [petrolera]
 * [petrolera class="petrolera-card"]
 */
function petrolera_shortcode($atts) {
    // Parámetros por defecto
    $atts = shortcode_atts(array(
        'class' => ''
    ), $atts);

    // Obtener el valor y objeto del campo ACF petrolera
    $petrolera_value = get_field('eess_petrolera');
    $field_object = get_field_object('eess_petrolera');
    
    // Si no hay valor, retornar vacío
    if (!$petrolera_value || !$field_object) {
        return '';
    }

    // Obtener la etiqueta del valor seleccionado
    $petrolera_label = isset($field_object['choices'][$petrolera_value]) ? 
                      $field_object['choices'][$petrolera_value] : $petrolera_value;

    // Construir el output
    $class_attr = !empty($atts['class']) ? ' class="' . esc_attr($atts['class']) . '"' : '';
    $output = '<div' . $class_attr . '>';

    // Debug extenso para diagnosticar problema de producción
    $template_dir = get_template_directory();
    $icon_path = $template_dir . '/assets/icons/' . esc_attr($petrolera_value) . '.svg';
    $file_exists = file_exists($icon_path);
    $is_readable = is_readable($icon_path);
    
    $output .= '<!-- DEBUG START -->';
    $output .= '<!-- Valor ACF: ' . esc_html($petrolera_value) . ' -->';
    $output .= '<!-- Label: ' . esc_html($petrolera_label) . ' -->';
    $output .= '<!-- Template dir: ' . esc_html($template_dir) . ' -->';
    $output .= '<!-- Icon path: ' . esc_html($icon_path) . ' -->';
    $output .= '<!-- File exists: ' . ($file_exists ? 'YES' : 'NO') . ' -->';
    $output .= '<!-- Is readable: ' . ($is_readable ? 'YES' : 'NO') . ' -->';
    
    // Mostrar icono
    if ($file_exists && $is_readable) {
        $icon_content = file_get_contents($icon_path);
        if ($icon_content !== false && !empty($icon_content)) {
            $output .= '<!-- Icon loaded: ' . strlen($icon_content) . ' chars -->';
            $output .= '<div class="petrolera-icon">' . $icon_content . '</div>';
        } else {
            $output .= '<!-- Icon file empty or read failed -->';
        }
    } else {
        $output .= '<!-- Icon file not found or not readable -->';
        
        // Verificar si la carpeta icons existe
        $icons_dir = $template_dir . '/assets/icons/';
        $icons_dir_exists = is_dir($icons_dir);
        $output .= '<!-- Icons dir exists: ' . ($icons_dir_exists ? 'YES' : 'NO') . ' -->';
        
        if ($icons_dir_exists) {
            $files_in_dir = scandir($icons_dir);
            $svg_files = array_filter($files_in_dir, function($file) {
                return pathinfo($file, PATHINFO_EXTENSION) === 'svg';
            });
            $output .= '<!-- SVG files found: ' . implode(', ', array_slice($svg_files, 0, 10)) . ' -->';
        }
    }
    
    $output .= '<!-- DEBUG END -->';

    // Mostrar etiqueta
    $output .= '<strong class="has-big-font-size">' . esc_html($petrolera_label) . '</strong>';
    $output .= '</div>';

    return $output;
}
add_shortcode('petrolera', 'petrolera_shortcode');
