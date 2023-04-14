<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'employees';

    public function jk()
    {
        return $this->belongsTo(Gender::class,'gender','id');
    }
}