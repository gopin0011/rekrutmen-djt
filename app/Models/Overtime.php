<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'overtimes';

    public function detail()
    {
        return $this->hasMany(Detail::class,'splid','nomor');
    }

    public function division()
    {
        return $this->belongsTo(Dept::class,'dept','id');
    }

    public function pengajuanDana()
    {
        return $this->hasOne(PengajuanDana::class, 'tanggal', 'tanggalspl')->with('detail');
    }

    public function getPengajuanDana()
    {
        return self::pengajuanDana();
    }

    public static function getCount($arr = [])
    {
        $data = [];
        $kode = '';
        foreach ($arr as $row) {
            $kode = $row->division->kode.' - '.$row->division->nama;
            $data['dept'][$kode]['kegiatan'] = $row->catatan;
            foreach ($row->detail as $detail) {
                $data['dept'][$kode]['people'][] = $detail->nama;
            }
        }

        if(count($arr)) {
            $data['pengajuanDana']['detail'] = [];
            $data['pengajuanDana']['id'] = ($arr[0]->getPengajuanDana) ? $arr[0]->getPengajuanDana->id : null;
            // dd($arr[0]->getPengajuanDana);
            if($arr[0]->getPengajuanDana) {
                foreach ($arr[0]->getPengajuanDana->detail as $detail) {
                    $data['pengajuanDana']['detail'][] = [$detail->keterangan, $detail->jumlah];
                }
            }
        }
        // dd($data);

        return $data;
    }
}
