<?php

namespace App\View\Components;

use Illuminate\View\Component;

class panunote_topbar extends Component
{

    public $username;
    public $image;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($username,$image)
    {
        //
        $this->username = $username;
        $this->image = $image;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.panunote_topbar');
    }
}
