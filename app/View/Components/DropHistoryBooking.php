<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DropHistoryBooking extends Component
{
    /**
     * Create a new component instance.
     */
    public $list_booking;
    public function __construct($listbooking)
    {
        $this->list_booking = $listbooking;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.drop-history-booking');
    }
}
