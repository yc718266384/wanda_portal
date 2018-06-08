<?php
/*
 * main portal entry for old pnpgw asp page, by Digger
 *
 * history change log:
 *  - allow cookie auth for room wired connection since pnpgw-20120906
 *  - add portal ads_push function since pnpgw-20120112
 *
 * v-20121203, re-arrange compatibility for all pnpgw versions
 *  - add site_conf.php to define cookie, ads_push, hotel_url config
 *
 * v-20121211, add call websGetUserState to get mac purchase status
 *  - add $hibos_portal_query config into site_conf.php
 *
 * v-20121218, fix up.php 1.1.1.1 condition bug
 *
 */
$url = $_GET['url'];
setcookie("rurl", $url, time() + 300);

include_once("guest_env.php");
include_once("asp_funcs.php");

$lang = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
$lang = strtolower($lang);
if (strpos($lang, 'cn') !== false || strpos($lang, 'zh-cn') !== false || strpos($lang, 'zh') !== false) {
    $lang = 'cn';
} else {
    $lang = 'en';
}

include_once __DIR__ . '/portal/index.php';
exit;

/*
 * if portal ads_push enabled, redirect local request to ads_push.php
 */
if ($ads_push == 1 && $_SERVER["REMOTE_ADDR"] == "127.0.0.1") {
    include_once("ads_push.php");
    return;
}

/*
 * get language and generate file prefix
 *   - "c" for Chinese Simplified
 *   - "b" for Chinese Big5
 *   - "k" for Korea, "j" for Japanese
 *   - "" for default English
 */
if (strncasecmp($lang, "zh-cn", 5) == 0)
    $prefix = "cn";
//else if (strncasecmp($lang, "zh-tw", 5) == 0)
//	$prefix = "b";
//else if (strncasecmp($lang, "ko", 2) == 0)
//	$prefix = "k";
//else if (strncasecmp($lang, "ja", 2) == 0)
//	$prefix = "j";
else
    $prefix = "en";

/*
 * default password portal
 */
$base = "sssid.asp";
$file = "sssid.asp";

/*
 * session already up
 */
if (strcmp($status, "3") == 0) {
    $base = "up.php";
    $prefix = "";
} /*
 * vlan user portal, vguide or vpass
 */
else if (strcmp($portal_type, "user") == 0) {
    if ($roamid != "" && $room_cookie_auth == 1 &&
        ($portal_stat == 1 || $portal_stat == 2 ||
            $portal_stat == 6)) {
        $base = "pub.php";
    } else if ($portal_stat == 1 || $portal_stat == 3 ||
        $portal_stat == 6) {

        if ($guest_policy != "vipfree" && $guest_policy != "pfree" && $guest_policy != "efree" && $guest_policy != "pfree1" && $guest_policy != "pday") {
            $go_purchase = websGetUserState($user_vlan, websGetUserID(3), 0);
            if ($go_purchase == "yes" || $go_purchase == "N/A") {
                $base = "sssid.asp";
                $type = "vpass";
            } else {
                $base = "sssid.asp";
                $type = "vpass";
            }
        } else {
            $base = "sssid.asp";
            $type = "vpass";
        }
    } else {
        $base = "sssid.asp";
        $type = "vpass";
    }
} /*
 * vlan-specific portal
 */
else if (strcmp($portal_type, "url") == 0) {
    if (strcmp($portal_name, "pass") == 0)
        $base = "pass.asp";
    else
        $base = $portal_name;
} /*
 * public area and check cookie portal
 */
else if (strcmp($portal_type, "public") == 0) {
    if ($roamid != "")
        $base = "pub.php";
}

// $is_public = $is_conference = $is_room = $is_event = false;
// foreach($public_vlan as $val){
// 	if($val["start"] != "" && $val["end"] != "")
// 		if($user_vlan >= $val["start"] && $user_vlan <= $val["end"])
// 			$is_public = true;        	   
// } 
// foreach($conference_vlan as $val){
// 	if($val["start"] != "" && $val["end"] != "")
// 		if($user_vlan >= $val["start"] && $user_vlan <= $val["end"])
// 			$is_conference = true;        	   
// } 
// foreach($room_vlan as $val){
// 	if($val["start"] != "" && $val["end"] != "")
// 		if($user_vlan >= $val["start"] && $user_vlan <= $val["end"])
// 			$is_room = true;        	   
// }
// foreach($event_vlan as $val){
// 	if($val["start"] != "" && $val["end"] != "")
// 		if($user_vlan >= $val["start"] && $user_vlan <= $val["end"])
// 			$is_event = true;        	   
// }
/*foreach($guest_vlan as $val){
	if($val["start"] != "" && $val["end"] != "")
		if($guest_vlan >= $val["start"] && $guest_vlan <= $val["end"])
			$is_guest = true;        	   
}*/
// if($base == "sssid.asp" && $is_public && $use_public_page == 1 ){
// 	$base = "sssid.asp";	
// }
// if($base == "sssid.asp" && $is_event && $use_event_page == 1 ){
// 	$base = "sssid.asp";	
// }
// if($base == "sssid.asp" && $is_conference && $use_conference_page == 1 ){
// 	$base = "sssid.asp";	
// }

// if($base == "auth.asp" && $is_public && $use_public_page == 1 && $use_sms == 0 ){
// 	$base = "public.asp";	
// }
/*if($base == "auth.asp" && $is_guest && $use_guest_page == 1){
	$base = "auth.asp";	
}*/
$file = $base;

if ($prefix != "" && !file_exists("/usr/portal/htdocs/" . $file) &&
    !file_exists("/usr/portal/htdocs/includes/" . $file)) {
    $file = $base;
}

if ($debug == 1) {
    echo "go_purchase: " . $go_purchase . "<br>";
    echo $file . "<br>";
    exit;
}


if (file_exists("/usr/portal/htdocs/" . $file) ||
    file_exists("/usr/portal/htdocs/includes/" . $file))
    include_once($file);
else
    echo "service not available for " . $file . "<br>";

?>
