<?php

namespace App\Atheer\View\Components\Inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Hidden extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $model = null,
        public $name = '',
        public $value = '',
    ) {
        $this->setValue();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('atheer::components.inputs.hidden');
    }

    private function setValue()
    {
        $this->value = $this->value?$this->value:($this->model?$this->model?->{$this->name}:'');
    }
}
