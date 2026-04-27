<?php
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function smn_hybrid_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'zoilo-rios' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'zoilo-rios' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Widget Megamenu Particulares', 'zoilo-rios' ),
			'id'            => 'widget-megamenu-particulares',
			'description'   => esc_html__( 'Add widgets here.', 'zoilo-rios' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Widget Megamenu Empresas', 'zoilo-rios' ),
			'id'            => 'widget-megamenu-empresas',
			'description'   => esc_html__( 'Add widgets here.', 'zoilo-rios' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
		)
	);
}
add_action( 'widgets_init', 'smn_hybrid_widgets_init' );



