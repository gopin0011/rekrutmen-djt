<?php

namespace App\Http\Controllers;

use App\Models\ApplicantCareer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;
use App\Models\Application;

class ApplicantCareerController extends Controller
{
    public function index()
    {
        $dt = route('applicant_careers.data');
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
        return view('pages.applicant.career', compact('mustUpload','dt'));
    }

    public function showData(Request $request)
    {
        $data = ApplicantCareer::where('user_id', Auth::user()->id)->get();
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
        $data = ApplicantCareer::find($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        ApplicantCareer::updateOrCreate(
            ['id' => $request->data_id],
            [
                'user_id' => $request->user_id,
                'perusahaan' => $request->perusahaan,
                'alamat' => $request->alamat,
                'jabatan' => $request->jabatan,
                'masuk' => $request->masuk,
                'keluar' => $request->keluar,
                'gaji' => $request->gaji,
                'pekerjaan' => $request->pekerjaan,
                'prestasi' => $request->prestasi,
                'alasan' => $request->alasan,
            ]
        );
        return response()->json(['success' => 'Data telah berhasil disimpan']);
    }

    public function destroy($id)
    {
        ApplicantCareer::find($id)->delete();
        return response()->json(['success' => 'Data telah berhasil dihapus']);
    }

    public function convert()
    {
        try {
            $apply = ApplicantCareer::orderBy('id')->get();
            foreach($apply as $data){
                $update = ApplicantCareer::find($data->id);

                $update->perusahaan = Crypt::decryptString($data->perusahaan);
                $update->alamat = Crypt::decryptString($data->alamat);
                $update->jabatan = Crypt::decryptString($data->jabatan);
                $update->gaji = Crypt::decryptString($data->gaji);
                $update->pekerjaan = Crypt::decryptString($data->pekerjaan);
                $update->prestasi = Crypt::decryptString($data->prestasi);
                $update->alasan = Crypt::decryptString($data->alasan);


                $blnmsk = Crypt::decryptString($data->bulanmasuk);
                $update->bulanmasuk = $blnmsk;

                $thnmsk = Crypt::decryptString($data->tahunmasuk);
                $update->tahunmasuk = $thnmsk;

                $update->masuk = $blnmsk.'-'.$thnmsk;

                $blnklr = Crypt::decryptString($data->bulankeluar);
                $update->bulankeluar = $blnklr;

                $thnklr = Crypt::decryptString($data->tahunkeluar);
                $update->tahunkeluar = $thnklr;

                $update->keluar = $blnklr.'-'.$thnklr;

                $update->update();
            }
            dd('done');
        } catch (\Throwable $e) {
            dd([$update->id,$e->getMessage()]);
            dd($e->getMessage());
        }
    }
}
