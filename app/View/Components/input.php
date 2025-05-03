<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class input extends Component
{
    
    public $id;
    public $name;
    public $label;
    public $type;
    public $placeholder;
    public $value;
    public $icon;
    public $required;
    public $disabled;
public $accept;
     

    /**
     * Create a new component instance.
     */
    public function __construct($id, $name, $label, $type, $placeholder, $value = null, $icon = null, $accept = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->icon = $icon;
        $this->accept = $accept;
    }
    

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}
