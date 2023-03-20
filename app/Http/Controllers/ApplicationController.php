<?php

namespace App\Http\Controllers;

use App\Models\ApplicantActivity;
use App\Models\ApplicantAnswer;
use App\Models\ApplicantCareer;
use App\Models\ApplicantFamily;
use App\Models\ApplicantLanguage;
use App\Models\ApplicantProfile;
use App\Models\ApplicantReference;
use App\Models\ApplicantStudy;
use App\Models\ApplicantTraining;
use App\Models\Invitation;
use App\Models\Application;
use App\Models\User;
use App\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use PDF;

class ApplicationController extends Controller
{
    public function print($id)
    {
                $data = Application::find($id);
                $user = User::find($data->user_id);
                $posisi = Vacancy::find($data->posisi)->name;
                $posisialt = Vacancy::find($data->posisialt)->name;

                $getTanggal = Carbon::parse($data->tanggalinterview)->locale('id');
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

    public function showData(Request $request,$id)
    {
        if ($request->ajax()) {
            // ALL INTERVIEWS
            if ($id == 'all') {
                $data = DB::table('applications')
                ->select('applications.user_id as id', 'applicant_studies.tingkat as tingkat')
                ->leftJoin('applicant_studies', function ($join) {
                    $join->on('applicant_studies.user_id', '=', 'applications.user_id')
                         ->whereRaw('applicant_studies.created_at = (select min(created_at) from applicant_studies)');
                })
                ->leftJoin('applicant_careers', function ($join) {
                    $join->on('applicant_careers.user_id', '=', 'applications.user_id')
                         ->whereRaw('applicant_careers.created_at = (select min(created_at) from applicant_careers)');
                })
                ->leftJoin('applicant_references', function ($join) {
                    $join->on('applicant_references.user_id', '=', 'applications.user_id')
                         ->whereRaw('applicant_references.created_at = (select min(created_at) from applicant_references)');
                })
                ->leftJoin('applicant_profiles','applicant_profiles.user_id','=','applications.user_id')
                ->leftJoin('users','users.id','=','applications.user_id')
                ->leftJoin('applicant_documents','applicant_documents.user_id','=','applications.user_id')
                ->leftJoin('interviews','interviews.application_id','=','applications.id')
                ->leftJoin('psychotests','psychotests.user_id','=','applications.user_id')
                ->select('applications.id as id','applications.info as info','applications.kerabat as kerabat','applicant_profiles.panggilan as panggilan','interviews.application_id as int_id','psychotests.user_id as psy_id','applicant_documents.user_id as doc_id','users.name as name','applicant_profiles.nik as nik','applications.posisi as posisi','applications.posisialt as posisialt','applicant_profiles.tanggallahir as lahir','applicant_profiles.alamat as alamat', 'applicant_profiles.kontak as kontak','users.email as email','applicant_studies.tingkat as tingkat','applicant_studies.sekolah as sekolah','applicant_careers.jabatan as jabatan','applicant_careers.perusahaan as perusahaan','applicant_references.nama as referensi', 'interviews.interview_hr as int_hr', 'interviews.interview_user as int_user', 'interviews.interview_manajemen as int_mana', 'psychotests.disctest as disc', 'psychotests.ist as ist', 'psychotests.cfit as cfit', 'psychotests.armyalpha as army', 'psychotests.papikostik as papi', 'psychotests.kreplin as krep', 'applications.jadwalinterview as tanggalinterview', 'applications.hasil as hasil', 'applications.jadwalgabung as tanggalgabung', 'applications.undangan as undangan','users.id as uid')
                ->orderBy('applications.created_at','desc')
                ->get();
                $allData = DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . '../../interviews/0/' . $row->id . '" data-toggle="tooltip" data-original-title="Interview" class="interview btn btn-success btn-sm interview"><i class="fa fa-comments"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="' . '../../psychotests/0/' . $row->uid . '" data-toggle="tooltip" data-original-title="Psychotest" class="psychotest btn btn-primary btn-sm psychotest"><i class="fa fa-head-side-virus"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="' . '../../applications/print/' . $row->id . '" data-toggle="tooltip" data-original-title="FIle" class="file btn btn-warning btn-sm file"><i class="fa fa-file"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-secondary btn-sm editData"><i class="fa fa-gear"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->addColumn('name', function ($row){
                    $name = '<a href="' . '../../storage/doc/' . $row->uid . '.pdf' . '" target="_blank">'. $row->name .'</a>';
                    return $name;
                })
                ->addColumn('posisi', function ($row){
                    $posisi = Vacancy::find($row->posisi)->name;
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
                ->addColumn('usia', function ($row){
                    $years = now()->diffInYears($row->lahir);
                    return $years;
                })
                ->rawColumns(['action','usia','name'])
                ->make(true);
            } elseif($id == 'today'){
                // TODAY INTERVIEWS
                $data = Application::where('jadwalinterview',now()->format('Y-m-d'))->get();
                $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($row){
                    $id = $row->user_id;
                    $user = User::find($id)->name;
                    return '<a href="' . '../../storage/doc/' . $row->id . '.pdf' . '" target="_blank">'. $user .'</a>';;
                })
                ->addColumn('posisi', function ($row){
                    $id = $row->posisi;
                    $posisi = Vacancy::find($id)->name;
                    return $posisi;
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
                    $btn = '<a href="' . '../../interviews/0/' . $row->id . '" data-toggle="tooltip" data-original-title="Interview" class="interview btn btn-success btn-sm interview"><i class="fa fa-comments"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="' . '../../psychotests/0/' . $row->user_id . '" data-toggle="tooltip" data-original-title="Psychotest" class="psychotest btn btn-primary btn-sm psychotest"><i class="fa fa-head-side-virus"></i></a>';
                    return $btn;
                })
                ->rawColumns(['user','posisi','posisialt','hasil','action','lahir','usia'])
                ->make(true);
            }else{
                // INTERVIEWS PER APPLICANT
                $data = Application::where('user_id',Auth::user()->id)->get();
                $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('posisi', function ($row){
                    $id = $row->posisi;
                    $posisi = Vacancy::find($id)->name;
                    return $posisi;
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
                ->rawColumns(['posisi','posisialt','jadwalinterview','action'])
                ->make(true);
            }
            return $allData;
        }
    }

    public function edit($id)
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
}
