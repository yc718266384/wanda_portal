<?php
header("Cache-Control:no-cache,must-revalidate");

$url = $_SERVER["SERVER_NAME"];
$rurl = $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
if (isset($_SERVER['https'])) {
    $rurl = 'https://' . $rurl;
} else {
    $rurl = 'http://' . $rurl;
}

$agent = $_SERVER["HTTP_USER_AGENT"];

$caller = isset($_SERVER["CALLER_INFO"]) ? $_SERVER["CALLER_INFO"] : false;
if ($caller === false) {
    echo 'unknow CALLER_INFO';
    exit;
}
$expval = explode(" ", $caller);
if (count($expval) == 4) {
    $mac = $expval[0];
    $vlan = intval($expval[1]);
    $ip = $expval[2];
    $status = intval($expval[3]);
}

if (strncasecmp($agent, "iPassConnect", 12) == 0) {
    if ($status == 3)
        include_once("wispr_up.php");
    else
        include_once("wispr_login.php");
    return 0;
}

if ($status == 3) {
    include_once("up.php");
    return 0;
}

/*
 * set it true if use external portal on radius server
 */
$use_radius_portal = false;

if ($use_radius_portal) {
    $radinfo = $_SERVER["RADIUS_INFO"];
    $expval = explode(" ", $radinfo);
    if (count($expval) == 2) {
        $radius_ip = $expval[0];
        $radius_key = $expval[1];
    }
    if ($radius_ip == "" || $radius_ip == "0.0.0.0") {
        echo "External portal is not available";
        return -1;
    }
    $portal_url = "http://" . $radius_ip . "/portal/index.php?url=" . $rurl . "&sid=" . $SID_INFO . "&randno=" . rand();
} else {
    /*
     * default old asp style portal
     */
    $portal_url = "http://1.1.1.3/asp_portal.php?url=" . $rurl . "&randno=" . rand();
}

?>
<html>
<script language="javascript">
    location.replace("<?= $portal_url; ?>");
</script>
<body>
<p align="center">
    <a href="<?= $portal_url; ?>">Welcome. If the browser cannot be redirected automatically, please click here, Thank
        you.</a>
</body>
</html>
