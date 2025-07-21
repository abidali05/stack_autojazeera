<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$data['title']}}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;700&display=swap');
    </style>
</head>

<body style="font-family: 'Inter', sans-serif; margin: 0; padding: 0;">
    <div style="width: 400px; margin: auto; background-color: #1F1B2D; border-radius: 10px; padding: 20px;">
        <div style="text-align: center; padding: 20px; border-bottom: 1px solid #ffffff;">
            <img src="{{ asset('web/images/email_assets/images/logo.png') }}" alt="Logo" style="height: 50px; width: 100px;">
        </div>
        <div style="margin-top: 20px;">
            <p style="color: #ffffff; font-size: 14px; font-weight: 700;">{{$data['title']}}</p>

            <p style="color: #ffffff; font-size: 12px; font-weight: 500; margin-top: 10px;">
                {{$data['body']}}
            </p>

            <div style="background-color: #29263E; border-radius: 10px; padding: 15px; margin-top: 10px; text-align: center;">
                <p style="color: #ffffff; font-size: 14px; font-weight: 700; margin: 0;">Your OTP to Reset Password:</p>
                <p style="color: #FD5631; font-size: 20px; font-weight: 700; margin: 10px 0;">{{$data['otp']}}</p>
            </div>

            <p style="color: #ffffff; font-size: 12px; font-weight: 500; margin-top: 20px;">
                If you didn’t request this, please ignore this email or contact our support team for help — 
                <a href="{{url('contact-us')}}" style="color: red;">contact us anytime</a>.
            </p>

            <p style="color: #ffffff; font-size: 12px; font-weight: 500; margin-top: 20px;">Thank you for using our services!</p>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <div style="display: flex; justify-content: space-between; width: 200px; margin: auto;">
                <button type="button" style="background: none; border: none; padding: 0;">
                    <img src="{{asset('web/images/email_assets/images/facebook.png')}}" alt="Facebook" style="width: 40px;">  
                </button>
                <button type="button" style="background: none; border: none; padding: 0;">
                    <img src="{{asset('web/images/email_assets/images/insta1.png')}}" alt="Instagram" style="width: 40px;">
                </button>
                <button type="button" style="background: none; border: none; padding: 0;">
                    <img src="{{asset('web/images/email_assets/images/Vector.png')}}" alt="Twitter" style="width: 40px;">
                </button>
                <button type="button" style="background: none; border: none; padding: 0;">
                    <img src="{{asset('web/images/email_assets/images/insta.png')}}" alt="Threads" style="width: 40px;">
                </button>
            </div>
        </div>
    </div>
</body>

</html>
