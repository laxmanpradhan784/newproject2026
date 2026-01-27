<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order Placed - Order #{{ $order->order_number }}</title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f7f9fc;
            padding: 20px;
        }

        .email-container {
            max-width: 700px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }

        /* Header */
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .header-icon {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .email-header h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .email-header p {
            opacity: 0.9;
            font-size: 16px;
        }

        /* Order Info Cards */
        .order-summary {
            padding: 30px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            border-left: 4px solid #667eea;
        }

        .info-card h3 {
            color: #667eea;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .info-card p {
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }

        /* Customer Info */
        .customer-section {
            background: linear-gradient(to right, #f8f9fa, #ffffff);
            padding: 25px;
            border-radius: 12px;
            margin: 25px 0;
            border: 1px solid #eaeaea;
        }

        .customer-section h2 {
            color: #2c3e50;
            font-size: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .customer-section h2:before {
            content: "👤";
            font-size: 24px;
        }

        .customer-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .detail-item {
            margin-bottom: 12px;
        }

        .detail-label {
            font-size: 13px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
            display: block;
        }

        .detail-value {
            font-size: 15px;
            color: #333;
            font-weight: 500;
        }

        /* Order Items Table */
        .order-items {
            margin: 30px 0;
        }

        .order-items h2 {
            color: #2c3e50;
            font-size: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .order-items h2:before {
            content: "📦";
            font-size: 24px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .items-table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .items-table th {
            padding: 18px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .items-table tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s;
        }

        .items-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .items-table td {
            padding: 18px 15px;
            font-size: 15px;
        }

        .items-table td:first-child {
            font-weight: 500;
            color: #2c3e50;
        }

        /* Total Section */
        .total-section {
            background: #2c3e50;
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin: 30px 0;
        }

        .total-section h2 {
            font-size: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .total-section h2:before {
            content: "💰";
            font-size: 24px;
        }

        .total-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .total-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .total-label {
            font-size: 14px;
            opacity: 0.8;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .total-value {
            font-size: 24px;
            font-weight: 700;
        }

        .grand-total {
            background: #27ae60;
        }

        .grand-total .total-value {
            font-size: 28px;
        }

        /* Footer */
        .email-footer {
            text-align: center;
            padding: 30px;
            background: #f8f9fa;
            color: #666;
            border-top: 1px solid #eaeaea;
        }

        .company-logo {
            font-size: 24px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 20px 0;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .copyright {
            font-size: 13px;
            margin-top: 20px;
            opacity: 0.7;
        }

        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: #fef9e7;
            color: #f39c12;
        }

        .status-paid {
            background: #e8f6f3;
            color: #27ae60;
        }

        .status-shipped {
            background: #eaf2f8;
            color: #3498db;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .email-container {
                border-radius: 0;
            }
            
            .email-header {
                padding: 30px 20px;
            }
            
            .order-summary {
                padding: 20px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .items-table {
                display: block;
                overflow-x: auto;
            }
            
            .total-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <div class="header-icon">🎉</div>
            <h1>New Order Received!</h1>
            <p>Order #{{ $order->order_number }} • {{ $order->created_at->format('F j, Y, g:i a') }}</p>
        </div>

        <!-- Order Summary -->
        <div class="order-summary">
            <div class="info-grid">
                <div class="info-card">
                    <h3>Customer Name</h3>
                    <p>{{ $order->shipping_name }}</p>
                </div>
                <div class="info-card">
                    <h3>Payment Method</h3>
                    <p>{{ strtoupper($order->payment_method) }}</p>
                </div>
                <div class="info-card">
                    <h3>Payment Status</h3>
                    <span class="status-badge status-{{ strtolower($order->payment_status) }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
                <div class="info-card">
                    <h3>Shipping Method</h3>
                    <p>{{ ucfirst($order->shipping_method) }}</p>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="customer-section">
                <h2>Customer Information</h2>
                <div class="customer-details">
                    <div class="detail-item">
                        <span class="detail-label">Email Address</span>
                        <span class="detail-value">{{ $order->shipping_email }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Phone Number</span>
                        <span class="detail-value">{{ $order->shipping_phone }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Shipping Address</span>
                        <span class="detail-value">
                            {{ $order->shipping_address }}, {{ $order->shipping_city }}<br>
                            {{ $order->shipping_state }}, {{ $order->shipping_zip }}<br>
                            {{ $order->shipping_country }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="order-items">
                <h2>Order Items ({{ count($order->items) }})</h2>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->category_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₹{{ number_format($item->price, 2) }}</td>
                            <td>₹{{ number_format($item->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Total Section -->
            <div class="total-section">
                <h2>Order Summary</h2>
                <div class="total-grid">
                    <div class="total-item">
                        <div class="total-label">Subtotal</div>
                        <div class="total-value">₹{{ number_format($order->subtotal, 2) }}</div>
                    </div>
                    <div class="total-item">
                        <div class="total-label">Shipping</div>
                        <div class="total-value">₹{{ number_format($order->shipping, 2) }}</div>
                    </div>
                    <div class="total-item">
                        <div class="total-label">Tax (18%)</div>
                        <div class="total-value">₹{{ number_format($order->tax, 2) }}</div>
                    </div>
                    <div class="total-item grand-total">
                        <div class="total-label">Grand Total</div>
                        <div class="total-value">₹{{ number_format($order->total, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <div class="company-logo">PNN OPERATIONS</div>
            <p>Thank you for your business! We're processing your order.</p>
            <div class="footer-links">
                <a href="#">View Order Details</a>
                <a href="#">Track Order</a>
                <a href="#">Contact Support</a>
                <a href="#">Visit Our Store</a>
            </div>
            <div class="copyright">
                © {{ date('Y') }} PNN Operations. All rights reserved.<br>
                This email was sent to you as a notification of a new order.
            </div>
        </div>
    </div>
</body>
</html>