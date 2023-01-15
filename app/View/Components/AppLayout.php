<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{
    public $title;
    public $description;
    public $og;
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
    public function __construct($title, $description, $og, $canonical) {
        $this->title = $title;
        $this->description = $description;
        $this->og = $og;
        $this->canonical = $canonical;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.app-layout');
    }
}
