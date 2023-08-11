<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'divisions';

    protected $fillable = ['id', 'nama', 'kode', 'created_at', 'updated_at', 'is_hr'];

    public function overtime()
    {
        return $this->hasMany(Overtime::class,'dept')->with('detail')->where(['manajer' => 'diterima', 'hr' => 'diterima']);
    }

}
