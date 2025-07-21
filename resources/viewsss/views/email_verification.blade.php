@extends('layout.panel_layout.main')

@Section('content')
<div class="container">
    <h2 class="mb-3">Verify Your Email Address</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('verify.emailNumber') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ $check->id }}">

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" 
                   value="{{ old('email', $check->email ?? '') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Send OTP</button>
    </form>

    @if(session('otp_sent'))
    <form action="{{ route('verify.emailNumberOTP') }}" method="POST" class="mt-3">
        @csrf
        <input type="hidden" name="user_id" value="{{ $check->id }}">

        <div class="mb-3">
            <label for="otp" class="form-label">Enter OTP</label>
            <input type="text" class="form-control" id="otp" name="otp" required pattern="[0-9]{6}" title="6-digit OTP">
        </div>

        <button type="submit" class="btn btn-success">Verify OTP & Login</button>
    </form>
    @endif
</div>
@endsection
