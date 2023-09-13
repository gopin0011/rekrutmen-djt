<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantProfile extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'applicant_profiles';

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function jk()
    {
        return $this->belongsTo(Gender::class,'gender','id');
    }

    public function religi()
    {
        return $this->belongsTo(Religion::class,'agama','id');
    }
}
