<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use SerializesModels;

    public $name;
    public $email;
    public $subjectText;
    public $messageText;
    public $phone;

    public function __construct($name, $email, $subject, $message, $phone = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->subjectText = $subject;
        $this->messageText = $message;
        $this->phone = $phone;
    }

    public function build()
{
    return $this->subject('New Contact Form: ' . $this->subjectText)
        ->view('emails.contact-form')
        ->with([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subjectText,
            'messageText' => $this->messageText,   // 👈 change
            'phone' => $this->phone,
            'submitted_at' => now()->format('F j, Y g:i A'),
        ]);
}

}
