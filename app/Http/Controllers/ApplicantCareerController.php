<?php

namespace App\Http\Controllers;

use App\Models\ApplicantCareer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ApplicantCareerController extends Controller
{
    public function index()
    {
        $dt = route('applicant_careers.data');
        return view('pages.applicant.career', compact('dt'));
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
}
