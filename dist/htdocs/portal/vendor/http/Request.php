<?php

namespace vendor\http;

class Request
{
    /**
     * @param $name
     * @param null $defaultValue
     * @return null
     */
    public static function get($name, $defaultValue = null)
    {
        return isset($_GET[$name]) ? $_GET[$name] : $defaultValue;
    }

    /**
     * @param $names
     * @param null $defaultValue
     * @return array
     */
    public static function getAll($names, $defaultValue = null)
    {
        if (!is_array($names)) {
            $names = [$names];
        }
        $result = [];
        foreach ($names as $name) {
            $result[] = static::get($name, $defaultValue);
        }
        return $result;
    }

    /**
     * @param $name
     * @param null $defaultValue
     * @return null
     */
    public static function post($name, $defaultValue = null)
    {
        return isset($_POST[$name]) ? $_POST[$name] : $defaultValue;
    }

    /**
     * @param $names
     * @param null $defaultValue
     * @return array
     */
    public static function postAll($names, $defaultValue = null)
    {
        if (!is_array($names)) {
            $names = [$names];
        }
        $result = [];
        foreach ($names as $name) {
            $result[] = static::post($name, $defaultValue);
        }
        return $result;
    }
}