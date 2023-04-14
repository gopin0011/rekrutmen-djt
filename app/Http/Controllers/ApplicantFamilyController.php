<?php

namespace App\Http\Controllers;

use App\Models\ApplicantFamily;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;

class ApplicantFamilyController extends Controller
{
    public function index()
    {
        $dt = route('applicant_families.data');
        $genders = DB::table('gender')->get();
        $study = DB::table('studygrade')->get();
        return view('pages.applicant.family', compact('genders','study','dt'));
    }

    public function showData(Request $request)
    {
        $data = ApplicantFamily::where('user_id', Auth::user()->id)->get();
        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('gender', function ($row) {
                    $id = $row->gender;
                    $gender = DB::table('gender')->where('id', $id)->first();
                    return $gender->name;
                })
                ->addColumn('pendidikan', function ($row) {
                    $id = $row->pendidikan;
                    if($id != '')
                    {
                        $getStudy = DB::table('studygrade')->where('id', $id)->first();
                        $study = $getStudy->name;
                    }else{
                        $study = 'Tidak sekolah';
                    }
                    return $study;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editData"><i class="fa fa-edit"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action','gender','pendidikan'])
                ->make(true);
            return $allData;
        }
    }

    public function edit($id)
    {
        $data = ApplicantFamily::find($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        ApplicantFamily::updateOrCreate(
            ['id' => $request->data_id],
            [
                'user_id' => $request->user_id,
                'nama' => $request->nama,
                'status' => $request->status,
                'gender' => $request->gender,
                'ttl' => $request->ttl,
                'pendidikan' => $request->pendidikan,
                'pekerjaan' => $request->pekerjaan,
            ]
        );
        return response()->json(['success' => 'Data telah berhasil disimpan']);
    }

    public function destroy($id)
    {
        ApplicantFamily::find($id)->delete();
        return response()->json(['success' => 'Data telah berhasil dihapus']);
    }

    public function convert()
    {
        try {
            $apply = ApplicantFamily::orderBy('id')->get();
            foreach($apply as $data){
                $update = ApplicantFamily::find($data->id);

                // $update->nama = Crypt::decryptString($data->nama);
                // $update->status = Crypt::decryptString($data->status);
                // $update->gender = Crypt::decryptString($data->gender);
                // $update->ttl = Crypt::decryptString($data->ttl);
                // $update->pendidikan = Crypt::decryptString($data->pendidikan);
                // $update->pekerjaan = Crypt::decryptString($data->pekerjaan);
                switch($data->gender_char){
                    case 'Pria' : $gender_char = 'Pria'; $gender = 2; break;
                    default : $gender_char = 'Wanita'; $gender = 1; break; 
                }
                $update->gender = $gender;

                switch($data->pendidikan_char){
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
                $update->pendidikan = $study;
                
                $update->update();
            }
            dd('done');
        } catch (\Throwable $e) {
            dd([$update->id,$e->getMessage()]);
            dd($e->getMessage());
        }
    }
}
