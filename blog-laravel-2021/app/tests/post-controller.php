<?php

use Blog\Models\Post;
use GuzzleHttp\Exception\GuzzleException;

require '../vendor/autoload.php';

$client = new GuzzleHttp\Client();
$post_model = new Post();

echo 'Testing show request'.PHP_EOL;
echo 'Fetching the latest post first to get its slug'.PHP_EOL;
$latest_slug = $post_model->latest()->post_slug;
echo 'The slug is: '.$latest_slug.PHP_EOL;

// Making the request using GuzzleHTTP
try {
    $res = $client->request('GET', 'http://blog.test/?action=show&resource=post&slug='.$latest_slug);
} catch (GuzzleException $e) {
    echo $e->getMessage().PHP_EOL;
    exit;
}
// Everything is OK ? Display the result of the request. Probably some HTML
echo 'The latest post is :'.PHP_EOL;
echo $res->getBody()->getContents();