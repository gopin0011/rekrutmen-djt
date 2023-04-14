<?php

namespace App\Http\Controllers;

use App\Models\ApplicantProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class ApplicantProfileController extends Controller
{
    public function index()
    {
        $x = ApplicantProfile::where('user_id',Auth::user()->id)->get();
        $data = ApplicantProfile::where('user_id',Auth::user()->id)->first();

        $genders = DB::table('gender')->get();
        $religions = DB::table('religion')->get();

        $gender = count($x) == 1 ? $data->gender : '';
        $wn = count($x) == 1 ? $data->wn : '';
        $agama = count($x) == 1 ? $data->agama : '';
        $status = count($x) == 1 ? $data->status : '';
        $darah = count($x) == 1 ? $data->darah : '';

        return view('pages.applicant.profile', compact('data','genders','religions','gender','wn','agama','status','darah'));
    }

    public function store(Request $request)
    {
        ApplicantProfile::updateOrCreate(
            ['id' => $request->data_id],
            [
                'user_id' => $request->user_id,
                'nik' => $request->nik,
                'panggilan' => $request->panggilan,
                'tempatlahir' => $request->tempatlahir,
                'tanggallahir' => $request->tanggallahir,
                'gender' => $request->gender,
                'wn' => $request->wn,
                'agama' => $request->agama,
                'status' => $request->status,
                'darah' => $request->darah,
                'kontak' => $request->kontak,
                'alamat' => $request->alamat,
                'domisili' => $request->domisili,
                'hobi' => $request->hobi,
            ]
        );
        if(Auth::user()->admin == 0)
        {
            return redirect(route('applicant_profiles.index'));
        }else{
            return redirect(route('candidates.index'));
        }
    }

    public function convert_two()
    {
        try {
            $apply = ApplicantProfile::orderBy('id')->get();
            foreach($apply as $data){
                $update = ApplicantProfile::find($data->id);

                $update->panggilan = Crypt::decryptString($data->panggilan);
                $update->nik = Crypt::decryptString($data->nik);
                $update->kontak = Crypt::decryptString($data->kontak);
                $update->tempatlahir = Crypt::decryptString($data->tempatlahir);
                
                $update->gender = Crypt::decryptString($data->gender);
                $update->agama = Crypt::decryptString($data->agama);
                $update->status = Crypt::decryptString($data->status);
                $update->darah = Crypt::decryptString($data->darah);
                $update->alamat = Crypt::decryptString($data->alamat);
                $update->domisili = Crypt::decryptString($data->domisili);
                $update->hobi = Crypt::decryptString($data->hobi);
                $update->tingkat = Crypt::decryptString($data->tingkat);
                $update->sekolah = Crypt::decryptString($data->sekolah);
                $update->posisi = Crypt::decryptString($data->posisi);
                $update->perusahaan = Crypt::decryptString($data->perusahaan);
                $update->referensi = Crypt::decryptString($data->referensi);

                $hr = Crypt::decryptString($data->hari);
                $update->hari = $hr;

                $blnlhr = Crypt::decryptString($data->bulan);
                $update->bulan = $blnlhr;

                $thn = Crypt::decryptString($data->tahun);
                $update->tahun = $thn;

                switch($blnlhr) {
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
    
                $lhr = $thn.'-'.$bln.'-'.$hr;
                $update->tanggallahir = Carbon::createFromFormat('Y-m-d', $lhr)->toDateString();

                $wn = Crypt::decryptString($data->warganegara);
                $update->warganegara = $wn;
                $update->wn = $wn;

                $update->update();
            }
            dd('done');
        } catch (\Throwable $e) {
            dd([$update->id,$e->getMessage()]);
            dd($e->getMessage());
        }
    }

    public function convert()
    {
        try {
            $apply = ApplicantProfile::orderBy('id')->get();
            foreach($apply as $data){
                $update = ApplicantProfile::find($data->id);

                switch($data->gender_char){
                    case 'Pria' : $gender_char = 'Pria'; $gender = 2; break;
                    default : $gender_char = 'Wanita'; $gender = 1; break; 
                }
                $update->gender = $gender;

                switch($data->agama_char){
                    case 'Islam' : $agama = 'Islam'; $religion = 6; break;
                    case 'Budha' : $agama = 'Budha'; $religion = 3; break;
                    case 'Katolik' : $agama = 'Katolik'; $religion = 2; break;
                    case 'Kong Hu Cu' : $agama = 'Kong Hu Cu'; $religion = 5; break;
                    case 'Kristen' : $agama = 'Kristen'; $religion = 7; break;
                    case 'Protestan' : $agama = 'Protestan'; $religion = 1; break;
                    case 'Hindu' : $agama = 'Hindu'; $religion = 4; break;
                }
                $update->agama = $religion;
                $update->update();
            }
            dd('done');
        } catch (\Throwable $e) {
            dd([$update->id,$e->getMessage()]);
            dd($e->getMessage());
        }
    }
}
