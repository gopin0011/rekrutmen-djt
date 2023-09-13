<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserInterview extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $date;
    public $vacancy;
    public $text;
    public $url;
    public function __construct($name, $date, $vacancy, $text, $url)
    {
        $this->name = $name;
        $this->date = $date;
        $this->vacancy = $vacancy;
        $this->url = $url;
        $this->text = $text;
        $this->subject("Undangan Untuk Mengisi Hasil Interview");
    }

    public function build()
    {
        return $this->markdown('pages.invitation.userInterview');
    }
}
