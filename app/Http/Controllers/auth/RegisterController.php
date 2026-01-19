<?php

namespace App\Http\Controllers\auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }
    public function store(Request $request)
    {
        $user = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:user',
            'no_telp' => 'required|unique:user',
            'email' => 'email|unique:user',
            'team' => '',
            'address' => '',
            'date_of_birth' => 'date',
            'password' => 'required|confirmed'
        ]);
        
        User::create($user);
        return redirect()->route('login')->withSuccess('Register Berhasil!, Silahkan Login Terlebih Dahulu');
    }
}
