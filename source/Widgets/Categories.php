<?php

namespace Widgets;

class Categories extends AbstractWidget
{

    protected $path = 'partials/widgets/categories';

    public function __construct()
    {
        // Name
        $widgetName = _('Theme Categories');

        parent::__construct('theme-custom-categories', $widgetName, [
            'classname'   => 'Categories',
            'description' => _('A side-nav list categories')
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
        $instance['categories'] = get_categories([
            'orderby'      => 'name',
            'order'        => 'ASC',
            'child_of'     => 0,
            'parent'       => '',
            'hierarchical' => 1,
            'hide_empty'   => 1,
        ]);

        $this->render('widget', array_merge($instance, $args));
    }

    /**
     * Back-end widget form.
     * @see WP_Widget::form()
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {
        $this->render('form', $instance);
    }
}
