var baseUrl = 'portal/ajax.php';

var request = {
    get: function (action, params, successCallback) {
        $.get(baseUrl + '?a=' + action, params, function (data) {
            if (data.code === 200) {
                successCallback(data.data);
            } else {
                toast.error(data.msg);
            }
        }, 'json');
    },
    post: function (action, params, successCallback) {
        $.post(baseUrl + '?a=' + action, params, function (data) {
            if (data.code === 200) {
                successCallback ? successCallback(data.data) : '';
            } else {
                toast.error(data.msg);
            }
        }, 'json');
    }
};

var api = {
    changeLang: function (language) {
        request.post('changeLang', {language: language})
    },
    sendVerifyCode: function (phone, countryCode, language, successCallback) {
        request.post('sendVerifyCode', {
            phone: phone,
            countryCode: countryCode,
            language: language
        }, function (data) {
            toast.success(data);
            successCallback();
        })
    },
    memberIdentify: function (phone, verifyCode, userMac, hotelCode, successCallback) {
        request.post('memberIdentify', {
            phone: phone,
            verifyCode: verifyCode,
            userMac: userMac,
            hotelCode: hotelCode
        }, function (data) {
            successCallback(data)
        })
    },
    memberRegister: function (phone, hotelCode, firstName, lastName, gender, successCallback) {
        request.post('memberRegister', {
            phone: phone,
            hotelCode: hotelCode,
            firstName: firstName,
            lastName: lastName,
            gender: gender
        }, function (data) {
            successCallback(data)
        })
    },
    sendRadiusSmsCode: function (phone, code, lang, successCallback) {
        request.post('sendRadiusSmsCode', {phone: phone, code: code, lang: lang}, function (data) {
            toast.success(data);
            successCallback();
        })
    },
    memberToUserId: function (phone, memberCardNo, successCallback) {
        request.post('memberToUserId', {phone: phone, memberCardNo: memberCardNo}, function (data) {
            successCallback(data)
        })
    },
    phoneToUserId: function (phone, verifyCode, successCallback) {
        request.post('phoneToUserId', {
            phone: phone,
            verifyCode: verifyCode
        }, function (data) {
            successCallback(data)
        })
    },
    meetingCodeToUserId: function (code, successCallback) {
        request.post('meetingCodeToUserId', {
            code: code
        }, function (data) {
            successCallback(data)
        })
    },
    roomAuth: function (userId, lastName, successCallback) {
        request.post('roomAuth', {
            userId: userId,
            lastName: lastName
        }, function (data) {
            successCallback(data)
        })
    }
};

var auth = {
    createFormAndSubmit: function (action, params) {
        var form = document.createElement('form');
        form.action = action;
        form.method = 'post';
        var hiddenInput;
        $.each(params, function (k, v) {
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = k;
            hiddenInput.value = v;
            form.appendChild(hiddenInput);
        });
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    },
    userPassword: function (userId, password, service, url) {
        this.createFormAndSubmit('/fcgi/websAuth', {
            userid: userId,
            passwd: password,
            service: service,
            url: url
        });
    },
    vlanPass: function (vlanId, service, url) {
        this.createFormAndSubmit('/fcgi/websVlanAuth', {
            vlanid: vlanId,
            service: service,
            url: url
        });
    }
};
