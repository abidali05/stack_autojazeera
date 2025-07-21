@extends('layout.panel_layout.main')
@Section('content')
<style>
	.butonnum {
    color: white;
    background-color: #FD5631;
    border: none;
    border-radius: 5px;
    padding: 8px 20px;
    font-size: 14px;
    font-weight: 600;
    position: relative;
    overflow: hidden;
    transition: color 0.3s ease-in-out;
}

.butonnum::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;

    background-color: white;
    transition: left 0.4s ease-in-out;
    z-index: 0;
}

.butonnum:hover::before {
    left: 0;
}

.butonnum:hover {
    color: #1F1B2D; /* Keep text visible */
}

.butonnum span {
    position: relative;
    z-index: 1;
}

</style>
<div class="container mt-5">
	<div class="row d-flex justify-content-center">
		<div class="col-8 p-5" style="background-color: rgba(151, 151, 151, 0.2); border-radius:10px

">  <h2 class="mb-3 text-center" style="color:#FD5631">Verify Your Phone Number</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('verify.number') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ $check->id }}">

        <div class="mb-3">
            <label for="phoneNumber" class="form-label" style="color:white !important">Phone Number</label>
            <input type="tel" class="form-control"  id="phone-number" name="phoneNumber" 
                   value="{{ old('phoneNumber', $check->number ?? '') }}"  maxlength="13" required>
			<small class="text-danger" id="phone-error" style="display:none;">Invalid format! Use +923XXXXXXXXX.</small>
        </div>

        <button type="submit" class="butonnum"><span>Send OTP</span></button>
    </form>

    @if(session('otp_sent'))
    <form action="{{ route('verify.numberOTP') }}" method="POST" class="mt-3">
        @csrf
        <input type="hidden" name="user_id" value="{{ $check->id }}">

        <div class="mb-3">
            <label for="otp" class="form-label"  style="color:white !important">Enter OTP</label>
            <input type="text" class="form-control" id="otp" name="otp" required pattern="[0-9]{6}" title="6-digit OTP">
        </div>

        <button type="submit" class="butonnum"><span>Verify OTP & Login</span></button>
    </form>
    @endif</div>
  </div>
</div>
<script>
document.getElementById('phone-number').addEventListener('input', function (e) {
    let phoneInput = e.target;
    let phoneValue = phoneInput.value;

    // Remove non-numeric and non-plus characters
    phoneInput.value = phoneValue.replace(/[^0-9+]/g, '');

    // Ensure it starts with "+92"
    if (!phoneInput.value.startsWith('+92')) {
        phoneInput.value = '+92';
    }

    // Limit max length to 13
    if (phoneInput.value.length > 13) {
        phoneInput.value = phoneInput.value.slice(0, 13);
    }

    // Show error message if format is incorrect
    const errorMessage = document.getElementById('phone-error');
    if (/^\+92[0-9]{10}$/.test(phoneInput.value)) {
        errorMessage.style.display = 'none';
    } else {
        errorMessage.style.display = 'block';
    }
});
</script>

@endsection

