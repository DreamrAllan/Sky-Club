<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // Mengambil notifikasi yang belum dibaca
        // $notifications = Auth::user()->unreadNotifications;

        // Mengambil semua notifikasi
        $notifications = Auth::user()->notifications;

        return view('profiles.notifikasi', compact('notifications'));
    }

    public function markAsRead($id)
    {
        // Mengambil notifikasi berdasarkan id
        $notification = Auth::user()->notifications->where('id', $id)->first();

        // Menandai notifikasi sebagai sudah dibaca
        $notification->markAsRead();

        return redirect()->route('profile.show')->with(['activeTab' => 'history']);
    }
}
