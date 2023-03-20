<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InterviewController extends Controller
{
    public function index($id)
    {
        $data = Interview::where('application_id',$id)->first();
        return view('pages.interview.index', compact('data','id'));
    }

    public function store(Request $request)
    {
        Interview::updateOrCreate(
            ['id' => $request->data_id],
            [
                'application_id' => $request->application_id,
                'interview_hr' => $request->interview_hr,
                'nama_hr' => $request->nama_hr,
                'interview_user' => $request->interview_user,
                'nama_user' => $request->nama_user,
                'interview_manajemen' => $request->interview_manajemen,
                'nama_manajemen' => $request->nama_manajemen,
            ]
        );
        return redirect(route('applications.today'));
    }
}
