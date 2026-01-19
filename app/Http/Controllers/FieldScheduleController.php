<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Field;
use App\Models\Photo;
use App\Models\Review;
use App\Models\ListBooking;
use Illuminate\Http\Request;
use App\Models\RescheduleRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\schedule\GenerateSchedule;
use Illuminate\Routing\Controller as BaseController;
use App\Notifications\NewRequestRescheduleNotification;



// Class untuk men-generate jadwal 2 bulan kedepan
class FieldScheduleController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }
    public function index()
    {
        $fieldPhotos = Photo::all()->pluck('photo')->map(function ($photo) {
            return asset('storage/field/images/' . $photo);
        });

        $field = Field::findOrFail(1);
        $fieldDescription = $field->description;
        $fieldFasility = $field->facility->pluck('name')->toArray();
        $selectedFacilities = $fieldFasility;

        $slicedFacilities = $fieldFasility;

        // Ambil hanya 4 fasilitas
        $selectedSliceFacilities = array_slice($slicedFacilities, 3, 4);

        $generateSchedules = new GenerateSchedule(2);
        $schedules = $generateSchedules->createSchedule();
        $reviews = Review::with(['user:id,name,team,profile_photo'])->latest()->get();
        $countRating = $reviews->count();
        $averageRating = $reviews->avg('rating');

        return view('bookings.detailSewa', compact('schedules', 'generateSchedules', 'fieldPhotos', 'fieldDescription', 'selectedFacilities', 'selectedSliceFacilities', 'reviews', 'countRating', 'averageRating', 'fieldPhotos', 'field'));
    }
    public function scheduleValidate(Request $request)
    {

        $booking_cart = [];
        $total = 0;
        $booked = ListBooking::whereRelation('booking', function ($query) {
            $query
                ->whereIn('status', ['accept', 'pending']);
        })->get();
        for ($i = 0; $i < count($request->schedule); $i++) {
            $total += $this->getReqPrice($request, $i);
            $booking_cart['list_schedules'][$i] = ['date' => $this->getReqDate($request, $i), 'session' => $this->getReqSession($request, $i), 'price' => $this->getReqPrice($request, $i)];
            foreach ($booked as $booking) {
                if ($booking->date == $this->getReqDate($request, $i) && $booking->session == $this->getReqSession($request, $i)) {
                    return back()->with('error_booking', 'Sesi Jadwal Sudah Di Pesan');
                }
            }
        }
        $booking_cart['total'] = $total;
        $booking_cart['discount'] = 0;
        $booking_cart['order_date'] = now();
        $booking_cart['rented'] = Auth::user()->id;
        $booking_cart['field'] = Field::find(1);
        $booking_cart['fullTotal'] = $total;
        $booking_cart = collect($booking_cart);
        $request->session()->put('cart', $booking_cart);
        return redirect()->route('booking.payment');
    }
    public function reschedule(ListBooking $list_booking)
    {
        // Menghitung selisih hari antara tanggal saat ini dan tanggal booking
        $daysDifference = Carbon::now()->diffInDays(Carbon::parse($list_booking->date), false);

        // Jika selisihnya kurang dari 3 hari, tampilkan pesan kesalahan
        if ($daysDifference < 3) {
            return back()->with([
                'error' => 'Jadwal tidak dapat diubah karena kurang dari 3 hari dari sekarang.',
                'activeTab' => 'history',
                'activeBookingTab' => 'field',
            ]);
        }
        // Jika selisihnya 3 hari atau lebih, tampilkan halaman ubah jadwal
        $fieldPhotos = Photo::all()->pluck('photo')->map(function ($photo) {
            return asset('storage/field/images/' . $photo);
        });

        $field = Field::findOrFail(1);
        $fieldDescription = $field->description;
        $fieldFasility = $field->facility->pluck('name')->toArray();
        $selectedFacilities = $fieldFasility;

        $slicedFacilities = $fieldFasility;

        // Ambil hanya 4 fasilitas
        $selectedSliceFacilities = array_slice($slicedFacilities, 3, 4);

        $generateSchedules = new GenerateSchedule(2);
        $schedules = $generateSchedules->createSchedule();
        $reviews = Review::with(['user:id,name,team,profile_photo'])->latest()->get();
        $countRating = $reviews->count();
        $averageRating = $reviews->avg('rating');

        return view('bookings.ubahJadwal', compact('schedules', 'generateSchedules', 'fieldPhotos', 'fieldDescription', 'selectedFacilities', 'selectedSliceFacilities', 'reviews', 'countRating', 'averageRating', 'fieldPhotos', 'field', 'list_booking'));
    }
    public function rescheduleValidate(Request $request, ListBooking $list_booking)
    {
        $list_booking->update([
            'status_request' => 'request-reschedule'
        ]);
        RescheduleRequest::create([
            'id_list_booking' => $list_booking->id,
            'date' => $this->getReqDate($request, 0),
            'session' => $this->getReqSession($request, 0),
            'price' => $this->getReqPrice($request, 0),
        ]);
        $admin = User::where('role', 'admin')->get();
        Notification::send($admin, new NewRequestRescheduleNotification($list_booking));
        return redirect()->route('profile.show');
    }
    protected function getReqSession($request, $i)
    {
        return (int)substr($request->session[$i], 0, 2) + 1;
    }
    protected function getReqPrice($request, $i)
    {
        return (int)str_replace(['Rp', '.', ','], ['', '', ''], $request->price[$i]);
    }
    protected function getReqDate($request, $i)
    {
        return Carbon::parse($request->schedule[$i]);
    }
}
