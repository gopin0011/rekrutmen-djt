<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function profile()
    {
        return $this->hasOne(ApplicantProfile::class, 'user_id', 'user_id')->with('user');
    }

    public function document()
    {
        return $this->hasOne(ApplicantDocument::class, 'user_id', 'user_id');
    }

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class, 'posisi', 'id')->with('vacanciesAdditionalUpload');
    }

    public function reschedule()
    {
        return $this->hasOne(ApplicantReschedule::class, 'applications_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
