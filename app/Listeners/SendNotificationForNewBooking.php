<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\PaymentUplouded;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ApproveBooking;
use App\Notifications\NewBookingAdminNotification;
use App\Notifications\NewBookingUserNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendNotificationForNewBooking implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PaymentUplouded $event): void
    {
        DB::table('jobs')
            ->where('available_at', '>', now())
            ->where('payload', 'LIKE', '%UpdateBookingStatus%')
            ->delete();
        $admins = User::where('role', 'admin')->get();
        $user = User::where('id', $event->booking->rentedBy->id)->first();
        Notification::send($admins, new NewBookingAdminNotification($event->booking, $event->total));
        Notification::send($user, new NewBookingUserNotification($event->booking, $event->total));
    }
}
