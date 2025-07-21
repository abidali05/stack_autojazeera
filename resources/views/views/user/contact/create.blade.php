@extends('layout.website_layout.main')
@section('content')
@if(session('success'))
	
<div class="modal fade" id="contactsuccessmodal" tabindex="-1" aria-labelledby="contactsuccessmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" >
            <!-- Modal Header -->
            <div class="modal-header" >
                <h5 class="modal-title" id="contactsuccessmodalLabel">Success</h5>
                <button type="button" class="btn-close"  data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body text-center p-4" >
                <i class="bi bi-patch-check-fill fs-1"></i>
                
                <h6 class="" style="line-height: 1.6; color:#281F48">
                    {{session('success')}}
                    <br><br>
                    
                </h6>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer justify-content-center border-0">
                <a href="#" class="btn btn-light px-4 py-2 " style="background-color: white; font-weight:600; color: #FD5631; border-radius: 5px;" data-bs-dismiss="modal">close</a>
                
            </div>
        </div>
    </div>
</div>
 <script>
        // Show the modal when the page loads
        document.addEventListener('DOMContentLoaded', function () {
            const myModal = new bootstrap.Modal(document.getElementById('contactsuccessmodal'));
            myModal.show();
        });
    </script>

@endif
<div class="container my-5">
        <h2 class="sec mb-4 primary-color-custom">Contact us</h2>
        <form method="post" action="{{route('contactUs')}}">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label for="firstName" class="form-label">First Name*</label>
                    <input type="text" class="form-control formcontrol" name="first_name" id="firstName" placeholder="Enter your first name" >
                    @error('first_name')
                        <div class="alert ">{{ $message }}</div>
                        @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="lastName" class="form-label">Last Name*</label>
                    <input type="text" class="form-control formcontrol" name="last_name" id="lastName" placeholder="Enter your last name" >
                    @error('last_name')
                        <div class="alert ">{{ $message }}</div>
                        @enderror
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email*</label>
                        <input type="email" class="form-control formcontrol" name="email" id="email" placeholder="Enter your email" >
                        @error('email')
                        <div class="alert ">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="phoneNo" class="form-label">Phone No</label>
                            <input type="tel" class="form-control formcontrol" name="number" id="phone-number" name="PhoneNumber" placeholder="+92 000 0000000">
                            @error('number')
                        <div class="alert ">{{ $message }}</div>
                        @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control formcontrol" id="message" name="message" style="    line-height: 1.2 !important;" rows="4" placeholder="Type a message..."
                    maxlength="1000"></textarea>
                    @error('message')
                        <div class="alert ">{{ $message }}</div>
                        @enderror
            </div>

            <div class="form-text mb-3" style="color: #FD5631;">
                By entering your details and clicking “SUBMIT” you consent to be contacted by Auto Jazeera Team.
            </div>

            <button type="submit" class="btn custom-btn-nav rounded px-5">Submit</button>
        </form>
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