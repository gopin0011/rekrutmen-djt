<?php

namespace App\Http\Controllers;

use App\Models\Corp;
use App\Models\Dept;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class StaffController extends Controller
{
    public function staffActive($id)
    {
        $x = route('staffActive.data', ['id' => $id]);
        $genders = DB::table('gender')->get();
        $religions = DB::table('religion')->get();
        $status = DB::table('staffstatus')->where('id', '<>', '2')->get();
        $study = DB::table('studygrade')->get();
        $corps = Corp::all();
        $depts = Dept::all();
        return view('pages.staff.active', compact('x', 'genders', 'religions', 'status', 'study', 'corps', 'depts'));
    }

    public function showDataStaffActive(Request $request, $id)
    {
        if ($id == 'all') {
            $data = Staff::where([['status', '<>', '2'], ['resign', '']])->get();
        } else if ($id == 'alper') {
            $data = Staff::where([['status', '<>', '2'], ['resign', ''], ['corp', '1']])->get();
        } else {
            $data = Staff::where([['status', '<>', '2'], ['resign', ''], ['corp', '2']])->get();
        }
        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('corp', function ($row) {
                    $id = $row->corp;
                    $corp = Corp::find($id);
                    return $corp->name;
                })
                ->addColumn('dept', function ($row) {
                    $id = $row->dept;
                    $dept = Dept::find($id);
                    return $dept->name;
                })
                ->addColumn('gender', function ($row) {
                    $id = $row->gender;
                    $gender = DB::table('gender')->where('id', $id)->first();
                    return $gender->name;
                })
                ->addColumn('religion', function ($row) {
                    $id = $row->religion;
                    $religion = DB::table('religion')->where('id', $id)->first();
                    return $religion->name;
                })
                ->addColumn('born', function ($row) {
                    if ($row->born != '') {
                        $born = date('d F Y', strtotime($row->born));
                    } else {
                        $born = '';
                    }
                    return $born;
                })
                ->addColumn('years', function ($row) {
                    $years = now()->diffInYears($row->born);
                    return $years . ' tahun';
                })
                ->addColumn('joindate', function ($row) {
                    if ($row->joindate != '') {
                        $joindate = date('d F Y', strtotime($row->joindate));
                    } else {
                        $joindate = '';
                    }
                    return $joindate;
                })
                ->addColumn('joinyears', function ($row) {
                    $joinyears = now()->diffInYears($row->joindate);
                    return $joinyears . ' tahun';
                })
                ->addColumn('status', function ($row) {
                    $id = $row->status;
                    $status = DB::table('staffstatus')->where('id', $id)->first();
                    return $status->name;
                })
                ->addColumn('study', function ($row) {
                    $id = $row->study;
                    $study = DB::table('studygrade')->where('id', $id)->first();
                    return $study->name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editData"><i class="fa fa-edit"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['corp', 'dept', 'gender', 'religion', 'born', 'years', 'joindate', 'joinyears', 'status', 'study', 'action'])
                ->make(true);
            return $allData;
        }
    }

    public function staffResign($id)
    {
        $x = route('staffResign.data', ['id' => $id]);
        $genders = DB::table('gender')->get();
        $religions = DB::table('religion')->get();
        $status = DB::table('staffstatus')->where('id', '<>', '2')->get();
        $study = DB::table('studygrade')->get();
        $corps = Corp::all();
        $depts = Dept::all();
        return view('pages.staff.resign', compact('x', 'genders', 'religions', 'status', 'study', 'corps', 'depts'));
    }

    public function showDataStaffResign(Request $request, $id)
    {
        if ($id == 'all') {
            $data = Staff::where([['status', '<>', '2'], ['resign', '<>', '']])->get();
        } else if ($id == 'alper') {
            $data = Staff::where([['status', '<>', '2'], ['resign', '<>', ''], ['corp', '1']])->get();
        } else {
            $data = Staff::where([['status', '<>', '2'], ['resign', '<>', ''], ['corp', '2']])->get();
        }

        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('corp', function ($row) {
                    $id = $row->corp;
                    $corp = Corp::find($id);
                    return $corp->name;
                })
                ->addColumn('dept', function ($row) {
                    $id = $row->dept;
                    $dept = Dept::find($id);
                    return $dept->name;
                })
                ->addColumn('gender', function ($row) {
                    $id = $row->gender;
                    $gender = DB::table('gender')->where('id', $id)->first();
                    return $gender->name;
                })
                ->addColumn('religion', function ($row) {
                    $id = $row->religion;
                    $religion = DB::table('religion')->where('id', $id)->first();
                    return $religion->name;
                })
                ->addColumn('born', function ($row) {
                    if ($row->born != '') {
                        $born = date('d F Y', strtotime($row->born));
                    } else {
                        $born = '';
                    }
                    return $born;
                })
                ->addColumn('years', function ($row) {
                    $years = now()->diffInYears($row->born);
                    return $years . ' tahun';
                })
                ->addColumn('joindate', function ($row) {
                    if ($row->joindate != '') {
                        $joindate = date('d F Y', strtotime($row->joindate));
                    } else {
                        $joindate = '';
                    }
                    return $joindate;
                })
                ->addColumn('joinyears', function ($row) {
                    $joinyears = strtotime($row->resign) - strtotime($row->joindate);
                    return abs(round($joinyears / 31536000)) . ' tahun';
                })
                ->addColumn('status', function ($row) {
                    $id = $row->status;
                    $status = DB::table('staffstatus')->where('id', $id)->first();
                    return $status->name;
                })
                ->addColumn('study', function ($row) {
                    $id = $row->study;
                    $study = DB::table('studygrade')->where('id', $id)->first();
                    return $study->name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editData"><i class="fa fa-edit"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['corp', 'dept', 'gender', 'religion', 'born', 'years', 'joindate', 'joinyears', 'status', 'study', 'action'])
                ->make(true);
            return $allData;
        }
    }

    public function tlhActive($id)
    {
        $x = route('tlhActive.data', ['id' => $id]);
        $genders = DB::table('gender')->get();
        $religions = DB::table('religion')->get();
        $status = DB::table('staffstatus')->where('id', '2')->get();
        $study = DB::table('studygrade')->get();
        $corps = Corp::all();
        $depts = Dept::all();
        return view('pages.tlh.active', compact('x', 'genders', 'religions', 'status', 'study', 'corps', 'depts'));
    }

    public function showDataTlhActive(Request $request, $id)
    {
        if ($id == 'all') {
            $data = Staff::where([['status', '2'], ['resign', '']])->get();
        } else if ($id == 'alper') {
            $data = Staff::where([['status', '2'], ['resign', ''], ['corp', '1']])->get();
        } else {
            $data = Staff::where([['status', '2'], ['resign', ''], ['corp', '2']])->get();
        }
        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('corp', function ($row) {
                    $id = $row->corp;
                    $corp = Corp::find($id);
                    return $corp->name;
                })
                ->addColumn('dept', function ($row) {
                    $id = $row->dept;
                    $dept = Dept::find($id);
                    return $dept->name;
                })
                ->addColumn('gender', function ($row) {
                    $id = $row->gender;
                    $gender = DB::table('gender')->where('id', $id)->first();
                    return $gender->name;
                })
                ->addColumn('religion', function ($row) {
                    $id = $row->religion;
                    $religion = DB::table('religion')->where('id', $id)->first();
                    return $religion->name;
                })
                ->addColumn('born', function ($row) {
                    if ($row->born != '') {
                        $born = date('d F Y', strtotime($row->born));
                    } else {
                        $born = '';
                    }
                    return $born;
                })
                ->addColumn('years', function ($row) {
                    $years = now()->diffInYears($row->born);
                    return $years . ' tahun';
                })
                ->addColumn('joindate', function ($row) {
                    if ($row->joindate != '') {
                        $joindate = date('d F Y', strtotime($row->joindate));
                    } else {
                        $joindate = '';
                    }
                    return $joindate;
                })
                ->addColumn('joinyears', function ($row) {
                    $joinyears = now()->diffInYears($row->joindate);
                    return $joinyears . ' tahun';
                })
                ->addColumn('status', function ($row) {
                    $id = $row->status;
                    $status = DB::table('staffstatus')->where('id', $id)->first();
                    return $status->name;
                })
                ->addColumn('study', function ($row) {
                    $id = $row->study;
                    $study = DB::table('studygrade')->where('id', $id)->first();
                    return $study->name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editData"><i class="fa fa-edit"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['corp', 'dept', 'gender', 'religion', 'born', 'years', 'joindate', 'joinyears', 'status', 'study', 'action'])
                ->make(true);
            return $allData;
        }
    }

    public function tlhResign($id)
    {
        $x = route('tlhResign.data', ['id' => $id]);
        $genders = DB::table('gender')->get();
        $religions = DB::table('religion')->get();
        $status = DB::table('staffstatus')->where('id', '2')->get();
        $study = DB::table('studygrade')->get();
        $corps = Corp::all();
        $depts = Dept::all();
        return view('pages.tlh.resign', compact('x', 'genders', 'religions', 'status', 'study', 'corps', 'depts'));
    }

    public function showDataTlhResign(Request $request, $id)
    {
        if ($id == 'all') {
            $data = Staff::where([['status', '2'], ['resign', '<>', '']])->get();
        } else if ($id == 'alper') {
            $data = Staff::where([['status', '2'], ['resign', '<>', ''], ['corp', '1']])->get();
        } else {
            $data = Staff::where([['status', '2'], ['resign', '<>', ''], ['corp', '2']])->get();
        }

        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('corp', function ($row) {
                    $id = $row->corp;
                    $corp = Corp::find($id);
                    return $corp->name;
                })
                ->addColumn('dept', function ($row) {
                    $id = $row->dept;
                    $dept = Dept::find($id);
                    return $dept->name;
                })
                ->addColumn('gender', function ($row) {
                    $id = $row->gender;
                    $gender = DB::table('gender')->where('id', $id)->first();
                    return $gender->name;
                })
                ->addColumn('religion', function ($row) {
                    $id = $row->religion;
                    $religion = DB::table('religion')->where('id', $id)->first();
                    return $religion->name;
                })
                ->addColumn('born', function ($row) {
                    if ($row->born != '') {
                        $born = date('d F Y', strtotime($row->born));
                    } else {
                        $born = '';
                    }
                    return $born;
                })
                ->addColumn('years', function ($row) {
                    $years = now()->diffInYears($row->born);
                    return $years . ' tahun';
                })
                ->addColumn('joindate', function ($row) {
                    if ($row->joindate != '') {
                        $joindate = date('d F Y', strtotime($row->joindate));
                    } else {
                        $joindate = '';
                    }
                    return $joindate;
                })
                ->addColumn('joinyears', function ($row) {
                    $joinyears = strtotime($row->resign) - strtotime($row->joindate);
                    return abs(round($joinyears / 31536000)) . ' tahun';
                })
                ->addColumn('status', function ($row) {
                    $id = $row->status;
                    $status = DB::table('staffstatus')->where('id', $id)->first();
                    return $status->name;
                })
                ->addColumn('study', function ($row) {
                    $id = $row->study;
                    $study = DB::table('studygrade')->where('id', $id)->first();
                    return $study->name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editData"><i class="fa fa-edit"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['corp', 'dept', 'gender', 'religion', 'born', 'years', 'joindate', 'joinyears', 'status', 'study', 'action'])
                ->make(true);
            return $allData;
        }
    }

    public function edit($id)
    {
        $data = Staff::find($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {

        if ($request->opsiresign == 0) {
            $resign = '';
        } else {
            $resign = $request->resign;
        }

        Staff::updateOrCreate(
            ['id' => $request->data_id],
            [
                'nik' => $request->nik,
                'name' => $request->name,
                'corp' => $request->corp,
                'dept' => $request->dept,
                'position' => $request->position,
                'gender' => $request->gender,
                'religion' => $request->religion,
                'kk' => $request->kk,
                'ktp' => $request->ktp,
                'address' => $request->address,
                'email' => $request->email,
                'certi' => $request->certi,
                'place' => $request->place,
                'born' => $request->born,
                'bill' => $request->bill,
                'npwp' => $request->npwp,
                'ptkp' => $request->ptkp,
                'status' => $request->status,
                'joindate' => $request->joindate,
                'study' => $request->study,
                'school' => $request->school,
                'prodi' => $request->prodi,
                'ijazah' => $request->ijazah,
                'resign' => $resign,
            ]
        );
        return response()->json(['success' => 'Data telah berhasil disimpan']);
    }

    public function destroy($id)
    {
        Staff::find($id)->delete();
        return response()->json(['success' => 'Data telah berhasil dihapus']);
    }
}
