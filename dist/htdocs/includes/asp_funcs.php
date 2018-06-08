<?
/*
 * for compatible with old pnpgw asp funcs
 *
 * change log:
 *  - 20121203, merge websGetUserID fix by Maxim
 *    to support dot-separated MAC string
 *  - 20121203, merge websGetVlanDigest fix by Maxim
 *    use new $hotel_url env, fix user_id and rdrudr post var
 *  - 20121211, add websGetUserState func, provided by Maxim
 *
 */

function websEchoVar($var_name)
{
	if ($var_name == "passwd")
		echo $GLOBALS["passwd"];
	if ($var_name == "policy")
		echo $GLOBALS["policy"];
	if ($var_name == "userid")
		echo $GLOBALS["userid"];
}

function websGetChapVal()
{
	echo "0";
}

function websGetEchoTimer()
{
	echo "0";
}

function websGetDeadTimer()
{
	echo "180000";
}

function websGetGinfo($type = 0)
{
	if ($type == 1)
		echo $GLOBALS["guest_policy"];
	else
		echo $GLOBALS["guest_name"];
}

function websGetOnlineTime()
{
	echo $GLOBALS["online_time"];
}

function websGetRandom()
{
	echo $GLOBALS["random_number"];
}

function websGetRealIp()
{
	echo $GLOBALS["user_ip"];
}

function websGetServerIp($type = 0)
{
	if ($type == 1)
		echo $GLOBALS["radius_ip"];
	else
		echo "1.1.1.3";
}

function websGetSessionTime()
{
	echo $GLOBALS["max_session_time"];
}

function websGetUserByVlan()
{
	if ($GLOBALS["portal_type"] == "user")
		echo $GLOBALS["portal_name"];
	else
		echo $GLOBALS["user_vlan"];
}

function websGetUserID($type = 0)
{
	if ($type == 1 || $type == 3) {
		$mac = $GLOBALS["user_mac"];;
		if (strlen($mac) == 12) {
			$mac_array = str_split($mac, 2);
			$str_mac = "";
			$i = 0;
			foreach ($mac_array as $key => $val) {
				if ($i != 0) $str_mac .= ":";
				$str_mac .= $val;
				$i++;
			}
			if ($type == 1)
				echo $str_mac;
			else
				return $str_mac;
		} else {
			echo $mac;
		}
	} else {
		echo $GLOBALS["user_id"];
	}
}

function websGetVlan()
{
	echo $GLOBALS["user_vlan"];
}

function websGetVportalStat()
{
	echo $GLOBALS["portal_stat"];
}

function websRandom()
{
	srand();
	echo rand();
}

function websGetUserUrl()
{
	echo $GLOBALS["url"];
}

function websGetPwdUrl()
{
	echo "http://".$GLOBALS["radius_ip"].":8080/user/notepass.php";
}

function websGetVlanDigest($get_parm = 0)
{
        $key = $GLOBALS["radius_key"];
        $userid = $GLOBALS["user_id"];
        $vlanid = $GLOBALS["user_vlan"];
	$rdrurl = $GLOBALS["url"];

        $text = $vlanid.$userid.$key;
	$md5str = md5($text);

	if (empty($rdrurl) || $rdrurl == "")
		$rdrurl = $hotel_url;

	// echo $md5str;
	if ($get_parm == 1) {
		echo "vlanid=".$GLOBALS["user_vlan"]."&digest=".$md5str."\n";
	} else {
		echo "<input type=\"hidden\" name=\"vlanid\" value=\"".$GLOBALS["user_vlan"]."\">\n";
		echo "<input type=\"hidden\" name=\"userid\" value=\"".$userid."\">\n";
		echo "<input type=\"hidden\" name=\"digest\" value=\"".$md5str."\">\n";
		echo "<input type=\"hidden\" name=\"rdrurl\" value=\"".$rdrurl."\">\n";
	}
}

function websGetUserSid()
{
	echo $GLOBALS["user_sid"];
}

function websGetUserState($vlanid, $usermac, $type)
{
	if (!isset($GLOBALS["hibos_portal_query"]) || $GLOBALS["hibos_portal_query"] == 0)
		return "N/A";

	if (!isset($vlanid) || $vlanid == ""|| !isset($usermac) || $usermac == "")
		return "N/A";

	// type 0 for enet, type 1 for wifi
	if ($type == "1") {
		$url = "http://".$GLOBALS["radius_ip"].":8080/user/portal/get_wifimac_stat.php?usermac=".$usermac."&vlanid=".$vlanid;
	} else {
		$url = "http://".$GLOBALS["radius_ip"].":8080/user/portal/get_enetmac_stat.php?usermac=".$usermac."&vlanid=".$vlanid;
	}
	$content = file_get_contents($url);

	return $content;
}

function is_mobile(){

    // returns true if one of the specified mobile browsers is detected
	$isMobile = false;
	
	$devices = array("android","blackberry","rim tablet os","iphone","ipod)","opera mini","opera mobi","avantgo","blazer","elaine","hiptop","palm","plucker","xiino","windows ce","iemobile","ppc","smartphone","windows phone os","kindle","mobile","mmp","midp","pocket","psp","symbian","smartphone","treo","up.browser","up.link","vodafone","wap","opera mini"
    );
	foreach ($devices as $device) {
		if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),$device)!= false){
			if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'ipad'))
				continue;
			$isMobile = true;
			break;	
		}
    }
    
	return isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE']) or (strpos($_SERVER['HTTP_ACCEPT'], 'text/vnd.wap.wml') > 0||strpos($_SERVER['HTTP_ACCEPT'], 'application/vnd.wap.xhtml+xml') > 0) or $isMobile;

}

function websGetPortalMode($userid){
	
	if($userid == ""){
		echo "N/A";
		exit;
	}
	
	$url = "http://".$GLOBALS["radius_ip"].":8080/user/portal/get_portal_mode.php?userid=$userid";
	$content = file_get_contents($url);
	
	return $content;
	
}

function websGetMacState($userid,$passwd)
{
	if (!isset($GLOBALS["hibos_portal_query"]) || $GLOBALS["hibos_portal_query"] == 0)
		return "N/A";

	if (!isset($userid) || $userid == "")
		return "N/A";

	$url = "http://".$GLOBALS["radius_ip"].":8080/user/portal/get_wifimac_stat.php?usermac=".websGetUserID(3)."&userid=".$userid."&passwd=".$passwd;
	$content = file_get_contents($url);
	if($content == "pwderr" || $content == "no")
		return $content;

	$url = "http://".$GLOBALS["radius_ip"].":8080/user/portal/get_enetmac_stat.php?usermac=".websGetUserID(3)."&userid=".$userid."&passwd=".$passwd;
	$content = file_get_contents($url);

	return $content;
}

function websGetCodeInfo($code){
	
	if($code == ""){
		echo "N/A";
		exit;
	}
	
	$url = "http://".$GLOBALS["radius_ip"].":8080/user/portal/get_uid_by_code.php?type=js&code=$code";
	$content = file_get_contents($url);
	
	echo $content;
	
}

function websGetPolicy($userid){
	
	if($userid == ""){
		echo "N/A";
		exit;
	}
	
	$url = "http://".$GLOBALS["radius_ip"].":8080/user/portal/get_policy.php?type=0&uid=$userid";
	$content = file_get_contents($url);
	
	return $content;
	
}

function websCardByMobile($userid,$code){
	
	$url = "http://".$GLOBALS["radius_ip"].":8080/user/portal/get_card_by_mobile.php?Source=Portal&Mobile=".$userid."&Code=".$code;;
	
	$content = file_get_contents($url);
        
	$result_arr = array();
	$card_arr = array();
	if ($content != "") {
		preg_match_all( "/\<Result\>(.*?)\<\/Result\>/", $content, $result_arr);
		preg_match_all( "/\<CardNo\>(.*?)\<\/CardNo\>/", $content, $card_arr);
	}
	
	if($result_arr[1][0] == "True" || $result_arr[1][0] == "true"){
		return $card_arr[1][0];
	}else
		return "";

}

function websGetDepartureDate($userid){
	
	$url = "http://".$GLOBALS["radius_ip"].":8080/user/portal/get_departure_date.php?UserId=".$userid;
	
	$content = file_get_contents($url);
        
	$result_arr = array();
	if ($content != "") {
		preg_match_all( "/\<DepartureDate\>(.*?)\<\/DepartureDate\>/", $content, $result_arr);
	}
	
	return $result_arr[1][0];

}

function websGetUserIdByVlan($vlan){

	$url = "http://".$GLOBALS["radius_ip"].":8080/user/portal/get_passwd_info.php?vlan=".$vlan."&lan=en";	
	$content = file_get_contents($url);
	$tmp_ary = explode("unt: ",$content);
	$tmp_ary2 = explode(" Password:",$tmp_ary[1]);	
	
	return $tmp_ary2[0];
	
}

function inRange($user_vlan,$public_vlan){
	/*var_dump($user_vlan);
	var_dump($public_vlan);*/
	$flag = false;
	foreach($public_vlan as $val){
		if($val["start"] != "" && $val["end"] != "")
			if($user_vlan >= $val["start"] && $user_vlan <= $val["end"])
				$flag = true;        	  
		
	}
	return $flag;
}

function websGetterms($lang){
	
	global $brand_code;
	global $hotel_name;
	global $demo_addr;
	$hotel_name = urlencode($hotel_name['en']);
	$url = $demo_addr."/Marriott/func/get_term.php?lang=$lang&brand_code=$brand_code&hotel_name=".$hotel_name['en'];
	$content = file_get_contents($url);
	
	return $content;
	
}

function in_vlan($vlan,$vlans){
        if(strlen($vlans)<1) return true;
        $vlans_r = explode(',',$vlans);
        if (in_array($vlan,$vlans_r)) return true;
        foreach($vlans_r as $val){
                $vlan_r = explode('-',$val);
                if(count($vlan_r)<2) continue;
                if( $vlan >= $vlan_r[0] and $vlan <= $vlan_r[1] ) return true;

        }
        return false;
}

function is_visible($mod_name,$mod_visible_r){
        $vlan_id =   $GLOBALS["user_vlan"];
        $is_mobile = is_mobile();
        if(!isset($mod_visible_r[$mod_name])) return false;
        if($is_mobile){
                return in_vlan($vlan_id,$mod_visible_r[$mod_name]['mobile_visible_vlans']);
        }else{
                return in_vlan($vlan_id,$mod_visible_r[$mod_name]['pc_visible_vlans']) ;
        }
        return false;

}


?>
