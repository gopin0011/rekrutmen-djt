<?php

namespace App\Http\Controllers;

use App\Models\ApplicantAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;

class ApplicantAnswerController extends Controller
{
    public function index()
    {
        $data = ApplicantAnswer::where('user_id',Auth::user()->id)->first();
        $mustUpload = false;

        $applications = Application::groupBy('posisi', 'user_id')->select('posisi', 'user_id')->with('document','vacancy')->where('user_id', Auth::user()->id)->first();
        // dd($applications->vacancy);
        if(!$applications && !$applications->document) {
            $mustUpload = true;
        }

        if($applications->vacancy && $applications->vacancy->vacanciesAdditionalUpload) {
            foreach($applications->vacancy->vacanciesAdditionalUpload as $add) {
                $response = app()->call('\App\Http\Controllers\ApplicantDocumentController@showDataAdditional', [
                    'userId' => Auth::user()->id,
                    'vacancyId' => $add->vacancies_id,
                    'additionalUploadId' => $add->additional_upload_id,
                ]);
                if(!json_decode($response->getContent())->ApplicantAdditionalDocument) {
                    $mustUpload = true;
                    break;
                }
            }
        }
        return view('pages.applicant.answer', compact('data','mustUpload'));
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
