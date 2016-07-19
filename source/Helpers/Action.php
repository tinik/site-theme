<?php

namespace Helpers;

class Action
{

    public static function execute($handler, $args = null)
    {
        if(is_string($handler) && has_action($handler)) {
            return do_action($handler, $args);
        } elseif(is_callable($handler)) {
            if(!is_array($args)) {
                $args = [$args];
            }

            return call_user_func_array($handler, $args);
        } else {
            $name = is_string($handler) ? $handler : "Anonymous";
            throw new \RuntimeException($name . ' function was not found.');
        }
    }

    public static function is_callable($handler)
    {
        return is_callable($handler) || (is_string($handler) && has_action($handler));
    }
}
