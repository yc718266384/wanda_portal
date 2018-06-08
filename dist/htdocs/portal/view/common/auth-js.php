<?php

use common\GlobalData;

$url = GlobalData::get(GlobalData::KEY_URL);
$userVlan = GlobalData::get(GlobalData::KEY_USER_VLAN);
$userMac = GlobalData::get(GlobalData::KEY_USER_MAC);

$js = <<<JS
    var body = $('body');

    // 会员发送短信验证码
    body.on('click', '#member_get_code, #member_get_code2 ', function () {
        var form = $(this).parents('form'),
           phone = form.find('input[name=phone]').val(),
            countryCode = form.find('input[name=country_code]').val();
        if (formValidate.required(form, ['phone'])) {
            if($(this).attr('data-is-start')) {
                return;
            }
            var _this = $(this);
            api.sendVerifyCode(phone, countryCode, language.get(), function() {
               smsCode.countDown(_this, 'data-is-start')
            });
        }
    });
    // 会员注册提交
    body.on('click', '#member_register_submit', function () {
        var form = $(this).parents('form'),
            phone = form.find('input[name=phone]').val(),
            firstName = form.find('input[name=first_name]').val(),
            lastName = form.find('input[name=last_name]').val(),
            gender = form.find('input[name=sex]').val(),
            hotelCode = form.find('input[name=hotel_code]').val();
            countryCode = form.find('input[name=country_code]').val();
        if (formValidate.clauseAgree(form) && formValidate.required(form)) {
            api.memberRegister(
                phone, hotelCode, firstName, lastName, gender,
                function (data) {
                    api.memberToUserId(phone, data.memberCardNo, function (data) {
                        auth.userPassword(data.userId, data.password, 'intent', '{$url}');
                    });
                }
            );
        }
    });

    // 游客发送验证码
    body.on('click', '#visitor_get_code', function () {
        var form = $(this).parents('form'),
            phone = form.find('input[name=phone]').val(),
            countryCode = form.find('input[name=country_code]').val();
        if (formValidate.required(form, ['phone', 'country_code'])) {
            if($(this).attr('data-is-start')) {
                return;
            }
            var _this = $(this);
            api.sendRadiusSmsCode(phone, countryCode, language.get(), function() {
                smsCode.countDown(_this, 'data-is-start')
            });
        }
    });

    // 可以直接点击连接的情况
    body.on('click', '#member_already_auth', function () {
        var type = $(this).data('type'),
            phone = $(this).data('phone'),
            memberCardNo = $(this).data('card-no');
        if (type === 'member') {
            // 漫游会员已通过的认证
            api.memberToUserId(phone, memberCardNo, function (data) {
                auth.userPassword(data.userId, data.password, 'internet', '{$url}');
            });
        } else if(type === 'vpass') {
            // VPASS 已通过的认证
            auth.vlanPass('{$userVlan}', 'internet', '{$url}');
        } else {
            toast.error('未知的 type');
        }
    });
    
    // 房间认证
    body.on('click', '#room_auth', function () {
        var form = $(this).parents('form'),
            userId = form.find('input[name=userid]').val(),
            password = form.find('input[name=lastName]').val();
        if (formValidate.clauseAgree(form) && formValidate.required(form)) {
            api.roomAuth(userId, password, function() {
               auth.userPassword(userId, password, 'intent', '{$url}');
            });
        }
    });
    // 会员认证
    body.on('click', '#member_auth, #member_auth2', function () {
        var form = $(this).parents('form'),
            phone = form.find('input[name=phone]').val(),
            verifyCode = form.find('input[name=code]').val(),
            hotelCode = form.find('input[name=hotel_code]').val();
        if (formValidate.clauseAgree(form) && formValidate.required(form)) {
            api.memberIdentify(
                phone, verifyCode, '{$userMac}', hotelCode,
                function (data) {
                    console.log(data);
                    var code = data.code;
                    if(code == 0) {
                        api.memberToUserId(phone, data.memberCardNo, function (data) {
                            auth.userPassword(data.userId, data.password, 'intent', '{$url}');
                        });
                    } else if(code == 2) {
                        // 需要注册
                        $('#club_shade').find('input[name=phone]').val(phone);
                        $('#club_shade').find('.country_code_div span').text(form.find('.country_code a span').text());
                        $('#club_shade').show();
                    } else {
                        toast.error('状态未知');
                    }
                }
            );
        }
    });
    // 来访客人认证
    body.on('click', '#visitor_auth', function () {
        var form = $(this).parents('form'),
            phone = form.find('input[name=phone]').val(),
            verifyCode = form.find('input[name=code]').val();
        if (formValidate.clauseAgree(form) && formValidate.required(form)) {
            api.phoneToUserId(phone, verifyCode, function (data) {
                auth.userPassword(data.userId, data.password, 'intent', '{$url}');
            });
        }
    });
    // 会议认证
    body.on('click', '#meeting_auth', function () {
        var form = $(this).parents('form'),
            code = form.find('input[name=meeting_code]').val();
        if (formValidate.clauseAgree(form) && formValidate.required(form)) {
            api.meetingCodeToUserId(code, function (data) {
                auth.userPassword(data.userId, data.password, 'intent', '{$url}');
            });
        }
    });
JS;

echo $js;