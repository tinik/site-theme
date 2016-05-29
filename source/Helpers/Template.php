<?php

namespace Helpers;

class Template
{

    static public function locate($name)
    {
        $pattern = sprintf('%s.php', $name);
        return locate_template($pattern);
    }

    static public function feth($name, array $variables = [], $display = false)
    {
        $template = self::locate($name);

        $vars = new \ArrayObject($variables);

        $cache = '';
        ob_start();
        if (is_file($template) && file_exists($template)) {
            extract($variables);
            include ($template);
        }
        $cache = ob_get_contents();
        ob_end_clean();

        if($display) {
            echo $cache;
        }

        return $cache;
    }

}