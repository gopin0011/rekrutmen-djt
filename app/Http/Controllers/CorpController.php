<?php

namespace App\Http\Controllers;

use App\Models\Corp;
use App\Models\Staff;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CorpController extends Controller
{
    public function index()
    {
        return view('pages.corp.index');
    }

    public function showData(Request $request)
    {
        $data = Corp::query();
        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $trans = Staff::where('corp', $row->id)->get();
                    $count = count($trans);
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editData"><i class="fa fa-edit"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    if ($count == 0) {
                        $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            return $allData;
        }
    }

    public function edit($id)
    {
        $data = Corp::find($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {

        Corp::updateOrCreate(
            ['id' => $request->data_id],
            [
                'name' => $request->name,
                'code' => $request->code
            ]
        );
        return response()->json(['success' => 'Data telah berhasil disimpan']);
    }

    public function destroy($id)
    {
        Corp::find($id)->delete();
        return response()->json(['success' => 'Data telah berhasil dihapus']);
    }
}
