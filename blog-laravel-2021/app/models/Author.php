<?php

namespace Blog\Models;

use stdClass;

class Author extends Model
{
    public function get(): array
    {
        $sql = <<<SQL
                SELECT a.id,
                       a.name, 
                       a.avatar, 
                       a.slug, 
                       count(posts.id) as posts_count
                FROM posts
                JOIN authors a on posts.author_id = a.id
                GROUP BY a.id
            SQL;

        return $this->pdo_connection->query($sql)->fetchAll();
    }

    public function find_by_slug($slug): stdClass|bool
    {
        $sql = <<<SQL
            SELECT * FROM authors WHERE slug = :slug;
        SQL;
        $statement = $this->pdo_connection->prepare($sql);
        $statement->execute([':slug' => $slug]);

        return $statement->fetch();
    }

    public function find_by_email($email): stdClass|bool
    {
        $sql = <<<SQL
            SELECT * FROM authors WHERE email = :email;
        SQL;
        $statement = $this->pdo_connection->prepare($sql);
        $statement->execute([':email' => $email]);

        return $statement->fetch();
    }
}