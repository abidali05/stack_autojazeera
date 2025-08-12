@extends('layout.superadmin_layout.main')

@section('content')
    <!-- jQuery and jQuery Validation Plugin CDNs -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/additional-methods.min.js"></script>

    <style>
        .orange {
            color: #FD5631
        }

        .custom-switch {
            width: 40px;
            height: 20px;
            background-color: #484553;
            border-radius: 20px !important;
            position: relative;
            cursor: pointer;
            outline: none;
            transition: background-color 0.3s ease;
            border: none;
        }

        .custom-switch::before {
            content: '';
            width: 16px;
            height: 16px;
            background-color: white;
            border-radius: 50%;
            position: absolute;
            top: 2px;
            left: 2px;
            transition: transform 0.3s ease;
        }

        .custom-switch:checked {
            background-color: #FD5631;
        }

        .custom-switch:checked::before {
            transform: translateX(20px);
        }

        /* Hide the default radio button */
        .registeredDealer {
            position: absolute;
            opacity: 0;
        }

        /* Custom radio button styling */
        .registeredDealer+label {
            position: relative;
            padding-left: 30px;
            cursor: pointer;
            display: inline-block;
            color: #fff;
            /* Text color */
            font-size: 16px;
        }

        /* Outer circle */
        .registeredDealer+label::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border: 2px solid #FD5631;
            /* Border color */
            border-radius: 50%;
            /* Makes it a circle */
            background-color: #2E2D3C;
            /* Background color */
            transition: all 0.3s ease;
        }

        /* Inner circle when checked */
        .registeredDealer:checked+label::after {
            content: '';
            position: absolute;
            left: 5px;
            top: 50%;
            transform: translateY(-50%);
            width: 10px;
            height: 10px;
            background-color: #FD5631;
            /* Inner circle color */
            border-radius: 50%;
        }

        /* Hide the default radio button */
        .privateDealer {
            position: absolute;
            opacity: 0;
        }

        /* Custom radio button styling */
        .privateDealer+label {
            position: relative;
            padding-left: 30px;
            cursor: pointer;
            display: inline-block;
            color: #fff;
            /* Text color */
            font-size: 16px;
        }

        /* Outer circle */
        .privateDealer+label::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border: 2px solid #FD5631;
            /* Border color */
            border-radius: 50%;
            /* Makes it a circle */
            background-color: #2E2D3C;
            /* Background color */
            transition: all 0.3s ease;
        }

        /* Inner circle when checked */
        .privateDealer:checked+label::after {
            content: '';
            position: absolute;
            left: 5px;
            top: 50%;
            transform: translateY(-50%);
            width: 10px;
            height: 10px;
            background-color: #FD5631;
            /* Inner circle color */
            border-radius: 50%;
        }

        /* Hide the default checkbox */
        #feature_ad {
            position: absolute;
            opacity: 0;
            pointer-events: none;
            /* Prevent interaction with the default checkbox */
        }

        /* Custom checkbox container */
        #feature_ad+label {
            position: relative;
            padding-left: 35px;
            /* Space for the custom checkbox */
            cursor: pointer;
            display: inline-block;
            color: #fff;
            /* Text color */
            font-size: 16px;
            line-height: 1.5;
            user-select: none;
        }

        /* Outer box of the checkbox */
        #feature_ad+label::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border: 2px solid #281F48;
            /* Border color */
            border-radius: 4px;
            /* Rounded corners */
            background-color: white;
            /* Background color */
            transition: all 0.3s ease;
        }

        /* Checkmark when checked */
        #feature_ad:checked+label::after {
            content: '\2713';
            /* Unicode for a checkmark */
            position: absolute;
            left: 5px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            color: white;
            /* Checkmark color */
        }

        /* Background change when checked */
        #feature_ad:checked+label::before {
            background-color: #281F48;
            border-color: #281F48;
        }

        /* Hover effect */
        #feature_ad+label:hover::before {
            border-color: #281F48;
            /* Lighter border on hover */
            background-color: #281F48;
        }

        /* Hide the default checkbox */
        #negotiatedPrice {
            position: absolute;
            opacity: 0;
            pointer-events: none;
            /* Prevent interaction with the default checkbox */
        }

        /* Custom checkbox container */
        #negotiatedPrice+label {
            position: relative;
            padding-left: 35px;
            /* Space for the custom checkbox */
            cursor: pointer;
            display: inline-block;
            color: #fff;
            /* Label text color */
            font-size: 16px;
            line-height: 1.5;
            user-select: none;
        }

        /* Outer box for the checkbox */
        #negotiatedPrice+label::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border: 2px solid #FD5631;
            /* Border color */
            border-radius: 4px;
            /* Rounded corners */
            background-color: #2E2D3C;
            /* Background color */
            transition: all 0.3s ease;
        }

        /* Checkmark for the checkbox when checked */
        #negotiatedPrice:checked+label::after {
            content: '\2713';
            /* Unicode for a checkmark */
            position: absolute;
            left: 5px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            color: white;
            /* Checkmark color */
        }

        /* Background change for the checkbox when checked */
        #negotiatedPrice:checked+label::before {
            background-color: #FD5631;
            border-color: #FD5631;
        }

        /* Hover effect for the checkbox */
        #negotiatedPrice+label:hover::before {
            border-color: #FF7F50;
            /* Lighter border on hover */
            background-color: #3B3A4B;
            /* Slightly darker background */
        }

        /* Optional styling for the error message */
        .alert {
            margin-top: 5px;
            color: #FF7F50;
            /* Error text color */
            font-size: 14px;
        }

        /* Hide the default radio button */
        .registeredDealer {
            position: absolute;
            opacity: 0;
        }

        /* Custom radio button styling */
        .registeredDealer+.registeredDealer1 {
            position: relative;
            padding-left: 30px;
            cursor: pointer;
            display: inline-block;
            color: #fff;
            /* Text color */
            font-size: 16px;
        }

        /* Outer circle */
        .registeredDealer+.registeredDealer1::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border: 2px solid #FD5631;
            /* Border color */
            border-radius: 50%;
            /* Makes it a circle */
            background-color: #2E2D3C;
            /* Background color */
            transition: all 0.3s ease;
        }

        /* Inner circle when checked */
        .registeredDealer:checked+.registeredDealer1::after {
            content: '';
            position: absolute;
            left: 5px;
            top: calc(50% + 0px);
            transform: translateY(-50%);
            width: 10px;
            height: 10px;
            background-color: #FD5631;
            /* Inner circle color */
            border-radius: 50%;
        }

        /* Hide the default radio button */
        .privateDealer {
            position: absolute;
            opacity: 0;
        }

        /* Custom radio button styling */
        .privateDealer+.privateDealer1 {
            position: relative;
            padding-left: 30px;
            cursor: pointer;
            display: inline-block;
            color: #fff;
            /* Text color */
            font-size: 16px;
        }

        /* Outer circle */
        .privateDealer+.privateDealer1::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border: 2px solid #FD5631;
            /* Border color */
            border-radius: 50%;
            /* Makes it a circle */
            background-color: #2E2D3C;
            /* Background color */
            transition: all 0.3s ease;
        }

        /* Inner circle when checked */
        .privateDealer:checked+.privateDealer1::after {
            content: '';
            position: absolute;
            left: 5px;
            top: calc(50% + 0px);
            transform: translateY(-50%);
            width: 10px;
            height: 10px;
            background-color: #FD5631;
            /* Inner circle color */
            border-radius: 50%;
        }

        .feature_checkbox {
            width: 20px;
            height: 20px;
            background-color: white;
            border: 2px solid #281F48;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .feature_checkbox:checked {
            background-color: #281F48;
            border-color: #281F48;
        }

        .feature_ad {
            width: 20px;
            height: 20px;
            background-color: white;
            border: 2px solid #281F48;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .feature_ad:checked {
            background-color: #281F48;
            border-color: #281F48;
        }

        .custom-switch {
            width: 40px;
            height: 20px;
            background-color: #484553;
            border-radius: 20px !important;
            position: relative;
            cursor: pointer;
            outline: none;
            transition: background-color 0.3s ease;
            border: none;
        }

        .custom-switch::before {
            content: '';
            width: 16px;
            height: 16px;
            background-color: white;
            border-radius: 50%;
            position: absolute;
            top: 2px;
            left: 2px;
            transition: transform 0.3s ease;
        }

        .custom-switch:checked {
            background-color: #FD5631;
        }

        .custom-switch:checked::before {
            transform: translateX(20px);
        }

        .form-select {
            max-width: 100%;
            text-align: start;
            color: #281F48 !important;
            background-color: white !important;
        }
    </style>

    <!-- back header start -->
    <div id="ajaxLoader"
        style="
    display: none;
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(15, 23, 42, 0.85);
    backdrop-filter: blur(12px);
    z-index: 9999;
    animation: fadeIn 0.3s ease-out;
">
        <div
            style="
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    ">
            <!-- Spinner -->
            <div
                style="
            width: 60px;
            height: 60px;
            border: 4px solid #F40000;
            border-top: 4px solid rgba(226, 112, 112, 0.33);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        ">
            </div>

            <!-- Loading Text -->
            <div
                style="
            color: #e2e8f0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 16px;
            font-weight: 500;
            letter-spacing: 0.5px;
            opacity: 0.9;
        ">
                Loading...</div>

            <!-- Progress Dots -->
            <div style="margin-top: 15px;">
                <span
                    style="
                display: inline-block;
                width: 8px;
                height: 8px;
                background: rgba(226, 112, 112, 0.33);
                border-radius: 50%;
                margin: 0 4px;
                animation: pulse 1.5s ease-in-out infinite;
            "></span>
                <span
                    style="
                display: inline-block;
                width: 8px;
                height: 8px;
                background: rgba(226, 112, 112, 0.33);
                border-radius: 50%;
                margin: 0 4px;
                animation: pulse 1.5s ease-in-out 0.3s infinite;
            "></span>
                <span
                    style="
                display: inline-block;
                width: 8px;
                height: 8px;
                background: rgba(226, 112, 112, 0.33);
                border-radius: 50%;
                margin: 0 4px;
                animation: pulse 1.5s ease-in-out 0.6s infinite;
            "></span>
            </div>
        </div>
    </div>

    <style>
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 0.4;
                transform: scale(1);
            }

            50% {
                opacity: 1;
                transform: scale(1.2);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
    <div class="container mt-3">
        <div class="row align-items-center mb-4">

            <div class="col-auto p-0">
                <h2 class="sec mb-0 ms-2 primary-color-custom">Post An Ad</h2>
            </div>

        </div>
    </div>
    <div class="container">
        <div class="row pb-md-5 pt-md-3">
            <div class="col-lg-8">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="adFormmmms" method="post" action="{{ route('superadmin.ads.store') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                    <div class="mb-3 p-3" style="background-color:#F0F3F6;">
                        <label for="dealerSelect" class="form-label" style="color:white">Select Dealer</label>

                        <select class="form-select " id="dealerSelect" name="dealer">

                            <option value="" disabled selected>Select Dealer</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ isset($post) && $post->dealer_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        <div id="dealerSelect-error" class="orange"></div>
                        @error('dealer')
                            <div class="alert ">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Step 2: Basic Info -->
                    {{-- <input type="hidden" value="{{ Auth::user()->id }}" name="dealer"> --}}
                    <div class="mb-3 p-3 rounded" style="background-color:#F0F3F6;">
                        <h4 class="step-header">Basic Info</h4>
                        <div class="mb-3 d-none">
                            <label for="adTitle" class="form-label">Title <span style="color:#FD5631">*</span></label>
                            <input type="text" class="form-control adTitle" name="title" id="adTitle" maxlength="48"
                                placeholder="Enter Ad title e.g. Mercedes-Benz" value="{{ $post->title ?? 'dummy title' }}">
                            <div class="char-counter" id="charCounter">48 characters left</div>
                            @error('title')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-lg-6">
                                <label for="vehicleCondition" class="form-label" style="color:white">Vehicle Condition <span
                                        style="color:#FD5631">*</span></label>
                                <select class="form-select" id="vehicleCondition" name="condition" required>
                                    <option value="">Any</option>
                                    <option value="new"
                                        {{ isset($post) && $post->condition == 'new' ? 'selected' : '' }}>New
                                    </option>
                                    <option value="used"
                                        {{ isset($post) && $post->condition == 'used' ? 'selected' : '' }}>
                                        Used</option>
                                </select>
                                {{-- <div id="vehicleCondition-error" class="orange" style="display: none;">Vehicle condition is
                                    required.</div> --}}
                                @error('condition')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label for="assembly" class="form-label" style="color:white">Assembly <span
                                        style="color:#FD5631">*</span></label>
                                <select class="form-select " name="assembly" id="assembly"required>
                                    <option value="">Any</option>
                                    <option value="local"
                                        {{ isset($post) && $post->assembly == 'local' ? 'selected' : '' }}>
                                        Local</option>
                                    <option value="imported"
                                        {{ isset($post) && $post->assembly == 'imported' ? 'selected' : '' }}>Imported
                                    </option>
                                </select>
                                {{-- <div id="assembly-error" class="orange" style="display: none;">assembly is required.</div> --}}
                                @error('assembly')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{--  <div class="mb-3">
                            <label class="form-label"  style="color:white">What type of seller are you?</label>
                            <div class="form-check">
                                <input class="form-check-input registeredDealer" type="radio" name="dealerType"
                                    id="registeredDealer" value="registered"
                                    {{ isset($post) && $post->company_conection == 'registered' ? 'checked' : '' }}
                                    checked>
                                <label class="form-check-label" for="registeredDealer">I am a registered
                                    dealer</label>

                            </div>
                            <div class="form-check">
                                <input class="form-check-input privateDealer" type="radio" name="dealerType"
                                    id="privateDealer" value="private"
                                    {{ isset($post) && $post->company_conection == 'private' ? 'checked' : '' }}>
                                <label class="form-check-label" for="privateDealer">I am a private
                                    dealer</label>
                            </div>
                            @error('dealerType')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div> --}}
                    </div>

                    <!-- Step 3: Currency & Price -->
                    <div class="mb-3 p-3 rounded" style="background-color:#F0F3F6;">
                        <h4 class="step-header">Price</h4>
                        <div class="row align-items-center mb-3">
                            <div class="col-4">
                                <label for="currencySelect" class="form-label">Currency</label>
                                <input type="hidden" name="currency" id="currencySelect" value="PKR">
                                <p class="mb-0">PKR</p>
                                <!-- <select class="form-select" id="currencySelect" disabled>
                                                                                                <option value="PKR" selected>PKR</option>
                                                                                                <option value="USD">USD</option>
                                                                                                <option value="EUR">EUR</option>
                                                                                            </select> -->
                                @error('currency')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-8">
                                <label for="priceInput" class="form-label" style="color:white">Price <span
                                        style="color:#FD5631">*</span></label>
                                <input type="number" class="form-control validate-field formcontrol" name="price"
                                    id="priceInput" placeholder="Enter price" min="0"
                                    value="{{ $post->price ?? '' }}" required>
                                {{-- <div id="priceInput-error" class="orange" style="display: none;">Price is required.</div> --}}
                                @error('price')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{--  <div class="form-check mb-3">
                            <input class="form-check-input" name="negotiatedPrice" type="checkbox" id="negotiatedPrice"
                                {{ isset($post) && $post->negotiatedPrice == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="negotiatedPrice">Negotiated Price</label>
                            @error('negotiatedPrice')
                                <div class="alert">{{ $message }}</div>
                            @enderror
                        </div> --}}
                    </div>
                    <!-- Step 4: Vehicle Information -->
                    <div class="mb-3 p-3 rounded" style="background-color:#F0F3F6;">
                        <h4 class="step-header">Vehicle information</h4>
                        <input type="hidden" name="step4" value="step4">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="make" class="form-label" style="color:white">Make <span
                                        style="color:#FD5631">*</span></label>
                                <select class="form-select " name="makecompany" id="makecompanydata"required>
                                    <option value="">Any</option>
                                    @foreach ($makes as $make)
                                        <option value="{{ $make->id }}"
                                            {{ isset($post) && $post->make == $make->id ? 'selected' : '' }}>
                                            {{ $make->name }}</option>
                                    @endforeach
                                </select>
                                {{-- <div id="makecompanydata-error" class="orange" style="display: none;">Make is required.
                                </div> --}}
                                @error('makecompany')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="model" class="form-label" style="color:white">Model <span
                                        style="color:#FD5631">*</span></label>
                                <select class="form-select " name="model" id="model"required>
                                    <option value="{{ $post->model ?? '' }}" selected>{{ $post->modelname ?? 'Any' }}
                                    </option>

                                </select>
                                {{-- <div id="model-error" class="orange" style="display: none;">Model is required.</div> --}}
                                @error('model')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="year" class="form-label" style="color:white">Year <span
                                        style="color:#FD5631">*</span></label>
                                <select class="form-select " name="year" id="years"required>
                                    <option value="">Any</option>
                                    @for ($year = now()->year; $year >= 1960; $year--)
                                        <option value="{{ $year }}"
                                            {{ isset($post) && $post->year == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                                {{-- <div id="years-error" class="orange" style="display: none;">Year is required.</div> --}}
                                @error('year')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="mileage" class="form-label" style="color:white">Mileage (Km) <span
                                        style="color:#FD5631">*</span></label>
                                <input type="number" name="mileage" value="{{ $post->milleage ?? '' }}"
                                    class="form-control validate-field formcontrol" id="mileage"
                                    placeholder="e.g., 25000" min="0"required>
                                {{-- <div id="mileage-error" class="orange" style="display: none;">Mileage is required.</div> --}}
                                @error('mileage')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="bodyType" class="form-label" style="color:white">Body Type <span
                                        style="color:#FD5631">*</span></label>
                                <select class="form-select " name="bodyType" id="bodyType"required>
                                    <option value="" disabled selected> Any</option>
                                    @foreach ($bodytypes as $bodytype)
                                        <option value="{{ $bodytype->id }}"
                                            {{ isset($post) && $post->body_type == $bodytype->id ? 'selected' : '' }}>
                                            {{ $bodytype->name }}</option>
                                    @endforeach
                                </select>
                                {{-- <div id="bodyType-error" class="orange" style="display: none;">Body type is required.
                                </div> --}}
                                @error('bodyType')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="doorCount" class="form-label" style="color:white">Door Count <span
                                        style="color:#FD5631">*</span></label>
                                <select class="form-select " name="doorcount" id="doorCount"required>
                                    <option value="">Any</option>
                                    <option value="2" {{ isset($post) && $post->doors == '2' ? 'selected' : '' }}>2
                                    </option>
                                    <option value="4" {{ isset($post) && $post->doors == '4' ? 'selected' : '' }}>4
                                    </option>
                                    <option value="5+" {{ isset($post) && $post->doors == '5+' ? 'selected' : '' }}>5+
                                    </option>
                                </select>
                                {{-- <div id="doorCount-error" class="orange" style="display: none;">Door count is required.
                                </div> --}}
                                @error('doorcount')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fuelType" class="form-label" style="color:white">Fuel Type <span
                                        style="color:#FD5631">*</span></label>
                                <select class="form-select " name="fuelType" id="fuelType"required>
                                    <option value="">Any</option>
                                    <option value="Gasoline"
                                        {{ isset($post) && $post->fuel == 'Gasoline' ? 'selected' : '' }}>Gasoline</option>
                                    <option value="Diesel"
                                        {{ isset($post) && $post->fuel == 'Diesel' ? 'selected' : '' }}>
                                        Diesel</option>
                                    <option value="Electric"
                                        {{ isset($post) && $post->fuel == 'Electric' ? 'selected' : '' }}>Electric</option>
                                    <option value="Petrol"
                                        {{ isset($post) && $post->fuel == 'Petrol' ? 'selected' : '' }}>Petrol</option>
                                    <option value="LPG" {{ isset($post) && $post->fuel == 'LPG' ? 'selected' : '' }}>
                                        LPG</option>
                                    <option value="CNG" {{ isset($post) && $post->fuel == 'CNG' ? 'selected' : '' }}>
                                        CNG</option>
                                    <option value="Hybrid"
                                        {{ isset($post) && $post->fuel == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                </select>
                                {{-- <div id="fuelType-error" class="orange" style="display: none;">Fuel type is required.
                                </div> --}}
                                @error('fuelType')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="seatingCapacity" class="form-label" style="color:white">Seating Capacity
                                    <span style="color:#FD5631">*</span></label>
                                <select class="form-select " name="seatingCapacity" id="seatingCapacity"required>
                                    <option value="">Any</option>
                                    <option value="2"
                                        {{ isset($post) && $post->seating_capacity == '2' ? 'selected' : '' }}>2</option>
                                    <option value="4"
                                        {{ isset($post) && $post->seating_capacity == '4' ? 'selected' : '' }}>4</option>
                                    <option value="5+"
                                        {{ isset($post) && $post->seating_capacity == '5+' ? 'selected' : '' }}>5+</option>
                                </select>
                                {{-- <div id="seatingCapacity-error" class="orange" style="display: none;">Seating capacity is
                                    required.</div> --}}
                                @error('seatingCapacity')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="engineCapacity" class="form-label" style="color:white">Engine Capacity <span
                                        style="color:#FD5631">*</span></label>
                                <select class="form-select " name="engineCapacity" id="engineCapacity"required>
                                    <option value="">Any</option>
                                    <option value="1.6L"
                                        {{ isset($post) && $post->engine_capacity == '1.6L' ? 'selected' : '' }}>1.6L
                                    </option>
                                    <option value="2.0L"
                                        {{ isset($post) && $post->engine_capacity == '2.0L' ? 'selected' : '' }}>2.0L
                                    </option>
                                    <option value="3.0L+"
                                        {{ isset($post) && $post->engine_capacity == '3.0L+' ? 'selected' : '' }}>3.0L+
                                    </option>
                                </select>
                                {{-- <div id="engineCapacity-error" class="orange" style="display: none;">Engine Capacity is
                                    required.</div> --}}
                                @error('engineCapacity')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="transmission" class="form-label" style="color:white">Transmission <span
                                        style="color:#FD5631">*</span></label>
                                <select class="form-select " name="transmission" id="transmission"required>
                                    <option value="">Any</option>
                                    <option value="Automatic"
                                        {{ isset($post) && $post->transmission == 'Automatic' ? 'selected' : '' }}>
                                        Automatic
                                    </option>
                                    <option value="Manual"
                                        {{ isset($post) && $post->transmission == 'Manual' ? 'selected' : '' }}>Manual
                                    </option>
                                </select>
                                {{-- <div id="transmission-error" class="orange" style="display: none;">Transmission is
                                    required.</div> --}}
                                @error('transmission')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="driveType" class="form-label" style="color:white">Drive Type <span
                                        style="color:#FD5631">*</span></label>
                                <select class="form-select " name="driveType" id="driveType"required>
                                    <option value="">Any</option>
                                    <option value="Front Wheel Drive"
                                        {{ isset($post) && $post->drive_type == 'Front Wheel Drive' ? 'selected' : '' }}>
                                        Front
                                        Wheel Drive</option>
                                    <option value="Rear Wheel Drive"
                                        {{ isset($post) && $post->drive_type == 'Rear Wheel Drive' ? 'selected' : '' }}>
                                        Rear
                                        Wheel Drive</option>
                                    <option value="All Wheel Drive"
                                        {{ isset($post) && $post->drive_type == 'All Wheel Drive' ? 'selected' : '' }}>All
                                        Wheel Drive</option>
                                </select>
                                {{-- <div id="driveType-error" class="orange" style="display: none;">Drive type is required.
                                </div> --}}
                                @error('driveType')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="color" class="form-label" style="color:white">Exterior Color <span
                                        style="color:#FD5631">*</span></label>
                                <select class="form-select " name="exterior_color" id="exterior_color"required>
                                    <option value="">Any</option>
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->id }}"
                                            {{ isset($post) && $post->exterior_color == $color->id ? 'selected' : '' }}>
                                            {{ $color->name }}</option>
                                    @endforeach
                                </select>
                                {{-- <div id="exterior_color-error" class="orange" style="display: none;">Exterior color is
                                    required.</div> --}}
                                @error('exterior_color')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-check mb-3 m-2">
                                <input class="form-check-input" name="feature_ad" type="checkbox" id="feature_ad"
                                    {{ isset($post) && $post->feature_ad == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" style="color:#281F48" for="feature_ad">Features Ad <span
                                        style="color:#FD5631">*</span></label>
                                @error('feature_ad')
                                    <div class="alert">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="comments" class="form-label" style="color:white">Dealer Comments <span
                                    style="color:#FD5631">*</span></label>
                            <textarea class="form-control validate-field formcontrol " style="    line-height: 1 !important;"
                                name="dealer_comment" id="comments" rows="4" maxlength="3000"
                                placeholder="Describe your vehicle. These comments will be displayed on your ad." required>{{ $post->comment ?? '' }}</textarea>
                            {{-- <div id="comments-error" class="orange" style="display: none;">Comment is required.</div> --}}
                            <!-- <div class="char-counter" id="commentCharCount">3000 characters left</div> -->
                            @error('dealer_comment')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- Step 5: Vehicle Features -->

                    <div class="mb-3 p-3 rounded" style="background-color:#F0F3F6;">
                        <h4 class="step-header">Features <span class="text-danger">*</span></h4>

                        <div class="feature-section">
                            <h5>Exterior</h5>

                            <!-- Display existing features for the post -->


                            <div class=" row d-flex flex-wrap">
                                <!-- Iterate over dynamic features -->
                                @foreach ($features->where('feature', 'Exterior') as $feature)
                                    <div class="col-md-4 col-6">
                                        <div class="form-check me-3">
                                            <input type="checkbox" name="Features[Exterior][{{ $feature->Sub_feature }}]"
                                                class="form-check-input feature_checkbox"
                                                id="feature_{{ $feature->id }}"
                                                {{ isset($post->feature) && $post->feature->where('feature', 'Exterior')->pluck('feature_name')->contains($feature->Sub_feature) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="feature_{{ $feature->id }}">{{ $feature->Sub_feature }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('Features["Exterior"]')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="feature-section mt-4">
                            <h5>Interior</h5>

                            <div class=" row d-flex flex-wrap">

                                @foreach ($features->where('feature', 'Interior') as $feature)
                                    <div class="col-md-4 col-6">
                                        <div class="form-check me-3">
                                            <input type="checkbox" name="Features[Interior][{{ $feature->Sub_feature }}]"
                                                class="form-check-input feature_checkbox"
                                                id="feature_{{ $feature->id }}"
                                                {{ isset($post->feature) && $post->feature->where('feature', 'Interior')->pluck('feature_name')->contains($feature->Sub_feature) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="feature_{{ $feature->id }}">{{ $feature->Sub_feature }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- <a href="#" class="text-primary" onclick="showMore('interiorFeatures')">Show more</a> -->

                            @error('Features["Interior"]')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="feature-section mt-4">
                            <h5>Safety</h5>

                            <div class=" row d-flex flex-wrap">

                                @foreach ($features->where('feature', 'Safety') as $feature)
                                    <div class="col-md-4 col-6">
                                        <div class="form-check me-3">
                                            <input type="checkbox" name="Features[Safety][{{ $feature->Sub_feature }}]"
                                                class="form-check-input feature_checkbox"
                                                id="feature_{{ $feature->id }}"
                                                {{ isset($post->feature) && $post->feature->where('feature', 'Safety')->pluck('feature_name')->contains($feature->Sub_feature) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="feature_{{ $feature->id }}">{{ $feature->Sub_feature }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- <a href="#" class="text-primary" onclick="showMore('safetyFeatures')">Show more</a> -->

                            <!-- Add more safety features as needed -->
                        </div>
                        @error('Features["Safety"]')
                            <div class="alert ">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Step 6: Upload Photos / Videos -->
                    <div class="mb-3 p-3 rounded" style="background-color:#F0F3F6;">
                        <h4 class="step-header">Photos</h4>

                        <p class="rounded p-3" style="background-color:#281F48; color: white; ">
                            You can upload a minimum of <strong>5</strong> and a maximum of<strong> 30 </strong>photos. The
                            maximum file size per photo is<strong> 8 MB</strong>. Allowed formats: <strong>JPEG, JPG,
                                PNG</strong>.
                        </p>

                        <div class="upload-area border border-dashed rounded p-4 text-center" ondrop="handleDrop(event)"
                            ondragover="event.preventDefault()" ondragleave="event.preventDefault()">
                            <i class="bi bi-cloud-arrow-up fs-1 primary-color-custom mb-3"></i>
                            <p class="mb-2">Maximum 30 files (images)</p>
                            <input type="file" id="fileUpload" class="d-none" name="filedata[]" multiple
                                accept=".jpg, .jpeg, .png, .mp4, .mov"
                                onchange="handleImgUpload(this.files), handleAdPreview(this.files)">
                            {{-- <input type="file" id="fileUpload" class="d-none" name="filedata[]" multiple
                                accept=".jpg, .jpeg, .png, .mp4, .mov"
                                onchange="handleFiles(this.files), handleAdPreview(this.files)"> --}}

                            <a class="btn custom-btn-nav mt-3" onclick="document.getElementById('fileUpload').click();"
                                style="border-radius:5px !important">
                                Select Files
                            </a>
                        </div>
                        @error('filedata')
                            <div class="alert ">{{ $message }}</div>
                        @enderror
                        @if (isset($post->document))
                            @foreach ($post->document as $document)
                                @if ($document->doc_type == 'image')
                                    <image width="100px" height="100px" class="draggable-img"
                                        style="width: 150px; cursor: grab;" draggable="true"
                                        data-index="{{ $loop->index }}"
                                        src="{{ asset('posts/doc/' . $document->doc_name) }}">
                                @endif
                                @if ($document->doc_type == 'video')
                                    <iframe src="{{ asset('posts/doc/' . $document->doc_name) }}"
                                        frameborder="0"></iframe>
                                @endif
                            @endforeach
                        @endif
                        <div id="previewContainer" class="mt-4 d-flex flex-wrap gap-3"></div>
                    </div>

                    <div class="mb-3 p-3 rounded" style="background-color:#F0F3F6;">

                        <h4 class="step-header">Upload Documents <span
                                style="color:white ;font-size:12px">(Optional)</span></h4>
                        <p class="rounded p-3" style="background-color:#281F48; color: white; ">
                            You can upload a maximum of <strong>1 auction sheet</strong> and <strong>1 brochure PDF
                                file</strong>.
                            The maximum file size is <strong>16 MB</strong>. Allowed format: <strong>PDF</strong>.
                        </p>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="upload-area border border-dashed rounded p-4 text-center"
                                    onclick="document.getElementById('brochureUpload').click();">
                                    <i class="bi bi-file-earmark-pdf fs-1 text-danger mb-2"></i>
                                    <p class="mb-0">Click here to upload brochure</p>
                                    <small class="text-muted">(PDF only, max 16 MB)</small>
                                    <input type="file" id="brochureUpload" name="document_brochure" class="d-none"
                                        accept=".pdf" onchange="handleDocumentUpload(this, 'brochurePreview')">
                                </div>
                                <div id="brochurePreview" class="mt-3 text-success"></div>
                            </div>

                            <div class="col-md-6">
                                <div class="upload-area border border-dashed rounded p-4 text-center"
                                    onclick="document.getElementById('auctionSheetUpload').click();">
                                    <i class="bi bi-file-earmark-pdf fs-1 text-danger mb-2"></i>
                                    <p class="mb-0">Click here to upload auction sheet</p>
                                    <small class="text-muted">(PDF only, max 16 MB)</small>
                                    <input type="file" id="auctionSheetUpload" name="document_auction" class="d-none"
                                        accept=".pdf" onchange="handleDocumentUpload(this, 'auctionSheetPreview')">
                                </div>
                                @if (isset($post->document))
                                    @foreach ($post->document as $document)
                                        @if ($document->doc_type == 'Brochure Document')
                                            <div>
                                                <a href="{{ asset('posts/doc/' . $document->doc_name) }}"
                                                    frameborder="0">{{ $document->doc_type }}</a>
                                            </div>
                                        @endif
                                        @if ($document->doc_type == 'Auction Document')
                                            <div>
                                                <a href="{{ asset('posts/doc/' . $document->doc_name) }}"
                                                    frameborder="0">{{ $document->doc_type }}</a>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                                <div id="auctionSheetPreview" class="mt-3 text-success"></div>
                            </div>
                            @error('document_auction')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                            @error('document_brochure')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <!-- Step 8: Location -->
                    <div class="mb-3 p-3 rounded" style="background-color:#F0F3F6;">
                        <h4 class="mb-4 step-header">Location</h4>

                        <div class="row mb-3">
                            {{--
                        <div class="col-md-6">
                            <label for="country" class="form-label" style="color:white">Country / Region <span style="color:#FD5631">*</span></label>
                            <select id="country" name="country" class="form-select">
									  <option value="" disabled selected>Select Country</option>
                                @foreach ($countries as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                                
                                <!-- <option value="pakistan" selected>Pakistan</option> -->
                            </select>
                            @error('country')
                            <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                        --}}
                            <input type="hidden" name="country" value="pakistan">
                            <div class="col-md-12">
                                <label for="state" class="form-label" style="color:white">province <span
                                        style="color:#FD5631">*</span></label>
                                <select id="province" name="province" class="form-select "required>
                                    <option value="" disabled selected>Select province</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}"
                                            {{ isset($post->location) && $post->location->province == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}</option>
                                    @endforeach

                                </select>
                                {{-- <div id="province-error" class="orange" style="display: none;">Province is required.
                                </div> --}}
                                @error('province')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="city" class="form-label" style="color:white">City <span
                                        style="color:#FD5631">*</span></label>
                                <select id="city" name="city" class="form-select "required>
                                    <option
                                        value="{{ isset($post->location) && $post->location->city ? '$post->location->city' : '' }}">
                                        {{ $post->location->cityname ?? '' }}</option>
                                    <!-- @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach   -->
                                </select>
                                {{-- <div id="city-error" class="orange" style="display: none;">City is required.</div> --}}
                                @error('city')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 d-none">
                                <label for="area" class="form-label" style="color:white">Area <span
                                        style="color:#FD5631">*</span></label>
                                <input type="number" id="area" name="area" class="form-control formcontrol"
                                    placeholder="Enter Area code" value="default area">
                            </div>

                        </div>


                        <div class="mb-3">
                            <label for="streetAddress" class="form-label" style="color:white">
                                Street Address <span style="color:#FD5631">*</span>
                            </label>
                            <input type="text" id="streetAddress" name="street_address"
                                class="form-control formcontrol validate-field" style="color:#281F48 !important"
                                placeholder="Enter Address" autocomplete="off" required />
                            {{-- <div id="streetAddress-error" class="orange" style="display: none;">Street address is
                                required.</div> --}}
                        </div>

                        <div class="mb-3 d-none">
                            <label for="map" class="form-label">Display on the map <span
                                    style="color:#FD5631">*</span></label>
                        </div>

                        <div id="map" class="border rounded mb-3 d-none" style="height: 300px;">
                            <!-- <input type="text" id="location" name="location" class="form-control"
                                                                                placeholder=""> -->
                        </div>
                    </div>
                    <!-- Step 9: Contacts -->

                    <div class="mb-3 p-3" style="background-color:#F0F3F6;">
                        <h4 class="step-header">Contacts</h4>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="firstName" class="form-label" style="color:white">First Name <span
                                        style="color:#FD5631">*</span></label>
                                <input type="text" class="form-control validate-field formcontrol" name="firstName"
                                    id="firstName" placeholder="Enter First name"
                                    value="{{ $post->contact->first_name ?? '' }}"required>
                                {{-- <div id="firstName-error" class="orange" style="display: none;">First name is required.
                                </div> --}}
                                @error('firstName')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="secondName" class="form-label" style="color:white">Second Name <span
                                        style="color:#FD5631">*</span></label>
                                <input type="text" class="form-control validate-field formcontrol" name="secondName"
                                    id="secondName" placeholder="Enter last name"
                                    value="{{ $post->contact->last_name ?? '' }}"required>
                                {{-- <div id="secondName-error" class="orange" style="display: none;">Second name is required.
                                </div> --}}
                                @error('secondName')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label" style="color:white">Email <span
                                        style="color:#FD5631">*</span></label>
                                <input type="email" class="form-control  formcontrol" name="email" id="email"
                                    placeholder="Enter Email" value="{{ Auth::user()->email ?? '' }}"required >
                                @error('email')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phoneNumber" class="form-label" style="color:white">Phone Number <span
                                        style="color:#FD5631">*</span></label>
                                <input type="tel" class="form-control formcontrol" name="number" id="phoneNumber"
                                    placeholder="Enter phone number" value="+92" required>
                                @error('number')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 d-none">
                            <label for="website" class="form-label" style="color:white">Website</label>
                            <input type="url" class="form-control formcontrol" name="website" id="website"
                                placeholder="Enter website" pattern="https://.*"
                                value="{{ $post->contact->website ?? '' }}">
                            {{-- <div id="website-error" class="text-danger mt-1" style="display: none;">
                                The website URL must start with <strong>https://</strong>.
                            </div> --}}
                        </div>
                        <!-- <div id="socialMediaSection" class="collapse">
                                                                                        <div class="mb-3">
                                                                                            <label for="facebook" name="facebook" class="form-label">Your Facebook Account *</label>
                                                                                            <input type="url" class="form-control" name="facebookUrl" id="facebook" placeholder="Enter Facebook URL">
                                                                                            @error('facebookUrl')
        <div class="alert ">{{ $message }}</div>
    @enderror
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label for="linkedin" class="form-label">Your LinkedIn Account *</label>
                                                                                            <input type="url" name="linkedin" class="form-control" id="linkedin" placeholder="Eneter LinkedIn URL">
                                                                                            @error('linkedin')
        <div class="alert ">{{ $message }}</div>
    @enderror
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label for="twitter" class="form-label">Your Twitter Account *</label>
                                                                                            <input type="url" name="twitter" class="form-control" id="twitter" placeholder="Twitter URL">
                                                                                            @error('twitter')
        <div class="alert ">{{ $message }}</div>
    @enderror
                                                                                        </div>
                                                                                    </div>

                                                                                    <button type="button" class="btn btn-link text-white" data-bs-toggle="collapse"
                                                                                        data-bs-target="#socialMediaSection" aria-expanded="false">
                                                                                        Show More
                                                                                    </button> -->
                    </div>

                    <div style="display:flex;justify-content:end">
                        {{--   <div>
                            <button type="button" class="btn rounded px-5 primary-color-custom py-2"
                                style="background-color: white;" onclick="scrolltop()">Preview</button>
                        </div>  --}}
                        <div>
                            <input type="button" class="btn custom-btn-nav rounded px-5" value="Save and continue"
                                onclick="submitform();" id="form_submit_btn_fake">
                            <input type="submit" class="btn custom-btn-nav rounded px-5 d-none"
                                value="Save and continue" id="form_submit_btn">
                        </div>
                    </div>
                </form>
                <!-- Include Google Maps API (use your own API key) -->
                <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>

            </div>
            <div class="col-lg-4">
                <div class="wishlist-card">
                    <div class="img-bg-home">

                        <img src="{{ asset('web/images/Group 1171275357.png') }}" class="img-adj-card"
                            id="preview_img_post_ad">
                    </div>
                    <div class="py-lg-3 px-lg-4 p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 id="yearsvalue">-----</h6>
                            <div>
                                <span class="rounded px-3 py-1 text-capitalize featured_label d-none"
                                    style="background-color:#BF0000; font-size:12px; "><img
                                        src="{{ asset('web/images/star-icon.svg') }}"
                                        class="me-2 mb-1 img-fluid">featured</span>
                                <span class="rounded px-3 py-1 text-capitalize" id="vehicleConditionvalue"
                                    style="background-color:#4581F9; font-size:12px;">-----</span>
                            </div>
                        </div>

                        <h4 id="vehiclename" style="color:#281F48">-----</h4>
                        <h5 style="color: #FD5631;"><b id="priceInputvalue">PKR -----</b></h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"> <i class="bi bi-geo-alt"></i>
                                <span id="cityvalue">-----</span>
                            </h6>
                            <span style="font-size:11px;">Last Updated:
                                {{ \carbon\carbon::parse(date('Y-M-d'))->format('F d, Y') }}</span>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-4">
                                <div class="text-center py-1" style="background-color:#EAF4FD; border-radius: 10px;">
                                    <i class="bi bi-speedometer2"></i>
                                    <h6 id="mileagevalue" style="font-size:14px">-----</h6>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center py-1" style="background-color:#EAF4FD; border-radius: 10px;">
                                    <i class="bi bi-car-front-fill"></i>
                                    <h6 id="transmission_value" style="font-size:14px">-----</h6>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center py-1" style="background-color:#EAF4FD; border-radius: 10px;">
                                    <i class="bi bi-fuel-pump-diesel"></i>
                                    <h6 id="fule_type_value" style="font-size:14px">-----</h6>
                                </div>
                            </div>
                        </div>
                        <!-- Row 1 -->
                        <div class="row my-3">
                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Manufacturing Year</strong></span>
                                <span id="manufacturing_year_value">-----</span>
                            </div>

                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Make</strong></span>
                                <span id="makecompanydatavalue">-----</span>
                            </div>
                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Model</strong></span>
                                <span id="modelvalue">-----</span>
                            </div>
                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Transmission</strong></span>
                                <span id="transmissionvalue">-----</span>
                            </div>
                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Assembly</strong></span>
                                <span id="assemblyvalue">-----</span>
                            </div>
                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Door Count</strong></span>
                                <span id="doorCountvalue">-----</span>
                            </div>


                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Fuel Type</strong></span>
                                <span id="fuelTypevalue">-----</span>
                            </div>
                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Engine Capacity</strong></span>
                                <span id="engineCapacityvalue">-----</span>
                            </div>
                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Mileage</strong></span>
                                <span id="mileage_value">-----</span>
                            </div>
                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Body Type</strong></span>
                                <span id="bodyTypevalue">-----</span>
                            </div>
                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Exterior Color</strong></span>
                                <span id="exterior_colorvalue">-----</span>
                            </div>
                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Seating Capacity</strong></span>
                                <span id="seatingCapacityvalue">-----</span>
                            </div>
                        </div>
                        <!-- Features Section -->
                        <div class="features mt-4">
                            <h5 style="color: #FD5631;">Features<span class="text-danger">*</span></h5>
                            <div class="row mt-3">
                                <div class="col-md-6 feature-item">
                                    <i class="bi bi-fan"></i> Air Conditioning
                                </div>
                                <div class="col-md-6 feature-item">
                                    <i class="bi bi-shield-shaded"></i> Air Bags
                                </div>
                                <div class="col-md-6 feature-item">
                                    <i class="bi bi-cassette-fill"></i> Cassette Player
                                </div>
                                <div class="col-md-6 feature-item">
                                    <i class="bi bi-thermometer-half"></i> Cool Box
                                </div>
                                <div class="col-md-6 feature-item">
                                    <i class="bi bi-speedometer2"></i> Cruise Control
                                </div>
                                <div class="col-md-6 feature-item">
                                    <i class="bi bi-disc"></i> DVD Player
                                </div>
                                <div class="col-md-6 feature-item">
                                    <i class="bi bi-speaker"></i> Front Speaker
                                </div>
                                <div class="col-md-6 feature-item">
                                    <i class="bi bi-camera-video"></i> Front Camera
                                </div>
                                <div class="col-md-6 feature-item">
                                    <i class="bi bi-key"></i> Keyless Entry
                                </div>
                                <div class="col-md-6 feature-item">
                                    <i class="bi bi-shield"></i> Immobilizer Key
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    @if (isset($post))
        @include('user.post.preview')
    @endif
    <div class="modal fade" id="preview" tabindex="-1" aria-labelledby="previewLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 10px; overflow: hidden">
                <div class="modal-header" style="background-color: #FD5631; color: white; border-bottom: none;">
                    <h5 class="modal-title" id="previewLabel">Preview Your Ad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="previewContent">
                        <!-- Preview content will be populated here via JavaScript -->
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class=""
                        style="color:white; background-color:#FD5631;padding:5px 20px; border:none;border-radius:5px"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap Modal -->
    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 10px; overflow: hidden">
                <div class="modal-header" style="background-color: #FD5631; color: white; border-bottom: none;">
                    <h5 class="modal-title" id="alertModalLabel">Invalid File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" id="alertModalBody">
                    <!-- Alert message will be inserted here -->
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class=""
                        style="color:white; background-color:#FD5631;padding:5px 20px; border:none;border-radius:5px"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="imageValidationModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 10px; overflow: hidden">
                <div class="modal-header" style="background-color: #FD5631; color: white; border-bottom: none;">
                    <h5 class="modal-title" id="modalTitle">Image Upload Error</h5>
                    <button type="button" class="btn-close" style="background-color: white; color: #FD5631;"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <p id="modalMessage " class="m-0">Please upload at least 5 and at most 30 images.</p>
                </div>
                <div class="modal-footer" style="border:none">
                    <button type="button" class=""
                        style="color:white; background-color:#FD5631;padding:5px 20px; border:none;border-radius:5px"
                        data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places&callback=initAutocomplete"
        async defer></script>

    <script>
        let selectedPlace = false;

        function initAutocomplete() {
            const input = document.getElementById("streetAddress");
            const latitudeInput = document.getElementById("latitude");
            const longitudeInput = document.getElementById("longitude");

            const autocomplete = new google.maps.places.Autocomplete(input, {
                fields: ["formatted_address", "geometry"],
            });

            autocomplete.addListener("place_changed", () => {
                const place = autocomplete.getPlace();
                if (place.geometry) {
                    selectedPlace = true;
                    input.value = place.formatted_address;
                    latitudeInput.value = place.geometry.location.lat();
                    longitudeInput.value = place.geometry.location.lng();
                } else {
                    selectedPlace = false;
                }
            });

            input.addEventListener("blur", () => {
                if (!selectedPlace) {
                    input.value = "";
                    latitudeInput.value = "";
                    longitudeInput.value = "";
                }
            });

            input.addEventListener("input", () => {
                selectedPlace = false;
            });
        }

        window.initAutocomplete = initAutocomplete;
    </script>
    <!-- JavaScript for Step Navigation -->
    <script>
        let firstImageSet = false;

        function showMore(featureId) {
            const moreOptions = document.getElementById(featureId);
            moreOptions.classList.toggle('d-none');
        }

        function handleFiles(files) {
            const previewContainer = document.getElementById('previewContainer');
            previewContainer.innerHTML = ''; // Clear previous previews
            let indexCounter = 0;
            Array.from(files).forEach((file) => {
                if (file.size <= 8 * 1024 * 1024) { // Image limit
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('draggable-img');
                        img.style.width = '150px';
                        img.setAttribute('data-index', indexCounter);
                        previewContainer.appendChild(img);
                        indexCounter++;
                    };
                    reader.readAsDataURL(file);
                } else if (file.size <= 10 * 1024 * 1024 && /\.(mp4|mov)$/i.test(file.name)) { // Video limit
                    const video = document.createElement('video');
                    video.src = URL.createObjectURL(file);
                    video.controls = true;
                    video.style.width = '150px';
                    previewContainer.appendChild(video);
                } else {
                    alert('Invalid file or size exceeds limit!');
                }
            });
        }



        function handleDrop(event) {
            event.preventDefault();
            const files = event.dataTransfer.files;
            handleFiles(files);
        }
        document.addEventListener("DOMContentLoaded", function() {
            const previewContainer = document.getElementById("previewContainer");
            const previewAdImg = document.getElementById("preview_img_post_ad");

            let draggedElement = null;

            // Drag Start
            previewContainer.addEventListener("dragstart", (e) => {
                if (e.target.classList.contains("draggable-img")) {
                    draggedElement = e.target.closest(".preview-item"); // Get the parent preview-item
                    e.dataTransfer.setData("text/plain", ""); // Required for Firefox
                    e.dataTransfer.effectAllowed = "move";
                    console.log("Drag Start:", draggedElement);
                }
            });

            // Drag Over (Allow Drop)
            previewContainer.addEventListener("dragover", (e) => {
                e.preventDefault();
            });

            // Drop (Swap Images)
            previewContainer.addEventListener("drop", (e) => {
                e.preventDefault();

                // Ensure the target is an image and inside previewContainer
                const target = e.target.closest(".draggable-img");
                const targetItem = target ? target.closest(".preview-item") : null;

                console.log('Dropped target:', targetItem);

                // Check if the target element is valid and a child of previewContainer
                if (targetItem && draggedElement !== targetItem && previewContainer.contains(targetItem)) {
                    const items = Array.from(previewContainer.querySelectorAll(".preview-item"));
                    const draggedIndex = items.indexOf(draggedElement);
                    const targetIndex = items.indexOf(targetItem);

                    console.log("Dragged Index:", draggedIndex, "Target Index:", targetIndex);

                    if (draggedIndex !== -1 && targetIndex !== -1) {
                        swapItems(draggedElement, targetItem);
                    } else {
                        console.log("Error: Invalid drag or target element");
                    }
                } else {
                    console.log("Target element is not a valid draggable item.");
                }
            });

            // Swap Function
            function swapItems(dragged, target) {
                console.log('Swapping:', dragged, target); // Debugging the swap

                if (dragged && target) {
                    const parent = previewContainer;

                    // Ensure that both dragged and target are still children of previewContainer
                    if (parent.contains(dragged) && parent.contains(target)) {
                        try {
                            // Insert the dragged element before the target
                            target.parentNode.insertBefore(dragged, target);

                            console.log('Preview-item swapped');
                        } catch (error) {
                            console.log('Error inserting element:', error);
                        }
                    } else {
                        console.log('Dragged or target element is not part of the parent container');
                    }

                    // Update the first image preview
                    if (previewContainer.firstElementChild && previewContainer.firstElementChild.querySelector(
                            "img")) {
                        previewAdImg.src = previewContainer.firstElementChild.querySelector("img").src;
                        console.log('Updated preview image:', previewAdImg.src);
                    }
                }
            }
        });

        function populatePreview() {

            const previewContent = document.getElementById('previewContent');
            previewContent.innerHTML = ''; // Clear previous content

            // Collect data from the form

            // Collect data from the form
            const title = document.getElementById('adTitle').value;
            const condition = document.getElementById('vehicleCondition').value;
            const price = document.getElementById('priceInput').value;
            const make = document.getElementById('makecompanydata').value;
            const model = document.getElementById('model').value;
            const year = document.getElementById('years').value;
            const mileage = document.getElementById('mileage').value;

            // Add collected data to the preview content
            previewContent.innerHTML += `
            <h6>Ad Title: ${title}</h6>
            <p>Condition: ${condition}</p>
            <p>Price: ${price}</p>
            <p>Make: ${make}</p>
            <p>Model: ${model}</p>
            <p>Year: ${year}</p>
            <p>Mileage: ${mileage}</p>
            <!-- Add more fields as needed -->
            <div class="container mb-4">
                        <div class="breadcrumb-nav mb-3">
                            <a href="#" class="breadcrumb-item text-white">Home</a>
                            <span class="breadcrumb-separator">></span>
                            <a href="#" class="breadcrumb-item text-white">${condition}</a>
                            <span class="breadcrumb-separator">></span>
                            <span class="breadcrumb-item active">${model}</span>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">

                                <h2>${modelname} ${year}</h2>
                            </div>
                        
                        </div>
                    </div>
                    <div class="container mb-4">
                        <div class="row">
                        
                            <div class="col-lg-7">
                            
                                <div class="container my-4">
                                    <h5 style="color: #FD5631;">Specifications</h5>

                                    <!-- Row 1 -->
                                    <div class="row">
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Manufacturing Year</strong></span>
                                            <span> ${year}</span>
                                        </div>
                                 
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Make</strong></span>
                                            <span> ${makename}</span>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Model</strong></span>
                                            <span> ${modelname}</span>
                                        </div>
                                    </div>

                                    <!-- Row 2 -->
                                    <div class="row">
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Transmission</strong></span>
                                            <span>${transmission}</span>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Assembly</strong></span>
                                            <span>${assembly}</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Door Count</strong></span>
                                            <span>${doors}</span>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Fuel Type</strong></span>
                                            <span>${fuel}</span>
                                        </div>
                                    </div>

                                    <!-- Row 3 -->
                                    <div class="row">
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Engine Capacity</strong></span>
                                            <span>${engine_capacity}</span>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Mileage</strong></span>
                                            <span>${milleage}</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Body Type</strong></span>
                                            <span>${bodytypename}</span>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Exterior Color</strong></span>
                                            <span>${excolorname}</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Seating Capacity</strong></span>
                                            <span>${seating_capacity}</span>
                                        </div>
                                    </div>

                                    <!-- Features Section -->
                                    <div class="features mt-4">
                                        <h5 style="color: #FD5631;">Features</h5>
                                        <div class="row mt-3">

                                            
                                            <div class="col-md-4 feature-item">
                                                <!-- <i class="bi bi-fan"></i>  -->
                                                ${feature_name}
                                            </div>
                                        



                                        </div>
                                    </div>
                                    <!-- Seller's Description Section -->
                                    <div class="description mt-4">
                                        <h5 style="color: #FD5631;">Seller's Description</h5>
                                        <p>${dealer_comment}.</p>
                                        <div class="mt-3">
                                        
    
                                        </div>
                                    </div>
                                    <!-- Information Section -->
                                    <div class="info-section mt-4">
                                        <div class="row text-start">
                                            <div class="col-md-3">
                                                <div class="info-item">Published:</div>
                                                <div class="info-value">${created_at} </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="info-item">Last Updated:</div>
                                                <div class="info-value">${ updated_at}</div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="info-item">Ad Id:</div>
                                                <div class="info-value">${id}</div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="info-item">Member Since:</div>
                                                <div class="info-value">${ created_at}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="col-lg-5">
                                <div class="row align-items-center mb-4">
                                    <!-- Left Side Buttons -->
                                    <div class="col d-flex align-items-center">
                                        <button class="btn custom-btn-3">${condition}</button>
                                        <!-- <button class="btn custom-btn-3 ms-2">Used</button> -->
                                    </div>

                                
                                </div>
                                <div class="row align-items-center mb-3">
                                    <!-- First Column -->
                                    <div class="col-md-8">
                                        <h5 class="mb-1"><span style="color: #FD5631;">PKR ${price}</span></h5>
                                        <div class="row">
                                            <div class="col-auto">
                                                <p>${milleage} miles</p>
                                            </div>
                                            <div class="col-auto">
                                                <p>${cityname}, ${locationarea}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Second Column -->
                                    <div class="col-md-4 text-end">
                                        <p><strong>Posted on:</strong> ${created_at}</p>
                                    </div>
                                </div>

                            </div>
                        </div>



                    </div>
        `;
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const websiteInput = document.getElementById('website');
            const errorDiv = document.getElementById('website-error');

            websiteInput.addEventListener('input', function() {
                const value = websiteInput.value;
                const isValid = value.startsWith('https://');

                if (value && !isValid) {
                    errorDiv.style.display = 'block';
                } else {
                    errorDiv.style.display = 'none';
                }
            });

            websiteInput.addEventListener('blur', function() {
                const value = websiteInput.value;
                const isValid = value.startsWith('https://');

                if (value && !isValid) {
                    errorDiv.style.display = 'block';
                } else {
                    errorDiv.style.display = 'none';
                }
            });
        });
    </script>



    {{-- handling Ad preview  --}}


    <script>
        // handling image preview in ad preview 
        function handleAdPreview(files) {
            const previewAdImg = document.getElementById('preview_img_post_ad');



            Array.from(files).forEach((file, index) => {
                if (file.type.startsWith('image/') && file.size <= 8 * 1024 * 1024) {
                    const reader = new FileReader();

                    reader.onload = (e) => {
                        // Update the primary preview image for the first valid image
                        if (!firstImageSet) {
                            previewAdImg.src = e.target.result;
                            firstImageSet = true;
                        }

                    };

                    reader.readAsDataURL(file);
                } else if (file.type.startsWith('video/') && file.size <= 10 * 1024 * 1024) {
                    previewAdImg.src = 'https://placehold.co/600x400@2x.png';
                    firstImageSet = false;

                } else {
                    console.warn('Invalid file type or size exceeds limit!');
                    firstImageSet = false;

                }
            });
        }

        // handling car condition 


        $('#vehicleCondition').change(function(e) {
            e.preventDefault();
            var vehicleConditionvalue = $(this).val();
            $('#vehicleConditionvalue').text(vehicleConditionvalue);
            if (vehicleConditionvalue == 'used') {
                $('.vehicleConditionvaluecolor').css({
                    'background': 'green'
                });
            } else {
                $('.vehicleConditionvaluecolor').css({
                    'background': '#4581F9'
                });
            }

        });
        // handling assembly 
        $('#assembly').change(function(e) {
            e.preventDefault();
            var assemblyvalue = $(this).val();
            $('#assemblyvalue').text(assemblyvalue)
        });
        // handling registeredDealer 
        $('#registeredDealer').change(function(e) {
            if ($(this).prop('checked')) {

                $('#registeredDealervalue').text('Yes')
            }
        });
        $('#privateDealer').change(function(e) {
            if ($(this).prop('checked')) {

                $('#registeredDealervalue').text('No')
            }
        });
        // handling price 
        $('#priceInput').change(function(e) {
            e.preventDefault();
            var priceInputValue = $(this).val();

            // Remove any non-numeric characters except for "." (for decimal values)
            var numericValue = priceInputValue.replace(/[^0-9.]/g, '');

            // Format the numeric value with commas
            var formattedValue = parseFloat(numericValue).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            // Display the formatted value
            $('#priceInputvalue').text(formattedValue);
        });

        // handling make 
        $('#makecompanydata').change(function(e) {
            e.preventDefault();
            var makecompanydatavalue = $(this).find('option:selected').text();
            $('#makecompanydatavalue').text(makecompanydatavalue);
            $('#vehiclename').text(makecompanydatavalue);
        });
        // handling model 
        $('#model').change(function(e) {
            e.preventDefault();
            var modelvalue = $(this).find('option:selected').text();
            $('#modelvalue').text(modelvalue);
            $('#vehiclename').text($('#makecompanydatavalue').text() + ' ' + modelvalue);
        });
        // handling year 
        $('#years').change(function(e) {
            e.preventDefault();
            var yearsvalue = $(this).val();
            $('#yearsvalue').text(yearsvalue);
            $('#manufacturing_year_value').text(yearsvalue);
        });
        // handling mileage 
        $('#mileage').change(function(e) {
            e.preventDefault();
            var mileagevalue = $(this).val();
            $('#mileagevalue').text(mileagevalue);
            $('#mileage_value').text(mileagevalue);
        });
        // handling bodytype 
        $('#bodyType').change(function(e) {
            e.preventDefault();
            var bodyTypevalue = $(this).find('option:selected').text();
            $('#bodyTypevalue').text(bodyTypevalue);
        });
        // handling doorCount 
        $('#doorCount').change(function(e) {
            e.preventDefault();
            var doorCountvalue = $(this).val();
            $('#doorCountvalue').text(doorCountvalue);
        });
        // handling fuelType 
        $('#fuelType').change(function(e) {
            e.preventDefault();
            var fuelTypevalue = $(this).val();
            $('#fuelTypevalue').text(fuelTypevalue);
            $('#fule_type_value').text(fuelTypevalue);
        });
        // handling seatingCapacity 
        $('#seatingCapacity').change(function(e) {
            e.preventDefault();
            var seatingCapacityvalue = $(this).val();
            $('#seatingCapacityvalue').text(seatingCapacityvalue);
        });
        // handling engineCapacity 
        $('#engineCapacity').change(function(e) {
            e.preventDefault();
            var engineCapacityvalue = $(this).val();
            $('#engineCapacityvalue').text(engineCapacityvalue);
        });
        // handling transmission 
        $('#transmission').change(function(e) {
            e.preventDefault();
            var transmissionvalue = $(this).val();
            $('#transmissionvalue').text(transmissionvalue);
            $('#transmission_value').text(transmissionvalue);
        });
        // handling exterior_color 
        $('#exterior_color').change(function(e) {
            e.preventDefault();
            var exterior_colorvalue = $(this).find('option:selected').text();
            $('#exterior_colorvalue').text(exterior_colorvalue);
        });
        // handling city 
        $('#city').change(function(e) {
            e.preventDefault();
            var cityvalue = $(this).find('option:selected').text();
            $('#cityvalue').text(cityvalue);
        });
        // handling feature_ad 
        $('#feature_ad').change(function(e) {
            e.preventDefault();

            if ($(this).prop('checked')) {
                $('.featured_label').removeClass('d-none');
            } else {
                $('.featured_label').addClass('d-none');
            }

        });


        // handling features 

        function updateSelectedFeatures() {
            const selectedFeaturesContainer = $('.features .row.mt-3');
            selectedFeaturesContainer.empty();

            // Get all checked checkboxes
            $('.feature_checkbox:checked').each(function() {
                const featureText = $(this).siblings('label').text().trim();
                const featureIcon = getFeatureIcon(featureText);
                const featureDiv = `
                <div class="col-md-6 feature-item">
                    <i class="${featureIcon} orange"></i> ${featureText}
                </div>`;
                selectedFeaturesContainer.append(featureDiv);
            });
        }


        function getFeatureIcon(featureText) {
            const featureIcons = {
                'Air Conditioning': 'bi bi-fan',
                'Air Bags': 'bi bi-shield-shaded',
                'Cassette Player': 'bi bi-cassette-fill',
                'Cool Box': 'bi bi-thermometer-half',
                'Cruise Control': 'bi bi-speedometer2',
                'DVD Player': 'bi bi-disc',
                'Front Speaker': 'bi bi-speaker',
                'Front Camera': 'bi bi-camera-video',
                'Keyless Entry': 'bi bi-key',
                'Immobilizer Key': 'bi bi-shield',
            };
            return featureIcons[featureText] || 'bi bi-check-circle';
        }


        $('.form-check-input').change(function() {
            updateSelectedFeatures();
        });


        updateSelectedFeatures();

        function scrolltop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }


        function submitform() {
            const form = document.getElementById('adFormmmms');
            const fileInput = document.getElementById('fileUpload');


            //if (fileInput.files.length === 0) {

            //toastr.error('At least one image is required to submit the form.');
            if (fileArray.length < 5 || fileArray.length > 30) {

                event.preventDefault(); // Prevent form submission
                let modal = new bootstrap.Modal(document.getElementById('imageValidationModal'));
                modal.show();
                //}
                //return false;
            } else {
                $('#form_submit_btn').click();
            }
        }
    </script>







    <script>
        let fileArray = []; // To track all selected files globally

        function handleImgUpload(files) {
            const previewContainer = document.getElementById('previewContainer');
            const fileInput = document.getElementById('fileUpload'); // Get reference to file input

            // Append new files to the existing fileArray without duplicates
            const newFiles = Array.from(files).filter((file) => {
                return !fileArray.some((f) => f.name === file.name && f.size === file.size);
            });


            fileArray = fileArray.concat(newFiles); // Add only non-duplicate files

            // Update the input's files with the current fileArray
            updateFileInput();
            let indexCounter = fileArray.length - newFiles.length;
            // Render only the newly added files
            newFiles.forEach((file) => {
                if (file.size <= 8 * 1024 * 1024 && /\.(jpe?g|png|gif|bmp)$/i.test(file.name)) { // Image limit
                    const reader = new FileReader();

                    reader.onload = (e) => {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'preview-item';
                        wrapper.setAttribute('data-filename', file.name);
                        wrapper.setAttribute('data-filesize', file.size);
                        wrapper.style.display = 'inline-block';
                        wrapper.style.position = 'relative';
                        wrapper.style.margin = '10px';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('draggable-img');
                        img.style.width = '150px';
                        img.style.height = '150px';
                        img.style.objectFit = 'cover';
                        img.setAttribute('data-index', indexCounter);

                        const removeBtn = document.createElement('button');
                        removeBtn.type = 'button';
                        removeBtn.innerHTML = '×';
                        removeBtn.style.position = 'absolute';
                        removeBtn.style.top = '5px';
                        removeBtn.style.right = '5px';
                        removeBtn.style.background = '#FD5631';
                        removeBtn.style.color = 'white';
                        removeBtn.style.border = 'none';
                        removeBtn.style.borderRadius = '50%';
                        removeBtn.style.cursor = 'pointer';
                        removeBtn.style.width = '20px';
                        removeBtn.style.height = '20px';
                        removeBtn.style.display = 'flex';

                        removeBtn.style.justifyContent = 'center';
                        removeBtn.style.padding = '0';
                        removeBtn.style.lineHeight = '1';

                        // Improved remove functionality
                        removeBtn.onclick = () => {
                            wrapper.remove(); // Remove from DOM
                            // Remove from fileArray using file identifiers
                            fileArray = fileArray.filter(f =>
                                !(f.name === file.name && f.size === file.size)
                            );
                            updateFileInput(); // Update input files after removal
                            console.log('Remaining files:', fileArray);
                        };

                        wrapper.appendChild(img);
                        wrapper.appendChild(removeBtn);
                        previewContainer.appendChild(wrapper);
                        indexCounter++;
                    };

                    reader.readAsDataURL(file);
                } else {
                    function showAlert(message) {
                        document.getElementById('alertModalBody').innerText = message;
                        var alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
                        alertModal.show();
                    }

                    // Example Usage:
                    if (file.size > 8 * 1024 * 1024) { // 8MB limit
                        showAlert(`File "${file.name}" is invalid or exceeds the 8MB size limit!`);
                    }

                }
            });
        }

        // Function to update the file input with current fileArray
        function updateFileInput() {
            const fileInput = document.getElementById('fileUpload');
            // Create a DataTransfer object and add our files
            const dataTransfer = new DataTransfer();
            fileArray.forEach(file => {
                dataTransfer.items.add(file);
            });
            // Set the input's files to our DataTransfer files
            fileInput.files = dataTransfer.files;
        }

        // Optional: Function to get the final files for submission
        function getSelectedFiles() {
            return fileArray;
        }
        $(document).ready(function() {
            $('#phoneNumber').on('input', function() {
                // Remove all non-numeric characters
                let phoneValue = $(this).val().replace(/\D/g, '');

                // If number starts with 92, remove it
                phoneValue = phoneValue.replace(/^92/, '');

                // If number starts with 0, remove it
                phoneValue = phoneValue.replace(/^0/, '');

                // Format the number with proper spacing
                let formatted = '';
                if (phoneValue.length > 0) {
                    formatted = '+92 ' + phoneValue.substring(0, 3);
                    if (phoneValue.length > 3) {
                        formatted += ' ' + phoneValue.substring(3);
                    }
                }

                // Limit the total length
                formatted = formatted.substring(0, 15);

                // Update input value
                $(this).val(formatted);

                // Validate: must be exactly "+92 3XX XXXXXXXX" format
                const isValid = /^\+92 3\d{2} \d{7}$/.test(formatted);
                $('#phone-error').toggle(!isValid);
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Add custom validation method for feature checkboxes
            $.validator.addMethod("requireOneFeature", function(value, element) {
                return $('.feature_checkbox:checked').length > 0;
            }, "Please select at least one feature");

            $("#adFormmmms").validate({
                rules: {
                    dealer: {
                        required: true
                    },
                    condition: {
                        required: true
                    },
                    assembly: {
                        required: true
                    },
                    price: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    makecompany: {
                        required: true
                    },
                    model: {
                        required: true
                    },
                    year: {
                        required: true
                    },
                    mileage: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    bodyType: {
                        required: true
                    },
                    doorcount: {
                        required: true
                    },
                    fuelType: {
                        required: true
                    },
                    seatingCapacity: {
                        required: true
                    },
                    engineCapacity: {
                        required: true
                    },
                    transmission: {
                        required: true
                    },
                    driveType: {
                        required: true
                    },
                    exterior_color: {
                        required: true
                    },
                    dealer_comment: {
                        required: true,
                        minlength: 10
                    },
                    province: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    street_address: {
                        required: true
                    },
                    firstName: {
                        required: true,
                        minlength: 2
                    },
                    secondName: {
                        required: true,
                        minlength: 2
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    number: {
                        required: true,
                        pattern: /^\+92 3\d{2} \d{7}$/
                    },
                    'Features[Exterior][]': {
                        requireOneFeature: true
                    },
                    'Features[Interior][]': {
                        requireOneFeature: true
                    },
                    'Features[Safety][]': {
                        requireOneFeature: true
                    }
                },
                messages: {
                    dealer: {
                        required: "Please select a dealer"
                    },
                    condition: {
                        required: "Please select vehicle condition"
                    },
                    assembly: {
                        required: "Please select assembly type"
                    },
                    price: {
                        required: "Please enter the price",
                        number: "Please enter a valid number",
                        min: "Price cannot be negative"
                    },
                    makecompany: {
                        required: "Please select a make"
                    },
                    model: {
                        required: "Please select a model"
                    },
                    year: {
                        required: "Please select a year"
                    },
                    mileage: {
                        required: "Please enter mileage",
                        number: "Please enter a valid number",
                        min: "Mileage cannot be negative"
                    },
                    bodyType: {
                        required: "Please select body type"
                    },
                    doorcount: {
                        required: "Please select door count"
                    },
                    fuelType: {
                        required: "Please select fuel type"
                    },
                    seatingCapacity: {
                        required: "Please select seating capacity"
                    },
                    engineCapacity: {
                        required: "Please select engine capacity"
                    },
                    transmission: {
                        required: "Please select transmission type"
                    },
                    driveType: {
                        required: "Please select drive type"
                    },
                    exterior_color: {
                        required: "Please select exterior color"
                    },
                    dealer_comment: {
                        required: "Please enter dealer comments",
                        minlength: "Comments must be at least 10 characters long"
                    },
                    province: {
                        required: "Please select a province"
                    },
                    city: {
                        required: "Please select a city"
                    },
                    street_address: {
                        required: "Please enter street address"
                    },
                    firstName: {
                        required: "Please enter first name",
                        minlength: "First name must be at least 2 characters long"
                    },
                    secondName: {
                        required: "Please enter second name",
                        minlength: "Second name must be at least 2 characters long"
                    },
                    email: {
                        required: "Please enter email address",
                        email: "Please enter a valid email address"
                    },
                    number: {
                        required: "Please enter phone number",
                        pattern: "Please enter a valid phone number in format: +92 3XX XXXXXXX"
                    },
                    'Features[Exterior][]': {
                        requireOneFeature: "Please select at least one feature"
                    },
                    'Features[Interior][]': {
                        requireOneFeature: "Please select at least one feature"
                    },
                    'Features[Safety][]': {
                        requireOneFeature: "Please select at least one feature"
                    }
                },
                errorElement: 'div',
                errorClass: 'orange',
                errorPlacement: function(error, element) {
                    if (element.hasClass('feature_checkbox')) {
                        // For feature checkboxes, show error at the top of the feature section
                        error.insertBefore(element.closest('.feature-section'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function(element, errorClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass) {
                    $(element).removeClass('is-invalid');
                },
                invalidHandler: function(event, validator) {
                    // Scroll to the first error
                    if (validator.numberOfInvalids() > 0) {
                        $('html, body').animate({
                            scrollTop: $(validator.errorList[0].element).offset().top - 100
                        }, 500);
                    }
                },
                submitHandler: function(form) {
                    // Check if at least one feature is selected
                    if ($('.feature_checkbox:checked').length === 0) {
                        // Show error message at the top of the feature section
                        const errorDiv = $(
                            '<div class="orange">Please select at least one feature</div>');
                        $('.feature-section').first().before(errorDiv);

                        // Scroll to the error message
                        $('html, body').animate({
                            scrollTop: errorDiv.offset().top - 100
                        }, 500);

                        return false;
                    }

                    // Check image count before submitting
                    if (fileArray.length < 5 || fileArray.length > 30) {
                        let modal = new bootstrap.Modal(document.getElementById(
                            'imageValidationModal'));
                        modal.show();
                        return false;
                    }

                    // If validation passes and image count is correct, submit the form
                    form.submit();
                }
            });

            // Custom validation for phone number format
            $.validator.addMethod("pattern", function(value, element, param) {
                return this.optional(element) || param.test(value);
            }, "Please enter a valid phone number");

            // Add change event handler for feature checkboxes to trigger validation
            $('.feature_checkbox').on('change', function() {
                $("#adFormmmms").validate().element(this);
            });

            // Add a hidden input to track feature validation
            $('<input type="hidden" name="feature_validation" value="1">').appendTo('#adFormmmms');
        });

        // Update the submitform function to use jQuery validation
        function submitform() {
            const form = $("#adFormmmms");
            if (form.valid()) {
                if (fileArray.length < 5 || fileArray.length > 30) {
                    let modal = new bootstrap.Modal(document.getElementById('imageValidationModal'));
                    modal.show();
                    return false;
                }
                $('#form_submit_btn').click();
            }
        }
    </script>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById("latitude").value = position.coords.latitude;
                    document.getElementById("longitude").value = position.coords.longitude;
                    getAddressFromCoordinates(position.coords.latitude, position.coords.longitude, function(
                        address) {
                        if (address) {
                            document.getElementById("streetAddress").value = address;
                            // alert(address);
                        }
                    })
                    // alert("Latitude: " + position.coords.latitude + "\nLongitude: " + position.coords.longitude);
                }, function(error) {
                    console.warn("Geolocation failed or was denied:", error.message);
                });
            } else {
                console.warn("Geolocation is not supported by this browser.");
            }
        });
    </script>

    <script>
        const GOOGLE_MAPS_API_KEY = "{{ config('services.google_maps.key') }}";
        async function getAddressFromCoordinates(lat, lng, callback) {
            try {
                const response = await fetch(
                    `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=${GOOGLE_MAPS_API_KEY}`
                );
                const data = await response.json();

                if (data.status === "OK" && data.results.length > 0) {
                    const address = data.results[0].formatted_address;
                    if (callback) callback(address);
                } else {
                    console.warn("No address found.");
                    if (callback) callback(null);
                }
            } catch (err) {
                console.error("Geocoding error:", err.message);
                if (callback) callback(null);
            }
        }
    </script>


    <script>
        $('#dealerSelect').change(function() {
            var dealerId = $(this).val();
            if (dealerId) {
                $('#ajaxLoader').css('display', 'block');
                $.ajax({
                    url: '/superadmin/check-dealer-posting-status',
                    type: 'POST',
                    data: {
                        dealer_id: dealerId
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#ajaxLoader').fadeOut();
                        if (data.success) {
                            $('#dealerSelect-error').text('');
                        } else {
                            $('#dealerSelect-error').text(data.message);
                            $('#form_submit_btn_fake').prop('disabled', true);
                        }

                    },
                    error: function(xhr, status, error) {
                        $('#ajaxLoader').fadeOut();
                        console.error('Error fetching dealer info:', error);
                    }
                });
            }
        });
    </script>
@endsection
