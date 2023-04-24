<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function invitationToken()
    {
        return $this->belongsTo(InvitationToken::class,'id','invitation_id');
    }
}


