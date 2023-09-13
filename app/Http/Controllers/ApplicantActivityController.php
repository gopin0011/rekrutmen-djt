<?php

namespace App\Http\Controllers;

use App\Models\ApplicantActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Models\Application;

class ApplicantActivityController extends Controller
{
    public function index()
    {
        $dt = route('applicant_activities.data');
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
        return view('pages.applicant.activity', compact('dt','mustUpload'));
    }

    public function showData(Request $request)
    {
        $data = ApplicantActivity::where('user_id', Auth::user()->id)->get();
        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editData"><i class="fa fa-edit"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            return $allData;
        }
    }

    public function edit($id)
    {
        $data = ApplicantActivity::find($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        ApplicantActivity::updateOrCreate(
            ['id' => $request->data_id],
            [
                'user_id' => $request->user_id,
                'kegiatan' => $request->kegiatan,
                'tahun' => $request->tahun,
                'jabatan' => $request->jabatan,
                'catatan' => $request->catatan,
            ]
        );
        return response()->json(['success' => 'Data telah berhasil disimpan']);
    }

    public function destroy($id)
    {
        ApplicantActivity::find($id)->delete();
        return response()->json(['success' => 'Data telah berhasil dihapus']);
    }
}
