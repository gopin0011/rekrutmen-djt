<?php

namespace App\Http\Controllers;

use App\Models\ApplicantStudy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ApplicantStudyController extends Controller
{
    public function index()
    {
        $dt = route('applicant_studies.data');
        $study = DB::table('studygrade')->get();
        return view('pages.applicant.study', compact('study','dt'));
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
}
