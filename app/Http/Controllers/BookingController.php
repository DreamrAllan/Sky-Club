<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Field;
use App\Models\Review;
use App\Models\Booking;
use App\Models\Voucher;
use App\Models\UserInfo;
use App\Models\ListBooking;
use Illuminate\Http\Request;
use App\Events\BookingCreated;
use App\Events\PaymentUplouded;
use App\Rules\VoucherValidation;
use App\Jobs\UpdateBookingStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ApproveBooking;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AcceptBookingNotification;
use App\Notifications\RejectBookingNotification;
use Illuminate\Routing\Controller as BaseController;

class BookingController extends BaseController
// class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.payment')->except(['acceptBooking', 'rejectBooking']);
    }
    //menampilkan halaman detail Pembayaran
    public function payment(Request $request)
    {
        $booking_cart = $request->session()->get('cart', []);
        $users_offline = UserInfo::all();
        $reviews = Review::with(['user:id,name,team'])->latest()->get();
        $countRating = $reviews->count();
        $averageRating = $reviews->avg('rating');
        return view('payments.detailPembayaran', compact('booking_cart', 'users_offline', 'averageRating', 'countRating'));
    }

    // menampilkan halaman uploud bukti pembayaran
    public function paymentUploud(Request $request)
    {
        $booking_cart = $request->session()->get('cart', []);
        return view('payments.buktiPembayaran', compact('booking_cart'));
    }

    // validasi uploud bukti pembayaran
    // public function paymentUploudValidate(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|image|max:2000'
    //     ], [
    //         'file.required' => 'Foto bukti pembayaran wajib diunggah.',
    //         'file.image' => 'File yang diunggah harus berupa gambar.',
    //         'file.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.'
    //     ]);
    //     $booking_cart = $request->session()->get('cart', []);
    //     $max_payment = $booking_cart['order_date']->copy()->addMinutes(5)->setTimezone('Asia/Jakarta');
    //     if ($max_payment->greaterThan(now())) {
    //         $booking = Booking::find($booking_cart['id_booking']);
    //         $path = $request->file('file')->store('/payments', 'local');
    //         $booking->uploud_payment = $path;
    //         $booking->save();
    //         $field = Field::find(1);
    //         PaymentUplouded::dispatch($booking, $booking_cart['total']);
    //         return redirect()->route('booking.paymentSuccess');
    //     }
    //     return back()->with('timeIsOut', 'Waktu Pembayaran Telah Habis');
    // }

    public function paymentUploudValidate(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2000'
        ], [
            'photo.required' => 'Foto bukti pembayaran wajib diunggah.',
            'photo.image' => 'File yang diunggah harus berupa gambar.',
            'photo.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.'
        ]);

        $booking_cart = $request->session()->get('cart', []);
        $max_payment = $booking_cart['order_date']->copy()->addMinutes(5)->setTimezone('Asia/Jakarta');

        if ($max_payment->greaterThan(now())) {
            $booking = Booking::find($booking_cart['id_booking']);
            $path = $request->file('photo')->store('/payments', 'local');
            $booking->uploud_payment = $path;
            $booking->save();

            PaymentUplouded::dispatch($booking, $booking_cart['total']);
            return response()->json(['redirect_url' => route('booking.paymentSuccess')]);
        }

        return back()->with('timeIsOut', 'Waktu Pembayaran Telah Habis');
    }

    public function paymentSuccess(Request $request)
    {
        $request->session()->forget('cart');
        return view('payments.pembayaranBerhasil');
    }

    //menyimpan data booking & jadwalnya
    public function store(StoreBookingRequest $request)
    {
        $booking_cart = $request->session()->get('cart', []);
        $id_voucher = $booking_cart['voucher']->id ?? 0;
        $list_booking = $booking_cart['list_schedules'];
        $rented = $booking_cart['rented'];
        $order_date = $booking_cart['order_date'];
        $user_offline = $booking_cart['user_offline'] ?? null;

        if (Auth::user()->role == 'admin') {
            if (is_array($user_offline)) {
                $newUser = UserInfo::create([
                    'name' => $user_offline['name'],
                    'no_telp' => $user_offline['no_telp'],
                    'email' => $user_offline['email']
                ]);
            } else {
                $newUser = $user_offline;
            }
            if (!isset($booking_cart['id_booking'])) {
                if ($id_voucher === 0) {
                    $newBooking = Booking::create([
                        'order_date' => $order_date,
                        'status' => 'accept',
                        'rented_by' => $rented,
                        'user_info' => $newUser->id
                    ]);
                } else {
                    $newBooking = Booking::create([
                        'order_date' => $order_date,
                        'status' => 'accept',
                        'rented_by' => $rented,
                        'id_voucher' => $id_voucher,
                        'user_info' => $newUser->id
                    ]);
                }
                foreach ($list_booking as $schedule) {
                    BookingCreated::dispatch($newBooking, $schedule);
                }
                UpdateBookingStatus::dispatch($newBooking->id)->delay(now()->addMinutes(5));
                $booking_cart['id_booking'] = $newBooking->id;
                $booking_cart['order_date'] = now();
                $request->session()->put('cart', $booking_cart);
            }
            return redirect()->route('booking.paymentSuccess');
        }

        if (!isset($booking_cart['id_booking'])) {
            if ($id_voucher === 0) {
                $newBooking = Booking::create([
                    'order_date' => $order_date,
                    'status' => 'pending',
                    'rented_by' => $rented,
                ]);
            } else {
                $newBooking = Booking::create([
                    'order_date' => $order_date,
                    'status' => 'pending',
                    'rented_by' => $rented,
                    'id_voucher' => $id_voucher,
                ]);
            }
            foreach ($list_booking as $schedule) {
                BookingCreated::dispatch($newBooking, $schedule);
            }
            UpdateBookingStatus::dispatch($newBooking->id)->delay(now()->addMinutes(5));
            $booking_cart['id_booking'] = $newBooking->id;
            $booking_cart['order_date'] = now();
            $request->session()->put('cart', $booking_cart);
        }

        return redirect()->route('booking.paymentUploud');
    }
    public function acceptBooking(Booking $booking)
    {
        $booking->update(['status' => 'accept']);
        $user = User::find($booking->rented_by);
        Notification::send($user, new AcceptBookingNotification($booking));
        return back()->with('success', 'Booking berhasil diterima');
    }
    public function rejectBooking(Booking $booking)
    {
        $booking->update(['status' => 'failed']);
        $user = User::find($booking->rented_by);
        Notification::send($user, new RejectBookingNotification($booking));
        return back()->with('success', 'Booking berhasil ditolak');
    }
    public function useVoucher(Request $request)
    {
        $request->validate([
            'voucher' => 'required'
        ]);
        $voucher = Voucher::where('code', $request->voucher)->first();

        if (!$voucher) {
            return back()->with('voucher', 'Voucher tidak ditemukan.');
        }

        // Validasi tanggal kadaluarsa
        $currentDate = Carbon::now();
        $expiredDate = Carbon::parse($voucher->expired_date);

        if ($currentDate->greaterThan($expiredDate)) {
            return back()->with('voucher', 'Voucher sudah kadaluarsa.');
        }
        // dd('Voucher berhasil digunakan.');
        // Validasi kuota voucher
        if ($voucher->quota <= 0) {
            return back()->with('voucher', 'Kuota voucher sudah habis.');
        }

        // Validasi harga minimum
        $booking_cart = $request->session()->get('cart', []);
        $totalPrice = $booking_cart['total']; // Sesuaikan dengan nama input harga total di form Anda

        if ($totalPrice < $voucher->min_price) {
            return back()->with('voucher', "Voucher hanya berlaku untuk transaksi minimal Rp " . number_format($voucher->min_price, 0, ',', '.'));
        }

        // Proses selanjutnya setelah validasi berhasil
        $discountAmount = 0;
        if ($voucher->discount_percentage > 0) {
            // Hitung diskon persentase
            $discountAmount = $totalPrice * ($voucher->discount_percentage / 100);

            // Batasi maksimal diskon jika ada max_discount
            if ($voucher->max_discount > 0) {
                $discountAmount = min($discountAmount, $voucher->max_discount);
            }
        } elseif ($voucher->discount_price > 0) {
            // Diskon dalam nominal fix
            $discountAmount = $voucher->discount_price;
        }

        // Pastikan diskon tidak melebihi total harga
        $discountAmount = min($discountAmount, $totalPrice);
        $booking_cart = $request->session()->get('cart', []);
        $booking_cart['voucher'] = Voucher::where('id', $voucher->id)->first();
        $booking_cart['discount'] = $discountAmount;
        $booking_cart['fullTotal'] = $totalPrice - $discountAmount;
        $request->session()->put('cart', $booking_cart);
        return redirect()->route('booking.payment')->with('voucherSuccess', 'Voucher berhasil digunakan.');
    }
    public function userOffline(Request $request)
    {
        if ($request->has('user')) {
            $request->validate([
                'user' => 'required'
            ]);
            $booking_cart = $request->session()->get('cart', []);
            $booking_cart['user_offline'] = UserInfo::where('id', $request->user)->first();
            $request->session()->put('cart', $booking_cart);
            return redirect()->route('booking.payment')->with('userOfflineSuccess', $request->user);
        }
        $request->validate([
            'name' => 'required',
            'no_telp' => 'required',
            'email' => 'required|email',
        ]);
        $user_offline = [
            'name' => $request->name,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
        ];
        $booking_cart = $request->session()->get('cart', []);
        $booking_cart['user_offline'] = $user_offline;
        $request->session()->put('cart', $booking_cart);
        return redirect()->route('booking.payment')->with('userOfflineSuccess', 'Data user offline berhasil disimpan');
    }
}
