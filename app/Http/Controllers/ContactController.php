<?php
namespace App\Http\Controllers;


use App\Http\Requests\Contact\SendContactRequest;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\ContactMessageSubmitted;


class ContactController extends Controller
{
    public function send(SendContactRequest $req)
    {
        $data = $req->validated();
        $msg = ContactMessage::create([
            ...$data,
            'ip'         => $req->ip(),
            'user_agent' => (string) request()->header('User-Agent'),
            'status'     => 'new',
        ]);

        try {
            Mail::to(config('mail.from.address'))
                ->send(new ContactMessageSubmitted($msg));
        } catch (\Throwable $e) {
            \Log::error('Failed to send contact email: ' . $e->getMessage(), [
                'contact_id' => $msg->id,
                'exception' => $e
            ]);
        }

        return response()->json(['message' => 'Sent', 'id' => $msg->id], 201);
    }
}