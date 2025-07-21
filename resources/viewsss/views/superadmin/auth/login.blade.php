@extends('layout.website_layout.main')
@Section('content')
<style>
.form-control {
    display: block;
    width: 100%;
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 2.3 !important;
    color: var(--bs-body-color);
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: var(--bs-body-bg);
    background-clip: padding-box;
    border: var(--bs-border-width) solid var(--bs-border-color);
    border-radius: var(--bs-border-radius);
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}
	.input-group-text {
    display: flex;
    align-items: center;
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: var(--bs-body-color);
    text-align: center;
    white-space: nowrap;
     background-color:transparent; 
    border: var(--bs-border-width) solid var(--bs-border-color);
    border-radius: var(--bs-border-radius);
    color: white;
}
</style>
<div class="container form-container py-5">
        <div class="row g-0">
            <!-- Left Column -->
            <div class="col-md-6 border-end">
                <h2 class="ps-lg-5 ps-3" style="color:#281F48">Hey there!</h2>
                <h2 class="ps-lg-5 ps-3" style="color:#281F48">Welcome to <span style="color: #FD5631"> Auto Jazeera</span>.</h2>
                <img src="{{asset('web/images/sign-in.png')}}" alt="Placeholder Image" class="mt-3 img-fluid">
               
            </div>

            <!-- Right Column -->
            <div class="col-md-6 px-lg-5 p-3 mt-md-5">
            <h2 class="text-capitalize mb-lg-4" style="color:#281F48">Superadmin login</h2>
   

                <form method="POST" action="{{ route('superadmin.login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email">
                        @error('email')
                    <div class="alert ">{{ $message }}</div>
                  
                    @enderror
                    </div>
                  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <div class="input-group p-0" style="border:1px solid white ; border-radius:5px">
        <input type="password" class="form-control" id="password" name="password" style="border:none" placeholder="Enter your password">
<span class="input-group-text" id="toggle-password" style="cursor: pointer; border: 1px solid #281F48 !important;">

            <i class="bi bi-eye-slash" style="color:#281F48" id="eye-icon"></i> <!-- Eye icon initially set to "closed" -->
        </span>
    </div>
    @error('password')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
                  
                    <button type="submit" class="btn custom-btn fw-bold rounded w-100 py-3">Sign In</button>
                </form>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function() {
        $('#toggle-password').click(function() {
            // Toggle password visibility
            var passwordField = $('#password');
            var icon = $('#eye-icon');

            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                icon.removeClass('bi-eye-slash').addClass('bi-eye'); // Change icon to open eye
            } else {
                passwordField.attr('type', 'password');
                icon.removeClass('bi-eye').addClass('bi-eye-slash'); // Change icon to closed eye
            }
        });
    });
</script>
@endsection

