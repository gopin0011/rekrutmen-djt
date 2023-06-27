<?php

namespace App\Http\Controllers;

use App\Models\MonthlyCounter;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Models\NotificationsReschedule;
use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Str;
use App\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Application;
use App\Models\ApplicantProfile;
use App\Models\ApplicantStudy;
use App\Models\ApplicantCareer;
use App\Models\ApplicantFamily;
use App\Models\Invitation;
use Hamcrest\Type\IsString;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $countAlper = count(Staff::where([['corp', '1'], ['resign', ''], ['status', '<>', '2']])->get());
        $countLegano = count(Staff::where([['corp', '2'], ['resign', ''], ['status', '<>', '2']])->get());
        // $countTlhAlper = count(Staff::where([['corp', '1'], ['resign', ''], ['status', '2']])->get());
        // $countTlhLegano = count(Staff::where([['corp', '2'], ['resign', ''], ['status', '2']])->get());

        // $countAlper = count(Staff::where([['corp', '1'], ['resign', '']])->get());
        // $countLegano = count(Staff::where([['corp', '2'], ['resign', '']])->get());

        $year = now()->format('Y');
        $monthlyAlper = MonthlyCounter::where([['month','like', $year . '%'],['corp','1']])->get('amount');
        $monthlyLegano = MonthlyCounter::where([['month','like', $year . '%'],['corp','2']])->get('amount');

        $buffAlper = '';
        $buffLegano = '';
        $bulan = now()->format('m');
        for ($i = 0; $i < $bulan ; $i++)
        {
            if($buffAlper == '')
            {
                $buffAlper = $monthlyAlper[$i]['amount'];
                $buffLegano = $monthlyLegano[$i]['amount'];
            }else{
                $buffAlper = (isset($monthlyAlper[$i]['amount'])) ? $buffAlper .','. $monthlyAlper[$i]['amount'] : $buffAlper .',0';
                $buffLegano = (isset($monthlyLegano[$i]['amount'])) ? $buffLegano .','. $monthlyLegano[$i]['amount'] : $buffLegano .',0';
            }
        }

        // dd($reschedule[0]->applications->user);

        return view('home', compact('countAlper', 'countLegano', 'monthlyAlper', 'monthlyLegano', 'buffAlper', 'buffLegano'));
    }

    public function formImport()
    {
        return view('pages.admin.import');
    }

    public function importXlsKandidat(Request $request)
    {
        $the_file = $request->file('file');

        $filePath = $the_file->getRealPath();

        $password = Hash::make("hris1234");
        try{
            $total = 0;
            $spreadsheet = IOFactory::load($filePath);
            $sheet        = $spreadsheet->getActiveSheet();
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range    = range( 8, $row_limit );
            $column_range = range( 'F', $column_limit );
            $startcount = 8;
            $data = array();
            $item = [];
            $add = [];

            $posisi = [];
            $vacancies = Vacancy::orderBy('id')->get();
            foreach ($vacancies as $row) {
                $vacancyName = Str::lower($row->name);
                $posisi[$vacancyName] = $row->id;
            }
            // dd($row_range);
            $number = 7;
            $error = [];

            foreach ( $row_range as $row ) {
                $number++;

                $value1 = $sheet->getCell( 'A' . $row )->getValue();
                if(empty($value1)) break;

                // name
                $name = $sheet->getCell( 'B' . $row )->getValue();

                $job = trim(Str::lower($sheet->getCell( 'C' . $row )->getValue()));
                if (!isset($posisi[$job])) {
                    // $error[] = [$number, $name, trim($sheet->getCell( 'C' . $row )->getValue()), "doesnt have specific vacancy"];
                    // continue;
                    $posisi[$job] = 125;
                }

                // email
                $email = $sheet->getCell( 'H' . $row )->getValue();
                $regex = '/^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$/';

                // if (preg_match('/^[^0-9]+$/', $value1) || !$value1 || $value1 == "") {
                //     // echo "Variabel tidak mengandung angka.";
                //     // dd($name);
                // } else {
                //     // dd($value);
                // }
                
                

                $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value1);
                // $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($value1);
                // if(intval($value1) || floatval($value1)) {
                //     continue;
                // }
                // $error = [$name,$value1];
                // dd($error);
                $created_at = $updated_at = Carbon::createFromFormat('d-M-y', $date->format('d-M-y'))->format('Y-m-d');
                // dd($created_at);
                if (!preg_match($regex, $email)) {
                    // Jika validasi gagal
                    $arr = explode(" ", $name);
                    
                    $name_char = (count($arr) > 1) ? preg_replace('/\s+/', '', $name) : $name;
                    $email1 = $name_char . '1@gmail.com';
                    $name = $name_char;
                    $email = $email1;

                    // if($name == "Imam") {
                    //     dd([$name,$name_char,$email]);
                    // }
                }

                if (User::where('email', 'like', $email)->first()) {
                    continue;
                }

                $userId = DB::table('users')->insertGetId([
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                    'admin' => 0,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ]);

                

                $inthr = $sheet->getCell( 'Q' . $row )->getValue();
                if ($inthr != "") {
                    $inthr = $sheet->getCell( 'M' . $row )->getValue()." - ".$inthr;
                }

                $intuser = $sheet->getCell( 'R' . $row )->getValue();
                if ($intuser != "") {
                    $intuser = $sheet->getCell( 'N' . $row )->getValue()." - ".$intuser;
                }

                Application::create([
                    'user_id' => $userId,
                    'posisi_char' => trim($sheet->getCell( 'C' . $row )->getValue()),
                    'code' => 'Kode Diterima',
                    'info' => 'Jobstreet',
                    'jadwaljam' => "14:00",
                    'inthr' => $inthr,
                    'intuser' => $intuser,
                    'intmana' => $sheet->getCell( 'O' . $row )->getValue(),
                    'undangan' => 'Diundang',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                    'jadwalinterview' => $created_at,
                    'hasil' => $sheet->getCell( 'M' . $row )->getValue(),
                    'posisi' => $posisi[$job],
                ]);

                $value = $sheet->getCell( 'D' . $row )->getValue();
                // $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($value1);
                // if(intval($value) || floatval($value)) {
                //     continue;
                // }
                // $error = [$name,$value];
                // dd($error);
                if($value != "" && !$value) {
                    $dateString = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
                    $tglLahir = Carbon::createFromFormat('d-M-y', $dateString->format('d-M-y'))->format('Y-m-d');
                }
                else {
                    $age = intval($sheet->getCell( 'E' . $row )->getValue());
                    $tglLahir = Carbon::now()->subYears($age)->format('Y-m-d');
                }

                ApplicantProfile::create([
                    'user_id' => $userId,
                    'panggilan' => $name,
                    'kontak' => $sheet->getCell( 'G' . $row )->getValue(),
                    'tanggallahir' => $tglLahir,
                    'alamat' => $sheet->getCell( 'F' . $row )->getValue(),
                    'domisili' => $sheet->getCell( 'F' . $row )->getValue(),
                    'tingkat' => $sheet->getCell( 'I' . $row )->getValue(),
                    'posisi' => $sheet->getCell( 'C' . $row )->getValue(),
                    'perusahaan' => $sheet->getCell( 'L' . $row )->getValue(),
                    'gender' => 2,
                    'agama' => 6,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ]);

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
                    default:
                        $pendidikan = 'SD';
                        $id_stut = 9;
                        break;
                }

                ApplicantStudy::create([
                    'user_id' => $userId,
                    'tingkat_char' => $pendidikan,
                    'nama' => $sheet->getCell( 'J' . $row )->getValue(),
                    'tingkat' => $id_stut,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ]);

                if ($sheet->getCell( 'L' . $row )->getValue() != "" || $sheet->getCell( 'L' . $row )->getValue() != "-") {
                    ApplicantCareer::create([
                        'user_id' => $userId,
                        'perusahaan' => $sheet->getCell( 'L' . $row )->getValue(),
                        'jabatan' => $sheet->getCell( 'K' . $row )->getValue(),
                        'created_at' => $created_at,
                        'updated_at' => $updated_at,
                    ]);
                }

                $tanggal = Carbon::parse($created_at);
                $tanggal->subWeeks(2);

                Invitation::create([
                    'name' => $name,
                    'email' => $email,
                    'created_at' => $tanggal->toDateString(),
                    'updated_at' => $tanggal->toDateString(),
                    'phone' => $sheet->getCell( 'G' . $row )->getValue(),
                    'sender' => 51,
                    'vacancy' => $posisi[$job],
                    'type' => 0,
                    'code' => \Str::random(5),
                    'dateinvite' => $created_at,
                    'timeinvite' => '14:00:00',
                ]);
            }
            dd($error);
        } catch (\Exception $e) {
            $error = [$name,$e->getMessage()];
            dd($error);
        }
    }
}
