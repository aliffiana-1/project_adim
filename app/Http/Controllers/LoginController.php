<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function check_user(Request $request)
    {
        $user = DB::table('users')->where('username', $request->username)->orWhere('email', $request->username)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            \Session::put('logged_in', true);
            \Session::put('id_user', $user->id_user);
            \Session::put('role', $user->role);
            return redirect('/article_editor');
        } else {
            \Session::put('error', 'Invalid username or password');
            return redirect()->back();
        }
    }
}
