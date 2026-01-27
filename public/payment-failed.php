<?php
session_start();
$error = $_GET['error'] ?? 'Payment processing failed';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment Failed</title>
    <style>
        .error-box {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            text-align: center;
            background: #fff0f0;
            border: 2px solid #f44336;
            border-radius: 10px;
        }
        .error-icon {
            color: #f44336;
            font-size: 60px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="error-box">
        <div class="error-icon">✗</div>
        <h1>Payment Failed</h1>
        <p><?php echo htmlspecialchars($error); ?></p>
        <p>Please try again or use a different payment method.</p>
        
        <div style="margin-top: 30px;">
            <a href="checkout.php" style="background: #f44336; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                Return to Checkout
            </a>
        </div>
    </div>
</body>
</html>