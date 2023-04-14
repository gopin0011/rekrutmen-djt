<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantAdditionalDocument extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'applicant_additional_documents';

    public function additionalUpload()
    {
        return $this->belongsTo(AdditionalUpload::class,'additional_upload_id','id');
    }
}
