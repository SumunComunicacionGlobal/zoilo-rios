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

add_filter( 'render_block', 'smn_convert_paragraph_in_list', 10, 2 );
function smn_convert_paragraph_in_list( $block_content, $block ) {

    if ( $block['blockName'] !== 'core/paragraph' ) {
        return $block_content; // Solo modificar el contenido de bloques de párrafo
    }

    if ( isset($block['attrs']['className']) && strpos($block['attrs']['className'], 'is-style-paragraph-list') !== false ) {
        // Convertir el párrafo en una lista. Encuentra los saltos de línea forzados y convierte cada línea en un elemento de la lista.
        // Añade la clase .wp-block-list.is-style-arrow-mini
        // Remove paragraph tags, including classes and inline styles, if present
        $block_content = preg_replace('/<p[^>]*>(.*?)<\/p>/i', '$1', $block_content);

        $lines = preg_split('/<br\s*\/?>/i', $block_content);
        $list_items = array_map(function($line) {
            return '<li>' . trim($line) . '</li>';
        }, $lines);
        $block_content = '<ul class="wp-block-list is-style-arrow-list is-style-paragraph-list">' . implode('', $list_items) . '</ul>';
    }

    return $block_content;
}

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
    } elseif ( is_singular( 'estacion-de-servicio' ) ) {
        if ( isset($_COOKIE['audience']) && $_COOKIE['audience'] === 'empresas' ) {
            $estaciones_page_id = get_field('home_eess_empresas', 'option');
        } else {
            $estaciones_page_id = get_field('home_eess_particulares', 'option');
        }
        if ( $estaciones_page_id ) {
            $url = get_permalink($estaciones_page_id);
            $title = get_the_title($estaciones_page_id);
            array_splice($crumbs, 1, 0, [[ $title, $url ]]);
        }
    }

    // Reemplazo múltiple en los títulos de las migas de pan
    $search  = [
        'Estaciones de servicio', 
        'Estación de servicio',
        'Zoilo Ríos para '
    ]; // Cambia estos valores
    $replace = [
        'EE.SS.', 
        'E.SS.',
        ''
    ]; // Cambia estos valores
    foreach ($crumbs as &$crumb) {
        if (isset($crumb[0])) {
            $crumb[0] = str_replace($search, $replace, $crumb[0]);
        }
    }
    unset($crumb);

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
    $content = preg_replace('/ class="(xmsonormal|MsoNormal|v1msonormal|paragraph|MsoListParagraphCxSpMiddle|MsoListParagraphCxSpLast)"/', '', $content);

    $content = str_replace( '&nbsp;', ' ', $content );

    // Quitar párrafos vacíos
    $content = preg_replace('/<p>\s*<\/p>/', '', $content);

    // Quitar párrafos que solo contengan espacios
    $content = preg_replace('/<p>\s+<\/p>/', '', $content);

    

    return $content;

}

// Establece la cookie "audience" a "empresas" si la página es un CPT "empresa"
add_action('template_redirect', function() {

    $home_empresa_id = get_field('home_empresa', 'option');
    $home_particulares_id = get_field('home_particulares', 'option');
    
    if ( is_singular('empresa') || is_page( $home_empresa_id ) ) {
        smn_set_audience_cookie('empresas');
    } elseif ( is_singular('particulares') || is_page( $home_particulares_id) ) {
        smn_set_audience_cookie('particulares');
    }

});

function smn_set_audience_cookie($audience) {
    setcookie('audience', $audience, time() + 30 * DAY_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);
    $_COOKIE['audience'] = $audience; // Reflejar el valor en $_COOKIE para acceso inmediato
}

// Cambia el enlace del logo personalizado si la cookie audience es 'empresas'
add_filter('get_custom_logo', function($html) {
    if (isset($_COOKIE['audience']) && $_COOKIE['audience'] === 'empresas') {
        $home_empresa_id = get_field('home_empresa', 'option');
        if ($home_empresa_id) {
            $empresa_url = get_permalink($home_empresa_id);
            // Reemplazar el href del logo por la home de empresa
            $html = preg_replace('/href=["\\\'].*?["\\\']/', 'href="' . esc_url($empresa_url) . '"', $html);
        }
    }
    return $html;
});

// add_filter( 'the_content', 'smn_append_child_pages_after_content', 20 );
function smn_append_child_pages_after_content( $content ) {

    if ( ! is_singular() || is_admin() || ! in_the_loop() || ! is_main_query() ) {
        return $content;
    }

    global $post;
    
    $children = get_posts( [
        'post_parent' => $post->ID,
        'post_type'   => $post->post_type,
        'orderby'     => 'menu_order title',
        'order'       => 'ASC',
        'post_status' => 'publish',
    ] );

    if ( empty( $children ) ) {
        return $content;
    }
    $output = '';
    $output .= '<div class="smn-child-pages-wrapper">';
        $output .= '<h2 class="smn-child-pages-title has-heading-3-font-size">' . esc_html__( '¿Quieres saber más?', 'zoilo' ) . '</h2>';
        $output .= '<ul class="smn-child-pages wp-block-list is-style-arrow-mini-separator-list">';
        foreach ( $children as $child ) {
            $output .= sprintf(
                '<li><a href="%s">%s</a></li>',
                esc_url( get_permalink( $child->ID ) ),
                esc_html( get_the_title( $child->ID ) )
            );
        }
        $output .= '</ul>';
    $output .= '</div>';

    return $content . $output;
}

