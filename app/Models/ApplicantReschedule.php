<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantReschedule extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'applicant_reschedule';
}
