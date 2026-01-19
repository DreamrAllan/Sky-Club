<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DropBooking extends Component
{
    /**
     * Create a new component instance.
     */
    public $booking;
    public $sesi;
    public function __construct($booking, $sesi)
    {
        $this->booking = $booking;
        $this->sesi = $sesi;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.drop-booking');
    }
}
