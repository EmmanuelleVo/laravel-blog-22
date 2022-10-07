<?php

namespace Blog\Request\Validators;

trait StorePostRequest
{
    public function has_validation_errors(): bool
    {
        unset($_SESSION['errors'], $_SESSION['old']);

        if (mb_strlen($_POST['post-title']) < 5 || mb_strlen($_POST['post-title']) > 100) {
            $_SESSION['errors']['post-title'] = 'Le titre doit être avoir une taille comprise entre 5 et 100 caractères';
        }
        if (mb_strlen($_POST['post-excerpt']) < 20 || mb_strlen($_POST['post-excerpt']) > 200) {
            $_SESSION['errors']['post-excerpt'] = 'Le résumé doit être avoir une taille comprise entre 20 et 200 caractères';
        }
        if (mb_strlen($_POST['post-body']) < 100 || mb_strlen($_POST['post-body']) > 1000) {
            $_SESSION['errors']['post-body'] = 'Le texte doit être avoir une taille comprise entre 100 et 1000 caractères';
        }
        if (!$this->category_model->category_exists($_POST['post-category'])) {
            $_SESSION['errors']['category'] = 'La catégorie doit faire partie des catégories existantes';
        }

        return isset($_SESSION['errors']) && count($_SESSION['errors']);
    }
}