<?php
require_once 'vendor/autoload.php';
$faker = Faker\Factory::create();
define('AUTHORS_COUNT', rand(2, 8));
define('CATEGORIES_COUNT', rand(2, 8));
define('POSTS_COUNT', rand(30, 50));


// On détruit d’abord les fichiers existants
if (file_exists('./datas/posts')) {
    $files = scandir('./datas/posts');
    foreach ($files as $file) {
        if (str_ends_with($file, '.json')) unlink('./datas/posts/' . $file);
    }
}

// On crée un tableau d’auteurs, tout en minuscule.
$authors = [];
for ($i = 0; $i < AUTHORS_COUNT; $i++) {
    $author_name = $faker->name();
    $author_avatar = $faker->imageUrl(128, 128, 'people', true, $author_name);
    $authors [] = ['name' => strtolower($author_name), 'avatar' => $author_avatar];
}

// On crée un tableau de noms de catégories, tout en minuscule.
// Avec sentence, il y a un point à la fin de la chaîne. On l’enlève.
$categories = [];
for ($i = 0; $i < CATEGORIES_COUNT; $i++) {
    $category = strtolower(substr($faker->sentence(2), 0, -1));
    $categories [] = $category;
}

// On crée un tableau de posts et on stocke chacun dans un fichier nommé selon son id.
for ($i = 0; $i < POSTS_COUNT; $i++) {
    $post = new stdClass();
    $post->id = uniqid();
    $post->published_at = $faker->dateTimeBetween('-3 years', 'now')->format('Y-m-d H:i:s');
    $idx = rand(0, count($authors) - 1);
    $post->author_name = $authors[$idx]['name'];
    $post->author_avatar = $authors[$idx]['avatar'];
    $post->title = $faker->sentence(10);
    $post->excerpt = $faker->sentence(40);
    $post->body = '<p>' . implode('</p><p>', $faker->paragraphs(12)) . '</p>';
    $post->category = $categories[rand(0, count($categories) - 1)];
    file_put_contents('./datas/posts/' . $post->id . '.json', json_encode($post));
}
