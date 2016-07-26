<?php

namespace Widgets;

class Posts extends AbstractWidget
{

    protected $path = 'partials/widgets/posts';

    public function __construct()
    {
        $id = 'theme-custom-posts';
        $name = 'Theme Posts';

        parent::__construct($id, _($name), [
            'description' => _('Render blog posts'),
        ]);
    }

    /**
     * Front-end display of widget.
     * @see WP_Widget::widget()
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        $paged = max(1, get_query_var('paged'));

        $query = [
            'post_type'      => 'post',
            'post_status'    => ['publish'],
            'posts_per_page' => 10,
            'paged'          => $paged,
            'orderby'        => ['date'=>'DESC'],
        ];

        if(is_super_admin()) {
            $query['post_status'] = ['publish', 'future', 'draft', 'pending', 'private'];
        }

        $posts = query_posts($query);

        $this->render('widget', array_merge($instance, $args, [
            'paged' => $paged,
            'query' => $GLOBALS['wp_query'],
            'index' => $args['widget_id'],
        ]));

        wp_reset_query();
    }

    public function form($instance)
    {
        $types = apply_filters('widget_theme_post_content_types', [
            ''         => __('None',  'themes'),
            'title'    => __('Title', 'themes'),
            'featured' => __('Featured Image', 'themes'),
        ]);

        $this->render('form', [
            'instance' => $instance,
            'types'    => $types,
        ]);
    }
}
