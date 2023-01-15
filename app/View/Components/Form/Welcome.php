<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Welcome extends Component
{
    public $step;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($step)
    {
        $this->step = $step;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.welcome');
    }
}
