<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserLoginInfoNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $passwd;
    public $text;
    public $url;
    public function __construct($name, $email, $passwd, $text, $url)
    {
        $this->name = $name;
        $this->email = $email;
        $this->passwd = $passwd;
        $this->url = $url;
        $this->text = $text;
        $this->subject("Informasi Login DWIDA JAYA TAMA, PT");
    }

    public function build()
    {
        return $this->markdown('pages.invitation.loginInfo');
    }
}
