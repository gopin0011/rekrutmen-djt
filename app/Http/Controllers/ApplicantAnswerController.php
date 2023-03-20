<?php

namespace App\Http\Controllers;

use App\Models\ApplicantAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicantAnswerController extends Controller
{
    public function index()
    {
        $data = ApplicantAnswer::where('user_id',Auth::user()->id)->first();
        return view('pages.applicant.answer', compact('data'));
    }

    public function store(Request $request)
    {

        ApplicantAnswer::updateOrCreate(
            ['id' => $request->data_id],
            [
                'user_id' => $request->user_id,
                'alasan' => $request->alasan,
                'bidang' => $request->bidang,
                'rencana' => $request->rencana,
                'prestasi' => $request->prestasi,
                'lamaran' => $request->lamaran,
                'deskripsi' => $request->deskripsi,
            ]
        );
        return redirect(route('applicant_answers.index'));
    }
}
