@extends('layout.website_layout.main')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <h2 class="mb-4 text-center text-dark">Verify Your Email Address</h2>

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('verify.emailNumber') }}" method="POST" class="mb-4">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $check->id }}">

                    <div class="mb-3">
                        <label for="email" class="form-label text-dark">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email', $check->email ?? '') }}" required>
                    </div>
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                        
                    @enderror

                    <div class="d-grid">
                        <button type="submit" class="btn " style="background-color: #281F48;color: white;">Send OTP</button>
                    </div>
                </form>

                @if (session('otp_sent'))
                    <form action="{{ route('verify.emailNumberOTP') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $check->id }}">

                        <div class="mb-3">
                            <label for="otp" class="form-label">Enter OTP</label>
                            <input type="text" class="form-control" id="otp" name="otp" required
                                pattern="[0-9]{6}" title="6-digit OTP">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn " style="background-color: #281F48; color: white;">Verify OTP & Login</button>
                        </div>
                    </form>
                @endif

            </div>
        </div>
    </div>
@endsection
