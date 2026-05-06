<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$home_empresa_id = get_field('home_empresa', 'option');
$home_particulares_id = get_field('home_particulares', 'option');

if ( isset($_COOKIE['audience']) ) {
    $audience = $_COOKIE['audience'];
} else {
    $audience = 'particulares'; // Valor por defecto
}

$toggle_class = $audience === 'empresas' ? 'active' : '';

?>


<!-- Toggle Nav para header - navegación directa por URLs -->
<div class="header-toggle-nav">
    <div class="toggle" id="toggle-header">
        <div class="toggle-btn--slider <?php echo $toggle_class; ?>"></div>
        <a href="<?php echo get_permalink($home_particulares_id); ?>" 
            class="toggle-btn toggle-btn-particulares">
            <?php esc_html_e( 'Particulares', 'zoilo-rios' ); ?>
        </a>
        <a href="<?php echo get_permalink($home_empresa_id); ?>" 
            class="toggle-btn toggle-btn-empresas">
            <?php esc_html_e( 'Empresas', 'zoilo-rios' ); ?>
        </a>
    </div>
</div>
