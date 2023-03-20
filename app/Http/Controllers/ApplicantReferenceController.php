<?php

namespace App\Http\Controllers;

use App\Models\ApplicantReference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ApplicantReferenceController extends Controller
{
    public function index()
    {
        $dt = route('applicant_references.data');
        return view('pages.applicant.reference',compact('dt'));
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
}
