<?php

namespace App\Http\Controllers;

use App\Models\ApplicantActivity;
use App\Models\ApplicantCareer;
use App\Models\ApplicantDocument;
use App\Models\ApplicantFamily;
use App\Models\ApplicantProfile;
use App\Models\ApplicantReference;
use App\Models\ApplicantStudy;
use App\Models\Corp;
use App\Models\Dept;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;
use Yajra\DataTables\DataTables;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class UsersController extends Controller
{
    const per_page = 10;

    //DATA
    public function changedata()
    {
        $data = Auth::user()->name;
        return view('pages.user.changedata', compact('data'));
    }

    public function storedata(Request $request)
    {
        User::find(auth()->user()->id)->update(['name' => $request->name]);
        return redirect(route('home'));
    }

    //PASSWORD
    public function changepassword()
    {
        return view('pages.user.changepassword');
    }

    public function storepassword(Request $request)
    {
        $validate = $request->validate([
            'old' => ['required', new MatchOldPassword],
            'new' => ['required', 'string', 'min:8'],
            'conf' => ['same:new'],
        ]);

        if ($validate) {
            User::find(auth()->user()->id)->update(['password' => Hash::make($request->new)]);
            // toast('Password telah berhasil diubah','success');
            Auth::logout();
            return redirect(route('login'));
        } else {
            // toast('Gagal ubah password','error');
            return redirect(route('changepassword'));
        }
    }

    //DATA
    public function index()
    {
        $corps = Corp::all();
        $depts = Dept::all();
        return view('pages.user.index', compact('corps', 'depts'));
    }

    public function showData(Request $request)
    {
        $data = User::where([['admin', '<>', '0'], ['admin', '<>', '1']])->get();
        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('admin', function ($row) {
                    if ($row->admin == 2) {
                        $admin = "Superadmin";
                    } else if ($row->admin == 3) {
                        $admin = "HR Staff";
                    } else if ($row->admin == 4) {
                        $admin = "Kepala Departemen";
                    } else if ($row->admin == 5) {
                        $admin = "Admin Departemen";
                    } else if ($row->admin == 6){
                        $admin = "Interviewer User";
                    }else{
                        $admin = "Interviewer Management";
                    }
                    return $admin;
                })
                ->addColumn('corp', function ($row) {
                    $corp = $row->corp;
                    $data = Corp::find($corp);
                    return $data->name;
                })
                ->addColumn('dept', function ($row) {
                    $dept = $row->dept;
                    $data = Dept::find($dept);
                    return $data->nama;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editData"><i class="fa fa-edit"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['admin', 'action', 'dept', 'corp'])
                ->make(true);
            return $allData;
        }
    }

    public function applicantData(Request $request)
    {
        $current_page = request('page') ?? 1;

        $limit = self::per_page;
        $start = ($current_page * self::per_page) - self::per_page;

        $search = request('search');
        if($search == '') {
            // unset($search);
        }

        $q = User::with(['applicantProfile', 'applicantFamily', 'applicantStudy', 'applicantCareer', 'applicantActivity', 'applicantReference', 'applicantDocument'])
            ->where('admin','=','0');
        if ($search != '' && $search) {
            $q->where('name', 'like', '%'.$search.'%')->orWhere('email', $search);
        }
        $total = $q->count();
        
        $q->offset($start)->limit($limit);

        $data = $q->get();

        $result['paginator'] = new Paginator($data, $total, self::per_page, $current_page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return $result;
        
        // dd($data[0]->applicantProfile);
        if ($request->ajax()) {

            $total=User::where('admin','0')->count();

            $result['paginator'] = new Paginator($data, $total, self::per_page, $current_page, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);


            return response()->json([
                "draw" => intval(request('draw')),  
                "recordsTotal"    => intval(User::where('admin','0')->count()),  
                "recordsFiltered" => intval(0),
                "data" => $data
            ]);

            // $allData = DataTables::of($data)
            //     ->addIndexColumn()
            //     ->addColumn('profile', function ($row) {
            //         // $id = $row->id;
            //         // $check = count(ApplicantProfile::where('user_id',$id)->get());
            //         // $check = count($row->applicantProfile);
            //         if($row->applicantProfile)
            //         {
            //             $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm", id="editProfile"><i class="fa fa-circle-check"></i></a>';
            //         }else{
            //             $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-danger btn-sm", id="editProfile"><i class="fa fa-circle-xmark"></i></a>';
            //         }
            //         return $btn;
            //     })
            //     ->addColumn('family', function ($row) {
            //         // $id = $row->id;
            //         // $check = count(ApplicantFamily::where('user_id',$id)->get());
            //         $check = count($row->applicantFamily);
            //         if($check != 0)
            //         {
            //             $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm", id="editFamily"><i class="fa fa-circle-check"></i>'.$check.'</a>';
            //         }else{
            //             $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-danger btn-sm", id="editFamily"><i class="fa fa-circle-xmark"></i>'.$check.'</a>';
            //         }
            //         return $btn;
            //     })
            //     ->addColumn('study', function ($row) {
            //         // $id = $row->id;
            //         // $check = count(ApplicantStudy::where('user_id',$id)->get());
            //         $check = count($row->applicantStudy);
            //         if($check != 0)
            //         {
            //             $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm", id="editStudy"><i class="fa fa-circle-check"></i>'.$check.'</a>';
            //         }else{
            //             $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-danger btn-sm", id="editStudy"><i class="fa fa-circle-xmark"></i>'.$check.'</a>';
            //         }
            //         return $btn;
            //     })
            //     ->addColumn('career', function ($row) {
            //         // $id = $row->id;
            //         // $check = count(ApplicantCareer::where('user_id',$id)->get());
            //         $check = count($row->applicantCareer);
            //         if($check != 0)
            //         {
            //             $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm", id="editCareer"><i class="fa fa-circle-check"></i>'.$check.'</a>';
            //         }else{
            //             $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-danger btn-sm", id="editCareer"><i class="fa fa-circle-xmark"></i>'.$check.'</a>';
            //         }
            //         return $btn;
            //     })
            //     ->addColumn('activity', function ($row) {
            //         // $id = $row->id;
            //         // $check = count(ApplicantActivity::where('user_id',$id)->get());
            //         $check = count($row->applicantActivity);
            //         if($check != 0)
            //         {
            //             $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm", id="editActivity"><i class="fa fa-circle-check"></i>'.$check.'</a>';
            //         }else{
            //             $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-danger btn-sm", id="editActivity"><i class="fa fa-circle-xmark"></i>'.$check.'</a>';
            //         }
            //         return $btn;
            //     })
            //     ->addColumn('ref', function ($row) {
            //         // $id = $row->id;
            //         // $check = count(ApplicantReference::where('user_id',$id)->get());
            //         $check = count($row->applicantReference);
            //         if($check != 0)
            //         {
            //             $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm", id="editRef"><i class="fa fa-circle-check"></i>'.$check.'</a>';
            //         }else{
            //             $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-danger btn-sm", id="editRef"><i class="fa fa-circle-xmark"></i>'.$check.'</a>';
            //         }
            //         return $btn;
            //     })
            //     ->addColumn('doc', function ($row) {
            //         // $id = $row->id;
            //         // $check = count(ApplicantDocument::where('user_id',$id)->get());
            //         $check = count($row->applicantDocument);
            //         if($check != 0)
            //         {
            //             $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm", id="editDoc"><i class="fa fa-circle-check"></i>'.$check.'</a>';
            //         }else{
            //             $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-danger btn-sm", id="editDoc"><i class="fa fa-circle-xmark"></i>'.$check.'</a>';
            //         }
            //         return $btn;
            //     })
            //     ->rawColumns(['profile','family','study','career','activity','ref','doc'])
            //     ->make(true);
            // return $allData;
        }
    }

    public function edit($id)
    {
        $data = User::find($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        if ($request->data_id == "") {
            User::updateOrCreate(
                ['id' => $request->data_id],
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'admin' => $request->admin,
                    'corp' => $request->corp,
                    'dept' => $request->dept,
                    'password' => bcrypt("hris1234"),
                ]
            );
        } else {
            User::updateOrCreate(
                ['id' => $request->data_id],
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'admin' => $request->admin,
                    'corp' => $request->corp,
                    'dept' => $request->dept,
                ]
            );
        }
        return response()->json(['success' => 'Data telah berhasil disimpan']);
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(['success' => 'Data telah berhasil dihapus']);
    }

    public function convert()
    {
        $staff = User::orderBy('id')->get();
        foreach($staff as $data){
            switch($data->divisi){
                case 'Business and Development' : $divisi = 'Business and Development'; $dept = 17; break;
                case 'Comptroller' : $divisi = 'Comptroller'; $dept = 32; break;
                case 'Elektro' : $divisi = 'Elektro'; $dept = 12; break;
                case 'Engineering' : $divisi = 'Engineering'; $dept = 19; break;
                case 'FAT' : $divisi = 'FAT'; $dept = 1; break;
                case 'Finishing' : $divisi = 'Finishing'; $dept = 23; break;
                case 'General Affairs' : $divisi = 'General Affairs'; $dept = 4; break;
                case 'Gudang' : $divisi = 'Gudang'; $dept = 9; break;
                case 'Handmade Panel' : $divisi = 'Handmade Panel'; $dept = 28; break;
                case 'Human Resources' : $divisi = 'Human Resources'; $dept = 3; break;
                case 'Injection' : $divisi = 'Injection'; $dept = 13; break;
                case 'Kayu' : $divisi = 'Kayu'; $dept = 11; break;
                case 'Logam' : $divisi = 'Logam'; $dept = 10; break;
                case 'Multimedia' : $divisi = 'Multimedia'; $dept = 30; break;
                case 'Offset Printing' : $divisi = 'Offset Printing'; $dept = 18; break;
                case 'Operasional' : $divisi = 'Operasional'; $dept = 8; break;
                case 'Packing dan Finish Good' : $divisi = 'Packing dan Finish Good'; $dept = 22; break;
                case 'Pembahanaan dan Proses Panel' : $divisi = 'Pembahanaan dan Proses Panel'; $dept = 20; break;
                case 'PPIC' : $divisi = 'PPIC'; $dept = 24; break;
                case 'Product Development' : $divisi = 'Product Development'; $dept = 29; break;
                case 'Product Development Engineering' : $divisi = 'Product Development Engineering'; $dept = 27; break;
                case 'Project' : $divisi = 'Project'; $dept = 25; break;
                case 'Purchasing' : $divisi = 'Purchasing'; $dept = 6; break;
                case 'Quality Control' : $divisi = 'Quality Control'; $dept = 14; break;
                case 'Research and Development' : $divisi = 'Research and Development'; $dept = 7; break;
                case 'Set Up' : $divisi = 'Set Up'; $dept = 15; break;
                case 'Solid dan Assembling' : $divisi = 'Solid dan Assembling'; $dept = 21; break;
                case 'Vokasi' : $divisi = 'Vokasi'; $dept = 16; break;
                case 'Marketing' : $divisi = 'Marketing'; $dept = 26; break;
                case 'Produksi' : $divisi = 'Marketing'; $dept = 31; break;
            }

            switch($data->bisnis){
                case 'Alat Peraga' : $divisi = 'Business and Development'; $corp = 1; break;
                case 'Legano' : $divisi = 'Comptroller'; $corp = 2; break;
            }

            $update = User::find($data->id);
            $update->corp = $corp;
            $update->dept = $dept;
            $update->update();
        }
        dd('done');
    }
}
