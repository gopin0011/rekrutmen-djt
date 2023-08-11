<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\EmployeToken;
use App\Models\Interview;
use JWTHelper;
use Illuminate\Http\Request;
use DateTime;
use App\Mail\UserLoginInfoNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Invitation;
// use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Form;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Models\Vacancy;
use App\Models\ApplicantProfile;
use App\Models\ApplicantTraining;
use App\Models\ApplicantLanguage;
use App\Models\ApplicantActivity;
use App\Models\ApplicantReference;
use App\Models\ApplicantCareer;
use App\Models\ApplicantAnswer;
use App\Models\ApplicantDocument;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use File;
// use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
use App\Models\InvitationToken;
use App\Models\Staff;
use PDFMerger;
use App\Mail\UserInterview;
use App\Models\Overtime;
use App\Models\Detail;

class GuestController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['formUserInterview','autoRegistration', 'test', 'forms', 'showDataForm', 'printAll', 'isMobile', 'shareHasilInterview', 'debug', 'approveSPL','postSpl']);
    }

    public function formUserInterview($token)
    {
        EmployeToken::where('token', $token)->firstOrFail();

        $request = JWTHelper::decode($token, JWTHelper::jwtSecretKey, JWTHelper::algoJwt);

        $data = $request->data;

        $interview = Interview::where('application_id', $data->app->id)->first();
        $application = Application::find($data->app->id);

        if ($data->type == 'user') {
            $application->namauser = $application->namauser;
            $application->intuser = $application->intuser;
        } 
        else {
            $application->namauser = $application->namamana;
            $application->intuser = $application->intmana;
        }

        $id = $application->id;

        return view('pages.interview.user', compact('interview', 'id', 'token', 'data', 'application'));
    } 

    public function userInterviewStore(Request $request)
    {
        $type = $request->type;

        if ($type == 'user') {
            Interview::updateOrCreate(
                ['id' => $request->data_id],
                [
                    'application_id' => $request->application_id,
                    'interview_user' => $request->interview_user,
                    'nama_user' => $request->nama_user,
                ]
            );
    
            Application::updateOrCreate(
                ['id' => $request->application_id],
                [
                    'intuser' => $request->interview_user,
                    'namauser' => $request->nama_user,
                ]
            );
        }
        else {
            Interview::updateOrCreate(
                ['id' => $request->data_id],
                [
                    'application_id' => $request->application_id,
                    'interview_manajemen' => $request->interview_user,
                    'nama_manajemen' => $request->nama_user,
                ]
            );
    
            Application::updateOrCreate(
                ['id' => $request->application_id],
                [
                    'intmana' => $request->interview_user,
                    'namamana' => $request->nama_user,
                ]
            );
        }
        

        return redirect()->back()->with("message", "Sukses Input Data");
    }

    public function autoRegistration(Request $request, $token)
    {
        try {
            $invitationToken = InvitationToken::where('token', $token)->first();
            if($invitationToken && $invitationToken->has_applied == '1') {
                echo"Link Undangan sudah digunakan, untuk login gunakan email dan password yang dikirimkan melalui email";
                echo"<br>";
                echo "<a href='".route('home')."'>".route('home')."</a>";
                die();
                return die('sudah applied');
            }

            $data = JWTHelper::decode($token, JWTHelper::jwtSecretKey, JWTHelper::algoJwt);

            if (!$data->invite) { 
                return view('auth.register');
            }

            $found = false;
            $user = User::where('email', $data->invite->email)->first();
            if ($user) {
                $found = true;
            }
            else {
                $passwd = \Str::random(8);

                $user = User::create([
                    'name'      => $data->invite->nama,
                    'key'       => \Str::random(32),
                    'admin'     => '0',
                    'email'     => $data->invite->email,
                    'password'  => Hash::make($passwd),
                    'email_verified_at' => Carbon::now()->toDateTimeString(),
                ]);
            }

            $caricode = Invitation::where([['code', $data->invite->invCode],['email', $data->invite->email],['vacancy', $data->invite->posisi]])->first();
            if (!$caricode){
                $statkode = '';
            }
            else{
                $fdate = $caricode->created_at;
                $tdate = date(now());
                $datetime1 = new DateTime($fdate);
                $datetime2 = new DateTime($tdate);
                $interval = $datetime1->diff($datetime2);
                $days = $interval->format('%a');

                if($days <= 30)
                {
                    $statkode = 'Kode Diterima';
                }else{
                    $statkode ='';
                }
            }

            Application::create([
                'user_id' => $user->id,
                'posisi' => $data->invite->posisi,
                'posisialt' => $data->invite->posisi,
                'undangan' => 'Diundang',
                'code' => $statkode,
                'jadwalinterview' => $data->invite->dateinvite,
                'jadwaljam' => $data->invite->timeinvite
            ]);

            $invitationToken->update(['has_applied' => 1]);

            Auth::loginUsingId($user->id);
            
            // $request->authenticate();
            $request->session()->regenerate();

            if(!$found) {
                Mail::to($data->invite->email)->send(
                    new UserLoginInfoNotification($data->invite->nama, $data->invite->email, $passwd, 'Catatan : Gunakan info login di atas untuk mengakses, di kemudian hari.', route('login'))
                );
            }

            return redirect('/'); //->intended(RouteServiceProvider::HOME);
        }
        catch (\Exception $e)
        {
            dd(['error' => $e->getMessage()]);
        }
    }

    // public function test()
    // {
    //     return view('test');
    // }

    public function showDataForm(Request $request)
    {
        $data = Form::query();
        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . 'storage/form/' . $row->code . '.pdf' . '" target="_blank" class="show btn btn-primary btn-sm showData"><i class="fa fa-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            return $allData;
        }
    }

    public function printAll(Request $request, $id)
    {
        $data = Application::find($id);
        $user = User::find($data->user_id);
        $posisi = Vacancy::find($data->posisi)->name;
        $posisialt = ($data->posisialt) ? Vacancy::find($data->posisialt)->name : '';

        $getTanggal = Carbon::parse($data->jadwalinterview)->locale('id');
        $getTanggal->settings(['formatFunction' => 'translatedFormat']);
        $tanggal = $getTanggal->format('l, j F Y');

        $profil = ApplicantProfile::with(['jk', 'religi'])->where('user_id',$user->id)->first();
        $gender = ($profil) ? $profil->jk->name : '';
        $agama = ($profil) ? $profil->religi->name : '';
        // $gender = $profil ? DB::table('gender')->find($profil->gender)->name : '';
        // $agama = $profil ? DB::table('religion')->find($profil->agama)->name : '';

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
        ->select('applicant_families.nama as nama','applicant_families.status as status', 'gender.name as gender', 'studygrade.name as pendidikan','applicant_families.ttl as ttl', 'applicant_families.pekerjaan as pekerjaan')
        ->join('gender','gender.id','=','applicant_families.gender')
        ->leftJoin('studygrade','studygrade.id','=','applicant_families.pendidikan')
        ->where('applicant_families.user_id',$user->id)
        ->whereIn('applicant_families.status',['Istri','Suami'])
        ->first();

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

        $logoExt = pathinfo(url('public/logo.png'), PATHINFO_EXTENSION);
        $contentLogo = file_get_contents(url('public/logo.png'));
        $base64String = base64_encode($contentLogo);

        $item = [
            'data'  => $data,
            'user' => $user,
            'posisi' => $posisi,
            'posisialt' => $posisialt,
            'tanggal' => $tanggal,
            'profil' => $profil,
            'gender' => $gender,
            'agama' => $agama,
            'tanggallahir' => $tanggallahir,
            'ayah' => $ayah,
            'ibu' => $ibu,
            'kakak' => $kakak,
            'adik' => $adik,
            'pasangan' => $pasangan,
            'anak' => $anak,
            'study' => $study,
            'training' => $training,
            'language' => $language,
            'activity' => $activity,
            'reference' => $reference,
            'career' => $career,
            'quest' => $quest,
            'logo' => $base64String,
            'logo_type' => $logoExt,
            'forUser' => $request->get('forUser'),
        ];

        // Buat instance Dompdf
        $pdf = new Dompdf();
        
        // Render view Blade ke dalam string
        // $html = View::make('pages.application.applicationAll', $item)->render();
        $html = view('pages.application.applicationAll')->with(compact('item'))->render();
        
        // Buat objek dompdf
        $dompdf = new Dompdf();

        // Convert HTML ke dalam PDF
        $dompdf->loadHtml($html);

        // Render PDF ke dalam output buffer
        $dompdf->render();

        // Output PDF sebagai binary string
        $pdfContent = $dompdf->output();

        // Tulis binary string ke file PDF
        file_put_contents(public_path('storage/file.pdf'), $pdfContent);

        // $rekrutmen_pdf = url('public/storage/file.pdf');
        $rekrutmen_pdf = 'storage/file.pdf';
        $cv = public_path('storage/pelamar/'.$user->key.'/rekrutmen.pdf');
        $cv_url = url('public/storage/pelamar/'.$user->key.'/rekrutmen.pdf');
        // $cv_path = asset('storage/pelamar/'.$user->key.'/rekrutmen.pdf');
        $cv_path = 'storage/pelamar/'.$user->key.'/rekrutmen.pdf';

        if (!File::exists($cv)) {
            $doc = ApplicantDocument::where('user_id', $user->id)->first();
            $cv_url = isset($doc->dokumen) ? url('public/storage/doc/'.$doc->dokumen.'.pdf') : null;
            $cv_path = isset($doc->dokumen) ? 'storage/doc/'.$doc->dokumen.'.pdf' : null;
        }

        // $rekrutmen_pdf = sprintf("https://docs.google.com/viewer?embedded=true&url=%s", $rekrutmen_pdf);
        // $cv_url = sprintf("https://docs.google.com/viewer?embedded=true&url=%s", $cv_url);

        // dd([$rekrutmen_pdf,$cv_url]);
        if($request->get('share') == '1') {
            if ($request->get('forUser') == '1' && $data->is_lock_for_view == '1') {
                return die('View Has Expired');
            }

            $paths = [
                public_path('storage/file.pdf')
            ];
            if($cv_url != null) {
                array_push($paths, public_path($cv_path));
            }

            $merger = \PDFMerger::init();
            
            foreach($paths as $path) {
                $merger->addPathToPDF($path, 'all', 'P');
            }

            $merger->merge();
            $merger->save(base_path('/public/storage/merger.pdf'));

            $gdocs = sprintf("https://docs.google.com/viewer?embedded=true&url=%s", url('public/storage/merger.pdf'));

            if ($this->isMobile()) {
                return view('pages.application.mobile.viewpdf', ['rekrutmen_pdf' => $gdocs, 'cv_url' => null]);
            }

            return view('pages.application.viewpdf', ['rekrutmen_pdf' => $gdocs, 'cv_url' => null]);
        }

        $thisUrl = route('applications.printAll', ['id' => $id, 'share' => 1]);

        return view('pages.application.printAllFile', ['rekrutmen_pdf' => $rekrutmen_pdf, 'cv_url' => $cv_path, 'thisUrl' => $thisUrl, 'user' => $user, 'posisi' => $posisi]);
    }

    public function shareHasilInterview(Request $request, $id, $userId, $type)
    {
        try {
            // $type = $request->type;

            $application = Application::find($id);

            if ($type == 'user' && $application->is_lock_for_view == '1') {
                return die('View Has Expired');
            }

            $staff = Staff::find($userId);

            switch($staff->jk->name) {
                case 'Wanita' : $dear = 'Ibu'; break;
                default: $dear = 'Bapak'; break;
            }

            $app['id'] = $application->id;
            $app['posisi'] = $application->posisi;
            $app['posisiChar'] = $application->posisi_char;

            $user['id'] = $staff->id;
            $user['email'] = $staff->email;
            $user['name'] = $staff->name;

            $data = new \stdClass();
            $data->app = $app;
            $data->staff = $user;
            $data->type = $type;
            $data->created_at = Carbon::now()->format('Y-m-d H:i:s');
            $data->token = JWTHelper::encode(['data' => $data], JWTHelper::jwtSecretKey, JWTHelper::algoJwt);

            $stafToken = EmployeToken::Create(
                [
                    'employe_id' => $staff->id,
                    'token' => $data->token
                ]
            );

            $data->action = route('user.form.add.interview', ['token' => $data->token, 'type' => $type]);

            if($request->whatsapp == '1') {
                return redirect($data->action);
            }

            $text = "Dear, ".$dear." ".$staff->name."<br><br>Anda Diminta Untuk Mengisi Hasil Interview Dengan Kandidat:";

            $send = Mail::to($staff->email)->send(
                new UserInterview($application->user->name, $application->jadwalinterview, $application->vacancy->name, $text, $data->action)
            );

            $result['status'] = true;
            $result['code'] = 200;
            $result['data'] = $data;

            return response()->json($result);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
            dd([$e->getMessage()]);
        }
        

    }

    private function isMobile()
    {
        // Deteksi user agent menggunakan package "jenssegers/agent"
        $agent = new \Jenssegers\Agent\Agent();
        return $agent->isMobile();
    }

    public function forms()
    {
        return view('pages.form.guest');
    }

    public function debug(Request $request, $token)
    {
        // $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpbnZpdGUiOnsibmFtYSI6IlN1cHJpeWF0bmEiLCJlbWFpbCI6InN1cHJpeWF0bmEwNDA4MDdAZ21haWwuY29tIiwidmFjYW5jeSI6IkRlc2FpbiBJbnRlcmlvciIsInBvc2lzaSI6IjE5IiwiZGF0ZSI6IjIwMjMtMDYtMjEiLCJ0aW1laW52aXRlIjoiMDk6MDAiLCJkYXRlaW52aXRlIjoiMjAyMy0wNi0yMSIsImludkNvZGUiOiIxS0h2YyJ9fQ.U83u9gf8lFpB_pbUYP6BMmw4XsotMyDsKwwmnVYkxaM';
        $request = JWTHelper::decode($token, JWTHelper::jwtSecretKey, JWTHelper::algoJwt);

        dd($request);
    }

    public function approveSPL(Request $request, $token)
    {
        $data = JWTHelper::decode($token, JWTHelper::jwtSecretKey, JWTHelper::algoJwt);

        $withAction = $request->withAction;

        $noSpl = $idovertime = $data->overtimes->nomor;
        $atasan = $data->overtimes->atasan;

        $overtime = Overtime::where('nomor', $noSpl)->first();
        $detail = Detail::where('splid', $noSpl)->get();

        $employee = Staff::where(['id' => $atasan])->first();

        $tanggal = Carbon::parse($overtime->tanggalspl);
        $tglSplSebelumnya['1hari'] = $tanggal->subDay()->isoFormat('D MMMM YYYY');
        $tglSplSebelumnya['2hari'] = $tanggal->subDay(1)->isoFormat('D MMMM YYYY');
        // dd($tglSplSebelumnya);

        return view('pages.overtime.app', compact('overtime', 'detail', 'employee', 'idovertime','tglSplSebelumnya'));
    }

    public function postSpl(Request $request, $id)
    {
        $spl = Overtime::find($id);

        $spl->update([
            'manajer'   => $request->manajer,
            'nmmanajer' => $request->nmmanajer,
            'catatan'   => $request->catatan,
        ]);

        return redirect()->back()->with("message", "Sukses Input Data");
    }
}
