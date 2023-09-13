<?php

namespace App\Http\Controllers;

use App\Models\Corp;
use App\Models\Dept;
use App\Models\Vacancy;
use App\Models\VacanciesAdditionalUpload;
use App\Models\AdditionalUpload;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class VacancyController extends Controller
{
    public function index()
    {
        $corps = Corp::all();
        $depts = Dept::all();
        $addUpload = AdditionalUpload::all();
        return view('pages.vacancy.index',compact('corps','depts', 'addUpload'));
    }

    public function showData(Request $request)
    {
        $data = Vacancy::all();
        if ($request->ajax()) {
            $allData = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('corp', function ($row) {
                    $id = $row->corp;
                    $corp = Corp::find($id);
                    return $corp->name;
                })
                ->addColumn('dept', function ($row) {
                    $dept = $row->dept;
                    $data = Dept::find($dept);
                    return $data->nama;
                })
                ->addColumn('status', function ($row) {
                    $data = $row->status;
                    if($data == '0'){
                        $status = 'Aktif';
                    }else{
                        $status = 'Tidak tersedia';
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editData"><i class="fa fa-edit"></i></a>';
                    $btn .= '&nbsp;&nbsp;';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['corp','dept','status','action'])
                ->make(true);
            return $allData;
        }
    }

    public function edit($id)
    {
        $data = Vacancy::with('vacanciesAdditionalUpload')->find($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        Vacancy::updateOrCreate(
            ['id' => $request->data_id],
            [
                'name' => $request->name,
                'corp' => $request->corp,
                'dept' => $request->dept,
                'description' => $request->description,
                'status' => $request->status
            ]
        );

        $vacanciesAdditionalUploads = VacanciesAdditionalUpload::where('vacancies_id', $request->data_id)->get();
        foreach ($vacanciesAdditionalUploads as $vacanciesAdditionalUpload) {
            $upload = isset($request->pendukung[$vacanciesAdditionalUpload->id]) ? $request->pendukung[$vacanciesAdditionalUpload->id] : null;
        
            if (is_null($upload)) {
                $vacanciesAdditionalUpload->delete();
            } else {
                $vacanciesAdditionalUpload->update([
                    'additional_upload_id' => $upload
                ]);
            }
        }

        if($request->has('pendukung')){
            foreach ($request->pendukung as $pendukung) {
                $find = VacanciesAdditionalUpload::where('vacancies_id', $request->data_id)->where('additional_upload_id', $pendukung)->first();
                if (!$find) {
                    VacanciesAdditionalUpload::create([
                        'vacancies_id' => $request->data_id,
                        'additional_upload_id' => $pendukung,
                    ]);
                }
            }
        }

        return response()->json(['success' => 'Data telah berhasil disimpan']);
    }

    public function destroy($id)
    {
        Vacancy::find($id)->delete();
        return response()->json(['success' => 'Data telah berhasil dihapus']);
    }

    public function convert()
    {
        try {
            // ->where('id','<=', 188)
            $vac = Vacancy::orderBy('id')->get();
            foreach($vac as $data){
               
                $update = Vacancy::find($data->id);
                switch($data->unit){
                    case 'Alat Peraga' : $divisi = 'Business and Development'; $corp = 1; break;
                    case 'Legano' : $divisi = 'Comptroller'; $corp = 2; break;
                }

                $update->corp = $corp;

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
                $update->dept = $dept;
                $update->update();
            }
            dd('done');
        } catch (\Throwable $e) {
            dd($update->id);
            dd($e->getMessage());
        }
    }

}
