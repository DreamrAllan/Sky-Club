<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Sparing;
use App\Models\ListBooking;
use App\Models\RescheduleRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\StoreListBookingRequest;
use App\Http\Requests\UpdateListBookingRequest;
use App\Notifications\AcceptRescheduleNotification;
use App\Notifications\RejectRescheduleNotification;
use App\Notifications\AcceptCancelBookingNotification;
use App\Notifications\RejectCancelBookingNotification;
use App\Notifications\NewRequestCancelBookingNotification;

class ListBookingController extends Controller
{
    public function cancel(ListBooking $list_booking)
    {
        // dd($list_booking);
        // Menghitung selisih hari antara tanggal saat ini dan tanggal booking
        $daysDifference = Carbon::now()->diffInDays(Carbon::parse($list_booking->date), false);

        // Jika selisihnya kurang dari 3 hari, tampilkan pesan kesalahan
        if ($daysDifference < 7) {
            return back()->with([
                'error' => 'Jadwal tidak dapat diubah karena kurang dari 7 hari dari sekarang.',
                'activeTab' => 'history',
                'activeBookingTab' => 'field',
            ]);
        }

        $list_booking->update([
            'status_request' => 'request-cancel'
        ]);
        $admin = User::where('role', 'admin')->get();
        Notification::send($admin, new NewRequestCancelBookingNotification($list_booking));
        return redirect()->route('profile.show', Auth::user()->id);
    }

    public function acceptReschedule(ListBooking $listBooking, RescheduleRequest $request)
    {
        ListBooking::create([
            'date' => $request->date,
            'session' => $request->session,
            'id_booking' => $listBooking->id_booking,
            'id_field' => $listBooking->id_field,
            'status_request' => 'reschedule',
        ]);
        Sparing::where('id_list_booking', $listBooking->id)->delete();
        $request->delete();
        $listBooking->delete();
        $user = User::findOrFail($listBooking->booking->rented_by);
        Notification::send($user, new AcceptRescheduleNotification($listBooking));
        return back()->with('success', 'Reschedule berhasil diterima');
    }
    public function rejectReschedule(ListBooking $listBooking, RescheduleRequest $request)
    {
        $listBooking->update([
            'status_request' => null,
        ]);
        $request->delete();
        $user = User::find($listBooking->booking->rented_by);
        Notification::send($user, new RejectRescheduleNotification($listBooking));
        return back()->with('success', 'Reschedule berhasil ditolak');
    }
    public function acceptCancelBooking(ListBooking $listBooking)
    {
        $listBooking->update([
            'status_request' => 'cancel',
        ]);
        // $booking = $listBooking->booking;
        // $booking->update([
        //     'status' => 'canceled',
        // ]);
        $user = User::find($listBooking->booking->rented_by);
        Notification::send($user, new AcceptCancelBookingNotification($listBooking));
        return back()->with('success', 'Pembatalan booking berhasil diterima');
    }
    public function rejectCancelBooking(ListBooking $listBooking)
    {
        $listBooking->update([
            'status_request' => null,
        ]);
        $user = User::find($listBooking->booking->rented_by);
        Notification::send($user, new RejectCancelBookingNotification($listBooking));
        return back()->with('success', 'Pembatalan booking berhasil ditolak');
    }
}
