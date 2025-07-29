@extends('layout.website_layout.main')
@section('content')
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .slider-container {
            position: relative;
            width: 100%;
            max-width: 400px;
            margin: 25px auto;

        }

        .range-track {
            position: absolute;
            width: 100%;
            height: 5px;

            top: 50%;
            transform: translateY(2%);
            border-radius: 5px;
        }

        .progress-bar {
            position: absolute;
            height: 8px;
            background-color: #281F48;
            top: 50%;
            transform: translateY(0%);
            border-radius: 5px;
            z-index: 2;
        }

        .slider {
            position: absolute;
            width: 100%;
            pointer-events: none;
            background: #F0F3F6;
            -webkit-appearance: none;
            appearance: none;
            height: 8px;
        }

        /* Customize slider thumb */
        .slider::-webkit-slider-thumb {
            pointer-events: auto;
            width: 20px;
            height: 20px;
            background: red;
            border: 3px solid white;
            border-radius: 50%;
            cursor: pointer;
            -webkit-appearance: none;
            position: relative;
            z-index: 3;
        }

        .slider::-moz-range-thumb {
            pointer-events: auto;
            width: 20px;
            height: 20px;
            background: red;
            border-radius: 50%;
            cursor: pointer;
        }

        .price-inputs {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .price-inputs input {
            width: 45%;
            padding: 5px;
            text-align: center;
            background: #2a273e;
            color: white;
            border: 1px solid #FF5722;
            border-radius: 5px;
        }
    </style>
    <style>
        /* Default styles for the checkbox */
        .filter-checkbox {
            appearance: none;
            /* Remove default checkbox styling */
            width: 15px;
            height: 15px;
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

        /* Base styles for the checkbox */
        .transmission-filter {
            appearance: none;
            /* Remove default checkbox styling */
            width: 15px;
            height: 15px;
            border: 2px solid #281F48;
            background-color: white;
            border-radius: 4px;
            /* Optional: rounded corners */
            cursor: pointer;
            display: inline-block;
            position: relative;
        }

        /* Styles for when the checkbox is checked */
        .transmission-filter:checked {
            background-color: #281F48;
            border-color: #281F48;
        }

        /* Optional: Checkmark for checked state */
        .transmission-filter:checked::after {
            content: '✓';
            /* Checkmark */
            color: white;
            font-size: 14px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .text-muted {
            --bs-text-opacity: 1;
            font-size: 16px;
            color: #FD5631 !important;
        }

        .page-link {
            position: relative;
            display: block;
            padding: var(--bs-pagination-padding-y) var(--bs-pagination-padding-x);
            font-size: var(--bs-pagination-font-size);
            color: var(--bs-pagination-color);
            text-decoration: none;

            border: var(--bs-pagination-border-width) solid var(--bs-pagination-border-color);
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            color: white;
            background: #FD5631;
            border: none !important;
        }

        .search-container {
            display: flex;
            align-items: center;
            position: relative;

        }

        .search-container input {
            width: 100%;
            border: none;
            border-bottom: 1px solid #ccc;
            outline: none;
            font-size: 16px;
            padding: 5px 10px;
            background: none;
            color: #fff;
            /* Adjust for dark background */
        }

        .search-container button {
            position: absolute;
            right: 0px;
            background: none;
            border: none;
            cursor: pointer;
            color: #888;
            font-size: 12px;
        }

        .search-container input::placeholder {
            color: white;
            font-weight: 600;
            /* Adjust placeholder color */
        }

        .search-container input:focus {
            border-bottom-color: #fff;
            /* Change border color on focus */
        }

        label.form-label {
            font-size: 17.6px;
            font-weight: 500;
            line-height: 20.68px;
            text-align: left;
            color: #281F48;
        }
    </style>
    <style>
        .select-wrapper {
            position: relative;

        }

        .select-wrapper i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            /* Prevent interaction with the icon */
            font-size: 1.1rem;
            /* Increase font size */
            font-weight: bold;
            /* Make it bold */
        }

        .form-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: none !important;
            position: relative;
            border: none !important;
            display: block;
            width: 100%;
            padding: .375rem 2.25rem .375rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.9;
            color: #281F48 !important;
            background-color: #F0F3F6 !important;
            background-image: var(--bs-form-select-bg-img), var(--bs-form-select-bg-icon, none);
            background-repeat: no-repeat;
            background-position: right .75rem center;
            background-size: 16px 12px;
            /* border: var(--bs-border-width) solid var(--bs-border-color); */
            border-radius: var(--bs-border-radius);
            /* transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out; */
            -webkit-appearance: none;
            -moz-appearance: none;
            /* appearance: none; */
        }

        .form-select:focus {
            border-color: none;
            outline: none;
            box-shadow: none;
        }

        .price_class {
            background-color: #F0F3F6;
            color: #281F48;
            border: none;
            padding: 7px;
            font-size: 16px;
            border-radius: 5px;
            width: 100%;
        }

        .price_class::placeholder {
            color: #281F48;
        }
    </style>
    <style>
        .select2-container--default .select2-selection--single {
            padding: 4px 13px;
            border: none;
            border-radius: 5px;
            height: 39px;
        }

        .select2-container--default .select2-selection--single {
            background-color: #F0F3F6;
            border: none;
            border-radius: 4px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            display: none;
        }

        .select2-container--default .select2-results__option {
            padding: 10px 20px;
            background: #F0F3F6;
            border: none;
        }

        .select2-search--dropdown {
            display: block;
            padding: 4px;
            /* background: red; */
            background: #F0F3F6;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            padding: 10px 20px;
            font-size: 14px;
            background: .select2-search--dropdown;
            background: #F0F3F6;
            border-radius: 5px;
            color: #281F48;
        }

        .select2-container--default .select2-results>.select2-results__options {
            max-height: 200px;
            overflow-y: auto;
            scrollbar-color: #281F48 #F0F3F6;
            scrollbar-width: thin;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #281F48;
        }

        .dash {
            color: #BFBEC3;
            position: absolute;
            top: 35%;
            right: 9%;
            width: 120px;
        }

        .pricedash {
            color: #BFBEC3;
            position: absolute;
            top: 15%;
            left: 133px;
        }

        .milagedash {
            color: #BFBEC3;
            position: absolute;
            top: 23%;
            right: 47%;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Custom rotating loader */
        .loader {
            width: 60px;
            aspect-ratio: 1;
            border: 15px solid #ddd;
            border-radius: 50%;
            position: relative;
            transform: rotate(45deg);
        }

        .loader::before {
            content: "";
            position: absolute;
            inset: -15px;
            border-radius: 50%;
            border: 15px solid #514b82;
            animation: l18 2s infinite linear;
        }

        @keyframes l18 {
            0% {
                clip-path: polygon(50% 50%, 0 0, 0 0, 0 0, 0 0, 0 0)
            }

            25% {
                clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 0, 100% 0, 100% 0)
            }

            50% {
                clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 100% 100%, 100% 100%)
            }

            75% {
                clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 0 100%, 0 100%)
            }

            100% {
                clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 0 100%, 0 0)
            }
        }

        @media (min-width: 500px) and (max-width: 800px) {
            .dash {
                color: #BFBEC3;
                position: absolute;
                top: 35%;
                right: 29%;
                width: 120px;
            }

            .pricedash {
                color: #BFBEC3;
                position: absolute;
                top: 30%;
                left: 268px;
            }

            .milagedash {
                color: #BFBEC3;
                position: absolute;
                top: 23%;
                right: 48%;
            }
        }
    </style>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3 @if (Request::is('dealer/*/ads/all')) d-none @endif">
                <div class="sidebar-filter">

                    <!-- Condition Filter -->
                    <div class="d-flex justify-content-between">

                        {{-- <span id="clearFilterbtn" style="color: #BFBEC3; cursor: pointer; font-size:12px ;text-decoration:underline ">Clear All Filter</span> --}}
                    </div>
                    <form method="post"
                        @if (Request::is('superadmin/*')) action="{{ route('superadmin.search') }}" @else  action="{{ route('search') }}" @endif>
                        @csrf
                        <div class="search-container mb-3">
                            {{-- <input type="text" placeholder="Search"> --}}

                            <div class="d-none">
                                <div class="col-lg-2 col-6 custom-select-icon">
                                    <img src="{{ asset('web/images/body-icon.png') }}" class="me-lg-3 img-fluid">
                                    <select name="bodytype" style="color:black" class="form-select form-select-home">
                                        <option value="" selected>
                                            Select Body Type</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-6 custom-select-icon">
                                    <img src="{{ asset('web/images/make.png') }}" class="me-lg-3 img-fluid">
                                    <select name="make" style="color:black" class="form-select form-select-home">
                                        <option value="">Select Make</option>

                                    </select>
                                </div>
                                <div class="col-lg-2 col-6 custom-select-icon">
                                    <img src="{{ asset('web/images/model.png') }}" class="me-lg-3 img-fluid">
                                    <select class="form-select form-select-home" style="color:black" name="model">
                                        <option value="" selected>Select Model</option>
                                    </select>
                                </div>

                                <div class="col-lg-2 col-6 custom-select-icon">
                                    <img src="{{ asset('web/images/map.png') }}" class="me-lg-3 img-fluid">
                                    <select name="province " style="color:black" class="form-select form-select-home ">
                                        <option value="">Select Province</option>

                                    </select>
                                </div>
                                <div class="col-lg-2 col-6 custom-select-icon">
                                    <img src="{{ asset('web/images/map.png') }}" class="me-lg-3 img-fluid">
                                    <select name="city" style="color:black" class="form-select form-select-home">
                                        <option value="">Select City</option>

                                    </select>
                                </div>
                                <div class="text-lg-end col-lg-2 col-6">
                                    <input type="submit" name="search" class="px-5 rounded btn custom-btn-nav w-100"
                                        value="Search">
                                </div>
                            </div>

                            <button type="submit"
                                style="color:#281F48;font-weight:900 !important ; border:1px solid #281F48; padding:5px; border-radius:5px">Clear
                                Filters</button>
                    </form>
                    <h6 class="form-label m-0" style="color:#FD5631"><strong>Condition</strong></h6>
                </div>
                <div class="">
                    <div class="my-3" style="display: flex; gap: 10px; align-items: center ;">
                        <div class="{{ request()->name == 'new' ? 'd-none' : '' }}">
                            <input type="checkbox" class="filter-checkbox condition_filter" name="condition"
                                data-filter="condition" value="used" id="usedCars_check"
                                {{ request()->name == 'used' ? 'checked' : '' }}
                                {{ request()->condition == 'used' ? 'checked' : '' }}
                                {{ request()->name == 'used' || request()->name == 'new' ? 'd-none' : '' }}>
                            <label for="usedCars" style="font-size:16px">Used Cars</label>
                        </div>
                        <div class="{{ request()->name == 'used' ? 'd-none' : '' }}">
                            <input type="checkbox" class="filter-checkbox condition_filter" name="condition"
                                data-filter="condition" value="new" id="newCars_check"
                                {{ request()->name == 'new' ? 'checked' : '' }}
                                {{ request()->condition == 'new' ? 'checked' : '' }}
                                {{ request()->name == 'used' || request()->name == 'new' ? 'd-none' : '' }}>
                            <label for="newCars" style="font-size:16px">New Cars</label>
                        </div>
                    </div>
                </div>

                <!-- Year Filter -->
                <!-- Year Filter -->
                <div class="my-2">
                    <label class="form-label mb-2"><strong>Year</strong></label>
                    {{--   <div class="d-flex">
                <select class="form-select year-filter filter-style" name="year" id="years" >
                                        <option value="" selected>Any</option>
                                        @for ($year = date('Y'); $year >= 1960; $year--)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                    </select>
        
                    </div> --}}
                    <div class="row p-1">
                        <div style="position: relative;">
                            <div class="col-12 ">
                                <div class="row">
                                    <div class="col-6 p-0 pe-1 my-3">
                                        <div class="select-wrapper">
                                            <select class="form-select from-year-filter" id="from-year-filter"
                                                aria-label="Default select example">
                                                <option value="" selected>From</option>
                                                @for ($year = date('Y'); $year >= 1960; $year--)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endfor
                                            </select>
                                            <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                                        </div>
                                    </div>
                                    <div class="col-6 p-0 ps-1 my-3">
                                        <div class="select-wrapper">
                                            <select class="form-select to-year-filter" id="to-year-filter"
                                                aria-label="Default select example">
                                                <option value="" selected>To</option>
                                                @for ($year = date('Y'); $year >= 1960; $year--)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endfor
                                            </select>
                                            <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <i class="bi bi-dash dash" style=" "></i>
                        </div>
                    </div>
                </div>

                <!-- Make & Model Filters -->
                <div class="my-2">
                    <label class="form-label"><strong>Make & Model</strong></label>
                    <div class="select-wrapper mt-2">
                        <select id="make_filter" class="form-select select-search mb-2 make-filter filter-style"
                            style="width:100% !important" name="make">
                            <option value="">Make</option>
                            <option value="any">Any</option>
                            @foreach ($makes as $make)
                                <option value="{{ $make->id }}"
                                    {{ request()->make == $make->id || request()->segment(2) == $make->id ? 'selected' : '' }}>
                                    {{ $make->name }} ({{ $make->count }})
                                </option>
                            @endforeach
                        </select> <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                    </div>

                    {{-- <div class="select-wrapper mt-3">
                        <label class="form-label modellabel d-none"> Model</label>
                        <div id="model_filter_wrapper"
                            style="max-height: 200px !important; overflow-y: scroll;
                                        scrollbar-color: #FD5631 #1F1B2D;
                                        scrollbar-width: thin;">
                        </div>
                    </div> --}}

                    <div class="select-wrapper mt-2">
                        <select class="form-select model-filter select-search-class filter-style"
                            style="width:100% !important" name="model" id="model_filter">
                            <option value="" disabled selected>Any model</option>
                            <option value="any">Any</option>
                        </select><i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                    </div>
                </div>

                <!-- Province & City Filters -->
                <div class="my-2">
                    <label class="form-label mb-3"><strong>Province</strong></label>
                    <div class="select-wrapper mt-2">
                        <select class="form-select mb-2  select-search filter-style " style="width:100% !important"
                            id="province_filter">
                            <option value="" disabled selected>Select Province</option>
                            <option value="any">Any</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->id }}"
                                    {{ request()->province == $province->id || request()->province_ == $province->id || request()->segment(2) == $province->id ? 'selected' : '' }}>
                                    {{ $province->name }}
                                    ({{ $province->count }})
                                </option>
                            @endforeach
                        </select><i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                    </div>
                </div>
                <!--     <div class="my-3">
                                                                                                                <label class="form-label mb-3">City</label>
                                                                                                                <div class="select-wrapper">
                                                                                                                    <select class="form-select select-search filter-style" style="width:100% !important"
                                                                                                                        id="city_filter">
                                                                                                                        <option value="" disabled selected>Select City</option>
                                                                                                                        {{-- @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }} ({{ $city->count }})</option>
                                    @endforeach --}}
                                                                                                                    </select><i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                                                                                                                </div>
                                                                                                            </div> -->

                {{-- <div class="my-2">
                    <label class="form-label mb-3 citylabel d-none"><strong>City</strong></label>
                    <div id="city_filter_wrapper"
                        style="max-height: 200px !important ;     overflow-y: scroll;
                                scrollbar-color: #1F1B2D transparent;
                                scrollbar-width: thin;">
                    </div>
                </div> --}}

                <div class="my-2">
                    <label class="form-label mb-3 mt-2 citylabel "><strong>City</strong></label>
                    <div class="select-wrapper">
                        <select class="form-select select2 select-search assembly-filter filter-style assembly_filter"
                            style="width:100% !important" id="city">
                            <option value="" disabled selected>Select Province First</option>
                            <option value="any">Any</option>
                        </select>
                        <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                    </div>
                </div>
                <div class="my-2">
                    <label class="form-label mb-2 mt-2"><strong>Price</strong></label>
                    <div class="slider-container">
                        <!-- Track background -->
                        <div class="range-track"></div>

                        <!-- Progress Bar -->
                        <div id="progressBar" class="progress-bar"></div>

                        <!-- Sliders -->
                        <input type="range" id="minRange" min="0" max="60000000"
                            value="{{ request('min', 0) }}" class="slider">

                        <input type="range" id="maxRange" min="0" max="60000000"
                            value="{{ request('max', 60000000) }}" class="slider">

                    </div>

                    <div class="row pt-5">
                        <div style="position: relative;">
                            <div class="col-12 px-2">
                                <div class="row">
                                    <div class="col-6 p-0 pe-2">
                                        <input type="number" id="minPrice_filter" class="price_class"
                                            value="{{ request('min', 0) }}">
                                    </div>
                                    <div class="col-6 p-0 ps-2">
                                        <input type="number" id="maxPrice_filter" class="price_class"
                                            value="{{ request('max', 60000000) }}">
                                    </div>
                                </div>
                            </div>
                            <i class="bi bi-dash-lg pricedash" style=""></i>
                        </div>
                    </div>

                </div>

                <!-- Engine Capacity, Mileage, and Price Range Filters -->
                <div class="my-3">
                    <label class="form-label mb-4 mt-2"><strong>Engine Capacity (CC)</strong></label>
                    <div class="select-wrapper my-2">
                        {{-- <input type="range" class="form-range engine-capacity-filter" min="1" max="10" step="0.1"> --}}
                        <select class="form-select engine-capacity-filter select-search filter-style" style="width:100%"
                            id="engine_capacity_filter">
                            <option value="" disabled selected>Select Engine Capacity</option>
                            <option value="any">Any</option>
                            <option value="1.6L">1.6L</option>
                            <option value="2.0L">2.0L</option>
                            <option value="3.0L+">3.0L+</option>
                            {{-- @for ($ecap = 1.0; $ecap <= 3.0; $ecap += 0.1)
                                        <option value="{{ number_format($ecap, 1) }}L">{{ number_format($ecap, 1) }}L
                                        </option>
                                    @endfor --}}
                        </select>
                        <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                    </div>


                </div>
                <div class="my-3">
                    <label class="form-label mb-2 mt-2"><strong>Mileage</strong></label>
                    {{-- <input type="range" class="form-range mileage-filter" min="0" max="300000" step="5000"> --}}
                    {{-- <input type="number" class="formcontrol form-control mileage-filter" style="background-color:#282435 !important;" id="" placeholder="Mileage"> --}}
                    <div class="row mt-3">
                        <div style="position: relative;">
                            <div class="col-12 px-2">
                                <div class="row">
                                    <div class="col-6 p-0 pe-2">
                                        <input type="email" class="price_class" id="mileage_from" placeholder="0">
                                    </div>
                                    <div class="col-6 p-0 ps-2">
                                        <input type="email" class="price_class" id="mileage_to" placeholder="0">
                                    </div>
                                </div>
                            </div>
                            <i class="bi bi-dash-lg milagedash" style=" "></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 divheight">
                    <label class="form-label mb-3 mt-2"><strong>Body type</strong></label>
                    @foreach ($bodytypes as $bodytype)
                        <div class="my-2">
                            <input type="checkbox" name="body_type[]" class="filter-checkbox me-2 body_type_filter"
                                value="{{ $bodytype->id }}" id="body_type_filter{{ $bodytype->id }}"
                                {{ request()->bodytype == $bodytype->id || request()->segment(2) == $bodytype->id ? 'checked' : '' }}>
                            <label for="body_type_filter{{ $bodytype->id }}"
                                style="font-size:16px; color: #281F48;">{{ $bodytype->name }}
                                ({{ $bodytype->count }})
                            </label>
                        </div>
                    @endforeach
                </div>

                {{-- <div>
                    <label class="form-label mt-1"><strong>Body type</strong></label>
                    <div class="select-wrapper mt-1">
                        <select class="form-select select2 bodytype-filter select-search formcontrol"
                            style="width:100% !important" style="background-color:#282435" placeholder="Seats"
                            id="bodytype_filter">
                            <option value="" disabled selected>Body type</option>
                            <option value="">Any</option>
                            @foreach ($bodytypes as $body_type)
                                <option value="{{ $body_type->id }}"
                                    {{ request()->type == 'bodytype' && request()->id == $body_type->id ? 'selected' : '' }}>
                                    {{ $body_type->name }} ({{ $body_type->count }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}

                <!-- Fuel Type Filter -->
                <div class="my-2">
                    <label class="form-label mb-2 "><strong>Fuel Type</strong></label>
                    <div class="divheight">
                        {{-- <select class="form-select fuel-type-filter filter-style" name="fuel" id="" >
                                    <option value="" selected>Any</option>
                                        
                                    <option value="Diesel">Diesel</option>
                                <option value="Electric">Electric</option>
                                <option value="Gasoline">Gasoline</option>
                                        
                                    </select> --}}
                        @php
                            $fuelCounts = \App\Models\Post::getFuelTypeCounts();
                            $transmissionCounts = \App\Models\Post::getTransmissionCounts();
                        @endphp

                        @foreach (['Diesel', 'Electric', 'Gasoline', 'Hybrid', 'LPG', 'CNG', 'Petrol'] as $fuelType)
                            <div class="my-2">
                                <input type="checkbox" class="filter-checkbox me-2 fuel_type_filter"
                                    id="{{ $fuelType }}fuelType" value="{{ $fuelType }}">
                                <label for="{{ $fuelType }}fuelType" style="font-size:16px; color: #281F48;">
                                    {{ $fuelType }} ({{ $fuelCounts[$fuelType] ?? 0 }})
                                </label>
                            </div>
                        @endforeach


                    </div>

                    <!-- Add other fuel types similarly -->
                </div>
                <!-- Seating Capacity & Door Count Filters -->
                <div class="my-2">
                    <label class="form-label "><strong>Seating Capacity</strong></label>
                    <div class="select-wrapper mt-3">
                        <select class="form-select seating-capacity-filter select-search formcontrol"
                            style="width:100% !important" style="background-color:#282435" placeholder="Seats"
                            id="seating_capacity_filter">
                            <option value="" disabled selected>Seating Capacity</option>
                            <option value="any">Any</option>
                            <option value="2">2</option>
                            <option value="4">4</option>
                            <option value="5+">5+</option>
                        </select> <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                    </div>
                    {{-- <input type="number" class="form-control seating-capacity-filter formcontrol" placeholder="Seats"> --}}
                </div>
                <!-- Transmission Filter -->
                <div class="my-3">
                    <label class="form-label mb-3 mt-2"><strong>Transmission</strong></label>
                    <div class="d-flex align-items-center">
                        <input type="checkbox" class="transmission-filter me-2 transmission_filter"
                            id="TransmissionAutomatic" value="Automatic">
                        <label for="TransmissionAutomatic">Automatic</label>
                    </div>
                    <div class="d-flex align-items-center mt-2">
                        <input type="checkbox" id="TransmissionManual"
                            class="transmission-filter me-2 transmission_filter" value="Manual">
                        <label for="TransmissionManual">Manual</label>
                    </div>
                </div>

                <div class="my-3">
                    <label class="form-label mb-4"><strong>Door Count</strong></label>
                    <div class="select-wrapper">
                        <select class="form-select select-search door-count-filter formcontrol door_count_filter"
                            style="width:100% !important" placeholder="Doors">
                            <option value="" disabled selected>Door Count</option>
                            <option value="any">Any</option>
                            <option value="2">2</option>
                            <option value="4">4</option>
                            <option value="5+">5+</option>
                        </select> <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                    </div>
                    {{--  <input type="number" class="form-control door-count-filter formcontrol" placeholder="Doors"> --}}
                </div>

                <!-- Assembly Filter -->
                <div class="my-3">
                    <label class="form-label mb-4 mt-1"><strong>Assembly</strong></label>
                    <div class="select-wrapper">
                        <select class="form-select select-search assembly-filter filter-style assembly_filter"
                            style="width:100% !important">
                            <option value="" disabled selected>Select Assembly</option>
                            <option value="any">Any</option>
                            <option value="local">Local</option>
                            <option value="imported">Imported</option>
                        </select>
                        <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                    </div>
                </div>
                <!-- Body Type Filter -->
                {{--  <div class="my-3">
                        <label class="form-label mb-4">Body Type</label>
                    
                        <div>
                            
                                <select class="form-select body-type-filter filter-style" name="bodyType" id="years" >
                                    <option value="" selected>Body Type</option>
                                        @foreach ($bodytypes as $body)
                                    <option value="{{$body->id}}" >{{$body->name}} ({{$body->count}})</option>
                                        @endforeach   
                                    </select>
                    
                        </div>
                
                        <!-- Add other body types similarly -->
                    </div> --}}
                <!-- Exterior Color Filter -->
                <div class="my-3 ">
                    <label class="form-label mb-3 mt-2"><strong>Exterior Color</strong></label>

                    {{--  <div>
                        
                            <select class="form-select color-filter filter-style" name="exteriorColor" id="" >
                                    <option value="" selected>Any</option>
                                        @foreach ($colors as $color)
                                    <option value="{{$color->id}}" {{request()->exterior_color == $color->id?"selected":""}}><span style="background-color:{{$color->name}}" class=" p-0 m-0 px-4 me-3"></span>{{$color->name}} ({{$color->count}})</option>
                                        @endforeach   
                                    </select>
                        </div> --}}
                    <div class="col-12 divheight">
                        @foreach ($colors as $color)
                            <div class="my-2">
                                <input type="checkbox" class="filter-checkbox me-2 exterior_color_filter"
                                    value="{{ $color->id }}" id="exterior_color_filter{{ $color->id }}">
                                <label for="exterior_color_filter{{ $color->id }}"
                                    style="font-size:16px; color: #281F48;"> <span
                                        style="background-color:{{ $color->color_id }}"
                                        class=" p-0 m-0 px-4 me-3"></span>{{ $color->name }}
                                    ({{ $color->count }})
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <!-- Add other colors similarly -->
                </div>

                <!-- Ad Type Filter -->
                <div class="my-3 ">
                    <label class="form-label mb-3"><strong>Ad Type</strong></label>
                    <div>
                        <input type="checkbox" class=" transmission-filter  featureAd_filter" id="featureAd_filter"
                            name="adType">
                        <label for="featureAd_filter">Feature ads only </label>
                    </div>
                </div>

                <div class="my-3">
                    <label class="form-label mb-3"><strong>Seller Type</strong></label>
                    <div class="d-flex">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" class="filter-checkbox" name="userType" data-usertype="car_dealer"
                                value="car_dealer" id="dealer_check">
                            <label for="" class="ms-2" style="font-size:16px">Dealer</label>
                        </div>
                        <div class="d-flex align-items-center ms-3">
                            <input type="checkbox" class="filter-checkbox" name="userType"
                                data-usertype="private_dealer" value="private_dealer" id="private_seller_check">
                            <label for="" class="ms-2" style="font-size:16px">Private Seller</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 ps-md-4">
            <div class="row">
                <div class="col-md-6 col-12">
                    <h3 class="pb-md-2" style="color:#281F48"><strong>Available Cars <small> (<span
                                    id="filter_available_results"></span>) </small></strong></h3>

                </div>
                <div class="col-md-6 col-12 d-flex justify-content-end">
                    <span class="pt-md-3 pagination_count" style="font-size: 18px; color: #FD5631; font-weight:700 ">
                    </span>
                </div>
            </div>
            <div id="post-container" class="post-container">

            </div>

            <div class="mt-2 mb-3 row">
                <div class="col-6 col-md-3 ">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="p-0 col-5 pe-2 d-flex justify-content-end"> <img
                                        src="{{ asset('web/images/sortimg.png') }}" class=""
                                        style="    height: 15px;
                                                width: 15px;
                                                
                                                margin-right: 6px;
                                                margin-top: 6px;">
                                    <p class="pt-1 text-end" style="font-size:12px;font-weight:500">Sort by:</p>
                                </div>
                                <div class="p-0 col-5">
                                    <select class="p-1 "
                                        style="  line-height: 12.68px !important; font-size:12px !important; border-radius: 5px; background-color:#F0F3F6;"
                                        id="sortbyorder">
                                        <option value="" selected>All</option>
                                        <option value="Newest First">Newest First</option>
                                        <option value="Oldest First">Oldest First</option>
                                        <option value="Price: Low to High">Price: Low to High</option>
                                        <option value="Price: High to Low">Price: High to Low</option>
                                        <option value="Model Year: Latest First">Model Year: Latest First</option>
                                        <option value="Model Year: Oldest First">Model Year: Oldest First</option>
                                        <option value="Mileage: High to Low">Mileage: High to Low</option>
                                        <option value="Mileage: Low to High">Mileage: Low to High</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="no_results_message" class="pt-5 row d-none">
                <div class="p-3 col-12" style="border:1px solid #281F48;border-radius:9px;">
                    <div class="row">
                        <div class="col-3">
                            <img src="{{ asset('web/images/noinputs.svg') }}" alt="" class="img-fluid"
                                srcset="">
                        </div>
                        <div class="col-9 text-start">
                            <h1 style="color:#FD5631">Sorry</h1>
                            <p>No matches found for your search. Try adjusting your filters or expanding your criteria
                                to
                                explore available cars!</p>

                        </div>
                    </div>
                </div>
            </div>

            <!-- test -->
            <div class="mb-3 row gy-3 position-relative" id="postresultsContainer">
                <!-- Loader -->

                @include('superadmin.Cars.filtered_posts')
            </div>

            <div style="display: flex;justify-content: space-between;margin-bottom: 10px;">
                <div>
                    <span class="pt-md-3 pagination_count" style="font-size: 18px; color: #FD5631; font-weight:700 ">
                    </span>
                </div>
                <div id="post-container" class="post-container">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#bodytype_filter').select2({
                placeholder: "Select Body Type",
                allowClear: true,
                minimumResultsForSearch: 0
            });
            // Initialize Select2 for Make filter
            $('#make_filter').select2({
                placeholder: "Select Make",
                allowClear: true,
                minimumResultsForSearch: 0
            });

            // Initialize Select2 for Province filter
            $('#province_filter').select2({
                placeholder: "Select Province",
                allowClear: true,
                minimumResultsForSearch: 0
            });

            // Initialize Select2 for City filter
            $('#city').select2({
                placeholder: "Select City",
                allowClear: true,
                minimumResultsForSearch: 0
            });

            // Initialize Select2 for Model filter
            $('.select-search-class').select2({
                placeholder: "Select Model",
                allowClear: true,
                minimumResultsForSearch: 0
            });

            

            // Initialize Select2 for other filters (if needed)
            $('.select-search').not('#make_filter, #province_filter, #city').select2({
                placeholder: function() {
                    return $(this).data('placeholder') || 'Select an option';
                },
                allowClear: true,
                minimumResultsForSearch: 0
            });

            // Trigger change events for dependent filters
            $('#province_filter').change();
            $('#make_filter').change();

            // Submit the form automatically when a dealer is selected (if still needed)
            $('.select-search, .select-search-class').on('change', function() {
                $('#dealerForm').submit();
            });

            $('.select-search').not('#make_filter, #province_filter, #city').select2({
                placeholder: function() {
                    return $(this).data('placeholder') || 'Select an option';
                },
                allowClear: true,
                minimumResultsForSearch: 0
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#province_filter').change();
            $('#make_filter').change();
        });

        // $('#province_filter').change(function(e) {
        //     var selectedCityId = "{{ request()->city }}";

        //     var provinceId = this.value;
        //     var cityWrapper = document.getElementById('city_filter_wrapper');
        //     var cityLabel = $('.citylabel');
        //     // Clear the existing city checkboxes
        //     cityWrapper.innerHTML = '';
        //     cityLabel.addClass('d-none'); // Hide label initially
        //     var urlPath = encodeURIComponent(window.location.pathname);
        //     // Fetch cities based on the selected province
        //     // if (provinceId) {
        //     //     fetch(`/getCity/${provinceId}?path=${urlPath}`)
        //     //         .then(response => response.json())
        //     //         .then(data => {
        //     //             data.forEach(city => {
        //     //                 var div = document.createElement('div');
        //     //                 div.classList.add('form-check', 'my-2');

        //     //                 var checkbox = document.createElement('input');
        //     //                 checkbox.type = 'checkbox';
        //     //                 checkbox.classList.add('filter-checkbox',
        //     //                     'city_filter'); // Apply custom checkbox class
        //     //                 checkbox.id = 'city_' + city.id;
        //     //                 checkbox.value = city.id;
        //     //                 checkbox.name = 'city[]';
        //     //                 if (selectedCityId == city.id) {
        //     //                     checkbox.checked = true;
        //     //                 }
        //     //                 var label = document.createElement('label');
        //     //                 label.classList.add('form-check-label', 'ms-3');
        //     //                 label.htmlFor = 'city_' + city.id;
        //     //                 label.textContent = city.name + ' (' + (city.count || 0) + ')';

        //     //                 div.appendChild(checkbox);
        //     //                 div.appendChild(label);
        //     //                 $('.citylabel').removeClass('d-none');
        //     //                 cityWrapper.appendChild(div);
        //     //             });
        //     //             fetchFilteredResults();
        //     //         })
        //     //         .catch(error => console.error('Error fetching cities:', error));
        //     // } else {
        //     //     $('.citylabel').addClass('d-none');
        //     // }

        //     if (provinceId) {
        //         $.get(`/getCity/${provinceId}?path=${urlPath}`, function(data) {
        //             data.forEach(city => {
        //                 citySelect.append(
        //                     `<option value="${city.id}" ${city.id == selectedCityId ? 'selected' : ''} >${city.name + '('+ city.bike_count +')' }</option>`
        //                 );
        //             });
        //             citySelect.trigger('change.select2');
        //         });
        //     }
        // });


        $('#province_filter').on('change', function() {
            const provinceId = $(this).val();
            const citySelect = $('#city');
            var urlPath = encodeURIComponent(window.location.pathname);
            var selectedCityId = "{{ request()->city }}";
            citySelect.empty().append('<option value="">Select City</option>');

            if (provinceId) {
                $.get(`/getCity/${provinceId}?path=${urlPath}`, function(data) {
                    data.forEach(city => {
                        citySelect.append(
                            `<option value="${city.id}" ${city.id == selectedCityId ? 'selected' : ''} >${city.name + '('+ city.count +')' }</option>`
                        );
                    });
                    citySelect.trigger('change.select2');
                });
            }
        });

        $('#make_filter').on('change', function() {
            const makeId = $(this).val();
            const urlPath = encodeURIComponent(window.location.pathname);
            const modelSelect = $('#model_filter');
            const selectedModelId = "{{ request()->model }}"; // This works if inside a Blade view
            modelSelect.empty().append('<option value="">Select Model</option>');

            if (makeId) {
                $.get('/getmodel/' + makeId, {
                    path: urlPath
                }, function(data) {
                    // Remove return; if you want it to populate!
                    data.forEach(model => {
                        modelSelect.append(
                            `<option value="${model.id}" ${model.id == selectedModelId ? 'selected' : ''}>
                        ${model.name} (${model.count})
                    </option>`
                        );
                    });
                    modelSelect.trigger('change.select2'); // Update select2
                });
            }
        });


        // to get models based on selected make
        // $('#make_filter').change(function(e) {
        //     var selectedModelId = "{{ request()->model }}";
        //     var makeId = this.value;
        //     var modelWrapper = document.getElementById('model_filter_wrapper');
        //     var modelLabel = $('.model-label'); // Target the label

        //     // Clear the current model options
        //     modelWrapper.innerHTML = '';
        //     modelLabel.addClass('d-none'); // Hide label initially
        //     var urlPath = encodeURIComponent(window.location.pathname);
        //     // console.log(urlPath);
        //     // Fetch models based on selected make
        //     if (makeId) {
        //         fetch(`/getmodel/${makeId}?path=${urlPath}`)
        //             .then(response => response.json())
        //             .then(data => {
        //                 //console.log(data);
        //                 if (data.length > 0) {
        //                     modelLabel.removeClass('d-none'); // Show label if models exist
        //                 }

        //                 data.forEach(model => {
        //                     var div = document.createElement('div');
        //                     div.classList.add('form-check', 'my-2');

        //                     var checkbox = document.createElement('input');
        //                     checkbox.type = 'checkbox';
        //                     checkbox.classList.add('filter-checkbox',
        //                         'model-filter'); // Apply custom checkbox styling
        //                     checkbox.id = 'model_' + model.id;
        //                     checkbox.value = model.id;
        //                     checkbox.name = 'model[]';
        //                     if (selectedModelId == model.id) {
        //                         checkbox.checked = true;
        //                     }
        //                     var label = document.createElement('label');
        //                     label.classList.add('form-check-label', 'ms-3');
        //                     label.htmlFor = 'model_' + model.id;
        //                     label.textContent = model.name + ' (' + (model.count || 0) + ')';

        //                     div.appendChild(checkbox);
        //                     div.appendChild(label);
        //                     $('.modellabel').removeClass('d-none');
        //                     modelWrapper.appendChild(div);
        //                 });
        //                 fetchFilteredResults();
        //             })
        //             .catch(error => console.error('Error fetching models:', error));
        //     } else {
        //         $('.modellabel').addClass('d-none');
        //     }
        // });
    </script>

    {{-- filters script  --}}
    <script>
        $(document).ready(function() {
            $(".price_class").on("focus", function() {
                if ($(this).val() == "0" || $(this).val() == "60000000") {
                    $(this).val("");
                }
            });

            $(".price_class").on("blur", function() {
                if ($(this).val().trim() === "") {
                    $(this).val($(this).attr("id") === "minPrice_filter" ? "0" : "60000000");
                }
            });
        });
    </script>

    <script>
        function fetchFilteredResults(page = 1) {
            let sortBy = $('#sortbyorder').val() || null;
            let fromYear = $('#from-year-filter').val() || null;
            let toYear = $('#to-year-filter').val() || null;
            let engineCapacity = $('#engine_capacity_filter').val() || null;
            let mileageFrom = $('#mileage_from').val() || null;
            let mileageTo = $('#mileage_to').val() || null;
            let minPrice = Number($('#minPrice_filter').val()) || 0;
            let maxPrice = Number($('#maxPrice_filter').val()) || 60000000;
            let seatingCapacity = $('#seating_capacity_filter').val() || null;
            let transmission = $('.transmission_filter:checked').map(function() {
                return this.value;
            }).get();
            let doorCount = $('.door_count_filter').val() || null;
            let assembly = $('.assembly_filter').val() || null;
            let featureAd = $('#featureAd_filter').is(':checked') ? 1 : null;
            let sellerType = $('input[name="userType"]:checked').map(function() {
                return this.value;
            }).get();
            let conditionType = $('input[name="condition"]:checked').map(function() {
                return this.value;
            }).get();
            let fuelType = $('.fuel_type_filter:checked').map(function() {
                return this.value;
            }).get();
            let exteriorColor = $('.exterior_color_filter:checked').map(function() {
                return this.value;
            }).get();
            let bodyType = $('.body_type_filter:checked').map(function() {
                return this.value;
            }).get();
            let make = $('#make_filter').val() || null;

            let model = $('input.model-filter:checked').map(function() {
                return this.value;
            }).get();

            let province = $('#province_filter').val() || null;

            let city = $('input.city_filter:checked').map(function() {
                return this.value;
            }).get();


            let urlPath = window.location.pathname.split('/');
            let type = urlPath[2] || 'search';

            let filters = {
                from_year: fromYear,
                to_year: toYear,
                engine_capacity: engineCapacity,
                mileage_from: mileageFrom,
                mileage_to: mileageTo,
                min_price: minPrice,
                max_price: maxPrice,
                seating_capacity: seatingCapacity,
                door_count: doorCount,
                assembly: assembly,
                transmission: transmission,
                feature_ad: featureAd,
                seller_type: sellerType.length > 0 ? sellerType : null,
                fuel_type: fuelType.length > 0 ? fuelType : null,
                exterior_color: exteriorColor.length > 0 ? exteriorColor : null,
                body_type: bodyType.length > 0 ? bodyType : null,
                make: make,
                model: model,
                city: city,
                province: province,
                sortby: sortBy,
                condition: conditionType,
                page: page
            };
            //console.log(filters);
            $("#loadingSpinner").removeClass("d-none");

            $.ajax({
                url: "/posts/" + type,
                method: "GET",
                data: filters,
                success: function(response) {
                    $('#postresultsContainer').html(response.html);
                    $("#filter_available_results").text(response.posts_count);

                    if (response.posts_count > 0) {

                        loadGoogleMaps(initDistance);
                        $(".post-container")
                            .removeClass("d-none")
                            .css({
                                "display": "flex",
                                "justify-content": "flex-end"
                            });

                        $("#no_results_message").addClass("d-none"); // Hide no results message
                    } else {
                        $(".post-container").addClass("d-none"); // Hide container
                        $("#no_results_message").removeClass("d-none"); // Show no results message

                    }
                },
                complete: function() {
                    $("#loadingSpinner").addClass("d-none");
                }
            });
        }

        $(document).ready(function() {
            const minRange = document.getElementById("minRange");
            const maxRange = document.getElementById("maxRange");
            const minPrice = document.getElementById("minPrice_filter");
            const maxPrice = document.getElementById("maxPrice_filter");
            const progressBar = document.getElementById("progressBar");

            const gap = 10000; // Minimum allowed gap
            const totalRange = 60000000; // Max price

            function updateProgress() {
                let minValue = parseInt(minRange.value);
                let maxValue = parseInt(maxRange.value);

                let minPercent = (minValue / totalRange) * 100;
                let maxPercent = (maxValue / totalRange) * 100;

                progressBar.style.left = minPercent + "%";
                progressBar.style.width = (maxPercent - minPercent) + "%";
            }

            function handleMinChange() {
                let minValue = parseInt(minRange.value);
                let maxValue = parseInt(maxRange.value);

                if (minValue + gap > maxValue) {
                    minValue = maxValue - gap; // Prevent pushing max forward
                }
                minRange.value = minValue;
                minPrice.value = minValue;
                updateProgress();
                fetchFilteredResults();
            }

            function handleMaxChange() {
                let minValue = parseInt(minRange.value);
                let maxValue = parseInt(maxRange.value);

                if (maxValue - gap < minValue) {
                    maxValue = minValue + gap; // Prevent pulling min backward
                }
                maxRange.value = maxValue;
                maxPrice.value = maxValue;
                updateProgress();
                fetchFilteredResults();
            }

            function handleMinInputChange() {
                let minValue = parseInt(minPrice.value) || 0;
                let maxValue = parseInt(maxRange.value);

                if (minValue < 0) minValue = 0;
                if (minValue + gap > maxValue) minValue = maxValue - gap;

                minPrice.value = minValue;
                minRange.value = minValue;
                updateProgress();
                fetchFilteredResults();
            }

            function handleMaxInputChange() {
                let minValue = parseInt(minRange.value);
                let maxValue = parseInt(maxPrice.value) || totalRange;

                if (maxValue > totalRange) maxValue = totalRange;
                if (maxValue - gap < minValue) maxValue = minValue + gap;

                maxPrice.value = maxValue;
                maxRange.value = maxValue;
                updateProgress();
                fetchFilteredResults();
            }

            minRange.addEventListener("input", handleMinChange);
            maxRange.addEventListener("input", handleMaxChange);
            minPrice.addEventListener("input", handleMinInputChange);
            maxPrice.addEventListener("input", handleMaxInputChange);

            updateProgress();

            $(document).on('change',
                '.form-select, .price_class, .filter-checkbox, .transmission_filter, \
                                                                                            #engine_capacity_filter, #from-year-filter, #to-year-filter, \
                                                                                            #mileage_from, #mileage_to, #sortbyorder, .door_count_filter, .assembly_filter, \
                                                                                            #featureAd_filter, input[name="userType"], input[name="model"], input[name="city"]',
                function() {
                    fetchFilteredResults();
                });

            fetchFilteredResults();
        });



        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            if (page) {
                fetchFilteredResults(page);
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fromYearFilter = document.getElementById("from-year-filter");
            const toYearFilter = document.getElementById("to-year-filter");
            const currentYear = new Date().getFullYear(); // Get the current year

            fromYearFilter.addEventListener("change", function() {
                let selectedFromYear = parseInt(this.value) ||
                    currentYear; // Default to current year if empty

                // Reset the "To Year" dropdown
                toYearFilter.innerHTML = '<option value="" selected>To</option>';

                // Populate "To Year" dropdown from (selectedFromYear + 1) to current year
                for (let year = currentYear; year >= selectedFromYear + 1; year--) {
                    let option = document.createElement("option");
                    option.value = year;
                    option.textContent = year;
                    toYearFilter.appendChild(option);
                }
            });
        });
        $(document).ready(function() {
            $(document).on("click", ".page-link", function(e) {
                e.preventDefault(); // Stop default page reload

                let page = $(this).data("page"); // Get the page number from data attribute
                let url = $(this).attr("href"); // Get the pagination URL

                if (!page) return; // Ensure page number exists

                $.ajax({
                    url: "{{ route('search') }}", // Update with your actual route
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        page: page,
                    },
                    beforeSend: function() {
                        $("#post-container").css("opacity", "0.5"); // Show loading effect
                    },
                    success: function(response) {
                        // Update only the post container
                        $("#post-container").html($(response).find("#post-container").html());

                        // Update pagination links
                        $("#pagination-links").html($(response).find("#pagination-links")
                            .html());

                        // Reset opacity after loading
                        $("#post-container").css("opacity", "1");

                        // Update active state for pagination
                        $(".page-link").removeClass("active").css("background-color",
                            "#444"); // Reset all
                        $('.page-link[data-page="' + page + '"]').addClass("active").css(
                            "background-color", "#FD5631"); // Set active link

                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
