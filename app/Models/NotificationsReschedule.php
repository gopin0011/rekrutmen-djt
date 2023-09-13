<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;

class NotificationsReschedule extends Notification
{
    const notifReschedule = "Telah melakukan reschedule";

    use HasFactory;
    protected $guarded = [];

    protected $table = 'notifications_reschedule';

    public $from;
    public $posisi;
    public $jadwalinterview;
    public $jadwalsebelumnya;

    public function __construct($from, $posisi, $jadwalinterview, $jadwalsebelumnya)
    {
        $this->from = $from;
        $this->posisi = $posisi;
        $this->jadwalinterview = $jadwalinterview;
        $this->jadwalsebelumnya = $jadwalsebelumnya;
    }

    public function applications()
    {
        return $this->hasOne(Application::class, 'id', 'applications_id');
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toarray($notifiable)
    {
        return [
            'message' => self::notifReschedule,
            'from' => $this->from,
            'posisi' => $this->posisi,
            'jadwalinterview' => $this->jadwalinterview,
            'jadwalsebelumnya' => $this->jadwalsebelumnya,
        ];
    }
}
