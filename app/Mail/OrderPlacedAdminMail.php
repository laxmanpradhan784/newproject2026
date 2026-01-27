<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlacedAdminMail extends Mailable
{
    use SerializesModels;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('New Order Placed: #' . $this->order->order_number)
                    ->view('emails.order-placed-admin')
                    ->with(['order' => $this->order]);
    }
}
