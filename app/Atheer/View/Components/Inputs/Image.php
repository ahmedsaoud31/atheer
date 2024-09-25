<?php

namespace App\Atheer\View\Components\Inputs;

use Illuminate\View\Component;

class Image extends Component
{
    public $record;
    public $label;
    public $name;
    public $placeholder;
    public $value;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($record = null, $label = null, $name = null, $placeholder = null, $value = null)
    {
        $this->record = $record;
        $this->label = $label;
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->setValue();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.inputs.image');
    }

    private function setValue()
    {
        if(old($this->name)){
            $this->value = old($this->name);
        }elseif($this->record){
            $this->value = $this->record->{$this->name};
        }elseif($this->value === null){
            $this->value = '';
        }
        // $this->value = old($this->name)?old($this->name):($this->record?$this->record->{$this->name}:($this->value !== null?$this->value:''));
    }
}
