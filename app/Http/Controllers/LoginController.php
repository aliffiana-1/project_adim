<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function register()
    {
        return view('register');
    }

    public function register_store(Request $request)
    {
        app(UserController::class)->store_user($request, 'register');
        return redirect()->route('login')->with('success', 'Success!');
    }

    public function login()
    {
        return view('login');
    }

    public function check_user(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = DB::table('users')
            ->where('email', $request->username)
            ->orWhere('name', $request->username)
            ->first();

        if (!$user) {
            return back()->with('error', 'User not found!');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password is incorrect!');
        }

        $role = DB::table('roles')->where('id_role', $user->id_role)->first();

        Session::put('role_name', strtolower($role->role_name));
        Session::put('id_user', $user->id_user);
        Session::put('name', $user->name);
        Session::put('full_name', $user->full_name);
        Session::put('email', $user->email);
        Session::put('id_role', $user->id_role);
        Session::put('is_login', true);

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }
}
