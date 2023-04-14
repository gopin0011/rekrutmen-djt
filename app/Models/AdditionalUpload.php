<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalUpload extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'additional_upload';
}
