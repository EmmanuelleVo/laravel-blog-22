<?php

namespace App\View\Components\Commons;

use App\Models\User;
use Illuminate\View\Component;

class Navigation extends Component
{
    public User $user;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = User::where('email', 'emmanuelle.vo@student.hepl.be')->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.commons.navigation');
    }
}
