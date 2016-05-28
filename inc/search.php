<?php

use Helpers\Template;

add_filter('build_search_page', function() {
    $page = get_page_by_path('search');

    $query = get_search_query();
    if(empty($query)) {
        $link = get_permalink($page);
        if(!headers_sent()) {
            wp_redirect($link);
            exit;
        }
    }

    echo siteorigin_panels_render($page->ID);
});

add_filter('search_result', function($args) {
    if(empty($args['query'])) {
        return;
    }

    $query = $args['query'];
    if(!have_posts() && !strlen($query)) {
        var_dump(__LINE__);
        return;
    }

    $posts = [];
    while(have_posts()) {
        the_post();
        if(!is_page()) {
            $posts[] = ['link'=>get_permalink(), 'title'=>get_the_title()];
        }
    }

    Template::feth('partials/search/content', [
        'posts' => $posts,
        'query' => $query,
    ], true);
});

add_filter('get_search_form', function($form) {
    return $form = Template::feth('partials/search/search', [
        'query'=>get_search_query()
    ]);
});