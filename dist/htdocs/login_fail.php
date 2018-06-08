<?php

require_once __DIR__ . '/portal/vendor/Autoloader.php';
spl_autoload_register(['Autoloader', 'autoload'], true, true);

use common\GlobalData;

$msg = isset($_GET['msg']) ? $_GET['msg'] : 'error';

$lang = GlobalData::get(GlobalData::KEY_LANG);
if ($lang == 'cn') {
    $msgMap = [
        'Account nonexists' => '帐号不存在',
        'Password error' => '密码错误',
    ];
    $showMsg = isset($msgMap[$msg]) ? $msgMap[$msg] : '认证失败';
    $clickMsg = '确定';
} else {
    $msgMap = [
        'Account nonexists' => 'Account None Exists',
        'Password error' => 'Password Error',
    ];
    $showMsg = isset($msgMap[$msg]) ? $msgMap[$msg] : 'Authentication Failure';
    $clickMsg = 'OK';
}
?>

<html>
<head>
    <?php include_once __DIR__ . '/portal/view/common/head.php' ?>
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <style>
        .dim {
            height: 100%;
            width: 100%;
            left: 0;
            top: 0;
            position: fixed;
            z-index: 1 !important;
            background-color: black;
            filter: alpha(opacity=75); /* internet explorer */
            -khtml-opacity: 0.75; /* khtml, old safari */
            -moz-opacity: 0.75; /* mozilla, netscape */
            opacity: 0.75; /* fx, safari, opera */
        }

        .dialog {
            width: 478px;
            height: 200px;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            z-index: 5;
        }

        .alert {
            padding: 8px 35px 16px;
            color: #555;
            text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
            background-color: #ffffff;
            text-align: center;
        }

        .alert-heading {
            color: inherit;
        }

        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
            min-width: 150px;
        }

        .btn-primary {
            color: #fff;
            background-color: #8D7342;
            border-color: #8D7342;
        }

        @media only screen and (max-width: 641px) {
            .dialog {
                width: 80%;
            }
        }
    </style>
    <script language="javascript">
        function go() {
            location.replace("http://1.1.1.3/index.php");
        }

        //setTimeout("go()", 10000);
    </script>
</head>
<body>
<p><?= $showMsg ?></p>

<div class="dim"></div>
<div class="dialog">
    <div class="alert" onclick="go()">
        <h2 class="alert-heading"><?= $showMsg ?></h2>
        <a type="button" class="btn btn-primary" onclick="go()"><?= $clickMsg ?></a>
    </div>
</div>

</body>
</html>
