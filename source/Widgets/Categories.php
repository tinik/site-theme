<?php

class Categories extends AbstractWidget
{

    protected $path = 'partials/widgets/categories';

    public function __construct()
    {
        // Name
        $widgetName = _('Theme Custom Categories');

        parent::__construct('ThemeCustomCategories', $widgetName, array(
            'description' => _('A side-nav list categories')
        ));
    }

    /**
     * Front-end display of widget.
     * @see WP_Widget::widget()
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        $instance['categories'] = get_categories([
            'orderby'      => 'name',
            'order'        => 'ASC',
            'child_of'     => 0,
            'parent'       => '',
            'hierarchical' => 1,
            'hide_empty'   => 1,
        ]);

        $this->fetch('widget', array_merge($instance, $args), true);
    }

    /**
     * Back-end widget form.
     * @see WP_Widget::form()
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {
        $this->fetch('form', $instance, true);
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new Values just sent to be saved.
     * @param array $old Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new, $old)
    {
        return $new;
    }
}

// Register and load the widget?php
add_action('widgets_init', function() {
    register_widget(Categories::class);
});
