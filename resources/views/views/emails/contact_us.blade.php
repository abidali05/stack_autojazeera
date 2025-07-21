<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get in Touch with Us</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1F1B2D;
        }

        .email-container {
            max-width: auto;
            margin: auto;
            background-color: #29263E;
            border-radius: 10px;
            padding: 20px;
            color: #ffffff;
        }

        .email-header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #ffffff;
        }

        .email-header img {
            height: 50px;
        }

        .email-body {
            margin-top: 20px;
        }

        .email-body h2 {
            font-size: 18px;
            margin-bottom: 20px;
            color: #ffffff;
            text-align: center;
        }

        .email-body p {
            font-size: 14px;
            margin: 10px 0;
            color: #ffffff;
        }

        .email-body span {
            font-weight: bold;
            color: #FD5631;
        }

        .email-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
        }

        .email-footer a {
            color: #FD5631;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div style="text-align: center; padding: 20px; border-bottom: 1px solid #1F1B2D;">
              <img src="{{asset('web/images/emallgo.png') }}" alt="Logo" style="height:50px; width:150px" class="img-fluid">
        </div>

        <!-- Body -->
        <div class="email-body">
            <h2>Contact Form Submission</h2>
            <p><strong>First Name:</strong> <span>{{ $contact->first_name }}</span></p>
            <p><strong>Last Name:</strong> <span>{{ $contact->last_name }}</span></p>
            <p><strong>Email:</strong> <span>{{ $contact->email }}</span></p>
            <p><strong>Phone Number:</strong> 
				<span>
					@php
						$formattedNumber = isset($contact->number) 
							? preg_replace('/^\+92(\d{3})(\d{7})$/', '+92 $1 $2', $contact->number) 
							: $contact->number;
					@endphp
					{{ $formattedNumber }}
				</span>
			</p>
            <p><strong>Message:</strong></p>
            <p>{{ $contact->message }}</p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>If you have any questions, feel free to <a href="{{ url('contact-us') }}">contact us</a>.</p>
        </div>
    </div>
</body>

</html>
