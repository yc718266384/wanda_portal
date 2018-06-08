<?
	/*
	 * site_conf.php: hotel site config, by Digger
	 */
	
	/*
	 *  hotel information
	 */
	//$auth_mod_list = array('room','code','sms','tips');
	$auth_enable_list = array('room','code','sms');
	$mod_visible_r = array(
		/*
       	'sms'=> array(
                        'pc_visible_vlans'=>'50,53,55,60,70-72',
                        'mobile_visible_vlans'=>'50,53,55,60,70-72,880',
                        ),
		*/
       	'room'=> array(
                        'pc_visible_vlans'=>'',
                        'mobile_visible_vlans'=>'',
                        ),
        'code'=> array(
                        'pc_visible_vlans'=>'',
                        'mobile_visible_vlans'=>'',
                        ),
        'sms'=> array(
                        'pc_visible_vlans'=>'',
                        'mobile_visible_vlans'=>'',
                        ),
        'tips'=> array(
                        'pc_visible_vlans'=>'',
                        'mobile_visible_vlans'=>'',
                        ),
        'vpass'=> array(
                        'pc_visible_vlans'=>'',
                        'mobile_visible_vlans'=>'',
                        ),
	);

	$auth_mod_config = array(
		'sms_international' => 0,  //国际短信开启 1 或 0
		'sms_resend_sec' => 60,  //国际短信开启
		'noauth_userid' => 'publicwifi', //内置账号用户名
		'noauth_password' => 'publicwifi', //内置帐号密码
		'pad_len' => 10, //自动补字符 的位数
		'pad_char'=>'0', // 自动补的字符
	);

	$hotel_name["cn"] = "北京长安街W酒店";
	$hotel_name["en"] = "W Beijing - Chang'an ";
	$hotel_address["cn"] = "中国 北京, 建国门南大街 2 号, 朝阳区 邮政编码 100022";
	$hotel_address["en"] = "No.2 Jianguomennan Avenue Beijing, Beijing100022 China";
	$brand_code = "WHO";
	$hotel_detail_url = 'http://www.marriott.com';
	$e_interface_url = "http://www.starwoodhotels.com";
	$use_add_zero = 1;
	$use_trim = 1;
	$demo_addr = "http://demo.amttgroup.com:58080";
	include_once('lang.php');
	/* 
	 *  policy information
	 */
	
	// parameters in public areas
	
	$use_public_page = 1; //if you use the following three ways, set it 1
	$use_bind_auth = 1; // if bind password authentication is used, set it 1
	$bind_vlan[0]["start"] = 5000;
	$bind_vlan[0]["end"] = 5000;


	$use_conference_page = 1; 
	$use_event_page = 1; 
	$use_wechat = 1;
	$use_reurl = 0;
	/*
	 *  vlan information 
	 */
	 
	/*
	 * could be hotel or hotel group URL, !!! DONOT include "http://"
	 * !!! www.google.com may be blocked by government
	 */
	$delay_sec = 3 ;
	$hotel_url = "www.amttgroup.com";

	/*
	 * if hibos donnot support portal query API, set it 0
	 */
	$hibos_portal_query = 1;

	/*
	 * hotel self_help URL, default empty, !!! DONNOT include "http://"
	 * currently only Marriott need it set as "upgrade.com"
	 */
	if (isset($_SERVER["SELF_HELP"]))
		$self_help_host = $_SERVER["SELF_HELP"]; /* PnPGW ver > 20121115 */
	else
		$self_help_host = "";	/* set it if PnPGW ver = 20121115 */

	/*
	 * if enable room cookie auth for wired connect, 1 true, 0 false
	 * !!! should set it false if pnpgw version is not newer than 20120906
	 */
	$room_cookie_auth = 1;		/* set 0 if PnPGW ver < 20120906 */

	/*
	 * if enable portal ads_push, 1 true, default 0 false
	 * currently only Shangri-La need portal ads_push function
	 * !!! the ads_index.php must be present if ads_push enabled
	 */
	if (isset($_SERVER["ADS_PUSH"]))
		$ads_push = $_SERVER["ADS_PUSH"];	/* PnPGW ver >= 20130101 */
	else
		$ads_push = 0;				/* PnPGW ver < 20130101 */

	/* the height of portal ads bar */
	if (isset($_SERVER["ADS_BHEIGHT"]))
		$bheight = $_SERVER["ADS_BHEIGHT"];	/* PnPGW ver >= 20130101 */
	else
		$bheight = 58;				/* PnPGW ver < 20130101 */

	/*
	 * how many minutes before enrollment timeout to prompt user to purchase more time
	 * default 5 minutes
	 */
	if (isset($_SERVER["ADS_BTIME"]))
		$btime = $_SERVER["ADS_BTIME"];		/* PnPGW ver >= 20130101 */
	else
		$btime = 5;				/* PnPGW ver < 20130101 */

	/* site auth flow debug for cookie and pub auth, 1 ture, default 0 false */
	$site_debug = 0;

	if ($debug == 1) {
		echo "hotel_url: ".$hotel_url."<br>";
		echo "self_help_host: ".$self_help_host."<br>";
		echo "room_cookie_auth: ".$room_cookie_auth."<br>";
		echo "ads_push: ".$ads_push."<br>";
		echo "bheight: ".$bheight."<br>";
		echo "btime: ".$btime."<br>";
	}
?>
