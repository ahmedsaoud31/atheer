<?php

namespace App\Atheer\View\Components\Inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $model = null,
        public $type = 'text',
        public $label = '',
        public $name = '',
        public $id = '',
        public $placeholder = '',
        public $value = '',
        public $inputClass = '',
    ) {
        $this->setValue();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('atheer::components.inputs.input');
    }

    private function setValue()
    {
        $this->value = $this->value?$this->value:(old($this->name)?old($this->name):($this->model?$this->model?->{$this->name}:''));
        
        if($this->value && $this->type == 'date'){
            $this->value = date('Y-m-d', strtotime($this->value));
        }
        if($this->type == 'password'){
            $this->value = null;
        }
    }
}
