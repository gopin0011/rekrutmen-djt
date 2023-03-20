<?php

namespace App\Http\Controllers;

use App\Models\Dept;
use App\Models\Staff;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DeptController extends Controller
{
    public function index()
    {
        return view('pages.dept.index');
    }

    public function showData(Request $request)
    {
        $data = Dept::query();
        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $trans = Staff::where('dept', $row->id)->get();
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
        $data = Dept::find($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {

        Dept::updateOrCreate(
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
        Dept::find($id)->delete();
        return response()->json(['success' => 'Data telah berhasil dihapus']);
    }
}
