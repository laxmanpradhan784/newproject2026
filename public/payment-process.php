<?php
session_start();
require_once '../app/controllers/PaymentController.php';

if (!isset($_SESSION['order_id'])) {
    header("Location: checkout.php");
    exit();
}

$method = $_GET['method'] ?? 'card';
$paymentController = new PaymentController();

// Simulate payment processing
sleep(2); // Simulate processing time

// Update payment status
if ($method == 'card' || $method == 'upi') {
    // Simulate 80% success rate for testing
    $success = (rand(1, 100) > 20);
    
    if ($success) {
        $paymentController->updatePaymentStatus($_SESSION['order_id'], 'paid');
        header("Location: payment-success.php?method=" . $method);
    } else {
        $paymentController->updatePaymentStatus($_SESSION['order_id'], 'failed');
        header("Location: payment-failed.php?method=" . $method . "&error=Payment+failed");
    }
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Processing Payment</title>
    <style>
        .loader {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 2s linear infinite;
            margin: 50px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div style="text-align: center; padding: 50px;">
        <div class="loader"></div>
        <h2>Processing <?php echo strtoupper($method); ?> Payment...</h2>
        <p>Please wait while we process your payment.</p>
    </div>
</body>
</html>