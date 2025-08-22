{{-- @dd($features) --}}
@extends('layout.superadmin_layout.main')

@section('content')

    <style>
        body {
            font-family: 'Maven Pro', sans-serif !important;
        }

        .form-select {
            max-width: 100% !important;
            text-align: start !important;
        }

        .orange {
            color: #FD5631 !important;
        }

        .img-adj-card {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Hide the default radio button */
        .registeredDealer {
            position: absolute;
            opacity: 0;
        }

        -input:focus {
            border: 2px solid red !important;
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

        #goToTop,
        #goToBottom {
            position: fixed;
            right: 20px;
            padding: 10px;
            padding-left: 15px;
            padding-right: 15px;
            font-size: 20px;
            background-color: #FD5631;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            opacity: 0;
            /* Start hidden */
            visibility: hidden;
            /* Prevent interaction when hidden */
            transition: opacity 0.3s ease, visibility 0.3s ease;
            /* Smooth transition */
        }

        #goToTop {
            bottom: 80px;
        }

        #goToBottom {
            bottom: 20px;
        }

        #goToTop:hover,
        #goToBottom:hover {
            background-color: #f94922;
        }

        /* Show buttons with fade-in effect */
        #goToTop.show,
        #goToBottom.show {
            opacity: 1;
            visibility: visible;
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
            width: 15px;
            height: 15px;

            border: 2px solid #00000080;
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
            background-color: #282435;
            border: 2px solid #EFEFEF80;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .feature_ad:checked {
            background-color: #FD5631;
            border-color: #FD5631;
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

        .form-label {
            color: #281F48 !important;
            font-weight: 400;
            font-size: 18px;
        }

        .form-check-label {
            color: #281F48 !important;
            font-weight: 400;
            font-size: 16px;
        }

        .step-header {
            color: #281F48 !important;
            font-weight: 700;
            font-size: 24px;
        }

        .primary-color-custom {
            color: #281F48 !important;
            font-weight: 700;
            font-size: 48px;
        }
        .select-wrapper {
    position: relative;
    display: inline-block;
    width: 100%;
}

.select-wrapper select {
    padding-right: 2rem; /* space for the icon */
}

.select-wrapper i {
    position: absolute;
    top: 50%;
    right: 10px;
    pointer-events: none; /* make sure clicks go to the select */
    transform: translateY(-50%);
    color: #6c757d;
    font-size: 1rem;
}
    </style>

    <style>
        .navbar {
            display: none !important
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
        <div class="row align-items-center mb-2">

            <div class="col-auto">
                <h2 class="sec mb-0 primary-color-custom">Post an Ad</h2>
            </div>

        </div>
    </div>
    <div class="container">
        <div class="row pb-md-5 pt-md-3">
            <div class="col-lg-8">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="adForm" method="post" action="{{ route('superadmin.bike-ads.store') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Step 2: Basic Info -->
                    <input type="hidden" value="" name="dealer">
                    <div class="mb-3 p-3 d-none rounded" style="background-color:#282435;">



                    </div>

                    <!-- Step 3: Currency & Price -->
                    <div class="mb-3 p-3 d-none rounded" style="background-color:#282435;">


                    </div>
                    <!-- Step 4: Vehicle Information -->
                    <div class=" row mb-3  rounded" style="background-color:white;">
                       <div class="col-md-12 mb-2">
    <div class="select-wrapper">
        <select name="dealer" class="form-control" required
            style="border: 1px solid #D0D5DD !important; line-height: 1 !important;"
            id="dealer">
            <option value="">Select Dealer</option>
            @foreach ($users as $dealer)
                <option value="{{ $dealer->id }}">{{ $dealer->name }}</option>
            @endforeach
        </select>
        <i class="bi bi-chevron-down"></i>
    </div>
    <div id="dealerSelect-error" class="orange"></div>
</div>
                        <div class="col-md-12  p-4">
                            <div class="row rounded-4 p-2"  style="background-color:#white; border:1px solid #0000001F">
                                <h4 class="step-header">Vehicle information</h4>
                                <input type="hidden" name="step4" value="step4">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="make" class="form-label" style="color:white">Feature Ad <span
                                                style="color:#FD5631">*</span></label>
                                        <select class="form-select " aria-label="Default select example" required
                                            style="background-color: white !important ; color:#281F48 !important"
                                            name="is_featured" id="is_featured">
                                            <option value="">Select Option</option>
                                            <option value="1" {{ old('is_featured') == '1' ? 'selected' : '' }}>Yes
                                            </option>
                                            <option value="0" {{ old('is_featured') == '0' ? 'selected' : '' }}>No
                                            </option>
                                        </select>
                                        {{-- <div id="makecompanydata-error" class="orange" style="display: none;">Please select
                                            an option.</div> --}}
                                        @error('is_featured')
                                            <div class="alert ">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">

                                        <label for="model" class="form-label" style="color:white">Registered <span
                                                style="color:#FD5631">*</span></label>
                                        <select class="form-select  validate-field" name="is_registered"
                                            style="background-color: white !important ; color:#281F48 !important"
                                            id="is_registered"required>
                                            <option value="">Select Option</option>
                                            <option value="1" {{ old('is_registered') == '1' ? 'selected' : '' }}>Yes
                                            </option>
                                            <option value="0" {{ old('is_registered') == '0' ? 'selected' : '' }}>No
                                            </option>

                                        </select>
                                        {{-- <div id="model-error" class="orange" style="display: none;">Please select an option.
                                        </div> --}}
                                        @error('is_registered')
                                            <div class="alert ">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">

                                        <label for="condition" class="form-label" style="color:white">Condition <span
                                                style="color:#FD5631">*</span></label>
                                        <select class="form-select validate-field" name="condition"
                                            style="background-color: white !important ; color:#281F48 !important"
                                            id="condition"required>
                                            <option value="">Select Option</option>
                                            <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>New
                                            </option>
                                            <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Used
                                            </option>

                                        </select>
                                        {{-- <div id="condition-error" class="orange" style="display: none;">Please select an
                                            option.
                                        </div> --}}
                                        @error('condition')
                                            <div class="alert ">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">

                                        <label for="transmission" class="form-label" style="color:white">Transmission <span
                                                style="color:#FD5631">*</span></label>
                                        <select class="form-select  validate-field" name="transmission"
                                            style="background-color: white !important ; color:#281F48 !important"
                                            id="transmission"required>
                                            <option value="">Select Option</option>
                                            <option value="Auto" {{ old('transmission') == 'Auto' ? 'selected' : '' }}>
                                                Auto
                                            </option>
                                            <option value="Manual" {{ old('transmission') == 'Manual' ? 'selected' : '' }}>
                                                Manual
                                            </option>

                                        </select>
                                        {{-- <div id="transmission-error" class="orange" style="display: none;">Please select an
                                            option.
                                        </div> --}}
                                        @error('transmission')
                                            <div class="alert ">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="year" class="form-label" style="color:white">Assembly <span
                                                style="color:#FD5631">*</span></label>
                                        <select class="form-select  validate-field" name="assembly"
                                            style="background-color: white !important ; color:#281F48 !important"
                                            id="assembly"required>
                                            <option value="">Any</option>
                                            <option value="local" {{ old('assembly') == 'local' ? 'selected' : '' }}>
                                                Local
                                            </option>
                                            <option value="imported"
                                                {{ old('assembly') == 'imported' ? 'selected' : '' }}>
                                                Imported</option>
                                        </select>
                                        {{-- <div id="years-error" class="orange" style="display: none;">Please select an
                                            option.
                                        </div> --}}
                                        @error('assembly')
                                            <div class="alert ">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="mileage" class="form-label" style="color:white">Price <span
                                                style="color:#FD5631">*</span></label>
                                        <input type="number" name="price" value="{{ old('price') }}"
                                            class="form-control formcontrol validate-field" id="price"
                                            placeholder="e.g., 25000" min="0"required>
                                        {{-- <div id="mileage-error" class="orange" style="display: none;">Price is required.
                                        </div> --}}
                                        @error('price')
                                            <div class="alert ">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="bodyType" class="form-label" style="color:white">Make <span
                                                style="color:#FD5631">*</span></label>
                                        <select class="form-select  validate-field" name="make"
                                            style="background-color: white !important ; color:#281F48 !important"
                                            id="bike_make"required>
                                            <option value="">Any</option>
                                            @foreach ($makes as $make)
                                                <option value="{{ $make->id }}"
                                                    {{ old('make') == $make->id ? 'selected' : '' }}>{{ $make->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        {{-- <div id="bodyType-error" class="orange" style="display: none;">Make is
                                            required.</div> --}}
                                        @error('make')
                                            <div class="alert ">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="model" class="form-label" style="color:white">Model <span
                                                style="color:#FD5631">*</span></label>
                                        <select class="form-select  validate-field" name="model"
                                            style="background-color: white !important ; color:#281F48 !important"
                                            id="model"required>
                                            <option value="">Select Make first</option>
                                        </select>
                                        {{-- <div id="model-error" class="orange" style="display: none;">Model is
                                            required.</div> --}}
                                        @error('model')
                                            <div class="alert ">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="year" class="form-label" style="color:white">Year <span
                                                style="color:#FD5631">*</span></label>
                                        <select class="form-select  validate-field" name="year"
                                            style="background-color: white !important ; color:#281F48 !important"
                                            id="year"required>
                                            <option value="">Any</option>
                                            @for ($year = now()->year; $year >= 1960; $year--)
                                                <option value="{{ $year }}"
                                                    {{ old('year') == $year ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endfor
                                        </select>
                                        {{-- <div id="year-error" class="orange" style="display: none;">Year is
                                            required.</div> --}}
                                        @error('year')
                                            <div class="alert ">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="mileage" class="form-label" style="color:white">Mileage (Km)
                                            <span style="color:#FD5631">*</span></label>
                                        <input type="number" name="mileage" value="{{ old('mileage') }}"
                                            class="form-control formcontrol validate-field" id="mileage"
                                            placeholder="e.g., 25000" min="0"required>
                                        {{-- <div id="mileage-error" class="orange" style="display: none;">
                                            Mileage is required.</div> --}}
                                        @error('mileage')
                                            <div class="alert ">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="body_type" class="form-label" style="color:white">Body type
                                            <span style="color:#FD5631">*</span></label>
                                        <select class="form-select  validate-field" name="body_type"
                                            style="background-color: white !important ; color:#281F48 !important"
                                            id="body_type"required>
                                            <option value="">Any</option>
                                            @foreach ($bodytypes as $bodytype)
                                                <option value="{{ $bodytype->id }}"
                                                    {{ old('body_type') == $bodytype->id ? 'selected' : '' }}>
                                                    {{ $bodytype->name }}</option>
                                            @endforeach
                                        </select>
                                        {{-- <div id="body_type-error" class="orange" style="display: none;">
                                            Body Type is required.</div> --}}
                                        @error('body_type')
                                            <div class="alert ">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="fuel_type" class="form-label" style="color:white">Fuel type <span
                                                style="color:#FD5631">*</span></label>
                                        <select class="form-select  validate-field" name="fuel_type"
                                            style="background-color: white !important ; color:#281F48 !important"
                                            id="fuel_type"required>
                                            <option value="">Any</option>
                                            <option value="Gasoline"
                                                {{ old('fuel_type') == 'Gasoline' ? 'selected' : '' }}>Gasoline</option>
                                            <option value="Diesel" {{ old('fuel_type') == 'Diesel' ? 'selected' : '' }}>
                                                Diesel</option>
                                            <option value="Electric"
                                                {{ old('fuel_type') == 'Electric' ? 'selected' : '' }}>Electric</option>
                                            <option value="Petrol" {{ old('fuel_type') == 'Petrol' ? 'selected' : '' }}>
                                                Petrol</option>
                                            <option value="LPG" {{ old('fuel_type') == 'LPG' ? 'selected' : '' }}>LPG
                                            </option>
                                            <option value="CNG" {{ old('fuel_type') == 'CNG' ? 'selected' : '' }}>CNG
                                            </option>
                                            <option value="Hybrid" {{ old('fuel_type') == 'Hybrid' ? 'selected' : '' }}>
                                                Hybrid</option>
                                        </select>
                                        {{-- <div id="fuel_type-error" class="orange" style="display: none;">Fuel Type
                                            is required.</div> --}}
                                        @error('fuel_type')
                                            <div class="alert ">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="fuel_capacity" class="form-label" style="color:white">Fuel capacity
                                            <span style="color:#FD5631">*</span></label>
                                        <select class="form-select  validate-field" name="fuel_capacity"
                                            style="background-color: white !important ; color:#281F48 !important"
                                            id="fuel_capacity"required>
                                            <option value="">Any</option>
                                            <option value="3">3L</option>
                                            <option value="4">4L</option>
                                            <option value="5">5L</option>
                                            <option value="6">6L</option>
                                            <option value="7">7L</option>
                                            <option value="8">8L</option>
                                            <option value="9">9L</option>
                                            <option value="10">10L</option>
                                            <option value="11">11L</option>
                                            <option value="12">12L</option>
                                            <option value="13">13L</option>
                                            <option value="14">14L</option>
                                            <option value="15">15L</option>
                                            <option value="16">16L</option>
                                            <option value="17">17L</option>
                                            <option value="18">18L</option>
                                            <option value="19">19L</option>
                                            <option value="20">20L</option>

                                        </select>
                                        {{-- <div id="fuel_capacity-error" class="orange" style="display: none;">Fuel Capacity
                                            is
                                            required.</div> --}}
                                        @error('fuel_capacity')
                                            <div class="alert ">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="color" class="form-label" style="color:white"> Color <span
                                                style="color:#FD5631">*</span></label>
                                        <select class="form-select  validate-field" name="exterior_color"
                                            style="background-color: white !important ; color:#281F48 !important"
                                            id="exterior_color"required>
                                            <option value="">Any</option>
                                            @foreach ($colors as $color)
                                                <option value="{{ $color->id }}"
                                                    {{ isset($post) && $post->exterior_color == $color->id ? 'selected' : '' }}>
                                                    {{ $color->name }}</option>
                                            @endforeach
                                        </select>
                                        {{-- <div id="exterior_color-error" class="orange" style="display: none;">
                                            Color is required.</div> --}}
                                        @error('exterior_color')
                                            <div class="alert ">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>


                                {{-- description start  --}}
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="description" class="form-label" style="color:white">Description
                                            <span style="color:#FD5631">*</span></label>
                                        <textarea class="form-control  validate-field" style="line-height: 1 !important;" id="description"
                                            name="description" placeholder="Description" required rows="6"></textarea>
                                        {{-- <div id="description-error" class="orange" style="display: none;">Description
                                            is
                                            required.</div> --}}
                                        @error('description')
                                            <div class="alert ">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>
                                {{-- description end --}}

                            </div>
                        </div>

                    </div>
                    <!-- Step 5: Vehicle Features -->

                    <div class="mb-3 p-3 rounded-4" style="background-color:#white; border:1px solid #0000001F">
                        <h4 class="step-header">Features <span class="text-danger">*</span> </h4>

                        @foreach ($features as $category => $featureGroup)
                            <div class="feature-section mb-4">
                                <h6>{{ $category }}</h6>

                                <div class="row d-flex flex-wrap">
                                    @foreach ($featureGroup as $feature)
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input feature_checkbox"
                                                    name="features[]" value="{{ $feature->id }}"
                                                    id="feature_{{ $feature->id }}">
                                                <label class="form-check-label" for="feature_{{ $feature->id }}">
                                                    {{ $feature->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach



                    </div>
                    <!-- Step 6: Upload Photos / Videos -->
                    <div class="mb-3 p-3 rounded-4" style="background-color:#white; border:1px solid #0000001F">
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
                            {{-- <input type="file" id="fileUpload" class="d-none" name="filedata[]" multiple
                                accept=".jpg, .jpeg, .png, .mp4, .mov"
                                onchange="handleFiles(this.files), handleAdPreview(this.files)"> --}}


                            <input type="file" id="bikefileUpload" class="d-none" name="filedata[]" multiple
                                accept=".jpg, .jpeg, .png, .mp4, .mov"
                                onchange="handlebikeImgUpload(this.files), handlebikeAdPreview(this.files)">

                            <a class="btn btn-primary mt-3" style="background-color:#281F48 !important;"
                                onclick="document.getElementById('bikefileUpload').click();">
                                Select Files
                            </a>
                        </div>
                        @error('filedata')
                            <div class="alert ">{{ $message }}</div>
                        @enderror

                        <div id="previewContainer" class="mt-4 d-flex flex-wrap gap-3"></div>
                    </div>
                    <div class="mb-3 p-3 rounded-4" style="background-color:#white; border:1px solid #0000001F">

                        <h4 class="step-header">Upload Documents <span style="color:#281F48; font-size:12px;">
                                (Optional)</span></h4>
                        <p class="rounded p-3" style="background-color:#281F48; color: white; ">
                            You can upload a maximum of <strong>1 auction sheet</strong> and <strong>1 brochure PDF
                                file</strong>.
                            The maximum file size is <strong>16 MB</strong>. Allowed format: <strong>PDF</strong>.
                        </p>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="upload-area border border-dashed rounded p-4 text-center"
                                    onclick="document.getElementById('bikebrochureUpload').click();">
                                    <i class="bi bi-file-earmark-pdf fs-1 text-danger mb-2"></i>
                                    <p class="mb-0">Click here to upload brochure</p>
                                    <small class="text-muted">(PDF only, max 16 MB)</small>
                                    <input type="file" id="bikebrochureUpload" name="document_brochure"
                                        class="d-none" accept=".pdf"
                                        onchange="handleDocumentUpload(this, 'brochurePreview')">
                                </div>
                                <div id="brochurePreview" class="mt-3 " style="color:#FD5631"></div>
                            </div>

                            <div class="col-md-6">
                                <div class="upload-area border border-dashed rounded p-4 text-center"
                                    onclick="document.getElementById('bikeauctionSheetUpload').click();">
                                    <i class="bi bi-file-earmark-pdf fs-1 text-danger mb-2"></i>
                                    <p class="mb-0">Click here to upload auction sheet</p>
                                    <small class="text-muted">(PDF only, max 16 MB)</small>
                                    <input type="file" id="bikeauctionSheetUpload" name="document_auction"
                                        class="d-none" accept=".pdf"
                                        onchange="handleDocumentUpload(this, 'auctionSheetPreview')">
                                </div>

                                <div id="auctionSheetPreview" class="mt-3 " style="color:#FD5631"></div>
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
                    <div class="mb-3 p-3 rounded-4" style="background-color:#white; border:1px solid #0000001F">
                        <h4 class="mb-4 step-header" style="color:#FD5631">Location</h4>

                        <div class="row mb-3">

                            <div class="col-md-6">
                                <label for="state" class="form-label" style="color:white">Province <span
                                        style="color:#FD5631">*</span></label>
                                <select id="province" name="province"
                                    style="background-color: white !important ; color:#281F48 !important"
                                    class="form-select  validate-field"required>
                                    <option value="" disabled selected>Select province</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}"
                                            {{ old('province') == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}</option>
                                    @endforeach

                                </select>
                                {{-- <div id="province-error" class="orange" style="display: none;">province is required.
                                </div> --}}
                                @error('province')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="city" class="form-label" style="color:white">City <span
                                        style="color:#FD5631">*</span></label>
                                <select id="city" name="city"
                                    style="background-color: white !important ; color:#281F48 !important"
                                    class="form-select  validate-field"required>
                                    <option value="" disabled selected>Select province first</option>


                                </select>
                                {{-- <div id="city-error" class="orange" style="display: none;">city is required.
                                </div> --}}
                                @error('city')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>



                            {{-- <div class="col-md-12">
                                <label for="street_address" class="form-label" style="color:white">Street address <span
                                        style="color:#FD5631">*</span></label>
                                <textarea name="street_address" id="street_address" cols="30" rows="3" class="form-control"></textarea>
                          
                                @error('street_address')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div> --}}

                            <div class="col-md-12">
                                <label for="streetAddress" class="form-label" style="color:white">
                                    Street Address <span style="color:#FD5631">*</span>
                                </label>
                                <input type="text" name="street_address"
                                    class="form-control formcontrol validate-field" style="color:#281F48 !important"
                                    placeholder="Enter Address" autocomplete="off" required />
                                <div id="streetAddress-error" class="orange" style="display: none;">Street address is
                                    required.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 9: Contacts -->

                    <div class="mb-3 p-3 rounded-4" style="background-color:#white; border:1px solid #0000001F">
                        <h4 class="step-header">Contacts</h4>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="firstName" class="form-label" style="color:white">First Name <span
                                        style="color:#FD5631">*</span></label>
                                <input type="text" class="form-control formcontrol validate-field" name="firstName"
                                    id="firstName" placeholder="Enter First name"
                                    value="{{ old('firstName') }}"required>
                                {{-- <div id="firstName-error" class="orange" style="display: none;">First Name is required.
                                </div> --}}
                                @error('firstName')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="secondName" class="form-label" style="color:white">Second Name <span
                                        style="color:#FD5631">*</span></label>
                                <input type="text" class="form-control formcontrol validate-field" name="secondName"
                                    id="secondName" placeholder="Enter last name" required
                                    value="{{ old('secondName') }}">
                                {{-- <div id="secondName-error" class="orange" style="display: none;">Second Name is required.
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
                                <input type="email" class="form-control formcontrol" name="email" id="email"
                                    placeholder="Enter Email" value="{{ Auth::user()->email ?? '' }}"required readonly>
                                @error('email')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phoneNumber" class="form-label" style="color:white">Phone Number <span
                                        style="color:#FD5631">*</span></label>
                                <input type="tel" class="form-control formcontrol" name="number" id="phoneNumber"
                                    placeholder="Enter phone number" value="{{ old('number') }}" required>

                                @error('number')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 d-none">
                            <label for="website" class="form-label" style="color:white">Website (Optional)</label>
                            <input type="url" class="form-control formcontrol" name="website" id="website"
                                placeholder="Enter website" pattern="https://.*" value="{{ old('website') }}">
                            {{-- <div id="website-error" class="text-danger mt-1" style="display: none;">
                                The website URL must start with <strong>https://</strong>.
                            </div> --}}
                        </div>

                    </div>

                    <div class="mb-3" style="display:flex;justify-content:end">
                        {{--  <div>
                            <button type="button" class="btn rounded px-5 primary-color-custom py-2"
                                style="background-color: white;" onclick="scrolltop()">Preview</button>
                        </div> --}}
                        <div>
                            <input type="button" class="btn custom-btn-nav rounded px-5" value="Save and continue"
                                style="background-color:#281F48 !important; color:white !important"
                                onclick="submitform();" id="form_submit_btn_fake">
                            <input type="submit" class="btn custom-btn-nav rounded px-5 d-none"
                                style="background-color:#281F48 !important; color:white !important"
                                value="Save and continue" id="form_submit_btn">
                        </div>
                    </div>
                </form>


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
                                    style="background-color:#BF0000; font-size:12px; color:white "><img
                                        src="{{ asset('web/images/star-icon.svg') }}"
                                        class="me-2 mb-1 img-fluid ">featured</span>
                                <span class="rounded px-3 py-1 text-capitalize vehicleConditionvaluecolor"
                                    id="vehicleConditionvalue"
                                    style="background-color:#4581F9; font-size:12px; color:#281F48 !important">-----</span>
                            </div>
                        </div>

                        <h4 id="vehiclename" style="color:#281F48 !important">-----</h4>
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
                                <div class="text-center py-1" style="background-color:#F6F6F6; border-radius: 10px;">
                                    <i class="bi bi-speedometer2"></i>
                                    <h6 id="mileagevalue" style="font-size:14px">-----</h6>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center py-1" style="background-color:#F6F6F6; border-radius: 10px;">
                                    <i class="fa fa-motorcycle fs-5" aria-hidden="true" style="color: #281F48;"></i>
                                    <h6 id="transmission_value" style="font-size:14px">-----</h6>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center py-1" style="background-color:#F6F6F6; border-radius: 10px;">
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
                                <span><strong>Registered?</strong></span>
                                <span id="registeredDealervalue">-----</span>
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
                                <span id="assemblyvalue" class="text-capitalize">-----</span>
                            </div>



                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Fuel Type</strong></span>
                                <span id="fuelTypevalue">-----</span>
                            </div>
                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Fuel Capacity</strong></span>
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

                        </div>
                        <!-- Features Section -->
                        <div class="features mt-4">
                            <h5 style="color: #FD5631;">Features</h5>
                            <div class="row mt-3">
                                <div class="col-md-6 feature-item ">
                                    <i class="bi bi-fan"></i> Air Conditioning
                                </div>
                                <div class="col-md-6 feature-item ">
                                    <i class="bi bi-shield-shaded"></i> Air Bags
                                </div>
                                <div class="col-md-6 feature-item ">
                                    <i class="bi bi-cassette-fill"></i> Cassette Player
                                </div>
                                <div class="col-md-6 feature-item ">
                                    <i class="bi bi-thermometer-half"></i> Cool Box
                                </div>
                                <div class="col-md-6 feature-item ">
                                    <i class="bi bi-speedometer2"></i> Cruise Control
                                </div>
                                <div class="col-md-6 feature-item ">
                                    <i class="bi bi-disc"></i> DVD Player
                                </div>
                                <div class="col-md-6 feature-item ">
                                    <i class="bi bi-speaker"></i> Front Speaker
                                </div>
                                <div class="col-md-6 feature-item ">
                                    <i class="bi bi-camera-video"></i> Front Camera
                                </div>
                                <div class="col-md-6 feature-item ">
                                    <i class="bi bi-key "></i> Keyless Entry
                                </div>
                                <div class="col-md-6 feature-item ">
                                    <i class="bi bi-shield"></i> <span style="color:white">Immobilizer Key</span>
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
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewLabel">Preview Your Ad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="previewContent">
                        <!-- Preview content will be populated here via JavaScript -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary" onclick="document.getElementById('adForm').submit();">Confirm & Submit</button> -->
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap Modal -->
    <div class="modal fade" id="imageValidationModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content " style="border-radius: 10px; overflow: hidden;">
                <div class="modal-header" style="background-color: #FD5631; color: white; border-bottom: none;">
                    <h5 class="modal-title" id="modalTitle">Image Upload Error</h5>
                    <button type="button" class="btn-close" style="background-color: white; color: #FD5631;"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <p class="m-0" id="modalMessage">Please upload at least 5 and at most 30 images.</p>
                </div>
                <div class="modal-footer justify-content-end border-0">
                    <button type="button" class=""
                        style="color:white; background-color:#FD5631;padding:5px 20px; border:none;border-radius:5px"
                        data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap Modal -->
    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                <div class="modal-header" style="background-color: #FD5631; color: white; border-bottom: none;">
                    <h5 class="modal-title" id="alertModalLabel">Invalid File Size</h5>
                    <button type="button" class="btn-close" style="background-color: white; color: #FD5631;"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" id="alertModalBody">

                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class=""
                        style="color:white; background-color:#FD5631;padding:5px 20px; border:none;border-radius:5px"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('web/bikes/js/create.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/additional-methods.min.js"></script>
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
    <script>
        let bikeFileArray = [];
        $(document).ready(function() {
            // Initialize bikeFileArray

            // Update bikeFileArray on file input change
            $('#bikefileUpload').on('change', function(event) {
                bikeFileArray = Array.from(event.target.files);
                // console.log('Files selected:', bikeFileArray.length);
            });

            // Add custom validation method for feature checkboxes
            $.validator.addMethod("requireOneFeature", function(value, element) {
                return $('.feature_checkbox:checked').length > 0;
            }, "Please select at least one feature");

            $("#adForm").validate({
                rules: {
                    dealer: {
                        required: true
                    },
                    is_featured: {
                        required: true
                    },
                    is_registered: {
                        required: true
                    },
                    condition: {
                        required: true
                    },
                    transmission: {
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
                    make: {
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
                    body_type: {
                        required: true
                    },
                    fuel_type: {
                        required: true
                    },
                    fuel_capacity: {
                        required: true
                    },
                    exterior_color: {
                        required: true
                    },
                    description: {
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
                    'features[]': {
                        requireOneFeature: true
                    }
                },
                messages: {
                    dealer: {
                        required: "Please select a dealer"
                    },
                    is_featured: {
                        required: "Please select an option"
                    },
                    is_registered: {
                        required: "Please select an option"
                    },
                    condition: {
                        required: "Please select condition"
                    },
                    transmission: {
                        required: "Please select transmission"
                    },
                    assembly: {
                        required: "Please select assembly"
                    },
                    price: {
                        required: "Please enter price",
                        number: "Please enter a valid number",
                        min: "Price cannot be negative"
                    },
                    make: {
                        required: "Please select make"
                    },
                    model: {
                        required: "Please select model"
                    },
                    year: {
                        required: "Please select year"
                    },
                    mileage: {
                        required: "Please enter mileage",
                        number: "Please enter a valid number",
                        min: "Mileage cannot be negative"
                    },
                    body_type: {
                        required: "Please select body type"
                    },
                    fuel_type: {
                        required: "Please select fuel type"
                    },
                    fuel_capacity: {
                        required: "Please select fuel capacity"
                    },
                    exterior_color: {
                        required: "Please select color"
                    },
                    description: {
                        required: "Please enter description",
                        minlength: "Description must be at least 10 characters long"
                    },
                    province: {
                        required: "Please select province"
                    },
                    city: {
                        required: "Please select city"
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
                    'features[]': {
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
                    console.log('Image count:', bikeFileArray ? bikeFileArray.length : 'undefined');
                    if (typeof bikeFileArray !== 'undefined' && (bikeFileArray.length < 5 ||
                            bikeFileArray.length > 30)) {
                        let modal = new bootstrap.Modal(document.getElementById(
                            'imageValidationModal'));
                        modal.show();
                        return false;
                    }
                    form.submit();
                }
            });

            // Custom validation for phone number format
            $.validator.addMethod("pattern", function(value, element, param) {
                return this.optional(element) || param.test(value);
            }, "Please enter a valid phone number");

            // Add change event handler for feature checkboxes to trigger validation
            $('.feature_checkbox').on('change', function() {
                $("#adForm").validate().element(this);
            });

            // Add a hidden input to track feature validation
            $('<input type="hidden" name="feature_validation" value="1">').appendTo('#adForm');
        });

        // Update the submitform function to use jQuery validation
        function submitform() {
            const form = $("#adForm");
            if (form.valid()) {
                console.log('Image count before submit:', bikeFileArray ? bikeFileArray.length : 'undefined');
                if (typeof bikeFileArray !== 'undefined' && (bikeFileArray.length < 5 || bikeFileArray.length > 30)) {
                    let modal = new bootstrap.Modal(document.getElementById('imageValidationModal'));
                    modal.show();
                    return false;
                }
                $('#form_submit_btn').click();
            }
        }
    </script>




    <script>
        $('#dealer').change(function() {
            var dealerId = $(this).val();
            if (dealerId) {
                $('#ajaxLoader').css('display', 'block');

                $.ajax({
                    url: '/superadmin/check-dealer-posting-status',
                    type: 'POST',
                    data: {
                        dealer_id: dealerId,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#ajaxLoader').fadeOut(); // Hide loader
                        if (data.success) {
                            $('#dealerSelect-error').text('');
                            $('#form_submit_btn_fake').prop('disabled', false);
                        } else {
                            $('#dealerSelect-error').text(data.message);
                            $('#form_submit_btn_fake').prop('disabled', true);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#ajaxLoader').fadeOut(); // Hide loader
                        console.error('Error fetching dealer info:', error);
                    }
                });
            }
        });
    </script>









@endsection
