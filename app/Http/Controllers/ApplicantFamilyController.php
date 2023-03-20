<?php

namespace App\Http\Controllers;

use App\Models\ApplicantFamily;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

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
}
