<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function level_editor(Request $request)
    {
        if (session('role_name') != 'admin') abort(403);

        $session = true;
        $user_role = 'admin';
        $admin_name = 'Admin';
        $search = $request->search;

        $level_data = DB::table('article_levels');

        $sortir = $request->sortir ?? 10;

        if ($search) {
            $like = '%' . $search . '%';
            $level_data->where('article_level_name', 'like', $like);
        }

        return view('level_editor', [
            'title' => 'Level',
            'user_role' => $user_role,
            'admin_name' => $admin_name,
            'session' => $session,
            'level_data' => $level_data->paginate($sortir),
        ]);
    }

    public function store_level(Request $request)
    {
        DB::table('article_levels')->insert([
            'article_level_name' => $request->article_level_name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Add level success!');
    }

    public function edit_level(Request $request)
    {
        $data = DB::table('article_levels')
            ->where('id_article_level', $request->id_article_level)
            ->first();

        if (!$data) return back()->with('error', 'Level not found!');

        DB::table('article_levels')
            ->where('id_article_level', $request->id_article_level)
            ->update([
                'article_level_name' => $request->article_level_name,
                'updated_at' => now(),
            ]);

        return back()->with('success', 'Update level success!');
    }

    public function delete_level(Request $request)
    {
        DB::table('article_levels')
            ->where('id_article_level', $request->id_article_level)
            ->delete();

        return back()->with('success', 'Delete level success!');
    }
}
