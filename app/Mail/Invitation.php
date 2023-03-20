<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Invitation extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $phone;
    public $date;
    public $time;
    public $vacancy;
    public $type;
    public $online_url;
    public $url;
    public $code;
    public $sender;
    public function __construct($name, $email, $phone, $date, $time, $vacancy, $type, $online_url, $url, $code, $sender)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->date = $date;
        $this->time = $time;
        $this->vacancy = $vacancy;
        $this->type = $type;
        $this->online_url = $online_url;
        $this->url = $url;
        $this->code = $code;
        $this->sender = $sender;
        $this->subject("Undangan Interview");
    }

    public function build()
    {
        return $this->markdown('pages.invitation.invite');
    }
}
