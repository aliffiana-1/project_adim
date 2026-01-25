<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
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
            $data_footer = FooterModel::latest('footer_created_at')->first();
            $search = $request->search;
            $events_data = EventsModel::where('events_softdel', 1)->orderBy('events_inserted_at', 'desc');
            $sortir = 10;

            if ($request->sortir) {
                $sortir = $request->sortir;
            }

            if ($search) {
                $events_data->where('events_title', 'like', '%' . $search . '%')->where('events_softdel', 1)
                    ->orWhere('events_desc', 'like', '%' . $search . '%')->where('events_softdel', 1)
                    ->orWhere('events_inserted_at', 'like', '%' . $search . '%')->where('events_softdel', 1);

                if ($search == 'Webinar' || $search == 'webinar') {
                    $events_data->orWhere('events_type', 2)->where('events_softdel', 1);
                } elseif ($search == 'News' || $search == 'news') {
                    $events_data->orWhere('events_type', 1)->where('events_softdel', 1);
                }
            }

            return view('article_editor', [
                'title' => 'Article Center',
                'user_role' => $user_role,
                'admin_name' => $admin_name,
                'events_data' => $events_data->paginate($sortir),
                'data_footer' => $data_footer,
                'session' => $session,
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
        $data = ArticleModel::find($request->id_article);
        // $data->id_employee = $request->Session()->get('id_employee');
        $data->events_title = $request->events_title;
        $data->events_desc = $request->events_desc;
        $data->events_status = $request->events_status;
        $data->events_type = $request->events_type;
        if ($request->hasFile('events_img')) {
            if ($data->events_img != null) {
                unlink(public_path('events/' . $data->events_img));
            }
            $destination_path = 'events/';
            $file_name = date('ymd') . '_';
            $image = $request->file('events_img');
            $name = $file_name . rand(1000, 9999) . $image->getClientOriginalName();
            $image->move($destination_path, $name);
            $data->events_img = $name;
        }
        $data->events_updated_at = date('Y-m-d H:i:s');
        $data->save();
        if ($data) {
            \Session::put('success', 'Update evenst Success');
            return redirect()->back();
        } else {
            \Session::put('error', 'Update events failed!');
            return redirect()->back();
        }
    }

}
