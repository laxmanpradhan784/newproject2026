<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../../../vendor/autoload.php';

use Razorpay\Api\Api;

class PaymentController {
    private $conn;
    private $api;
    
    // Razorpay Test Credentials (Get from https://dashboard.razorpay.com/app/test-credentials)
    private $keyId = 'rzp_test_YOUR_KEY_ID';
    private $keySecret = 'YOUR_KEY_SECRET';
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->api = new Api($this->keyId, $this->keySecret);
    }
    
    // Create Razorpay Order
    public function createRazorpayOrder($orderId, $amount) {
        try {
            $order = $this->api->order->create([
                'receipt' => 'order_rcpt_' . $orderId,
                'amount' => $amount * 100, // Convert to paise
                'currency' => 'INR',
                'payment_capture' => 1
            ]);
            
            return [
                'success' => true,
                'order_id' => $order->id,
                'amount' => $amount,
                'currency' => 'INR',
                'key_id' => $this->keyId
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    // Verify Payment Signature
    public function verifyPayment($razorpayOrderId, $razorpayPaymentId, $razorpaySignature) {
        $generatedSignature = hash_hmac('sha256', 
            $razorpayOrderId . "|" . $razorpayPaymentId, 
            $this->keySecret
        );
        
        return hash_equals($generatedSignature, $razorpaySignature);
    }
    
    // Save Order to Database
    public function saveOrder($data) {
        try {
            // Generate order number
            $orderNumber = 'ORD-' . date('ymd-His') . '-' . rand(1000, 9999);
            
            $query = "INSERT INTO orders SET
                order_number = :order_number,
                user_id = :user_id,
                subtotal = :subtotal,
                shipping = :shipping,
                tax = :tax,
                total = :total,
                payment_method = :payment_method,
                payment_status = :payment_status,
                shipping_name = :shipping_name,
                shipping_email = :shipping_email,
                shipping_phone = :shipping_phone,
                shipping_address = :shipping_address,
                shipping_city = :shipping_city,
                shipping_state = :shipping_state,
                shipping_zip = :shipping_zip";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':order_number', $orderNumber);
            $stmt->bindParam(':user_id', $data['user_id']);
            $stmt->bindParam(':subtotal', $data['subtotal']);
            $stmt->bindParam(':shipping', $data['shipping']);
            $stmt->bindParam(':tax', $data['tax']);
            $stmt->bindParam(':total', $data['total']);
            $stmt->bindParam(':payment_method', $data['payment_method']);
            $stmt->bindParam(':payment_status', $data['payment_status']);
            $stmt->bindParam(':shipping_name', $data['shipping_name']);
            $stmt->bindParam(':shipping_email', $data['shipping_email']);
            $stmt->bindParam(':shipping_phone', $data['shipping_phone']);
            $stmt->bindParam(':shipping_address', $data['shipping_address']);
            $stmt->bindParam(':shipping_city', $data['shipping_city']);
            $stmt->bindParam(':shipping_state', $data['shipping_state']);
            $stmt->bindParam(':shipping_zip', $data['shipping_zip']);
            
            if ($stmt->execute()) {
                return ['success' => true, 'order_id' => $this->conn->lastInsertId(), 'order_number' => $orderNumber];
            }
            return ['success' => false, 'error' => 'Failed to save order'];
            
        } catch(PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    // Update Payment Status
    public function updatePaymentStatus($orderId, $status, $transactionId = null) {
        $query = "UPDATE orders SET 
                  payment_status = :status,
                  status = CASE 
                    WHEN :status = 'paid' THEN 'processing'
                    WHEN :status = 'failed' THEN 'pending'
                    ELSE status
                  END
                  WHERE id = :order_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':order_id', $orderId);
        
        return $stmt->execute();
    }
}
?>