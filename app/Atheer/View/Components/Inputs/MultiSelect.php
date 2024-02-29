<?php

namespace App\Atheer\View\Components\Inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MultiSelect extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public $model = null,
        public $type = 'text',
        public $label = '',
        public $name = '',
        public $placeholder = '',
        public $options = [],
        public $selectedOptions = [],
        public $disabled = false,
    ) {
        
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('atheer::components.inputs.multi-select');
    }
}
