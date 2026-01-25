<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Models\ArticlesModel;
use App\Models\EventsModel;
use App\Models\FooterModel;
use Illuminate\Http\Request;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Str;

class AuthorController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->ArticlesModel = new ArticlesModel();
    }

    public function article(Request $request)
    {
        $session = $request->Session()->get('logged_in');
        $id_alumni = $request->Session()->get('id_alumni');
        $user_role = $request->Session()->get('role');
        $id_alumni = $request->Session()->get('id_alumni');
        $search = $request->search;
        $data_articles = ArticlesModel::where('is_published', 1)
            ->select('articles.*', 'categories.category_name', 'article_levels.article_level_name', 'articles.created_at as article_created_at')
            ->join('categories', 'articles.id_category', '=', 'categories.id_category')
            ->join('article_levels', 'articles.id_article_level', '=', 'article_levels.id_article_level')
            ->orderBy('articles.id_article_level', 'asc')
            ->orderBy('articles.created_at', 'desc');

        if ($search) {
            $data_articles->where('title', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%')
                ->orWhere('published_at', 'like', '%' . $search . '%');
        }
        return view('article', [
            'title' => 'Article',
            'data_articles' => $data_articles->paginate(9),
            'user_role' => $user_role,
            'session' => $session
        ]);
    }

    //events news
    public function article_editor(Request $request)
    {
        // if ($request->Session()->get('logged_in') == true && $request->Session()->get('role') == "admin") {
        $session = true; // Skip login for testing
        $user_role = 'admin'; // Set role to admin
        $admin_name = 'Admin'; // Default name
        // $data_footer = FooterModel::latest('footer_created_at')->first();
        $search = $request->search;
        $article_data = DB::table('articles')
            ->join('categories', 'articles.id_category', '=', 'categories.id_category')
            ->join('article_levels', 'articles.id_article_level', '=', 'article_levels.id_article_level')
            ->select('articles.*', 'categories.category_name', 'article_levels.article_level_name')
            ->orderBy('articles.created_at', 'desc');

        $sortir = 10;

        if ($request->sortir) {
            $sortir = $request->sortir;
        }

        if ($search) {
            $like = '%' . $search . '%';
            $article_data->where(function ($q) use ($like) {
                $q->where('articles.title', 'like', $like)
                    ->orWhere('categories.category_name', 'like', $like)
                    ->orWhere('articles.content', 'like', $like);
            });

            $article_data->orderByRaw(
                "CASE WHEN articles.title LIKE ? THEN 0 WHEN categories.category_name LIKE ? THEN 1 WHEN articles.content LIKE ? THEN 2 ELSE 3 END",
                [$like, $like, $like]
            )->orderBy('articles.created_at', 'desc');
        }
        return view('article_editor', [
            'title' => 'Article Center',
            'user_role' => $user_role,
            'admin_name' => $admin_name,
            'article_data' => $article_data->paginate($sortir),
            'session' => $session,
            'categories' => DB::table('categories')->get(),
            'levels' => DB::table('article_levels')->get(),
        ]);
        // } else {
        //     return redirect('/');
        // }
    }

    public function store_article(Request $request)
    {
        $data = new ArticlesModel();
        $data->id_user = 1; // Assuming a default user ID, adjust as needed
        $data->id_category = $request->id_category;
        $data->id_article_level = $request->id_article_level;
        $data->title = $request->title;
        $data->content = $request->content;
        $data->is_published = $request->is_published;
        $data->slug = Str::slug($request->title);
        $data->published_at = $request->is_published == 1 ? now() : null;
        $data->created_at = now();
        $data->updated_at = now();

        $data->save();
        if ($data) {
            \Session::put('success', 'Add article Success!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Add article failed!');
            return redirect()->back();
        }
    }

    public function edit_article(Request $request){
        $data = ArticlesModel::find($request->id_article);

        if (!$data) {
            \Session::put('error', 'Article not found!');
            return redirect()->back();
        }

        $data->title = $request->title;
        $data->content = $request->content;
        $data->id_category = $request->id_category;
        $data->id_article_level = $request->id_article_level;
        $data->is_published = $request->is_published;
        $data->slug = \Str::slug($request->title);
        if ($request->is_published == 1 && empty($data->published_at)) {
            $data->published_at = now();
        }

        $data->updated_at = now();

        if ($data->save()) {
            \Session::put('success', 'Update article success!');
        } else {
            \Session::put('error', 'Update article failed!');
        }

        return redirect()->back();
    }

    public function delete_article(Request $request){
        $data = ArticlesModel::find($request->id_article);

        if (!$data) {
            \Session::put('error', 'Article not found!');
            return redirect()->back();
        }

        if ($data->delete()) {
            \Session::put('success', 'Delete article success!');
        } else {
            \Session::put('error', 'Delete article failed!');
        }

        return redirect()->back();
    }

    public function show_detail_article(Request $request, $id)
    {
        $article_detail = ArticlesModel::where('is_published', 1)
            ->join('categories', 'articles.id_category', '=', 'categories.id_category')
            ->join('article_levels', 'articles.id_article_level', '=', 'article_levels.id_article_level')
            ->select('articles.*', 'categories.category_name', 'article_levels.article_level_name')
            ->where('id_article', $id)
            ->first();

        return view('article_details', [
            'title' => 'Article Details',
            'article_detail' => $article_detail,
        ]);
    }
}
