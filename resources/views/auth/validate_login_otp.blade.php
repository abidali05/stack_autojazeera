@extends('layout.website_layout.main')

<style>
    .bubble-container {
        gap: 10px;
    }

    .bubble-container input {
        width: 11%;
        height: 50px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 10px;
        font-size: 20px;
        font-weight: bold;
        background-color: #f5f5f5;
        outline: none;
        transition: border-color 0.2s ease-in-out;
    }

    .butonotp {
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        background-color: #281F48;
        color: white;
        font-weight: 600;
    }

    h5 {
        color: #281F48;
    }
</style>
@section('content')
<<<<<<< HEAD
@if (session('resendOtp'))
    		
<div class="modal fade" id="resendOtp_successmodal" tabindex="-1" aria-labelledby="resendOtp_successmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
            <!-- Modal Header -->
            <div class="modal-header" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
				<h5 class="modal-title" id="resendOtp_successLabel"><strong>OTP Code</strong></h5>
                <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> 
            <!-- Modal Body -->
            <div class="modal-body text-center " style="background-color: #F0F3F6; color: #FD5631;" >
                <i class="bi bi-patch-check-fill fs-1"></i>
                
                <h6 class=" mt-3" style="line-height: 1.6;">
                    {{session('resendOtp')}}
                </h6>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                <a href="#" class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;" data-bs-dismiss="modal">close</a>
                
=======
    @if (session('resendOtp'))
        <div class="modal fade" id="resendOtp_successmodal" tabindex="-1" aria-labelledby="resendOtp_successmodalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                    <!-- Modal Header -->
                    <div class="modal-header"
                        style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                        <h5 class="modal-title" id="resendOtp_successLabel"><strong>OTP Code</strong></h5>
                        <button type="button" class="btn-close"
                            style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body text-center " style="background-color: #F0F3F6; color: #FD5631;">
                        <i class="bi bi-patch-check-fill fs-1"></i>

                        <h6 class=" mt-3" style="line-height: 1.6;">
                            {{ session('resendOtp') }}


                        </h6>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                        <a href="#" class="btn btn-light px-4 py-2 "
                            style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;"
                            data-bs-dismiss="modal">close</a>

                    </div>
                </div>
>>>>>>> b0296916f0f3d52cae520057ae40f1305dc7f0fa
            </div>
        </div>
        <script>
            // Show the modal when the page loads
            document.addEventListener('DOMContentLoaded', function() {
                const myModal = new bootstrap.Modal(document.getElementById('resendOtp_successmodal'));
                myModal.show();
            });
        </script>
    @endif
    <div class="container form-container py-5">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-6 rounded-3 p-5">
                <div class="row card p-4" style="background:#F0F3F6; border-radius:20px">
                    <div class="col-12 text-center" style="color: white;">
                        <h1>Enter OTP</h1>
                        <h6 style="color:#281F48 !important">Enter the 6-digit code that has been sent to your email</h6>
                    </div>
                    <form method="POST" action="{{ route('verifyLoginOtp') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ session('email') }}">
                        <div class="col-12 my-3">
                            <div class="bubble-container d-flex justify-content-center" style="gap: 10px;">
                                <input type="number" maxlength="1" oninput="moveFocus(this, 1)" required name="otp[]">
                                <input type="number" maxlength="1" oninput="moveFocus(this, 2)" required name="otp[]">
                                <input type="number" maxlength="1" oninput="moveFocus(this, 3)" required name="otp[]">
                                <input type="number" maxlength="1" oninput="moveFocus(this, 4)" required name="otp[]">
                                <input type="number" maxlength="1" oninput="moveFocus(this, 5)" required name="otp[]">
                                <input type="number" maxlength="1" oninput="moveFocus(this, 6)" required name="otp[]">
                            </div>
                            @if (session('warning'))
                                <p style="color: #FD5631;" class="text-center my-1">
                                    {{ session('warning') }}
                                </p>
                            @endif

                            <x-input-error :messages="$errors->get('otp')" class="mt-2 text-center"
                                style="color: #FD5631; list-style:none" />
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="butonotp w-100">
                                Confirm
                            </button>
                    </form>
                </div>
                <div class="col-12 text-center mt-2">
                    <form id="resend-otp-form" method="POST" action="{{ route('resendOtp') }}" style="display: inline;">
                        @csrf
                        <input type="hidden" name="email" value="{{ session('email') }}">
                        <a style="color: #FD5631; cursor: pointer;"
                            onclick="document.getElementById('resend-otp-form').submit();">Resend OTP</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        function moveFocus(current, index) {
            const inputs = document.querySelectorAll('.bubble-container input');
            if (current.value && index < inputs.length) {
                inputs[index].focus();
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const inputs = document.querySelectorAll('input[name="otp[]"]');

            inputs.forEach((input, index) => {
                input.addEventListener("input", function() {
                    if (this.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });

                input.addEventListener("paste", function(event) {
                    event.preventDefault();
                    const pasteData = (event.clipboardData || window.clipboardData).getData("text");

                    if (pasteData.length === inputs.length) {
                        pasteData.split("").forEach((char, i) => {
                            if (inputs[i]) {
                                inputs[i].value = char;
                            }
                        });
                        inputs[inputs.length - 1].focus(); // Move focus to the last input
                    }
                });
            });
        });
    </script>
@endsection
