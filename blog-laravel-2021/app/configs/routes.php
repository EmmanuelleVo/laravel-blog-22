<?php
return [
    [
        'method' => 'POST',
        'action' => 'store',
        'resource' => 'post',
        'controller' => 'PostController',
        'callback' => 'store',
    ],
    [
        'method' => 'GET',
        'action' => 'show',
        'resource' => 'post',
        'controller' => 'PostController',
        'callback' => 'show',
    ],
    [
        'method' => 'GET',
        'action' => 'index',
        'resource' => 'post',
        'controller' => 'PostController',
        'callback' => 'index',
    ],
    [
        'method' => 'GET',
        'action' => 'create',
        'resource' => 'post',
        'controller' => 'PostController',
        'callback' => 'create',
    ],
    [
        'method' => 'GET',
        'action' => 'login',
        'resource' => 'auth',
        'controller' => 'SessionController',
        'callback' => 'create',
    ],
    [
        'method' => 'POST',
        'action' => 'login',
        'resource' => 'auth',
        'controller' => 'SessionController',
        'callback' => 'store',
    ],
    [
        'method' => 'POST',
        'action' => 'logout',
        'resource' => 'auth',
        'controller' => 'SessionController',
        'callback' => 'destroy',
    ],
];