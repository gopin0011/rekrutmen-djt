<?php

namespace App\Http\Controllers;

use App\Models\ApplicantActivity;
use App\Models\ApplicantAdditionalDocument;
use App\Models\ApplicantAnswer;
use App\Models\ApplicantCareer;
use App\Models\ApplicantDocument;
use App\Models\ApplicantFamily;
use App\Models\ApplicantLanguage;
use App\Models\ApplicantProfile;
use App\Models\ApplicantReference;
use App\Models\ApplicantStudy;
use App\Models\ApplicantTraining;
use App\Models\Invitation;
use App\Models\Application;
use App\Models\NotificationsReschedule;
use App\Models\User;
use App\Models\Vacancy;
use App\Models\ApplicantReschedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use PDF;
use Illuminate\Support\Facades\Crypt;
use File;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    const notifReschedule = "Telah melakukan reschedule";

    public function print($id)
    {
        $data = Application::find($id);
        $user = User::find($data->user_id);
        $posisi = Vacancy::find($data->posisi)->name;
        $posisialt = ($data->posisialt) ? Vacancy::find($data->posisialt)->name : '';

        $getTanggal = Carbon::parse($data->jadwalinterview)->locale('id');
        $getTanggal->settings(['formatFunction' => 'translatedFormat']);
        $tanggal = $getTanggal->format('l, j F Y');

        $profil = ApplicantProfile::where('user_id',$user->id)->first();
        $gender = $profil ? DB::table('gender')->find($profil->gender)->name : '';
        $agama = $profil ? DB::table('religion')->find($profil->agama)->name : '';

        $getTanggalLahir = $profil ? Carbon::parse($profil->tanggallahir)->locale('id') : '';
        $profil ? $getTanggalLahir->settings(['formatFunction' => 'translatedFormat']) : '';
        $tanggallahir = $profil ? $getTanggalLahir->format('j F Y') : '';

        $ayah = DB::table('applicant_families')
        ->join('gender','gender.id','=','applicant_families.gender')
        ->leftJoin('studygrade','studygrade.id','=','applicant_families.pendidikan')
        ->where('applicant_families.status','=','Ayah')
        ->select('applicant_families.nama as nama','applicant_families.status as status', 'gender.name as gender', 'studygrade.name as pendidikan','applicant_families.ttl as ttl', 'applicant_families.pekerjaan as pekerjaan')
        ->where('user_id',$user->id)->first();

        $ibu = DB::table('applicant_families')
        ->join('gender','gender.id','=','applicant_families.gender')
        ->leftJoin('studygrade','studygrade.id','=','applicant_families.pendidikan')
        ->where('applicant_families.status','=','Ibu')
        ->select('applicant_families.nama as nama','applicant_families.status as status', 'gender.name as gender', 'studygrade.name as pendidikan','applicant_families.ttl as ttl', 'applicant_families.pekerjaan as pekerjaan')
        ->where('user_id',$user->id)->first();

        $kakak = DB::table('applicant_families')
        ->join('gender','gender.id','=','applicant_families.gender')
        ->leftJoin('studygrade','studygrade.id','=','applicant_families.pendidikan')
        ->where('applicant_families.status','=','Kakak')
        ->select('applicant_families.nama as nama','applicant_families.status as status', 'gender.name as gender', 'studygrade.name as pendidikan','applicant_families.ttl as ttl', 'applicant_families.pekerjaan as pekerjaan')
        ->where('user_id',$user->id)->get();

        $adik = DB::table('applicant_families')
        ->join('gender','gender.id','=','applicant_families.gender')
        ->leftJoin('studygrade','studygrade.id','=','applicant_families.pendidikan')
        ->where('applicant_families.status','=','Adik')
        ->select('applicant_families.nama as nama','applicant_families.status as status', 'gender.name as gender', 'studygrade.name as pendidikan','applicant_families.ttl as ttl', 'applicant_families.pekerjaan as pekerjaan')
        ->where('user_id',$user->id)->get();

        $pasangan = DB::table('applicant_families')
        ->join('gender','gender.id','=','applicant_families.gender')
        ->leftJoin('studygrade','studygrade.id','=','applicant_families.pendidikan')
        ->where('applicant_families.status','=','Istri')
        ->orWhere('applicant_families.status','=','Suami')
        ->select('applicant_families.nama as nama','applicant_families.status as status', 'gender.name as gender', 'studygrade.name as pendidikan','applicant_families.ttl as ttl', 'applicant_families.pekerjaan as pekerjaan')
        ->where('user_id',$user->id)->first();

        $anak = DB::table('applicant_families')
        ->join('gender','gender.id','=','applicant_families.gender')
        ->leftJoin('studygrade','studygrade.id','=','applicant_families.pendidikan')
        ->where('applicant_families.status','=','Anak')
        ->select('applicant_families.nama as nama','applicant_families.status as status', 'gender.name as gender', 'studygrade.name as pendidikan','applicant_families.ttl as ttl', 'applicant_families.pekerjaan as pekerjaan')
        ->where('user_id',$user->id)->get();

        $study = DB::table('applicant_studies')
        ->join('studygrade','studygrade.id','=','applicant_studies.tingkat')
        ->select('studygrade.name as tingkat', 'applicant_studies.sekolah as sekolah','applicant_studies.jurusan as jurusan','applicant_studies.masuk as masuk',
        'applicant_studies.kota as kota','applicant_studies.keluar as keluar')
        ->where('user_id',$user->id)->get();

        $training = ApplicantTraining::where('user_id',$user->id)->get();
        $language = ApplicantLanguage::where('user_id',$user->id)->get();
        $activity = ApplicantActivity::where('user_id',$user->id)->get();
        $reference = ApplicantReference::where('user_id',$user->id)->get();
        $career = ApplicantCareer::where('user_id',$user->id)->get();
        $quest = ApplicantAnswer::where('user_id',$user->id)->get();
        // dd($career);

        $pdf = PDF::loadView('pages.application.application', compact('data','user','posisi','posisialt','tanggal','profil','gender','agama','tanggallahir','ayah','ibu','kakak','adik','pasangan','anak','study','training','language', 'activity','reference','career','quest'))->setPaper('a4', 'potrait');
        return $pdf->stream();
    }

    public function index()
    {
        $x = route('applications.data', ['id' => Auth::user()->id]);
        $vacancy = Vacancy::where('status','0')->get();
        return view('pages.application.index', compact('x','vacancy'));
    }

    public function indexToday()
    {
        $x = route('applications.data', ['id' => 'today']);
        $vacancy = Vacancy::where('status','0')->get();
        return view('pages.interview.today', compact('x','vacancy'));
    }

    public function indexAll()
    {
        $x = route('applications.data', ['id' => 'all']);
        $vacancy = Vacancy::all();
        return view('pages.interview.all', compact('x','vacancy'));
    }

    public function showPdf($id)
    {
        $cv = ApplicantDocument::where('user_id', $id)->first();
        $additionalFiles = ApplicantAdditionalDocument::where('user_id', $id)->get();

        return view('pages.interview.pdf', compact('cv','additionalFiles'));
    }

    public function showData(Request $request,$id)
    {
        if ($request->ajax()) {
            // ALL INTERVIEWS
            $limit = request('length');
            $start = request('start');
            // dd([$limit, $start]);
            if ($id == 'all') {
                $data = DB::table('applications')
                ->select('applications.id', 'applications.jadwalinterview', 'users.id as uid', 'users.key as ukey', 'users.name', 'users.email', 'applications.posisi', 'applications.posisi_char', 'applicant_profiles.tanggallahir as lahir', 'applicant_profiles.nik', 'applicant_profiles.alamat', 'applicant_profiles.kontak', 'vacancies.name as posisi_name')
                ->join('applicant_profiles','applicant_profiles.user_id','=','applications.user_id')
                ->join('users','users.id','=','applications.user_id')
                ->join('vacancies','vacancies.id','=','applications.posisi')
                ->where('admin', 0)
                ->whereNotNull('jadwalinterview')
                ->orderBy('applications.jadwalinterview','desc')
                ->get();

                $allData = DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $url1 = route('interviews.show', ['id' => $row->id]);
                    $btn = '<a href="' . $url1 . '" data-toggle="tooltip" data-original-title="Interview" class="interview btn btn-success btn-sm interview"><i class="fa fa-comments"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $url2 = route('psychotests.show', ['id' => $row->uid]);
                    $btn .= '<a href="' . $url2 . '" data-toggle="tooltip" data-original-title="Psychotest" class="psychotest btn btn-primary btn-sm psychotest"><i class="fa fa-head-side-virus"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $url3 = route('applications.print', ['id' => $row->id]);
                    $btn .= '<a href="' . $url3 . '" data-toggle="tooltip" data-original-title="FIle" class="file btn btn-warning btn-sm file"><i class="fa fa-file"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-secondary btn-sm editData"><i class="fa fa-gear"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $url4 = route('applications.printAll', ['id' => $row->id]);
                    $btn .= '<a target="_blank" href="' . $url4 . '" data-toggle="tooltip" data-original-title="All File" class="file btn btn-primary btn-sm AllFile"><i class="fa fa-file"></i></a>';
                    return $btn;
                })
                ->addColumn('name', function ($row){
                    $id = $row->ukey;

                    $path = storage_path('app/public/pelamar/'.$id.'/rekrutmen.pdf');
                    if (File::exists($path)) {
                        $url = route('storage.old.doc', ['id' => $id]);
                        return '<a href="' . $url . '" target="_blank">'. $row->name .'</a>';
                    }
                    else {
                        $path = storage_path('app/public/doc/'.$row->uid.'.pdf');
                        if (File::exists($path)) {
                            $url = route('applications.showpdf', ['id' => $row->uid]);
                            return '<a href="' . $url . '" target="_blank">'. $row->name .'</a>';
                        }
                        return $row->name;
                    }
                    // return $name;
                })
                ->addColumn('posisi', function ($row){
                    // if ($row->posisi) $posisi = Vacancy::find($row->posisi)->name;
                    if($row->posisi_name) $posisi = $row->posisi_name;
                    else $posisi = $row->posisi_char;
                    return $posisi;
                })
                ->addColumn('lahir', function ($row) {
                    if ($row->lahir != '') {
                        $born = date('d F Y', strtotime($row->lahir));
                    } else {
                        $born = '';
                    }
                    return $born;
                })
                ->addColumn('jadwalinterview', function ($row) {
                    if ($row->jadwalinterview != '') {
                        $jadwalinterview = date('d F Y', strtotime($row->jadwalinterview));
                    } else {
                        $jadwalinterview = '';
                    }
                    return $jadwalinterview;
                })
                ->addColumn('usia', function ($row){
                    $years = now()->diffInYears($row->lahir);
                    return $years;
                })
                ->rawColumns(['action','usia','name','email'])
                ->make(true);
            } elseif($id == 'today'){
                // TODAY INTERVIEWS
                $data = Application::where('jadwalinterview',now()->format('Y-m-d'))->get();
                $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($row){
                    $id = $row->user_id;
                    $user = User::find($id);

                    $path = storage_path('app/public/pelamar/'.$user->key.'/rekrutmen.pdf');
                    if (File::exists($path)) {
                        $url = route('storage.old.doc', ['id' => $user->key]);
                        return '<a href="' . $url . '" target="_blank">'. $user->name .'</a>';
                    } 
                    else {
                        $path = storage_path('app/public/doc/'.$row->user_id.'.pdf');
                        if (File::exists($path)) {
                            $url = route('applications.showpdf', ['id' => $row->user_id]);
                            return '<a href="' . $url . '" target="_blank">'. $user->name .'</a>';
                        }
                        return $user->name;
                    }
                    // return '<a href="' . '../../storage/doc/' . $row->id . '.pdf' . '" target="_blank">'. $user .'</a>';;
                })
                ->addColumn('posisi', function ($row){
                    $id = $row->posisi;
                    if ($id) return Vacancy::find($id)->name;
                    return $row->posisi_char;
                })
                ->addColumn('posisialt', function ($row){
                    $id = $row->posisialt;
                    if($id != '')
                    {
                        $posisi = Vacancy::find($id)->name;
                    }else{
                        $posisi = '';
                    }
                    return $posisi;
                })
                ->addColumn('hasil',function ($row){
                    $data = $row->hasil;
                    if($data == '')
                    {
                        $hasil = 'Belum ada hasil';
                    }elseif($data == '1'){
                        $hasil = 'Anda diterima';
                    }else{
                        $hasil = 'Anda tidak lolos';
                    }
                    return $hasil;
                })
                ->addColumn('action', function ($row) {
                    $url1 = route('interviews.show', ['id' => $row->id]);
                    $btn = '<a href="' . $url1 . '" data-toggle="tooltip" data-original-title="Interview" class="interview btn btn-success btn-sm interview"><i class="fa fa-comments"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $url2 = route('psychotests.show', ['id' => $row->user_id]);
                    $btn .= '<a href="' . $url2 . '" data-toggle="tooltip" data-original-title="Psychotest" class="psychotest btn btn-primary btn-sm psychotest"><i class="fa fa-head-side-virus"></i></a>';
                    return $btn;
                })
                ->rawColumns(['user','posisi','posisialt','hasil','action','lahir','usia'])
                ->make(true);
            }else{
                // INTERVIEWS PER APPLICANT
                $data = Application::with('reschedule')->where('user_id',Auth::user()->id)->get();
                $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('posisi', function ($row){
                    $id = $row->posisi;
                    if ($id) return Vacancy::find($id)->name;
                    return $row->posisi_char;
                })
                ->addColumn('posisialt', function ($row){
                    $id = $row->posisialt;
                    if($id != '')
                    {
                        $posisi = Vacancy::find($id)->name;
                    }else{
                        $posisi = '';
                    }
                    return $posisi;
                })
                ->addColumn('jadwalinterview',function ($row){
                    $data = $row->jadwalinterview;
                    if($data != '')
                    {
                        $getTanggal = Carbon::parse($data)->locale('id');
                        $getTanggal->settings(['formatFunction' => 'translatedFormat']);
                        $tanggal = $getTanggal->format('l, j F Y');
                    }else{
                        $tanggal = '';
                    }

                    return $tanggal;
                })
                ->addColumn('jadwaljam',function ($row){
                    return $row->jadwaljam;
                })
                ->addColumn('hasil',function ($row){
                    $data = $row->hasil;
                    if($data == '')
                    {
                        $hasil = 'Belum ada hasil';
                    }elseif($data == '1'){
                        $hasil = 'Anda diterima';
                    }else{
                        $hasil = 'Anda tidak lolos';
                    }
                    return $hasil;
                })
                ->addColumn('action', function ($row) {
                    if($row->jadwalinterview == '')
                    {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editData"><i class="fa fa-edit"></i></a>';
                        $btn .= '&nbsp;&nbsp;';
                        $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a>';
                    }else{
                        $btn = '';
                    }
                    return $btn;
                })
                ->addColumn('reschedule', function ($row) {
                    if(!$row->reschedule)
                        return '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm reschedule"><i class="fa fa-edit"></i></a>';
                    return '';
                })
                ->rawColumns(['posisi','posisialt','jadwalinterview','action', 'reschedule'])
                ->make(true);
            }
            return $allData;
        }
    }

    public function edit($id)
    {
        $data = Application::find($id);

        // $getTanggal = Carbon::parse($data->jadwalinterview)->locale('id');
        // $getTanggal->settings(['formatFunction' => 'translatedFormat']);
        // $tanggal = $getTanggal->format('Y-m-d');
        $data->int = $data->jadwalinterview;

        return response()->json($data);
    }

    public function reschedule($id)
    {
        $data = Application::find($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $invitation = Invitation::where([['code', $request->undangan],['vacancy',$request->posisi],['dateinvite','>=',now()]])->get();
        if(count($invitation) == 1)
        {
            $undangan = 'Diundang';
            $jadwalinterview = $invitation[0]->dateinvite;
        }else{
            $undangan = '';
            $jadwalinterview = '';
        }

        if ($request->newdateinvite && $request->newdateinvite != "") {
            $dateOrig = $request->dateorig;
            $datePlusOneWeek = date('Y-m-d', strtotime($dateOrig . ' + 1 week'));

            $messages = [
                'newdateinvite.required' => 'Waktu undangan harus diisi',
                'newdateinvite.date' => 'Waktu undangan harus berupa tanggal',
                'newdateinvite.before_or_equal' => 'Waktu undangan tidak boleh melebihi 1 minggu dari tanggal sekarang',
                'newdateinvite.date_format' => 'Waktu undangan harus memiliki format YYYY-MM-DD HH:II',
                'newdateinvite.custom_time' => 'Waktu pengisian undangan harus di antara 08:00 dan 17:00',
                'dateorig.required' => 'Tanggal undangan harus diisi',
                'dateorig.date' => 'Tanggal undangan harus berupa tanggal',
            ];

            $validator = Validator::make($request->all(), [
                'newdateinvite' => [
                    'required',
                    'date',
                    'before_or_equal:' . $datePlusOneWeek,
                    'date_format:Y-m-d H:i',
                    function ($attribute, $value, $fail) {
                        // Konversi waktu menjadi detik
                        $time = time();
                        $minTime = strtotime('08:00');
                        $maxTime = strtotime('17:00');
            
                        // Periksa apakah waktu berada di antara rentang yang diperbolehkan
                        if ($time < $minTime || $time > $maxTime) {
                            $fail(__('validation.custom_time'));
                        }
                    }
                ],
                'dateorig' => 'required|date',
            ], $messages);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()]);
            }
            
            $applicant = Application::find($request->data_id);
            ApplicantReschedule::create(
                [
                    'applications_id' => $applicant->id,
                    'date' => $applicant->jadwalinterview,
                ]
            );

            $tanggal = Carbon::parse($request->newdateinvite)->locale('id');
            $tanggal->settings(['formatFunction' => 'translatedFormat']);
            $jadwalinterview = $tanggal->format("Y-m-d");
            
            Application::updateOrCreate(
                ['id' => $request->data_id],
                [
                    'jadwalinterview' => $jadwalinterview,
                ]
            );

            $users = User::where('is_rekrutmen', 1)->get();
            foreach($users as $user) {
                $user->notify(new NotificationsReschedule($applicant->user->name, $applicant->vacancy->name, $jadwalinterview, $applicant->jadwalinterview));
            }

            // NotificationsReschedule::create(
            //     [
            //         'from' => $applicant->user_id,
            //         'message' => self::notifReschedule,
            //         'applications_id' => $applicant->id,
            //     ]
            // );
        }
        else {
            Application::updateOrCreate(
                ['id' => $request->data_id],
                [
                    'user_id' => Auth::user()->id,
                    'posisi' => $request->posisi,
                    'posisialt' => $request->posisialt,
                    'undangan' => $undangan,
                    'info' => $request->info,
                    'kerabat' => $request->kerabat,
                    'jadwalinterview' => $jadwalinterview,
                    'jadwalgabung' => '',
                    'hasil' => ''
                ]
            );
        }
        
        return response()->json(['success' => 'Data telah berhasil disimpan']);
    }

    public function storeAdmin(Request $request)
    {
        Application::find($request->data_id)->update(
            [
                'posisi' => $request->posisi,
                'posisialt' => $request->posisialt,
                'kerabat' => $request->kerabat,
                'jadwalinterview' => $request->jadwalinterview,
                'jadwalgabung' => $request->jadwalgabung,
                'hasil' => $request->hasil
            ]
        );
        return response()->json(['success' => 'Data telah berhasil disimpan']);
    }

    public function destroy($id)
    {
        Application::find($id)->delete();
        return response()->json(['success' => 'Data telah berhasil dihapus']);
    }

    public function convert_two()
    {
        try {
            // ->where('id','<=', 188)
            $vac = Vacancy::orderBy('id')->get();
            $posisi = [];
            foreach($vac as $data) {
                $posisi[$data->name] = $data->id;
            }

            $apply = Application::orderBy('id')->get();
            foreach($apply as $data){
                $update = Application::find($data->id);

                // switch($data->unit){
                //     case 'Alat Peraga' : $divisi = 'Business and Development'; $corp = 1; break;
                //     case 'Legano' : $divisi = 'Comptroller'; $corp = 2; break;
                // }

                // $update->corp = $corp;

                // switch($data->divisi){
                //     case 'Business and Development' : $divisi = 'Business and Development'; $dept = 17; break;
                //     case 'Comptroller' : $divisi = 'Comptroller'; $dept = 32; break;
                //     case 'Elektro' : $divisi = 'Elektro'; $dept = 12; break;
                //     case 'Engineering' : $divisi = 'Engineering'; $dept = 19; break;
                //     case 'FAT' : $divisi = 'FAT'; $dept = 1; break;
                //     case 'Finishing' : $divisi = 'Finishing'; $dept = 23; break;
                //     case 'General Affairs' : $divisi = 'General Affairs'; $dept = 4; break;
                //     case 'Gudang' : $divisi = 'Gudang'; $dept = 9; break;
                //     case 'Handmade Panel' : $divisi = 'Handmade Panel'; $dept = 28; break;
                //     case 'Human Resources' : $divisi = 'Human Resources'; $dept = 3; break;
                //     case 'Injection' : $divisi = 'Injection'; $dept = 13; break;
                //     case 'Kayu' : $divisi = 'Kayu'; $dept = 11; break;
                //     case 'Logam' : $divisi = 'Logam'; $dept = 10; break;
                //     case 'Multimedia' : $divisi = 'Multimedia'; $dept = 30; break;
                //     case 'Offset Printing' : $divisi = 'Offset Printing'; $dept = 18; break;
                //     case 'Operasional' : $divisi = 'Operasional'; $dept = 8; break;
                //     case 'Packing dan Finish Good' : $divisi = 'Packing dan Finish Good'; $dept = 22; break;
                //     case 'Pembahanaan dan Proses Panel' : $divisi = 'Pembahanaan dan Proses Panel'; $dept = 20; break;
                //     case 'PPIC' : $divisi = 'PPIC'; $dept = 24; break;
                //     case 'Product Development' : $divisi = 'Product Development'; $dept = 29; break;
                //     case 'Product Development Engineering' : $divisi = 'Product Development Engineering'; $dept = 27; break;
                //     case 'Project' : $divisi = 'Project'; $dept = 25; break;
                //     case 'Purchasing' : $divisi = 'Purchasing'; $dept = 6; break;
                //     case 'Quality Control' : $divisi = 'Quality Control'; $dept = 14; break;
                //     case 'Research and Development' : $divisi = 'Research and Development'; $dept = 7; break;
                //     case 'Set Up' : $divisi = 'Set Up'; $dept = 15; break;
                //     case 'Solid dan Assembling' : $divisi = 'Solid dan Assembling'; $dept = 21; break;
                //     case 'Vokasi' : $divisi = 'Vokasi'; $dept = 16; break;
                //     case 'Marketing' : $divisi = 'Marketing'; $dept = 26; break;
                //     case 'Produksi' : $divisi = 'Marketing'; $dept = 31; break;
                // }
                // $update->dept = $dept;
                // if($data->posisi)
                //     $update->posisi = Crypt::decryptString($data->posisi);
                // if($data->posisialt)
                //     $update->posisialt = Crypt::decryptString($data->posisialt);
                // if($data->info)
                //     $update->info = Crypt::decryptString($data->info);
                // if($data->kerabat)
                //     $update->kerabat = Crypt::decryptString($data->kerabat);
                // if(strlen($data->inthr)>=30)
                //     $update->inthr = Crypt::decryptString($data->inthr);
                // if(strlen($data->namahr)>=30)
                //     $update->namahr = Crypt::decryptString($data->namahr);
                // if(strlen($data->intuser)>=30)
                //     $update->intuser = Crypt::decryptString($data->intuser);
                // if(strlen($data->namauser)>=30)
                //     $update->namauser = Crypt::decryptString($data->namauser);
                // if(strlen($data->intmana)>=30)
                //     $update->intmana = Crypt::decryptString($data->intmana);
                // if(strlen($data->namamana)>=30)
                //     $update->namamana = Crypt::decryptString($data->namamana);
                // if(strlen($data->hasil)>=30)
                //     $update->hasil = Crypt::decryptString($data->hasil);
                // if(strlen($data->gabunghari)>=30)
                //     $update->gabunghari = Crypt::decryptString($data->gabunghari);
                // if(strlen($data->gabungbulan)>=30)
                //     $update->gabungbulan = Crypt::decryptString($data->gabungbulan);
                // if(strlen($data->gabungtahun)>=30)
                //     $update->gabungtahun = Crypt::decryptString($data->gabungtahun);

                // if($data->jadwaltahun && $data->jadwalbulan && $data->jadwalhari) {
                //     switch($data->jadwalbulan) {
                //         case 'Januari' : $bln = '01'; break;
                //         case 'Februari' : $bln = '02'; break;
                //         case 'Maret' : $bln = '03'; break;
                //         case 'April' : $bln = '04'; break;
                //         case 'Mei' : $bln = '05'; break;
                //         case 'Juni' : $bln = '06'; break;
                //         case 'Juli' : $bln = '07'; break;
                //         case 'Agustus' : $bln = '08'; break;
                //         case 'September' : $bln = '09'; break;
                //         case 'Oktober' : $bln = '10'; break;
                //         case 'November' : $bln = '11'; break;
                //         case 'Desember' : $bln = '12'; break;
                //     }
        
                //     $invite = $data->jadwaltahun.'-'.$bln.'-'.$data->jadwalhari;
                //     $update->jadwalinterview = Carbon::createFromFormat('Y-m-d', $invite)->toDateString();
                // }

                // if($data->gabungtahun && $data->gabungbulan && $data->gabunghari) {
                //     switch($data->gabungbulan) {
                //         case 'Januari' : $bln = '01'; break;
                //         case 'Februari' : $bln = '02'; break;
                //         case 'Maret' : $bln = '03'; break;
                //         case 'April' : $bln = '04'; break;
                //         case 'Mei' : $bln = '05'; break;
                //         case 'Juni' : $bln = '06'; break;
                //         case 'Juli' : $bln = '07'; break;
                //         case 'Agustus' : $bln = '08'; break;
                //         case 'September' : $bln = '09'; break;
                //         case 'Oktober' : $bln = '10'; break;
                //         case 'November' : $bln = '11'; break;
                //         case 'Desember' : $bln = '12'; break;
                //     }
        
                //     $gabung = $data->gabungtahun.'-'.$bln.'-'.$data->gabunghari;
                //     $update->jadwalgabung = Carbon::createFromFormat('Y-m-d', $gabung)->toDateString();
                // }

                if(isset($posisi[$data->posisi_char])) {
                    $update->posisi = $posisi[$data->posisi_char];
                }
                
                $update->update();
            }
            dd('done');
        } catch (\Throwable $e) {
            switch($data->jadwalbulan) {
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
            $invite = $data->jadwaltahun.'-'.$bln.'-'.$data->jadwalhari;
            dd([$update->id,$e->getMessage()]);
            dd($e->getMessage());
        }
    }

    public function convert()
    {
        try {
            $apply = Application::orderBy('id')->whereNull('jadwalinterview')->get();
            foreach($apply as $data){
                $user = User::find($data->user_id);
                if ($user) {
                    $inv = Invitation::where('email', $user->email)->first();
                    if ($inv) {
                        $update = Application::find($data->id);

                        $update->jadwalinterview = $inv->dateinvite;
        
                        if($update->code =='') {
                            $update->code = 'Kode Diterima';
                        }
        
                        $update->jadwalhari = $inv->hari;
                        $update->jadwalbulan = $inv->bulan;
                        $update->jadwaltahun = $inv->tahun;
        
                        $update->update();
                    }
                }
            }
            dd('done');
        } catch (\Throwable $e) {
            dd([['apply' => $data],$e->getMessage()]);
            dd($e->getMessage());
        }
    }
}
