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
use JWTHelper;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $type = $data;
        if($data == 'all') {
            $data = Overtime::with(['detail'])->where([['corp', Auth::user()->corp],['dept', Auth::user()->dept]])->get();
            if(Auth::user()->email == "mail.dwidajayatama@gmail.com")
            {
                $data = Overtime::with(['detail'])->get(); //all();
            }
        }
        else if($data == 'manajer') {
            // dd('');
            if(Auth::user()->admin == self::adminDept || Auth::user()->admin == self::headDep){
                $data = Overtime::with('detail')
                    ->where('corp', Auth::user()->corp)
                    ->where('dept', Auth::user()->dept)
                    ->whereIn('hr', ['revisi'])
                    ->orWhereNull('hr')
                    ->where('manajer','diterima')
                    ->get();
            }else{
                $data = Overtime::with('detail')
                    ->where('manajer', 'diterima')
                    ->whereIn('hr', ['revisi'])
                    ->orWhereNull('hr')
                    ->whereNull('status')
                    ->get();

                    
            }
        }
        else if($data == 'today') {
            if(Auth::user()->admin == self::adminDept || Auth::user()->admin == self::headDep){
                $data = Overtime::with(['detail'])->where([['hr',null],['manajer',null],['corp', Auth::user()->corp],['dept', Auth::user()->dept]])->where('tanggalspl', Carbon::today())->get();
            }else{
                $data = Overtime::with(['detail'])->where([['hr',null],['manajer',null]])->where('tanggalspl', Carbon::today())->get();
            }
        }
        else if($data == 'hr') {
            if(Auth::user()->admin == self::adminDept || Auth::user()->admin == self::headDep){
                $data = Overtime::with(['detail'])->where([['hr','diterima'],['manajer','diterima'],['corp', Auth::user()->corp],['dept', Auth::user()->dept]])->get();
            }else{
                $data = Overtime::with(['detail'])->where([['hr','diterima'],['manajer','diterima']])->get();
            }
        }
        $statspl = 0;

        if ($request->ajax()) {
            $data = $data->filter(function($item) {
                if(!count($item->detail) < 1 ) {
                    // dd($item->detail);
                    return $item;
                }
            });

            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('hari', function ($row) {
                    $getTanggal = Carbon::parse($row->tanggalspl)->locale('id');
                    $getTanggal->settings(['formatFunction' => 'translatedFormat']);
                    return $getTanggal->format('l, j F Y');
                })
                ->addColumn('nomor', function ($row) {
                    $nomor = $row->nomor;
                    if($row->hr == 'revisi') {
                        $nomor .= ' <font style="color:red;">[Revisi]</font>';
                    }
                    return $nomor;
                })
                ->addColumn('action', function ($row) use ($statspl, $type) {
                    $url = route('overtimes.print', ['id' => $row->nomor]);        
                    $btn = '<a target="_blank" href="'.$url.'" class="btn btn-success btn-sm" data-toggle="tooltip" title="Cetak"><i class="fa fa-print"></i></a>';
                    if($type != 'all') {
                        if(Auth::user()->admin == self::hrStaff || Auth::user()->admin == self::superAdmin || (Auth::user()->admin == self::headDep && !$row->hr)){
                            $url = route('overtimes.detailcreate', ['id' => $row->nomor,'withAction' => 1]);
                            $btn .= '&nbsp;&nbsp;<a href="'.$url.'" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Approve"><i class="fa fa-check"></i></a>';
                        }
                    }
                    if($row->hr == 'revisi' && $row->manajer == null) {
                        $url = route('overtimes.detailcreate', ['id' => $row->nomor, 'revisi' => 1]);
                        $btn .= '&nbsp;&nbsp;<a href="'.$url.'" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Ubah"><i class="fa fa-edit"></i></a>';
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
                ->rawColumns(['action','hari','nomor'])
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
        $revisi = $request->revisi;
        $withAction = $request->withAction;
        $overtime = Overtime::where('nomor', $id)->first();
        $data = Detail::where('splid', $id)->get();
        $employee = Staff::where([['dept', Auth::user()->dept],['corp',Auth::user()->corp]])->get();
        $idovertime = $id;

        $tanggal = Carbon::parse($overtime->tanggalspl);
        $tglSplSebelumnya['1hari'] = $tanggal->subDay()->isoFormat('D MMMM YYYY');
        $tglSplSebelumnya['2hari'] = $tanggal->subDay(1)->isoFormat('D MMMM YYYY');

        if(Auth::user()->admin == self::headDep){
            $datas = Overtime::where([['hr',null],['manajer',null],['corp', Auth::user()->corp],['dept', Auth::user()->dept]])->get();
            $a = $datas->count();
            return view('pages.overtime.detailcreate', compact('overtime', 'data', 'employee', 'idovertime','a', 'withAction', 'tglSplSebelumnya','revisi'));
        }elseif(Auth::user()->admin == self::hrStaff || Auth::user()->admin == self::superAdmin){
            $datas = Overtime::where([['hr',null],['manajer','diterima'],['status',null]])->get();
            $b = $datas->count();
            return view('pages.overtime.detailcreate', compact('overtime', 'data', 'employee', 'idovertime','b', 'withAction', 'tglSplSebelumnya','revisi'));
        }else{
            return view('pages.overtime.detailcreate', compact('overtime', 'data', 'employee', 'idovertime', 'withAction', 'tglSplSebelumnya','revisi'));
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
                'shift'     => $request->shift,
                'pemohon'   => $request->pemohon,
                'manajer'   => $request->manajer,
                'hr'        => $request->hr,
                'catatan'   => $request->catatan,
                'status'    => $request->status,
                'corp'      => Corp::where('name', $request->bisnis)->first()->id,
                'dept'      => Dept::where('nama', $request->divisi)->first()->id,
                'created_by' => Auth::user()->id,
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
        $spl = Overtime::find($id);
        // $emailadmin = User::where([['divisi',$request->divisi],['bisnis',$request->bisnis],['admin',5]])->get('email')->first();
        $emailadmin = Auth::user()->email;
        //$emailhr = 'triacahyaramadhan@hotmail.com';
        // dd($request->input());

        $input = [];
        $input['manajer'] = $input['nmmanajer'] = $input['hr'] = $input['nmhr'] = $input['status'] = null;

        foreach($request->input() as $key => $data) {
            if($data['name'] == 'nomor') {
                $input['nomor'] = $data['value'];
            }
            else if($data['name'] == 'bisnis') {
                $input['bisnis'] = $data['value'];
            }
            else if($data['name'] == 'divisi') {
                $input['divisi'] = $data['value'];
            }
            else if($data['name'] == 'waktu') {
                $input['waktu'] = $data['value'];
            }
            else if($data['name'] == 'shift') {
                $input['shift'] = $data['value'];
            }
            else if($data['name'] == 'date') {
                $input['date'] = $data['value'];
            }
            else if($data['name'] == 'catatan') {
                $input['catatan'] = $data['value'];
            }
            else if($data['name'] == 'manajer') {
                $input['manajer'] = $data['value'];
            }
            else if($data['name'] == 'nmhr') {
                $input['nmhr'] = $data['value'];
            }
            else if($data['name'] == 'nmmanajer') {
                $input['nmmanajer'] = $data['value'];
            }
            else if($data['name'] == 'status') {
                $input['status'] = $data['value'];
            }
            else if($data['name'] == 'hr') {
                $input['hr'] = $data['value'];
            }
            else if($data['name'] == 'revisi') {
                $input['revisi'] = $data['value'];
            }
        }
        // dd($input);

        $emailmanajer = User::where([['divisi',$input['divisi']],['bisnis',$input['bisnis']],['admin',4]])->get('email')->first();
        
        try {

            $kontakManajer = Staff::where(['role' => 4, 'divisi' => $input['divisi'], 'bisnis' => $input['bisnis']])->first();
            
            if(!$kontakManajer) {
                return response()->json([
                    "status" => false,
                    "reason" => "Kontak Atasan Tidak Ada Dalam Database\nSilahkan Hub Divisi Multimedia",
                ]);
            }

            $spl->update([
                'status'    => $input['status'],
                'catatan'   => $input['catatan'],
                'waktu'   => $input['waktu'],
                'shift'   => $input['shift'],
                'tanggalspl' => $input['date'],
            ]);

            if($input['revisi'] == 1)
            {
                $spl->update([
                    'manajer'   => null,
                    'nmmanajer' => null,
                ]);
            }
            else 
            {
                if(isset($input['manajer'])) {
                    $spl->update([
                        'manajer'   => $input['manajer'],
                        'nmmanajer' => $input['nmmanajer'],
                    ]);
                }
    
                if(isset($input['hr'])) {
                    $spl->update([
                        'hr'        => $input['hr'],
                        'nmhr'      => $input['nmhr']
                    ]);
                    if($input['hr'] == 'revisi') {
                        $spl->update([
                            'manajer'   => null,
                            'nmmanajer' => null,
                        ]);
                    }
                }
            }

            $detail = Detail::where('splid', $spl->nomor)->get();
            foreach($detail as $row) {
                if($row->pulang){
                    $is_umak_cut = $this->umak($row->pulang, $input['waktu']);
                    $row->update([
                        'is_umak_cut' => $is_umak_cut,
                    ]);
                }
                else {
                    $row->update([
                        'is_umak_cut' => null,
                    ]);
                }

                $row->update([
                    'waktu' => $input['waktu'],
                ]);
            }

            if(Auth::user()->admin == 5) {
                $peoples = Detail::where('splid', $spl->nomor)->get();
                //$user = $emailhr;
    
                $details = [
                    'greeting'  => 'SPL ' . $input['nomor'],
                    'head'      => 'Surat Perintah Lembur (SPL) ini telah diproses dengan status:',
                    'line1'     => 'Hari Lembur     : ' . $input['date'],
                    'line2'     => 'Approve Manager : ' . $input['manajer'],
                    'line3'     => 'Approve HR      : ' . $input['hr'],
                    'line4'     => 'Status SPL      : ' . $input['status'],
                    'line5'     => 'Catatan         : ' . $input['catatan'],
                    'footnote'  =>
                    'Note :
                    Jika SPL ditolak, maka departemen pemohon yang bersangkutan, harus membuat SPL baru.',
                    // 'order_id' => 102
                ];
    
                // dd($peoples);
    
                Mail::to($emailadmin)->send(
                    new AdminSPLNotification($details, $peoples)
                );
            }

            // Notification::route('mail', 'gopin.ipin@gmail.com')->notify(new ApproveNotification($details));
            // Notification::route('mail', $emailadmin->email)->notify(new ApproveNotification($details));
            // Notification::route('mail', $emailmanajer->email)->notify(new ApproveNotification($details));

            // dd('send');
            if(!isset($input['manajer']) && !isset($input['hr']))
            {
                $ovt = [
                    'nomor' => $input['nomor'],
                    'atasan' => $kontakManajer->id,
                ];
    
                $token = JWTHelper::encode(['overtimes' => $ovt], JWTHelper::jwtSecretKey, JWTHelper::algoJwt);
    
                $link = route('overtimes.app', ['token' => $token]);
    
                return response()->json([
                    "status" => true,
                    "data" => [
                        "type" => "admin",
                        "nomor" => $input['nomor'],
                        "atasan" => $kontakManajer,
                        "link" => $link,
                    ]
                ]);
            }

            $u = User::where('id', $spl->created_by)->first();
            $userOvertime = Staff::where(['role' => 5, 'dept' => $u->dept, 'corp' => $u->corp])->first();
// dd($u);
            return response()->json([
                "status" => true,
                "data" => [
                    "type" => (isset($input['manajer']) ? "manajer" : "hr"),
                    "revision" => (isset($input['hr']) && $input['hr'] == "revisi") ? true : false,
                    "nomor" => $input['nomor'],
                    "atasan" => $kontakManajer,
                    "admin" => $userOvertime,
                ]
            ]);
            
            return redirect(route('overtimes.index'));   
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return response()->json([
                "status" => false,
                "reason" => $e->getMessage()
            ]);
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
        $overtime = Overtime::where('nomor',$id)->first();
        $detail = Detail::where('splid',$id)->get();
        $makan = [];
        foreach($detail as $row) {
            $makan[$row->makan] = isset($makan[$row->makan]) ? $makan[$row->makan] + 1 : 1;
        }
        // dd($makan);
        // dd($overtime);
        $tanggal = Carbon::parse($overtime->tanggalspl);
        $tglSplSebelumnya['1hari'] = $tanggal->subDay()->isoFormat('dddd, D MMMM YYYY');
        $tglSplSebelumnya['2hari'] = $tanggal->subDay(1)->isoFormat('dddd, D MMMM YYYY');

        $pdf = PDF::loadView('pages.overtime.print', compact('overtime','detail', 'makan', 'tglSplSebelumnya'))->setPaper('a4', 'landscape');
        // return view('pages.overtime.print', compact('overtime','detail'));
        return $pdf->stream();
    }

    public function insert(Request $request, $id)
    {
        $overtime = Overtime::where('nomor', $id)->first();
        // dd($overtime);
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
                    'jabatan'   => $employee->position,
                    'pekerjaan' => $request->pekerjaan,
                    'spk'       => $request->spk,
                    'nospk'     => $request->nospk,
                    'hasil2'    => $request->hasil2,
                    'persen2'   => $request->persen2,
                    'hasil'     => $request->hasil,
                    'persen'    => $request->persen,
                    'mulai'     => $request->mulai,
                    'akhir'     => $request->akhir,
                    'total'     => $total,
                    'makan'     => $request->makan, // ''
                    'waktu' => $overtime->waktu,
                ]);
            // }

            // alert()->toast('Data karyawan pada SPL telah berhasil ditambahkan','success');
            return redirect()->back();
            // return response()->json([
            //     "status" => true,
            //     "data" => [
            //         "nomor" => $request->nomor,
            //     ]
            // ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "reason" => $e->getMessage()
            ]);
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

        $data = Overtime::with(['detail','division','pengajuanDana.detail'])->whereHas('detail')->where('tanggalspl', $date)->where(['manajer' => 'diterima', 'hr' => 'diterima'])->get();


        $detail = Overtime::getCountWithGroup($data);
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
        $data = Overtime::with(['detail','division','pengajuanDana.detail'])->whereHas('detail')->where('tanggalspl', $tanggalspl)->get()->sortBy('division.kode');
        $detail = Overtime::getCountWithGroup($data);

        // dd($detail);
        $pdf = PDF::loadView('pages.overtime.print-pengajuan', compact('detail','tanggalspl'))->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function viewFormDetail(Request $request, $tanggalspl)
    {
        if($request->save == 'Simpan') {
            // return redirect()->route('overtimes.post.form-detail', ['tanggalspl', $tanggalspl]);
            // dd($request);
        }
        // $data = Overtime::with(['detail','division','pengajuanDana.detail'])->whereHas('detail')->where('tanggalspl', $tanggalspl)->get();
        $data = Division::with(['overtime' => function ($query) use ($tanggalspl) {
            $query->where('tanggalspl', '=', $tanggalspl);
        }])
        ->has('overtime.detail', '>', 0)
        ->orderBy('kode')
        ->get();

        $divisi = [];
        foreach($data as $row) {
            if(!isset($divisi[$row->nama])) {
                $divisi[$row->nama] = $row->id;
            }
        }

        $filter = $request->filter;
        // dd($request->filter);
        if($request->filter != '0' && $request->filter) {
            $data = $data->where('id', $filter);
        }

        // $data = Overtime::getCountWithGroup($data);

        return view('pages.overtime.form-detail', compact('data', 'tanggalspl','divisi', 'filter'));
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
            $rules['masuk.' . $id] = 'nullable|date_format:H:i';
            $rules['pulang.' . $id] = 'nullable|date_format:H:i';

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

                $value->update([
                    'masuk' => $masuk,
                    'pulang' => $pulang,
                ]);

                $is_umak_cut = ($request->input('is_umak_cut.' . $key) === null) ? $this->umak($pulang, $value->waktu) : $request->input('is_umak_cut.' . $key);

                // if($key == 24) {
                //     dd($is_umak_cut);
                // }

                if($pulang) {
                    $value->update([
                        'is_umak_cut' => $is_umak_cut
                    ]);
                }
                else {
                    $value->update([
                        'is_umak_cut' => null
                    ]);
                }

                // $is_umak_cut = $request->input('is_umak_cut.' . $key);
            }

            return redirect()->back();
        }
    }

    function umak($pulang, $waktu)
    {
        $is_umak_cut = 1;
        if($waktu == "Hari Libur") {
            $is_umak_cut = 0;
        }
        else {
            if ($pulang) {
                $waktuPulang = Carbon::createFromFormat('H:i', $pulang);
                $batasWaktu = Carbon::createFromTime(21, 59, 0);

                if ($waktuPulang->greaterThan($batasWaktu)) {
                    $is_umak_cut = 0;
                }
            }
        }

        return $is_umak_cut;
    }

    public function formImport(Request $request)
    {
        return view('pages.overtime.import');
    }

    public function importXlsStaff(Request $request)
    {
        setlocale(LC_TIME, 'id_ID'); // Set locale ke bahasa Indonesia
        $the_file = $request->file('file');

        $filePath = $the_file->getRealPath();

        // $password = Hash::make("hris1234");
        try{
            $total = 0;
            $spreadsheet = IOFactory::load($filePath);
            $sheet        = $spreadsheet->getActiveSheet();
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range    = range( 3, $row_limit );
            $column_range = range( 'AV', $column_limit );
            $startcount = 8;
            $data = array();
            $item = [];
            $add = [];

            $divisi = [];
            $deptss = Dept::all();
            foreach ($deptss as $row) {
                $deptName = Str::lower($row->kode);
                $divisi[$deptName] = $row->id;
            }
            // dd($row_range);
            $number = 3;
            $error = [];

            foreach ( $row_range as $row ) {
                $number++;

                $div = trim(Str::lower($sheet->getCell( 'E' . $row )->getValue()));
                $kode = substr($div, 0, 4);
                if (!isset($divisi[$kode])) {
                    $divisi[$kode] = 34;
                }

                // dd($sheet->getCell( 'C' . $row )->getValue());
                $created_at = $updated_at = Carbon::now()->format('Y-m-d H:i:s');

                $value = $sheet->getCell( 'G' . $row )->getValue();
                $tgl = explode(' ',$value);

                if(count($tgl) >= 3) {
                    switch(Str::lower($tgl[1])) {
                        case 'januari' : $bln = '01'; break;
                        case 'februari' : $bln = '02'; break;
                        case 'maret' : $bln = '03'; break;
                        case 'april' : $bln = '04'; break;
                        case 'mei' : $bln = '05'; break;
                        case 'juni' : $bln = '06'; break;
                        case 'juli' : $bln = '07'; break;
                        case 'agustus' : $bln = '08'; break;
                        case 'september' : $bln = '09'; break;
                        case 'oktober' : $bln = '10'; break;
                        case 'november' : $bln = '11'; break;
                        case 'desember' : $bln = '12'; break;
                    }
                    $joinDate = Carbon::createFromFormat('d-m-Y', $tgl[0].'-'.$bln.'-'.$tgl[2])->locale('id_ID')->format('Y-m-d');
                }
                else {
                    $joinDate = null;
                }


                $value = $sheet->getCell( 'H' . $row )->getValue();
                $tgl = explode(' ',$value);

                if(count($tgl) >= 3) {
                    switch(Str::lower($tgl[1])) {
                        case 'januari' : $bln = '01'; break;
                        case 'februari' : $bln = '02'; break;
                        case 'maret' : $bln = '03'; break;
                        case 'april' : $bln = '04'; break;
                        case 'mei' : $bln = '05'; break;
                        case 'juni' : $bln = '06'; break;
                        case 'juli' : $bln = '07'; break;
                        case 'agustus' : $bln = '08'; break;
                        case 'september' : $bln = '09'; break;
                        case 'oktober' : $bln = '10'; break;
                        case 'november' : $bln = '11'; break;
                        case 'desember' : $bln = '12'; break;
                    }
                    $contractDate = Carbon::createFromFormat('d-m-Y', $tgl[0].'-'.$bln.'-'.$tgl[2])->locale('id_ID')->format('Y-m-d');
                }
                else {
                    $contractDate = null;
                }

                switch (strtoupper($sheet->getCell( 'J' . $row )->getValue())) {
                    case 'SMP':
                        $pendidikan = 'SMP';
                        $id_stut = 1;
                        break;
                    case 'SMA':
                        $pendidikan = 'SMA';
                        $id_stut = 2;
                        break;
                    case 'SMK':
                        $pendidikan = 'SMK';
                        $id_stut = 2;
                        break;
                    case 'D1':
                        $pendidikan = 'D1';
                        $id_stut = 3;
                        break;
                    case 'D3':
                        $pendidikan = 'D3';
                        $id_stut = 4;
                        break;
                    case 'STIEK':
                        $pendidikan = 'STIEK';
                        $id_stut = 4;
                        break;    
                    case 'D4':
                        $pendidikan = 'D4';
                        $id_stut = 5;
                        break;
                    case 'S1':
                        $pendidikan = 'S1';
                        $id_stut = 6;
                        break;
                    case 'S2':
                        $pendidikan = 'S2';
                        $id_stut = 7;
                        break;
                    case 'S3':
                        $pendidikan = 'S3';
                        $id_stut = 8;
                        break;
                    case 'SD':
                        $pendidikan = 'SD';
                        $id_stut = 9;
                        break;
                    case 'MA':
                        $pendidikan = 'MA';
                        $id_stut = 10;
                    break;
                    case 'MTS':
                        $pendidikan = 'MTs';
                        $id_stut = 11;
                    break;
                    case 'STM':
                        $pendidikan = 'STM';
                        $id_stut = 12;
                    break;
                    case 'SMU':
                        $pendidikan = 'SMU';
                        $id_stut = 13;
                    break;
                    case 'PAKET C':
                        $pendidikan = 'PAKET C';
                        $id_stut = 14;
                    break;
                    case 'PKBM':
                        $pendidikan = 'PKBM';
                        $id_stut = 15;
                    break;
                    case 'PAKET B':
                        $pendidikan = 'PAKET B';
                        $id_stut = 16;
                    break;
                }

                switch(Str::lower($sheet->getCell( 'I' . $row )->getValue())){
                    case 'islam' : $agama = 'Islam'; $religion = 6; break;
                    case 'budha' : $agama = 'Budha'; $religion = 3; break;
                    case 'katolik' : $agama = 'Katolik'; $religion = 2; break;
                    case 'kong hu cu' : $agama = 'Kong Hu Cu'; $religion = 5; break;
                    case 'kristen' : $agama = 'Kristen'; $religion = 7; break;
                    case 'protestan' : $agama = 'Protestan'; $religion = 1; break;
                    case 'hindu' : $agama = 'Hindu'; $religion = 4; break;
                }


                $value = $sheet->getCell( 'M' . $row )->getValue();
                $tgl = explode(' ',$value);

                if(count($tgl) >= 3) {
                    switch(Str::lower($tgl[1])) {
                        case 'januari' : $bln = '01'; break;
                        case 'februari' : $bln = '02'; break;
                        case 'maret' : $bln = '03'; break;
                        case 'april' : $bln = '04'; break;
                        case 'mei' : $bln = '05'; break;
                        case 'juni' : $bln = '06'; break;
                        case 'juli' : $bln = '07'; break;
                        case 'agustus' : $bln = '08'; break;
                        case 'september' : $bln = '09'; break;
                        case 'oktober' : $bln = '10'; break;
                        case 'november' : $bln = '11'; break;
                        case 'desember' : $bln = '12'; break;
                    }
                    $tglIjazah = Carbon::createFromFormat('d-m-Y', $tgl[0].'-'.$bln.'-'.$tgl[2])->locale('id_ID')->format('Y-m-d');
                }
                else {
                    $tglIjazah = null;
                }

                switch(Str::lower($sheet->getCell( 'T' . $row )->getValue())){
                    case 'tetap' : $status = 1; $status_char = 'Tetap'; break;
                    case 'tlh' : $status = 2; $status_char = 'TLH'; break;
                    case 'harian' : $status = 2; $status_char = 'Harian'; break;
                    case 'kontrak' : $status = 3; $status_char = 'Kontrak'; break;
                    case 'percobaan' : $status = 4; $status_char = 'Percobaan'; break;
                    default : $status = 3; $status_char = 'Kontrak'; break;
                }

                $value = $sheet->getCell( 'AC' . $row )->getValue();
                $tgl = explode(' ',$value);

                if(count($tgl) >= 3) {
                    switch(Str::lower($tgl[1])) {
                        case 'januari' : $bln = '01'; break;
                        case 'februari' : $bln = '02'; break;
                        case 'maret' : $bln = '03'; break;
                        case 'april' : $bln = '04'; break;
                        case 'mei' : $bln = '05'; break;
                        case 'juni' : $bln = '06'; break;
                        case 'juli' : $bln = '07'; break;
                        case 'agustus' : $bln = '08'; break;
                        case 'september' : $bln = '09'; break;
                        case 'oktober' : $bln = '10'; break;
                        case 'november' : $bln = '11'; break;
                        case 'desember' : $bln = '12'; break;
                    }
                    $bornDate = Carbon::createFromFormat('d-m-Y', $tgl[0].'-'.$bln.'-'.$tgl[2])->locale('id_ID')->format('Y-m-d');
                }
                else {
                    $bornDate = null;
                }

                $value = $sheet->getCell( 'AI' . $row )->getValue();
                $tgl = explode(' ',$value);

                if(count($tgl) >= 3) {
                    switch(Str::lower($tgl[1])) {
                        case 'januari' : $bln = '01'; break;
                        case 'februari' : $bln = '02'; break;
                        case 'maret' : $bln = '03'; break;
                        case 'april' : $bln = '04'; break;
                        case 'mei' : $bln = '05'; break;
                        case 'juni' : $bln = '06'; break;
                        case 'juli' : $bln = '07'; break;
                        case 'agustus' : $bln = '08'; break;
                        case 'september' : $bln = '09'; break;
                        case 'oktober' : $bln = '10'; break;
                        case 'november' : $bln = '11'; break;
                        case 'desember' : $bln = '12'; break;
                    }
                    $sp1 = Carbon::createFromFormat('d-m-Y', $tgl[0].'-'.$bln.'-'.$tgl[2])->locale('id_ID')->format('Y-m-d');
                }
                else {
                    $sp1 = null;
                }


                $value = $sheet->getCell( 'AJ' . $row )->getValue();
                $tgl = explode(' ',$value);

                if(count($tgl) >= 3) {
                    switch(Str::lower($tgl[1])) {
                        case 'januari' : $bln = '01'; break;
                        case 'februari' : $bln = '02'; break;
                        case 'maret' : $bln = '03'; break;
                        case 'april' : $bln = '04'; break;
                        case 'mei' : $bln = '05'; break;
                        case 'juni' : $bln = '06'; break;
                        case 'juli' : $bln = '07'; break;
                        case 'agustus' : $bln = '08'; break;
                        case 'september' : $bln = '09'; break;
                        case 'oktober' : $bln = '10'; break;
                        case 'november' : $bln = '11'; break;
                        case 'desember' : $bln = '12'; break;
                    }
                    $sp2 = Carbon::createFromFormat('d-m-Y', $tgl[0].'-'.$bln.'-'.$tgl[2])->locale('id_ID')->format('Y-m-d');
                }
                else {
                    $sp2 = null;
                }


                $value = $sheet->getCell( 'AK' . $row )->getValue();
                $tgl = explode(' ',$value);

                if(count($tgl) >= 3) {
                    switch(Str::lower($tgl[1])) {
                        case 'januari' : $bln = '01'; break;
                        case 'februari' : $bln = '02'; break;
                        case 'maret' : $bln = '03'; break;
                        case 'april' : $bln = '04'; break;
                        case 'mei' : $bln = '05'; break;
                        case 'juni' : $bln = '06'; break;
                        case 'juli' : $bln = '07'; break;
                        case 'agustus' : $bln = '08'; break;
                        case 'september' : $bln = '09'; break;
                        case 'oktober' : $bln = '10'; break;
                        case 'november' : $bln = '11'; break;
                        case 'desember' : $bln = '12'; break;
                    }
                    $sp3 = Carbon::createFromFormat('d-m-Y', $tgl[0].'-'.$bln.'-'.$tgl[2])->locale('id_ID')->format('Y-m-d');
                }
                else {
                    $sp3 = null;
                }

                $atasan = Str::lower($sheet->getCell( 'AT' . $row )->getValue());
                $role = null;
                if($atasan == 'atasan') {
                    $role = 4;
                }
                else if($atasan == 'admin')
                {
                    $role = 5;
                }

                $corp = 3;
                $bisnis = 'Legano 5';

                $kalimat = $sheet->getCell( 'E' . $row )->getValue();
                $kalimatBaru = substr($kalimat,7);

                Staff::create([
                    'nik' => $sheet->getCell( 'B' . $row )->getValue(),
                    'name' => $sheet->getCell( 'C' . $row )->getValue(),
                    'position' => $sheet->getCell( 'D' . $row )->getValue(),
                    'corp' => $corp,
                    'bisnis' => $bisnis,
                    'dept' => $divisi[$kode],
                    'divisi' => $kalimatBaru,
                    'gender_char' => ($sheet->getCell( 'F' . $row )->getValue() == "L") ? "Pria":"Wanita" ,
                    'gender' => ($sheet->getCell( 'F' . $row )->getValue() == "L") ? "2":"1" ,
                    'joindate' => $joinDate,
                    'end_contract' => $contractDate,
                    'religion' => $religion,
                    'agama' => $agama,
                    'pendidikan' => $pendidikan,
                    'study' => $id_stut,
                    'titip_ijazah' => $sheet->getCell( 'K' . $row )->getValue(),
                    'prodi' => $sheet->getCell( 'L' . $row )->getValue(),
                    'tgl_ijazah' => $tglIjazah,
                    'nim' => $sheet->getCell( 'N' . $row )->getValue(),
                    'ijazah' => $sheet->getCell( 'O' . $row )->getValue(),
                    'school' => $sheet->getCell( 'P' . $row )->getValue(),
                    'certi' => $sheet->getCell( 'Q' . $row )->getValue(),
                    'npwp' => $sheet->getCell( 'R' . $row )->getValue(),
                    'ptkp' => $sheet->getCell( 'S' . $row )->getValue(),
                    'status' => $status,
                    'status_char' => $status_char,
                    'kk' => $sheet->getCell( 'U' . $row )->getValue(),
                    'ktp' => $sheet->getCell( 'V' . $row )->getValue(),
                    'address' => $sheet->getCell( 'W' . $row )->getValue(),
                    'kelurahan' => $sheet->getCell( 'X' . $row )->getValue(),
                    'kecamatan' => $sheet->getCell( 'Y' . $row )->getValue(),
                    'kota' => $sheet->getCell( 'Z' . $row )->getValue(),
                    'propinsi' => $sheet->getCell( 'AA' . $row )->getValue(),
                    'place' => $sheet->getCell( 'AB' . $row )->getValue(),
                    'born' => $bornDate,
                    'bpjs_kesehatan' => $sheet->getCell( 'AD' . $row )->getValue(),
                    'bpjs_tk' => $sheet->getCell( 'AE' . $row )->getValue(),
                    'bill' => $sheet->getCell( 'AF' . $row )->getValue(),
                    'email' => $sheet->getCell( 'AG' . $row )->getValue(),
                    'kontak' => $sheet->getCell( 'AH' . $row )->getValue(),
                    'sp1' => $sp1,
                    'sp2' => $sp2,
                    'sp3' => $sp3,
                    'is_vaksin1' => $sheet->getCell( 'AL' . $row )->getValue(),
                    'is_vaksin2' => $sheet->getCell( 'AN' . $row )->getValue(),
                    'is_vaksin3' => $sheet->getCell( 'AP' . $row )->getValue(),
                    'vaksin1' => $sheet->getCell( 'AM' . $row )->getValue(),
                    'vaksin2' => $sheet->getCell( 'AO' . $row )->getValue(),
                    'vaksin3' => $sheet->getCell( 'AQ' . $row )->getValue(),
                    'vaksin_name' => $sheet->getCell( 'AR' . $row )->getValue(),
                    'pic_mesin' => $sheet->getCell( 'AS' . $row )->getValue(),
                    'role' => $role,
                ]);
                
                // email
                // $email = $sheet->getCell( 'H' . $row )->getValue();
                // $regex = '/^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$/';

            }
            dd($error);
        } catch (\Exception $e) {
            $error = [$e->getMessage(), $row];
            dd($error);
        }
    }

    public function exportDetailSpl(Request $request, $tanggalspl)
    {
        // Ambil data dari model User atau data yang ingin Anda ekspor
        // $users = User::all();
        $datas = Division::with(['overtime' => function ($query) use ($tanggalspl) {
            $query->where('tanggalspl', '=', $tanggalspl);
        }])
        ->has('overtime.detail', '>', 0)
        ->orderBy('kode')
        ->get();

        // Buat objek Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Header kolom
        $sheet->setCellValue('A1', Carbon::createFromFormat('Y-m-d', $tanggalspl)->locale('id_ID')->format('l, j F Y'));
        $sheet->setCellValue('A2', 'ID');
        $sheet->setCellValue('B2', 'Divisi');
        $sheet->setCellValue('C2', 'Nik');
        $sheet->setCellValue('D2', 'Nama');
        $sheet->setCellValue('E2', 'Jabatan');
        $sheet->setCellValue('F2', 'Waktu Kerja');
        $sheet->setCellValue('G2', 'Tanggal');
        $sheet->setCellValue('H2', 'Hari');
        $sheet->setCellValue('I2', 'Masuk');
        $sheet->setCellValue('J2', 'Pulang');
        // ... tambahkan header kolom lainnya

        // Isi data
        $row = 3;
        // dd($datas);
        foreach ($datas as $data) {
            foreach ($data->overtime as $overtime) {
                foreach ($overtime->detail as $detail) {
                    $sheet->setCellValue('A' . $row, $detail->id);
                    $sheet->setCellValue('B' . $row, $data->kode.' - '.$data->nama);
                    $sheet->setCellValue('C' . $row, $detail->nik);
                    $sheet->setCellValue('D' . $row, $detail->nama);
                    $sheet->setCellValue('E' . $row, $detail->jabatan);
                    $sheet->setCellValue('F' . $row, $overtime->waktu);
                    $sheet->setCellValue('G' . $row, Carbon::parse($overtime->tanggalspl)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F, Y'));
                    $sheet->setCellValue('H' . $row, Carbon::parse($overtime->tanggalspl)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('l'));
                    $sheet->setCellValue('I' . $row, $detail->masuk);
                    $sheet->setCellValue('J' . $row, $detail->pulang);
                    // ... tambahkan isi data kolom lainnya
                    $row++;
                }
            }
        }

        // Buat file Excel
        $filename = 'spl_detail.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path('app/public/' . $filename));

        return response()->download(storage_path('app/public/' . $filename));
    }

    public function importDetailSpl(Request $request, $tanggalspl)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }


        setlocale(LC_TIME, 'id_ID'); // Set locale ke bahasa Indonesia
        $the_file = $request->file('file');

        $filePath = $the_file->getRealPath();

        // $password = Hash::make("hris1234");
        try{
            $total = 0;
            $spreadsheet = IOFactory::load($filePath);
            $sheet        = $spreadsheet->getActiveSheet();
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range    = range( 3, $row_limit );
            $column_range = range( 'AQ', $column_limit );
            $startcount = 8;
            $data = array();
            $item = [];
            $add = [];

            // dd($row_range);
            $number = 3;
            $errors = [];

            foreach ( $row_range as $row ) {
                $number++;

                $masuk = $sheet->getCell( 'I' . $row )->getValue();
                $pulang = $sheet->getCell( 'J' . $row )->getValue();

                $id = $sheet->getCell( 'A' . $row )->getValue();

                $detail = Detail::find($id);
                if(!$detail) {
                    continue;
                }

                if($masuk)
                {
                    $validator = Validator::make([
                        'time' => $masuk,
                    ], [
                        'time' => 'excel_time_format',
                    ]);
                    
                    if ($validator->fails()) {
                        $errors[] = "Invalid time format at row " . $row;
                    }
                    else {
                        $detail->update([
                            'masuk' => $masuk,
                        ]);
                    }
                }
                else {
                    $detail->update([
                        'masuk' => null,
                    ]);
                }

                if($pulang) {
                    $validator = Validator::make([
                        'time' => $pulang,
                    ], [
                        'time' => 'excel_time_format',
                    ]);
                    
                    if ($validator->fails()) {
                        $errors[] = "Invalid time format at row " . $row;
                    }
                    else {
                        $is_umak_cut = $this->umak($pulang, $sheet->getCell( 'F' . $row )->getValue());
                        $detail->update([
                            'pulang' => $pulang,
                            'is_umak_cut' => $is_umak_cut,
                        ]);
                    }
                }
                else {
                    $detail->update([
                        'pulang' => null,
                        'is_umak_cut' => null,
                    ]);
                }

            }

            return response()->json([
                "status" => true,
                "data" => [
                    "errors" => $errors
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "reason" => $e->getMessage(),
                "data" => []
            ]);
        }
    }

    // public function selfUpdate()
    // {
    //     $divisi = Dept::all();
    //     $dept = [];
    //     foreach($divisi as $div) {
    //         $temp[$div->id] = $div->kode;
    //         if($div->kode_temp != $div->kode) {
                
    //         }
    //     }

    //     $user = Staff::all();

    //     foreach($user as $u) {
    //         $div = Dept::where($u)
    //         $u->update([
    //             'dept' => $temp[$u->dept]
    //         ]);
    //     }
    // }
}
