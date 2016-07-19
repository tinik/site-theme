<?php

namespace Helpers;

trait TemplateTrait
{

    static public function locate($name)
    {
        $pattern = sprintf('%s.php', $name);
        return locate_template($pattern);
    }

    static public function fetch($name, array $variables = [], $display = false)
    {
        $content = self::content($name, $variables);
        if ($display) {
            echo $content;
        }

        return $content;
    }

    public function content($name, array $variables = [])
    {
        try {
            $path = static::locate($name);
            if (!is_file($path) || !file_exists($path)) {
                throw new \RuntimeException(sprintf('Not found %s', $name));
            }

            $vars = new \ArrayObject($variables);
            do_action('tempalte_prepare', [
                'name' => $name,
                'vars' => $vars
            ]);

            extract($vars->getArrayCopy());

            ob_start();
            require $path;
            $content = ob_get_clean();
        } catch (\Exception $ex) {
            ob_end_clean();
            throw $ex;
        }

        return $content;
    }

}