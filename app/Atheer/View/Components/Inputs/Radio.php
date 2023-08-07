<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;

class Radio extends Component
{
    public $record;
    public $name;
    public $label;
    public $labels;
    public $values;
    public $checked;
    public $radios;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($record = null, $name = null, $label =null, $labels = [], $values = [], $checked = null)
    {
        $this->record = $record;
        $this->name = $name;
        $this->label = $label;
        $this->labels = $labels;
        $this->values = $values;
        $this->checked = $checked;
        $this->setRadios();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.inputs.radio');
    }

    public function setRadios()
    {
        if(count($this->labels) != count($this->values)){
            $this->radios = [];
        }
        
        $checked_index = false;
        if(old($this->name)){
            $checked_index = array_search(old($this->name), $this->values);
        }
        
        if($checked_index === false && $this->record){
            $checked_index = array_search($this->record->{$this->name}, $this->values);
        }
        
        if($checked_index === false && $this->checked){
            $checked_index = array_search($this->checked, $this->values);
        }

        for ($i=0; $i < count($this->labels); $i++) { 
            $temp = (object)[];
            $temp->label = $this->labels[$i];
            $temp->value = $this->values[$i];
            $temp->checked = '';
            if($checked_index == $i){
                $temp->checked = 'checked';
            }
            $this->radios[] = $temp;
        }
    }
}
