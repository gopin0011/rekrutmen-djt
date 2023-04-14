<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationsReschedule extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'notifications_reschedule';

    public function applications()
    {
        return $this->hasOne(Application::class, 'id', 'applications_id');
    }
}
