<?php

use Models\Post;

require '../configs/config.php';
require '../vendor/autoload.php';

$post_model = new Post();
if (get_class($post_model) !== 'Models\Post') {
    die('le post n’est pas du bon type');
}
echo 'Get Method : '.PHP_EOL;
echo json_encode($post_model->get(), JSON_PRETTY_PRINT);