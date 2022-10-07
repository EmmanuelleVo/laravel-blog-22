<?php
$routes = require(DOCUMENT_ROOT.'/configs/routes.php');

$method = $_SERVER['REQUEST_METHOD'];//GET ? POST ?
$methodName = '_'.$method;//_GET _POST
$action = $$methodName['action'] ?? '';
$resource = $$methodName['resource'] ?? '';

$route = array_filter($routes, fn($r) => $r['method'] === $method
    && $r['action'] === $action
    && $r['resource'] === $resource);

if (!$route) {
    header('Location: index.php?action=index&resource=post');
    exit();
}

return reset($route);