<?php

namespace App\Http\Controllers\admin;

use App\Models\Booking;
use App\Models\ListBooking;
use Illuminate\Http\Request;
use App\Models\RescheduleRequest;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index()
    {
        $bookings = Booking::latest()->where('status', 'pending')->get();
        $bookings = $bookings->map(function ($booking) {
            $totalPrice = $booking->listBooking->sum(function ($listBooking) {
                return $listBooking->field->price;
            });
            $booking->total_price = $totalPrice;
            return $booking;
        });

        $reschedules = RescheduleRequest::latest()->get();

        $cancelBookings = ListBooking::latest()->where('status_request', 'request-cancel')->get();

        return view('admin.index', compact('bookings', 'reschedules', 'cancelBookings'));
    }

    public function allBooking()
    {
        $listBookings = ListBooking::whereRelation('booking', 'status', 'accept')
            ->where('date', '>', now())
            ->orderBy('date', 'asc')
            ->get();

        return view('admin.booking.allBooking', compact('listBookings'));
    }

    public function approveBooking()
    {
        $bookings = Booking::latest()->where('status', 'pending')->get();
        $bookings = $bookings->map(function ($booking) {
            $totalPrice = $booking->listBooking->sum(function ($listBooking) {
                return $listBooking->field->price;
            });
            $booking->total_price = $totalPrice;
            return $booking;
        });
        return view('admin.booking.approveBooking', compact('bookings'));
    }

    public function rescheduleBooking()
    {
        $reschedules = RescheduleRequest::latest()->get();
        return view('admin.booking.rescheduleBooking', compact('reschedules'));
    }
    public function cancelBooking()
    {
        $cancelBookings = ListBooking::latest()->where('status_request', 'request-cancel')->get();
        return view('admin.booking.cancelBooking', compact('cancelBookings'));
    }

    public function getData(Request $request)
    {
        $days = $request->input('days', 7); // Default to last 7 days

        $data = Booking::selectRaw('DATE(order_date) as date, COUNT(*) as count')
                    ->where('order_date', '>=', now()->subDays($days)) // Ambil data untuk periode yang dipilih
                    ->groupBy('date')
                    ->orderBy('date', 'asc')
                    ->get();

        return response()->json($data);
    }


}
