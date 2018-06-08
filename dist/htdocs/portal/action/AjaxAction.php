<?php

namespace action;

use common\Config;
use common\GlobalData;
use common\Language;
use common\Radius;
use vendor\validate\Required;
use vendor\http\Request;
use vendor\http\Response;
use common\WanDa;

class AjaxAction
{
    // 切换语言
    public function changeLang()
    {
        list($language) = Request::postAll(['language']);
        if (!Required::validate([$language])) {
            return Response::ajaxError('参数必填');
        }

        GlobalData::set([GlobalData::KEY_LANG => $language]);

        return Response::ajaxOk();
    }

    // 万达发送验证码
    public function sendVerifyCode()
    {
        if (!$this->checkWandaApi()) {
            return Response::ajaxError('接口不可用');
        }

        list($phone, $language, $countryCode) = Request::postAll(['phone', 'language', 'countryCode']);
        if (!Required::validate([$phone, $language, $countryCode])) {
            return Response::ajaxError('参数必填');
        }

        $result = WanDa::sendVerifyCode($phone, $language, $countryCode);
        if ($result['type'] == 'success') {
            return Response::ajaxOk(Language::t('信息发送成功'));
        }
        return Response::ajaxError($result['msg']);
    }

    // 会员认证
    public function memberIdentify()
    {
        if (!$this->checkWandaApi()) {
            return Response::ajaxError('接口不可用');
        }

        list($phone, $verifyCode, $userMac, $hotelCode) = Request::postAll(['phone', 'verifyCode', 'userMac', 'hotelCode']);
        if (!Required::validate([$phone, $verifyCode, $userMac, $hotelCode])) {
            return Response::ajaxError('参数必填');
        }

        $result = WanDa::memberIdentify($phone, $verifyCode, $hotelCode, $userMac);

        if ($result['type'] == 'success') {
            return Response::ajaxOk($result['msg']);
        }
        return Response::ajaxError($result['msg']);
    }

    // 会员注册
    public function memberRegister()
    {
        if (!$this->checkWandaApi()) {
            return Response::ajaxError('接口不可用');
        }

        list($phone, $hotelCode, $firstName, $lastName, $gender) = Request::postAll(['phone', 'hotelCode', 'firstName', 'lastName', 'gender']);
        if (!Required::validate([$phone, $hotelCode])) {
            return Response::ajaxError('参数必填');
        }

        $result = WanDa::memberRegister($phone, $firstName, $lastName, $gender, $hotelCode);
        if ($result['type'] == 'success') {
            return Response::ajaxOk($result['msg']);
        }
        return Response::ajaxError($result['msg']);
    }

    // 游客发送手机验证码
    public function sendRadiusSmsCode()
    {
        list($phone, $code, $lang) = Request::postAll(['phone', 'code', 'lang']);
        if (!Required::validate([$phone, $code, $lang])) {
            return Response::ajaxError('参数必填');
        }

        $result = Radius::sendSmsCode($phone, $code, $lang);
        if ($result['type'] == 'success') {
            return Response::ajaxOk(Language::t($result['msg']));
        }
        return Response::ajaxError($result['msg']);
    }

    // 手机号和验证码换用户信息
    public function phoneToUserId()
    {
        list($phone, $verifyCode) = Request::postAll(['phone', 'verifyCode']);
        if (!Required::validate([$phone, $verifyCode])) {
            return Response::ajaxError('参数必填');
        }

        $result = Radius::websCardByMobile($phone, $verifyCode);
        if ($result['type'] == 'success') {
            $data = $result['msg'];
            return Response::ajaxOk(['userId' => $data['cardNo'] ?: $phone, 'password' => $verifyCode]);
        }
        return Response::ajaxError($result['msg']);
    }

    // 会议码换用户信息
    public function meetingCodeToUserId()
    {
        list($code) = Request::postAll(['code']);
        if (!Required::validate([$code])) {
            return Response::ajaxError('参数必填');
        }

        $result = Radius::websGetCodeInfo($code);
        if ($result['type'] == 'success') {
            $data = $result['msg'];
            return Response::ajaxOk(['userId' => $data['userId'], 'password' => $data['password']]);
        }
        return Response::ajaxError($result['msg']);
    }

    // 万达会员换用户信息
    public function memberToUserId()
    {
        if (!$this->checkWandaApi()) {
            return Response::ajaxError('接口不可用');
        }
        list($phone, $memberCardNo) = Request::postAll(['phone', 'memberCardNo']);
        if (!Required::validate([$phone, $memberCardNo])) {
            return Response::ajaxError('参数必填');
        }

        $result = Radius::websGetCard($memberCardNo, $phone);
        if ($result['type'] == 'success') {
            $data = $result['msg'];
            return Response::ajaxOk(['userId' => $data['userId'], 'password' => $data['password']]);
        }
        return Response::ajaxError($result['msg']);
    }

    //房间号认证
    public function roomAuth()
    {
        if (!$this->checkWandaApi()) {
            return Response::ajaxError('接口不可用');
        }
        list($userId, $lastName) = Request::postAll(['userId', 'lastName']);
        if (!Required::validate([$userId, $lastName])) {
            return Response::ajaxError('参数必填');
        }
        // 用户帐号有效性验证
        $result = Radius::websGetAcctAuth($userId, $lastName);
        if ($result['type'] == 'error') {
            return Response::ajaxError($result['msg']);
        }
        $verifyTime = $result['msg']['time'];
        // 万达认证登记
        $registerResult = WanDa::identityRecordRegister(Config::WANDA_HOTEL_CODE, GlobalData::get(GlobalData::KEY_USER_MAC), $verifyTime, $userId, $lastName);
        if ($registerResult['type'] == 'error') {
            return Response::ajaxError($registerResult['msg']);
        }
        return Response::ajaxOk('success');
    }

    /**
     * @return bool
     */
    protected function checkWandaApi()
    {
        return Config::isWandaApiOn();
    }
}