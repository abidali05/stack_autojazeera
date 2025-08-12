@extends('layout.superadmin_layout.main')
@section('content')
    <style>
        .orange {
            color: #FD5631;
        }

        .white {
            color: #281F48;
        }

        .addheading {
            font-size: 35px;
            font-weight: 700;
            color: #FD5631;
        }

        .buttonback {
            border: none !important;
            background-color: #FD5631;
            color: white;
            border-radius: 5px;
            padding: 10px 30px;
            font-size: 15px !important;
        }
    </style>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12 mt-5">
                @if (Request::is('superadmin/*'))
                    <a href="{{ route('superadmin.dashboard') }}" class="buttonback">Go Back To Home</a>
                @else
                    <a href="{{ route('home') }}" class="buttonback">Go Back To Home</a>
                @endif
                <h1 class="addheading mt-3 d-flex align-items-center">Ad Submission Confirmation</h1>
                <p class="white">Ad Submission Confirmation <br>
                    Thank you for submitting your ad! We’ve received it, and our team will review it shortly. We aim to
                    ensure every ad meets our community guidelines and marketplace standards</p>
                <p class="orange">What to Expect Next:</p>
                <ul class="white">
                    <li>Approval: If everything checks out, your ad will be approved, and you’ll be notified via email. Your
                        ad will then go live on the marketplace, ready to reach potential buyers!</li>
                    <li>Rejection: If your ad doesn’t meet our guidelines, don’t worry! We’ll send you an email detailing
                        the necessary changes. Once you make those adjustments, you can easily resubmit your ad for review.
                    </li>
                </ul>
                <p class="orange">Track Your Ad:</p>
                <p class="white">At any time, you can monitor the status of your ad under <a href="{{ url('/ads') }}"
                        class="orange">manage ads</a>. Stay informed about its progress and any required actions.</p>
                <p class="orange">Need Help?</p>
                <p class="white">If you have any questions about the process or need assistance, feel free to reach out to
                    our support team at <span class="orange m-0"
                        style="font-size:16px;"><strong>contactus@autojazeera.pk</strong></span>. We’re here to help ensure
                    your ad gets listed smoothly. </p>
                <p class="white">Thank you for choosing our platform to connect with buyers. We’re excited to help you
                    showcase your product!</p>
            </div>

        </div>
    </div>
@endsection
