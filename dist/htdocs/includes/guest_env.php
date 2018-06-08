<?php
/*
 * guest_env.php:	arrange guest global environment vars, by Digger
 *
 *   $user_mac:		%12X MAC address
 *   $user_vlan:	guest VLAN ID
 *   $user_ip:		guest IP address
 *
 *   $status:		3 for SESSION_UP
 *
 *   $online_time:	online time by seconds
 *   $max_session_time: max session time by seconds
 *
 *   $user_id:		login user_id if $status == 3, or "invalid"
 *
 *   $random_number:	guest random number, for logout match
 *
 *   $portal_stat:	vlan portal stat
 *			1, 3, 6 -  should open purchase portal
 *			2 -  purchased vlan portal
 *
 *   $portal_type:	"user" - is passwd portal
 *		 	"vlan" - is vlan portal
 *			"url" - should redirect to new url
 *			"public" - in public area, default password portal
 *				   trycookie auth if roamid cookie available
 *
 *   $portal_name:	vlanuser name if portal_type == "vlan"
 *			redirect file name if $portal_type == "url"
 *
 *   $roamid:		"roamid" if auth cookie avalable
 *
 *   $radius_ip:	radius server IP address
 *   $radius_key:	radius key
 *
 *   $guest_name:	guest check-in name if extended portal enabled
 *   $guest_policy:	guest policy ID if extended portal enabled
 */

include_once("site_conf.php");

$caller = $_SERVER["CALLER_INFO"];
$expval = explode(" ", $caller);
if (count($expval) == 4) {
	$user_mac = $expval[0];
	$user_vlan = intval($expval[1]);
	$user_ip = $expval[2];
	$status = intval($expval[3]);
} else if ($debug == 1) {
	echo "service not available<br>";
}

if ($debug == 1) {
	echo "user_mac: ".$user_mac."<br>";
	echo "user_vlan: ".$user_vlan."<br>";
	echo "user_ip: ".$user_ip."<br>";
	echo "status: ".$status."<br>";
}

$timer = $_SERVER["TIMER_INFO"];
$expval = explode(" ", $timer);
if (count($expval) == 2) {
	$online_time = $expval[0];
	$max_session_time = $expval[1];
}

if ($debug == 1) {
	echo "online_time: ".$online_time."<br>";
	echo "max_session_time: ".$max_session_time."<br>";
}

$names = $_SERVER["NAME_INFO"];
$expval = explode(" ", $names);
if (count($expval) == 2) {
	$random_number = $expval[0];
	$user_id = $expval[1];
}

if ($debug == 1) {
	echo "random_number: ".$random_number."<br>";
	echo "user_id: ".$user_id."<br>";
}

$portal_stat = $_SERVER["PORTAL_STAT"];
if ($debug == 1) {
	echo "portal_stat: ".$portal_stat."<br>";
}

$portal = $_SERVER["PORTAL_INFO"];
$expval = explode(" ", $portal);
if (count($expval) == 2) {
	$portal_type = $expval[0];
	$portal_name = $expval[1];
}

if ($debug == 1) {
	echo "portal_type: ".$portal_type."<br>";
	echo "portal_name: ".$portal_name."<br>";
}

$radinfo = $_SERVER["RADIUS_INFO"];
$expval = explode(" ", $radinfo);
if (count($expval) == 2) {
	$radius_ip = $expval[0];
	$radius_key = $expval[1];
}

if ($debug == 1) {
	echo "radius_ip: ".$radius_ip."<br>";
	echo "radius_key: ".$radius_key."<br>";
}

$guest_name = $_SERVER["GUEST_NAME"];
$guest_policy = $_SERVER["GUEST_POLICY"];

if ($debug == 1) {
	echo "guest_name: ".$guest_name."<br>";
	echo "guest_policy: ".$guest_policy."<br>";
}

$user_sid = $_SERVER["SID_INFO"];
if ($debug == 1) {
	echo "user_sid: ".$user_sid."<br>";
}

$auth_mod_list = array('room','sms','code','wechat','noauth');
?>
