<?php

namespace App\Services;

use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    protected $razorpay;

    public function __construct()
    {
        $this->razorpay = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );
    }

    /**
     * Create Razorpay Order
     */
    public function createRazorpayOrder($orderData)
    {
        try {
            $razorpayOrder = $this->razorpay->order->create([
                'receipt' => $orderData['order_number'],
                'amount' => $orderData['total'] * 100, // Convert to paise
                'currency' => 'INR',
                'payment_capture' => 1,
                'notes' => [
                    'order_number' => $orderData['order_number']
                ]
            ]);

            return [
                'success' => true,
                'order_id' => $razorpayOrder->id,
                'amount' => $orderData['total'],
                'currency' => 'INR',
                'key' => config('services.razorpay.key')
            ];
        } catch (\Exception $e) {
            Log::error('Razorpay order creation failed: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Verify Payment Signature
     */
    public function verifyPayment($razorpayOrderId, $razorpayPaymentId, $razorpaySignature)
    {
        $generatedSignature = hash_hmac('sha256', 
            $razorpayOrderId . "|" . $razorpayPaymentId, 
            config('services.razorpay.secret')
        );

        return hash_equals($generatedSignature, $razorpaySignature);
    }
}