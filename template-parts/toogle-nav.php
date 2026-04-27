<?php
    // Detectar si se está usando en mega menú o en header
    $context = isset($args['context']) ? $args['context'] : 'header';
    
    // Detectar el estado actual basado en post type y URL
    $current_post_type = get_post_type();
    $is_empresa_ctp = ($current_post_type === 'empresa' || is_post_type_archive('empresa'));
    $is_empresa_url = (strpos($_SERVER['REQUEST_URI'], '/empresa') !== false);
    
    // Lógica de estado inicial
    if ($context === 'megamenu') {
        // En mega menú: será controlado por JavaScript + localStorage
        $toggle_state = $is_empresa_ctp ? 'empresas' : 'particulares';
        $toggle_id = 'toggle-megamenu';
        $data_attrs = 'data-context="megamenu" data-current-post-type="' . esc_attr($current_post_type) . '"';
    } else {
        // En header: basado en URL para navegación
        $toggle_state = $is_empresa_url ? 'empresas' : 'particulares';
        $toggle_id = 'toggle-header';
        $data_attrs = 'data-context="header"';
    }
?>	

 <div data-current="<?php echo esc_attr($toggle_state); ?>" <?php echo $data_attrs; ?>>
    <div class="toggle" id="<?php echo esc_attr($toggle_id); ?>">
        <div class="toggle-btn--slider"></div>
        <button 
            class="toggle-btn toggle-btn-particulares <?php echo $toggle_state === 'particulares' ? 'active' : 'inactive'; ?>" 
            data-target="particulares"
            <?php echo $toggle_state === 'particulares' ? 'disabled' : ''; ?>
        >
            <?php esc_html_e( 'Particulares', 'zoilo-rios' ); ?>
        </button>
        <button 
            class="toggle-btn toggle-btn-empresas <?php echo $toggle_state === 'empresas' ? 'active' : 'inactive'; ?>" 
            data-target="empresas"
            <?php echo $toggle_state === 'empresas' ? 'disabled' : ''; ?>
        >
            <?php esc_html_e( 'Empresas', 'zoilo-rios' ); ?>
        </button>
    </div>
</div>