<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class FormController extends Controller
{
    public function index()
    {
        return view('pages.form.index');
    }

    public function showData(Request $request)
    {
        $data = Form::query();
        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . 'storage/form/' . $row->code . '.pdf' . '" target="_blank" class="show btn btn-primary btn-sm showData"><i class="fa fa-eye"></i></a>';
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
        $data = Form::find($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:4096',
        ]);

        $date = now()->format('ymdHis');
        $fileName =  $date . '.pdf';

        $request->file->move('storage/form', $fileName);

        Form::updateOrCreate(
            ['id' => $request->data_id],
            [
                'name' => $request->name,
                'code' => $date
            ]
        );
        return response()->json(['success' => 'Data telah berhasil disimpan']);
    }

    public function destroy($id)
    {
        $data = Form::find($id);
        $file = 'storage/form/' . $data->code . '.pdf';
        File::delete(($file));
        $data->delete();
        return response()->json(['success' => 'Data telah berhasil dihapus']);
    }
}
