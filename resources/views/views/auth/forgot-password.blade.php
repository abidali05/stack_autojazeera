@extends('layout.panel_layout.main')

@section('title', 'Forgot Password')

@section('content')
<div class="container form-container py-5">
    <div class="row g-0">
        <!-- Left Column -->
        <div class="col-md-6 border-end">
            <h2 class="ps-lg-5 ps-3">Forgot Your Password?</h2>
            <h2 class="ps-lg-5 ps-3">No worries!</h2>
            <img src="{{ asset('web/images/sign-in.png') }}" alt="Forgot Password Illustration" class="mt-3 img-fluid">
            <p class="mt-4 ps-5">Remember your password? 
                <a href="{{ route('login') }}" class="text-decoration-underline fw-bold text-white">Log in here</a>
            </p>
        </div>

        <!-- Right Column -->
        <div class="col-md-6 p-lg-5 p-3">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" id="forgetPasswordForm">
                @csrf
                <section id="forgetSection">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email">
                        @error('email')
                            <span class="invalid-feedback" style="color: #FD5631" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="button" class="btn custom-btn fw-bold rounded w-100 py-3" id="forgetBtn">
                       Submit
                    </button>
                </section>

                <section id="otpSection" class="d-none">
                    <div class="mb-3">
                        <label for="otp" class="form-label">OTP</label>
                        <input id="otp" class="form-control @error('otp') is-invalid @enderror" type="number" name="otp" value="{{ old('otp') }}" required autofocus maxlength="5" placeholder="Enter OTP">
                        @error('otp')
                            <span class="invalid-feedback" style="color: #FD5631" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="button" class="btn custom-btn fw-bold rounded w-100 py-3" id="VerifyOtpBtn">
                        Verify OTP
                    </button>
                </section>

                <section id="passwordSection" class="d-none">
                    <div class="mb-3 position-relative">
                        <label for="password" class="form-label">New Password</label>
                        <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autofocus placeholder="Enter your new password">
                        <span class="position-absolute" style="right: 10px; top: 35px; cursor: pointer;" onclick="togglePasswordVisibility('password', this)">
                            <i class="fa fa-eye"></i>
                        </span>
                        @error('password')
                            <span class="invalid-feedback" style="color: #FD5631" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 position-relative">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" required autofocus placeholder="Confirm your new password">
                        <span class="position-absolute" style="right: 10px; top: 35px; cursor: pointer;" onclick="togglePasswordVisibility('password_confirmation', this)">
                            <i class="fa fa-eye"></i>
                        </span>
                        @error('password_confirmation')
                            <span class="invalid-feedback" style="color: #FD5631" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="button" class="btn custom-btn fw-bold rounded w-100 py-3" id="updatePassBtn">
                        Update Password
                    </button>
                </section>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('customjs/forgetPassword.js') }}"></script>
@endsection
