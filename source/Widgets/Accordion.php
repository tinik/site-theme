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
        $this->fetch('widget', array_merge($instance, $args, [
            'index' => $args['widget_id'],
        ]), true);
    }

    public function form($instance)
    {
        $this->fetch('form', $instance, true);
    }
}

// Register and load the widget?php
add_action('widgets_init', function() {
    register_widget(Accordion::class);
});