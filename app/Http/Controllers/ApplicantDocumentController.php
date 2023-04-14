<?php

namespace App\Http\Controllers;

use App\Models\ApplicantDocument;
use App\Models\Application;
use App\Models\ApplicantAdditionalDocument;
use App\Models\AdditionalUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;

class ApplicantDocumentController extends Controller
{
    public function index()
    {
        $dt = route('applicant_documents.data');
        $applications = Application::groupBy('posisi', 'user_id')->select('posisi', 'user_id')->with('vacancy')->whereHas('vacancy.vacanciesAdditionalUpload')->where('user_id', Auth::user()->id)->get();
        return view('pages.applicant.document',compact('dt','applications'));
    }

    public function showDataAdditional($userId, $vacancyId, $additionalUploadId)
    {
        $additionalDocument = ApplicantAdditionalDocument::with('additionalUpload')->where('user_id', $userId)->where('vacancy_id', $vacancyId)->where('additional_upload_id', $additionalUploadId)->first();
        $data['ApplicantAdditionalDocument'] = $additionalDocument;
        $data['status'] = 200;
        $data['message'] = 'success';
        $data['title'] = AdditionalUpload::find($additionalUploadId)->text;
        $data['userid'] = $userId;
        $data['vacancyid'] = $vacancyId;
        $data['additionaluploadid'] = $additionalUploadId;

        return response()->json($data);
    }

    public function storeAdditional(Request $request)
    {
        $user_id = $request->user_id;
        $vacancy_id = $request->vacancy_id;
        $additional_upload_id = $request->additional_upload_id;

        $request->validate([
            'file' => 'required|mimes:pdf|max:4096',
        ]);

        $file = $user_id.'-'.$vacancy_id.'-'.$additional_upload_id;
        $fileName =  $file.'.pdf';

        $request->file->move('storage/app/public/additional', $fileName);

        ApplicantAdditionalDocument::Create(
            [
                'user_id' => $user_id,
                'vacancy_id' => $vacancy_id,
                'additional_upload_id' => $additional_upload_id,
                'file' => $file
            ]
        );

        return response()->json(['success' => 'Data telah berhasil disimpan']);
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
                    $url = route('storage.doc', ['folder' => 'doc', 'filename' => $row->dokumen.'.pdf']);
                    $btn = '<div class="btn-group"><a href="' . $url . '" target="_blank" class="show btn btn-primary btn-sm showData"><i class="fa fa-eye"></i></a>';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a></div>';
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

        $request->file->move('storage/app/public/doc', $fileName);

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
        $file = 'storage/app/public/doc/' . $data->dokumen . '.pdf';
        File::delete(($file));
        $data->delete();
        return response()->json(['success' => 'Data telah berhasil dihapus']);
    }

    public function destroyAdditional($id)
    {
        $data = ApplicantAdditionalDocument::find($id);
        $file = 'storage/app/public/additional/' . $data->file . '.pdf';
        File::delete(($file));
        $data->delete();
        return response()->json(['success' => 'Data telah berhasil dihapus']);
    }
}
