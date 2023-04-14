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
use Illuminate\Support\Facades\Crypt;
use JWTHelper;

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
                    if (!$row->vacancy) return $row->posisi;

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
                    if(!$row->phone) return '-';
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
                ->addColumn('dibuat',function ($row){
                    // $data = $row->created_at;
                    // $tanggal = Carbon::parse($data)->locale('id');
                    // $tanggal->settings(['formatFunction' => 'translatedFormat']);
                    // return $tanggal->format('Y-m-d');
                    return [
                        'display' => e($row->created_at->format('m/d/Y')),
                        'timestamp' => $row->created_at->timestamp
                     ];
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editData"><i class="fa fa-edit"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['vacancy','phone','type','sender','dateinvite','dibuat','action'])
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
        $vacancy = ($request->vacancy) ? $data->name : '';
        $type = $type;
        $online_url = $request->online_url;
        // $url = env('APP_URL') . '/register';
        $sender = Auth::user()->name;

        $invitation = new \stdClass();
        $invitation->nama = $request->name;
        $invitation->email = $request->email;
        $invitation->vacancy = $vacancy;
        $invitation->posisi = $request->vacancy;
        $invitation->date = $tanggal->format("Y-m-d");
        $invitation->timeinvite = $request->timeinvite;
        $invitation->dateinvite = $request->dateinvite;
        $invitation->invCode = $code;

        $token = JWTHelper::encode(['invite' => $invitation], JWTHelper::jwtSecretKey, JWTHelper::algoJwt);

        $url = route('auto.register', ['token' => $token]);

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

    public function convert()
    {
        try {
            $vac = Vacancy::orderBy('id')->get();
            $posisi = [];
            foreach($vac as $data) {
                $posisi[$data->name] = $data->id;
            }

            // ->where('id','<=', 188)
            $inv = Invitation::where('jam', '<>', '')->whereRaw('LENGTH(name) >= 40')->orderBy('id')->get();
            foreach($inv as $data){
                $update = Invitation::find($data->id);

                switch($data->pic) {
                    case 'Dev' : $sender = '1'; break;
                    case 'Dwida Jaya Tama' : $sender = '52'; break;
                    case 'Erfin Gustaman' : $sender = '1148'; break;
                    case 'Human Resources' : $sender = '51'; break;
                    case 'PT Dwida Jaya Tama' : $sender = '52'; break;
                }

                $update->sender = $sender;

                switch($data->jenis) {
                    case 'Online' : $jenis = '1'; break;
                    case 'Offline' : $jenis = '0'; break;
                    default: $jenis = null; break;
                }

                $update->type = $jenis;

                if(isset($posisi[$data->posisi])) {
                    $update->vacancy = $posisi[$data->posisi];
                }

                $exp = explode('.', $data->jam);
                if(count($exp) == 2) {
                    $time = $exp[0].'.'.$exp[1];
                    $jam = Carbon::createFromFormat('H.i', $time)->toTimeString();
                } else {
                    $time = $data->jam.'.00';
                    $jam = Carbon::createFromFormat('H.i', $time)->toTimeString();
                }

                switch($data->bulan) {
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
    
                $invite = $data->tahun.'-'.$bln.'-'.$data->hari;

                $update->name = Crypt::decryptString($data->name);
                $update->email = Crypt::decryptString($data->email);
                $update->dateinvite = Carbon::createFromFormat('Y-m-d', $invite)->toDateString();
                $update->timeinvite = $jam;
                $update->update();
            }
            dd('done');
        } catch (\Throwable $e) {
            dd([$update->id, $e->getMessage()]);
            dd($e->getMessage());
        }
    }
}
