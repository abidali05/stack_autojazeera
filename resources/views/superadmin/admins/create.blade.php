@extends('layout.superadmin_layout.main')
@section('content')
    <style>
        .form-control {
            background-color: transparent !important;
            color: #281F48 !important;
            border: 1px solid #281F48 !important;
            border-bottom: 2px solid #F5F5F5;
            border-radius: 0;
            padding: 0px 10px;
            line-height: 2.5 !important;
        }

        .profile-info {
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal;
            max-width: 100%;
            /* Ensures it doesn't exceed container */
        }
    </style>
    <style>
        .custom-modal {
            border-radius: 10px;
            overflow: hidden;
        }

        .custom-modal-header {
            background-color: #FD5631;
            color: white;
            border-bottom: none;
        }

        .custom-close-btn {
            font-weight: 600;
            color: #FD5631;
            background-color: white;
            border-radius: 5px;
            border: none;
            padding: 8px 20px;
        }

        .custom-close-btn:hover {
            background-color: #FD5631;
            color: white;
        }

        .modal-content {
            background-color: #F0F3F6 !important;
        }

        .modal-body {
            background-color: #F0F3F6 !important;
        }

        .form-select {
            max-width: 100%;
            text-align: start;
            background-color: transparent !important;
            border: 1px solid #281F48 !important;
            color: #281F48 !important;
        }

        .formcontrol::placeholder {
            color: #281F48;
        }

        .formcontrol {
            color: #281F48;
        }
    </style>
    <div class="container py-3 py-lg-3">
        <div class="row">
            <div class="col-md-12 mb-3 d-flex align-items-center">

                <h2 class="sec mb-0 primary-color-custom">Profile Information</h2>
            </div>

        </div>
        <div class="row">
            <!-- Center Column -->
            <div class="p-3 col-md-12" style="border: 2px dotted #a9afb4; border-radius: 10px;">
                <form method="POST" action="{{ route('superadmin.admins.store') }}">
                    @csrf
                    <div class="mb-2">
                        <label for="f-name" class="form-label">Full Name</label>
                        <div class="input-groups" style="padding: 0px !important;">
                            <input type="text" class="form-control formcontrol" name="name" id="f-name"
                                placeholder="" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-groups">
                            <input type="email" class="form-control formcontrol" name="email" id="email" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="phone" class="form-label">Phone Number</label>
                        <div class="input-groups">
                            <input type="tel" class="form-control formcontrol" name="number" id="phone-number" placeholder="+92 000 0000000">
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger p-0 m-0 mt-2">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <small class="" style="color:#FD5631" id="phone-error" style="display:none;"></small>
                    </div>

                    <div class="mb-2">
                        <label for="email" class="form-label">Password</label>
                        <div class="input-groups">
                            <input type="password" class="form-control formcontrol" name="password" id="password" required>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="email" class="form-label">Confirm Password</label>
                        <div class="input-groups">
                            <input type="password" class="form-control formcontrol" name="password_confirmation" id="password_confirmation" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="px-5 mt-3 rounded btn custom-btn-nav">Save
                            changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
