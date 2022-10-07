<?php

use Carbon\Carbon;
use Cocur\Slugify\Slugify;
use Ramsey\Uuid\Uuid;

require_once '../vendor/autoload.php';
$faker = Faker\Factory::create();
define('AUTHORS_COUNT', rand(2, 8));
define('CATEGORIES_COUNT', rand(2, 8));
define('POSTS_COUNT', rand(30, 50));

const DSN = 'mysql:host=127.0.0.1;port=3306';
try {
    $pdo = new PDO(DSN, 'root', '',
        [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    var_dump($e);
    exit;
}


$slugify = new Slugify();


$pdo->exec(<<<SQL
    USE blog;
    SQL
);

//////////////////////////////
/// AUTHORS
//////////////////////////////

echo '// Creating authors <br>';
$pdo->exec(<<<SQL
    SET FOREIGN_KEY_CHECKS = 0;
    TRUNCATE authors;
    SET FOREIGN_KEY_CHECKS = 1;
    SQL
);

for ($i = 0; $i < AUTHORS_COUNT; $i++) {
    $author_id = Uuid::uuid4();
    $author_name = $i > 0 ? strtolower($faker->name()) : 'Dominique Vilain';
    $author_slug = $slugify->slugify($author_name);
    $author_avatar = $faker->imageUrl(128, 128, 'people', true, $author_name);
    $author_email = $i > 0 ? $faker->unique()->safeEmail : 'dominique.vilain@hepl.be';
    $author_password = password_hash('change_this', PASSWORD_DEFAULT);
    $pdo->exec(<<<SQL
        INSERT INTO authors(id, name, slug, avatar, email, password, created_at, deleted_at, updated_at) 
        VALUES('$author_id', '$author_name', '$author_slug', '$author_avatar','$author_email', '$author_password', CURRENT_TIMESTAMP, NULL, CURRENT_TIMESTAMP)
    SQL
    );
}

//////////////////////////////
/// CATEGORIES
//////////////////////////////

echo '// Creating categories <br>';
$pdo->exec(<<<SQL
    SET FOREIGN_KEY_CHECKS = 0;
    TRUNCATE categories;
    SET FOREIGN_KEY_CHECKS = 1;
    SQL
);

for ($i = 0; $i < CATEGORIES_COUNT; $i++) {
    $category_id = Uuid::uuid4();
    $category_name = strtolower(substr($faker->sentence(2), 0, -1));
    $category_slug = $slugify->slugify($category_name);
    $pdo->exec(<<<SQL
        INSERT INTO categories(id, name, slug, created_at, deleted_at, updated_at) 
        VALUES('$category_id', '$category_name', '$category_slug', CURRENT_TIMESTAMP, NULL, CURRENT_TIMESTAMP)
    SQL
    );
}

//////////////////////////////
/// POSTS
//////////////////////////////

echo '// Creating posts <br>';
$pdo->exec(<<<SQL
    SET FOREIGN_KEY_CHECKS = 0;
    TRUNCATE posts;
    SET FOREIGN_KEY_CHECKS = 1;
    SQL
);

for ($i = 0; $i < POSTS_COUNT; $i++) {
    $post_id = Uuid::uuid4();
    $creation_date = Carbon::create($faker->dateTimeBetween('-3 years', 'now')->format('Y-m-d H:i:s'));
    $post_created_at = $creation_date;
    $post_published_at = $creation_date->addDays(rand(0, 1) * rand(2, 20));
    $post_updated_at = rand(0, 10) ? $post_created_at : $post_created_at->addWeeks(rand(2, 8));
    $post_deleted_at = rand(0, 10) ? null : Carbon::now();
    $post_author_id = $pdo->query('SELECT id FROM authors ORDER BY rand() LIMIT 1', PDO::FETCH_COLUMN, 0)->fetch();
    $post_title = $faker->sentence(10);
    $post_slug = $slugify->slugify($post_title);
    $post_excerpt = $faker->sentence(40);
    $post_thumbnail = $faker->imageUrl(640, 480, 'landscape', true);
    $post_body = '<p>'.implode('</p><p>', $faker->paragraphs(12)).'</p>';

    $pdo->exec(<<<SQL
        INSERT INTO posts(id, title, slug, excerpt, author_id, body, created_at, updated_at, published_at, thumbnail) 
        VALUES('$post_id', '$post_title', '$post_slug', '$post_excerpt', '$post_author_id', '$post_body', '$post_created_at', '$post_updated_at' ,'$post_published_at' , '$post_thumbnail');
    SQL
    );
}

//////////////////////////////
/// CATEGORY_POST
//////////////////////////////

echo '// Creating relationships between categories and posts <br>';
$pdo->exec(<<<SQL
    SET FOREIGN_KEY_CHECKS = 0;
    TRUNCATE category_post;
    SET FOREIGN_KEY_CHECKS = 1;
    SQL
);

$categories_ids = $pdo->query('SELECT id FROM categories')->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < POSTS_COUNT; $i++) {
    $post_id = $pdo->query("SELECT id FROM posts LIMIT $i,1", PDO::FETCH_COLUMN, 0)->fetch();
    echo '<br><br><br><br><br>'.$i.': ';
    echo $post_id.'<br>';
    echo '-------------'.'<br>';
    for ($j = rand(0, intdiv(CATEGORIES_COUNT, 2)); $j < CATEGORIES_COUNT; $j += rand(1, CATEGORIES_COUNT)) {
        $category_id = $categories_ids[$j]['id'];
        echo $j.':'.$category_id.'<br>';
        $pdo->exec(<<<SQL
            INSERT INTO category_post(category_id, post_id) 
            VALUES('$category_id', '$post_id');
        SQL
        );
    }
}

//////////////////////////////
/// COMMENTS
//////////////////////////////

echo '// Creating comments <br>';
$pdo->exec(<<<SQL
    SET FOREIGN_KEY_CHECKS = 0;
    TRUNCATE comments;
    SET FOREIGN_KEY_CHECKS = 1;
    SQL
);

$posts_ids = $pdo->query('SELECT id FROM posts')->fetchAll(PDO::FETCH_COLUMN);
$authors_ids = $pdo->query('SELECT id FROM authors')->fetchAll(PDO::FETCH_COLUMN);
$mod = rand(2, 3);
for ($i = 0; $i < POSTS_COUNT; $i++) {
    if ($i % $mod) {
        $comments_count = rand(1, 7);
        $post_id = $posts_ids[$i];
        echo '<br><br><br><br><br>'.$i.': ';
        echo $post_id.'<br>';
        echo '-------------'.'<br>';
        for ($j = 0; $j < $comments_count; $j++) {
            $id = Uuid::uuid4();
            $author_id = $authors_ids[rand(0, AUTHORS_COUNT - 1)];
            $body = $faker->text;
            echo $j.':'.$id.'<br>';
            $pdo->exec(<<<SQL
            INSERT INTO comments(id, body, author_id, post_id) 
            VALUES('$id', '$body', '$author_id', '$post_id');
        SQL
            );
        }
    }
}

echo '<a href="../index.php">Back to website!</a>';