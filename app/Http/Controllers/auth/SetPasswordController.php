<?php

namespace App\Http\Controllers\auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class SetPasswordController extends Controller
{
    public function edit($id)
    {
        $user = User::find($id);
        return view('auth.set-password', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $password = $request->validate([
            'password' => 'required|confirmed',
        ]);
        $password['password'] = Hash::make($password['password']);
        User::where('id', $id)->update($password);
        session()->forget('forgot_password_user_id');
        return redirect()->route('login')->withSuccess('Update Password berhasil, silahkan login!');
    }
}
