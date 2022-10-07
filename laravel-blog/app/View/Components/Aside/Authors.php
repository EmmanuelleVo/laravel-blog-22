<?php

namespace App\View\Components\Aside;

use App\Models\User;
use Illuminate\View\Component;

class Authors extends Component
{
    public $users;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->users = User::withCount(['posts', 'comments'])->paginate('5');
        if(request()->has('authors')) {
            $this->users = User::withCount(['posts', 'comments'])->get();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.aside.authors');
    }
}
