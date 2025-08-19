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

        .form-label {
            color: #281F48;
            font-weight: 600;
            font-size: 18px;
        }

        .btn-primary {
            background-color: #281F48;
            border-color: #281F48;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
        }

        .btn-secondary {
            background-color: #F0F3F6;
            border-color: #281F48;
            color: #281F48;
            padding: 10px 20px;
            border-radius: 8px;
        }

        .alert-danger {
            background-color: #FD5631;
            color: white;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
        }

        .alert-danger ul {
            margin: 0;
            padding-left: 20px;
        }

        .custom-btn-nav {
            background-color: #281F48;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
        }

        .custom-btn-nav:hover {
            background-color: #FD5631;
            color: white;
        }
    </style>

    <div class="container py-3 py-lg-3">
        <div class="row">
            <div class="col-md-12 mb-3 d-flex align-items-center">
                <h2 class="sec mb-0 primary-color-custom">Create Admin</h2>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="p-3 col-md-8 mt-3" style="border: 2px solid #281F48; border-radius: 10px;">
                <form method="POST" action="{{ route('superadmin.admins.store') }}" id="adminCreateForm">
                    @csrf

                    <div class="mb-2">
                        <label for="name" class="form-label">Full Name *</label>
                        <div class="input-groups" style="padding: 0px !important;">
                            <input type="text" class="form-control formcontrol" name="name" id="name"
                                value="{{ old('name') }}" placeholder="Enter full name" required>
                        </div>
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="email" class="form-label">Email *</label>
                        <div class="input-groups">
                            <input type="email" class="form-control formcontrol" name="email" id="email"
                                value="{{ old('email') }}" placeholder="Enter email" required>
                        </div>
                        @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="phone-number" class="form-label">Phone Number *</label>
                        <div class="input-groups">
                            <input type="tel" class="form-control formcontrol" name="number" id="phone-number"
                                value="{{ old('number') }}" placeholder="+92 3XX XXXXXXX" maxlength="16" required>
                        </div>
                        @error('number')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                        <small id="phone-error" class="text-danger" style="display:none;"></small>
                    </div>

                    <div class="mb-2">
                        <label for="password" class="form-label">Password *</label>
                        <div class="input-groups">
                            <input type="password" class="form-control formcontrol" name="password" id="password"
                                placeholder="Enter password" required>
                        </div>
                        @error('password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="password_confirmation" class="form-label">Confirm Password *</label>
                        <div class="input-groups">
                            <input type="password" class="form-control formcontrol" name="password_confirmation"
                                id="password_confirmation" placeholder="Confirm password" required>
                        </div>
                        @error('password_confirmation')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('superadmin.admins.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary custom-btn-nav">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#adminCreateForm").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 255
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 255
                    },
                    number: {
                        required: true,
                        pattern: /^\+92 3\d{2} \d{7}$/
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    name: {
                        required: "Please enter the admin's name",
                        maxlength: "Name cannot exceed 255 characters"
                    },
                    email: {
                        required: "Please enter the admin's email",
                        email: "Please enter a valid email address",
                        maxlength: "Email cannot exceed 255 characters"
                    },
                    number: {
                        required: "Please enter the admin's phone number",
                        pattern: "Please enter a valid phone number in format: +92 3XX XXXXXXX"
                    },
                    password: {
                        required: "Please enter a password",
                        minlength: "Password must be at least 8 characters long"
                    },
                    password_confirmation: {
                        required: "Please confirm the password",
                        equalTo: "Passwords do not match"
                    }
                },
                errorElement: 'div',
                errorClass: 'text-danger',
                errorPlacement: function(error, element) {
                    error.insertAfter(element.closest('.input-groups'));
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },
                invalidHandler: function(event, validator) {
                    $('html, body').animate({
                        scrollTop: $(validator.errorList[0].element).offset().top - 100
                    }, 500);
                }
            });

            // Phone number formatting
            const numberInput = $('#phone-number');
            function formatPhoneNumber(input) {
                let value = input.val().replace(/\D/g, '');
                if (!value.startsWith('92')) {
                    value = '92' + value;
                }
                value = value.substring(0, 12);
                let formatted = '+92';
                if (value.length > 2) {
                    formatted += ' ' + value.substring(2, 5);
                }
                if (value.length > 5) {
                    formatted += ' ' + value.substring(5, 12);
                }
                input.val(formatted);
            }

            numberInput.on('input', function() {
                formatPhoneNumber($(this));
            });

            numberInput.on('keydown', function(e) {
                if (this.selectionStart <= 4 && (e.key === 'Backspace' || e.key === 'Delete')) {
                    e.preventDefault();
                }
            });

            // Apply formatting on page load if there's an old value
            if (numberInput.val()) {
                formatPhoneNumber(numberInput);
            }
        });
    </script>
@endsection