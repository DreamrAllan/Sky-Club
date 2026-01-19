<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sparing;
use Illuminate\Http\Request;
use App\Events\SparingCreated;
use App\Events\SparingRequestAccepted;
use App\Models\SparingRequest;
use Illuminate\Support\Facades\Auth;
use App\Events\SparingRequestCreated;
use App\Events\SparingRequestRejected;
use Illuminate\Routing\Controller;

class SparingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }
    public function index()
    {
        $sparings = Sparing::latest()->where('status_sparing', '!=', 'done')->get();
        return view('bookings.sparing', compact('sparings'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'team_name' => 'required',
            'description' => '',
            'id_list_booking' => 'unique:sparings,id_list_booking'
        ]);
        $sparing = Sparing::create([
            'created_by' => Auth::user()->id,
            'description' => $request->description,
            'id_list_booking' => $request->id_list_booking,
            'status_sparing' => 'pending'
        ]);
        $user = User::find(Auth::user()->id);
        $user->team = $request->team_name;
        $user->save();
        SparingCreated::dispatch($user, $sparing);
        return redirect()->route('sparing.index');
    }

    public function addRequest(Sparing $sparing)
    {
        $user = Auth::user();
        $isRequest = SparingRequest::where('id_sparing', $sparing->id)->where('id_user', $user->id)->exists();
        // $isRequest = $request;
        // dd($isRequest);
        if ($user->team == null) {
            return back()->with('sparingFailed', 'Kamu Belum Mempunyai Team Silahkan Tambahkan Nama Team di Profile');
        } elseif ($sparing->createdBy->id == $user->id) {
            return back()->with('sparingFailed', 'Kamu Tidak Bisa Mengajukan Sparing Milik Sendiri');
        } elseif ($isRequest) {
            return redirect()->route('sparing.index')->with('sparingFailed', 'Kamu Sudah Pernah Mengajukan Sparing Ini');
        }
        $sparing_request = SparingRequest::create([
            'id_sparing' => $sparing->id,
            'id_user' => Auth::user()->id,
            'status_request' => 'waiting'
        ]);
        SparingRequestCreated::dispatch($sparing, $sparing_request);
        return redirect()->route('profile.show', Auth::user()->id);
    }

    public function acceptRequest(SparingRequest $sparing_req)
    {
        $sparing_req->update([
            'status_request' => 'accepted'
        ]);
        SparingRequest::where('id_sparing', $sparing_req->id_sparing)->where('id', '!=', $sparing_req->id)->update([
            'status_request' => 'rejected'
        ]);
        Sparing::where('id', $sparing_req->id_sparing)->update([
            'status_sparing' => 'done'
        ]);
        SparingRequestAccepted::dispatch($sparing_req);
        return back()->with(['activeTab' => 'history', 'activeBookingTab' => 'sparing']);
    }

    public function rejectRequest(SparingRequest $sparing_req)
    {
        // dd($sparing_req);
        $sparing_req->update([
            'status_request' => 'rejected'
        ]);
        SparingRequestRejected::dispatch($sparing_req);
        return back()->with(['activeTab' => 'history', 'activeBookingTab' => 'sparing']);
    }
}
