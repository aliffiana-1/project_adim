<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Models\AlumniModel;
use App\Models\TeamsModel;
use App\Models\VacancyModel;
use App\Models\EventsModel;
use App\Models\TracerStudyModel;
use App\Models\FormPenggunaModel;
use App\Models\FormAlumniModel;
use App\Models\FooterModel;
use Illuminate\Http\Request;
use Illuminate\Contracts\Session\Session;

class AuthorController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->AlumniModel = new AlumniModel();
        $this->EventsModel = new EventsModel();
        // $this->VacancyModel = new VacancyModel();
        $this->FooterModel = new FooterModel();
        // $this->TeamsModel = new TeamsModel();
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
            $article_data = DB::table('articles') ->join('categories', 'articles.id_category', '=', 'categories.id_category')->select('articles.*', 'categories.category_name')->orderBy('articles.created_at', 'desc');

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
            ]);
        // } else {
        //     return redirect('/');
        // }
    }

}
