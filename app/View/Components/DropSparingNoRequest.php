<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DropSparingNoRequest extends Component
{
    /**
     * Create a new component instance.
     */
    public $sparing;
    public function __construct($sparing)
    {
        $this->sparing = $sparing;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.drop-sparing-no-request');
    }
}
