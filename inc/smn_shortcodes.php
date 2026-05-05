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

    // Mostrar icono
    $icon_path = get_template_directory() . '/assets/icons/' . $petrolera_value . '.svg';
    if (file_exists($icon_path)) {
        $output .= '<div class="petrolera-icon">' . file_get_contents($icon_path) . '</div>';
    }

    // Mostrar etiqueta
    $output .= '<strong class="has-big-font-size">' . esc_html($petrolera_label) . '</strong>';
    $output .= '</div>';

    return $output;
}
add_shortcode('petrolera', 'petrolera_shortcode');
