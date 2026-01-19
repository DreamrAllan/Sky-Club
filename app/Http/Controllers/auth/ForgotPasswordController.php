<?php

namespace App\Http\Controllers\auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('auth.forgot-password');
    }
    public function validateData(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        if ($user->no_telp == $request->no_telp) {
            session(['forgot_password_user_id' => $user->id]);
            return redirect()->route('setPassword.edit', $user->id)->with('success_set_password', 'Silahkan masukan password baru');
        }
        return back()->with('errorForgot', 'Username dan No Telphone yang anda masukan salah');
    }
}
