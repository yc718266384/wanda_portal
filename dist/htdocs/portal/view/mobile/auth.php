<?php

use common\Config;

$hotelCode = Config::WANDA_HOTEL_CODE;

function htmlClauseField($config)
{
    $config = array_merge([
        'double' => false,
    ], $config);
    $clubClauseHtml = '';
    if ($config['double']) {
        $clubClauseHtml = <<<HTML
<div class="input_label">
    <label class="clause_label"><input type="checkbox" class="clause" name="club_clause" checked><i></i></label>
    <span set-lan="html:join_club_clause" class="club_clause_span">Agree and join the Wanda Club</span>
</div>
HTML;
    }
    return <<<HTML
<div class="clause_div">
    {$clubClauseHtml}
    <div class="input_label">
        <label class="clause_label"><input type="checkbox" class="clause" name="clause" checked><i></i></label>
        <span set-lan="html:clause" class="clause_span">条件和条款</span>
    </div>
</div>
HTML;
}

function htmlInputFiled($config)
{
    $config = array_merge([
        'icon' => '', 'type' => 'text', 'name' => '', 'value' => '',
        'placeholder' => '', 'setLan' => '', 'required' => true,
    ], $config);
    $requiredStr = $config['required'] ? 'required' : '';
    return <<<HTML
<div class="input_div">
    <span><i class="icon {$config['icon']}"></i></span>
    <input type="{$config['type']}" name="{$config['name']}" placeholder="{$config['placeholder']}" value="{$config['value']}"
     class="input" set-lan="{$config['setLan']}" {$requiredStr}>
</div>
HTML;
}

function htmlPhoneFiled($config)
{
    $config = array_merge([
        'icon' => '', 'type' => 'text', 'name' => '', 'value' => '',
        'placeholder' => '', 'setLan' => '', 'required' => true,
    ], $config);
    $requiredStr = $config['required'] ? 'required' : '';
    return <<<HTML
<div class="input_div">
    <span><i class="icon {$config['icon']}"></i></span>
    <div class="phone_div">
        <div class="country_code"><a href="javascript:void(0);"><span>+86</span><i class="icon icon_more"></i></a></div>
        <div class="phone_input">
            <input type="{$config['type']}" name="{$config['name']}" placeholder="{$config['placeholder']}" value="{$config['value']}" class="input" set-lan="{$config['setLan']}" {$requiredStr}>
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
<div class="btn_div">
    <button type="button" id="{$config['id']}" set-lan="html:agree">连 接</button>
</div>
HTML;
}

function htmlSendSmsField($config)
{
    $config = array_merge([
        'icon' => '', 'type' => 'text', 'name' => '', 'value' => '',
        'placeholder' => '', 'setLan' => '', 'required' => true, 'sendId' => ''
    ], $config);
    $requiredStr = $config['required'] ? 'required' : '';
    return <<<HTML
<div class="input_div">
    <span><i class="icon {$config['icon']}"></i></span>
    <input type="{$config['type']}" name="{$config['name']}" placeholder="{$config['placeholder']}" 
    value="{$config['value']}" class="input code" set-lan="{$config['setLan']}" {$requiredStr}>
    <div class="get_code">
        <button id="{$config['sendId']}" type="button" set-lan="html:get_code">获取验证码</button>
    </div>
</div>
HTML;
}

function htmlStateCodeContainerField()
{
    return <<<HTML
<span class="state_code" style="display: none;">
</span>
HTML;
}

?>
<div class="body" id="body" <?= $authOk ? 'style="display: none"' : '' ?>>
    <div class="ul_div">
        <ul id="choose_ul">
            <?php
            $data = [
                ['id' => 'room', 'label' => '住店客人', 'language' => 'html:guest', 'active' => true, 'icon' => 'icon_guest'],
                ['id' => 'member', 'label' => '万悦会', 'language' => 'html:wandaclub', 'active' => false, 'icon' => 'icon_wandaclub'],
                ['id' => 'visitor', 'label' => '来访客人', 'language' => 'html:visitor', 'active' => false, 'icon' => 'icon_visitor'],
                ['id' => 'meeting', 'label' => '会议客人', 'language' => 'html:meeting', 'active' => false, 'icon' => 'icon_meeting'],
            ];
            foreach ($data as $item):?>
                <li class="option tab_nav <?= $item['active'] ? 'active' : '' ?>" data-id="#<?= $item['id'] ?>">
                    <i class="icon icon_big <?= $item['icon'] ?> <?= $item['active'] ? 'active' : '' ?>"></i>
                    <span set-lan="<?= $item['language'] ?>"><?= $item['label'] ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <!-- 房号认证 -->
    <div id="room" class="form_div active tab_content">
        <form action="" onsubmit="return false;">
            <?= htmlInputFiled(['icon' => 'icon_roomnumber', 'name' => 'userid', 'placeholder' => '房间号码', 'setLan' => 'placeholder:room_no']) ?>
            <?= htmlInputFiled(['icon' => 'icon_people', 'name' => 'lastName', 'placeholder' => '姓', 'setLan' => 'placeholder:family_name']) ?>
            <?= htmlSubmitField(['id' => 'room_auth']) ?>
            <?= htmlClauseField(['double' => true]) ?>
        </form>
    </div>
    <!-- 万悦会员 -->
    <div id="member" class="form_div tab_content" style="display: none">
        <form action="" onsubmit="return false;">
            <input type="hidden" name="country_code" value="86">
            <input type="hidden" name="hotel_code" value="<?= $hotelCode ?>"/>
            <?= htmlStateCodeContainerField() ?>
            <?= htmlPhoneFiled(['icon' => 'icon_phone', 'type' => 'tel', 'name' => 'phone', 'placeholder' => '手机号码', 'setLan' => 'placeholder:phone']) ?>
            <?= htmlSendSmsField(['icon' => 'icon_captcha', 'name' => 'code', 'placeholder' => '验证码', 'setLan' => 'placeholder:captcha', 'sendId' => 'member_get_code']) ?>
            <?= htmlSubmitField(['id' => 'member_auth']) ?>
            <?= htmlClauseField(['double' => false]) ?>
        </form>
    </div>
    <!-- 访客 -->
    <div id="visitor" class="form_div tab_content" style="display: none">
        <form action="" onsubmit="return false;">
            <input type="hidden" name="country_code" value="86">
            <input type="hidden" name="hotel_code" value="<?= $hotelCode ?>"/>
            <?= htmlStateCodeContainerField() ?>
            <?= htmlPhoneFiled(['icon' => 'icon_phone', 'type' => 'tel', 'name' => 'phone', 'placeholder' => '手机号码', 'setLan' => 'placeholder:phone']) ?>
            <?= htmlSendSmsField(['icon' => 'icon_captcha', 'name' => 'code', 'placeholder' => '验证码', 'setLan' => 'placeholder:captcha',
                'sendId' => Config::VISITOR_USE_WANDA ? 'member_get_code2' : 'visitor_get_code']) ?>
            <?= htmlSubmitField(['id' => Config::VISITOR_USE_WANDA ? 'member_auth2' : 'visitor_auth']) ?>
            <?= htmlClauseField(['double' => true]) ?>
        </form>
    </div>
    <!-- 会议 -->
    <div id="meeting" class="form_div tab_content" style="display: none">
        <form action="" onsubmit="return false;">
            <?= htmlInputFiled(['icon' => 'icon_meetingcode', 'name' => 'meeting_code', 'placeholder' => '会议码', 'setLan' => 'placeholder:meeting_code']) ?>
            <div class="explain">
                <span>*  <lan set-lan="html:explain">请从会议组织者那里获取会议码</lan></span>
            </div>
            <?= htmlSubmitField(['id' => 'meeting_auth']) ?>
            <?= htmlClauseField(['double' => false]) ?>
        </form>
    </div>
    <div class="error_msg">
        <span set-lan="html:error_msg">错误信息</span>
    </div>
</div>
