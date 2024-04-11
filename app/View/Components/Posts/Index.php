<?php

namespace App\View\Components\Posts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Index extends Component
{
    //PASSING DATA TO COMPONENTS
    // public $post;
    /**
     * Create a new component instance.
     */
    public function __construct(/* PASSING DATA TO COMPONENTS *//* $post */)
    {
        //PASSING DATA TO COMPONENTS
        // $this->post = $post;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.posts.index');
    }
}
