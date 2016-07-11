<?php

namespace Helpers;

trait TemplateTrait
{

    static public function locate($name)
    {
        $pattern = sprintf('%s.php', $name);
        return locate_template($pattern);
    }

    static public function feth($name, array $variables = [], $display = false)
    {
        $locate = $template = self::locate($name);
        if (!is_file($template) || !file_exists($template)) {
            throw new \RuntimeException(sprintf('Not found %s', $name));
        }

        $vars = new \ArrayObject($variables);
        do_action('fetch_template', [
            'name' => $name,
            'vars' => $vars
        ]);

        $variables = $vars->getArrayCopy();

        $cache = '';
        ob_start();

        extract($variables);
        include ($template);

        $cache = ob_get_contents();
        ob_end_clean();

        if ($display) {
            echo $cache;
            return;
        }

        return $cache;
    }

}