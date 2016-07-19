<?php

namespace Widgets;

class Accordion extends AbstractWidget
{

    protected $path = 'partials/widgets/accordion';

    public function __construct()
    {
        parent::__construct('theme-custom-accordion', _('Theme Accordion'), [
            'classname'   => 'Accordion',
            'description' => _('Create "accordion" widget')
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
        $this->render('widget', array_merge($instance, $args, [
            'index' => $args['widget_id'],
        ]));
    }

    public function form($instance)
    {
        $this->render('form', $instance);
    }
}
