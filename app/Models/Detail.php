<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Detail extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'details';

    public function getPulangAttribute()
    {
        return $this->attributes['pulang'] 
            ? Carbon::parse($this->attributes['pulang'])->format('H:i')
            : null;
    }

    public function getMasukAttribute()
    {
        return $this->attributes['masuk'] 
            ? Carbon::parse($this->attributes['masuk'])->format('H:i')
            : null;
    }
}
