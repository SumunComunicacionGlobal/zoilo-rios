<?php

// Agrega un filtro para el bloque de consulta de WordPress
// que muestra los posts relacionados en la página de un post y los filtra por categorías
add_filter('render_block_data', function ($parsed_block) {
    if (
        is_single() &&
        isset($parsed_block['blockName']) &&
        $parsed_block['blockName'] === 'core/query' &&
        isset($parsed_block['attrs']['className']) &&
        strpos($parsed_block['attrs']['className'], 'is-style-is-related-posts') !== false
    ) {
        $category_ids = wp_get_post_categories(get_the_ID());

        if (!empty($category_ids)) {
            $parsed_block['attrs']['query']['categoryIds'] = $category_ids;
            $parsed_block['attrs']['query']['exclude'] = [get_the_ID()];
            $parsed_block['attrs']['query']['sticky'] = '';
            $parsed_block['attrs']['query']['perPage'] = 6;
        }
    }

    return $parsed_block;
});

add_filter('rank_math/frontend/breadcrumb/items', function ($crumbs) {

    // Obtener los IDs de las páginas desde las opciones de ACF
    $home_particulares_id = get_field('home_particulares', 'option');
    $home_empresa_id = get_field('home_empresa', 'option');
    $home_proyectos_id = get_field('home_proyectos', 'option');

    // Verificar si estamos en un singular de 'particulares' o 'empresa'
    if (is_singular('particulares') && $home_particulares_id) {
        $url = get_permalink($home_particulares_id);
        $title = get_the_title($home_particulares_id);
        // Insertar en segunda posición
        array_splice($crumbs, 1, 0, [[ $title, $url ]]);
    } elseif (is_singular('empresa') && $home_empresa_id) {
        $url = get_permalink($home_empresa_id);
        $title = get_the_title($home_empresa_id);
        array_splice($crumbs, 1, 0, [[ $title, $url ]]);
    } elseif ( is_singular('proyecto') ) {
        $url = get_permalink($home_proyectos_id);
        $title = get_the_title($home_proyectos_id);
        array_splice($crumbs, 1, 0, [[ $title, $url ]]);
    }

    return $crumbs;
});

/**
 * Complianz: Show the banner when a html element with class 'cmplz-show-banner' is clicked
 */
function cmplz_show_banner_on_click() {
	?>
	<style>
        .cmplz-show-banner {
            cursor: pointer;
        }
	</style>
	<script>
        function addEvent(event, selector, callback, context) {
            document.addEventListener(event, e => {
                if ( e.target.closest(selector) ) {
                    callback(e);
                }
            });
        }
        addEvent('click', '.cmplz-show-banner', function(e){
            e.preventDefault();
            document.querySelectorAll('.cmplz-manage-consent').forEach(obj => {
                obj.click();
            });
        });
	</script>
	<?php
}
add_action( 'wp_footer', 'cmplz_show_banner_on_click' );


add_filter( 'the_content', 'smn_remove_undesired_code_from_content' );
function smn_remove_undesired_code_from_content( $content ) {

if ( !is_singular('post') ) {
        return $content; // Solo modificar el contenido en posts individuales
    }
    // elimina estilos en línea (style="...") que puedan haber sido añadidos por plugins o el editor
    // a tener en cuenta que el estilo puede contener comillas simples para definir tipografías
    $content = preg_replace('/style=(["\'])(.*?)\1/', '', $content);

    // Quitar cursivas <em>
    $content = preg_replace('/<em>(.*?)<\/em>/', '$1', $content);

    // Quitar ' class="xxx"' de los párrafos cuando xxx es igual a:
    // xmsonormal
    // MsoNormal
    // v1msonormal
    $content = preg_replace('/ class="(xmsonormal|MsoNormal|v1msonormal)"/', '', $content);

    // Quitar párrafos vacíos
    $content = preg_replace('/<p>\s*<\/p>/', '', $content);

    // Quitar párrafos que solo contengan espacios
    $content = preg_replace('/<p>\s+<\/p>/', '', $content);

    return $content;

}