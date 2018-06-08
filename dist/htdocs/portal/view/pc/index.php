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
    <link rel="stylesheet" href="<?= __PUBLIC__ ?>/style/index.css?v=<?= $assetsTimestamp ?>"/>
</head>
<body>
<div id="container">
    <div class="screen">
        <div class="img_div">
            <img src="<?= __PUBLIC__ ?>/icon/image.jpg" class="show_img">
        </div>
        <div class="introduce">
            <div class="logo">
                <img src="<?= __PUBLIC__ ?>/icon/wanda_logo.png" class="logo_img">
            </div>
            <div class="language language_switch">
                <span class="active" id="cn">中</span>
                <span id="en">EN</span>
            </div>
            <div class="content">
                <p set-lan="html:content1">万达集团旗下共拥有商管、文化、地产、金融四大产业集团，万达酒店及度假村始于2007年，隶属于万达文化产业集团</p>
                <p set-lan="html:content2">
                    万达酒店及度假村拥有酒店设计、酒店建设、酒店管理三大核心板块，是全球唯一打通酒店开发及管理的全产业链公司。目前共拥有四个酒店品牌：奢华酒店品牌-万达瑞华、豪华酒店品牌-万达文华、高端酒店品牌-万达嘉华、以及精选酒店品牌-万达锦华，在全球50多座城市管理着超过60家酒店。位于伊斯坦布尔、万象、洛杉矶、芝加哥、悉尼、黄金海岸和兰卡威的万达文华和万达嘉华酒店将于2019年底陆续揭幕。</p>
            </div>
        </div>
        <div class="clear"></div>
    </div>
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
                    <i class="icon icon_cancel cancel"></i>
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
                    <i class="icon icon_lastname"></i>
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
                <div class="join_body">
                    <?php
                    $data = [
                        ['label' => '男', 'setLan' => 'html:male', 'value' => 'M', 'checked' => true],
                        ['label' => '女', 'setLan' => 'html:female', 'value' => 'F', 'checked' => false],
                    ];
                    foreach ($data as $item):?>
                        <div class="sex_box">
                            <label class="sex_label">
                                <span set-lan="<?= $item['setLan'] ?>">&nbsp;<?= $item['label'] ?></span>
                                <input type="radio" class="sex_radio" name="sex"
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
        </form>
    </div>
</div>
<!--上网协议-->
<div id="clause_shade" class="shade_box">
    <div class="clauses">
        <div class="clause_title">
            <span set-lan="html:clause_title"></span>
            <i class="icon_cancel cancel"></i>
        </div>
        <div class="clause_body">
            <div class="text clause_content" set-lan="html:clause_content"></div>
            <div class="btn_div">
                <button type="button" set-lan="html:confirm" class="clause_btn">确 认</button>
            </div>
        </div>
    </div>
</div>
<!--万达注册协议-->
<div id="club_clause_shade" class="shade_box">
    <div class="clauses">
        <div class="clause_title">
            <span set-lan="html:club_clause_title"></span>
            <i class="icon_cancel cancel"></i>
        </div>
        <div class="clause_body">
            <div class="text clause_content" set-lan="html:club_clause_content"></div>
            <div class="btn_div">
                <button type="button" set-lan="html:confirm" class="clause_btn">确 认</button>
            </div>
        </div>
    </div>
</div>

<div class="toast-container" style="display: none">
    <span class="toast"></span>
</div>
<?php include_once __DIR__ . '/../common/js.php' ?>
<script type="application/javascript">
    var windowHeight = $(window).height(),
        containerHeight = $('#container').height();
    if (windowHeight > containerHeight) {
        var marginTop = (windowHeight - containerHeight) / 2;
        $('#container').css('marginTop', marginTop);
    }
</script>
<script>
    // 中英文切换
    language.init({defaultLang: '<?= GlobalData::get(GlobalData::KEY_LANG)?>'});
    // 认证切换
    tabSwitch.init({isPc: true});
    // 条件条款弹窗
    modal.init({showEl: '.clause_span', hideEl: '.clause_btn, .cancel', modalEl: '#clause_shade'});
    // 注册协议弹窗
    modal.init({showEl: '.club_clause_span', hideEl: '.clause_btn, .cancel', modalEl: '#club_clause_shade'});
    // 注册弹窗
    modal.init({showEl: '', hideEl: '.cancel', modalEl: '#club_shade'});
    //国家代码切换
    countryCode.init({hiddenInputName: 'country_code'});

    <?php include_once __DIR__ . '/../common/auth-js.php'?>

    // 单选框样式切换
    $('.sex_radio').change(function () {
        $(this).parents('.sex_box').siblings().find('span').css('color', "#999999");
        $(this).siblings('span').css('color', '#8C6E4A');
    });
    $('.sex_radio:checked').change();

    // 欢迎页面的更多链接方式
    $('#more_ways').click(function () {
        $(".wifi").show();
        $('.welcome').hide();
    });

</script>
</body>
</html>