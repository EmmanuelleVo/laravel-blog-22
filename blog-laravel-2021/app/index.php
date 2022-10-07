<?php
session_start();

require './configs/config.php';
require DOCUMENT_ROOT.'/vendor/autoload.php';


$route = require(DOCUMENT_ROOT.'/utils/router.php');

$controllerName = 'Blog\\Controllers\\'.$route['controller'];

$controller = new $controllerName();

$data = call_user_func([$controller, $route['callback']]);

extract($data);

require VIEWS_PATH.$view;

unset($_SESSION['errors'], $_SESSION['old']);