<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Radio extends Component
{
    public $step;
    public $key;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($step, $key)
    {
        $this->step = $step;
        $this->key = $key;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.radio');
    }
}
