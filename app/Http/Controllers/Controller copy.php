<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\AlumniModel;
use App\Models\DescriptionModel;
use App\Models\TeamsModel;
use App\Models\PartnerModel;
use App\Models\VacancyModel;
use App\Models\EventsModel;
use App\Models\TracerStudyModel;
use App\Models\FormPenggunaModel;
use App\Models\FormAlumniModel;
use App\Models\FooterModel;
use Illuminate\Http\Request;
use Illuminate\Contracts\Session\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->AlumniModel = new AlumniModel();
        $this->EventsModel = new EventsModel();
        $this->VacancyModel = new VacancyModel();
        $this->FooterModel = new FooterModel();
        $this->TeamsModel = new TeamsModel();
    }

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

    public function aboutus(Request $request)
    {
        $session = $request->Session()->get('logged_in');
        $id_alumni = $request->Session()->get('id_alumni');
        $alumni_name = $request->Session()->get('name');
        $admin_name = $request->Session()->get('employee_name');
        $user_role = $request->Session()->get('role');
        $data_alumni = AlumniModel::where('id_alumni', $id_alumni)->first();
        $data_footer = FooterModel::latest('footer_created_at')->first();
        $data_desc = DescriptionModel::latest('desc_created_at')->first();
        $data_testimonial = TeamsModel::where('teams_softdel', 1)->get();
        $data_partner = PartnerModel::all();

        return view('aboutus', [
            'title' => 'About Us',
            'alumni_name' => $alumni_name,
            'admin_name' => $admin_name,
            'user_role' => $user_role,
            'data_alumni' => $data_alumni,
            'data_footer' => $data_footer,
            'data_desc' => $data_desc,
            'data_testimonial' => $data_testimonial,
            'data_partner' => $data_partner,
            'session' => $session
        ]);
    }

    public function find_job(Request $request)
    {
        $session = $request->Session()->get('logged_in');
        $id_alumni = $request->Session()->get('id_alumni');
        $data_alumni = AlumniModel::where('id_alumni', $id_alumni)->first();
        $data = [
            'job_name' => $this->VacancyModel->get_data_job_name(),
            'city_name' => $this->VacancyModel->get_data_city_name()
        ];
        $data_footer = FooterModel::latest('footer_created_at')->first();
        $data_vacancy = VacancyModel::where('vacancy_status', 1)
            ->where('vacancy_softdel', 1)
            ->orderBy('vacancy_inserted_at', 'desc');

        $job = $request->vacancy_name_filter;
        $city = $request->vacancy_city_filter;
        $search = $request->search;
        if ($job != null && $city != null) {
            $data_vacancy->where('vacancy_position', $job)
                ->where('vacancy_city', $city);
        } elseif ($job != null && $city == null) {
            $data_vacancy->where('vacancy_position', $job);
        } elseif ($job == null && $city != null) {
            $data_vacancy->where('vacancy_city', $city);
        }

        if ($search) {
            $data_vacancy->where('vacancy_position', 'like', '%' . $search . '%')
                ->orWhere('vacancy_city', 'like', '%' . $search . '%')
                ->orWhere('company_address', 'like', '%' . $search . '%')
                ->orWhere('vacancy_company', 'like', '%' . $search . '%');
        }
        $user_role = $request->Session()->get('role');
        return view('findjob', $data, [
            'title' => 'Find Job',
            'data_alumni' => $data_alumni,
            'data_vacancy' => $data_vacancy->paginate(10),
            'user_role' => $user_role,
            'data_footer' => $data_footer,
            'session' => $session
        ]);
    }

    public function show_detail_jobs(Request $request, $id)
    {
        $id_alumni = $request->Session()->get('id_alumni');
        $data_alumni = AlumniModel::where('id_alumni', $id_alumni)->first();
        $job_detail = VacancyModel::where('tb_vacancy.id_vacancy', $id)->first();
        $user_role = $request->Session()->get('role');
        $data_footer = FooterModel::latest('footer_created_at')->first();
        $session = $request->Session()->get('logged_in');
        return view('job-details', [
            'title' => 'Detail Job',
            'job_detail' => $job_detail,
            'data_alumni' => $data_alumni,
            'user_role' => $user_role,
            'data_footer' => $data_footer,
            'session' => $session
        ]);
    }

    public function webinar(Request $request)
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
        return view('webinar', [
            'title' => 'Webinar',
            'data_events' => $data_events->paginate(9),
            'data_alumni' => $data_alumni,
            'user_role' => $user_role,
            'data_footer' => $data_footer,
            'session' => $session
        ]);
    }

    public function show_detail_webinar(Request $request, $id)
    {
        $session = $request->Session()->get('logged_in');
        $id_alumni = $request->Session()->get('id_alumni');
        $user_role = $request->Session()->get('role');
        $data_alumni = AlumniModel::where('id_alumni', $id_alumni)->first();
        $data_footer = FooterModel::latest('footer_created_at')->first();
        $webinar_detail = EventsModel::where('events_status', 1)
            ->where('events_softdel', 1)
            ->where('events_type', 2)
            ->where('id_events', $id)
            ->first();

        return view('webinar-details', [
            'title' => 'Webinar Details',
            'webinar_detail' => $webinar_detail,
            'data_alumni' => $data_alumni,
            'user_role' => $user_role,
            'data_footer' => $data_footer,
            'session' => $session
        ]);
    }

    public function news(Request $request)
    {
        $session = $request->Session()->get('logged_in');
        $id_alumni = $request->Session()->get('id_alumni');
        $data_alumni = AlumniModel::where('id_alumni', $id_alumni)->first();
        $user_role = $request->Session()->get('role');
        $search = $request->search;
        $data_footer = FooterModel::latest('footer_created_at')->first();
        $data_news = EventsModel::where('events_status', 1)
            ->where('events_type', 1)
            ->where('events_softdel', 1)
            ->orderBy('events_inserted_at', 'desc');

        if ($search) {
            $data_news->where('events_title', 'like', '%' . $search . '%')->where('events_type', 1)->where('events_softdel', 1)->where('events_status', 1)
                ->orWhere('events_desc', 'like', '%' . $search . '%')->where('events_type', 1)->where('events_softdel', 1)->where('events_status', 1)
                ->orWhere('events_date', 'like', '%' . $search . '%')->where('events_type', 1)->where('events_softdel', 1)->where('events_status', 1);
        }
        return view('news', [
            'title' => 'News',
            'data_alumni' => $data_alumni,
            'data_news' => $data_news->paginate(9),
            'user_role' => $user_role,
            'data_footer' => $data_footer,
            'session' => $session
        ]);
    }

    public function show_detail_news(Request $request, $id)
    {
        $session = $request->Session()->get('logged_in');
        $id_alumni = $request->Session()->get('id_alumni');
        $data_alumni = AlumniModel::where('id_alumni', $id_alumni)->first();
        $user_role = $request->Session()->get('role');
        $data_footer = FooterModel::latest('footer_created_at')->first();
        $news_details = EventsModel::where('events_status', 1)
            ->where('events_softdel', 1)
            ->where('events_type', 1)
            ->where('id_events', $id)
            ->first();
        return view('news-detail', [
            'title' => 'News Details',
            'user_role' => $user_role,
            'news_details' => $news_details,
            'data_alumni' => $data_alumni,
            'data_footer' => $data_footer,
            'session' => $session
        ]);
    }

    public function show_form_pengguna(Request $request, $id)
    {
        $data_footer = FooterModel::latest('footer_created_at')->first();
        $data_alumni = FormPenggunaModel::leftJoin('tb_alumni', 'tb_alumni.id_alumni', '=', 'tb_form_company.id_alumni')
            ->leftJoin('tb_form_alumni', 'tb_form_alumni.id_alumni', '=', 'tb_form_company.id_alumni')
            ->leftJoin('tb_send_email', 'tb_send_email.id_email', '=', 'tb_form_company.id_send_mail')
            ->where('tb_form_company.id_form_company', $id)->first();
        return view('form-kelulusan', [
            'title' => 'Form Pengguna',
            'data_alumni' => $data_alumni,
            'data_footer' => $data_footer
        ]);
    }

    public function store_form_kuesioner_pengguna(Request $request)
    {
        $session = $request->Session()->get('logged_in');
        $data_alumni = AlumniModel::where('id_alumni', $request->id_alumni)->first();

        $data = FormPenggunaModel::find($request->id_form_company);
        $data->id_alumni = $request->id_alumni;
        $data->respondent_name = $request->respondent_name;
        $data->respondent_email = $request->respondent_email;
        $data->respondent_position = $request->respondent_position;
        $data->respondent_company = $request->respondent_company;
        $data->student_name = $data_alumni->alumni_name;
        $data->graduate_year = $request->graduate_year;
        $data->student_position = $request->student_position;
        $data->start_work = $request->start_work;
        $data->student_attitude = $request->student_attitude;
        $data->student_skill = $request->student_skill;
        $data->student_language = $request->student_language;
        $data->student_tech_skill = $request->student_tech_skill;
        $data->student_comm_skill = $request->student_comm_skill;
        $data->student_workteam_skill = $request->student_workteam_skill;
        $data->student_self_development = $request->student_self_development;
        $data->student_readiness = $request->student_readiness;
        $data->company_wishes = $request->company_wishes;
        $data->company_suggestion = $request->company_suggestion;
        $data->form_company_softdel = 1;
        $data->form_updated_at = date('Y-m-d H:i:s');
        $simpan = $data->save();

        $update_progress = AlumniModel::find($request->id_alumni);
        $update_progress->alumni_progress = 5;
        $simpan = $update_progress->save();

        if ($simpan) {
            \Session::put('success', 'Form sent!');
            return redirect()->back();
        } else {
            \Session::put('error', 'Failed to send!');
            return redirect()->back();
        }
    }

    public function show_tracer_study(Request $request)
    {
        $id_alumni = $request->Session()->get('id_alumni');
        $user_role = $request->Session()->get('role');
        $admin_name = $request->Session()->get('employee_name');
        $session = $request->Session()->get('logged_in');
        $data_tracer = TracerStudyModel::latest('tracer_study_created_at')->first();
        $data_footer = FooterModel::latest('footer_created_at')->first();

        // $bekerja_5 = FormAlumniModel::where('f8', '1')->where('graduate_year', date('Y', strtotime('-1 year')))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();
        $bekerja_4 = FormAlumniModel::where('f8', '1')->where('graduate_year', date('Y', strtotime('-2 year')))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();
        // $bekerja_3 = FormAlumniModel::where('f8', '1')->where('graduate_year', date('Y', strtotime('-3 year')))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();
        // $bekerja_2 = FormAlumniModel::where('f8', '1')->where('graduate_year', date('Y', strtotime('-4 year')))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();
        // $bekerja_1 = FormAlumniModel::where('f8', '1')->where('graduate_year', date('Y'))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();

        // $wiraswasta_5 = FormAlumniModel::where('f8', '2')->where('graduate_year', date('Y', strtotime('-1 year')))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();
        $wiraswasta_4 = FormAlumniModel::where('f8', '2')->where('graduate_year', date('Y', strtotime('-2 year')))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();
        // $wiraswasta_3 = FormAlumniModel::where('f8', '2')->where('graduate_year', date('Y', strtotime('-3 year')))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();
        // $wiraswasta_2 = FormAlumniModel::where('f8', '2')->where('graduate_year', date('Y', strtotime('-4 year')))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();
        // $wiraswasta_1 = FormAlumniModel::where('f8', '2')->where('graduate_year', date('Y'))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();

        // $pendidikan_5 = FormAlumniModel::where('f8', '3')->where('graduate_year', date('Y', strtotime('-1 year')))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();
        $pendidikan_4 = FormAlumniModel::where('f8', '3')->where('graduate_year', date('Y', strtotime('-2 year')))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();
        // $pendidikan_3 = FormAlumniModel::where('f8', '3')->where('graduate_year', date('Y', strtotime('-3 year')))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();
        // $pendidikan_2 = FormAlumniModel::where('f8', '3')->where('graduate_year', date('Y', strtotime('-4 year')))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();
        // $pendidikan_1 = FormAlumniModel::where('f8', '3')->where('graduate_year', date('Y'))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();

        // $mencari_5 = FormAlumniModel::where('f8', '4')->where('graduate_year', date('Y', strtotime('-1 year')))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();
        $mencari_4 = FormAlumniModel::where('f8', '4')->where('graduate_year', date('Y', strtotime('-2 year')))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();
        // $mencari_3 = FormAlumniModel::where('f8', '4')->where('graduate_year', date('Y', strtotime('-3 year')))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();
        // $mencari_2 = FormAlumniModel::where('f8', '4')->where('graduate_year', date('Y', strtotime('-4 year')))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();
        // $mencari_1 = FormAlumniModel::where('f8', '4')->where('graduate_year', date('Y'))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();

        // $tidak_bekerja_5 = FormAlumniModel::where('f8', '5')->where('graduate_year', date('Y', strtotime('-1 year')))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();
        $tidak_bekerja_4 = FormAlumniModel::where('f8', '5')->where('graduate_year', date('Y', strtotime('-2 year')))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();
        // $tidak_bekerja_3 = FormAlumniModel::where('f8', '5')->where('graduate_year', date('Y', strtotime('-3 year')))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();
        // $tidak_bekerja_2 = FormAlumniModel::where('f8', '5')->where('graduate_year', date('Y', strtotime('-4 year')))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();
        // $tidak_bekerja_1 = FormAlumniModel::where('f8', '5')->where('graduate_year', date('Y'))->latest('form_inserted_at')->groupBy('id_alumni')->get()->count();

        return view('tracer-study', [
            'title' => 'Tracer Study',
            'user_role' => $user_role,
            'admin_name' => $admin_name,
            'data_footer' => $data_footer,
            'data_tracer' => $data_tracer,
            'session' => $session,
            // 'bekerja_5' => $bekerja_5 + $wiraswasta_5,
            'bekerja_4' => $bekerja_4 + $wiraswasta_4,
            // 'bekerja_3' => $bekerja_3 + $wiraswasta_3,
            // 'bekerja_2' => $bekerja_2 + $wiraswasta_2,
            // 'bekerja_1' => $bekerja_1 + $wiraswasta_1,

            // 'pendidikan_5' => $pendidikan_5,
            'pendidikan_4' => $pendidikan_4,
            // 'pendidikan_3' => $pendidikan_3,
            // 'pendidikan_2' => $pendidikan_2,
            // 'pendidikan_1' => $pendidikan_1,

            // 'mencari_5' => $mencari_5,
            'mencari_4' => $mencari_4,
            // 'mencari_3' => $mencari_3,
            // 'mencari_2' => $mencari_2,
            // 'mencari_1' => $mencari_1,

            // 'tidak_bekerja_5' => $tidak_bekerja_5,
            'tidak_bekerja_4' => $tidak_bekerja_4,
            // 'tidak_bekerja_3' => $tidak_bekerja_3,
            // 'tidak_bekerja_2' => $tidak_bekerja_2,
            // 'tidak_bekerja_1' => $tidak_bekerja_1,

        ]);
    }
}
