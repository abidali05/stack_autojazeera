<style>
.sign-in-btn {

    line-height: 33px;
}
	.sign-in-btn-google {
  
    line-height: 33px;
}
	.btn {
	border-left:1px solid #281F48;
	}
	.sign-in-btn-google {
    border-radius: 10px;
    border: 1px, solid, #281F48;
    color: white;
    background-color: #281F48;
}

.sign-in-btn-google:hover {
    border-radius: 10px;
    border: 1px, solid, #281F48;
    color: #281F48;
    background-color:white;
}
</style>

				@if(request()->routeIs('number_login'))
				<a href="{{route('login')}}" class="btn sign-in-btn w-100 mb-3 fw-bold py-2 ">
                    <i class="bi bi-telephone me-lg-3"></i> Continue with Email
                </a>
				@else
				<a href="{{route('number_login')}}" class="btn sign-in-btn w-100 mb-3 fw-bold py-2 ">
                    <i class="bi bi-telephone me-lg-3"></i> Continue with Phone
                </a>
				@endif
                <a href="{{ route('google.login') }}" class="btn sign-in-btn-google w-100 mb-3 py-2 fw-semibold">
                    <img src="{{asset('web/images/google-icon.png')}}" class="me-lg-3" width="20" height="20"> Continue with Google
                </a>
                