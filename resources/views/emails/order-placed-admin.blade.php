<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Order Notification</title>
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
            max-width: 700px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #f5365c 0%, #f56036 100%);
            color: white;
            padding: 25px 20px;
            text-align: center;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .alert-badge {
            background: #ff6b6b;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            display: inline-block;
            margin-top: 10px;
            font-weight: bold;
        }
        .content {
            padding: 30px;
        }
        .info-box {
            background: #fff5f5;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #f5365c;
        }
        .customer-type {
            background: {{ $isNewCustomer ? '#d4edda' : '#fff3cd' }};
            color: {{ $isNewCustomer ? '#155724' : '#856404' }};
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            font-weight: bold;
            text-align: center;
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
        .summary {
            background: #4e54c8;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
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
            background: #f5365c;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .stat-box {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">E-Shop Admin</div>
            <h2>🚨 New Order Received</h2>
            <div class="alert-badge">Action Required</div>
        </div>
        
        <div class="content">
            <div class="customer-type">
                {{ $isNewCustomer ? '🎉 NEW CUSTOMER' : '🔄 RETURNING CUSTOMER' }}
            </div>
            
            <div class="info-box">
                <h3>📊 Order Summary</h3>
                <div class="stat-box">
                    <div>
                        <strong>Order Number:</strong><br>
                        {{ $order->order_number }}
                    </div>
                    <div>
                        <strong>Order Date:</strong><br>
                        {{ $order->created_at->format('F d, Y h:i A') }}
                    </div>
                </div>
                
                <div class="stat-box">
                    <div>
                        <strong>Total Items:</strong><br>
                        {{ $order->items->sum('quantity') }} items
                    </div>
                    <div>
                        <strong>Order Value:</strong><br>
                        ₹{{ number_format($order->total, 2) }}
                    </div>
                </div>
            </div>
            
            <div class="info-box">
                <h3>👤 Customer Information</h3>
                <p><strong>Name:</strong> {{ $order->shipping_name }}</p>
                <p><strong>Email:</strong> {{ $order->shipping_email }}</p>
                <p><strong>Phone:</strong> {{ $order->shipping_phone }}</p>
                <p><strong>User ID:</strong> {{ $order->user_id }}</p>
                <p><strong>Customer Since:</strong> {{ $user->created_at->format('F d, Y') }}</p>
                <p><strong>Total Orders:</strong> {{ $user->orders()->count() }}</p>
            </div>
            
            <div class="info-box">
                <h3>📍 Shipping Details</h3>
                <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
                <p><strong>City:</strong> {{ $order->shipping_city }}</p>
                <p><strong>State:</strong> {{ $order->shipping_state }}</p>
                <p><strong>ZIP:</strong> {{ $order->shipping_zip }}</p>
                <p><strong>Country:</strong> {{ $order->shipping_country }}</p>
                <p><strong>Shipping Method:</strong> {{ ucfirst($order->shipping_method) }}</p>
            </div>
            
            <div class="info-box">
                <h3>💰 Payment Information</h3>
                <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
                <p><strong>Payment Status:</strong> 
                    <span style="color: {{ $order->payment_status == 'paid' ? 'green' : 'orange' }}; font-weight: bold;">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </p>
                <p><strong>Subtotal:</strong> ₹{{ number_format($order->subtotal, 2) }}</p>
                <p><strong>Shipping:</strong> ₹{{ number_format($order->shipping, 2) }}</p>
                <p><strong>Tax:</strong> ₹{{ number_format($order->tax, 2) }}</p>
            </div>
            
            <div class="info-box">
                <h3>🛍️ Order Items</h3>
                @foreach($order->items as $item)
                <div class="order-item">
                    <div>
                        <strong>{{ $item->product_name }}</strong><br>
                        <small>Category: {{ $item->category_name }} | Product ID: {{ $item->product_id }}</small><br>
                        <small>Quantity: {{ $item->quantity }} × ₹{{ number_format($item->price, 2) }}</small>
                    </div>
                    <div>₹{{ number_format($item->price * $item->quantity, 2) }}</div>
                </div>
                @endforeach
                
                <div class="summary">
                    <div style="display: flex; justify-content: space-between;">
                        <div>Subtotal:</div>
                        <div>₹{{ number_format($order->subtotal, 2) }}</div>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <div>Shipping:</div>
                        <div>₹{{ number_format($order->shipping, 2) }}</div>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <div>Tax:</div>
                        <div>₹{{ number_format($order->tax, 2) }}</div>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 18px; font-weight: bold; margin-top: 10px; padding-top: 10px; border-top: 1px solid rgba(255,255,255,0.3);">
                        <div>GRAND TOTAL:</div>
                        <div>₹{{ number_format($order->total, 2) }}</div>
                    </div>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ url('/admin/orders/' . $order->id) }}" class="button">View Order in Admin Panel</a>
            </div>
            
            <p style="margin-top: 30px; font-size: 14px; color: #666;">
                This is an automated notification. Please process this order within 24 hours.
            </p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} E-Shop Admin Panel</p>
            <p>Sent to: Admin Team | Order ID: {{ $order->order_number }}</p>
        </div>
    </div>
</body>
</html>