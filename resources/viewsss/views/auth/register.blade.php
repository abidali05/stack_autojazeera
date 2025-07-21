{{--
<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
--}}
@extends('layout.website_layout.main')
@section('content')
<style>
.sign-in-btn {

    line-height: 33px;
}
	.sign-in-btn-google {
  
    line-height: 33px;
}
	.form-control {
  
    line-height: 1.8 !important;
  
}.filter-checkbox {
            appearance: none;
            /* Remove default checkbox styling */
            width: 18px;
            height: 18px;
            border: 2px solid #281F48;
            background-color: white;
            border-radius: 4px;
            /* Optional: rounded corners */
            cursor: pointer;
            display: inline-block;
            position: relative;
        }

        /* Style for the checkbox when checked */
        .filter-checkbox:checked {
            background-color: #281F48;
            border-color: #281F48;
        }

        /* Optional: Add a checkmark icon when checked */
        .filter-checkbox:checked::after {
            content: '✓';
            /* Checkmark */
            color: white;
            font-size: 14px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
.custom-btn-nav {
    background-color: #281F48 !important;
border:1px solid #281F48;
    border-radius: 50px;
    padding: 13px 20px !important;
    color: white ;
    line-height: 23px !important;
    font-size: 15px !important;
}
.custom-btn-nav:hover {
    background-color: white !important;
    color: #281F48 !important;
	border:1px solid #281F48;
	border-radius:5px;
}
.btn.disabled, .btn:disabled, fieldset:disabled .btn {
   color: white;
    pointer-events: none;
    background-color:#281F48 !important;
     border-color:#281F48 ;
 
}
</style>
<div class="container form-container py-5">
        <div class="row g-0">
            <!-- Left Column -->
            <div class="col-md-6 border-end">
                <h2 style="color: #FD5631">Auto Jazeera </h2>
                <p class="mb-0">Streamlining the Connection Between Dealers and Buyers.</p>
                <p style="color: #FD5631">Join
                            Today!</p>
                <img src="{{asset('web/images/sign-up-image.svg')}}" alt="Placeholder Image" class="mt-3 img-fluid">
               <p class="mt-4 grey-color" style="color: #281F48 !important">Already have an account  <a href="{{route('login')}}" class="text-decoration-underline fw-bold "style="color: #FD5631 !important" >Sign in</a></p>
            </div>

            <!-- Right Column -->
            <div class="col-md-6 px-lg-5 p-3">
            @include('auth.social')
            <div class="d-flex justify-content-center"><img
                src="https://determined-gauss.213-165-90-222.plesk.page/web/images/or.png" alt=""
                srcset="" class="img-fluid my-3 w-100"></div>
                <form class="" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter your full name" name="name" value="{{old('name')}}" required autofocus autocomplete="name" oninput="validateName(this)">
                        
                        <x-input-error :messages="$errors->get('name')" class="mt-2" style="color: #FD5631" />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter your email"  type="email" name="email" value="{{old('email')}}" required autocomplete="email">

                        <x-input-error :messages="$errors->get('email')"  style="color: #FD5631" />
                    </div>
                    <div class="mb-3 position-relative d-none">
                        <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter your password"    name="password"
                                 autocomplete="new-password">
                            <span class="position-absolute" style="right: 10px; top: 35px; cursor: pointer;" onclick="togglePasswordVisibility('password', this)">
                                <i class="fa fa-eye" style="color: #FD5631"></i>
                            </span>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" style="color: #FD5631" />
                    </div>
                    <div class="mb-3 position-relative d-none">
                        <label for="c-password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            placeholder="Enter your confirm password" name="password_confirmation" autocomplete="new-password">
                            <span class="position-absolute" style="right: 10px; top: 35px; cursor: pointer;" onclick="togglePasswordVisibility('password_confirmation', this)">
                                <i class="fa fa-eye" style="color: #FD5631"></i>
                            </span>
                          <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" style="color: #FD5631" />
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <input type="checkbox" class="filter-checkbox me-2" id="exampleCheck1">
                        <label class="form-check-label grey-color" style="color: #281F48 !important" for="exampleCheck1">By joining, I agree to the <a  style="color: #FD5631" href="{{route('term_condition')}}" class="text-decoration-underline fw-bold ">Terms of
                        use</a> and <a  style="color: #FD5631" href="{{route('privacy_policy')}}" class="text-decoration-underline fw-bold ">Privacy policy</a></label>
                    </div>
                    <button type="submit" class="btn custom-btn-nav fw-bold rounded w-100 py-5 signupbtn" style="border: 1px solid #281F48" disabled>Continue with Email</button>
                </form>
				{{--<p class="float-end">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-decoration-underline fw-bold text-white">Sign in</a>
                </p>--}}
            </div>
        </div>
    </div>
<script src="{{ asset('customjs/forgetPassword.js') }}"></script>
<script>
    function validateName(input) {
        input.value = input.value.replace(/[^a-zA-Z\s']/g, '');
    }

    $('#exampleCheck1').change(function (e) { 
        e.preventDefault();
        if($(this).prop('checked')){
            $('.signupbtn').prop('disabled', false);
        }
        else{
            $('.signupbtn').prop('disabled', true);
        }
        
    });
</script>
@endsection