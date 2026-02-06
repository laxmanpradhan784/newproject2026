<?php

namespace App\Services;

use Razorpay\Api\Api;
use App\Models\Order;

class RazorpayService
{
    protected $api;

    public function __construct()
    {
        $this->api = new Api(
            config('razorpay.key'),
            config('razorpay.secret')
        );
    }

    /**
     * Create a Razorpay Order
     */
    public function createOrder($amount, $receiptId, $notes = [])
    {
        try {
            $order = $this->api->order->create([
                'receipt' => $receiptId,
                'amount' => $amount * 100, // Razorpay expects amount in paise
                'currency' => 'INR',
                'notes' => $notes,
            ]);

            return $order;
        } catch (\Exception $e) {
            \Log::error('Razorpay Order Creation Failed: ' . $e->getMessage());
            throw new \Exception('Failed to create payment order: ' . $e->getMessage());
        }
    }

    /**
     * Verify Razorpay Payment Signature
     */
    public function verifySignature($orderId, $paymentId, $signature)
    {
        try {
            $attributes = [
                'razorpay_order_id' => $orderId,
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature,
            ];

            $this->api->utility->verifyPaymentSignature($attributes);
            return true;
        } catch (\Exception $e) {
            \Log::error('Razorpay Signature Verification Failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Fetch Payment Details
     */
    public function fetchPayment($paymentId)
    {
        try {
            return $this->api->payment->fetch($paymentId);
        } catch (\Exception $e) {
            \Log::error('Failed to fetch payment: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Refund Payment
     */
    public function refundPayment($paymentId, $amount = null, $notes = [])
    {
        try {
            $refundData = ['notes' => $notes];
            if ($amount) {
                $refundData['amount'] = $amount * 100;
            }

            return $this->api->payment->fetch($paymentId)->refund($refundData);
        } catch (\Exception $e) {
            \Log::error('Refund failed: ' . $e->getMessage());
            throw new \Exception('Refund failed: ' . $e->getMessage());
        }
    }
}