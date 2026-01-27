<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlacedUserMail extends Mailable
{
    use SerializesModels;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('Your Order Confirmation: #' . $this->order->order_number)
                    ->view('emails.order-placed-user')
                    ->with(['order' => $this->order]);
    }
}
