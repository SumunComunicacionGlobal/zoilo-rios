<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package zoilo-rios
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'zoilo-rios' ); ?></a>

	<header id="masthead" class="site-header has-global-padding">
		<div class="masthead-container">
			
			<div class="main-navigation has-white-blur-background-color">	
				<div class="site-branding">
					<?php the_custom_logo(); ?>
				</div><!-- .site-branding -->
				<div class="site-branding-symbol">
					<a href="<?php echo home_url('/'); ?>" class="custom-logo-link" rel="home" aria-current="page"><?php echo file_get_contents(get_template_directory() . '/assets/icons/symbol-zoilo.svg'); ?></a>
				</div><!-- .site-branding -->
				
				<?php get_template_part( 'template-parts/toggle-nav' ); ?>

				<?php
					wp_nav_menu(
						array(
							'theme_location' => 'secondary-menu',
							'menu_id'        => 'secondary-menu',
							'walker'         => new SMN_Walker_Nav_Menu_Icon(),
						)
					);
				?>
			</div>
			
			<button class="menu-toggle btn-icon has-primary-background-color" aria-controls="primary-menu" aria-label="Abrir menú" aria-expanded="false">
				<?php echo file_get_contents(get_template_directory() . '/assets/icons/burguer.svg'); ?>
			</button>
			
			<nav id="mega-menu" aria-label="<?php esc_attr_e( 'Primary Menu', 'zoilo-rios' ); ?>">
				<button class="menu-toggle-close btn-icon has-primary-background-color" aria-controls="primary-menu" aria-label="Cerrar menú" aria-expanded="false">
					<?php echo file_get_contents(get_template_directory() . '/assets/icons/x.svg'); ?>
				</button>
				<?php
					// Condicional para mostrar el menú correcto según el contexto
					if ( isset($_COOKIE['audience']) && $_COOKIE['audience'] === 'empresas' ) {
						// Mostrar menú de empresas
						wp_nav_menu(
							array(
								'theme_location' => 'empresas-menu',
								'menu_id'        => 'empresas-menu',
								'container_class' => 'menu-main-menu-container',
								'walker'         => new SMN_Walker_Mega_Menu_Groups(),
							)
						);
					} else {
						// Mostrar menú de particulares (por defecto)
						wp_nav_menu(
							array(
								'theme_location' => 'particulares-menu',
								'menu_id'        => 'particulares-menu',
								'container_class' => 'menu-main-menu-container',
								'walker'         => new SMN_Walker_Mega_Menu_Groups(),
							)
						);
					}
				?>
			</nav><!-- #mega-menu -->
			
		</div> <!-- .masthead-container -->
	</header><!-- #masthead -->
