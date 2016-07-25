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
        $content = '';
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

            include $path;

            $content = ob_get_contents();
            ob_end_clean();
        } catch (\Exception $ex) {
            ob_end_clean();
            throw $ex;
        }

        return $content;
    }

}