<?php

use Helpers\Spaceless;

abstract class AbstractWidget extends WP_Widget
{

    protected function fetch($type, array $vars, $display = false)
    {
        $cache = '';
        ob_start();
        $this->template($type, $vars);
        $cache = ob_get_contents();
        ob_end_clean();

        if($display === true) {
            echo Spaceless::content($cache);
        }

        return Spaceless::content($cache);
    }

    protected function template($type, array $vars)
    {
        $pattern = sprintf('%s/%s', $this->path, $type);

        $template = Helpers\Template::locate($pattern);
        if(is_file($template) && file_exists($template)) {
            extract($vars);
            return include($template);
        }

        throw new Exception(sprintf('Not found template %s', $template));
    }

}