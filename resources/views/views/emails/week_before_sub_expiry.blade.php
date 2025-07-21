<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subscription Ending Soon</title>
</head>
<body style="font-family: 'Inter', sans-serif; padding: 30px; background: #f4f4f4;">
    <div style="max-width: 600px; margin: auto; background: white; padding: 25px; border-radius: 10px;">
        <h2 style="color: #FD5631;">Your Subscription Ends in 7 Days</h2>
        <p>Hello {{ $name }},</p>
        <p>Your <strong>{{ $plan_name }}</strong> subscription will expire on <strong>{{ $expiry_date }}</strong>.</p>
        <p>To avoid service interruption, update your payment method now.</p>
        <p>Next billing amount: <strong>PKR {{ number_format($amount, 0) }}</strong>.</p>
        <a href="{{ url('subscription') }}" style="padding: 10px 20px; background-color: #FD5631; color: white; text-decoration: none; border-radius: 5px;">Update Payment</a>
        <p style="margin-top: 30px;">Questions? <a href="{{ url('contact-us') }}" style="color: #FD5631;">Get Support</a>.</p>
    </div>
</body>
</html>
