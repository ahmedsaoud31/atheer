<?php

namespace App\Atheer\View\Components\Inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Password extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $model = null,
        public $label = '',
        public $name = '',
        public $placeholder = '',
        public $value = '',
    ) {
        
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('atheer::components.inputs.password');
    }
}
