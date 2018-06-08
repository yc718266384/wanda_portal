<?php

//include_once(__DIR__ . "/includes/guest_env.php");
//include_once(__DIR__ . "/includes/asp_funcs.php");

require_once __DIR__ . '/portal/common/Config.php';

$url = 'http://www.baidu.com';
$lang = 'cn'; // cn en
$user_mac = '00:01:6C:06:A6:99'; // 00:01:6C:06:A6:29 已通过漫游认证
$user_vlan = 11;
$user_ip = '192.168.1.250';
$status = 1;
$portal_type = '1'; // user => vpass

$GLOBALS['radius_ip'] = '192.168.1.147';
$GLOBALS['user_mac'] = $user_mac;

include_once __DIR__ . '/function.php';
include_once __DIR__ . '/portal/index.php';