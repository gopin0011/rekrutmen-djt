<?php

namespace App\Http\Controllers;

use App\Models\ApplicantReference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;
use App\Models\Application;

class ApplicantReferenceController extends Controller
{
    public function index()
    {
        $dt = route('applicant_references.data');
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
        return view('pages.applicant.reference',compact('dt','mustUpload'));
    }

    public function showData(Request $request)
    {
        $data = ApplicantReference::where('user_id', Auth::user()->id)->get();
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
        $data = ApplicantReference::find($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        ApplicantReference::updateOrCreate(
            ['id' => $request->data_id],
            [
                'user_id' => $request->user_id,
                'nama' => $request->nama,
                'perusahaan' => $request->perusahaan,
                'jabatan' => $request->jabatan,
                'kontak' => $request->kontak,
            ]
        );
        return response()->json(['success' => 'Data telah berhasil disimpan']);
    }

    public function destroy($id)
    {
        ApplicantReference::find($id)->delete();
        return response()->json(['success' => 'Data telah berhasil dihapus']);
    }

    public function convert()
    {
        try {
            $apply = ApplicantReference::orderBy('id')->get();
            foreach($apply as $data){

                $update = ApplicantReference::find($data->id);

                $update->nama = Crypt::decryptString($data->nama);
                $update->perusahaan = Crypt::decryptString($data->perusahaan);
                $update->jabatan = Crypt::decryptString($data->jabatan);
                $update->kontak = Crypt::decryptString($data->kontak);

                $update->update();
            }
            dd('done');
        } catch (\Throwable $e) {
            dd([$update->id,$e->getMessage()]);
            dd($e->getMessage());
        }
    }
}
