<?php
session_start();
require_once '../app/controllers/PaymentController.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$cartTotal = 500; // Replace with actual cart total from database
$shipping = 50;
$tax = ($cartTotal * 0.18); // 18% GST
$grandTotal = $cartTotal + $shipping + $tax;

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'Customer';
$user_email = $_SESSION['user_email'] ?? '';
$user_phone = $_SESSION['user_phone'] ?? '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paymentController = new PaymentController();
    
    $orderData = [
        'user_id' => $user_id,
        'subtotal' => $cartTotal,
        'shipping' => $shipping,
        'tax' => $tax,
        'total' => $grandTotal,
        'payment_method' => $_POST['payment_method'],
        'payment_status' => ($_POST['payment_method'] == 'cod') ? 'pending' : 'pending',
        'shipping_name' => $_POST['name'],
        'shipping_email' => $_POST['email'],
        'shipping_phone' => $_POST['phone'],
        'shipping_address' => $_POST['address'],
        'shipping_city' => $_POST['city'],
        'shipping_state' => $_POST['state'],
        'shipping_zip' => $_POST['zip']
    ];
    
    // Save order to database
    $orderResult = $paymentController->saveOrder($orderData);
    
    if ($orderResult['success']) {
        $_SESSION['order_id'] = $orderResult['order_id'];
        $_SESSION['order_number'] = $orderResult['order_number'];
        $_SESSION['order_total'] = $grandTotal;
        
        if ($_POST['payment_method'] == 'razorpay') {
            // Create Razorpay order
            $razorpayOrder = $paymentController->createRazorpayOrder(
                $orderResult['order_id'],
                $grandTotal
            );
            
            if ($razorpayOrder['success']) {
                $_SESSION['razorpay_order_id'] = $razorpayOrder['order_id'];
                // Redirect to Razorpay payment page
                $razorpayData = $razorpayOrder;
            } else {
                $error = "Failed to create payment order: " . $razorpayOrder['error'];
            }
        } else if ($_POST['payment_method'] == 'cod') {
            // COD - Direct to success page
            header("Location: payment-success.php?method=cod");
            exit();
        } else {
            // Card/UPI - Simulate payment for now
            header("Location: payment-process.php?method=" . $_POST['payment_method']);
            exit();
        }
    } else {
        $error = "Failed to create order: " . $orderResult['error'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - E-commerce</title>
    <style>
        .payment-methods {
            margin: 20px 0;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .payment-option {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #eee;
            border-radius: 5px;
            cursor: pointer;
        }
        .payment-option:hover {
            background: #f5f5f5;
        }
        .payment-option input[type="radio"] {
            margin-right: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .order-summary {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .razorpay-payment-btn {
            display: none;
            background: #528FF0;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div style="max-width: 800px; margin: 0 auto; padding: 20px;">
        <h1>Checkout</h1>
        
        <?php if (isset($error)): ?>
            <div style="color: red; padding: 10px; background: #ffe6e6; border-radius: 5px;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="order-summary">
                <h3>Order Summary</h3>
                <p>Subtotal: ₹<?php echo number_format($cartTotal, 2); ?></p>
                <p>Shipping: ₹<?php echo number_format($shipping, 2); ?></p>
                <p>Tax (18%): ₹<?php echo number_format($tax, 2); ?></p>
                <h4>Total: ₹<?php echo number_format($grandTotal, 2); ?></h4>
            </div>
            
            <h3>Shipping Information</h3>
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($user_name); ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user_email); ?>" required>
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" name="phone" value="<?php echo htmlspecialchars($user_phone); ?>" required>
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea name="address" rows="3" required><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>
            </div>
            <div style="display: flex; gap: 15px;">
                <div class="form-group" style="flex: 1;">
                    <label>City</label>
                    <input type="text" name="city" required>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>State</label>
                    <input type="text" name="state" required>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>ZIP Code</label>
                    <input type="text" name="zip" required>
                </div>
            </div>
            
            <h3>Payment Method</h3>
            <div class="payment-methods">
                <div class="payment-option">
                    <input type="radio" name="payment_method" value="cod" id="cod" checked>
                    <label for="cod">Cash on Delivery</label>
                </div>
                
                <div class="payment-option">
                    <input type="radio" name="payment_method" value="card" id="card">
                    <label for="card">Credit/Debit Card</label>
                </div>
                
                <div class="payment-option">
                    <input type="radio" name="payment_method" value="upi" id="upi">
                    <label for="upi">UPI</label>
                </div>
                
                <div class="payment-option">
                    <input type="radio" name="payment_method" value="razorpay" id="razorpay">
                    <label for="razorpay">Pay with Razorpay</label>
                </div>
            </div>
            
            <button type="submit" class="submit-btn" style="background: #4CAF50; color: white; padding: 12px 24px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">
                Place Order
            </button>
        </form>
        
        <?php if (isset($razorpayData) && $razorpayData['success']): ?>
        <!-- Razorpay Payment Button -->
        <form id="razorpay-form">
            <script src="https://checkout.razorpay.com/v1/checkout.js"
                data-key="<?php echo $razorpayData['key_id']; ?>"
                data-amount="<?php echo $razorpayData['amount'] * 100; ?>"
                data-currency="<?php echo $razorpayData['currency']; ?>"
                data-order_id="<?php echo $razorpayData['order_id']; ?>"
                data-name="E-commerce Store"
                data-description="Order #<?php echo $_SESSION['order_number']; ?>"
                data-image="logo.png"
                data-prefill.name="<?php echo htmlspecialchars($user_name); ?>"
                data-prefill.email="<?php echo htmlspecialchars($user_email); ?>"
                data-prefill.contact="<?php echo htmlspecialchars($user_phone); ?>"
                data-theme.color="#F37254">
            </script>
            <input type="hidden" name="order_id" value="<?php echo $_SESSION['order_id']; ?>">
        </form>
        
        <script>
        // Auto-submit Razorpay form
        document.addEventListener('DOMContentLoaded', function() {
            var razorpayForm = document.getElementById('razorpay-form');
            if (razorpayForm) {
                var script = razorpayForm.querySelector('script');
                if (script) {
                    script.onload = function() {
                        // Open Razorpay checkout
                        var rzpButton = document.querySelector('.razorpay-payment-button');
                        if (rzpButton) {
                            rzpButton.click();
                        }
                    };
                }
            }
        });
        </script>
        <?php endif; ?>
    </div>
</body>
</html>