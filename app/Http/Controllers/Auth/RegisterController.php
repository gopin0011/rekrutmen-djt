<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTHelper;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Application;
use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserLoginInfoNotification;
use Illuminate\Http\Request;
use DateTime;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => '0',
            'token_device' => '',
            'corp' => '',
            'dept' => '',
        ]);
    }

    public function showRegistrationForm($token)
    {
        dd($token);
        try {
            if(Auth::check()){
                $request->session()->flush();
                Auth::logout();
            }
            
            $token = JWTHelper::decode($request->token, JWTHelper::jwtSecretKey, JWTHelper::algoJwt);

            if (!$token->invite) { 
                return view('auth.register');
            }

            $found = false;
            $user = User::where('email', $token->invite->email)->first();
            if ($user) {
                $found = true;
            }
            else {
                $passwd = \Str::random(8);

                $user = User::create([
                    'name'      => $token->invite->nama,
                    'key'       => \Str::random(32),
                    'admin'     => '0',
                    'email'     => $token->invite->email,
                    'password'  => Hash::make($passwd),
                    'email_verified_at' => Carbon::now()->toDateTimeString(),
                ]);
            }

            $caricode = Invitation::where([['code', $token->invite->invCode],['email', $token->invite->email],['vacancy', $token->invite->posisi]])->first();
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
                'posisi' => $token->invite->posisi,
                'posisialt' => $token->invite->posisi,
                'undangan' => 'Diundang',
                'code' => $statkode,
                'jadwalinterview' => $token->invite->dateinvite,
                'jadwaljam' => $token->invite->timeinvite
            ]);

            Auth::loginUsingId($user->id);
            
            // $request->authenticate();
            $request->session()->regenerate();

            if(!$found) {
                Mail::to($token->invite->email)->send(
                    new UserLoginInfoNotification($token->invite->nama, $token->invite->email, $passwd, 'Catatan : Gunakan info login di atas untuk mengakses, di kemudian hari.', route('login'))
                );
            }

            return redirect()->intended(RouteServiceProvider::HOME); //->intended(RouteServiceProvider::HOME);
        }
        catch (\Exception $e)
        {
            dd(['error' => $e->getMessage()]);
        }
    }
}
