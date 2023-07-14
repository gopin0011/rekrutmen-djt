<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Dept;
use App\Models\Staff;
use App\Models\Overtime;
use App\Models\Corp;
use App\Models\User;
use App\Mail\AdminSPLNotification;
use App\Models\PengajuanDana;
use App\Models\PengajuanDanaDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use \Illuminate\Support\Facades\DB;
use PDF;
// use Notification;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use DateTime;
// use Matrix\Operators\Division;
use App\Models\Division;
use Illuminate\Support\Facades\Validator;

class OvertimeController extends Controller
{
    const superAdmin = 2; // 3
    const hrStaff = 3; // 2
    const headDep = 4; // 9
    const adminDept = 5; // 8
    const interviewUser = 6; //1
    const interviewMana = 7; //1

    public function index()
    {
        $x = route('overtimes.data',['data' => 'all']);
        return view('pages.overtime.index', compact('x'));

        // if(Auth::user()->admin == self::headDep || Auth::user()->admin == self::adminDept){
        //     $statspl = 0;
        //     // $data = Overtime::where([['corp', Auth::user()->corp],['dept', Auth::user()->dept]])->get();
            
        //     $datas = Overtime::where([['hr',null],['manajer',null],['corp', Auth::user()->corp],['dept', Auth::user()->dept]])->get();
        //     $a = $datas->count();
        //     $b = NULL;
        //      return view('pages.overtime.index', compact('statspl','a','b', 'x'));
            
        // }else{
        //     $statspl = 0;
        //     // $data = Overtime::all();

        //     $datas = Overtime::where([['hr',null],['manajer','diterima'],['status',null]])->get();
        //     $a = NULL;
        //     $b = $datas->count();
            
        //     return view('pages.overtime.index', compact('statspl','a','b', 'x'));
        // }
    }

    public function showData(Request $request, $data)
    {
        if($data == 'all') {
            if(Auth::user()->admin == self::adminDept || Auth::user()->admin == self::headDep){
                $data = Overtime::where([['corp', Auth::user()->corp],['dept', Auth::user()->dept]])->get();
            }
            else {
                $data = Overtime::all();
            }
        }
        else if($data == 'manajer') {
            if(Auth::user()->admin == self::adminDept || Auth::user()->admin == self::headDep){
                $data = Overtime::where('corp', Auth::user()->corp)
                    ->where('dept', Auth::user()->dept)
                    ->whereNull('hr')
                    ->where('manajer','diterima')
                    ->get();
            }else{
                $data = Overtime::whereNull('hr')->where('manajer', 'diterima')->whereNull('status')->get();//where([['hr',null],['manajer','diterima'],['status',null]])->get();
            }
        }
        else if($data == 'today') {
            if(Auth::user()->admin == self::adminDept || Auth::user()->admin == self::headDep){
                $data = Overtime::where([['hr',null],['manajer',null],['corp', Auth::user()->corp],['dept', Auth::user()->dept]])->where('tanggalspl', Carbon::today())->get();
            }else{
                $data = Overtime::where([['hr',null],['manajer',null]])->where('tanggalspl', Carbon::today())->get();
            }
        }
        else if($data == 'hr') {
            if(Auth::user()->admin == self::adminDept || Auth::user()->admin == self::headDep){
                $data = Overtime::where([['hr','diterima'],['manajer','diterima'],['corp', Auth::user()->corp],['dept', Auth::user()->dept]])->get();
            }else{
                $data = Overtime::where([['hr','diterima'],['manajer','diterima']])->get();
            }
        }
        $statspl = 0;

        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('hari', function ($row) {
                    $getTanggal = Carbon::parse($row->tanggalspl)->locale('id');
                    $getTanggal->settings(['formatFunction' => 'translatedFormat']);
                    return $getTanggal->format('l, j F Y');
                })
                ->addColumn('action', function ($row) use ($statspl) {
                    $url = route('overtimes.print', ['id' => $row->nomor]);        
                    $btn = '<a target="_blank" href="'.$url.'" class="btn btn-success btn-sm" data-toggle="tooltip" title="Cetak"><i class="fa fa-print"></i></a>';
                    if(Auth::user()->admin == self::hrStaff || Auth::user()->admin == self::superAdmin || (Auth::user()->admin == self::headDep && !$row->hr)){
                        $url = route('overtimes.detailcreate', ['id' => $row->nomor,'withAction' => 1]);
                        $btn .= '&nbsp;&nbsp;<a href="'.$url.'" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Approve"><i class="fa fa-check"></i></a>';
                    }
                    if(!$row->manajer && Auth::user()->admin == self::adminDept) {
                        $url = route('overtimes.detailcreate', ['id' => $row->nomor]);
                        $btn .= '&nbsp;&nbsp;<a href="'.$url.'" class="btn btn-secondary btn-sm" data-toggle="tooltip" title="Ubah"><i class="fa fa-edit"></i></a>';
                    }
                    if((!$row->manajer && !$row->hr && Auth::user()->admin == self::adminDept)||(!$row->manajer && !$row->hr && Auth::user()->admin == self::hrStaff)||(Auth::user()->admin == self::superAdmin)||(Auth::user()->admin == self::headDep && $statspl == 0)||(Auth::user()->admin == 10 && $statspl == 0)) {
                        $url = route('overtimes.delete', ['id' => $row->id]);
                        $btn .= '&nbsp;&nbsp;<a href="'.$url.'" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>';
                    }
                    else if($statspl == 0 && Auth::user()->admin != self::adminDept) {
                        $url = route('overtimes.delete', ['id' => $row->id]);
                        $btn .= '&nbsp;&nbsp;<a href="'.$url.'" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>';
                    }
                    else {
                        // $url = route('overtimes.print', ['id' => $row->nomor]);
                        // $btn .= '&nbsp;&nbsp;<a target="_blank" href="'.$url.'" class="btn btn-success btn-sm" data-toggle="tooltip" title="Cetak"><i class="fa fa-print"></i></a>';
                    }
                                        
                    return $btn;
                })
                ->rawColumns(['action','hari'])
                ->make(true);
            return $allData;
        }
    }

    public function acc($id, Request $request)
    {
        $codeHr = env('HR_CODE');
        $userAcc = Auth::user();
        $manOrSuperHr = User::where(['admin' => 9])->with('division')->whereHas('division', function ($query) use ($codeHr) { 
            $query->where('kode', 'like', '%'.$codeHr.'%'); 
        })
        ->first();

        $overtime = Overtime::where('nomor', $id)->first();
        
        try {
            if($userAcc->id !== $manOrSuperHr->id) {
                $overtime->update([
                    'manajer' => $request->action
                ]);
            } else {
                $overtime->update([
                    'manajer' => $request->action,
                    'hr' => $request->action
                ]);
            }
            return redirect(route('overtimes.index'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
        
        dd($request->action);
    }

    public function start()
    {
        if(Auth::user()->admin == 8 || Auth::user()->admin == 9){
            $statspl = 0;
            $data = Overtime::where([['hr',null],['manajer',null],['bisnis', Auth::user()->bisnis],['divisi', Auth::user()->divisi]])->get();
            $datas = Overtime::where([['hr',null],['manajer',null],['bisnis', Auth::user()->bisnis],['divisi', Auth::user()->divisi]])->get();
            $a = $datas->count();
            $b = NULL;
            $withAction = 1;
            return view('overtime.index',compact('data','statspl','a','b'));
        }else{
            $statspl = 0;
            $data = Overtime::where([['hr',null],['manajer',null]])->get();
            $datas = Overtime::where([['hr',null],['manajer','diterima'],['status',null]])->get();
            $a = NULL;
            $b = $datas->count();
            $withAction = 0;
            return view('overtime.index',compact('data','statspl','a','b'));
        }
    }

    public function today()
    {
        $x = route('overtimes.data', ['data' => 'today']);
        return view('pages.overtime.index',compact('x'));
        
        // if(Auth::user()->admin == self::adminDept || Auth::user()->admin == self::headDep){
        //     $statspl = 0;
        //     $data = Overtime::where([['hr',null],['manajer',null],['corp', Auth::user()->corp],['dept', Auth::user()->dept]])->where('tanggalspl', Carbon::today())->get();
        //     $datas = Overtime::where([['hr',null],['manajer',null],['corp', Auth::user()->corp],['dept', Auth::user()->dept]])->where('tanggalspl', Carbon::today())->get();
        //     $a = $datas->count();
        //     $b = NULL;
        //     $withAction = 1;
        // }else{
        //     $statspl = 0;
        //     $data = Overtime::where([['hr',null],['manajer',null]])->where('tanggalspl', Carbon::today())->get();
        //     $datas = Overtime::where([['hr',null],['manajer','diterima'],['status',null]])->where('tanggalspl', Carbon::today())->get();
        //     $a = NULL;
        //     $b = $datas->count();
        //     $withAction = 0;
        //     return view('pages.overtime.index',compact('data','statspl','a','b'));
        // }
    }

    public function man()
    {
        $x = route('overtimes.data', ['data' => 'manajer']);
        return view('pages.overtime.index',compact('x'));

        // if(Auth::user()->admin == self::adminDept || Auth::user()->admin == self::headDep){
        //     $statspl = 0;
        //     $data = Overtime::where('corp', Auth::user()->corp)
        //         ->where('dept', Auth::user()->dept)
        //         ->whereNull('hr')
        //         ->where('manajer','diterima')
        //         ->get();//where([['hr',null],['manajer','diterima'],['status',null],['corp', Auth::user()->corp],['dept', Auth::user()->dept]])->get();
        //     // $datas = Overtime::where([['hr',null],['manajer',null],['corp', Auth::user()->corp],['dept', Auth::user()->dept]])->get();
        //     $datas = $data;
        //     $a = $datas->count();
        //     $b = NULL;
        //     return view('pages.overtime.index',compact('data','statspl','a','b','x'));
        // }else{
        //     $statspl = 0;
        //     $data = Overtime::where([['hr',null],['manajer','diterima'],['status',null]])->get();
        //     $datas = Overtime::where([['hr',null],['manajer','diterima'],['status',null]])->get();
        //     $a = NULL;
        //     $b = $datas->count();
        //     return view('pages.overtime.index',compact('data','statspl','a','b','x'));
        // }
    }

    public function hr()
    {
        $x = route('overtimes.data', ['data' => 'hr']);
        return view('pages.overtime.index',compact('x'));

        // if(Auth::user()->admin == 8 || Auth::user()->admin == 9){
        //     $statspl = 0;
        //     $data = Overtime::where([['hr','diterima'],['manajer','diterima'],['status',null],['bisnis', Auth::user()->bisnis],['divisi', Auth::user()->divisi]])->get();
        //     $datas = Overtime::where([['hr',null],['manajer',null],['bisnis', Auth::user()->bisnis],['divisi', Auth::user()->divisi]])->get();
        //     $a = $datas->count();
        //     $b = NULL;
        //     return view('overtime.index',compact('data','statspl','a','b'));
        // }else{
        //     $statspl = 0;
        //     $data = Overtime::where([['hr','diterima'],['manajer','diterima'],['status',null]])->get();
        //     $datas = Overtime::where([['hr',null],['manajer','diterima'],['status',null]])->get();
        //     $a = NULL;
        //     $b = $datas->count();
        //     return view('overtime.index',compact('data','statspl','a','b'));
        // }
    }

    public function end()
    {
        if(Auth::user()->admin == 8 || Auth::user()->admin == 9){
            $statspl = 0;
            $data = Overtime::where([['hr','!=',null],['manajer','diterima'],['status','!=',null],['bisnis', Auth::user()->bisnis],['divisi', Auth::user()->divisi]])->get();
            $datas = Overtime::where([['hr',null],['manajer',null],['bisnis', Auth::user()->bisnis],['divisi', Auth::user()->divisi]])->get();
            $a = $datas->count();
            $b = NULL;
            return view('overtime.index',compact('data','statspl','a','b'));
        }else{
            $statspl = 1;
            $data = Overtime::where([['hr','!=',null],['manajer','diterima'],['status','!=',null]])->get();
            $datas = Overtime::where([['hr',null],['manajer','diterima'],['status',null]])->get();
            $a = NULL;
            $b = $datas->count();
            return view('overtime.index',compact('data','statspl','a','b'));
        }
    }

    public function create()
    {
        $unit = Corp::all();
        $divisi = Dept::all();
        if(Auth::user()->admin == self::headDep){
            $datas = Overtime::where([['hr',null],['manajer',null],['bisnis', Auth::user()->bisnis],['divisi', Auth::user()->divisi]])->get();
            $a = $datas->count();
            return view('pages.overtime.create', compact('unit', 'divisi','a'));
        }elseif(Auth::user()->admin == self::hrStaff || Auth::user()->admin == self::superAdmin){
            $datas = Overtime::where([['hr',null],['manajer','diterima'],['status',null]])->get();
            $b = $datas->count();
            return view('pages.overtime.create', compact('unit', 'divisi','b'));
        }else{
            return view('pages.overtime.create', compact('unit', 'divisi'));
        }
    }

    public function totalJamLembur($jamMulai, $jamAkhir)
    {
        $total = 0;

        $mulai = Carbon::createFromFormat('H:i', $jamMulai);
        $akhir = Carbon::createFromFormat('H:i', $jamAkhir);

        $jamMulai = strtotime($jamMulai);
        $jamAkhir = strtotime($jamAkhir);

        $range1_start = strtotime('12:00');
        $range1_end = strtotime('13:00');

        if ($range1_start >= $jamMulai && $range1_end <= $jamAkhir) {
            $total++;
        }

        $range2_start = strtotime('18:00');
        $range2_end = strtotime('19:00');

        if ($range2_start >= $jamMulai && $range2_end <= $jamAkhir) {
            $total++;
        }

        $range3_start = strtotime('00:00');
        $range3_end = strtotime('01:00');

        if ($range3_start >= $jamMulai && $range3_end <= $jamAkhir) {
            $total++;
        }
        
        $range4_start = strtotime('04:00');
        $range4_end = strtotime('05:00');

        if ($range4_start >= $jamMulai && $range4_end <= $jamAkhir) {
            $total++;
        }

        $totalJam = ($akhir->diffInHours($mulai)) - $total;

        return ($totalJam * 60);
    }

    public function detailcreate($id, Request $request)
    {
        $withAction = $request->withAction;
        $overtime = Overtime::where('nomor', $id)->get();
        $data = Detail::where('splid', $id)->get();
        $employee = Staff::where([['dept', Auth::user()->dept],['corp',Auth::user()->corp]])->get();
        $idovertime = $id;

        $tanggal = Carbon::parse($overtime[0]->tanggalspl);
        $tglSplSebelumnya['1hari'] = $tanggal->subDay()->isoFormat('D MMMM YYYY');
        $tglSplSebelumnya['2hari'] = $tanggal->subDay(1)->isoFormat('D MMMM YYYY');

        if(Auth::user()->admin == self::headDep){
            $datas = Overtime::where([['hr',null],['manajer',null],['corp', Auth::user()->corp],['dept', Auth::user()->dept]])->get();
            $a = $datas->count();
            return view('pages.overtime.detailcreate', compact('overtime', 'data', 'employee', 'idovertime','a', 'withAction', 'tglSplSebelumnya'));
        }elseif(Auth::user()->admin == self::hrStaff || Auth::user()->admin == self::superAdmin){
            $datas = Overtime::where([['hr',null],['manajer','diterima'],['status',null]])->get();
            $b = $datas->count();
            return view('pages.overtime.detailcreate', compact('overtime', 'data', 'employee', 'idovertime','b', 'withAction', 'tglSplSebelumnya'));
        }else{
            return view('pages.overtime.detailcreate', compact('overtime', 'data', 'employee', 'idovertime', 'withAction', 'tglSplSebelumnya'));
        }    
    }

    public function store(Request $request)
    {
        try {
             Overtime::create([
                'nomor'     => $request->nomor,
                // 'hari'      => $request->hari,
                // 'hspl'      => $request->hspl,
                // 'bspl'      => $request->bspl,
                // 'thspl'     => $request->thspl,
                'tanggalspl'=> $request->date,
                'bisnis'    => $request->bisnis,
                'divisi'    => $request->divisi,
                'waktu'     => $request->waktu,
                'pemohon'   => $request->pemohon,
                'manajer'   => $request->manajer,
                'hr'        => $request->hr,
                'catatan'   => $request->catatan,
                'status'    => $request->status,
                'corp'      => Corp::where('name', $request->bisnis)->first()->id,
                'dept'      => Dept::where('nama', $request->divisi)->first()->id,
            ]); 
            $id = $request->nomor;
            return redirect(route('overtimes.detailcreate', ['id' => $id]));
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function ca()
    {
        $unit = Unit::all();
        if(Auth::user()->admin == 2 || Auth::user()->admin == 3){
            $datas = Overtime::where([['hr',null],['manajer','diterima'],['status',null]])->get();
            $b = $datas->count();
            return view('overtime.ca', compact('unit','b'));
        }else{
            return view('overtime.ca', compact('unit'));
        }         
    }

    public function caprint(Request $request)
    {
        $data =  DB::table('overtimes')
        ->join('details', 'details.splid', '=', 'overtimes.nomor')
        ->where([['hspl', $request->hari],['bspl', $request->bulan],['thspl', $request->tahun],['bisnis', $request->bisnis],['hr', 'diterima'],['makan','!=','']])
        ->select('divisi as a', DB::raw("COUNT(divisi) as b"))
        ->groupBy('divisi')
        ->get();

        $datamenu =  DB::table('overtimes')
        ->join('details', 'details.splid', '=', 'overtimes.nomor')
        ->where([['hspl', $request->hari],['bspl', $request->bulan],['thspl', $request->tahun],['bisnis', $request->bisnis],['hr', 'diterima'],['makan','!=','']])
        ->select('divisi','makan', DB::raw("COUNT(makan) as jumlah"))
        ->groupBy('divisi','makan')
        ->orderBy('divisi')
        ->get();

        $bisnis = $request->bisnis;
        $hari   = $request->hari;
        $bulan  = $request->bulan;
        $tahun  = $request->tahun;
        $pdf    = PDF::loadView('overtime.caprint', compact('data','bisnis','hari','bulan','tahun','datamenu'))->setPaper('a4', 'potrait');
        return $pdf->stream();
    }

    public function edit(Request $request,$id)
    {
        $data = Overtime::find($id);
        $emailadmin = User::where([['divisi',$request->divisi],['bisnis',$request->bisnis],['admin',5]])->get('email')->first();
        $emailmanajer = User::where([['divisi',$request->divisi],['bisnis',$request->bisnis],['admin',4]])->get('email')->first();
        //$emailhr = 'triacahyaramadhan@hotmail.com';

        try {
            $data->update([
                'manajer'   => $request->manajer,
                'nmmanajer' => $request->nmmanajer,
                'hr'        => $request->hr,
                'nmhr'      => $request->nmhr,
                'status'    => $request->status,
                'catatan'   => $request->catatan,
                'waktu'   => $request->waktu,
                'tanggalspl' => $request->date,
                // 'hari'   => $request->hari,
                // 'hspl'   => $request->hspl,
                // 'bspl'   => $request->bspl,
                // 'thspl'   => $request->thspl,
            ]);

            $peoples = Detail::where('splid', $data->nomor)->get();
            //$user = $emailhr;

            $details = [
                'greeting'  => 'SPL ' . $request->nomor,
                'head'      => 'Surat Perintah Lembur (SPL) ini telah diproses dengan status:',
                'line1'     => 'Hari Lembur     : ' . $request->date,
                'line2'     => 'Approve Manager : ' . $request->manajer,
                'line3'     => 'Approve HR      : ' . $request->hr,
                'line4'     => 'Status SPL      : ' . $request->status,
                'line5'     => 'Catatan         : ' . $request->catatan,
                'footnote'  =>
                'Note :
                Jika SPL ditolak, maka departemen pemohon yang bersangkutan, harus membuat SPL baru.',
                // 'order_id' => 102
            ];

            // dd($peoples);

            Mail::to($emailadmin->email)->send(
                new AdminSPLNotification($details, $peoples)
            );

            // Notification::route('mail', 'gopin.ipin@gmail.com')->notify(new ApproveNotification($details));
            // Notification::route('mail', $emailadmin->email)->notify(new ApproveNotification($details));
            // Notification::route('mail', $emailmanajer->email)->notify(new ApproveNotification($details));

            // dd('send');
            return redirect(route('overtimes.index'));   
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function edits(Request $request,$id)
    {
        $data = Overtime::find($id);
        
            $cariuser1 = User::where([['divisi',$request->divisi],['bisnis',$request->bisnis]])->get('email')->first();
            $cariuser2 = User::where([['divisi',$request->divisi],['bisnis',$request->bisnis]])->get('email')->last();
            dd($cariuser1->email,$cariuser2->email);
       
    }

    public function print($id)
    {
        $overtime = Overtime::where('nomor',$id)->get();
        $detail = Detail::where('splid',$id)->get();
        $makan = [];
        foreach($detail as $row) {
            $makan[$row->makan] = isset($makan[$row->makan]) ? $makan[$row->makan] + 1 : 1;
        }
        // dd($makan);
        // dd($overtime);
        $tanggal = Carbon::parse($overtime[0]->tanggalspl);
        $tglSplSebelumnya['1hari'] = $tanggal->subDay()->isoFormat('dddd, D MMMM YYYY');
        $tglSplSebelumnya['2hari'] = $tanggal->subDay(1)->isoFormat('dddd, D MMMM YYYY');

        $pdf = PDF::loadView('pages.overtime.print', compact('overtime','detail', 'makan', 'tglSplSebelumnya'))->setPaper('a4', 'landscape');
        // return view('pages.overtime.print', compact('overtime','detail'));
        return $pdf->stream();
    }

    public function insert(Request $request)
    {
        $employee = Staff::where('nik',$request->nik)->first();
        $data = Overtime::where('nomor', $request->nomor)->get();
        //$menitawal = substr($request->mulai,3,2);
        //$menitakhir = substr($request->akhir,3,2);
        //$jamawal = substr($request->mulai,0,2) * 60 + $menitawal;
        //$jamakhir = substr($request->akhir,0,2) * 60 + $menitakhir;
        $mulai = explode(':',$request->mulai);
        $akhir = explode(':',$request->akhir);

        // if($akhir[0] > $mulai[0])
        // {
        //     $menitawal = $mulai[1];
        //     $menitakhir = $akhir[1];
        //     $jamawal = $mulai[0] * 60 + $menitawal;
        //     $jamakhir = $akhir[0] * 60 + $menitakhir;
        //     $total = $jamakhir - $jamawal;
        // }else{
        //     $menitawal = $mulai[1];
        //     $menitakhir = $akhir[1];
        //     $jamawal = (24 - $mulai[0]) * 60 - $menitawal;
        //     $jamakhir = $akhir[0] * 60 + $menitakhir;
        //     $total = $jamakhir + $jamawal;
        // }

        $total = $this->totalJamLembur($request->mulai, $request->akhir);
        
        try {
            // if($total >= 240){
            //     Detail::create([
            //         'splid'     => $request->nomor,
            //         'nama'      => $employee->name,
            //         'nik'       => $request->nik,
            //         'pekerjaan' => $request->pekerjaan,
            //         'jabatan'   => $employee->jabatan,
            //         'pekerjaan' => $request->pekerjaan,
            //         'spk'       => $request->spk,
            //         'nospk'     => $request->nospk,
            //         'hasil2'     => $request->hasil2,
            //         'persen2'    => $request->persen2,
            //         'hasil'     => $request->hasil,
            //         'persen'    => $request->persen,
            //         'mulai'     => $request->mulai,
            //         'akhir'     => $request->akhir,
            //         'total'     => $total,
            //         'makan'     => $request->makan
            //     ]);
            // }else{
                Detail::create([
                    'splid'     => $request->nomor,
                    'nama'      => $employee->name,
                    'nik'       => $request->nik,
                    'pekerjaan' => $request->pekerjaan,
                    'jabatan'   => $employee->jabatan,
                    'pekerjaan' => $request->pekerjaan,
                    'spk'       => $request->spk,
                    'nospk'     => $request->nospk,
                    'hasil2'     => $request->hasil2,
                    'persen2'    => $request->persen2,
                    'hasil'     => $request->hasil,
                    'persen'    => $request->persen,
                    'mulai'     => $request->mulai,
                    'akhir'     => $request->akhir,
                    'total'     => $total,
                    'makan'     => $request->makan, // ''
                ]);
            // }

            // alert()->toast('Data karyawan pada SPL telah berhasil ditambahkan','success');
            return redirect()->back();
        } catch (\Exception $e) {
            dd(['error' => $e->getMessage()]);
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function deletedetail($id)
    {
        $data = Detail::find($id);
        try
        {
            $data->delete();
                // alert()->toast('Data karyawan pada SPL telah dihapus','warning');
                return redirect()->back();
        }
        catch (\Exception $e)
        {
            // alert()->toast('Data tidak ditemukan','error');
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        $data = Overtime::find($id);
        $detail = Detail::where('splid', $data->nomor);
        try
        {
            $data->delete();
            $detail->delete();
                // alert()->toast('SPL telah dihapus','warning');
                return redirect()->back();
        }
        catch (\Exception $e)
        {
            // alert()->toast('Data tidak ditemukan','error');
            return redirect()->back();
        }
    }

    public function formSpl(Request $request)
    {
        if (!$request->date) {
            $now = Carbon::now();
            $date = $now->format('Y-m-d');
        } 
        else {
            $date = $request->date;
        }

        // $date = '2023-06-27';

        $data = Overtime::with(['detail','division','pengajuanDana.detail'])->whereHas('detail')->where('tanggalspl', $date)->get();

        $detail = Overtime::getCount($data);
        // dd($detail);

        return view('pages.overtime.form', compact('data','detail','date'));
    }

    public function insertPengajuanDana(Request $request, $id)
    {
        $validate = $request->validate([
            'keterangan' => ['required'],
            'jumlah' => ['required', 'integer'],
        ]);

        if (!$validate) {
            return redirect()->back();
        }
        
        if($id === '0') {
            $pengajuan = PengajuanDana::create(
            [
                'tanggal' => $request->tanggal,
            ]);

            $id = $pengajuan->id;
        }

        PengajuanDanaDetail::create(
        [
            'id_pengajuan_dana' => $id,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->back();
    }

    public function viewFormPengajuan(Request $request, $tanggalspl)
    {
        $data = Overtime::with(['detail','division','pengajuanDana.detail'])->whereHas('detail')->where('tanggalspl', $tanggalspl)->get();
        $detail = Overtime::getCount($data);

        // dd($detail);
        $pdf = PDF::loadView('pages.overtime.print-pengajuan', compact('detail','tanggalspl'))->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function viewFormDetail(Request $request, $tanggalspl)
    {
        // $data = Overtime::with(['detail','division','pengajuanDana.detail'])->whereHas('detail')->where('tanggalspl', $tanggalspl)->get();
        $data = Division::with(['overtime' => function ($query) use ($tanggalspl) {
            $query->where('tanggalspl', '=', $tanggalspl);
        }])
        ->has('overtime.detail', '>', 0)
        ->get();    

        return view('pages.overtime.form-detail', compact('data', 'tanggalspl'));
    }

    public function viewPrintDetail(Request $request, $tanggalspl)
    {
        // $data = Overtime::with(['detail','division','pengajuanDana.detail'])->whereHas('detail')->where('tanggalspl', $tanggalspl)->get();
        $data = Division::with(['overtime' => function ($query) use ($tanggalspl) {
            $query->where('tanggalspl', '=', $tanggalspl);
        }])
        ->has('overtime.detail', '>', 0)
        ->get();    

        $pdf = PDF::loadView('pages.overtime.print-detail', compact('data','tanggalspl'))
            ->setPaper('a4', 'potrait');

        return $pdf->stream();
    }

    public function postFormDetail(Request $request)
    {
        // dd($request);
        $people = $request->id;

        $rules = [];

        foreach ($people as $person => $id) {
            $rules['masuk.' . $id] = 'nullable|date_format:H:i:s';
            $rules['pulang.' . $id] = 'nullable|date_format:H:i:s';

            $detail[$id] = Detail::find($id);
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Validation failed, handle the error
            $errors = $validator->errors();
            return redirect()->back();
        } else {
            foreach ($detail as $key => $value) {
                $masuk = $request->input('masuk.' . $key);
                $pulang = $request->input('pulang.' . $key);
                $is_umak_cut = $request->input('is_umak_cut.' . $key);

                $value->update([
                    'masuk' => $masuk,
                    'pulang' => $pulang,
                    'is_umak_cut' => $is_umak_cut
                ]);
            }

            return redirect()->back();
        }
    }
}
