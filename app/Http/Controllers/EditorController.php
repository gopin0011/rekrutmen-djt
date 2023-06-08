<?php

namespace App\Http\Controllers;

use App\Models\ApplicantActivity;
use App\Models\ApplicantCareer;
use App\Models\ApplicantDocument;
use App\Models\ApplicantFamily;
use App\Models\ApplicantProfile;
use App\Models\ApplicantReference;
use App\Models\ApplicantStudy;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class EditorController extends Controller
{
    public function index(){

    }

    public function profile($id)
    {
        if(Auth::user()->admin != '0')
        {
            $mustUpload = false;
            $x = ApplicantProfile::where('user_id',$id)->get();
            $data = ApplicantProfile::where('user_id',$id)->first();

            $genders = DB::table('gender')->get();
            $religions = DB::table('religion')->get();

            $gender = count($x) == 1 ? $data->gender : '';
            $wn = count($x) == 1 ? $data->wn : '';
            $agama = count($x) == 1 ? $data->agama : '';
            $status = count($x) == 1 ? $data->status : '';
            $darah = count($x) == 1 ? $data->darah : '';

            return view('pages.applicant.profile', compact('data','genders','religions','gender','wn','agama','status','darah', 'id','mustUpload'));
        }else{
            return redirect('home');
        }
    }

    public function family($id)
    {
        if(Auth::user()->admin != '0')
        {
            $mustUpload = false;
            $dt = route('families.data', ['id' => $id]);
            $genders = DB::table('gender')->get();
            $study = DB::table('studygrade')->get();
            return view('pages.applicant.family', compact('genders','study','id','dt','mustUpload'));
        }else{
            return redirect('home');
        }
    }

    public function familyData(Request $request,$id)
    {
        $data = ApplicantFamily::where('user_id', $id)->get();
        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('gender', function ($row) {
                    $id = $row->gender;
                    $gender = DB::table('gender')->where('id', $id)->first();
                    return $gender->name;
                })
                ->addColumn('pendidikan', function ($row) {
                    $id = $row->pendidikan;
                    $study = DB::table('studygrade')->where('id', $id)->first();
                    if ($study) return $study->name;
                    return 'Tidak Sekolah';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editData"><i class="fa fa-edit"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action','gender','pendidikan'])
                ->make(true);
            return $allData;
        }
    }

    public function study($id)
    {
        if(Auth::user()->admin != '0')
        {
            $mustUpload = false;
            $dt = route('studies.data', ['id' => $id]);
            $study = DB::table('studygrade')->get();
            return view('pages.applicant.study', compact('study','id','dt','mustUpload'));
        }else{
            return redirect('home');
        }
    }

    public function studyData(Request $request,$id)
    {
        $data = ApplicantStudy::where('user_id', $id)->get();
        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tingkat', function ($row) {
                    $id = $row->tingkat;
                    $study = DB::table('studygrade')->where('id', $id)->first();
                    return $study->name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editData"><i class="fa fa-edit"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action','tingkat'])
                ->make(true);
            return $allData;
        }
    }

    public function career($id)
    {
        $mustUpload = false;
        $dt = route('careers.data', ['id' => $id]);
        return view('pages.applicant.career', compact('dt','id','mustUpload'));
    }

    public function careerData(Request $request,$id)
    {
        $data = ApplicantCareer::where('user_id', $id)->get();
        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editData"><i class="fa fa-edit"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            return $allData;
        }
    }

    public function activity($id)
    {
        $mustUpload = false;
        $dt = route('activities.data', ['id' => $id]);
        return view('pages.applicant.activity', compact('dt','id','mustUpload'));
    }

    public function activityData(Request $request,$id)
    {
        $data = ApplicantActivity::where('user_id', $id)->get();
        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editData"><i class="fa fa-edit"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            return $allData;
        }
    }

    public function ref($id)
    {
        $mustUpload = false;
        $dt = route('references.data', ['id' => $id]);
        return view('pages.applicant.reference',compact('dt','id','mustUpload'));
    }

    public function refData(Request $request, $id)
    {
        $data = ApplicantReference::where('user_id', $id)->get();
        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editData"><i class="fa fa-edit"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            return $allData;
        }
    }

    public function doc($id)
    {
        $dt = route('documents.data', ['id' => $id]);
        $applications = Application::groupBy('posisi', 'user_id')->select('posisi', 'user_id')->with('vacancy')->whereHas('vacancy.vacanciesAdditionalUpload')->where('user_id', $id)->get();
        return view('pages.applicant.document',compact('dt','id', 'applications'));
    }

    public function docData(Request $request, $id)
    {
        $data = ApplicantDocument::where('user_id',$id)->get();
        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row){
                    $nama = 'Dokumen CV';
                    return $nama;
                })
                ->addColumn('action', function ($row) {
                    if($row->dokumen) {
                        $url = route('storage.doc', ['folder' => 'doc', 'filename' => $row->dokumen.'.pdf']);
                    } else {
                        $url = route('storage.old.doc', ['id' => $row->user->key]);
                    }
                    $btn = '<div class="btn-group"><a href="' . $url . '" target="_blank" class="show btn btn-primary btn-sm showData"><i class="fa fa-eye"></i></a>';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a></div>';
                    return $btn;
                })
                ->rawColumns(['action','name'])
                ->make(true);
            return $allData;
        }
    }
}
