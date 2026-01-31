<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function user_editor(Request $request)
    {
        if (session('role_name') != 'admin') abort(403);
        
        $session = true;
        $user_role = 'admin';
        $admin_name = 'Admin';
        $search = $request->search;

        $user_data = DB::table('users')
            ->join('roles', 'users.id_role', '=', 'roles.id_role')
            ->select('users.*', 'roles.role_name');

        $sortir = $request->sortir ?? 10;

        if ($search) {
            $like = '%' . $search . '%';
            $user_data->where(function ($q) use ($like) {
                $q->where('users.name', 'like', $like)
                    ->orWhere('users.email', 'like', $like)
                    ->orWhere('users.full_name', 'like', $like)
                    ->orWhere('users.nip', 'like', $like)
                    ->orWhere('roles.role_name', 'like', $like);
            });
        }

        return view('user_editor', [
            'title' => 'User',
            'session' => $session,
            'user_role' => $user_role,
            'admin_name' => $admin_name,
            'user_data' => $user_data->paginate($sortir),
            'roles' => DB::table('roles')->get()
        ]);
    }

    public function store_user(Request $request, $from = 'admin')
    {
        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'id_role' => $from == 'register' ? 2 : $request->id_role, // 2 = penulis
            'password' => Hash::make($request->password),
            'full_name' => $request->full_name,
            'nip' => $request->nip,
        ]);

        return back()->with('success', 'Add user success!');
    }

    public function edit_user(Request $request)
    {
        $data = DB::table('users')->where('id_user', $request->id_user)->first();
        if (!$data) return back()->with('error', 'User not found!');

        $update = [
            'name' => $request->name,
            'email' => $request->email,
            'id_role' => $request->id_role,
            'full_name' => $request->full_name,
            'nip' => $request->nip,
        ];

        if ($request->password) {
            $update['password'] = Hash::make($request->password);
        }

        DB::table('users')->where('id_user', $request->id_user)->update($update);
        return back()->with('success', 'Update user success!');
    }

    public function delete_user(Request $request)
    {
        DB::table('users')->where('id_user', $request->id_user)->delete();
        return back()->with('success', 'Delete user success!');
    }
}
