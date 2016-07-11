<?php

use Helpers\TemplateTrait;

abstract class AbstractWidget extends \WP_Widget
{

    use TemplateTrait;

    protected function render($template, array $variables)
    {
        $path = sprintf('%s/%s', $this->path, $template);
        $this->feth($path, $variables, true);
    }

    /**
     *
     * @return string
     */
    protected function get_class()
    {
        return get_called_class();
    }

    /**
     * Register current widget in WordPress
     */
    static public function register()
    {
        $class_name = self::get_class();
        add_action('widgets_init', function() use(&$class_name){
            register_widget($class_name);
        });
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