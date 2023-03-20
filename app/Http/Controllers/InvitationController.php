<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use App\Mail\Invitation as invit;
use Carbon\Carbon;

class InvitationController extends Controller
{
    public function index()
    {
        $vacancy = Vacancy::all();
        return view('pages.invitation.index',compact('vacancy'));
    }

    public function showData(Request $request)
    {
        $data = Invitation::query();
        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('vacancy', function ($row) {
                    $vacancy = $row->vacancy;
                    $data = Vacancy::find($vacancy);
                    return $data->name;
                })
                ->addColumn('type',function ($row){
                    $data = $row->type;
                    if($data == '0'){
                        $type = 'Offline';
                    }else{
                        $type = 'Online';
                    }
                    return $type;
                })
                ->addColumn('phone',function ($row){
                    $phone = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" class="whatsapp btn btn-success btn-sm sendWa">'.$row->phone.'</a>';
                    return $phone;
                })
                ->addColumn('sender',function ($row){
                    $id = $row->sender;
                    $sender = User::find($id)->name;
                    return $sender;
                })
                ->addColumn('dateinvite',function ($row){
                    $data = $row->dateinvite;
                    $tanggal = Carbon::parse($data)->locale('id');
                    $tanggal->settings(['formatFunction' => 'translatedFormat']);
                    return $tanggal->format('l, j F Y');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editData"><i class="fa fa-edit"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['vacancy','phone','type','sender','dateinvite','action'])
                ->make(true);
            return $allData;
        }
    }

    public function edit($id)
    {
        $data = Invitation::find($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $code = '';

        if($request->type == '0')
        {
            $type = 'Offline';
            $online_url = '';
        }else{
            $type = 'Online';
            $online_url = $request->online_url;
        }

        if($request->code == '')
        {
            $code = Str::random(5);
        }else{
            $code = $request->code;
        }

        if($request->data_id == '')
        {
            Invitation::Create(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'dateinvite' => $request->dateinvite,
                    'timeinvite' => $request->timeinvite,
                    'sender' => Auth::user()->id,
                    'vacancy' => $request->vacancy,
                    'type' => $request->type,
                    'code' => $code,
                    'online_url' => $online_url
                ]
            );
        }else{
            Invitation::find($request->data_id)->update(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'dateinvite' => $request->dateinvite,
                    'timeinvite' => $request->timeinvite,
                    'vacancy' => $request->vacancy,
                    'type' => $request->type,
                    'code' => $code,
                    'online_url' => $online_url
                ]
            );
        }

        $vacancy = $request->vacancy;
        $data = Vacancy::find($vacancy);

        $tanggal = Carbon::parse($request->dateinvite)->locale('id');
        $tanggal->settings(['formatFunction' => 'translatedFormat']);

        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $date = $tanggal->format('l, j F Y');
        $time = $request->timeinvite;
        $vacancy = $data->name;
        $type = $type;
        $online_url = $request->online_url;
        $url = env('APP_URL') . '/register';
        $sender = Auth::user()->name;

        Mail::to($email)->send(
            new invit( $name, $email, $phone, $date, $time, $vacancy, $type, $online_url, $url, $code, $sender)
        );

        return response()->json(['success' => 'Data telah berhasil disimpan']);
    }

    public function destroy($id)
    {
        Invitation::find($id)->delete();
        return response()->json(['success' => 'Data telah berhasil dihapus']);
    }

    public function sendMessage($id)
    {
        $data = Invitation::find($id);

        $vacancy = Vacancy::find($data->vacancy)->name;

        $getDate = Carbon::parse($data->date)->locale('id');
        $getDate->settings(['formatFunction' => 'translatedFormat']);
        $date = $getDate->format('l, j F Y');

        $sender = User::find($data->sender)->name;

        if($data->type == '0')
        {
            $type = 'Offline';
        }else{
            $type = 'Online';
        }

        return redirect('https://api.whatsapp.com/send/?phone=62'.Str::substr($data->phone, 1).'&text=Anda+mendapat+undangan+interview+dari+*PT.+Dwida+Jaya+Tama*%0aPosisi++++++++++++++++++:+*'.$vacancy.'*%0aHari++++++++++++++++++++++:+*'.$date.'*%0aPukul+++++++++++++++++++:+*'.$data->time.'+WIB*%0aBertemu+dengan:+'.$sender.'%0aInterview+secara:+'.$type.'%0aLink+meeting++++++:+'.$data->online_url.'%0aInvitation+code+++:+*'.$data->code.'*%0aDaftarkan+akun+Anda+di+https://rekrutmen.djt-system.com/register&type=phone_number&app_absent=0');
    }
}
