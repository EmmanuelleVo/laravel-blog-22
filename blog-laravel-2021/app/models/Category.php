<?php

namespace Blog\Models;

class Category extends Model
{
    public function category_exists(string $id): bool|string
    {
        $sql = <<< SQL
            SELECT count(id) as count
            FROM categories
            WHERE id = :id
        SQL;
        $statement = $this->pdo_connection->prepare($sql);
        $statement->execute([':id' => $id]);

        return $statement->fetchColumn();
    }

    public function get(): array
    {
        $sql = <<<SQL
                SELECT c.id,
                       c.name, 
                       c.slug, 
                       count(p.id) as posts_count
                FROM categories c
                JOIN category_post cp on c.id = cp.category_id
                JOIN posts p on cp.post_id = p.id
                GROUP BY c.id, c.name
                ORDER BY c.name;
            SQL;

        return $this->pdo_connection->query($sql)->fetchAll();
    }

    public function get_by_post(string $id): array
    {
        $sql = <<<SQL
            SELECT c.slug as category_slug, c.name as category_name
            FROM categories c 
            JOIN category_post cp on c.id = cp.category_id
            WHERE cp.post_id = :id;
        SQL;
        $statement = $this->pdo_connection->prepare($sql);
        $statement->execute([':id' => $id]);

        return $statement->fetchAll();
    }

    public function find_by_slug(string $slug): \stdClass|bool
    {
        $sql = <<<SQL
            SELECT * FROM categories WHERE slug = :slug;
        SQL;
        $statement = $this->pdo_connection->prepare($sql);
        $statement->execute([':slug' => $slug]);

        return $statement->fetch();
    }
}