<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Inputs extends Component
{
    public $step;
    public $key;
    public $supporter;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($step, $key, $supporter)
    {
        $this->step = $step;
        $this->key = $key;
        $this->supporter = $supporter;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.inputs');
    }
}
