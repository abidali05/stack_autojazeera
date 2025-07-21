@extends('layout.panel_layout.main')
@section('content')
<div class="container py-lg-5 py-3">
        <div class="row g-0">
            <!-- Left Column -->
            <div class="col-md-2">
            </div>

            <!-- Center Column -->
         <div class="col-md-6 p-3">

            <h2 class="sec mb-4 primary-color-custom">Login & Security</h2>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form class="border p-3 rounded" method="post" action="{{route('change_password')}}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" value="{{Auth::user()->email}}" readonly>
                    @error('email')
                    <div class="alert ">{{ $message }}</div>
                  
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="old-password" class="form-label">Old Password</label>
                    <input type="password" name="old_password" class="form-control" id="old-password"
                        placeholder="Enter your old Password" autocomplete="off">
                        @error('old_password')
                    <div class="alert ">{{ $message }}</div>
                  
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="new-password"  class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="new-password" placeholder="Enter New Password" autocomplete="off">
                    @error('password')
                    <div class="alert ">{{ $message }}</div>
                  
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="confirm-password" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="confirm-password" placeholder="Enter Confirm Password" autocomplete="off">
                    @error('password_confirmation')
                    <div class="alert ">{{ $message }}</div>
                  
                    @enderror
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn rounded px-5 primary-color-custom"
                        style="background-color: white;">Cancel</button>
                    <button type="submit" class="btn custom-btn-nav rounded px-5">Save changes</button>
                </div>
            </form>
        </div>
            <!-- Right Column -->
            <div class="col-md-4">
                <div class="profile-card">
                    <div class="d-flex">
                        <div class="profile-image">
                            <img src="https://via.placeholder.com/100" alt="Profile Picture">
                        </div>
                        <div class="profile-info">
                            <h5>{{Auth::user()->name}}</h5>
                            <p class="mb-0"><i class="bi bi-telephone-fill primary-color-custom"></i>{{Auth::user()->number}}</p>
                            <p class="mb-2"><i class="bi bi-envelope-fill primary-color-custom"></i> {{Auth::user()->email}}</p>
                        </div>
                    </div>
                    <hr>
                    <p class="mb-2">{{Auth::user()->name}}</p>
                    <hr>
                    <p class="mb-2">{{Auth::user()->email}}</p>
                    <hr>
                    <p class="mb-2">{{Auth::user()->number}}</p>
                    <hr>
                    <p class="mb-2">{{Auth::user()->gender??""}}</p>
                </div>

            </div>
        </div>
    </div>
@include('superadmin.modal.security_popup')
@endsection