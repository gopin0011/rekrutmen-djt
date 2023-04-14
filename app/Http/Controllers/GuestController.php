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
        $this->middleware('guest')->except(['formUserInterview','autoRegistration', 'test', 'forms']);
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

    public function forms()
    {
        return view('pages.form.guest');
    }
}
