<?php
/** @var $authOk boolean */

/** @var $authOkParams array */

use common\GlobalData;

?>
<!DOCTYPE html>
<html>
<head>
    <?php include_once __DIR__ . '/../common/head.php' ?>
    <?php include_once __DIR__ . '/../common/css.php' ?>
    <link rel="stylesheet" href="<?= __PUBLIC__ ?>/style/mobile.css?v=<?= $assetsTimestamp ?>"/>
    <link rel="stylesheet" href="<?= __PUBLIC__ ?>/style/icon.css?v=<?= $assetsTimestamp ?>"/>
</head>
<body>
<div id="container">
    <div class="screen">
        <div class="img_div">
            <img src="<?= __PUBLIC__ ?>/icon_mobile/icon_banner.jpg" class="show_img">
        </div>
        <div class="introduce transparent">
            <div class="logo transparent_50">
                <img src="<?= __PUBLIC__ ?>/icon_mobile/icon_logo.png" class="logo_img transparent">
                <!--<div class="logo_img"></div>-->
            </div>
            <div class="language transparent language_switch">
                <span class="active left" id="cn">中</span>
                <span class="right" id="en">EN</span>
            </div>
        </div>
    </div>
    <div style="clear: both"></div>
    <?php
    include_once __DIR__ . '/auth.php';
    include_once __DIR__ . '/welcome.php';
    ?>
    <div id="club_shade" class="shade_box">
        <div class="cancel" id="cancel"></div>
        <form action="" onsubmit="return false;">
            <input type="hidden" name="hotel_code" value="<?= $hotelCode ?>"/>
            <div class="join_club">
                <div class="club_title">
                    <span set-lan="html:join_club_title">Become Wanda Club members enjoy complimentary wifi</span>
                </div>
                <div class="join_body have_border">
                    <i class="icon icon_phone"></i>
                    <div class="phone_div">
                        <div class="country_code_div">
                            <span>+86</span>
                        </div>
                        <div class="phone_number_div">
                            <input type="tel" name="phone" value="" readonly class="input">
                        </div>
                    </div>
                </div>
                <div class="join_body have_border">
                    <i class="icon icon_people"></i>
                    <div class="name_div">
                        <div class="first_name">
                            <input type="text" name="first_name" value="" placeholder="名" class="input"
                                   set-lan="placeholder:name">
                        </div>
                        <div class="last_name">
                            <input type="text" name="last_name" value="" placeholder="姓" class="input"
                                   set-lan="placeholder:family_name">
                        </div>
                    </div>
                </div>
                <div class="join_body sex_div">
                    <?php
                    $data = [
                        ['label' => '男', 'setLan' => 'html:male', 'value' => 'M', 'checked' => true],
                        ['label' => '女', 'setLan' => 'html:female', 'value' => 'F', 'checked' => false],
                    ];
                    foreach ($data as $item):?>
                        <div class="sex_box">
                            <label class="sex_label">
                                <span set-lan="<?= $item['setLan'] ?>"><?= $item['label'] ?></span>
                                <input type="radio" class="sex_radio"
                                       name="sex"
                                       value="<?= $item['value'] ?>"<?= $item['checked'] ? ' checked' : '' ?>>
                                <i></i>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="join_body">
                    <button id="member_register_submit" type="button" set-lan="html:agree">连 接</button>
                </div>
                <div class="join_body little">
                    <div class="clause_div">
                        <label class="clause_label"><input type="checkbox" class="clause" name="clause" checked><i></i></label>
                        <span set-lan="html:join_club_clause" class="club_clause_span">条件和条款</span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--上网协议-->
    <div id="clause_shade" class="shade_box">
        <div class="clauses">
            <div class="clause_title">
                <i class="icon icon_back back"></i>
                <span set-lan="html:clause_title"></span>
            </div>
            <div class="clause_body">
                <div class="text clause_content" set-lan="html:clause_content"></div>
                <div class="high_bottom"></div>
            </div>
            <div class="btn_div">
                <button type="button" set-lan="html:confirm" class="clause_btn">确 认</button>
            </div>
        </div>
    </div>
    <!--万达注册协议-->
    <div id="club_clause_shade" class="shade_box">
        <div class="clauses">
            <div class="clause_title">
                <i class="icon icon_back back"></i>
                <span set-lan="html:club_clause_title"></span>
            </div>
            <div class="clause_body">
                <div class="text clause_content" set-lan="html:club_clause_content"></div>
                <div class="high_bottom"></div>
            </div>
            <div class="btn_div">
                <button type="button" set-lan="html:confirm" class="clause_btn">确 认</button>
            </div>
        </div>
    </div>

    <div class="toast-container" style="display: none">
        <span class="toast"></span>
    </div>
</div>
<script src="<?= __PUBLIC__ ?>/js/fastclick.min.js?v=<?= $assetsTimestamp ?>"></script>
<?php include_once __DIR__ . '/../common/js.php' ?>
<script>
    // 中英文切换
    language.init({defaultLang: '<?= GlobalData::get(GlobalData::KEY_LANG)?>'});
    // 认证切换
    tabSwitch.init({isPc: false});
    // 条件条款弹窗
    modal.init({showEl: '.clause_span', hideEl: '.clause_btn, .cancel, .back', modalEl: '#clause_shade'});
    // 注册协议弹窗
    modal.init({showEl: '.club_clause_span', hideEl: '.clause_btn, .cancel, .back', modalEl: '#club_clause_shade'});
    // 注册弹窗
    modal.init({showEl: '', hideEl: '.cancel', modalEl: '#club_shade'});

    //国家代码切换
    countryCode.init({hiddenInputName: 'country_code'});

    <?php include_once __DIR__ . '/../common/auth-js.php' ?>

    $('.sex_radio').change(function () {
        $(this).parents('.sex_box').siblings().find('span').css('color', "#999999");
        $(this).siblings('span').css('color', '#8C6E4A');
    });
    $('.sex_radio:checked').change();

    $('#more_ways').click(function () {
        $("#body").show();
        $('#welcome').hide();
    });

    $("dl.cell").height($(window).height() - 140);

</script>
</body>
</html>