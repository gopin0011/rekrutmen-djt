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

class UsersController extends Controller
{
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
        $data = User::where([['role', '<>', '0'], ['role', '<>', '1']])->get();
        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('role', function ($row) {
                    if ($row->role == 2) {
                        $role = "Superadmin";
                    } else if ($row->role == 3) {
                        $role = "HR Staff";
                    } else if ($row->role == 4) {
                        $role = "Kepala Departemen";
                    } else if ($row->role == 5) {
                        $role = "Admin Departemen";
                    } else if ($row->role == 6){
                        $role = "Interviewer User";
                    }else{
                        $role = "Interviewer Management";
                    }
                    return $role;
                })
                ->addColumn('corp', function ($row) {
                    $corp = $row->corp;
                    $data = Corp::find($corp);
                    return $data->name;
                })
                ->addColumn('dept', function ($row) {
                    $dept = $row->dept;
                    $data = Dept::find($dept);
                    return $data->name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editData"><i class="fa fa-edit"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['role', 'action', 'dept', 'corp'])
                ->make(true);
            return $allData;
        }
    }

    public function applicantData(Request $request)
    {
        $data = User::where('role','0')->get();
        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('profile', function ($row) {
                    $id = $row->id;
                    $check = count(ApplicantProfile::where('user_id',$id)->get());
                    if($check != 0)
                    {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm", id="editProfile"><i class="fa fa-circle-check"></i></a>';
                    }else{
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-danger btn-sm", id="editProfile"><i class="fa fa-circle-xmark"></i></a>';
                    }
                    return $btn;
                })
                ->addColumn('family', function ($row) {
                    $id = $row->id;
                    $check = count(ApplicantFamily::where('user_id',$id)->get());
                    if($check != 0)
                    {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm", id="editFamily"><i class="fa fa-circle-check"></i></a>';
                    }else{
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-danger btn-sm", id="editFamily"><i class="fa fa-circle-xmark"></i></a>';
                    }
                    return $btn;
                })
                ->addColumn('study', function ($row) {
                    $id = $row->id;
                    $check = count(ApplicantStudy::where('user_id',$id)->get());
                    if($check != 0)
                    {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm", id="editStudy"><i class="fa fa-circle-check"></i></a>';
                    }else{
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-danger btn-sm", id="editStudy"><i class="fa fa-circle-xmark"></i></a>';
                    }
                    return $btn;
                })
                ->addColumn('career', function ($row) {
                    $id = $row->id;
                    $check = count(ApplicantCareer::where('user_id',$id)->get());
                    if($check != 0)
                    {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm", id="editCareer"><i class="fa fa-circle-check"></i></a>';
                    }else{
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-danger btn-sm", id="editCareer"><i class="fa fa-circle-xmark"></i></a>';
                    }
                    return $btn;
                })
                ->addColumn('activity', function ($row) {
                    $id = $row->id;
                    $check = count(ApplicantActivity::where('user_id',$id)->get());
                    if($check != 0)
                    {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm", id="editActivity"><i class="fa fa-circle-check"></i></a>';
                    }else{
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-danger btn-sm", id="editActivity"><i class="fa fa-circle-xmark"></i></a>';
                    }
                    return $btn;
                })
                ->addColumn('ref', function ($row) {
                    $id = $row->id;
                    $check = count(ApplicantReference::where('user_id',$id)->get());
                    if($check != 0)
                    {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm", id="editRef"><i class="fa fa-circle-check"></i></a>';
                    }else{
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-danger btn-sm", id="editRef"><i class="fa fa-circle-xmark"></i></a>';
                    }
                    return $btn;
                })
                ->addColumn('doc', function ($row) {
                    $id = $row->id;
                    $check = count(ApplicantDocument::where('user_id',$id)->get());
                    if($check != 0)
                    {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm", id="editDoc"><i class="fa fa-circle-check"></i></a>';
                    }else{
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-danger btn-sm", id="editDoc"><i class="fa fa-circle-xmark"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['profile','family','study','career','activity','ref','doc'])
                ->make(true);
            return $allData;
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
                    'role' => $request->role,
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
                    'role' => $request->role,
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
}
