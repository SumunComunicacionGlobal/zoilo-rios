<?php
/**
 * Enqueue scripts
 */

 function smn_scripts() {

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'zoilo-rios-js', get_template_directory_uri() . '/assets/js/zoilo-rios.js', array(), true );
	
	// Localizar variables para JavaScript
	wp_localize_script( 'zoilo-rios-js', 'themeData', array(
		'themeUrl' => get_template_directory_uri()
	));
	
	wp_enqueue_script( 'zoilo-rios-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'zoilo-rios-toggle', get_template_directory_uri() . '/assets/js/toggle.js', array(), null, true );
	wp_enqueue_script( 'estaciones-js', get_template_directory_uri() . '/assets/js/estaciones.js', array('jquery'), _S_VERSION, true );
	
	// Cargar Google Maps API para estaciones de servicio
	if ( is_post_type_archive( 'estacion-de-servicio' ) || 
		 is_singular( 'estacion-de-servicio' ) || 
		 has_shortcode( get_post()->post_content ?? '', 'estaciones_servicio' ) ) {
		
		// Obtener la API key de Google Maps
		$google_maps_api_key = 'AIzaSyD3U_RUr-rQZYtYYb_ZqXqNdGFwd2czX00'; // Misma key que está en functions.php
		
		// Cargar Google Maps API
		wp_enqueue_script( 
			'google-maps-api', 
			'https://maps.googleapis.com/maps/api/js?key=' . $google_maps_api_key . '&libraries=places&callback=initializeStationMapCallback', 
			array(), 
			null, 
			true 
		);
	}

	if ( has_block( 'cb/carousel' ) ) {
        wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/assets/slick/slick.min.css' );
        wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/assets/slick/slick.min.js', array('jquery'), null, true );
        wp_enqueue_script( 'slick-init-js', get_template_directory_uri() . '/assets/slick/init.js', array('jquery'), null, true );
    }

}
add_action( 'wp_enqueue_scripts', 'smn_scripts' );

/** 
* Gutenberg scripts
*/
function smn_gutenberg_scripts() {

	wp_enqueue_script(
		'be-editor', 
		get_stylesheet_directory_uri() . '/assets/js/editor.js', 
		array( 'wp-blocks', 'wp-dom', 'wp-dom-ready', 'wp-edit-post' ), 
		filemtime( get_stylesheet_directory() . '/assets/js/editor.js' ),
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'smn_gutenberg_scripts' );

/**
 * GSAP script in WordPress
*/
// wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
function theme_gsap_script(){
    // The core GSAP library
    wp_enqueue_script( 'gsap-js', 'https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js', array(), false, true );
    // ScrollTrigger - with gsap.js passed as a dependency
    wp_enqueue_script( 'gsap-st', 'https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrollTrigger.min.js', array('gsap-js'), false, true );
    // Your animation code file - with gsap.js and gsap-st passed as a dependency
    wp_enqueue_script( 'gsap-js2', get_template_directory_uri() . '/assets/js/gsap.js', array('gsap-js', 'gsap-st'), false, true );
}

//add_action( 'wp_enqueue_scripts', 'theme_gsap_script' );



