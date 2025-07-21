<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shop Status Update</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;700&display=swap');
    </style>
</head>
<body style="font-family: 'Inter', sans-serif; margin: 0; padding: 0; background-color: #f6f6f6;">
    <div style="width: auto; margin: auto; background-color: #ffffff; border-radius: 10px; padding: 20px; color: #1F1B2D;">
        
        <!-- Header -->
        <div style="text-align: center; padding: 20px; border-bottom: 1px solid #eee;">
            <img src="{{ asset('web/images/emallgo.png') }}" alt="AutoJazeera" style="height:50px; width:150px;">
        </div>

        <!-- Body -->
        <div style="margin-top: 30px;">
            <h2 style="font-size: 18px; font-weight: 700; color: #1F1B2D; text-align: center; margin: 0;">
                🛠️ Shop Status Updated
            </h2>
            <p style="font-size: 14px; color: #1F1B2D; text-align: center; margin-top: 10px;">
                The status of your shop <strong>{{ $shop->name ?? 'Your Shop' }}</strong> has been updated to:
            </p>
            <p style="font-size: 16px; font-weight: bold; text-align: center; color: {{ $shop->status == '1' ? '#0EB617' : ($shop->status == '0' ? '#BF0000' : '#FFA500') }}">
                {{ $shop->status == '1' ? 'Active' : ($shop->status == '2' ? 'Rejected' : 'Inactive') }}
            </p>
            @if ($shop->status == '2')

                 <p style="font-size: 14px; color: #1F1B2D; text-align: center; margin-top: 10px;">
            <b>Reason for Rejection: </b>    {{ $shop->rejection_reason}}
            </p>
            @endif
        </div>

        <!-- CTA -->
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ route('shopdetail', $shop->id) }}"
               style="background-color: #FD5631; color: #ffffff; font-size: 14px; font-weight: 600; padding: 10px 25px; border-radius: 8px; text-decoration: none;">
                View Shop
            </a>
        </div>

        <!-- Footer -->
        <div style="margin-top: 40px; text-align: center;">
            <p style="font-size: 13px; color: #1F1B2D; font-weight: 300;">
                If you have any questions, feel free to 
                <a href="{{ url('contact-us') }}" style="color: #FD5631; text-decoration: none;">contact us</a>.
            </p>
        </div>

        <!-- Socials -->
        <div style="text-align: center; margin-top: 30px;">
            <div style="display: flex; justify-content: center; gap: 10px;">
                <img src="{{ asset('web/images/email_assets/images/facebook.png') }}" alt="Facebook" style="width: 30px;">
                <img src="{{ asset('web/images/email_assets/images/insta1.png') }}" alt="Instagram" style="width: 30px;">
                <img src="{{ asset('web/images/email_assets/images/lasttwuiter.png') }}" alt="Twitter" style="width: 30px;">
                <img src="{{ asset('web/images/youtube.png') }}" alt="YouTube" style="width: 30px;">
                <img src="{{ asset('web/images/tiktok.png') }}" alt="TikTok" style="width: 30px;">
            </div>
        </div>
    </div>
</body>
</html>
