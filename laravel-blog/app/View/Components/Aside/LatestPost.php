<?php

namespace App\View\Components\Aside;

use App\Models\Post;
use Illuminate\View\Component;

class LatestPost extends Component
{
    public $post;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->post = Post::latest()->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.aside.latest-post');
    }
}
