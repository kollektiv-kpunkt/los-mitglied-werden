<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Choice extends Component
{
    public $choice;
    public $key;
    public $letter;
    public $checked;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($choice, $key, $letter, $checked)
    {
        $this->choice = $choice;
        $this->key = $key;
        $this->letter = $letter;
        $this->checked = $checked;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.choice');
    }
}
