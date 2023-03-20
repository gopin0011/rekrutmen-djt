<?php

namespace App\Http\Controllers;

use App\Models\Corp;
use App\Models\Dept;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class VacancyController extends Controller
{
    public function index()
    {
        $corps = Corp::all();
        $depts = Dept::all();
        return view('pages.vacancy.index',compact('corps','depts'));
    }

    public function showData(Request $request)
    {
        $data = Vacancy::all();
        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('corp', function ($row) {
                    $id = $row->corp;
                    $corp = Corp::find($id);
                    return $corp->name;
                })
                ->addColumn('dept', function ($row) {
                    $dept = $row->dept;
                    $data = Dept::find($dept);
                    return $data->name;
                })
                ->addColumn('status', function ($row) {
                    $data = $row->status;
                    if($data == '0'){
                        $status = 'Aktif';
                    }else{
                        $status = 'Tidak tersedia';
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editData"><i class="fa fa-edit"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['corp','dept','status','action'])
                ->make(true);
            return $allData;
        }
    }

    public function edit($id)
    {
        $data = Vacancy::find($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        Vacancy::updateOrCreate(
            ['id' => $request->data_id],
            [
                'name' => $request->name,
                'corp' => $request->corp,
                'dept' => $request->dept,
                'description' => $request->description,
                'status' => $request->status
            ]
        );
        return response()->json(['success' => 'Data telah berhasil disimpan']);
    }

    public function destroy($id)
    {
        Vacancy::find($id)->delete();
        return response()->json(['success' => 'Data telah berhasil dihapus']);
    }
}
