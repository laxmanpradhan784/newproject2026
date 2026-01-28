<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->order_number }} - {{ config('app.name') }}</title>
    <style>
        /* Modern Professional Invoice Styles */
        @page {
            margin: 0;
        }
        
        body {
            font-family: 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            background: #f8f9fa;
            margin: 0;
            padding: 30px;
        }
        
        .invoice-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
        }
        
        .invoice-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            position: relative;
        }
        
        .invoice-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(100px, -100px);
        }
        
        .company-info h1 {
            font-size: 32px;
            font-weight: 700;
            margin: 0 0 10px 0;
            letter-spacing: -0.5px;
        }
        
        .company-info p {
            margin: 5px 0;
            opacity: 0.9;
        }
        
        .invoice-meta {
            text-align: right;
        }
        
        .invoice-title {
            font-size: 28px;
            font-weight: 600;
            margin: 0 0 15px 0;
            color: rgba(255, 255, 255, 0.95);
        }
        
        .invoice-number {
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 10px;
            color: rgba(255, 255, 255, 0.9);
        }
        
        .invoice-date {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .invoice-body {
            padding: 40px;
        }
        
        .billing-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .bill-to h3, .order-summary h3 {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin: 0 0 20px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
            display: inline-block;
        }
        
        .address-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        
        .address-box strong {
            display: block;
            font-size: 16px;
            margin-bottom: 10px;
            color: #2c3e50;
        }
        
        .status-badges {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-badge.pending { background: #ffc107; color: #212529; }
        .status-badge.processing { background: #17a2b8; color: white; }
        .status-badge.shipped { background: #007bff; color: white; }
        .status-badge.delivered { background: #28a745; color: white; }
        .status-badge.cancelled { background: #dc3545; color: white; }
        
        .payment-badge {
            background: #6f42c1;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .items-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 30px 0 40px 0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .items-table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .items-table th {
            padding: 18px 20px;
            font-weight: 600;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 14px;
        }
        
        .items-table tbody tr {
            transition: all 0.3s ease;
        }
        
        .items-table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .items-table tbody tr:hover {
            background: #e9ecef;
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }
        
        .items-table td {
            padding: 18px 20px;
            border-bottom: 1px solid #eee;
            font-size: 15px;
        }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        
        .price-cell {
            font-family: 'SF Mono', 'Roboto Mono', monospace;
            font-weight: 600;
        }
        
        .total-row {
            background: #f8f9fa !important;
            font-weight: 600;
        }
        
        .totals-section {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 40px;
            margin-top: 40px;
        }
        
        .notes-box {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            border-left: 4px solid #28a745;
        }
        
        .notes-box h4 {
            color: #28a745;
            margin: 0 0 15px 0;
            font-size: 16px;
            font-weight: 600;
        }
        
        .amount-box {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            border-left: 4px solid #dc3545;
        }
        
        .amount-box h4 {
            color: #dc3545;
            margin: 0 0 20px 0;
            font-size: 16px;
            font-weight: 600;
        }
        
        .amount-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px dashed #dee2e6;
            font-size: 15px;
        }
        
        .amount-row.total {
            font-size: 20px;
            font-weight: 700;
            color: #2c3e50;
            border-bottom: 2px solid #2c3e50;
            margin-top: 10px;
            padding-top: 20px;
        }
        
        .invoice-footer {
            margin-top: 50px;
            padding: 30px 40px;
            background: #2c3e50;
            color: white;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            border-radius: 12px 12px 0 0;
        }
        
        .footer-column h4 {
            font-size: 16px;
            margin: 0 0 15px 0;
            color: #667eea;
            font-weight: 600;
        }
        
        .footer-column p {
            margin: 8px 0;
            opacity: 0.9;
            font-size: 14px;
        }
        
        .watermark {
            position: absolute;
            bottom: 40px;
            right: 40px;
            font-size: 72px;
            font-weight: 900;
            color: rgba(255, 255, 255, 0.05);
            transform: rotate(-15deg);
            pointer-events: none;
        }
        
        /* Print Styles */
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .invoice-container {
                box-shadow: none;
                border-radius: 0;
            }
            
            .watermark {
                display: block;
            }
            
            .no-print { display: none !important; }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .billing-section,
            .totals-section,
            .invoice-footer {
                grid-template-columns: 1fr;
            }
            
            .invoice-header {
                padding: 25px;
            }
            
            .invoice-body {
                padding: 25px;
            }
            
            .items-table {
                display: block;
                overflow-x: auto;
            }
            
            .watermark {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header Section -->
        <div class="invoice-header">
            <div class="watermark">INVOICE</div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div class="company-info">
                    <h1>{{ config('app.name', 'E-COMMERCE STORE') }}</h1>
                    <p>123 Commerce Street, Business City, BC 12345</p>
                    <p>contact@ecommerce.com | +91 99999 99999</p>
                    <p>GSTIN: 27ABCDE1234F1Z5</p>
                </div>
                <div class="invoice-meta">
                    <div class="invoice-title">TAX INVOICE</div>
                    <div class="invoice-number">INVOICE #{{ $order->order_number }}</div>
                    <div class="invoice-date">Date: {{ $order->created_at->format('F d, Y') }}</div>
                </div>
            </div>
        </div>
        
        <!-- Body Section -->
        <div class="invoice-body">
            <!-- Billing & Order Summary -->
            <div class="billing-section">
                <div class="bill-to">
                    <h3>Bill To</h3>
                    <div class="address-box">
                        <strong>{{ $order->shipping_name }}</strong>
                        {{ $order->shipping_email }}<br>
                        📞 {{ $order->shipping_phone }}<br>
                        📍 {{ $order->shipping_address }}, {{ $order->shipping_city }}<br>
                        {{ $order->shipping_state }} - {{ $order->shipping_zip }}, {{ $order->shipping_country }}
                    </div>
                </div>
                
                <div class="order-summary">
                    <h3>Order Summary</h3>
                    <div class="status-badges">
                        <div class="status-badge {{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </div>
                        <div class="payment-badge">
                            {{ strtoupper($order->payment_method) }}
                        </div>
                    </div>
                    @if($order->transaction_id)
                    <div style="margin-top: 15px; background: #f8f9fa; padding: 12px; border-radius: 6px;">
                        <strong>Transaction ID:</strong><br>
                        <code style="font-size: 13px;">{{ $order->transaction_id }}</code>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Order Items Table -->
            <table class="items-table">
                <thead>
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">Product Description</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-right">Unit Price</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $index => $item)
                    <tr>
                        <td class="text-left">{{ $index + 1 }}</td>
                        <td class="text-left">
                            <strong>{{ $item->product_name }}</strong><br>
                            <small style="color: #6c757d; font-size: 13px;">SKU: PROD-{{ $item->product_id }}</small>
                        </td>
                        <td class="text-center">{{ $item->category_name }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right price-cell">₹{{ number_format($item->price, 2) }}</td>
                        <td class="text-right price-cell">₹{{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <!-- Totals Section -->
            <div class="totals-section">
                <div class="notes-box">
                    <h4>📝 Notes & Information</h4>
                    <p>• Thank you for your business! Your order will be processed within 24-48 hours.</p>
                    <p>• All prices include applicable taxes as per Indian regulations.</p>
                    <p>• For any queries regarding this invoice, contact our support team.</p>
                    <p>• Please retain this invoice for your records and warranty claims.</p>
                    <p style="margin-top: 20px; font-style: italic; color: #6c757d;">
                        This is a computer-generated invoice. No signature required.
                    </p>
                </div>
                
                <div class="amount-box">
                    <h4>💰 Amount Summary</h4>
                    <div class="amount-row">
                        <span>Subtotal:</span>
                        <span class="price-cell">₹{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="amount-row">
                        <span>Shipping Charges:</span>
                        <span class="price-cell">₹{{ number_format($order->shipping, 2) }}</span>
                    </div>
                    <div class="amount-row">
                        <span>Tax (18% GST):</span>
                        <span class="price-cell">₹{{ number_format($order->tax, 2) }}</span>
                    </div>
                    <div class="amount-row total">
                        <span>TOTAL AMOUNT:</span>
                        <span class="price-cell">₹{{ number_format($order->total, 2) }}</span>
                    </div>
                    
                    <div style="margin-top: 20px; padding: 15px; background: #e9ecef; border-radius: 6px; font-size: 13px;">
                        <strong>Amount in Words:</strong><br>
                        {{ ucwords(\Illuminate\Support\Str::title($order->total . ' Rupees Only')) }}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer Section -->
        <div class="invoice-footer">
            <div class="footer-column">
                <h4>Delivery Address</h4>
                <p>{{ $order->shipping_address }}</p>
                <p>{{ $order->shipping_city }}, {{ $order->shipping_state }}</p>
                <p>{{ $order->shipping_zip }}, {{ $order->shipping_country }}</p>
                <p>📞 {{ $order->shipping_phone }}</p>
            </div>
            
            <div class="footer-column">
                <h4>Payment Details</h4>
                <p><strong>Method:</strong> {{ strtoupper($order->payment_method) }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                @if($order->payment_method == 'card')
                <p><strong>Card Type:</strong> Credit/Debit Card</p>
                @endif
                <p><strong>Invoice Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
            </div>
            
            <div class="footer-column">
                <h4>Contact & Support</h4>
                <p>📧 support@ecommerce.com</p>
                <p>📞 +91 99999 99999 (10 AM - 7 PM)</p>
                <p>🌐 www.ecommerce.com</p>
                <p style="margin-top: 15px; font-size: 12px; opacity: 0.7;">
                    GST Registration No: 27ABCDE1234F1Z5<br>
                    PAN No: ABCDE1234F
                </p>
            </div>
        </div>
    </div>
    
    <!-- Print Button (Hidden in print) -->
    <div class="no-print" style="text-align: center; margin-top: 30px;">
        <button onclick="window.print()" style="
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 25px;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
        ">
            🖨️ Print / Download Invoice
        </button>
    </div>
    
    <script>
        // Auto print on load (optional)
        // window.onload = function() {
        //     window.print();
        // }
        
        // Print button styling
        document.querySelector('button').onmouseover = function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 8px 20px rgba(102, 126, 234, 0.6)';
        }
        
        document.querySelector('button').onmouseout = function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 5px 15px rgba(102, 126, 234, 0.4)';
        }
    </script>
</body>
</html>