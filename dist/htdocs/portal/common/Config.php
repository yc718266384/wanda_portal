<?php

namespace common;

class Config
{
    // 万达接口是否开启
    const WANDA_ON = true;
    // 万达的接口配置
    const WANDA_BASE_URL = 'http://crmdemo.wandahotels.com/crmapi/';
    const WANDA_SECRET = 'eEFLGCXd9o8ejVaZ4eC7s3m3DKaSIaRi';
    // 万达酒店 hotel_code
    const WANDA_HOTEL_CODE = '100';
    // 来访客人是否使用万达会员的流程
    const VISITOR_USE_WANDA = false;
    // 万达的短信接口是否使用国家码
    const WANDA_SMS_USE_COUNTRY_CODE = false;
    const WANDA_SMS_COUNTRY_CODE_NAME = 'areacode';

    /**
     * @return bool
     */
    public static function isWandaApiOn()
    {
        return static::WANDA_ON;
    }
}