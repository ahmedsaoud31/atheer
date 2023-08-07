<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;

class MultiSelect extends Component
{
    public $record;
    public $label;
    public $name;
    public $class;
    public $placeholder;
    public $options;
    public $values;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($record = null, $label = null, $name = null, $class = null, $placeholder = null, $options = [], $preoptions = [], $values = [])
    {
        $this->record = $record;
        $this->label = $label;
        $this->name = $name;
        $this->class = $class;
        $this->placeholder = $placeholder;
        $this->setOptions($options, $preoptions);
        $this->values = is_array($values)?$values:[];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.inputs.multi-select');
    }

    private function setOptions($options, $preoptions)
    {
        $out = [];
        if (is_array($preoptions) && array_values($preoptions) === $preoptions){
            foreach ($preoptions as $value) {
                $obj = (object)[];
                $obj->value = $value;
                $obj->text = ucfirst($value);
                $out[] = $obj;
            }
        }else{
            
            foreach ($preoptions as $record) {
                $obj = (object)[];
                $obj->value = $record->option_value;
                $obj->text = $record->option_text;
                $out[] = $obj;
            }
        }
        if (is_array($options) && array_values($options) === $options){
            foreach ($options as $value) {
                $obj = (object)[];
                $obj->value = $value;
                $obj->text = ucfirst($value);
                $out[] = $obj;
            }
        }else{
            foreach ($options as $record) {
                $obj = (object)[];
                $obj->value = $record->option_value;
                $obj->text = $record->option_text;
                $out[] = $obj;
            }
        }
        $this->options = $out;
    }
}
