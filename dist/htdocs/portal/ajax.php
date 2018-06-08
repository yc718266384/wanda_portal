<?php

use action\AjaxAction;
use vendor\http\Request;

require_once __DIR__ . '/vendor/Autoloader.php';
spl_autoload_register(['Autoloader', 'autoload'], true, true);

$action = Request::get('a');

if ($action) {
    $ajaxAction = new AjaxAction();
    $result = $ajaxAction->$action();
    if (is_array($result)) {
        echo json_encode($result);
    } else {
        echo $result;
    }
    exit;
}

throw new Exception('未知的操作:' . $action);