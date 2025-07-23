@extends('layout.website_layout.main')
@Section('content')
<style>
.form-control {
 
    line-height: 2.5;
   
}.custom-btn {
    background-color: #FD5631;
    border: 0px;
    border-radius: 50px;
    padding: 17px 45px;
    color: white;
    line-height: 15px;
}
	.custom-btn:hover{
	    padding: 17px 45px;
	}
</style>

<div class="container form-container py-5">
    <div class="row g-0">
        <!-- Left Column -->
        <div class="col-md-6 border-end">
            <h2 class="ps-lg-5 ps-3" style="color:#281F48 !important">Hey there!</h2>
            <h2 class="ps-lg-5 ps-3" style="color:#281F48 !important">Welcome back.</h2>
            <img src="{{ asset('web/images/sign-in.png') }}" alt="Placeholder Image" class="mt-3 img-fluid">
            <p class="mt-4 ps-5">Do you have an account? <a href="{{route('register')}}" class="" style="color: #FD5631">Sign up here</a></p>
        </div>

        <!-- Right Column -->
        <div class="col-md-6 p-lg-5 p-3">
            @include('auth.social')
            <img src="{{ asset('web/images/or.png') }}" alt="" class="img-fluid my-3">

            <!-- OTP Request Form -->
            <form id="request-otp-form" method="post"  action="{{ url('request-otp') }}" @if(isset($phoneNumber)) style="display:none" @endif>
                @csrf
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    
                @endif
                @if (session('error'))
                    <div class="alert alert-success" role="alert">
                        {{ session('error') }}
                    </div>
                    
                @endif
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone No</label>
                    <input type="tel" class="form-control" id="phone-number" name="phoneNumber" placeholder="+92 300 0000000"  required>
					
                </div>
                <button type="submit" onclick="sendOTP()" class="btn custom-btn fw-bold rounded w-100 mt-3">Get OTP</button>
            </form>

            <!-- OTP Verification Form (Initi   ally Hidden) -->
            <form id="verify-otp-form"  method="post" action="{{ url('verify-otp') }}" @if(!isset($phoneNumber)) style="display:none" @endif>
                @csrf
                <div class="mb-3">
                <input type="tel" class="form-control" id="phone-number1" value="{{$phoneNumber??''}}" name="phoneNumber" placeholder="+92 300 0000000">
                    <label for="otp" class="form-label">OTP</label>
                    <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP">
                </div>
                <button type="submit" onclick="verifyOTP()" class="btn custom-btn fw-bold rounded w-100 mt-3">Verify OTP</button>
            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    $('#phone-number').on('input', function () {
        let phoneValue = $(this).val().replace(/[^0-9]/g, '').replace(/^92/, ''); // Remove non-numeric & extra 92
        let formatted = '+92 ' + phoneValue.substring(0, 3) + (phoneValue.length > 3 ? ' ' + phoneValue.substring(3, 11) : '');
        $(this).val(formatted.substring(0, 15)); // Limit max length of "+92 XXX XXXXXXXX"

        // Show/hide error message based on correct format
        $('#phone-error').toggle(!/^\+92 \d{3} \d{8}$/.test(formatted));
    });
});
</script>
@endsection
