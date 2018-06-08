<?php

namespace common;

use vendor\http\Session;

class GlobalData
{
    public static $data;

    const KEY_URL = 'URL';
    const KEY_USER_MAC = 'MAC';
    const KEY_LANG = 'LANG';
    const KEY_USER_VLAN = 'VLAN';
    const KEY_USER_IP = 'IP';
    const KEY_STATUS = 'STATUS';
    const KEY_RADIUS_IP = 'RADIUS_IP';
    const KEY_G_USER_MAC = 'GLOBAL_USER_MAC';

    /**
     * @param array $data
     */
    public static function set($data = [])
    {
        foreach ($data as $key => $value) {
            static::$data[$key] = $value;
            Session::set($key, $value);
        }
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function get($key)
    {
        $value = isset(static::$data[$key]) ? static::$data[$key] : null;
        if (!$value) {
            $value = Session::get($key);
        }
        return $value;
    }
}