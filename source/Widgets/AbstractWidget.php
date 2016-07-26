<?php

namespace Widgets;

use Helpers\TemplateTrait;

abstract class AbstractWidget extends \WP_Widget
{

    use TemplateTrait;

    public function __construct($id, $name, $widget = [], $options = [])
    {
        parent::__construct($id, $name, array_merge([
            'panels_groups' => ['theme-bundle'],
            'groups'        => ['theme-bundle'],
            'plugin' => [
                'name' => _('Theme Widgets Bundle'),
                'slug' => 'theme-bundle'
            ],
        ], $widget), $options);

        do_action('widgets_initialize_widget_' . $id, $this);
    }

    protected function render($template, array $variables = [])
    {
        $path = sprintf('%s/%s', $this->path, $template);
        echo $this->content($path, $variables);
    }

    /**
     *
     * @return string
     */
    static protected function get_class()
    {
        return get_called_class();
    }

    /**
     * Register current widget in WordPress
     */
    static public function register()
    {
        $class_name = static::get_class();
        add_action('widgets_init', function() use(&$class_name){
            register_widget($class_name);
        });
    }
}
