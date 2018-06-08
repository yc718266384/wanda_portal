<html>
<head>
<script language="javascript">
<?php
include_once("site_conf.php");

function is_captive_portal_probe_url($url)
{
  // iPhone
  if ((substr($url, -20) === "/hotspot-detect.html") ||
    (substr($url, -35) === "apple.com/library/test/success.html") ) {
    return True;
  }

  // Android
  if (substr($url, -13) ===  "/generate_204") {
    return True;
  }

  // Windows
  if ((substr($url, -25) ===  "www.msftncsi.com/ncsi.txt") ||
    (substr($url, -39) ===  "www.msftconnecttest.com/connecttest.txt") ) {
    return True;
  }
  return False;
}

$url = isset($_GET['url'])?$_GET['url']:"";
if (empty($url) || is_captive_portal_probe_url($url)) {
  $url = $hotel_url;
}

if (strncasecmp($url , "http://", 7) != 0 &&
  strncasecmp($url , "https://", 8) != 0) {
  $url =  "http://" . $url;
}

echo "location.replace(\"" . $url . "\");";

?>
</script>
</head>
<body>
</body>
</html>
