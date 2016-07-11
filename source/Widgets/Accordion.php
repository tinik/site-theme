<?php

class Accordion extends AbstractWidget
{

    protected $path = 'partials/widgets/accordion';

    public function __construct()
    {
        parent::__construct('ThemeCustomAccordion', _('Theme Custom Accordion'), [
            'description' => _('Theme Custom Accordion')
        ]);
    }

    public function partial()
    {
        return $this->template('partial', []);
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
