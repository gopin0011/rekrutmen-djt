<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacanciesAdditionalUpload extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'vacancies_additional_upload';

    public function additionalUpload()
    {
        return $this->belongsTo(AdditionalUpload::class,'additional_upload_id', 'id');
    }
}
