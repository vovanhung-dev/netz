<?php
namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $msg) {}

    public function build()
    {
        return $this->subject('New Contact Message: '.$this->msg->name)
            ->markdown('emails.contact_submitted', ['m' => $this->msg]);
    }
}
