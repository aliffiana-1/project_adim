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
        $data_alumni = AlumniModel::where('id_alumni', $id_alumni)->first();
        $data_footer = FooterModel::latest('footer_created_at')->first();
        $search = $request->search;
        $data_events = EventsModel::where('events_status', 1)
            ->where('events_softdel', 1)
            ->where('events_type', 2)
            ->orderBy('events_inserted_at', 'desc');

        if ($search) {
            $data_events->where('events_type', 2)->where('events_title', 'like', '%' . $search . '%')->where('events_softdel', 1)->where('events_status', 1)
                ->orWhere('events_desc', 'like', '%' . $search . '%')->where('events_type', 2)->where('events_softdel', 1)->where('events_status', 1)
                ->orWhere('events_date', 'like', '%' . $search . '%')->where('events_type', 2)->where('events_softdel', 1)->where('events_status', 1);
        }
        return view('article', [
            'title' => 'Article',
            'data_events' => $data_events->paginate(9),
            'data_alumni' => $data_alumni,
            'user_role' => $user_role,
            'data_footer' => $data_footer,
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
                    [$like, $like, $like])->orderBy('articles.created_at', 'desc');
            }
            return view('article_editor', [
                'title' => 'Article Center',
                'user_role' => $user_role,
                'admin_name' => $admin_name,
                'article_data' => $article_data->paginate($sortir),
                // 'data_footer' => $data_footer,
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
        $data = new ArticleModel();
        // $data->id_employee = $request->Session()->get('id_employee');
        $data->events_title = $request->events_title;
        $data->events_type = $request->events_type;
        $data->events_date = $request->events_date;
        $data->events_desc = $request->events_desc;
        
        $data->events_status = $request->events_status;
        $data->events_softdel = 1;
        $data->events_inserted_at = date('Y-m-d H:i:s');
        $data->events_updated_at = date('Y-m-d H:i:s');

        // if ($validator->fails()) {
        //     \Session::put('error', 'Company name is required!');
        //     return redirect()->back();
        // } else {

        $data->save();
        if ($data) {
            \Session::put('success', 'Add events Success!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Add events failed!');
            return redirect()->back();
        }
        // }
    }

    public function edit_article(Request $request)
{
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


}
