<?php
namespace App\Mail;


use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;


    public function __construct(public ContactMessage $messageModel)
    {
    }


    public function build()
    {
        return $this->subject('[Netzl] New contact message')
            ->view('emails.contact_message')
            ->with(['m' => $this->messageModel]);
    }
}