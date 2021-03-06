<?php

    use Helpers\Template;
    use Helpers\Spaceless;
    use Options\OptionBox;

    define('SITE_NAME', basename(__DIR__));

    /** @var \Composer\Autoload\ClassLoader $autoload */
    $autoload = require_once __DIR__ . '/vendor/autoload.php';

    function assets_uri($path, $display = false) {
        $uri = sprintf('%s/assets/build/%s', get_template_directory_uri(), $path);
        if($display === true) {
            print $uri;
        }

        return $uri;
    }

    // Registration widgets
    Widgets\Accordion::register();
    Widgets\Posts::register();

    add_action('wp_head', function() {
        $source = OptionBox::get('meta')->get_value('head_code');
        if($source) {
            echo $source;
        }
    });

    add_action('init', function() {
        if(!is_user_logged_in()) {
            add_filter('autoptimize_filter_css_replacetag', create_function('$replacetag', 'return ["</head>","before"];'),10,1);
        }

        add_filter('autoptimize_css_include_inline',    create_function(null, 'return true;'), 10,1);
        add_filter('autoptimize_css_do_minify',         create_function(null, 'return true;'), 10,1);

        add_filter('autoptimize_filter_js_replacetag',  create_function('$replacetag', 'return ["</footer>","after"];'),10,1);
        add_filter('autoptimize_js_do_minify',          create_function(null, 'return true;'), 10,1);

        // clean up the <head>
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'wp_generator');

        // menu fallback
        register_nav_menus([
            'header' => 'Header Menu',
            'footer' => 'Footer Menu',
        ]);

        if(!is_admin()) {
            // Registration js library
            wp_enqueue_script('theme', assets_uri('js/theme.js'), ['jquery'], '1.3.6', true);

            // Registration css library
            wp_enqueue_style('styles', get_stylesheet_uri(), [], '1.3.6');
        }
    });

    add_action('widget_nav_menu_args', function($args) {
        return array_merge($args, [
            'menu_class' => 'menu align-right',
            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        ]);
    });

    add_filter('nav_menu_css_class' , function($classes, $item){
        if(in_array('current-menu-item', $classes) ){
            $classes[] = 'active ';
        }

        return $classes;
    }, 10 , 2);

    add_action('wp_nav_menu', function($output) {
        return @Template::fetch('partials/menu-header', [
            'output'=>Spaceless::content($output)
        ]);
    });

    add_filter('the_content', function($content) {
        return Spaceless::content($content);
    });

    // setup footer widget area
    if (function_exists('register_sidebar')) {
        register_sidebar([
            'id'            => 'widgets_header',
            'name'          => 'Header Widgets',
            'description'   => 'Header Widget Area',
            'before_widget' => '<div id="%1$s" class="side-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>'
        ]);

        register_sidebar([
            'id'            => 'widgets_sidebar',
            'name'          => 'Side Widgets',
            'description'   => 'Side Widget Area',
            'before_widget' => '<div id="%1$s" class="side-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>'
        ]);

        register_sidebar([
            'id'            => 'widgets_footer',
            'name'          => 'Footer Widgets',
            'description'   => 'Footer Widget Area',
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>'
        ]);
    }

    add_action('siteorigin_panels_widget_dialog_tabs', function($tabs) {
        $tabs['theme-bundle'] = [
            'title' => _('Theme Bundle'),
            'filter' => [
                'groups' => ['theme-bundle']
            ]
        ];

        return $tabs;
    });

    function create_pagination(WP_Query $query, $paged, $range = 2) {
        $showitems = ($range * 2) + 1;
        if (empty($paged)) {
            $paged = 1;
        }

        $pages = $query->max_num_pages;
        if(!$pages) {
            $pages = 1;
        }

        if (1 != $pages) {
            echo '<div>';
            echo '<ul class="pagination text-center" role="navigation" aria-label="Pagination">';

            if(($paged-1) > 0) {
                echo '<li class="pagination-previous hide-for-large"><a href="'. get_pagenum_link($paged-1) .'" aria-label="Previous page">Previous</a></li>';
            }

            if ($paged > 2 && $paged > $range + 1 && $showitems < $pages) {
                echo '<li class="arrow"><a href="' . get_pagenum_link(1) . '">1</a></li>';
                echo '<li class="ellipsis"></li>';
            }

            foreach(range(1, $pages) as $i) {
                if (1 != $pages && (! ($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
                    if($paged == $i) {
                        echo '<li class="current" aria-label="Page '. $i .'">'. $i .'</li>';
                    } else {
                        echo '<li><a href="'. get_pagenum_link($i) .'">'. $i .'</a></li>';
                    }
                }
            }

            if ($paged < $pages - 2 && $paged + $range - 1 < $pages && $showitems < $pages) {
                echo '<li class="ellipsis"></li>';
                echo '<li class="arrow"><a href="' . get_pagenum_link($pages) . '">'. $pages .'</a></li>';
            }

            if($paged < $pages) {
                echo '<li class="pagination-next hide-for-large"><a href="'. get_pagenum_link($paged+1) .'" aria-label="Next page">Next</a></li>';
            }

            echo '</ul>';
            echo '</div>';
        }
    };

    // pagination
    function custom_pagination($pages = '', $range = 2)
    {
        global $paged;
        $showitems = ($range * 2) + 1;
        if (empty($paged)) {
            $paged = 1;
        }

        if ($pages == '') {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if(!$pages) {
                $pages = 1;
            }
        }

        if (1 != $pages) {
            echo '<div>';
            echo '<ul class="pagination text-center" role="navigation" aria-label="Pagination">';
            if ($paged > 2 && $paged > $range + 1 && $showitems < $pages) {
                echo "<li class='arrow'><a href='". get_pagenum_link(1) ."'>1</a></li>";
                echo "<li class='unavailable'><a href='#'>&hellip;</a></li>";
            }

            foreach(range(1, $pages) as $i) {
                if (1 != $pages && (! ($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
                    if($paged == $i) {
                        echo "<li class='current'>". $i ."</li>";
                    } else {
                        echo "<li><a href='". get_pagenum_link($i) ."'>". $i ."</a></li>";
                    }
                }
            }

            if ($paged < $pages - 2 && $paged + $range - 1 < $pages && $showitems < $pages) {
                echo "<li class='unavailable'><a href='#'>&hellip;</a></li>";
                echo "<li class='arrow'><a href='". get_pagenum_link($pages) ."'>". $pages ."</a></li>";
            }
            echo "</ul>";
            echo '</div>';
        }
    }

    function get_theme_custom_tags($post_id = null) {
        if(!$post_id) {
            global $post;
            $post_id = $post->ID;
        }

        if($post_id) {
            $posttags = wp_get_post_tags($post_id);
            $tags = array_map(function($tag) {
                return vsprintf('<a href="%s"><span class="radius secondary label">%s</span></a>', [
                    get_tag_link($tag->term_id),
                    $tag->name
                ]);
            }, $posttags);

            if($tags) {
                echo sprintf('<i class="fi-pricetag-multiple"></i> %s', join(' ', $tags));
            }
        }
    }
