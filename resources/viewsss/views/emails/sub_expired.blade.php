<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subscription Expired</title>
</head>
<body style="font-family: 'Inter', sans-serif; padding: 30px; background: #f4f4f4;">
    <div style="max-width: 600px; margin: auto; background: white; padding: 25px; border-radius: 10px;">
        <h2 style="color: #FD5631;">Subscription Expired</h2>
        <p>Hello {{ $name }},</p>
        <p>Your <strong>{{ $plan_name }}</strong> subscription expired on <strong>{{ $expiry_date }}</strong>.</p>
        <p>Your account is now limited. To restore access, please renew your plan.</p>
        <p>Renewal amount: <strong>PKR {{ number_format($amount, 0) }}</strong>.</p>
        <a href="{{ url('subscription') }}" style="padding: 10px 20px; background-color: #FD5631; color: white; text-decoration: none; border-radius: 5px;">Renew Now</a>
        <p style="margin-top: 30px;">Need assistance? <a href="{{ url('contact-us') }}" style="color: #FD5631;">Contact us</a>.</p>
    </div>
</body>
</html>
