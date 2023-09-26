<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{
    public $title;
    public $description;
    public $canonical;
    /**
     * Create a new component instance.
     *
     * @return void
     * @param $title
     * @param $description
     * @param $og
     * @param $canonical
     */
    public function __construct($title, $description, $canonical) {
        $this->title = $title;
        $this->description = $description;
        $this->canonical = $canonical;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('layouts.app-layout');
    }
}
