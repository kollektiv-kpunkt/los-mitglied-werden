<?php

namespace App\View\Components\Form\Contentblocks;

use Illuminate\View\Component;

class title extends Component
{
    public $block;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($block)
    {
        $this->block = $block;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.contentblocks.title');
    }
}
