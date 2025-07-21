@extends('layout.website_layout.main')

@section('content')
    <style>
        .rectangle-border {
            border-radius: 0;
            /* Removes rounded corners */
            border: 2px solid #FD5631;
            /* Makes the border solid and defines the color */
            padding: 15px;
            /* Adds padding for better spacing */
            border-radius: 10px;
            color: #281F48;
        }

        .form-control {
            line-height: 2.5;
        }

        .custom-btn-nav {

            line-height: 25px !important;
        }

        .custom-btn:hover {
            line-height: 20px !important;
        }

        .backcolor {
            color: #281F48 !important;
        }
    </style>
    <div class="container form-container py-5" style="color:#281F48">
        <div class="row g-0">
            <!-- Left Column -->
            <div class="col-md-6 border-end">
                <h2 class="ps-lg-5 ps-3 backcolor">Hey there!</h2>
                <h2 class="ps-lg-5 ps-3 backcolor">Welcome to <span style="color: #FD5631">Auto Jazeera</span>.</h2>
                <img src="{{ asset('web/images/sign-in.png') }}" alt="Placeholder Image" class="mt-3 img-fluid">
                <p class="mt-4 ps-5">
                    Do you have an account?
                    <a href="{{ route('register') }}" class="text-decoration-underline fw-bold "
                        style="color:#FD5631;text-decoration">Sign up here</a>
                </p>
            </div>

            <!-- Right Column -->
            <div class="col-md-6 p-lg-5 p-2">
                @include('auth.social')

                <div class="d-flex justify-content-center">
                    <img src="{{ asset('web/images/or.png') }}" alt="Divider Image" class="img-fluid my-3 w-100">
                </div>



                @if (session('otpshow'))
                    <section id="loginSection" class="d-none">
                    @else
                        <section id="loginSection" class="">
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control rectangle-border" id="email" name="email"
                            placeholder="Enter your email" value="{{ session('otpshow') }}" required>
                    </div>


                    <div class="mb-3 position-relative d-none">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Enter your password">
                        <span class="position-absolute" style="right: 10px; top: 35px; cursor: pointer;"
                            onclick="togglePasswordVisibility('password', this)">
                            <i class="fa fa-eye" style="color: #FD5631"></i>
                        </span>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" style="color: #FD5631" />
                    </div>
                    @error('email')
                        <p class="mt-2" style="color: #FD5631">{!! $message !!}</p>
                    @enderror
                    {{-- <x-input-error :messages="$errors->get('email')" class="mt-2" style="color: #FD5631" />  --}}
                    <button type="submit" class="btn custom-btn-nav  rounded w-100 py-3" style="font-weight:600">Continue
                        with Email</button>

                    @if (session('warning'))
                        <div class="alert alert-warning py-0" role="alert">
                            {{ session('warning') }}
                        </div>
                    @endif
                </form>

                </section>

                @if (session('otpshow'))
                    <section id="otpSection" class="">
                    @else
                        <section id="otpSection" class="d-none">
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="otp" class="form-label">OTP</label>
                        <input type="number" class="form-control" id="otp" name="otp"
                            placeholder="Enter your OTP" required>
                        <x-input-error :messages="$errors->get('otp')" class="mt-2" style="color: #FD5631" />
                    </div>

                    <button type="submit" class="btn custom-btn fw-bold rounded w-100 py-3" id="validateOtpBtn">Validate
                        OTP</button>
                </form>
                </section>

                {{-- <div class="mb-3 text-end">
                    <a href="{{ route('password.forget') }}" class="text-decoration-underline fw-bold text-white">
                        Forgot password?
                    </a>
                </div> --}}
            </div>
        </div>
    </div>
    {{-- <script src="{{ asset('customjs/login.js') }}"></script> --}}
@endsection
