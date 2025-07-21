@extends('layout.website_layout.main')
@Section('content')


<div class="container form-container py-5">
    <div class="row g-0">
        <!-- Left Column -->
        <div class="col-md-6 border-end">
            <h2 class="ps-lg-5 ps-3">Hey there!</h2>
            <h2 class="ps-lg-5 ps-3">Welcome back.</h2>
            <img src="{{asset('web/images/sign-in.png')}}" alt="Placeholder Image" class="mt-3 img-fluid">
            <p class="mt-4 ps-5">Do you have an account? <a href="#" class="text-white">Sign up here</a></p>
        </div>

        <!-- Right Column -->
        <div class="col-md-6 p-lg-5 p-3">
            @include('auth.social')
            <img src="{{asset('web/images/or.png')}}" alt="" srcset="" class="img-fluid my-3">

            <form action="{{url('request-otp')}}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone No</label>
                    <input type="tel" class="form-control" id="phone-number" name="phoneNumber" placeholder="Enter your phone no">
                </div>
                <button type="submit" class="btn custom-btn fw-bold rounded w-100 mt-3">Get OTP</button>
            </form>

        </div>
    </div>
</div>


<div class="container form-container py-5">
    <!-- OTP input form -->
    <form action="{{url('/verify-otp')}}" method="post">
        @csrf
        <input type="text" id="otp-code" name="otp" placeholder="Enter OTP">
        <input type="text" id="otp-code" name="phoneNumber" placeholder="Enter number">
        <button type="submit">Verify OTP</button>
    </form>
</div>







@endsection