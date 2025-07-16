<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subscription Ending Soon</title>
</head>
<body style="font-family: 'Inter', sans-serif; padding: 30px; background: #f4f4f4;">
    <div style="max-width: 600px; margin: auto; background: white; padding: 25px; border-radius: 10px;">
        <h2 style="color: #FD5631;">Your Subscription Will Expire Soon</h2>
        <p>Hello {{ $user->name }},</p>

        <p>Your <strong>{{ $plan_name }}</strong> subscription will expire on <strong>{{ $expiry_date ?? $trial_end_date }}</strong>.</p>

        @isset($amount)
            <p>The next billing amount will be <strong>PKR {{ number_format($amount, 0) }}</strong>.</p>
        @endisset

        <p style="margin-bottom: 20px;">Please ensure your payment method is valid to avoid service interruption.</p>

        <a href="{{ url('subscription') }}" style="padding: 10px 20px; background-color: #FD5631; color: white; text-decoration: none; border-radius: 5px;">Update Payment</a>

        <p style="margin-top: 30px;">Need help? <a href="{{ url('contact-us') }}" style="color: #FD5631;">Contact us</a>.</p>
    </div>
</body>
</html>
