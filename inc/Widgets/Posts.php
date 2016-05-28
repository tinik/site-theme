<?php

class Posts extends \AbstractWidget
{

    protected $path = 'partials/widgets/posts';

    public function __construct()
    {
        parent::__construct('ThemeCustomPosts', _('Theme Custom Posts'), [
            'description' => _('Theme Custom Posts')
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

        $posts = query_posts([
            'post_type'      => 'post',
            'post_status'    => ['publish'],
            'posts_per_page' => 10,
            'paged'          => $paged,
            'orderby'        => ['date'=>'DESC'],
        ]);

        $this->fetch('widget', array_merge($instance, $args, [
            'paged' => $paged,
            'query' => $GLOBALS['wp_query'],
            'index' => $args['widget_id'],
        ]), true);

        wp_reset_query();
    }

    public function form($instance)
    {
        $types = apply_filters('widget_theme_post_content_types', [
            ''         => __('None', 'themes'),
            'title'    => __('Title', 'themes'),
            'featured' => __('Featured Image', 'themes'),
        ]);

        $this->fetch('form', [
            'instance' => $instance,
            'types'    => $types,
        ], true);
    }
}

// Register and load the widget?php
add_action('widgets_init', function() {
    register_widget(Posts::class);
});