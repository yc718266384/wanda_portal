<?php
/** @var $url string */
/** @var $lang string */
/** @var $user_mac string */
/** @var $user_vlan int */
/** @var $user_ip string */
/** @var $status int */

/** @var $portal_type string */

use common\Config;
use common\Functions;
use common\GlobalData;
use common\WanDa;

define('__VIEW__', __DIR__ . '/view/');
define('__AJAX_URL__', './portal/ajax.php');
define('__PUBLIC__', './portal/public');

require_once __DIR__ . '/vendor/Autoloader.php';
spl_autoload_register(['Autoloader', 'autoload'], true, true);

GlobalData::set([
    GlobalData::KEY_URL => $url,
    GlobalData::KEY_USER_MAC => $user_mac,
    GlobalData::KEY_USER_VLAN => $user_vlan,
    GlobalData::KEY_USER_IP => $user_ip,
    GlobalData::KEY_STATUS => $status,
]);
if (!GlobalData::get(GlobalData::KEY_LANG)) {
    GlobalData::set([GlobalData::KEY_LANG => $lang]);
}
if (isset($GLOBALS['radius_ip'])) {
    GlobalData::set([GlobalData::KEY_RADIUS_IP => $GLOBALS['radius_ip']]);
}
if (isset($GLOBALS['user_mac'])) {
    GlobalData::set([GlobalData::KEY_G_USER_MAC => $GLOBALS['user_mac']]);
}

// 已经授权可以直接访问的情况
$authOk = false;
$authOkType = null;
$authOkParams = [];
//var_dump($portal_type);
if ($portal_type == 'user') {
    // vpass 模式
    $authOk = true;
    $authOkType = 'vpass';
    $authOkParams = [
        'user' => ''
    ];
} else {
    if (Config::isWandaApiOn()) {
        // 漫游查询
        $result = WanDa::queryRoamStatus($user_mac, Config::WANDA_HOTEL_CODE);
        if ($result['type'] == 'success') {
            $authOk = true;
            $authOkType = 'member';
            $authOkParams = [
                'user' => $result['msg']['phone'],
                'cardNo' => $result['msg']['memberCardNo']
            ];
        }
    }
}

$assetsTimestamp = '201806072201'; // css js 的时间戳，解决缓存的问题等

if (Functions::isMobile()) {
    require_once __VIEW__ . 'mobile/index.php';
} else {
    require_once __VIEW__ . 'pc/index.php';
}
