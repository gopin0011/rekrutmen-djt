<?php

namespace App\Http\Controllers;

use App\Models\Corp;
use App\Models\Dept;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class StaffController extends Controller
{
    const per_page = 10;

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
            $data = Staff::where('status', '<>', '2')->whereNull('resign')->get();
        } 
        else if ($id == 'alper') {
            $data = Staff::where([['status', '<>', '2'], ['corp', '1']])->whereNull('resign')->get();
        } 
        else if ($id == 'legano5'){
            $data = Staff::where([['status', '<>', '2'], ['corp', '3']])->whereNull('resign')->get();
        }
        else {
            $data = Staff::where([['status', '<>', '2'], ['corp', '2']])->whereNull('resign')->get();
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
                    return $dept->nama;
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
        } else if ($id == 'legano5') {
            $data = Staff::where([['status', '<>', '2'], ['resign', '<>', ''], ['corp', '3']])->get();
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
                    return $dept->nama;
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
            $data = Staff::where([['status', '2']])->whereNull('resign')->get();
        } else if ($id == 'alper') {
            $data = Staff::where([['status', '2'], ['corp', '1']])->whereNull('resign')->get();
        } else if ($id == 'legano5') {
            $data = Staff::where([['status', '2'], ['corp', '3']])->whereNull('resign')->get();
        } else {
            $data = Staff::where([['status', '2'], ['corp', '2']])->whereNull('resign')->get();
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
                    return $dept->nama;
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
        } else if ($id == 'legano5') {
            $data = Staff::where([['status', '2'], ['resign', '<>', ''], ['corp', '3']])->get();
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
                    return $dept->nama;
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
        // dd($data->age = $data->age);
        $data->age = $data->age; 
        $data->masaKerja = $data->masaKerja;

        return response()->json($data);
    }

    public function store(Request $request)
    {
        if ($request->opsiresign == 0) {
            $resign = null;
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
                'kontak' => $request->kontak,
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
                'bpjs_kesehatan' => $request->bpjs_kes,
                'bpjs_tk' => $request->bpjs_tk,
                'titip_ijazah' => $request->titip_ijazah,
                'vaksin1' => $request->vaksin1,
                'vaksin2' => $request->vaksin2,
                'vaksin3' => $request->vaksin3,
                'vaksin4' => $request->vaksin4,
                'end_contract' => $request->end_contract,
                'sp1' => $request->sp1,
                'sp2' => $request->sp2,
                'sp3' => $request->sp3,
                'role' => ($request->role == "0") ? null : $request->role,
            ]
        );
        return response()->json(['success' => 'Data telah berhasil disimpan']);
    }

    public function destroy($id)
    {
        Staff::find($id)->delete();
        return response()->json(['success' => 'Data telah berhasil dihapus']);
    }

    public function showStaff(Request $request)
    {
        $current_page = request('page') ?? 1;

        $limit = self::per_page;
        $start = ($current_page * self::per_page) - self::per_page;

        $search = request('search');
        if($search == '') {
            // unset($search);
        }

        $q = Staff::orderBy('name');
        if ($search != '' && $search) {
            $q->where('name', 'like', '%'.$search.'%')
            ->orWhere('email', 'like', '%'.$search.'%')
            ->orWhere('kontak', 'like', '%'.$search.'%');
        }
        $total = $q->count();
        
        $q->offset($start)->limit($limit);

        $data = $q->get();

        $result['paginator'] = new Paginator($data, $total, self::per_page, $current_page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return $result;
    }

    public function conver00()
    {
        // where('id','<=', 172)->where('id','>', 172)->
        $staff = Staff::orderBy('id')->get();
        foreach($staff as $data){
            switch(Crypt::decryptString($data->gender_char)){
                case 'Pria' : $gender_char = 'Pria'; $gender = 2; break;
                default : $gender_char = 'Wanita'; $gender = 1; break; 
            }

            switch($data->divisi){
                case 'Business and Development' : $divisi = 'Business and Development'; $dept = 17; break;
                case 'Comptroller' : $divisi = 'Comptroller'; $dept = 32; break;
                case 'Elektro' : $divisi = 'Elektro'; $dept = 12; break;
                case 'Engineering' : $divisi = 'Engineering'; $dept = 19; break;
                case 'FAT' : $divisi = 'FAT'; $dept = 1; break;
                case 'Finishing' : $divisi = 'Finishing'; $dept = 23; break;
                case 'General Affairs' : $divisi = 'General Affairs'; $dept = 4; break;
                case 'Gudang' : $divisi = 'Gudang'; $dept = 9; break;
                case 'Handmade Panel' : $divisi = 'Handmade Panel'; $dept = 28; break;
                case 'Human Resources' : $divisi = 'Human Resources'; $dept = 3; break;
                case 'Injection' : $divisi = 'Injection'; $dept = 13; break;
                case 'Kayu' : $divisi = 'Kayu'; $dept = 11; break;
                case 'Logam' : $divisi = 'Logam'; $dept = 10; break;
                case 'Multimedia' : $divisi = 'Multimedia'; $dept = 30; break;
                case 'Offset Printing' : $divisi = 'Offset Printing'; $dept = 18; break;
                case 'Operasional' : $divisi = 'Operasional'; $dept = 8; break;
                case 'Packing dan Finish Good' : $divisi = 'Packing dan Finish Good'; $dept = 22; break;
                case 'Pembahanaan dan Proses Panel' : $divisi = 'Pembahanaan dan Proses Panel'; $dept = 20; break;
                case 'PPIC' : $divisi = 'PPIC'; $dept = 24; break;
                case 'Product Development' : $divisi = 'Product Development'; $dept = 29; break;
                case 'Product Development Engineering' : $divisi = 'Product Development Engineering'; $dept = 27; break;
                case 'Project' : $divisi = 'Project'; $dept = 25; break;
                case 'Purchasing' : $divisi = 'Purchasing'; $dept = 6; break;
                case 'Quality Control' : $divisi = 'Quality Control'; $dept = 14; break;
                case 'Research and Development' : $divisi = 'Research and Development'; $dept = 7; break;
                case 'Set Up' : $divisi = 'Set Up'; $dept = 15; break;
                case 'Solid dan Assembling' : $divisi = 'Solid dan Assembling'; $dept = 21; break;
                case 'Vokasi' : $divisi = 'Vokasi'; $dept = 16; break;
                case 'Marketing' : $divisi = 'Marketing'; $dept = 26; break;
                case 'Produksi' : $divisi = 'Marketing'; $dept = 31; break;
            }

            switch(Crypt::decryptString($data->agama)){
                case 'Islam' : $agama = 'Islam'; $religion = 6; break;
                case 'Budha' : $agama = 'Budha'; $religion = 3; break;
                case 'Katolik' : $agama = 'Katolik'; $religion = 2; break;
                case 'Kong Hu Cu' : $agama = 'Kong Hu Cu'; $religion = 5; break;
                case 'Kristen' : $agama = 'Kristen'; $religion = 7; break;
                case 'Protestan' : $agama = 'Protestan'; $religion = 1; break;
                case 'Hindu' : $agama = 'Hindu'; $religion = 4; break;
            }

            switch($data->status_char){
                case 'Kontrak' : $status_char = 'Kontrak'; $status = 3; break;
                case 'Tetap' : $status_char = 'Tetap'; $status = 1; break;
                case 'TLH' : $status_char = 'TLH'; $status = 2; break;
            }

            switch(Crypt::decryptString($data->pendidikan)){
                case 'SD' : $pendidikan = 'SD'; $study = 9; break;
                case 'SMP' : $pendidikan = 'SMP'; $study = 1; break;
                case 'SMA' : $pendidikan = 'SMA'; $study = 2; break;
                case 'D1' : $pendidikan = 'D1'; $study = 3; break;
                case 'D3' : $pendidikan = 'D3'; $study = 4; break;
                case 'D4' : $pendidikan = 'D4'; $study = 5; break;
                case 'S1' : $pendidikan = 'S1'; $study = 6; break;
                case 'S2' : $pendidikan = 'S2'; $study = 7; break;
                case 'S3' : $pendidikan = 'S3'; $study = 8; break;
            }

            $update = Staff::find($data->id);

            switch($data->blahir) {
                case 'Januari' : $bln = '01'; break;
                case 'Februari' : $bln = '02'; break;
                case 'Maret' : $bln = '03'; break;
                case 'April' : $bln = '04'; break;
                case 'Mei' : $bln = '05'; break;
                case 'Juni' : $bln = '06'; break;
                case 'Juli' : $bln = '07'; break;
                case 'Agustus' : $bln = '08'; break;
                case 'September' : $bln = '09'; break;
                case 'Oktober' : $bln = '10'; break;
                case 'November' : $bln = '11'; break;
                case 'Desember' : $bln = '12'; break;
            }

            $born = $data->thahir.'-'.$bln.'-'.$data->hlahir;

            $update->born = Carbon::createFromFormat('Y-m-d', $born)->toDateString();

            switch($data->bjoin) {
                case 'Januari' : $bln = '01'; break;
                case 'Februari' : $bln = '02'; break;
                case 'Maret' : $bln = '03'; break;
                case 'April' : $bln = '04'; break;
                case 'Mei' : $bln = '05'; break;
                case 'Juni' : $bln = '06'; break;
                case 'Juli' : $bln = '07'; break;
                case 'Agustus' : $bln = '08'; break;
                case 'September' : $bln = '09'; break;
                case 'Oktober' : $bln = '10'; break;
                case 'November' : $bln = '11'; break;
                case 'Desember' : $bln = '12'; break;
            }

            $join = $data->thjoin.'-'.$bln.'-'.$data->hjoin;

            $update->joindate = Carbon::createFromFormat('Y-m-d', $join)->toDateString();

            switch($data->bjoin) {
                case 'Januari' : $bln = '01'; break;
                case 'Februari' : $bln = '02'; break;
                case 'Maret' : $bln = '03'; break;
                case 'April' : $bln = '04'; break;
                case 'Mei' : $bln = '05'; break;
                case 'Juni' : $bln = '06'; break;
                case 'Juli' : $bln = '07'; break;
                case 'Agustus' : $bln = '08'; break;
                case 'September' : $bln = '09'; break;
                case 'Oktober' : $bln = '10'; break;
                case 'November' : $bln = '11'; break;
                case 'Desember' : $bln = '12'; break;
            }

            $join = $data->thjoin.'-'.$bln.'-'.$data->hjoin;

            $update->joindate = Carbon::createFromFormat('Y-m-d', $join)->toDateString();


            $update->nama = Crypt::decryptString($data->nama);
            $update->kk = Crypt::decryptString($data->kk);
            $update->ktp = Crypt::decryptString($data->ktp);
            $update->gender_char = $gender_char;
            $update->agama = $agama;
            $update->tmlahir = Crypt::decryptString($data->tmlahir);
            $update->hlahir = Crypt::decryptString($data->hlahir);
            $update->blahir = Crypt::decryptString($data->blahir);
            $update->thahir = Crypt::decryptString($data->thahir);  
            $update->alamat = Crypt::decryptString($data->alamat);
            $update->jabatan = Crypt::decryptString($data->jabatan);
            $update->masa = Crypt::decryptString($data->masa);
            $update->gaji = Crypt::decryptString($data->gaji);
            $update->rekening = Crypt::decryptString($data->rekening);
            $update->npwp = Crypt::decryptString($data->npwp);
            $update->ptkp = Crypt::decryptString($data->ptkp);
            $update->pendidikan = $pendidikan;
            $update->sekolah = Crypt::decryptString($data->sekolah);
            $update->prodi = Crypt::decryptString($data->prodi);
            $update->ijazah = Crypt::decryptString($data->ijazah);
            $update->email = Crypt::decryptString($data->email);
            $update->sp1 = Crypt::decryptString($data->sp1);
            $update->sp2 = Crypt::decryptString($data->sp2);
            $update->sp3 = Crypt::decryptString($data->sp3);
            $update->hreward5 = $data->hreward5 ? Crypt::decryptString($data->hreward5) : null;
            $update->breward5 = $data->breward5 ? Crypt::decryptString($data->breward5) : null;
            $update->threward5 = $data->threward5 ? Crypt::decryptString($data->threward5) : null;
            $update->reward5 = $data->reward5 ? Crypt::decryptString($data->reward5) : null;
            $update->hreward10 = $data->hreward10 ? Crypt::decryptString($data->hreward10) : null;
            $update->breward10 = $data->breward10 ? Crypt::decryptString($data->breward10) : null;
            $update->threward10 = $data->threward10 ? Crypt::decryptString($data->threward10) : null;
            $update->reward10 = $data->reward10 ? Crypt::decryptString($data->reward10) : null;
            $update->hreward15 = $data->hreward15 ? Crypt::decryptString($data->hreward15) : null;
            $update->breward15 = $data->breward15 ? Crypt::decryptString($data->breward15) : null;
            $update->threward15 = $data->threward15 ? Crypt::decryptString($data->threward15) : null;
            $update->reward15 = $data->reward15 ? Crypt::decryptString($data->reward15) : null;
            $update->gender = $gender;
            $update->dept = $dept;
            $update->religion = $religion;
            $update->status = $status;
            $update->study = $study;
            $update->update();
        }
        dd('done');
        dd($staff);
    }
}
