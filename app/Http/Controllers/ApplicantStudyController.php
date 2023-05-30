<?php

namespace App\Http\Controllers;

use App\Models\ApplicantStudy;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;

class ApplicantStudyController extends Controller
{
    public function index()
    {
        $dt = route('applicant_studies.data');
        $study = DB::table('studygrade')->get();
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
        return view('pages.applicant.study', compact('mustUpload','study','dt'));
    }

    public function showData(Request $request)
    {
        $data = ApplicantStudy::where('user_id', Auth::user()->id)->get();
        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tingkat', function ($row) {
                    $id = $row->tingkat;
                    $study = DB::table('studygrade')->where('id', $id)->first();
                    return $study->name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editData"><i class="fa fa-edit"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action','tingkat'])
                ->make(true);
            return $allData;
        }
    }

    public function edit($id)
    {
        $data = ApplicantStudy::find($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        ApplicantStudy::updateOrCreate(
            ['id' => $request->data_id],
            [
                'user_id' => $request->user_id,
                'tingkat' => $request->tingkat,
                'sekolah' => $request->sekolah,
                'kota' => $request->kota,
                'jurusan' => $request->jurusan,
                'masuk' => $request->masuk,
                'keluar' => $request->keluar,
            ]
        );
        return response()->json(['success' => 'Data telah berhasil disimpan']);
    }

    public function destroy($id)
    {
        ApplicantStudy::find($id)->delete();
        return response()->json(['success' => 'Data telah berhasil dihapus']);
    }

    public function convert()
    {
        try {
            $apply = ApplicantStudy::orderBy('id')->get();
            foreach($apply as $data){
                $update = ApplicantStudy::find($data->id);

                // $update->tingkat = Crypt::decryptString($data->tingkat);
                // $update->kota = Crypt::decryptString($data->kota);
                // $update->masuk = Crypt::decryptString($data->masuk);
                // $update->keluar = Crypt::decryptString($data->keluar);

                // $nama = Crypt::decryptString($data->nama);
                // $update->nama = $nama;
                // $update->sekolah = $nama;

                // $jur = Crypt::decryptString($data->jurfak);
                // $update->jurfak = $jur;
                // $update->jurusan = $jur;
                switch($data->tingkat_char){
                    case 'SD' : $pendidikan = 'SD'; $study = 9; break;
                    case 'SMP' : $pendidikan = 'SMP'; $study = 1; break;
                    case 'SMA' : $pendidikan = 'SMA'; $study = 2; break;
                    case 'D1' : $pendidikan = 'D1'; $study = 3; break;
                    case 'D3' : $pendidikan = 'D3'; $study = 4; break;
                    case 'D4' : $pendidikan = 'D4'; $study = 5; break;
                    case 'S1' : $pendidikan = 'S1'; $study = 6; break;
                    case 'S2' : $pendidikan = 'S2'; $study = 7; break;
                    case 'S3' : $pendidikan = 'S3'; $study = 8; break;
                }
                $update->tingkat = $study;

                $update->update();
            }
            dd('done');
        } catch (\Throwable $e) {
            dd([$update->id,$e->getMessage()]);
            dd($e->getMessage());
        }
    }
}
