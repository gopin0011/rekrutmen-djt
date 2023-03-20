<?php

namespace App\Http\Controllers;

use App\Models\ApplicantProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        if(Auth::user()->role == 0)
        {
            return redirect(route('applicant_profiles.index'));
        }else{
            return redirect(route('candidates.index'));
        }
    }
}
