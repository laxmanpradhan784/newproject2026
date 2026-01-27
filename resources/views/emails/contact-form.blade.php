<!DOCTYPE html>
<html>
<head>
    <title>New Contact Form Submission</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            line-height: 1.6; 
            color: #333;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background: #3490dc;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
            margin: -30px -30px 30px -30px;
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #3490dc;
            padding: 15px;
            margin: 15px 0;
        }
        .label {
            font-weight: bold;
            color: #3490dc;
            display: block;
            margin-top: 15px;
        }
        .value {
            margin-bottom: 10px;
            padding: 8px;
            background: #f8f9fa;
            border-radius: 4px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📨 New Contact Form Submission</h1>
            <p>You have received a new message from your website</p>
        </div>

        <div class="label">From:</div>
        <div class="value">{{ $name }} ({{ $email }})</div>

        @if($phone && $phone != 'Not provided')
        <div class="label">Phone:</div>
        <div class="value">{{ $phone }}</div>
        @endif

        <div class="label">Subject:</div>
        <div class="value">{{ $subject }}</div>

       <div class="label">Message:</div>
    <div class="info-box">{{ $messageText }}</div>


        <div class="label">Submitted On:</div>
        <div class="value">{{ $submitted_at }}</div>

        <div class="footer">
            <p>This email was automatically generated from your website contact form.</p>
            <p>Do not reply to this email. To respond, contact: {{ $email }}</p>
        </div>
    </div>
</body>
</html>