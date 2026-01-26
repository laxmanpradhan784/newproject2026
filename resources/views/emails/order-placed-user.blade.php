<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #f7f9fc;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .content {
            padding: 30px;
        }
        .order-info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }
        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .total {
            background: #667eea;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: right;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 14px;
            border-top: 1px solid #eee;
            background: #f8f9fa;
        }
        .button {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">E-Shop</div>
            <h1>Order Confirmed!</h1>
            <p>Thank you for your purchase</p>
        </div>
        
        <div class="content">
            <p>Dear {{ $order->shipping_name }},</p>
            
            <p>We're pleased to confirm that your order has been received and is being processed.</p>
            
            <div class="order-info">
                <h3>Order Details</h3>
                <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y h:i A') }}</p>
                <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
                <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                <p><strong>Shipping Method:</strong> {{ ucfirst($order->shipping_method) }}</p>
            </div>
            
            <div class="order-info">
                <h3>Shipping Information</h3>
                <p><strong>Name:</strong> {{ $order->shipping_name }}</p>
                <p><strong>Email:</strong> {{ $order->shipping_email }}</p>
                <p><strong>Phone:</strong> {{ $order->shipping_phone }}</p>
                <p><strong>Address:</strong> {{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_zip }}</p>
            </div>
            
            <div class="order-info">
                <h3>Order Items</h3>
                @foreach($order->items as $item)
                <div class="order-item">
                    <div>
                        <strong>{{ $item->product_name }}</strong><br>
                        <small>Category: {{ $item->category_name }}</small><br>
                        <small>Qty: {{ $item->quantity }}</small>
                    </div>
                    <div>₹{{ number_format($item->price * $item->quantity, 2) }}</div>
                </div>
                @endforeach
                
                <div class="order-item">
                    <div>Subtotal</div>
                    <div>₹{{ number_format($order->subtotal, 2) }}</div>
                </div>
                <div class="order-item">
                    <div>Shipping</div>
                    <div>₹{{ number_format($order->shipping, 2) }}</div>
                </div>
                <div class="order-item">
                    <div>Tax</div>
                    <div>₹{{ number_format($order->tax, 2) }}</div>
                </div>
                
                <div class="total">
                    <strong>Total Amount: ₹{{ number_format($order->total, 2) }}</strong>
                </div>
            </div>
            
            <p>You can track your order status from your account dashboard.</p>
            
            <div style="text-align: center;">
                <a href="{{ url('/my-orders/' . $order->id) }}" class="button">View Order Details</a>
            </div>
            
            <p>If you have any questions about your order, please contact our support team.</p>
            
            <p>Thank you for shopping with us!<br>
            <strong>The E-Shop Team</strong></p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} E-Shop. All rights reserved.</p>
            <p>This email was sent to {{ $order->shipping_email }}</p>
        </div>
    </div>
</body>
</html>