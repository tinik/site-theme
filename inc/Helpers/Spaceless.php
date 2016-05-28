<?php

namespace Helpers;

/**
 *
 * @see https://github.com/phoenixg/zf2/blob/master/vendor/twig/twig/lib/Twig/Node/Spaceless.php
 */
class Spaceless
{

    static public function content($content)
    {
        if(is_string($content)) {
            return trim(preg_replace('/>\s+</', '><', $content));
        }

        return $content;
    }

}