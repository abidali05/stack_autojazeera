<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trial Midway</title>
</head>
<body style="font-family: 'Inter', sans-serif; padding: 30px; background: #f4f4f4;">
    <div style="max-width: 600px; margin: auto; background: white; padding: 25px; border-radius: 10px;">
        <h2 style="color: #FD5631;">Trial Expires in 15 Days</h2>
        <p>Hello {{ $user->name }},</p>
        <p>You're halfway through your <strong>{{ $plan_name }}</strong> trial on Auto Jazera.</p>
        <p>Your trial will end on <strong>{{ $trial_end_date }}</strong>.</p>
        <p style="margin-bottom:20px;">To continue using premium features without interruption, please add a valid payment method.</p>
        <a href="{{ url('subscription') }}" style="padding: 10px 20px; background-color: #FD5631; color: white; text-decoration: none; border-radius: 5px; margin-top: 40px;">Upgrade Now</a>
        <p style="margin-top: 30px;">Need help? <a href="{{ url('contact-us') }}" style="color: #FD5631;">Contact us</a>.</p>
    </div>
</body>
</html>
