<?php

namespace common;

class Language
{
    /**
     * 翻译中文到其他语言
     * @param $cn
     * @param string $toLang
     * @return mixed
     */
    public static function t($cn, $toLang = null)
    {
        if (!$toLang) {
            $toLang = GlobalData::get(GlobalData::KEY_LANG);
        }
        $toLang = strtolower($toLang);
        if ($toLang == 'cn') {
            return $cn;
        }
        return static::$toLang($cn);
    }

    /**
     * @param $key
     * @return string
     */
    protected static function en($key)
    {
        $resource = [
            '参数不全' => 'Parameter is not complete',
            '当前环境不支持' => 'The current environment doesn\'t support',
            '信息发送成功' => 'Information sent successfully',
            '暂时无可用卡' => 'no available cards temporarily',
            '信息发送失败' => 'Failed to send message',
            '今日发送短信超出限额' => 'Messages snet today beyond the limit',
            '未开通短信发卡服务' => 'Message card service is not open',
            '重发数量已达上限' => 'The number of resend has reached the maximum',
            '未开通短信国际号码服务' => 'International Message service is not open',
            '换取用户信息失败' => 'In exchange for user information failure',
            '超出每日发送限制' => 'Beyond the daily delivery restrictions',
            '发送频率过快' => 'Sending frequency too fast',
            '验证码错误' => 'Verification code error',
            '非会员' => 'non-members',
            '会员的设备连接数超过限' => 'Members of the device to connect more than limit',
            '验证码失效，须重新发送' => 'Captcha failed, you must resend',
            '验证码错误次数超过限制，须重新发送' => 'The number of visits exceeds that limit, verification code error must be sent again',
            '已过期，须重新认证' => 'Has expired, you must to certification',
            '设备未认证' => 'Equipment of unauthorized',
            '手机已存在' => 'Mobile phone has been in existence',
            '会议码错误' => 'The meeting code error',
            '接口不可用' => 'The interface is not available',
            '验证码发送失败' => 'Verification code sent failure',
            '无效的请求' => 'Invalid Request',
            '预付卡绑定失败' => 'Card Bind Failed',
            '预付卡不可用' => 'Card Not Available',
            '用户信息不匹配' => 'User information does not match',
            '未知错误' => 'Unknow error',
        ];
        return isset($resource[$key]) ? $resource[$key] : '';
    }
}