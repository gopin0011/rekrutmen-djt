<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function vacanciesAdditionalUpload()
    {
        return $this->hasMany(VacanciesAdditionalUpload::class,'vacancies_id')->has('additionalUpload')->with('additionalUpload');
    }

}
