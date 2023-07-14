<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanDana extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'pengajuan_dana';

    public function detail()
    {
        return $this->hasMany(PengajuanDanaDetail::class,'id_pengajuan_dana','id');
    }
}
