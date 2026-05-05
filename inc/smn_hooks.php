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
    }

    return $crumbs;
});