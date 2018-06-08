<?php

namespace vendor\http;

use common\Language;

class Response
{
    /**
     * @param null $data
     * @param string $msg
     * @return string
     */
    public static function ajaxOk($data = null, $msg = 'ok')
    {
        return json_encode(['code' => 200, 'msg' => $msg, 'data' => $data]);
    }

    /**
     * @param $msg
     * @return string
     */
    public static function ajaxError($msg)
    {
        return json_encode(['code' => 422, 'msg' => Language::t($msg)]);
    }
}