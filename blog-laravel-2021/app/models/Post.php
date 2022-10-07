<?php

namespace Blog\Models;

use stdClass;
use PDOException;
use const PER_PAGE;
use const DEFAULT_SORT_ORDER;

class Post extends Model
{
    public function __construct(
        private readonly Category $category_model = new Category(),
        private readonly Author $author_model = new Author()
    ) {
        parent::__construct();
    }

    public function save(stdClass $post): bool|string
    {
        try {
            $st_post = $this->pdo_connection->prepare(
                <<<SQL
                    INSERT INTO posts(id,title,slug,excerpt,author_id,body,published_at,thumbnail) 
                    VALUES(:post_id,:post_title,:post_slug,:post_excerpt,:post_author_id,:post_body,:post_published_at,:post_thumbnail);
                SQL
            );
            $st_post->execute([
                ':post_id' => ''.$post->id, ':post_title' => $post->title, ':post_slug' => $post->slug,
                ':post_excerpt' => $post->excerpt, ':post_author_id' => $post->author_id, ':post_body' => $post->body,
                ':post_published_at' => $post->published_at, ':post_thumbnail' => $post->thumbnail,
            ]);

            $st_relation = $this->pdo_connection->prepare(
                <<<SQL
                    INSERT INTO category_post(category_id, post_id)
                    VALUES(:post_category_id, :post_id)
                SQL
            );
            $st_relation->execute([
                ':post_category_id' => $post->category_id, ':post_id' => ''.$post->id,
            ]);

            return true;
        } catch (PDOException $exception) {
            return $exception->getMessage();
        }
    }

    public function latest(): stdClass
    {
        $sql = <<<SQL
                SELECT p.id as post_id, 
                   p.slug as post_slug, 
                   p.title as post_title, 
                   p.excerpt as post_excerpt,
                   p.published_at as post_published_at,
                   a.avatar as post_author_avatar,
                   a.name as post_author_name,
                   a.slug as post_author_slug
                FROM posts p 
                JOIN authors a on p.author_id = a.id
                ORDER BY published_at DESC
                LIMIT 1;
            SQL;

        $post = $this->pdo_connection->query($sql)->fetch();
        $this->add_categories($post);

        return $post;
    }

    public function add_categories(stdClass &$post): void
    {
        $post->post_categories = $this->category_model->get_by_post($post->post_id);
    }

    public function get(array $filter = [], string $order = DEFAULT_SORT_ORDER, int $page = 1): array
    {
        $posts = [];
        $start = ($page - 1) * PER_PAGE;
        $per_page = PER_PAGE;

        if (isset($filter['type'])) {
            $value = $filter['value'];
            if ($filter['type'] === 'category') {
                $category = $this->category_model->find_by_slug($value);
                if ($category) {
                    $posts = $this->get_by_category($category->id, $order, $start, $per_page);
                }
            } elseif ($filter['type'] === 'author') {
                $author = $this->author_model->find_by_slug($value);
                if ($author) {
                    $posts = $this->get_by_author($author->id, $order, $start, $per_page);
                }
            }
        } else {
            $posts = $this->get_unfiltered($order, $start, $per_page);
        }

        $this->add_categories_to_many($posts);

        return $posts;
    }

    public function get_unfiltered(string $order, int $start, int $per_page): array
    {
        $sql = <<<SQL
            SELECT p.id as post_id, 
                   p.slug as post_slug, 
                   p.title as post_title, 
                   p.excerpt as post_excerpt,
                   p.published_at as post_published_at,
                   a.avatar as post_author_avatar,
                   a.name as post_author_name,
                   a.slug as post_author_slug
            FROM posts p 
            JOIN authors a on p.author_id = a.id
            ORDER BY published_at $order
            LIMIT $start, $per_page;
        SQL;

        return $this->pdo_connection->query($sql)->fetchAll();
    }

    public function get_by_category(string $id, string $order, int $start, int $per_page): array
    {
        $sql = <<<SQL
                SELECT p.id as post_id, 
                       p.title as post_title,
                       p.slug as post_slug,
                       p.excerpt as post_excerpt,
                       p.published_at as post_published_at,
                       a.avatar as post_author_avatar,
                       a.name as post_author_name,
                       a.slug as post_author_slug
                FROM posts p
                JOIN authors a on p.author_id = a.id
                JOIN category_post cp on p.id = cp.post_id
                WHERE cp.category_id = :id
                ORDER BY published_at $order
                LIMIT $start, $per_page;
            SQL;
        $statement = $this->pdo_connection->prepare($sql);
        $statement->execute([':id' => $id]);

        return $statement->fetchAll();
    }

    public function get_by_author(string $id, string $order, int $start, int $per_page): array
    {
        $sql = <<<SQL
                SELECT p.id as post_id, 
                       p.title as post_title, 
                       p.published_at as post_published_at,
                       p.slug as post_slug,
                       p.excerpt as post_excerpt,
                       a.avatar as post_author_avatar,
                       a.name as post_author_name,
                       a.slug as post_author_slug
                FROM posts p
                JOIN authors a on p.author_id = a.id
                WHERE author_id = :id
                ORDER BY published_at $order
                LIMIT $start, $per_page;
            SQL;

        $statement = $this->pdo_connection->prepare($sql);
        $statement->execute([':id' => $id]);

        return $statement->fetchAll();
    }

    public function add_categories_to_many(array $posts): void
    {
        foreach ($posts as $post) {
            $post->post_categories = $this->category_model->get_by_post($post->post_id);
        }
    }

    public function count(): string
    {

        $sql = <<<SQL
                SELECT count(*) 
                FROM posts p;
            SQL;

        return $this->pdo_connection->query($sql)->fetchColumn();
    }

    public function count_by_category(string $slug): string
    {
        $sql = <<<SQL
                SELECT count(p.id) 
                FROM posts p
                LEFT JOIN category_post cp on p.id = cp.post_id
                LEFT JOIN categories c on c.id = cp.category_id
                WHERE c.slug = :slug;
            SQL;
        $statement = $this->pdo_connection->prepare($sql);
        $statement->execute([':slug' => $slug]);

        return $statement->fetchColumn();
    }

    public function count_by_author(string $slug): string
    {
        $sql = <<<SQL
                SELECT count(p.id) 
                FROM posts p
                JOIN authors a on p.author_id = a.id
                WHERE a.slug = :slug;
            SQL;
        $statement = $this->pdo_connection->prepare($sql);
        $statement->execute([':slug' => $slug]);

        return $statement->fetchColumn();
    }

    public function find_by_slug($slug): stdClass|bool
    {
        $statement = $this->pdo_connection->prepare(<<<SQL
            SELECT p.id as post_id, 
                   p.title as post_title, 
                   p.body as post_body, 
                   p.published_at as post_published_at, 
                   a.id as post_author_id, 
                   a.name as post_author_name,
                   a.slug as post_author_slug,
                   a.avatar as post_author_avatar
            FROM posts p
            JOIN authors a on p.author_id = a.id
            WHERE p.slug = :slug;
        SQL
        );
        $statement->execute(['slug' => $_GET['slug']]);

        return $statement->fetch();
    }
}