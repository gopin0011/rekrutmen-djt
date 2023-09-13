<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Staff;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserInterview;
use App\Models\Application;
use JWTHelper;
use Carbon\Carbon;
use App\Models\EmployeToken;

class InterviewController extends Controller
{
    public function index($id)
    {
        // $data = Interview::where('application_id',$id)->first();
        $data = Application::find($id);
        $user = $data->user;
        $posisi = $data->vacancy->name;
        return view('pages.interview.index', compact('data','id', 'user', 'posisi'));
    }

    public function store(Request $request)
    {
        Application::updateOrCreate(
            ['id' => $request->data_id],
            [
                // 'application_id' => $request->application_id,
                'inthr' => $request->interview_hr,
                'namahr' => $request->nama_hr,
                'intuser' => $request->interview_user,
                'namauser' => $request->nama_user,
                'intmana' => $request->interview_manajemen,
                'namamana' => $request->nama_manajemen,
            ]
        );
        return redirect(route('applications.today'));
    }

    // public function shareHasilInterview(Request $request, $id, $userId, $type)
    // {
    //     try {
    //         // $type = $request->type;

    //         $application = Application::find($id);

    //         $staff = Staff::find($userId);

    //         switch($staff->jk->name) {
    //             case 'Wanita' : $dear = 'Ibu'; break;
    //             default: $dear = 'Bapak'; break;
    //         }

    //         $app['id'] = $application->id;
    //         $app['posisi'] = $application->posisi;
    //         $app['posisiChar'] = $application->posisi_char;

    //         $user['id'] = $staff->id;
    //         $user['email'] = $staff->email;
    //         $user['name'] = $staff->name;

    //         $data = new \stdClass();
    //         $data->app = $app;
    //         $data->staff = $user;
    //         $data->type = $type;
    //         $data->created_at = Carbon::now()->format('Y-m-d H:i:s');
    //         $data->token = JWTHelper::encode(['data' => $data], JWTHelper::jwtSecretKey, JWTHelper::algoJwt);

    //         $stafToken = EmployeToken::Create(
    //             [
    //                 'employe_id' => $staff->id,
    //                 'token' => $data->token
    //             ]
    //         );

    //         $data->action = route('user.form.add.interview', ['token' => $data->token, 'type' => $type]);

    //         if($request->whatsapp == '1') {
    //             return redirect($data->action);
    //         }

    //         $text = "Dear, ".$dear." ".$staff->name."<br><br>Anda Diminta Untuk Mengisi Hasil Interview Dengan Kandidat:";

    //         $send = Mail::to($staff->email)->send(
    //             new UserInterview($application->user->name, $application->jadwalinterview, $application->vacancy->name, $text, $data->action)
    //         );

    //         $result['status'] = true;
    //         $result['code'] = 200;
    //         $result['data'] = $data;

    //         return response()->json($result);
    //     } catch (\Throwable $e) {
    //         return response()->json(['error' => $e->getMessage()]);
    //         dd([$e->getMessage()]);
    //     }
        

    // }

    
}
