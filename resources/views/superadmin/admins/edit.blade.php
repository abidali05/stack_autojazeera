@extends('layout.superadmin_layout.main')

@section('content')
    <style>
        .form-select {
            max-width: 100%;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: white;
            line-height: 24px;
            max-width: 100% !important;
        }

        .select2-container--default .select2-selection--single {
            padding: 10px 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            height: 45px;
            background: #281F48;
        }

        .select2-container--default .select2-results__option {
            padding: 10px 20px;
            background: white;
        }

        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: #281F48;
            color: white;
        }

        .select2-search--dropdown {
            display: block;
            padding: 4px;
            background: #281F48;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            padding: 10px 20px;
            font-size: 14px;
            background: #281F48;
            color: white;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: none;
        }

        .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: transparent transparent white transparent;
            border-width: 0 6px 7px 6px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #888 transparent transparent transparent;
            border-style: solid;
            border-width: 5px 4px 0 4px;
            height: 0;
            left: -118%;
            margin-left: -4px;
            margin-top: 10px;
            position: absolute;
            top: 50%;
            width: 0;
        }

        .form-control {
            background-color: #F0F3F6;
            border: 1px solid #F0F3F6;
            border-radius: 8px;
            padding: 10px;
            color: #281F48;
        }

        .form-control:focus {
            border-color: #281F48;
            box-shadow: none;
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
    </style>

    <div class="container mt-3">
        <div class="row align-items-center mb-3">
            <div class="col-md-12">
                <h2 class="sec mb-0 primary-color-custom">Edit Admin</h2>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
           <div class="p-3 col-md-8 mt-3" style="border: 2px solid #281F48; border-radius: 10px;">
                <form action="{{ route('superadmin.admins.update', $user->id) }}" method="POST" id="adminEditForm">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Name *</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="number" class="form-label">Phone Number *</label>
                        <input type="text" class="form-control" id="number" name="number" value="{{ old('number', $user->number) }}" maxlength="16" placeholder="+92 3XX XXXXXXX" required>
                        @error('number')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password (leave blank to keep unchanged)</label>
                        <input type="password" class="form-control" id="password" name="password">
                        @error('password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('superadmin.admins.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#adminEditForm").validate({
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
                        minlength: 8
                    },
                    password_confirmation: {
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
                        minlength: "Password must be at least 8 characters long"
                    },
                    password_confirmation: {
                        equalTo: "Passwords do not match"
                    }
                },
                errorElement: 'div',
                errorClass: 'text-danger',
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
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
            const numberInput = $('#number');
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

            formatPhoneNumber(numberInput);
        });
    </script>
@endsection