<?php

namespace vendor\http;

class Session
{
    public static function set($key, $value)
    {
        static::startSession();
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        static::startSession();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : '';
    }

    protected static function startSession()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
}