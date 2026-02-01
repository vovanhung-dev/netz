<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class HrCareerApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $data, public string $cvPath) {}

    public function build()
    {
        $mail = $this->subject('New Career Application: '.$this->data['name'])
            ->view('emails.hr_career_application');

        // đính kèm file từ storage
        if (Storage::exists($this->cvPath)) {
            $mail->attach(Storage::path($this->cvPath), [
                'as'   => 'CV_'.str_replace(' ', '_', $this->data['name']).'.'.pathinfo($this->cvPath, PATHINFO_EXTENSION),
                'mime' => Storage::mimeType($this->cvPath),
            ]);
        }
        return $mail;
    }
}
