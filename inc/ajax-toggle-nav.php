<?php
/**
 * AJAX handler para toggle de navegación
 * Permite cargar dinámicamente menús de particulares y empresas
 */

// Endpoint AJAX para cargar menús dinámicamente
add_action('wp_ajax_toggle_menu', 'smn_toggle_menu_ajax');
add_action('wp_ajax_nopriv_toggle_menu', 'smn_toggle_menu_ajax');

function smn_toggle_menu_ajax() {
    // Verificar nonce para seguridad
    if (!wp_verify_nonce($_POST['nonce'], 'toggle_menu_nonce')) {
        wp_die('Seguridad: Nonce no válido');
    }
    
    // Obtener el tipo de menú solicitado
    $menu_type = sanitize_text_field($_POST['menu_type']);
    
    // Validar que sea particulares o empresas
    if (!in_array($menu_type, ['particulares', 'empresas'])) {
        wp_send_json_error('Tipo de menú no válido');
        return;
    }
    
    // Generar el menú correspondiente
    $menu_html = smn_generate_menu_html($menu_type);
    
    // Enviar respuesta JSON
    wp_send_json_success(array(
        'menu_html' => $menu_html,
        'menu_type' => $menu_type
    ));
}

/**
 * Genera el HTML del menú especificado
 */
function smn_generate_menu_html($menu_type) {
    $theme_location = $menu_type . '-menu'; // 'particulares-menu' o 'empresas-menu'
    
    // Configurar argumentos del menú - ambos usan la misma clase container
    $menu_args = array(
        'theme_location' => $theme_location,
        'menu_id'        => $theme_location,
        'container_class' => 'menu-main-menu-container',
        'walker'         => new SMN_Walker_Mega_Menu_Groups(),
        'echo'           => false, // No imprimir, devolver string
    );
    
    // Generar el menú
    $menu_html = wp_nav_menu($menu_args);
    
    return $menu_html;
}

/**
 * Localizar script con datos necesarios para AJAX
 */
function smn_localize_toggle_script() {
    wp_localize_script('zoilo-rios-navigation', 'toggleMenuAjax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('toggle_menu_nonce'),
        'current_menu' => smn_get_current_menu_context()
    ));
}

/**
 * Detectar el contexto actual del menú
 */
function smn_get_current_menu_context() {
    $current_post_type = get_post_type();
    
    // Si estamos en empresas, devolver 'empresas', sino 'particulares'
    if ($current_post_type === 'empresa' || is_post_type_archive('empresa')) {
        return 'empresas';
    }
    
    return 'particulares';
}

// Hook para localizar el script cuando se cargue navigation.js
add_action('wp_enqueue_scripts', 'smn_localize_toggle_script');
