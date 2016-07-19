<?php

namespace Helpers;

class GlobalStorage
{

    protected static $_data = [];

    static public function data()
    {
        return static::$_data;
    }

    /**
     *
     * @param string $key
     * @param string $group
     * @return bool
     */
    public static function has($key, $group = 'global')
    {
        return isset(static::$_data[$group][$key]);
    }

    /**
     *
     * @param string $key
     * @param mixed $value
     * @param string $group
     */
    public static function set($key, $value, $group = 'global')
    {
        static::$_data[$group][$key] = $value;
    }

    /**
     *
     * @param string $key
     * @param string $group
     * @return mixed
     */
    public static function get($key, $group = 'global')
    {
        if (! static::has($key, $group)) {
            return null;
        }

        return static::$_data[$group][$key];
    }

}
