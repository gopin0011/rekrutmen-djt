<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'admin',
        'token_device',
        'corp',
        'dept',
        'key',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'users';

    public function applicantProfile()
    {
        return $this->belongsTo(ApplicantProfile::class,'id','user_id');
    }

    public function applicantFamily()
    {
        return $this->hasMany(ApplicantFamily::class,'user_id');
    }

    public function applicantStudy()
    {
        return $this->hasMany(ApplicantStudy::class,'user_id');
    }

    public function applicantCareer()
    {
        return $this->hasMany(ApplicantCareer::class,'user_id');
    }

    public function applicantActivity()
    {
        return $this->hasMany(ApplicantActivity::class,'user_id');
    }

    public function applicantReference()
    {
        return $this->hasMany(ApplicantReference::class,'user_id');
    }

    public function applicantDocument()
    {
        return $this->hasMany(ApplicantDocument::class,'user_id');
    }

    public function divisi()
    {
        return $this->belongsTo(Dept::class,'dept','id');
    }

    public function hrDivisi()
    {
        return $this->belongsTo(Dept::class,'dept','id')->where('is_hr', 1);
    }
}
