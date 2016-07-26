<?php

namespace Widgets;

class Accordion extends AbstractWidget
{

    protected $path = 'partials/widgets/accordion';

    public function __construct()
    {
        $id = 'theme-custom-accordion';
        $name = 'Theme Accordion';

        parent::__construct($id, _($name), [
            'description' => _('Create "accordion" widget'),
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
        return $this->render('widget', array_merge($instance, $args, [
            'index' => $args['widget_id'],
        ]));
    }

    public function form($instance)
    {
        return $this->render('form', $instance);
    }
}
