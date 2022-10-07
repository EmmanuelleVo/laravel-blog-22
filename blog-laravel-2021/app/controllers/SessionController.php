<?php

namespace Blog\Controllers;

use Blog\Models\Post;
use Blog\Models\Author;
use Blog\Models\Category;
use JetBrains\PhpStorm\NoReturn;
use Blog\ViewComposers\AsideData;

class SessionController
{
    use AsideData;

    public function __construct(
        private readonly Author $author_model = new Author(),
        private readonly Category $category_model = new Category(),
        private readonly Post $post_model = new Post(),
    ) {
    }

    public function create(): array
    {

        $view_data = [];
        $view_data['view'] = 'auth/login_form.php';
        $view_data['data'] = $this->fetch_aside_data();

        return $view_data;
    }

    #[NoReturn] public function store(): void
    {
        $email = $_POST['email'];
        if ($author = $this->author_model->find_by_email($email)) {
            if (password_verify($_POST['password'], $author->password)) {
                $_SESSION['connected_author'] = $author;
                header('Location: /?action=index&resource=post&author='.$author->slug);
                exit;
            }
        }
        header('Location: /?action=login&resource=auth');
        exit;
    }

    #[NoReturn] public function destroy(): void
    {
        unset($_SESSION['connected_author']);
        header('Location: /?action=login&resource=auth');
        exit;
    }
}