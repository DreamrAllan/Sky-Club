<?php

namespace App\Http\Controllers\schedule;

class Schedule
{
    public string $date;
    public array $sessions;
    public int $field;

    public function __construct($date)
    {
        $this->date = $date;
        $this->sessions = array_fill(0, 24, true);
        $this->field = 1;
    }
}
