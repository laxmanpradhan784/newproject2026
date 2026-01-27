<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactAutoReplyMail extends Mailable
{
    use SerializesModels;

    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function build()
    {
        return $this->subject('Thank you for contacting PNN Operations')
            ->view('emails.contact-autoreply')
            ->with([
                'name' => $this->name
            ]);
    }
}
