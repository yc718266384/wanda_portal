<?
	include_once(__DIR__ . "/site_conf.php");

	if (!isset($url) || $url == "" || strncmp($url, "1.1.1", 5) == 0)
		$url = $hotel_url;
	if (strncasecmp($url, "http://", 7) != 0)
		$url = "http://".$url;
?>
<html>
<head>
<title></title>
</head> 
<frameset rows="<? echo $bheight; ?>,*" frameborder="no" border="0" framespacing="0">
<frame src="http://1.1.1.3/ads_index.php?url=<? echo $url; ?>&btime=<? echo $btime; ?>" name="ads_f" scrolling="no" noresize>
<frame src="<? echo $url; ?>" name="main_f" marginwidth="0" marginheight="0" frameborder="0" scrolling="auto">
</frameset>
<noframes> <body></body></noframes>
</html>
