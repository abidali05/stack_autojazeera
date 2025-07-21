@extends('layout.website_layout.main')
@section('content')
    <style>
        #goToTop,
        #goToBottom {
            position: fixed;
            right: 20px;
            padding: 10px;
            padding-left: 15px;
            width: 60px;
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
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

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
            background: #FFE4E4;
            color: #281F48;
            border: 1px solid #FFE4E4;
            border-radius: 5px;
        }

        .loading-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
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

        .price_class:focus {
            color: none;
            background-color: #F0F3F6 !important;
            border-color: #F0F3F6;
            outline: 0;
            box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
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

        .divheight {
            overflow-y: auto;
            height: 200px;
            scrollbar-color: #281F48 #F0F3F6;
            scrollbar-width: thin;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #281F48;
            line-height: 28px;
        }

        .select2-dropdown {

            border: none;

        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #F0F3F6 !important;
            color: #281F48 !important;
            /* Change text color for better contrast */
        }label.form-label {
    font-family: Maven Pro;
    font-size: 17.6px;
    font-weight: 500;
    line-height: 20.68px;
    text-align: left;
    color: #281F48;
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
                        <div class="search-container ">
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
                                style="color:#281F48;font-weight:900 !important ;border:1px solid #281F48;  padding:5px; border-radius:5px">Clear
                                Filters</button>
                    </form>
                    <h6 class="m-0 " style="font-weight:900 !important ; color:#281F48">Condition</h6>
                </div>
                <div class="">


                    <div class="my-3" style="display: flex; gap: 10px; align-items: center ;">
                        <div class="{{ request()->name == 'new' ? 'd-none' : '' }}">
                            <input type="checkbox" class="filter-checkbox" name="condition" data-filter="condition"
                                value="used" id="usedCars_check" {{ request()->name == 'used' ? 'checked' : '' }}
                                disabled>
                            <label for="usedCars" style="font-size:16px;color:#281F48">Used Cars</label>
                        </div>
                        <div class="{{ request()->name == 'used' ? 'd-none' : '' }}">
                            <input type="checkbox" class="filter-checkbox" name="condition" data-filter="condition"
                                value="new" id="newCars_check" {{ request()->name == 'new' ? 'checked' : '' }} disabled>
                            <label for="newCars" style="font-size:16px ; color:#281F48">New Cars</label>
                        </div>
                    </div>
                </div>

                <!-- Year Filter -->
                <div class="">
                    <label class="m-0 form-label" style=" color:#281F48"><strong>Year</strong></label>
                    <div class="p-1 row">
                        <div style="position: relative;">
                            <div class="col-12 ">
                                <div class="row">
                                    <div class="p-0 my-3 col-6 pe-1 ps-2">
                                        <div class="p-0 select-wrapper">
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
                                    <div class="p-0 my-3 col-6 ps-2 pe-2">
                                        <div class="p-0 select-wrapper">
                                            <select class="form-select to-year-filter" id="to-year-filter"
                                                aria-label="Default select example">
                                                <option selected>To</option>
                                                @for ($year = date('Y'); $year >= 1960; $year--)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endfor
                                            </select>
                                            <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <i class="bi bi-dash"
                                style="    color: #BFBEC3;
                                        position: absolute;
                                        top: 35%;
                                        right: 9%;
                                        width: 120px; "></i>
                        </div>
                    </div>
                </div>
                <!-- Make & Model Filters -->
                <div class="">
                    <label class="mb-2 form-label" style=" color:#281F48"><strong>Make</strong></label>
                    <div class="mt-3 select-wrapper">
                        <select id="make_filter" class="mb-2 form-select select-search make-filter filter-style"
                            style="width:100% !important" name="make">
                            <option value="" selected>Any make</option>
                            @if (isset($makes))
                                @foreach ($makes as $make)
                                    <option value="{{ $make->id }}"
                                        {{ request()->make == $make->id ? 'selected' : '' }}>
                                        {{ $make->name }} ({{ $make->count }})</option>
                                @endforeach
                            @endif
                        </select> <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                    </div>
                    <div class="mt-3 select-wrapper">
                        <label class="form-label modellabel d-none" style=" color:#281F48"> <strong>Model</strong></label>
                        <div id="model_filter_wrapper"
                            style="max-height: 200px !important ;     overflow-y: scroll;
									scrollbar-color: #FD5631 #1F1B2D;
									scrollbar-width: thin;">
                        </div>
                    </div>
                </div>
                <!-- Province & City Filters -->
                <div class="">
                    <label class="mt-2 form-label" style=" color:#281F48"><strong>Province</strong></label>
                    <div class="mt-3 select-wrapper">
                        <select class="mb-2 form-select select-search filter-style " style="width:100% !important"
                            id="province_filter">
                            <option value="" disabled selected>Select Province</option>
                            @if (isset($provinces))
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}"
                                        {{ request()->province_ == $province->id ? 'selected' : '' }}>
                                        {{ $province->name }}
                                        ({{ $province->count }})
                                    </option>
                                @endforeach
                            @endif
                        </select><i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                    </div>
                </div>

                <div class="my-3 select-wrapper">
                    <label class="mb-3 form-label citylabel d-none" style=" color:#281F48"><strong>City</strong></label>
                    <div id="city_filter_wrapper"
                        style="max-height: 330px !important ;     overflow-y: scroll;
							scrollbar-color: #FD5631 #1F1B2D;
							scrollbar-width: thin;">
                        {{-- Cities will be added dynamically here --}}
                    </div>
                </div>

                <div class="">
                    <label class="m-0 form-label" style=" color:#281F48"><strong>Price</strong></label>
                    <div class="slider-container">
                        <!-- Track background -->
                        <div class="range-track"></div>

                        <!-- Progress Bar -->
                        <div id="progressBar" class="progress-bar"></div>

                        <!-- Sliders -->
                        <input type="range" id="minRange" min="0" max="60000000" value="0"
                            class="slider">
                        <input type="range" id="maxRange" min="0" max="60000000" value="60000000"
                            class="slider">
                    </div>


                    <div class="pt-5 row">
                        <div style="position-relative">
                            <div class="px-2 col-12">
                                <div class="row">
                                    <div class="p-0 col-6 pe-2">
                                        <input type="number" id="minPrice_filter" class="price_class" value="0">
                                    </div>
                                    <div class="p-0 col-6 ps-2">
                                        <input type="number" id="maxPrice_filter"
                                            style="background-color:#F0F3F6 !important" class="price_class"
                                            value="60000000">
                                    </div>
                                </div>
                            </div>
                            <i class="bi bi-dash-lg"
                                style="color: #BFBEC3;position: absolute;    top: 108%;
                                        left: 196px;"></i>
                        </div>
                    </div>
                </div>

                <!-- Engine Capacity, Mileage, and Price Range Filters -->
                <div class="my-3">
                    <label class="mt-2 mb-2 form-label" style=" color:#281F48"><strong>Engine Capacity (CC)</strong></label>
                    <div class="mt-3 select-wrapper">
                        <select class="form-select engine-capacity-filter select-search filter-style"
                            id="engine_capacity_filter">
                            <option value="">Select Engine Capacity</option>
                            <option value="1.6L">1.6L</option>
                            <option value="2.0L">2.0L</option>
                            <option value="3.0L+">3.0L+</option>
                        </select>
                        <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>

                    </div>
                    <div class="my-3">
                        <label class="mt-2 mb-0 form-label" style=" color:#281F48"><strong>Mileage</strong></label>
                        <div class="mt-4 row">
                            <div style="position: relative;">
                                <div class="px-2 col-12">
                                    <div class="row">
                                        <div class="p-0 col-6 pe-2">
                                            <input type="email" class="price_class" id="mileage_from" placeholder="0">
                                        </div>
                                        <div class="p-0 col-6 ps-2">
                                            <input type="email" class="price_class" style=" background-color: #F0F3F6;"
                                                id="mileage_to" placeholder="0">
                                        </div>
                                    </div>
                                </div>
                                <i class="bi bi-dash-lg"
                                    style="color: #BFBEC3;position: absolute;top: 23% ;right: 47%;  "></i>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 divheight">
                        <label class="mt-2 mb-2 form-label " style=" color:#281F48"><strong>Body type</strong></label>
                        @if (isset($bodytypes))
                            @foreach ($bodytypes as $bodytype)
                                <div class="my-2">
                                    <input type="checkbox" name="body_type[]"
                                        class="filter-checkbox me-2 body_type_filter" value="{{ $bodytype->id }}"
                                        id="body_type_filter{{ $bodytype->id }}"
                                        {{ request()->bodytype == $bodytype->id ? 'checked' : '' }}>
                                    <label for="usedCars" style="font-size:16px; color: #281F48;">{{ $bodytype->name }}
                                        ({{ $bodytype->count }})</label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <!-- Fuel Type Filter -->
                    <div class="my-2">
                        <label class="mb-2 form-label " style=" color:#281F48"><strong>Fuel Type</strong></label>
                        <div class="divheight">
                            @php
                                $fuelCounts = \App\Models\Post::getFuelTypeCounts();
                                $transmissionCounts = \App\Models\Post::getTransmissionCounts();
                            @endphp

                            @foreach (['Diesel', 'Electric', 'Gasoline', 'Hybrid', 'Hydrogen', 'Plug-in Hybrid'] as $fuelType)
                                <div class="my-2">
                                    <input type="checkbox" class="filter-checkbox me-2 fuel_type_filter"
                                        id="{{ $fuelType }}fuelType" value="{{ $fuelType }}">
                                    <label for="{{ $fuelType }}fuelType" style="font-size:16px; color: #281F48;">
                                        {{ $fuelType }} ({{ $fuelCounts[$fuelType] ?? 0 }})
                                    </label>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <!-- Seating Capacity & Door Count Filters -->
                    <div class="my-2">
                        <label class="form-label " style=" color:#281F48"><strong>Seating Capacity</strong></label>
                        <div class="mt-3 select-wrapper">
                            <select class="form-select seating-capacity-filter select-search formcontrol"
                                style="width:100% !important" style="background-color:#282435" placeholder="Seats"
                                id="seating_capacity_filter">
                                <option value="" selected>Seating Capacity</option>
                                <option value="2">2</option>
                                <option value="4">4</option>
                                <option value="5+">5+</option>
                            </select> <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                        </div>
                    </div>
                    <!-- Transmission Filter -->
                    <div class="my-3">
                        <label class="form-label mb-3 mt-2" style=" color:#281F48"><strong>Transmission</strong></label>
                        <div class="d-flex align-items-center">
                            <input type="checkbox" class="transmission-filter me-2 transmission_filter"
                                id="TransmissionAutomatic" value="Automatic">
                            <label for="TransmissionAutomatic"style=" color:#281F48">Automatic</label>
                        </div>
                        <div class="d-flex align-items-center mt-2">
                            <input type="checkbox" id="TransmissionManual"
                                class="transmission-filter me-2 transmission_filter" value="Manual">
                            <label for="TransmissionManual"style=" color:#281F48">Manual</label>
                        </div>
                    </div>

                    <div class="my-2">
                        <label class="mb-4 form-label" style=" color:#281F48"><strong>Door Count</strong></label>
                        <div class="select-wrapper">
                            <select class="form-select select-search door-count-filter formcontrol door_count_filter"
                                style="width:100% !important" placeholder="Doors">
                                <option value="" selected>Door Count</option>
                                <option value="2">2</option>
                                <option value="4">4</option>
                                <option value="5+">5+</option>
                            </select> <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                        </div>
                    </div>

                    <!-- Assembly Filter -->
                    <div class="my-3">
                        <label class="mb-4 form-label" style=" color:#281F48"><strong>Assembly</strong></label>
                        <div class="select-wrapper">
                            <select class="form-select select-search assembly-filter filter-style assembly_filter"
                                style="width:100% !important">
                                <option value="" disabled selected>Select Assembly</option>
                                <option value="local">Local</option>
                                <option value="imported">Imported</option>
                            </select>
                            <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                        </div>
                    </div>
                    <!-- Exterior Color Filter -->
                    <div class="my-3 ">
                        <label class="mb-3 form-label" style=" color:#281F48"><strong>Exterior Color</strong></label>
                        <div class="col-12 divheight">
                            @if (isset($colors))
                                @foreach ($colors as $color)
                                    <div class="my-2">
                                        <input type="checkbox" class="filter-checkbox me-2 exterior_color_filter"
                                            value="{{ $color->id }}" id="exterior_color_filter{{ $color->id }}">
                                        <label for="exterior_color_filter{{ $color->id }}"
                                            style="font-size:16px; color: #281F48;"> <span
                                                style="background-color:{{ $color->color_id }}"
                                                class="p-0 px-4 m-0 me-3"></span>{{ $color->name }}
                                            ({{ $color->count }})</label>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                    <!-- Ad Type Filter -->
                    <div class="my-3 ">
                        <label class="form-label" style=" color:#281F48"><strong>Ad Type</strong></label>
                        <div>
                            <input type="checkbox" class=" transmission-filter featureAd_filter" id="featureAd_filter"
                                name="adType">
                            <label for="featureAd_filter" style=" color:#281F48">Feature ads only </label>
                        </div>
                    </div>

                    <div class="my-3" style=" ">
                        <label class="mb-3 form-label" style=" color:#281F48"><strong>Seller Type</strong></label>
                        <div class="d-flex ">
                            <div class="d-flex align-items-center">
                                <input type="checkbox" class="filter-checkbox" name="userType"
                                    data-usertype="car_dealer" value="car_dealer" id="dealer_check">
                                <label for="" class="ms-2" style="font-size:16px ;color:#281F48">Dealer</label>
                            </div>
                            <div class="d-flex align-items-center ms-4">
                                <input type="checkbox" class="filter-checkbox" name="userType"
                                    data-usertype="private_dealer" value="private_dealer" id="private_seller_check">
                                <label for="" class="ms-2" style="font-size:16px ;color:#281F48">Private
                                    Seller</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9 ps-md-4">
            <div class="row">
                <div class="col-md-6 col-12">
                    <h1 class="pb-md-2" style=" color:#281F48"><strong>Available Cars </strong> (<span
                                id="filter_available_results"></span>) </h1>
                </div>
                <div class="col-md-6 col-12 d-flex justify-content-end">
                    <span class="pt-md-3 pagination_count" style="font-size: 18px; color: #FD5631; font-weight:700 ">
                    </span>
                </div>
            </div>


            <div class="post-container">
                <div class="row">
                    <div class="col-12 d-flex justify-content-end">
                        <div id="custom-pagination-container">
                            @if ($posts->hasPages())
                                <nav class="d-flex justify-content-end align-items-center">
                                    <ul class="custom-pagination"
                                        style="display: flex; list-style: none; gap: 8px; justify-content: center; padding: 0; margin: 0;">

                                        {{-- Previous Page (Back Arrow) --}}
                                        @if ($posts->onFirstPage())
                                            <li>
                                                <span class="custom-disabled"
                                                    style="display: inline-flex; justify-content: center; align-items: center; 
                                   width: 35px; height: 35px; border-radius: 50%; background-color: #aaa; 
                                   color: #fff; cursor: not-allowed; font-size: 18px;">&laquo;</span>
                                            </li>
                                        @else
                                            <li>
                                                <a href="{{ $posts->previousPageUrl() }}"
                                                    class="custom-page-link custom-prev-page"
                                                    data-page="{{ $posts->currentPage() - 1 }}"
                                                    style="display: inline-flex; justify-content: center; align-items: center; 
                                   width: 35px; height: 35px; border-radius: 50%; background-color: #444; 
                                   color: #fff; font-size: 18px; transition: 0.3s;">
                                                    &laquo;
                                                </a>
                                            </li>
                                        @endif

                                        {{-- Page Numbers --}}
                                        @foreach ($posts->links()->elements as $element)
                                            @if (is_string($element))
                                                <li>
                                                    <span class="custom-disabled"
                                                        style="display: inline-flex; justify-content: center; align-items: center; 
                                       width: 35px; height: 35px; border-radius: 50%; background-color: #444; 
                                       color: #fff; font-size: 16px;">{{ $element }}</span>
                                                </li>
                                            @endif

                                            @if (is_array($element))
                                                @foreach ($element as $page => $url)
                                                    <li>
                                                        <a href="{{ $url }}"
                                                            class="custom-page-link {{ $page == $posts->currentPage() ? 'custom-active' : '' }}"
                                                            data-page="{{ $page }}"
                                                            style="display: inline-flex; justify-content: center; align-items: center; 
                                           width: 35px; height: 35px; border-radius: 50%; text-decoration: none; 
                                           font-size: 16px; background-color: {{ $page == $posts->currentPage() ? '#FD5631' : '#444' }}; 
                                           color: #fff; transition: 0.3s;">
                                                            {{ $page }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        @endforeach

                                        {{-- Next Page (Forward Arrow) --}}
                                        @if ($posts->hasMorePages())
                                            <li>
                                                <a href="{{ $posts->nextPageUrl() }}"
                                                    class="custom-page-link custom-next-page"
                                                    data-page="{{ $posts->currentPage() + 1 }}"
                                                    style="display: inline-flex; justify-content: center; align-items: center; 
                                   width: 35px; height: 35px; border-radius: 50%; background-color: #444; 
                                   color: #fff; font-size: 18px; transition: 0.3s;">
                                                    &raquo;
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <span class="custom-disabled"
                                                    style="display: inline-flex; justify-content: center; align-items: center; 
                                   width: 35px; height: 35px; border-radius: 50%; background-color: #aaa; 
                                   color: #fff; cursor: not-allowed; font-size: 18px;">&raquo;</span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            @endif
                        </div>
                    </div>
                </div>

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
                                    <select class="p-1 formcontrol"
                                        style="  line-height: 12.68px !important; font-size:12px !important; background-color:#F0F3F6 !important;color:#281F48"
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
                <div class="p-3 col-12" style="border:1px solid #FD5631;border-radius:9px;">
                    <div class="row">
                        <div class="col-3">
                            <img src="{{ asset('web/images/noinput.svg') }}" alt="" class="img-fluid"
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
                <div id="loadingSpinner" class="loading-overlay d-none">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                @include('superadmin.Cars.filtered_posts')
            </div>

            <div style="display: flex;justify-content: space-between;margin-bottom: 10px;">
                <div>
                    <span class="pt-md-3 pagination_count" style="font-size: 18px; color: #FD5631; font-weight:700 ">
                    </span>
                </div>
                <div class="post-container">
                    <div id="custom-pagination-container">
                        @if ($posts->hasPages())
                            <nav class="d-flex justify-content-end align-items-center">
                                <ul class="custom-pagination"
                                    style="display: flex; list-style: none; gap: 8px; justify-content: center; padding: 0; margin: 0;">

                                    {{-- Previous Page (Back Arrow) --}}
                                    @if ($posts->onFirstPage())
                                        <li>
                                            <span class="custom-disabled"
                                                style="display: inline-flex; justify-content: center; align-items: center; 
                                   width: 35px; height: 35px; border-radius: 50%; background-color: #aaa; 
                                   color: #fff; cursor: not-allowed; font-size: 18px;">&laquo;</span>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ $posts->previousPageUrl() }}"
                                                class="custom-page-link custom-prev-page"
                                                data-page="{{ $posts->currentPage() - 1 }}"
                                                style="display: inline-flex; justify-content: center; align-items: center; 
                                   width: 35px; height: 35px; border-radius: 50%; background-color: #444; 
                                   color: #fff; font-size: 18px; transition: 0.3s;">
                                                &laquo;
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Page Numbers --}}
                                    @foreach ($posts->links()->elements as $element)
                                        @if (is_string($element))
                                            <li>
                                                <span class="custom-disabled"
                                                    style="display: inline-flex; justify-content: center; align-items: center; 
                                       width: 35px; height: 35px; border-radius: 50%; background-color: #444; 
                                       color: #fff; font-size: 16px;">{{ $element }}</span>
                                            </li>
                                        @endif

                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                <li>
                                                    <a href="{{ $url }}"
                                                        class="custom-page-link {{ $page == $posts->currentPage() ? 'custom-active' : '' }}"
                                                        data-page="{{ $page }}"
                                                        style="display: inline-flex; justify-content: center; align-items: center; 
                                           width: 35px; height: 35px; border-radius: 50%; text-decoration: none; 
                                           font-size: 16px; background-color: {{ $page == $posts->currentPage() ? '#FD5631' : '#444' }}; 
                                           color: #fff; transition: 0.3s;">
                                                        {{ $page }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif
                                    @endforeach

                                    {{-- Next Page (Forward Arrow) --}}
                                    @if ($posts->hasMorePages())
                                        <li>
                                            <a href="{{ $posts->nextPageUrl() }}"
                                                class="custom-page-link custom-next-page"
                                                data-page="{{ $posts->currentPage() + 1 }}"
                                                style="display: inline-flex; justify-content: center; align-items: center; 
                                   width: 35px; height: 35px; border-radius: 50%; background-color: #444; 
                                   color: #fff; font-size: 18px; transition: 0.3s;">
                                                &raquo;
                                            </a>
                                        </li>
                                    @else
                                        <li>
                                            <span class="custom-disabled"
                                                style="display: inline-flex; justify-content: center; align-items: center; 
                                   width: 35px; height: 35px; border-radius: 50%; background-color: #aaa; 
                                   color: #fff; cursor: not-allowed; font-size: 18px;">&raquo;</span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        @endif
                    </div>

                </div>
            </div>
        </div>
 </div> </div>
        <script>
            $('#province_filter').change(function(e) {
                var provinceId = this.value;
                var cityWrapper = document.getElementById('city_filter_wrapper');
                var cityLabel = $('.citylabel');
                // Clear the existing city checkboxes
                cityWrapper.innerHTML = '';
                cityLabel.addClass('d-none'); // Hide label initially
                var urlPath = encodeURIComponent(window.location.pathname);
                // Fetch cities based on the selected province
                if (provinceId) {
                    fetch(`/getCity/${provinceId}?path=${urlPath}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(city => {
                                var div = document.createElement('div');
                                div.classList.add('form-check', 'my-2');

                                var checkbox = document.createElement('input');
                                checkbox.type = 'checkbox';
                                checkbox.classList.add('filter-checkbox',
                                    'city_filter'); // Apply custom checkbox class
                                checkbox.id = 'city_' + city.id;
                                checkbox.value = city.id;
                                checkbox.name = 'city[]';

                                var label = document.createElement('label');
                                label.classList.add('form-check-label', 'ms-3');
                                label.htmlFor = 'city_' + city.id;
                                label.textContent = city.name + ' (' + (city.count || 0) + ')';

                                div.appendChild(checkbox);
                                div.appendChild(label);
                                $('.citylabel').removeClass('d-none');
                                cityWrapper.appendChild(div);
                            });
                            fetchFilteredResults();
                        })
                        .catch(error => console.error('Error fetching cities:', error));
                } else {
                    $('.citylabel').addClass('d-none');
                }
            });

            // to get models based on selected make
            $('#make_filter').change(function(e) {
                var makeId = this.value;
                var modelWrapper = document.getElementById('model_filter_wrapper');
                var modelLabel = $('.model-label'); // Target the label

                // Clear the current model options
                modelWrapper.innerHTML = '';
                modelLabel.addClass('d-none'); // Hide label initially
                var urlPath = encodeURIComponent(window.location.pathname);
                // console.log(urlPath);
                // Fetch models based on selected make
                if (makeId) {
                    fetch(`/getmodel/${makeId}?path=${urlPath}`)
                        .then(response => response.json())
                        .then(data => {
                            //console.log(data);
                            if (data.length > 0) {
                                modelLabel.removeClass('d-none'); // Show label if models exist
                            }

                            data.forEach(model => {
                                var div = document.createElement('div');
                                div.classList.add('form-check', 'my-2');

                                var checkbox = document.createElement('input');
                                checkbox.type = 'checkbox';
                                checkbox.classList.add('filter-checkbox',
                                    'model-filter'); // Apply custom checkbox styling
                                checkbox.id = 'model_' + model.id;
                                checkbox.value = model.id;
                                checkbox.name = 'model[]';

                                var label = document.createElement('label');
                                label.classList.add('form-check-label', 'ms-3');
                                label.htmlFor = 'model_' + model.id;
                                label.textContent = model.name + ' (' + (model.count || 0) + ')';

                                div.appendChild(checkbox);
                                div.appendChild(label);
                                $('.modellabel').removeClass('d-none');
                                modelWrapper.appendChild(div);
                            });
                            fetchFilteredResults();
                        })
                        .catch(error => console.error('Error fetching models:', error));
                } else {
                    $('.modellabel').addClass('d-none');
                }
            });
        </script>

        {{-- filters script  --}}
        <script>
            $(document).ready(function() {
                $('#minRange').on('input', function() {
                    let minVal = parseInt($(this).val());
                    let maxVal = parseInt($('#maxRange').val());

                    if (minVal >= maxVal) {
                        $(this).val(maxVal - 1); // Keep minRange below maxRange
                    }
                });

                $('#maxRange').on('input', function() {
                    let minVal = parseInt($('#minRange').val());
                    let maxVal = parseInt($(this).val());

                    if (maxVal <= minVal) {
                        $(this).val(minVal + 1); // Keep maxRange above minRange
                    }
                });
            });
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

                function updateProgress() {
                    let minValue = parseInt(minRange.value);
                    let maxValue = parseInt(maxRange.value);
                    let totalRange = 60000000;

                    let minPercent = (minValue / totalRange) * 100;
                    let maxPercent = (maxValue / totalRange) * 100;

                    progressBar.style.left = minPercent + "%";
                    progressBar.style.width = (maxPercent - minPercent) + "%";
                }

                function updateRange() {
                    let minValue = Number(minRange.value) || 0;
                    let maxValue = Number(maxRange.value) || 60000000;

                    minPrice.value = minValue;
                    maxPrice.value = maxValue;

                    updateProgress();
                    fetchFilteredResults();
                }

                function updateInputs() {
                    let minValue = Number(minPrice.value) || 0;
                    let maxValue = Number(maxPrice.value) || 60000000;

                    if (minValue > 60000000) minValue = 60000000;
                    if (minValue < 0) minValue = 0;
                    if (maxValue > 60000000) maxValue = 60000000;
                    if (maxValue < minValue) maxValue = minValue;

                    minPrice.value = minValue;
                    maxPrice.value = maxValue;
                    minRange.value = minValue;
                    maxRange.value = maxValue;

                    updateProgress();
                    fetchFilteredResults();
                }

                minRange.addEventListener("input", updateRange);
                maxRange.addEventListener("input", updateRange);
                minPrice.addEventListener("input", updateInputs);
                maxPrice.addEventListener("input", updateInputs);

                updateProgress();

                $(document).on('change', '.form-select, .price_class, .filter-checkbox, .transmission_filter, \
                            #engine_capacity_filter, #from-year-filter, #to-year-filter, \
                            #mileage_from, #mileage_to, #sortbyorder, .door_count_filter, .assembly_filter, \
                            #featureAd_filter, input[name="userType"], input[name="model"], input[name="city"]', function() {
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
                $(document).on("click", ".custom-page-link", function(e) {
                    e.preventDefault(); // Prevent default page reload

                    let page = $(this).data("page"); // Get the clicked page number
                    let url = $(this).attr("href"); // Keep the original URL for SEO

                    if (!page) return; // Exit if no page number

                    $.ajax({
                        url: url, // Use Laravel-generated pagination URL
                        type: "GET",
                        beforeSend: function() {
                            $("#post-container").css("opacity",
                            "0.5"); // Add fade effect while loading
                        },
                        success: function(response) {
                            // Update posts and pagination
                            $("#post-container").html($(response).find("#post-container").html());
                            $("#custom-pagination-container").html($(response).find(
                                "#custom-pagination-container").html());

                            // Reset opacity
                            $("#post-container").css("opacity", "1");

                            // Update active state
                            $(".custom-page-link").removeClass("custom-active").css(
                                "background-color", "#444"); // Reset all
                            $('.custom-page-link[data-page="' + page + '"]').addClass(
                                "custom-active").css("background-color",
                            "#FD5631"); // Highlight active
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            });
        </script>
    @endsection
