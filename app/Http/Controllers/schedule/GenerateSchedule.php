<?php

namespace App\Http\Controllers\schedule;

use Carbon\Carbon;
use App\Models\ListBooking;

class GenerateSchedule
{
    public array $field_schedules;
    public Carbon $now;
    public Carbon $startOfWeek;
    public Carbon $endDate;
    public Carbon $endOfWeek;
    public int $daysCount;

    public function __construct(int $month)
    {
        $this->field_schedules = [];
        $this->now = Carbon::now('Asia/Jakarta');
        $this->endDate = $this->now->copy()->addMonths($month);
        $this->endOfWeek = $this->endDate->copy()->endOfWeek();
        $this->startOfWeek = $this->now->copy()->startOfWeek();
        $this->daysCount = $this->startOfWeek->diffInDays($this->endOfWeek);
    }
    public function createSchedule()
    {
        // mencari jadwal yang sudah dibooking dengan status accept
        $bookings = ListBooking::whereRelation('booking', function ($query) {
            $query
                ->whereIn('status', ['accept', 'pending']);
        })->get();

        //generate schedule
        for ($i = 0; $i < $this->daysCount + 1; $i++) {
            $dates = $this->startOfWeek->copy()->addDays($i)->format('Y-m-d');
            $field_schedules[$i] = new Schedule($dates);
            for ($sesi = 1; $sesi <= 24; $sesi++) {
                foreach ($bookings as $booking) {
                    if ($booking->date == $dates && $booking->session == $sesi) {
                        $field_schedules[$i]->sessions[$sesi - 1] = false;
                    }
                }
            }
        }
        return collect($field_schedules)->chunk(7);
        // dd(collect($field_schedules)->chunk(7));
    }
}
