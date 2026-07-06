<div id="filter-box">

    <div class="filter-box--header">
        <div id="filter-by"><strong><?php esc_html_e( 'Filtrar por', 'zoilo-rios' ); ?></strong></div>
        <button id="back-btn" class="btn">
            <?php echo file_get_contents(get_template_directory() . '/assets/icons/chevron-left.svg'); ?>
            <?php esc_html_e( 'Volver', 'zoilo-rios' ); ?>
        </button>
        <button id="close-btn" class="btn">
            <?php esc_html_e( 'Cerrar', 'zoilo-rios' ); ?>
            <?php echo file_get_contents(get_template_directory() . '/assets/icons/x.svg'); ?>
        </button>
    </div>

    <div class="filter-box--search">
        <div class="search-input-wrapper">
            <?php echo facetwp_display( 'facet', 'buscador_estaciones' ); ?>
        </div>
        <button id="geolocation-btn" class="geolocation-btn btn-icon">
            <?php echo file_get_contents(get_template_directory() . '/assets/icons/crosshair.svg'); ?>
            <span class="geo-spinner" style="display: none;">⏳</span>
        </button>
    </div>

    <div class="filter-box--selections">
        <?php echo facetwp_display( 'selections' ); ?>
    </div>

    <div class="menu-group">
        <div class="menu-group--title"><?php esc_html_e( 'Estaciones de servicio', 'zoilo-rios' ); ?></div>
        <div class="group-petronera"><?php echo facetwp_display( 'facet', 'petrolera' ); ?></div>
    </div>

    <div class="menu-group">
        <div class="menu-group--title"><?php esc_html_e( 'Servicios', 'zoilo-rios' ); ?></div>
        
        <div class="menu-group--siblings">
            <div class="menu-sibling--title">
                <?php echo file_get_contents(get_template_directory() . '/assets/icons/cafeteria.svg'); ?>
                <div><?php esc_html_e( 'Cafetería y Restaurante', 'zoilo-rios' ); ?></div>
                <button class="btn-icon" aria-controls="menu--siblings" aria-label="Abrir menú" aria-expanded="false">
                    <?php echo file_get_contents(get_template_directory() . '/assets/icons/chevron-right.svg'); ?>
                </button>
            </div>
            <div class="menu--siblings">
                <div class="menu-group--title"><?php esc_html_e( 'Cafetería y Restaurante', 'zoilo-rios' ); ?></div>
                <?php echo facetwp_display( 'facet', 'cafeteria_restaurante' ); ?>
            </div>
        </div>
        <div class="menu-group--siblings">
            <div class="menu-sibling--title">
                <?php echo file_get_contents(get_template_directory() . '/assets/icons/carga-electrica.svg'); ?>
                <div><?php esc_html_e( 'Carga eléctrica', 'zoilo-rios' ); ?></div>
                <button class="btn-icon" aria-controls="menu--siblings" aria-label="Abrir menú" aria-expanded="false">
                    <?php echo file_get_contents(get_template_directory() . '/assets/icons/chevron-right.svg'); ?>
                </button>
            </div>
            <div class="menu--siblings">
                <div class="menu-group--title"><?php esc_html_e( 'Carga eléctrica', 'zoilo-rios' ); ?></div>
                <?php echo facetwp_display( 'facet', 'carga_electrica' ); ?>
            </div>
        </div>
        <div class="menu-group--siblings">
            <div class="menu-sibling--title">
                <?php echo file_get_contents(get_template_directory() . '/assets/icons/combustible.svg'); ?>
                <div><?php esc_html_e( 'Combustible', 'zoilo-rios' ); ?></div>
                <button class="btn-icon" aria-controls="menu--siblings" aria-label="Abrir menú" aria-expanded="false">
                    <?php echo file_get_contents(get_template_directory() . '/assets/icons/chevron-right.svg'); ?>
                </button>
            </div>
            <div class="menu--siblings">
                <div class="menu-group--title"><?php esc_html_e( 'Combustible', 'zoilo-rios' ); ?></div>
                <?php echo facetwp_display( 'facet', 'combustible' ); ?>
            </div>
        </div>
        <div class="menu-group--siblings">
            <div class="menu-sibling--title">
                <?php echo file_get_contents(get_template_directory() . '/assets/icons/tienda.svg'); ?>
                <div><?php esc_html_e( 'Tienda', 'zoilo-rios' ); ?></div>
                <button class="btn-icon" aria-controls="menu--siblings" aria-label="Abrir menú" aria-expanded="false">
                    <?php echo file_get_contents(get_template_directory() . '/assets/icons/chevron-right.svg'); ?>
                </button>
            </div>
            <div class="menu--siblings">
                <div class="menu-group--title"><?php esc_html_e( 'Tienda', 'zoilo-rios' ); ?></div>
                <?php echo facetwp_display( 'facet', 'tienda' ); ?>
            </div>
        </div>
        <div class="menu-group--siblings">
            <div class="menu-sibling--title">
                <?php echo file_get_contents(get_template_directory() . '/assets/icons/lavado-vehiculos.svg'); ?>
                <div><?php esc_html_e( 'Lavado Vehículos', 'zoilo-rios' ); ?></div>
                <button class="btn-icon" aria-controls="menu--siblings" aria-label="Abrir menú" aria-expanded="false">
                    <?php echo file_get_contents(get_template_directory() . '/assets/icons/chevron-right.svg'); ?>
                </button>
            </div>
            <div class="menu--siblings">
                <div class="menu-group--title"><?php esc_html_e( 'Lavado Vehículos', 'zoilo-rios' ); ?></div>
                <?php echo facetwp_display( 'facet', 'lavado_vehiculos' ); ?>
            </div>
        </div>
        
    </div>

    <?php
        // Condicional para mostrar el menú correcto según el contexto
        // if ( get_post_type() === 'empresa' || is_post_type_archive( 'empresa' ) || (is_page() && get_page_template_slug() === 'page-empresa.php') ) { 
        if ( isset($_COOKIE['audience']) && $_COOKIE['audience'] === 'empresas' ) {
        ?>

        <div class="menu-group">
            <div class="menu-group--title"><?php esc_html_e( 'Para profesionales', 'zoilo-rios' ); ?></div>
            <div class="group-profesionales"><?php echo facetwp_display( 'facet', 'para_profesionales' ); ?></div>
        </div>
    
    <?php } else { ?>
        <div class="menu-group">
            <div class="menu-group--title"><?php esc_html_e( 'Para particulares', 'zoilo-rios' ); ?></div>
            <div class="group-particulares"><?php echo facetwp_display( 'facet', 'para_particulares' ); ?></div>
        </div>
    <?php } ?>
</div>
