<?php

namespace App\Http\Controllers;

use App\Models\ApplicantDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;

class ApplicantDocumentController extends Controller
{
    public function index()
    {
        $dt = route('applicant_documents.data');
        return view('pages.applicant.document',compact('dt'));
    }

    public function showData(Request $request)
    {
        $data = ApplicantDocument::where('user_id',Auth::user()->id)->get();
        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row){
                    $nama = 'Dokumen CV';
                    return $nama;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . 'storage/doc/' . $row->dokumen . '.pdf' . '" target="_blank" class="show btn btn-primary btn-sm showData"><i class="fa fa-eye"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action','name'])
                ->make(true);
            return $allData;
        }
    }

    public function edit($id)
    {
        $data = ApplicantDocument::find($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $check = ApplicantDocument::where('user_id', $request->user_id)->get();

        $request->validate([
            'file' => 'required|mimes:pdf|max:4096',
        ]);

        $date = $request->user_id;
        $fileName =  $date . '.pdf';

        $request->file->move('storage/doc', $fileName);

        if(count($check) == 0)
        {
            ApplicantDocument::Create(
                [
                    'user_id' => $request->user_id,
                    'dokumen' => $date
                ]
            );
        }
        return response()->json(['success' => 'Data telah berhasil disimpan']);
    }

    public function destroy($id)
    {
        $data = ApplicantDocument::find($id);
        $file = 'storage/doc/' . $data->dokumen . '.pdf';
        File::delete(($file));
        $data->delete();
        return response()->json(['success' => 'Data telah berhasil dihapus']);
    }
}
