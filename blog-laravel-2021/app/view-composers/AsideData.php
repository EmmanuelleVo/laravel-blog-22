<?php

namespace Blog\ViewComposers;

trait AsideData
{
    public function fetch_aside_data()
    {
        $authors = $this->author_model->get();
        $categories = $this->category_model->get();
        $most_recent_post = $this->post_model->latest();

        return compact('authors', 'categories', 'most_recent_post');
    }
}