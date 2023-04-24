<?php

namespace App\Http\Controllers;

use App\Models\MonthlyCounter;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Models\NotificationsReschedule;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $countAlper = count(Staff::where([['corp', '1'], ['resign', ''], ['status', '<>', '2']])->get());
        $countLegano = count(Staff::where([['corp', '2'], ['resign', ''], ['status', '<>', '2']])->get());
        // $countTlhAlper = count(Staff::where([['corp', '1'], ['resign', ''], ['status', '2']])->get());
        // $countTlhLegano = count(Staff::where([['corp', '2'], ['resign', ''], ['status', '2']])->get());

        // $countAlper = count(Staff::where([['corp', '1'], ['resign', '']])->get());
        // $countLegano = count(Staff::where([['corp', '2'], ['resign', '']])->get());

        $year = now()->format('Y');
        $monthlyAlper = MonthlyCounter::where([['month','like', $year . '%'],['corp','1']])->get('amount');
        $monthlyLegano = MonthlyCounter::where([['month','like', $year . '%'],['corp','2']])->get('amount');

        $buffAlper = '';
        $buffLegano = '';
        $bulan = now()->format('m');
        for ($i = 0; $i < $bulan ; $i++)
        {
            if($buffAlper == '')
            {
                $buffAlper = $monthlyAlper[$i]['amount'];
                $buffLegano = $monthlyLegano[$i]['amount'];
            }else{
                $buffAlper = $buffAlper .','. $monthlyAlper[$i]['amount'];
                $buffLegano = $buffLegano .','. $monthlyLegano[$i]['amount'];
            }
        }

        // dd($reschedule[0]->applications->user);

        return view('home', compact('countAlper', 'countLegano', 'monthlyAlper', 'monthlyLegano', 'buffAlper', 'buffLegano'));
    }

    
}
