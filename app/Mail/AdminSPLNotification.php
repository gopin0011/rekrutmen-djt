<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminSPLNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    public $data;

    public function __construct($details, $data)
    {
        $this->details = $details;
        $this->data = $data;
        $this->subject("Overtimes");
    }

    public function build()
    {
        $peoples = $this->data;

        return $this->cc('gopin.ipin@gmail.com', 'Multimedia')->markdown('pages.overtime.mail')->with('peoples', $peoples);
    }

    // private $details;

    // /**
    //  * Create a new notification instance.
    //  *
    //  * @return void
    //  */
    // public function __construct($details)
    // {
    //     $this->details = $details;
    // }


    // /**
    //  * Get the notification's delivery channels.
    //  *
    //  * @param  mixed  $notifiable
    //  * @return array
    //  */
    // public function via($notifiable)
    // {
    //     return ['mail','database'];
    // }

    // /**
    //  * Get the mail representation of the notification.
    //  *
    //  * @param  mixed  $notifiable
    //  * @return \Illuminate\Notifications\Messages\MailMessage
    //  */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //         ->greeting($this->details['greeting'])
    //         ->line($this->details['head'])
    //         ->line($this->details['line1'])
    //         ->line($this->details['line2'])
    //         ->line($this->details['line3'])
    //         ->line($this->details['line4'])
    //         ->line($this->details['line5'])
    //         ->line($this->details['footnote'])
    //         ->action($this->details['actionText'], $this->details['actionURL']);
    // }

    // /**
    //  * Get the array representation of the notification.
    //  *
    //  * @param  mixed  $notifiable
    //  * @return array
    //  */
    // public function toArray($notifiable)
    // {
    //     return [
    //         'order_id' => $this->details['order_id']
    //     ];
    // }
}
