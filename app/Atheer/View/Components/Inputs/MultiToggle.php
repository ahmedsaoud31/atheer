<?php

namespace App\Atheer\View\Components\Inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MultiToggle extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $model = null,
        public $label = '',
        public $name = '',
        public $placeholder = '',
        public $options = [],
        public $selections = [],
        public $inputClass = '',
    ) {
        $this->setValue();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('atheer::components.inputs.multi-toggle');
    }

    private function setValue()
    {
        $this->selections = old($this->name)?old($this->name):$this->selections;
    }
}
