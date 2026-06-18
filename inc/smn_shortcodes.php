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

    // Mostrar icono (convertir a minúsculas para compatibilidad con servidores case-sensitive)
    $icon_filename = strtolower($petrolera_value) . '.svg';
    $icon_path = get_template_directory() . '/assets/icons/' . $icon_filename;
    
    if (file_exists($icon_path)) {
        $icon_content = file_get_contents($icon_path);
        if ($icon_content !== false && !empty($icon_content)) {
            $output .= '<div class="petrolera-icon">' . $icon_content . '</div>';
        }
    }

    // Mostrar etiqueta
    $output .= '<span>' . esc_html($petrolera_label) . '</span>';
    $output .= '</div>';

    return $output;
}
add_shortcode('petrolera', 'petrolera_shortcode');

/**
 * Shortcode para mostrar botones dinámicos desde un campo repeater ACF
 *
 * Uso: [hero_dynamic_buttons field="nombre_del_repeater"]
 * Cada fila debe tener los subcampos: page (ID), text (opcional), link (opcional), color (opcional: primary, secondary, neutral-white)
 */
function hero_dynamic_buttons_shortcode($atts) {
    $atts = shortcode_atts([
        'field' => 'hero_buttons',
    ], $atts);

    if (empty($atts['field'])) {
        return '<p><em>Error: No se especificó el campo repeater ACF</em></p>';
    }

    $rows = get_field($atts['field']);
    if (!$rows || !is_array($rows)) {
        return '';
    }

    $output = '<div class="wp-block-buttons is-layout-flex hero-dynamic-buttons">';

    foreach ($rows as $row) {
        // Obtener valores de subcampos
        $page_id = isset($row['page']) ? $row['page'] : '';
        $text = isset($row['text']) && $row['text'] ? $row['text'] : '';
        $link = isset($row['link']) && $row['link'] ? $row['link'] : '';
        $color = isset($row['color']) && $row['color'] ? $row['color'] : 'primary';

        // Determinar título y enlace
        $title = '';
        $permalink = '';
        if ($page_id) {
            $title = get_the_title($page_id);
            $permalink = get_permalink($page_id);
        }
        if ($text) {
            $title = $text;
        }
        if ($link) {
            $permalink = $link;
        }
        if (!$title || !$permalink) {
            continue; // Saltar si falta info esencial
        }

        // Mapear color a clase de Gutenberg
        $color_class = 'has-' . $color . '-background-color';
        if ($color === 'neutral-white') {
            $color_class .= ' has-text-color has-foreground-color';
        }

        $output .= '<div class="wp-block-button"><a class="wp-block-button__link ' . esc_attr($color_class) . '" href="' . esc_url($permalink) . '">' . esc_html($title) . '</a></div>';
    }

    $output .= '</div>';
    return $output;
}
add_shortcode('hero_dynamic_buttons', 'hero_dynamic_buttons_shortcode');

/**
 * Shortcode para mostrar los terminos de la taxonomia temas
 *
 * Uso:
 * [temas]
 * [temas hide_empty="false" orderby="name" order="ASC"]
 */
function temas_shortcode($atts) {
    $atts = shortcode_atts([
        'hide_empty' => 'false',
        'orderby'    => 'name',
        'order'      => 'ASC',
    ], $atts);

    $terms = get_terms([
        'taxonomy'   => 'tema',
        'hide_empty' => filter_var($atts['hide_empty'], FILTER_VALIDATE_BOOLEAN),
        'orderby'    => sanitize_key($atts['orderby']),
        'order'      => strtoupper(sanitize_text_field($atts['order'])) === 'DESC' ? 'DESC' : 'ASC',
    ]);

    if (is_wp_error($terms) || empty($terms)) {
        return '';
    }

    ob_start();
    ?>
    <div class="wp-block-group is-layout-grid temas-shortcode">
        <?php foreach ($terms as $term) : ?>
            <?php $term_link = get_term_link($term); ?>
            <div class="wp-block-group has-global-padding is-layout-constrained wp-block-group-is-layout-constrained">

                <p class="has-altone-variable-font-family">
                    <?php if (!is_wp_error($term_link)) : ?>
                        <a href="<?php echo esc_url($term_link); ?>"><?php echo esc_html($term->name); ?></a>
                    <?php else : ?>
                        <?php echo esc_html($term->name); ?>
                    <?php endif; ?>
                </p>
                <p class="has-foreground-medium-color has-text-color has-link-color has-small-font-size"><?php echo esc_html(wp_strip_all_tags(term_description($term))); ?></p>

            </div>
        <?php endforeach; ?>
    </div>
    <?php

    return ob_get_clean();
}
add_shortcode('temas', 'temas_shortcode');

