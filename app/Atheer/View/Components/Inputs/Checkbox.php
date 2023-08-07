<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public $record;
    public $label;
    public $name;
    public $checked;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($record = null, $label = null, $name = null, $checked = null)
    {
        $this->record = $record;
        $this->label = $label;
        $this->name = $name;
        $this->checked = $checked;
        $this->setChecked();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.inputs.checkbox');
    }

    public function setChecked()
    {
        if(old($this->name) && old($this->name) == 'on'){
            $this->checked = 'checked';
        }elseif($this->record && $this->record->{$this->name}){
            $this->checked = 'checked';
        }elseif($this->checked !== null){
            $this->checked = 'checked';
        }
    }

}
