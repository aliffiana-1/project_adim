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
        

        return view('dashboard', [
            'title' => 'Dashboard',
            
        ]);
    }
}
