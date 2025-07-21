<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quote Submitted | Auto Jazeera</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;700&display=swap');
    </style>
</head>

<body style="font-family: 'Inter', sans-serif; margin: 0; padding: 0;">
    <div style="background-color: white; border-radius: 10px; padding: 20px;">
        <div style="text-align: center; padding: 20px; border-bottom: 1px solid #1F1B2D;">
            <img src="{{ asset('web/images/emallgo.png') }}" alt="Logo" style="height:50px; width:150px;">
        </div>

        <div style="margin-top: 20px;">
            <p style="color: #1F1B2D; text-align: center; font-size: 16px; font-weight: 700;">Quote Submitted Successfully</p>

            <p style="color: #1F1B2D; font-size: 12px; font-weight: 500;">Thank you for submitting your service quote on Auto Jazeera. Here’s a summary of your request:</p>

            <ul style="color: #1F1B2D; font-size: 12px; font-weight: 500; padding-left: 20px;">
                <li><strong>Shop Name:</strong> {{ $booking->shop->name }}</li>
                <li><strong>Shop Address:</strong> {{ $booking->shop->address }}</li>
                <li><strong>Shop Contact:</strong> {{ $booking->shop->number }}</li>
                <li><strong>Vehicle Type:</strong> {{ $booking->type }}</li>
                <li><strong>Make:</strong> {{ $booking->make_r->name ?? 'N/A' }}</li>
                <li><strong>Model:</strong> {{ $booking->model_r->name ?? 'N/A' }}</li>
                <li><strong>Year:</strong> {{ $booking->year }}</li>
                {{-- <li><strong>Body Type:</strong> {{ $booking->body_type_r->name ?? 'N/A' }}</li> --}}
                <li><strong>Description:</strong> {{ $booking->comments }}</li>
                <li><strong>Selected Services:</strong> @foreach ($booking->booking_services as $service)
                    <span>
                        {{ $service->shop_service->service->name ?? 'N/A' }}    
                    </span>
                @endforeach</li>
            </ul>
        </div>

        <div style="margin-top: 20px;">
            <p style="color: #1F1B2D; font-size: 14px; font-weight: 300;">Need help? <a href="{{ url('contact-us') }}" style="color: #FD5631; text-decoration: none;">Contact us</a></p>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <div style="display: flex; justify-content:space-between; width: 350px; margin: auto;">
                <img src="{{ asset('web/images/email_assets/images/facebook.png') }}" alt="Facebook" style="width: 40px;">
                <img src="{{ asset('web/images/email_assets/images/insta1.png') }}" alt="Instagram" style="width: 40px;">
                <img src="{{ asset('web/images/email_assets/images/lasttwuiter.png') }}" alt="Twitter" style="width: 40px;">
                <img src="{{ asset('web/images/youtube.png') }}" alt="Youtube" style="width: 40px;">
                <img src="{{ asset('web/images/tiktok.png') }}" alt="Tiktok" style="width: 40px;">
            </div>
        </div>
    </div>
</body>

</html>
