var body = $('body');
var uiDom = {
    languageContainer: '.language_switch',
    languageSwitch: '.language_switch span',
    setLanAttr: 'set-lan',
    tabSwitch: '.tab_nav',
    tabContent: '.tab_content',
    countryCodeChange: '.country_code',
    countryCodeContainer: '.state_code',
};

var toast = {
    error: function (msg) {
        $('.toast').text(msg).parent('.toast-container').show();
        setTimeout(function () {
            $('.toast-container').hide();
        }, 2000);
    },
    success: function (msg) {
        $('.toast').text(msg).parent('.toast-container').show();
        setTimeout(function () {
            $('.toast-container').hide();
        }, 2000);
    }
};

var formValidate = {
    required: function (formEl, onlyFields) {
        var isOk = true;
        $.each(formEl.find('input'), function () {
            if (onlyFields) {
                if ($.inArray($(this).attr('name'), onlyFields) < 0) {
                    return true;
                }
            }
            if (!$(this).attr('required')) {
                return true;
            }
            if (!$(this).val()) {
                toast.error('"' + $(this).attr('placeholder') + '"' + language.getValue('can_not_be_empty'));
                isOk = false;
                return false;
            }
        });
        return isOk;
    },
    clauseAgree: function (formEl) {
        var clause = formEl.find('input[name=clause]');
        if (!clause.prop('checked')) {
            toast.error(language.getValue('need_agree') + '"' + clause.parents('.clause_div').find('span').text() + '"');
            return false;
        }
        return true;
    }
};

var language = {
    init: function (config) {
        var def = {
            defaultLang: 'cn'
        };
        config = $.extend(def, config);
        this.set(config.defaultLang);
        this.change();
        var self = this;
        body.on('click', uiDom.languageSwitch, function () {
            self.set($(this).attr('id'));
            self.change();
            countryCode.setCountryCode();
        });
    },
    set: function (lang) {
        $(uiDom.languageContainer).attr('data-lang', lang);
    },
    get: function () {
        var lang = $(uiDom.languageContainer).attr('data-lang');
        return lang ? lang : 'cn';
    },
    getResource: function () {
        var lang = this.get();
        if (lang === 'en') {
            return languageResource.en;
        }
        return languageResource.cn;
    },
    getValue: function (key) {
        var t = this.getResource()[key];
        if (!t) {
            console.warn('未知的语言', this.get(), key);
            return '';
        }
        return t;
    },
    change: function () {
        var lang = this.get();
        var resource = this.getResource();
        $(uiDom.languageSwitch).removeClass('active');
        $('#' + lang).addClass('active');

        $('[' + uiDom.setLanAttr + ']').each(function () {
            var me = $(this),
                a = me.attr(uiDom.setLanAttr).split(':'),
                p = a[0], // 位置
                m = a[1], // 文字的key
                t = resource[m]; // 文字资源
            if (!t) {
                console.warn('未知的语言', lang, a);
                return true;
            }
            //文字放置位置有（html,val等，可以自己添加）
            switch (p) {
                case 'html':
                    me.html(t);
                    break;
                case 'val':
                case 'value':
                    me.val(t);
                    break;
                case 'placeholder':
                    me.attr('placeholder', t);
                    break;
                default:
                    me.html(t);
            }
        });
        api.changeLang(lang)
    }
};

var tabSwitch = {
    init: function (config) {
        var def = {
            isPc: false
        };
        config = $.extend(def, config);
        body.on('click', uiDom.tabSwitch, function (e) {
            e.preventDefault();
            $(uiDom.tabSwitch).removeClass('active');
            $(this).addClass('active');
            $(uiDom.tabContent).hide();
            $(uiDom.tabContent + $(this).data('id')).show();
            if (config.isPc) {
                $(this).find('img').hide();
                $(this).find('img.active').show();
                $(this).siblings(uiDom.tabSwitch).find('img').show();
                $(this).siblings(uiDom.tabSwitch).find('img.active').hide();
            } else {
                $(this).find('.icon').addClass('active');
                $(this).siblings(uiDom.tabSwitch).find('.icon').removeClass('active');
            }
        });
    }
};

var modal = {
    init: function (config) {
        var def = {
            showEl: '.modal_show',
            hideEl: '.modal_hide',
            modalEl: '.modal_box'
        };
        config = $.extend(def, config);
        if (config.showEl) {
            body.on('click', config.showEl, function () {
                $(config.modalEl).show();
                body.addClass('shade');
            });
        }
        $(config.modalEl).on('click', config.hideEl, function () {
            $(config.modalEl).hide();
            body.removeClass('shade');
        });
    }
};

var smsCode = {
    countDown: function (el, elAttr) {
        var time = 60,
            originText = el.text();
        el.text(time);
        el.attr(elAttr, 1);
        var interval = setInterval(function () {
            time--;
            if (time > 0) {
                el.text(time);
            } else {
                el.text(originText);
                clearInterval(interval);
                el.removeAttr(elAttr);
            }
        }, 1000);
    }
};

var countryCode = {
    init: function (config) {
        var def = {
            hiddenInputName: 'country_code'
        };
        config = $.extend(def, config);
        this.setCountryCode(config.isMobile);
        // 国家代码点击后显示
        body.on('click', uiDom.countryCodeChange, function () {
            var form = $(this).parents('form'),
                state = form.children(uiDom.countryCodeContainer);
            state.toggle('show', 0)
        });
        // 点击其他地方隐藏
        body.on('click', function (event) {
            var _con1 = $(uiDom.countryCodeChange),
                _con2 = $(uiDom.countryCodeContainer);
            if (!_con1.is(event.target) && _con1.has(event.target).length === 0
                && !_con2.is(event.target) && _con2.has(event.target).length === 0) {
                _con2.hide(300);
            }
        });
        //点击返回隐藏
        body.on('click', '.country_code_cancel, .select_title', function () {
            $(uiDom.countryCodeContainer).hide(300);
        })

        // 国家代码更换
        body.on('click', '.code_dd', function () {
            var _this = $(this),
                form = _this.parents('form'),
                value = _this.attr('code');
            form.find(uiDom.countryCodeChange + ' span').text('+' + value);
            _this.parents(uiDom.countryCodeContainer).hide();
            form.find('input[name=' + config.hiddenInputName + ']').val(value);
        });
        //国家代码控制滚动
        body.on('click', '.cell_nav li', function () {
            var _this = $(this),
                key = _this.text(),
                container = _this.parents(uiDom.countryCodeContainer),
                currTop = $('.cell').scrollTop(),
                dtTop = container.find('dt[key="' + key + '"]').eq(0).position().top;
            container.find('.cell').animate({scrollTop: dtTop + currTop}, 300);
        })
    },
    setCountryCode: function () {
        var countryCode = countryCodeResource[language.get()];
        var htmlI = '<i class="icon icon_back country_code_cancel"></i>';
        var htmlDl = '<dl class="cell">';
        var htmlUl = '<ul class="cell_nav">';
        $.each(countryCode, function (letter, arr) {
            htmlDl += '<dt key="' + letter + '"><span>' + letter + '</span></dt>';
            htmlUl += '<li>' + letter + '</li>';
            $.each(arr, function (index, item) {
                htmlDl += '<dd class="code_dd" key="' + item.label + '" code="' + item.value + '">'
                    + '<span>' + item.label + '</span>'
                    + '<span class="code">+' + item.value + '</span>'
                    + '</dd>';
            });
        });
        htmlUl += '</ul>';
        htmlDl += '<div class="bottom"></div></dl>';
        var html = '<div class="select_cell">'
            + htmlI
            + '<span class="select_title">' + language.getValue('choose_countries') + '</span>'
            + htmlDl + htmlUl
            + '</div>';
        $(uiDom.countryCodeContainer).html(html);
    }
};