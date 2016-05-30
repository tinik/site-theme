<?php

namespace Helpers;

class Message
{

    static public function admin($type, $message, $echo = true)
    {
        $pattern = '<div class="%s notice"><p>%s</p></div>';
        $handler = 'sprintf';
        if($echo === true) {
            $handler = 'printf';
        }

        return call_user_func_array($handler, [$pattern, $type, $message]);
    }
}