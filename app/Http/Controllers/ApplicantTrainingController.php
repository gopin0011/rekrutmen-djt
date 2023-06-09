<?php

namespace App\Http\Controllers;

use App\Models\ApplicantTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;
use App\Models\Application;

class ApplicantTrainingController extends Controller
{
    public function index()
    {
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
        return view('pages.applicant.training', ['mustUpload' => $mustUpload]);
    }

    public function showData(Request $request)
    {
        $data = ApplicantTraining::where('user_id', Auth::user()->id)->get();
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
        $data = ApplicantTraining::find($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        ApplicantTraining::updateOrCreate(
            ['id' => $request->data_id],
            [
                'user_id' => $request->user_id,
                'kursus' => $request->kursus,
                'tahun' => $request->tahun,
                'durasi' => $request->durasi,
                'ijazah' => $request->ijazah,
                'biaya' => $request->biaya,
            ]
        );
        return response()->json(['success' => 'Data telah berhasil disimpan']);
    }

    public function destroy($id)
    {
        ApplicantTraining::find($id)->delete();
        return response()->json(['success' => 'Data telah berhasil dihapus']);
    }

    public function convert()
    {
        try {
            $apply = ApplicantTraining::orderBy('id')->get();
            foreach($apply as $data){
                $update = ApplicantTraining::find($data->id);

                $update->kursus = Crypt::decryptString($data->kursus);
                $update->tahun = Crypt::decryptString($data->tahun);
                $update->durasi = Crypt::decryptString($data->durasi);
                $update->ijazah = Crypt::decryptString($data->ijazah);
                $update->biaya = Crypt::decryptString($data->biaya);

                $update->update();
            }
            dd('done');
        } catch (\Throwable $e) {
            dd([$update->id,$e->getMessage()]);
            dd($e->getMessage());
        }
    }
}
