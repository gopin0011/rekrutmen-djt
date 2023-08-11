<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Staff extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'employees';

    public function jk()
    {
        return $this->belongsTo(Gender::class,'gender','id');
    }

    // Aksesor untuk atribut 'age'
    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['born'])->age;
    }

    public function getMasaKerjaAttribute()
    {
        return Carbon::parse($this->attributes['joindate'])->age;
    }
}