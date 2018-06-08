<?
	/*
	 * portal entry for up users, by Digger
	 *
	 * history change log:
	 *  - add apple iOS wifi detection support
	 *  - add Win XP/7 wifi detection suport
	 *
	 * change log:
	 *  - 20121203, use site_conf.php vars: self_help, ads_push, hotel_url
	 *  - 20130926, add apple iOS7 wifi detection support
	 *  - 20140108, add android 4.3/4.4 wifi detection support
	 */
	include_once("guest_env.php");

	$path = $_SERVER["REQUEST_URI"];

	/* for Android 4.3 or 4.4 Wifi dectection */
	if (strcasecmp($path, "/generate_204") == 0) {
			header('HTTP/1.1 204 No Content');
		exit(0);
	}

	/* for Apple iOS 5 or 6 Wifi dectection */
	if ((strcasecmp($url, "www.apple.com") == 0 ||
	     strcasecmp($url, "apple.com") == 0 ||
	     strcasecmp($url, "1.1.1.3") == 0) &&
	    strcasecmp($path, "/library/test/success.html") == 0) {
		echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 3.2//EN\">\r\n";
		echo "<HTML>\r\n";
		echo "<HEAD>\r\n";
		echo "\t<TITLE>Success</TITLE>\r\n";
		echo "</HEAD>\r\n";
		echo "<BODY>\r\n";
		echo "Success\r\n";
		echo "</BODY>\r\n";
		echo "</HTML>\r\n";
		exit(0);
	}

	/* for new Apple iOS 7 Wifi dectection */
	if (strcasecmp($url, "captive.apple.com") == 0 ||
	    strcasecmp($url, "www.appleiphonecell.com") == 0 ||
	    strcasecmp($url, "www.airport.us") == 0 ||
	    strcasecmp($url, "www.itools.info") == 0 ||
	    strcasecmp($url, "www.ibook.info") == 0 ||
	    strcasecmp($url, "www.thinkdifferent.us") == 0) {
		echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 3.2//EN\">\r\n";
		echo "<HTML>\r\n";
		echo "<HEAD>\r\n";
		echo "\t<TITLE>Success</TITLE>\r\n";
		echo "</HEAD>\r\n";
		echo "<BODY>\r\n";
		echo "Success\r\n";
		echo "</BODY>\r\n";
		echo "</HTML>\r\n";
		exit(0);
	}

	/* for Win XP/7 box NCSI dectection */
	if (strcasecmp($url, "www.msftncsi.com") == 0 &&
	    strcasecmp($path, "/ncsi.txt") == 0) {
		echo "Microsoft NCSI";
		exit(0);
	}

	/* for self help url entry */
	if (strcasecmp($url, "help") == 0 ||
	    strcasecmp($url, "help.pnp.gw") == 0 ||
	    strcasecmp($url, "1.1.1.1") == 0 ||
	    strcasecmp($url, $self_help_host) == 0) {
		if ($ads_push == 1) {
			include_once("ads_push.php");
			return;
		} else {
			$lang = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
			if (strncasecmp($lang, "zh-cn", 5) == 0)
				$prefix = "c";
			else
				$prefix = "";
			$url = "1.1.1.3/".$prefix."connect.asp?realip=".$user_ip;         
/*		  	$url = "1.1.1.3/notepass.asp?realip=".$user_ip;   */
		}

	} else if (strcasecmp($url, "wpad") == 0 ||
		   strcasecmp($url, "wpad.pnp.gw") == 0) {

		echo "function FindProxyForURL(url, host) {\r\n";
		echo "return \"DIRECT\";\r\n";
		echo "}\r\n";
		exit;

	} else if (ip2long($url) != FALSE)

		$url = $hotel_url;
?>
<html>
<head>
<script language="javascript">
function go() {
	location.replace("http://<? echo $url?>");
}
setTimeout("go()", 2000);
</script>
</head>
<body>
<p align=center>
<?
if ($site_debug == 1) {
	echo "Connecting http://".$url." in progress ...";
}
?>
</body>
<html>

