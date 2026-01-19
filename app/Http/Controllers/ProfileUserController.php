<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Sparing;
use App\Models\ListBooking;
use Illuminate\Http\Request;
use App\Models\SparingRequest;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.index');
        }
        $data_user = Auth::user();
        $bookings = Booking::where('rented_by', $data_user->id)->whereIn('status', ['accept', 'pending', 'failed'])->whereRelation('listBooking', 'date', '>', now())->latest()->get();
        $sparings = Sparing::where('created_by', $data_user->id)->latest()->get();
        $id_sparings = $sparings->pluck('id');
        $request_sparing = SparingRequest::whereIn('id_sparing', $id_sparings)
            ->where('status_request', '!=', 'rejected')
            ->orWhere('id_user', $data_user->id)
            ->whereHas('sparing.listBooking', function ($query) {
                $query->where('date', '>', now());
            })
            ->latest()
            ->get();
        $bookings_to_sparing = $sparings->where('status_sparing', 'pending');
        // $history_sparing = SparingRequest::where('id_user', $data_user->id)->whereRelation('sparing', function ($query) use ($data_user) {
        //     $query->orWhere('created_by', $data_user->id)->whereRelation('listBooking', 'date', '<', Carbon::now());
        // });
        $history_sparing = SparingRequest::where(function ($query) use ($data_user) {
            $query->where('id_user', $data_user->id)
                ->orWhereHas('sparing', function ($sparingQuery) use ($data_user) {
                    $sparingQuery->where('created_by', $data_user->id)
                        ->whereHas('listBooking', function ($bookingQuery) {
                            $bookingQuery->where('date', '<', Carbon::now());
                        });
                });
        })->get();
        $history_booking_sparing = Booking::where('rented_by', $data_user->id)->where('status', 'accept')->whereRelation('listBooking', 'date', '<', Carbon::now())->latest()->get();
        // dd($history_booking_sparing);
        foreach ($history_sparing as $sparing) {
            $history_booking_sparing->push($sparing);
        }
        $history_booking_sparing->sortByDesc('created_at');
        // dd($history_booking_sparing, $data_user, $bookings, $request_sparing);
        return view('profiles.profile', compact(['data_user', 'bookings', 'sparings', 'request_sparing', 'history_booking_sparing', 'bookings_to_sparing']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->update($request->all());
        // return redirect()->route('profile.index')->with('successUpdate', 'Profile berhasil diupdate');
    }
    public function updateImage(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $user = User::find(Auth::user()->id);
        // dd($user->profile_photo);
        $path = $request->photo->store('/profile-photo', 'public');
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }
        $user->profile_photo = $path;
        $user->save();
        return response()->json([
            'photo' => Storage::url($path)
        ]);
    }
}
