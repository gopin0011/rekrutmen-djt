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
        // return Carbon::parse($this->attributes['born'])->age;
        $birthDate = Carbon::parse($this->attributes['born']);
        $currentDate = Carbon::now();

        $years = $birthDate->diffInYears($currentDate);
        $months = $birthDate->diff($currentDate)->m;

        return ['years' => $years, 'months' => $months];
    }

    public function getMasaKerjaAttribute()
    {
        // return Carbon::parse($this->attributes['joindate'])->age;
        $joindate = Carbon::parse($this->attributes['joindate']);
        $currentDate = Carbon::now();

        $years = $joindate->diffInYears($currentDate);
        $months = $joindate->diff($currentDate)->m;

        return ['years' => $years, 'months' => $months];
    }
}