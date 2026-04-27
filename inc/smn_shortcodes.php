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
 * Shortcode para mostrar campos ACF de tipo casillas de verificación
 * 
 * Parámetros:
 * - field: Nombre del campo ACF (requerido)
 * - class: Clase CSS para la lista (opcional)
 * - type: Tipo de lista 'ul' o 'ol' (opcional, por defecto 'ul')
 * - separator: Separador si no quieres lista (opcional)
 * 
 * Uso: 
 * [acf_checkboxes field="campo-checkbox-multiple"]
 * [acf_checkboxes field="servicios" class="servicios-lista" type="ol"]
 * [acf_checkboxes field="servicios" separator=", "]
 */
function acf_checkboxes_shortcode($atts) {
    // Parámetros por defecto
    $atts = shortcode_atts(array(
        'field' => '',
        'class' => '',
        'type' => 'ul',
        'separator' => '',
        'empty_message' => ''
    ), $atts);

    // Verificar que se especificó un campo
    if (empty($atts['field'])) {
        return '<p><em>Error: No se especificó el campo ACF</em></p>';
    }

    // Obtener el valor del campo ACF
    $checkboxes = get_field($atts['field']);
    
    // Si no hay valores o no es un array, retornar mensaje vacío o nada
    if (!$checkboxes || !is_array($checkboxes)) {
        return !empty($atts['empty_message']) ? '<p>' . esc_html($atts['empty_message']) . '</p>' : '';
    }

    // Construir el output
    $output = '';
    $class_attr = !empty($atts['class']) ? ' class="' . esc_attr($atts['class']) . '"' : '';

    // Si se especifica separator, mostrar como texto separado
    if (!empty($atts['separator'])) {
        $values = array_map('esc_html', $checkboxes);
        $output = implode($atts['separator'], $values);
    } else {
        // Mostrar como lista
        $list_type = in_array($atts['type'], ['ul', 'ol']) ? $atts['type'] : 'ul';
        $output = '<' . $list_type . $class_attr . '>';
        
        foreach ($checkboxes as $checkbox) {
            $output .= '<li>' . esc_html($checkbox) . '</li>';
        }
        
        $output .= '</' . $list_type . '>';
    }

    return $output;
}
add_shortcode('acf_checkboxes', 'acf_checkboxes_shortcode');
