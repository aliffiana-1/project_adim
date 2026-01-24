<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Contracts\Session\Session; 
use App\Models\AlumniModel;
use App\Models\FooterModel;
use App\Models\EventsModel;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function dashboard(Request $request)
    {
        $session = $request->Session()->get('logged_in');
        $id_alumni = $request->Session()->get('id_alumni');
        $alumni_name = $request->Session()->get('name');
        $admin_name = $request->Session()->get('employee_name');
        $user_role = $request->Session()->get('role');
        $data_alumni = AlumniModel::where('id_alumni', $id_alumni)->first();
        $data_footer = FooterModel::latest('footer_created_at')->first();
        $search = $request->search;
        $data_news = EventsModel::where('events_status', 1)
            ->where('events_softdel', 1)
            ->orderBy('events_inserted_at', 'desc');
        if ($search) {
            $data_news->where('events_title', 'like', '%' . $search . '%')->where('events_softdel', 1)->where('events_status', 1)
                ->orWhere('events_desc', 'like', '%' . $search . '%')->where('events_softdel', 1)->where('events_status', 1)
                ->orWhere('events_date', 'like', '%' . $search . '%')->where('events_softdel', 1)->where('events_status', 1);
        }

        return view('dashboard', [
            'title' => 'Dashboard',
            'alumni_name' => $alumni_name,
            'admin_name' => $admin_name,
            'user_role' => $user_role,
            'data_alumni' => $data_alumni,
            'data_news' => $data_news->paginate(9),
            'data_footer' => $data_footer,
            'session' => $session
        ]);
    }
}
