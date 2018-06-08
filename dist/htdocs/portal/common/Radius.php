<?php

namespace common;

class Radius
{
    /**
     * 发送验证码
     * @param $phone
     * @param $code
     * @param $lang
     * @return array
     */
    public static function sendSmsCode($phone, $code, $lang)
    {
        if (!$phone || !$code || !$lang) {
            return ['type' => 'error', 'msg' => '参数不全'];
        }
        $langMap = [
            'CN' => 'CN', 'cn' => 'CN', 'zh-CN' => 'CN',
            'EN' => 'EN', 'en' => 'EN',
        ];
        $lang = isset($langMap[$lang]) ? $langMap[$lang] : 'EN';
        $radiusIp = static::getRadiusIp();
        $userMac = static::getUserMac();

        $url = "http://{$radiusIp}:8080/user/portal/get_sms_code.php?Source=Portal&Mobile={$phone}&Code={$code}&Mac={$userMac}&Lang={$lang}";
        // 返回格式为：xml
        /** <?xml version="1.0" encoding="ISO-8859-1"?><Data><Result>False</Result><ErrorCode>-2</ErrorCode></Data> */
        /** <?xml version="1.0" encoding="ISO-8859-1"?><Data><Result>True</Result><ErrorCode>0</ErrorCode></Data> */
        $content = file_get_contents($url);
        if (!$content) {
            return ['type' => 'error', 'msg' => '当前环境不支持:' . $url];
        }
        $result = static::xml2arr($content);

        if (strtolower($result['Result']) == "true") {
            return ['type' => 'success', 'msg' => '信息发送成功'];
        } else {
            $errorCodeMap = [
                -1 => '暂时无可用卡',
                -2 => '信息发送失败',
                -3 => '今日发送短信超出限额',
                -4 => '未开通短信发卡服务',
                -5 => '重发数量已达上限',
                -6 => '未开通短信国际号码服务',
            ];
            return ['type' => 'error', 'msg' => Functions::mapValue($errorCodeMap, $result['ErrorCode'])];
        }
    }

    /**
     * 手机号换用户信息
     * @param $phone
     * @param $code
     * @return array
     */
    public static function websCardByMobile($phone, $code)
    {
        $radiusIp = static::getRadiusIp();
        $url = "http://{$radiusIp}:8080/user/portal/get_card_by_mobile.php?Source=Portal&Mobile={$phone}&Code={$code}";
        // 返回格式为：xml
        /** <?xml version="1.0" encoding="ISO-8859-1"?><Data><Result>false</Result><CardNo>N/A</CardNo></Data> */
        /** <?xml version="1.0" encoding="ISO-8859-1"?><Data><Result>true</Result><CardNo>0501</CardNo></Data> */
        $content = file_get_contents($url);
        if (!$content) {
            return ['type' => 'error', 'msg' => '当前环境不支持:' . $url];
        }
        $result = static::xml2arr($content);

        if (strtolower($result['Result']) == "true") {
            return ['type' => 'success', 'msg' => ['cardNo' => $result['CardNo']]];
        } else {
            //return ['type' => 'error', 'msg' => Language::t('当前环境不支持')];
            return ['type' => 'success', 'msg' => ['cardNo' => '']];
        }
    }

    /**
     * 会议码换用户信息
     * @param $code
     * @return array
     */
    public static function websGetCodeInfo($code)
    {
        $code = trim($code);
        if ($code == "") {
            return ['type' => 'error', 'msg' => 'code 必须'];
        }
        $radiusIp = static::getRadiusIp();
        $url = "http://{$radiusIp}:8080/user/portal/get_uid_by_code.php?type=js&code={$code}";
        // 返回的值为 getCode(""， "");
        $content = file_get_contents($url);
        $contentArr = explode('"', $content);
        $userId = $contentArr[1];
        $password = $contentArr[3];
        if (!$userId || !$password) {
            return ['type' => 'error', 'msg' => '会议码错误'];
        }
        return ['type' => 'success', 'msg' => ['userId' => $userId, 'password' => $password]];
    }

    /**
     * 预付卡申请
     * @param $creNo
     * @param $mobileNo
     * @param int $creLevel
     * @param int $creType
     * @return array
     */
    public static function websGetCard($creNo, $mobileNo, $creLevel = 0, $creType = 7)
    {
        if (!$creNo || !$mobileNo) {
            return ['type' => 'error', 'msg' => '参数不全'];
        }

        $radiusIp = static::getRadiusIp();
        $url = "http://{$radiusIp}:8080/user/portal/getCard.php?type=js&cretype={$creType}&creno={$creNo}&crelevel={$creLevel}&mobileno={$mobileNo}";

        $content = file_get_contents($url);
        $result = json_decode($content, true);

        if ($result['code'] === 0) {
            return ['type' => 'success', 'msg' => ['userId' => $result['userid'], 'password' => $result['passwd']]];
        }
        $errorCodeMap = [
            1 => '预付卡不可用',
            8 => '预付卡绑定失败',
            9 => '无效的请求',
        ];
        return ['type' => 'error', 'msg' => Functions::mapValue($errorCodeMap, $result['code'])];
    }

    /**
     * 获取住店日期
     * @param $userId
     * @return array
     */
    public static function websGetCheckinDate($userId)
    {
        if ($userId == '') {
            return ['type' => 'error', 'msg' => '用户账号必须'];
        }
        $radiusIp = static::getRadiusIp();
        $url = "http://{$radiusIp}:8080/user/portal/get_checkin_date.php?type=js&userid={$userId}";
        $content = file_get_contents($url);
        $result = json_decode($content, true);
        if ($result['code'] === 0) {
            return ['type' => 'success', 'msg' => $result['checkindate']];
        }
        $errorCodeMap = [
            8 => '没有记录',
            9 => '附带请求',
            10 => '未知错误',
        ];
        return ['type' => 'error', 'msg' => Functions::mapValue($errorCodeMap, $result['code'])];
    }

    /**
     * 用户帐号有效性验证
     * @param $userId
     * @param $password
     * @return array
     */
    public static function websGetAcctAuth($userId, $password)
    {
        if (!$userId || !$password) {
            return ['type' => 'error', 'msg' => '参数不全'];
        }
        $radiusIp = static::getRadiusIp();
        $url = "http://{$radiusIp}:8080/user/portal/getAcctAuth.php?type=js&userid={$userId}&passwd={$password}";
        $content = file_get_contents($url);
        $result = json_decode($content, true);

        if ($result['code'] === 0) {
            return ['type' => 'success', 'msg' => ['time' => time()]];
        }
        $errorCodeMap = [
            8 => '用户信息不匹配',
            9 => '无效的请求',
            10 => '未知错误',
        ];
        return ['type' => 'error', 'msg' => Functions::mapValue($errorCodeMap, $result['code'])];
    }

    /**
     * @param null $userId
     * @param null $password
     * @return array
     */
    protected static function setReturn($userId = null, $password = null)
    {
        return ['userId' => $userId, 'password' => $password];
    }

    /**
     * @return mixed
     */
    protected static function getRadiusIp()
    {
        return GlobalData::get(GlobalData::KEY_RADIUS_IP);
    }

    /**
     * @return string
     */
    protected static function getUserMac()
    {
        $mac = GlobalData::get(GlobalData::KEY_USER_MAC);
        if (strlen($mac) == 12) {
            $mac_array = str_split($mac, 2);
            $str_mac = '';
            $i = 0;
            foreach ($mac_array as $key => $val) {
                if ($i != 0) $str_mac .= ':';
                $str_mac .= $val;
                $i++;
            }
            return $str_mac;
        } else {
            return $mac;
        }
    }

    /**
     * @param $xml
     * @return array
     */
    protected static function xml2arr($xml)
    {
        libxml_disable_entity_loader(true);
        $xmlStr = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $val = json_decode(json_encode($xmlStr), true);
        return $val;
    }
}