<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation #{{ $order->order_number }}</title>
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
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 40px 20px;
            min-height: 100vh;
        }

        .email-wrapper {
            max-width: 700px;
            margin: 0 auto;
        }

        /* Header */
        .email-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .company-logo {
            font-size: 36px;
            font-weight: 800;
            color: #4f46e5;
            letter-spacing: 2px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .company-tagline {
            color: #6b7280;
            font-size: 16px;
            font-weight: 500;
        }

        /* Main Card */
        .confirmation-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            margin-bottom: 30px;
        }

        /* Success Banner */
        .success-banner {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 50px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 36px;
            backdrop-filter: blur(10px);
        }

        .success-banner h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .success-banner p {
            font-size: 18px;
            opacity: 0.9;
            max-width: 500px;
            margin: 0 auto;
        }

        /* Order Info */
        .order-info {
            padding: 40px;
        }

        .order-id-card {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 25px;
            border-radius: 16px;
            margin-bottom: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-id-label {
            font-size: 14px;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .order-id-value {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .order-date {
            text-align: right;
        }

        .order-date-label {
            font-size: 14px;
            opacity: 0.8;
        }

        .order-date-value {
            font-size: 18px;
            font-weight: 600;
        }

        /* Customer Info */
        .customer-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .info-card {
            background: #f8fafc;
            padding: 25px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .info-card h3 {
            color: #4f46e5;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-card p {
            color: #374151;
            font-size: 16px;
            line-height: 1.8;
        }

        /* Order Items */
        .order-items-section {
            margin-bottom: 40px;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e2e8f0;
        }

        .section-icon {
            width: 50px;
            height: 50px;
            background: #4f46e5;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .section-header h2 {
            color: #1f2937;
            font-size: 24px;
            font-weight: 700;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .items-table thead {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        }

        .items-table th {
            padding: 20px;
            text-align: left;
            color: white;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .items-table tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: background-color 0.2s;
        }

        .items-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .items-table td {
            padding: 20px;
            color: #374151;
        }

        .product-name {
            font-weight: 600;
            color: #1f2937;
        }

        .category-badge {
            display: inline-block;
            padding: 6px 12px;
            background: #e0e7ff;
            color: #4f46e5;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Totals */
        .totals-section {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            color: white;
            padding: 40px;
            border-radius: 20px;
        }

        .totals-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .total-item {
            text-align: center;
        }

        .total-label {
            font-size: 14px;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .total-value {
            font-size: 24px;
            font-weight: 700;
        }

        .grand-total {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 30px;
            border-radius: 16px;
            text-align: center;
        }

        .grand-total .total-label {
            font-size: 16px;
            opacity: 0.9;
        }

        .grand-total .total-value {
            font-size: 36px;
        }

        /* Next Steps */
        .next-steps {
            padding: 40px;
            background: #f8fafc;
            border-radius: 20px;
            margin-top: 40px;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .step-item {
            text-align: center;
            padding: 25px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .step-number {
            width: 50px;
            height: 50px;
            background: #4f46e5;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
            margin: 0 auto 20px;
        }

        .step-title {
            color: #1f2937;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .step-desc {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.6;
        }

        /* Footer */
        .email-footer {
            text-align: center;
            padding: 40px 0;
            color: #6b7280;
        }

        .contact-info {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 30px 0;
            flex-wrap: wrap;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #4f46e5;
            text-decoration: none;
            font-weight: 500;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 30px 0;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            background: #e5e7eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4f46e5;
            text-decoration: none;
            font-size: 18px;
            transition: all 0.3s;
        }

        .social-icon:hover {
            background: #4f46e5;
            color: white;
            transform: translateY(-3px);
        }

        .copyright {
            font-size: 14px;
            opacity: 0.7;
            margin-top: 20px;
        }

        /* Responsive */
        @media (max-width: 640px) {
            body {
                padding: 20px 10px;
            }

            .success-banner {
                padding: 30px 20px;
            }

            .success-banner h1 {
                font-size: 24px;
            }

            .order-info {
                padding: 20px;
            }

            .order-id-card {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .order-date {
                text-align: center;
            }

            .items-table {
                display: block;
                overflow-x: auto;
            }

            .steps-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <!-- Header -->
        <div class="email-header">
            <div class="company-logo">PNN</div>
            <div class="company-tagline">Premium Products & Services</div>
        </div>

        <!-- Confirmation Card -->
        <div class="confirmation-card">
            <!-- Success Banner -->
            <div class="success-banner">
                <div class="success-icon">✓</div>
                <h1>Order Confirmed!</h1>
                <p>Thank you for your order, {{ $order->shipping_name }}! We're preparing your items for shipment.</p>
            </div>

            <!-- Order Info -->
            <div class="order-info">
                <!-- Order ID Card -->
                <div class="order-id-card">
                    <div>
                        <div class="order-id-label">Order Number</div>
                        <div class="order-id-value">#{{ $order->order_number }}</div>
                    </div>
                    <div class="order-date">
                        <div class="order-date-label">Order Date</div>
                        <div class="order-date-value">{{ $order->created_at->format('F j, Y, g:i a') }}</div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="customer-info">
                    <div class="info-card">
                        <h3>👤 Customer Details</h3>
                        <p><strong>{{ $order->shipping_name }}</strong><br>
                           {{ $order->shipping_email }}<br>
                           {{ $order->shipping_phone }}</p>
                    </div>

                    <div class="info-card">
                        <h3>📍 Shipping Address</h3>
                        <p>{{ $order->shipping_address }}<br>
                           {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}<br>
                           {{ $order->shipping_country }}</p>
                    </div>

                    <div class="info-card">
                        <h3>🚚 Shipping & Payment</h3>
                        <p><strong>Shipping:</strong> {{ ucfirst($order->shipping_method) }}<br>
                           <strong>Payment:</strong> {{ strtoupper($order->payment_method) }}<br>
                           <strong>Status:</strong> <span style="color: #10b981;">{{ ucfirst($order->payment_status) }}</span></p>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="order-items-section">
                    <div class="section-header">
                        <div class="section-icon">📦</div>
                        <h2>Your Order Items</h2>
                    </div>
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td class="product-name">{{ $item->product_name }}</td>
                                <td><span class="category-badge">{{ $item->category_name }}</span></td>
                                <td>{{ $item->quantity }}</td>
                                <td>₹{{ number_format($item->price, 2) }}</td>
                                <td><strong>₹{{ number_format($item->total, 2) }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Totals -->
                <div class="totals-section">
                    <div class="section-header">
                        <div class="section-icon">💰</div>
                        <h2>Order Summary</h2>
                    </div>
                    
                    <div class="totals-grid">
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
                    </div>

                    <div class="grand-total">
                        <div class="total-label">Total Amount</div>
                        <div class="total-value">₹{{ number_format($order->total, 2) }}</div>
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="next-steps">
                    <div class="section-header">
                        <div class="section-icon">📋</div>
                        <h2>What's Next?</h2>
                    </div>
                    
                    <div class="steps-grid">
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <div class="step-title">Order Processing</div>
                            <div class="step-desc">We're preparing your order for shipment</div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <div class="step-title">Shipping Updates</div>
                            <div class="step-desc">You'll receive tracking information via email</div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <div class="step-title">Delivery</div>
                            <div class="step-desc">Your order will arrive within 3-5 business days</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>Need help with your order? We're here for you!</p>
            
            <div class="contact-info">
                <a href="mailto:support@pnnoperations.com" class="contact-item">
                    ✉️ support@pnnoperations.com
                </a>
                <a href="tel:+911234567890" class="contact-item">
                    📞 +91 1234567890
                </a>
                <a href="https://yourwebsite.com" class="contact-item">
                    🌐 yourwebsite.com
                </a>
            </div>

            <div class="social-links">
                <a href="#" class="social-icon">f</a>
                <a href="#" class="social-icon">in</a>
                <a href="#" class="social-icon">t</a>
                <a href="#" class="social-icon">ig</a>
            </div>

            <div class="copyright">
                © {{ date('Y') }} PNN Operations. All rights reserved.<br>
                This email was sent to {{ $order->shipping_email }} regarding your order #{{ $order->order_number }}
            </div>
        </div>
    </div>
</body>
</html>