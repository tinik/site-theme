<?php

namespace Helpers;

class Message
{

    const ERROR   = 'notice-error';
    const WARNING = 'notice-warning';
    const SUCCESS = 'notice-success';
    const INFO    = 'notice-info';

    static private $messages = [];

    static private $wrapper = '<div class="%s notice is-dismissible">%s<input type="button" class="notice-dismiss" /></div>';

    static public function set($type, $message)
    {
        self::$messages[$type][] = $message;
        return $message;
    }

    static public function get()
    {
        return self::$messages;
    }

    static public function messages($type = null)
    {
        $messages = self::$messages;
        if(is_string($type) && array_key_exists($type, self::$messages[$type])) {
            $messages = self::$messages[$type];
        }

        foreach($messages as $type=>$msgs) {
            if($msgs) {
                printf(self::$wrapper, $type, '<p>'.join('</p><p>', (array)$msgs).'</p>');
                unset(self::$messages[$type]);
            }
        }
    }

    static public function render($type, $message, $echo = true)
    {
        $pattern = sprintf(self::$wrapper, $type, '<p>%s</p>');
        $handler = 'sprintf';
        if($echo === true) {
            $handler = 'printf';
        }

        return call_user_func_array($handler, [$pattern, $message]);
    }
}