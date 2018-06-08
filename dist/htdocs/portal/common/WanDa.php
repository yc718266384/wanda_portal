<?php

namespace common;

class WanDa
{
    /**
     * 发送验证码
     * @param $phone
     * @param $language
     * @param string $countryCode
     * @return array
     */
    public static function sendVerifyCode($phone, $language, $countryCode = '86')
    {
        $params = [
            'phone' => $phone,
            'language' => $language,
        ];
        if (Config::WANDA_SMS_USE_COUNTRY_CODE) {
            $params[Config::WANDA_SMS_COUNTRY_CODE_NAME] = $countryCode;
        }
        $result = static::sendRequest('sendVerifyCode', $params);
        $codeMap = [
            1 => '超出每日发送限制',
            2 => '发送频率过快',
        ];
        return static::formatResult($result, $codeMap);
    }

    /**
     * 会员认证
     * @param $phone
     * @param $hotelCode
     * @param $verifyCode
     * @param $mac
     * @return array
     */
    public static function memberIdentify($phone, $verifyCode, $hotelCode, $mac)
    {
        $result = static::sendRequest('memberIdentify', [
            'phone' => $phone,
            'hotelCode' => $hotelCode,
            'verifyCode' => $verifyCode,
            'mac' => $mac,
        ]);
        $codeMap = [
            1 => '验证码错误',
            3 => '会员的设备连接数超过限',
            4 => '验证码失效，须重新发送',
            5 => '验证码错误次数超过限制，须重新发送',
        ];
        return static::formatResult($result, $codeMap, [0, 2]);
    }

    /**
     * 漫游状态 查询
     * @param $mac
     * @param $hotelCode
     * @return array
     */
    public static function queryRoamStatus($mac, $hotelCode)
    {
        $result = static::sendRequest('queryRoamStatus', [
            'mac' => $mac,
            'hotelCode' => $hotelCode,
        ], false);
        $codeMap = [
            1 => '已过期，须重新认证',
            2 => '设备未认证',
        ];
        return static::formatResult($result, $codeMap);
    }

    /**
     * 会员注册
     * @param $phone
     * @param $hotelCode
     * @param $firstName
     * @param $lastName
     * @param $gender
     * @return array
     */
    public static function memberRegister($phone, $firstName, $lastName, $gender, $hotelCode)
    {
        $result = static::sendRequest('memberRegister', [
            'phone' => $phone,
            'hotelCode' => $hotelCode,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'gender' => $gender,
        ]);
        $codeMap = [
            1 => '手机已存在',
        ];
        return static::formatResult($result, $codeMap);
    }

    /**
     * 认证信息登记
     * @param $hotelCode
     * @param $mac
     * @param $verifyTime
     * @param $checkinTime
     * @param $roomNumber
     * @param $lastName
     * @param $mobile
     * @param $email
     * @return array
     */
    public static function identityRecordRegister($hotelCode, $mac, $verifyTime, $roomNumber = null, $lastName = null, $mobile = null, $email = null)
    {
        $checkinDate = Radius::websGetCheckinDate($roomNumber);

        if ($checkinDate['type'] == 'error') {
            return $checkinDate;
        }
        $checkinTime = $checkinDate['msg'];
        $result = static::sendRequest('identityRecord', [
            'hotelCode' => $hotelCode,
            'mac' => $mac,
            'verifyTime' => date('Y-m-d H:i:s', $verifyTime),
            'checkinTime' => date('Y-m-d H:i:s', $checkinTime),
            'roomNumber' => $roomNumber ?: '',
            'lastName' => $lastName ?: '',
            'mobile' => $mobile ?: '',
            'email' => $email ?: '',
        ], true);
        return static::formatResult($result, []);
    }

    /**
     * @param $result
     * @param $errorCodeMap
     * @param array $successCode
     * @return array
     */
    protected static function formatResult($result, $errorCodeMap, $successCode = [0])
    {
        if ($result['status'] == 'success') {
            if (isset($result['code'])) {
                if (in_array($result['code'], $successCode)) {
                    return ['type' => 'success', 'msg' => $result];
                }
                return ['type' => 'error', 'msg' => Functions::mapValue($errorCodeMap, $result['code'], '未知错误')];
            } else {
                return ['type' => 'success'];
            }
        }
        return ['type' => 'error', 'msg' => $result['errorMessage']];
    }


    /**
     * @param $relativeUrl
     * @param null|array $data
     * @param bool $isPost
     * @return array
     */
    protected static function sendRequest($relativeUrl, $data = null, $isPost = true)
    {
        $url = Config::WANDA_BASE_URL . $relativeUrl;
        $url .= '?sign=' . static::make($data, !$isPost);

        if (!$isPost && $data) {
            $url .= '&' . urldecode(http_build_query($data));
        }
        /*echo $url . PHP_EOL;
        echo json_encode($data);
        exit;*/
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSLVERSION, 1);

        if ($isPost) {
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data) {
                $dataJson = json_encode($data);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $dataJson);
                //echo $dataJson;exit;
                curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            }
        }

        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $res = curl_exec($curl);
        curl_close($curl);
        return json_decode($res, true);
    }

    /**
     * 生成secretKey
     * @param array $data 数组
     * @param bool $keyValueToLowerCase 是否要把 key 和 value 都转为小写
     * @return string|boolean
     */
    protected static function make($data, $keyValueToLowerCase = false)
    {
        $secret = Config::WANDA_SECRET;
        if ($keyValueToLowerCase) {
            $data = array_change_key_case($data);
            $data = array_map(function ($v) {
                return strtolower($v);
            }, $data);
        }
        ksort($data);
        $str = urldecode(http_build_query($data));
        //echo $str;exit;
        $str = $secret . $str . $secret;
        $secretKey = strtoupper(md5($str));
        return $secretKey;
    }
}