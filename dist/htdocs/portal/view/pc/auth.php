<?php

use common\Config;

$hotelCode = Config::WANDA_HOTEL_CODE;

function htmlClauseField($config)
{
    $config = array_merge([
        'double' => false,
    ], $config);
    $clubClauseHtml = '';
    $notDoubleClass = 'not_double';
    if ($config['double']) {
        $notDoubleClass = '';
        $clubClauseHtml = <<<HTML
<div class="clause_div">
    <label class="clause_label"><input type="checkbox" class="clause" name="club_clause" checked><i></i></label>
    <span set-lan="html:join_club_clause" class="club_clause_span">Agree and join the Wanda Club</span>
</div>
HTML;
    }
    return <<<HTML
<div class="right main_div">
    <div class="clause_div {$notDoubleClass}">
        <label class="clause_label"><input type="checkbox" class="clause" name="clause" checked><i></i></label>
        <span set-lan="html:clause" class="clause_span">条件和条款</span>
    </div>
    {$clubClauseHtml}
</div>
HTML;
}

function htmlInputFiled($config)
{
    $config = array_merge([
        'pos' => 'left', 'type' => 'text', 'name' => '', 'value' => '',
        'placeholder' => '', 'setLan' => '', 'required' => true,
    ], $config);
    $requiredStr = $config['required'] ? 'required' : '';
    return <<<HTML
<div class="{$config['pos']} show main_div">
    <input type="{$config['type']}" name="{$config['name']}" value="{$config['value']}" placeholder="{$config['placeholder']}" class="input"
           set-lan="{$config['setLan']}" {$requiredStr} />
</div>
HTML;
}

function htmlInputDoubleFiled($pos, $confFront, $confBack)
{
    $conf = [
        'pos' => 'left', 'type' => 'text', 'name' => '', 'value' => '',
        'placeholder' => '', 'setLan' => '', 'required' => true,
    ];
    $config = [
        'pos' => $pos,
        'front' => array_merge($conf, $confFront),
        'back' => array_merge($conf, $confBack),
    ];
    $requiredStrFront = $config['front']['required'] ? 'required' : '';
    $requiredStrBack = $config['back']['required'] ? 'required' : '';
    return <<<HTML
<div class="{$config['pos']} show main_div">
    <div class="double_div double_front">
        <input type="{$config['front']['type']}" name="{$config['front']['name']}" value="{$config['front']['value']}" placeholder="{$config['front']['placeholder']}" class="double_input" set-lan="{$config['front']['setLan']}" {$requiredStrFront} />
    </div>
    <div class="double_div double_back">
        <input type="{$config['back']['type']}" name="{$config['back']['name']}" value="{$config['back']['value']}" placeholder="{$config['back']['placeholder']}" class="double_input" set-lan="{$config['back']['setLan']}" {$requiredStrBack} />
    </div>
</div>
HTML;
}

function htmlPhoneFiled($config)
{
    $config = array_merge([
        'pos' => 'left', 'type' => 'text', 'name' => '', 'value' => '',
        'placeholder' => '手机号码', 'setLan' => 'placeholder:phone', 'required' => true,
        'countryCodeName' => '', 'countryCodeValue' => '',
    ], $config);
    $requiredStr = $config['required'] ? 'required' : '';
    return <<<HTML
<span class="state_code" style="display: none;">
</span>
<div class="{$config['pos']} show main_div">
    <div class="phone_div">
        <div class="country_code">
            <a href="javascript:void(0);"><span>+{$config['countryCodeValue']}</span><i class="icon icon_more"></i></a>
            <input type="hidden" name="{$config['countryCodeName']}" value="{$config['countryCodeValue']}">
        </div>
        <div class="phone_input">
            <input type="{$config['type']}" name="{$config['name']}" value="{$config['value']}" placeholder="{$config['placeholder']}" class="input"
                    set-lan="{$config['setLan']}" {$requiredStr} />
        </div>
    </div>
</div>
HTML;
}

function htmlSubmitField($config)
{
    $config = array_merge([
        'id' => '',
    ], $config);
    return <<<HTML
<div class="left main_div">
    <button type="button" id="{$config['id']}" class="submit" set-lan="html:agree">连 接</button>
</div>
HTML;
}

function htmlSendSmsField($config)
{
    $config = array_merge([
        'pos' => 'right', 'type' => 'text', 'name' => '', 'value' => '',
        'placeholder' => '', 'setLan' => '', 'required' => true, 'sendId' => ''
    ], $config);
    $requiredStr = $config['required'] ? 'required' : '';
    return <<<HTML
<div class="{$config['pos']} main_div">
    <button type="button" class="get_code" id="{$config['sendId']}" set-lan="html:get_code">获取验证码</button>
    <div class="code_div">
        <input type="{$config['type']}" name="{$config['name']}" value="{$config['value']}"
         placeholder="{$config['placeholder']}" class="code" set-lan="{$config['setLan']}" {$requiredStr}/>
    </div>
</div>
HTML;
}

?>
<div class="down wifi" <?= $authOk ? 'style="display: none"' : '' ?>>
    <div class="wifi_logo_box">
        <div class="wifi_logo">
            <div class="wifi_logo_div"></div>
            <div class="wifi_char" set-lan="html:wifi"> 享受高速的无限免费上网宽带</div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="choose-container">
        <div class="choose" id="body">
            <ul id="choose_ul">
                <?php
                $data = [
                    ['id' => 'room', 'label' => '住店客人', 'language' => 'html:guest', 'active' => true, 'icon' => 'icon_guest_normal.png', 'iconActive' => 'icon_guest_selected.png'],
                    ['id' => 'member', 'label' => '万悦会', 'language' => 'html:wandaclub', 'active' => false, 'icon' => 'icon_wandaclub_normal.png', 'iconActive' => 'icon_wandaclub_selected.png'],
                    ['id' => 'visitor', 'label' => '来访客人', 'language' => 'html:visitor', 'active' => false, 'icon' => 'icon_vistor_normal.png', 'iconActive' => 'icon_vistor_selected.png'],
                    ['id' => 'meeting', 'label' => '会议客人', 'language' => 'html:meeting', 'active' => false, 'icon' => 'icon_meeting_normal.png', 'iconActive' => 'icon_meeting_selected.png'],
                ];
                foreach ($data as $item):?>
                    <li class="option tab_nav <?= $item['active'] ? 'active' : '' ?>" data-id="#<?= $item['id'] ?>">
                        <img class="icon_img" src="<?= __PUBLIC__ . '/icon/' . $item['icon'] ?>"
                            <?= $item['active'] ? ' style="display: none"' : '' ?>>
                        <img class="icon_img active" src="<?= __PUBLIC__ . '/icon/' . $item['iconActive'] ?>"
                            <?= !$item['active'] ? ' style="display: none"' : '' ?>>
                        <span set-lan="<?= $item['language'] ?>"><?= $item['label'] ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
            <!-- 房号认证 -->
            <div id="room" class="form_div active tab_content">
                <form action="" onsubmit="return false;">
                    <?= htmlInputFiled(['pos' => 'left', 'name' => 'userid', 'placeholder' => '房间号码', 'setLan' => 'placeholder:room_no']) ?>
                    <?= htmlInputFiled(['pos' => 'right', 'name' => 'lastName', 'placeholder' => '姓', 'setLan' => 'placeholder:family_name']) ?>
                    <div class="clear"></div>
                    <?= htmlSubmitField(['id' => 'room_auth']) ?>
                    <?= htmlClauseField(['double' => true]) ?>
                </form>
            </div>
            <!-- 万悦会员 -->
            <div id="member" class="form_div tab_content" style="display: none">
                <form action="" onsubmit="return false;">
                    <input type="hidden" name="hotel_code" value="<?= $hotelCode ?>"/>
                    <?= htmlPhoneFiled([
                        'pos' => 'left', 'type' => 'tel', 'name' => 'phone', 'placeholder' => '手机号码', 'setLan' => 'placeholder:phone',
                        'countryCodeName' => 'country_code', 'countryCodeValue' => 86
                    ]) ?>
                    <?= htmlSendSmsField(['pos' => 'right', 'name' => 'code', 'placeholder' => '验证码', 'setLan' => 'placeholder:captcha', 'sendId' => 'member_get_code']) ?>
                    <div class="clear"></div>
                    <?= htmlSubmitField(['id' => 'member_auth']) ?>
                    <?= htmlClauseField(['double' => false]) ?>
                </form>
            </div>
            <!-- 访客 -->
            <div id="visitor" class="form_div tab_content" style="display: none">
                <form action="" onsubmit="return false;">
                    <input type="hidden" name="hotel_code" value="<?= $hotelCode ?>"/>
                    <?= htmlPhoneFiled([
                        'pos' => 'left', 'type' => 'tel', 'name' => 'phone', 'placeholder' => '手机号码', 'setLan' => 'placeholder:phone',
                        'countryCodeName' => 'country_code', 'countryCodeValue' => 86
                    ]) ?>
                    <?= htmlSendSmsField(['pos' => 'right', 'name' => 'code', 'placeholder' => '验证码', 'setLan' => 'placeholder:captcha',
                        'sendId' => Config::VISITOR_USE_WANDA ? 'member_get_code2' : 'visitor_get_code']) ?>
                    <div class="clear"></div>
                    <?= htmlSubmitField(['id' => Config::VISITOR_USE_WANDA ? 'member_auth2' : 'visitor_auth']) ?>
                    <?= htmlClauseField(['double' => true]) ?>
                </form>
            </div>
            <!-- 会议 -->
            <div id="meeting" class="form_div tab_content" style="display: none">
                <form action="" onsubmit="return false;">
                    <?= htmlInputFiled(['pos' => 'left', 'name' => 'meeting_code', 'placeholder' => '会议码', 'setLan' => 'placeholder:meeting_code']) ?>
                    <div class="right">
                        <div class="explain">
                            <span class="xing">* </span><span set-lan="html:explain">请从会议组织者那里获取会议码</span>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <?= htmlSubmitField(['id' => 'meeting_auth']) ?>
                    <?= htmlClauseField(['double' => false]) ?>
                </form>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
