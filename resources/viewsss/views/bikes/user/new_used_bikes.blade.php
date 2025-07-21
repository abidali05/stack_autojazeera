@extends('layout.website_layout.bikes.bike_main')
@section('content')
    <style>
        body {
            font-family: 'Maven Pro', sans-serif !important;
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

        .range-wrapper {
            width: 100%;
            max-width: 400px;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }

        .range-label {
            display: block;
            font-size: 16px;

            margin-bottom: 10px;
        }

        .slider-track {
            position: relative;
            height: 6px;
            background: #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .range-progress {
            position: absolute;
            height: 6px;
            background: #281F48;
            border-radius: 5px;
        }

        .range-slider {
            position: absolute;
            width: 100%;
            -webkit-appearance: none;
            appearance: none;
            background: transparent;
            pointer-events: none;
            top: -5px;
        }

        .range-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            background: #281F48;
            border-radius: 50%;
            cursor: pointer;
            pointer-events: auto;
        }

        .range-inputs {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .price-input {
            width: 45%;
            padding: 5px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
        }

        .range-divider {
            font-size: 18px;
            color: #999;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .slider-container {
            position: relative;
            width: 100%;
            height: 6px;
            background: #ddd;
            border-radius: 3px;
            margin-top: 10px;
        }

        .range-track {
            position: absolute;
            width: 100%;
            height: 6px;
            background: #e0e0e0;
            border-radius: 3px;
        }

        .progress-bar {
            position: absolute;
            height: 6px;
            background: #281F48;
            /* Updated Color */
            border-radius: 3px;
        }

        .slider {
            position: absolute;
            width: 100%;
            top: -6px;
            appearance: none;
            background: none;
            pointer-events: auto;
        }

        .slider::-webkit-slider-thumb {
            appearance: none;
            width: 15px;
            height: 15px;
            background: #281F48;
            border-radius: 50%;
            cursor: pointer;
            position: relative;
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

        .img-bg-3 {

            overflow: hidden;
            height: 244px;
            background-repeat: no-repeat;
            background-position: start;
            opacity: 0px;
            border-radius: 20px 0px 0px 20px;

        }

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

        h4 {
            color: #DD1F1A;
            font-weight: 600;
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
            color: #281F48;
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
            border-color: #86b7fe;
            outline: 0;
            box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
        }

        .select2-container--default .select2-selection--single {
            padding: 4px 13px;
            border: none;
            border-radius: 5px;
            height: 39px;
        }

        .select2-container--default .select2-selection--single {
            background-color: #282435;
            border: none;
            border-radius: 4px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            display: none;
        }

        .select2-container--default .select2-results__option {
            padding: 10px 20px;
            background: #282435;
            border: none;
        }

        .select2-search--dropdown {
            display: block;
            padding: 4px;
            /* background: red; */
            background: #282435;
        }



        .select2-container--default .select2-results>.select2-results__options {
            max-height: 200px;
            overflow-y: auto;
            scrollbar-color: #FD5631 #282435;
            scrollbar-width: thin;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: white;
        }

        .divheight {
            overflow-y: auto;
            height: 200px;
            scrollbar-color: #281F48 white;
            scrollbar-width: thin;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: white;
            line-height: 28px;
        }

        .select2-dropdown {

            border: none;

        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #FD5631 !important;
            color: white !important;
            /* Change text color for better contrast */
        }

        .form-select {
            max-width: 100%;
            text-align: start;
        }
    </style>


    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-3">
                <div class="sidebar-filter">

                    <!-- Condition Filter -->

                    <div class="search-container mb-3">
                        <button type="submit"
                            style="color:#281F48;font-weight:900 !important ; border:1px solid #281F48; padding:5px; border-radius:5px"
                            onclick="window.location.reload()">Clear
                            Filters</button>
                        </form>
                        <h6 class="form-label m-0" style="color:#281F48">Condition</h6>
                    </div>
                    <div class="">
                        <div class="my-3" style="display: flex; gap: 10px; align-items: center ;">
                            <div class="{{ request()->name == 'new' ? 'd-none' : '' }}">
                                <input type="checkbox" class="filter-checkbox condition_filter" name="condition"
                                    data-filter="condition" value="used" id="usedCars_check">
                                <label for="usedCars" style="font-size:16px ;color: #281F48;">Used Bikes</label>
                            </div>
                            <div class="{{ request()->name == 'used' ? 'd-none' : '' }}">
                                <input type="checkbox" class="filter-checkbox condition_filter" name="condition"
                                    data-filter="condition" value="new" id="newCars_check">
                                <label for="newCars" style="font-size:16px ; color: #281F48;">New Bikes</label>
                            </div>
                        </div>
                    </div>

                    <!-- Year Filter -->
                    <!-- Year Filter -->
                    <div class="my-2">
                        <label class="form-label  m-0"><strong>Year</strong></label>

                        <div class="row p-1">
                            <div style="position: relative;">
                                <div class="col-12 ">
                                    <div class="row">
                                        <div class="col-6 p-0 pe-1 my-3">
                                            <div class="select-wrapper">
                                                <select class="form-select from-year-filter" id="from-year-filter"
                                                    aria-label="Default select example">
                                                    <option value="" selected>From</option>
                                                    @for ($year = 1960; $year <= date('Y'); $year++)
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
                                <i class="bi bi-dash" style="color: #BFBEC3;position: absolute;top: 35% ;right: 47%;  "></i>
                            </div>




                        </div>
                        <div class="select-wrapper">
                            <select class="form-select select-search assembly-filter filter-style assembly_filter"
                                style="width:100% !important" id="assembly">
                                <option value="" disabled selected>Select Assembly</option>
                                <option value="local" {{ request()->assembly == 'local' ? 'selected' : '' }}>Local</option>
                                <option value="imported" {{ request()->assembly == 'imported' ? 'selected' : '' }}>Imported
                                </option>
                            </select>
                            <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                        </div>
                    </div>
                    <!-- Make & Model Filters -->
                    <div class="my-2">
                        <label class="form-label mb-2 mt-2"><strong>Make & Model</strong></label>
                        <div class="select-wrapper mt-2">
                            <select id="make_filter" class="form-select select-search mb-2 make-filter filter-style"
                                style="width:100% !important" name="make">
                                <option value="">Make</option>
                                @foreach ($makes as $make)
                                    <option value="{{ $make->id }}"
                                        {{ request()->type ? (request()->type == 'make' && request()->id == $make->id ? 'selected' : '') : (request()->make == $make->id ? 'selected' : '') }}>
                                        {{ $make->name }}</option>
                                @endforeach
                            </select> <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                        </div>
                        <div class="select-wrapper mt-2">
                            <select id="model_filter" class="form-select select-search mb-2 make-filter filter-style"
                                name="Model">
                                <option value="">Select Make First</option>
                            </select> <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                        </div>




                    </div>
                    <!-- Province & City Filters -->
                    <div class="my-2">
                        <label class="form-label mb-3 mt-2"><strong>Province</strong></label>
                        <div class="select-wrapper">
                            <select class="form-select select-search assembly-filter filter-style assembly_filter"
                                style="width:100% !important" id="province">
                                <option value="" disabled selected>Province</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}"
                                        {{ request()->province == $province->id ? 'selected' : '' }}>{{ $province->name }}

                                    </option>
                                @endforeach
                            </select>
                            <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                        </div>
                    </div>


                    <div class="my-2">
                        <label class="form-label mb-3 mt-2 citylabel "><strong>City</strong></label>
                        <div class="select-wrapper">
                            <select class="form-select select-search assembly-filter filter-style assembly_filter"
                                style="width:100% !important" id="city">
                                <option value="" disabled selected>Select Province First</option>
                            </select>
                            <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                        </div>
                    </div>
                    <div class="my-2">
                        <label class="form-label mb-3 mt-2 citylabel "><strong>Fuel Type</strong></label>
                        <div class="select-wrapper">
                            <select class="form-select select-search assembly-filter filter-style assembly_filter"
                                style="width:100% !important" id="fuel_type">
                                <option value="" disabled selected>Fuel Type</option>
                                <option value="Gasoline" {{ request()->fuel_type == 'Gasoline' ? 'selected' : '' }}>
                                    Gasoline</option>
                                <option value="Diesel" {{ request()->fuel_type == 'Diesel' ? 'selected' : '' }}>Diesel
                                </option>
                                <option value="Electric" {{ request()->fuel_type == 'Electric' ? 'selected' : '' }}>
                                    Electric</option>
                                <option value="Petrol" {{ request()->fuel_type == 'Petrol' ? 'selected' : '' }}>Petrol
                                </option>
                                <option value="LPG" {{ request()->fuel_type == 'LPG' ? 'selected' : '' }}>LPG</option>
                                <option value="CNG" {{ request()->fuel_type == 'CNG' ? 'selected' : '' }}>CNG</option>
                                <option value="Hybrid" {{ request()->fuel_type == 'Hybrid' ? 'selected' : '' }}>Hybrid
                                </option>
                            </select>
                            <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                        </div>
                    </div>
                    <div class="range-wrapper m-0">
                        <label class="range-label citylabel mb-3 mt-3 form-label"><strong>Price</strong></label>

                        <div class="slider-track mb-3">
                            <div id="rangeProgress" class="range-progress"></div>

                            <!-- Sliders -->
                            <input type="range" id="priceMin" min="0" max="500000" value="0"
                                class="range-slider">
                            <input type="range" id="priceMax" min="0" max="500000" value="500000"
                                class="range-slider ">
                        </div>

                        <div class="range-inputs">
                            <input type="" id="minPrice" class="price-input m-0 price_class" value="0">
                            <span class="range-divider">—</span>
                            <input type="" id="maxPrice" class="price-input m-0  price_class" value="500000">
                        </div>
                    </div>




                    <!-- Engine Capacity, Mileage, and Price Range Filters -->
                    <div class="my-3">
                        <label class="form-label mb-2 mt-1"><strong>Fuel Capacity</strong></label>
                        <div class="select-wrapper my-2">

                            <select class="form-select  engine-capacity-filter select-search filter-style"
                                id="engine_capacity_filter">
                                <option value="">Select Fuel Capacity</option>
                                <option value="3" {{ request()->fuel_type == '3' ? 'selected' : '' }}>3L</option>
                                <option value="4" {{ request()->fuel_type == '4' ? 'selected' : '' }}>4L</option>
                                <option value="5" {{ request()->fuel_type == '5' ? 'selected' : '' }}>5L</option>
                                <option value="6" {{ request()->fuel_type == '6' ? 'selected' : '' }}>6L</option>
                                <option value="7" {{ request()->fuel_type == '7' ? 'selected' : '' }}>7L</option>
                                <option value="8" {{ request()->fuel_type == '8' ? 'selected' : '' }}>8L</option>
                                <option value="9" {{ request()->fuel_type == '9' ? 'selected' : '' }}>9L</option>
                                <option value="10" {{ request()->fuel_type == '10' ? 'selected' : '' }}>10L</option>
                                <option value="11" {{ request()->fuel_type == '11' ? 'selected' : '' }}>11L</option>
                                <option value="12" {{ request()->fuel_type == '12' ? 'selected' : '' }}>12L</option>
                                <option value="13" {{ request()->fuel_type == '13' ? 'selected' : '' }}>13L</option>
                                <option value="14" {{ request()->fuel_type == '14' ? 'selected' : '' }}>14L</option>
                                <option value="15" {{ request()->fuel_type == '15' ? 'selected' : '' }}>15L</option>
                                <option value="16" {{ request()->fuel_type == '16' ? 'selected' : '' }}>16L</option>
                                <option value="17" {{ request()->fuel_type == '17' ? 'selected' : '' }}>17L</option>
                                <option value="18" {{ request()->fuel_type == '18' ? 'selected' : '' }}>18L</option>
                                <option value="19" {{ request()->fuel_type == '19' ? 'selected' : '' }}>19L</option>
                                <option value="20" {{ request()->fuel_type == '20' ? 'selected' : '' }}>20L</option>

                            </select>
                            <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                        </div>


                    </div>
                    <div class="my-3">
                        <label class="form-label mb-1 mt-1"><strong>Mileage</strong></label>

                        <div class="row mt-3">
                            <div style="position: relative;">
                                <div class="col-12 px-2">
                                    <div class="row">
                                        <div class="col-6 p-0 pe-2">
                                            <input type="number" class="price_class" id="mileage_from" placeholder="0">
                                        </div>
                                        <div class="col-6 p-0 ps-2">
                                            <input type="number" class="price_class" id="mileage_to" placeholder="0">
                                        </div>
                                    </div>
                                </div>
                                <i class="bi bi-dash-lg"
                                    style="color: #BFBEC3;position: absolute;top: 23% ;right: 47%;  "></i>
                            </div>
                        </div>

                    </div>


                    <!-- Transmission Filter -->
                    <div class="my-3 d-none">
                        <label class="form-label mb-3 mt-2">Transmission</label>
                        <div class="d-flex align-items-center">
                            <input type="checkbox" class=" transmission-filter me-2 transmission_filter"
                                id="TransmissionAutomatic" value="Automatic">
                            <label for="TransmissionAutomatic" style="color: #281F48;"> Automatic</label>
                        </div>
                        <div class="d-flex align-items-center mt-2">
                            <input type="checkbox" id="TransmissionManual"
                                class="transmission-filter me-2 transmission_filter" value="Manual">
                            <label for="TransmissionManual" style="color: #281F48;">Manual</label>
                        </div>
                    </div>


                    <div>
                        <label class="form-label  mt-1"><strong>Body type</strong></label>
                        <div class="select-wrapper mt-1">
                            <select class="form-select seating-capacity-filter select-search formcontrol"
                                style="width:100% !important" style="background-color:#282435" placeholder="Seats"
                                id="seating_capacity_filter">
                                <option value="">Body type</option>
                                @foreach ($bodytypes as $body_type)
                                    <option value="{{ $body_type->id }}"
                                        {{ request()->type == 'bodytype' && request()->id == $body_type->id ? 'selected' : '' }}>
                                        {{ $body_type->name }}</option>
                                @endforeach
                            </select> <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                        </div>
                    </div>

                    <div class="my-3 ">
                        <label class="form-label mb-2 mt-1"><strong>Color</strong></label>
                        <div class="select-wrapper my-2">
                            <select class="form-select  engine-capacity-filter select-search filter-style" id="color">
                                <option value="">Select Color</option>
                                @foreach ($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                                @endforeach
                            </select>
                            <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                        </div>
                    </div>
                    <div class="my-3 ">
                        <label class="form-label mb-3"><strong>Ad Type</strong></label>
                        <div>
                            <input type="checkbox" class=" transmission-filter  featureAd_filter" id="is_featured"
                                name="is_featured">
                            <label for="featureAd_filter" style="color: #281F48;">Feature ads only </label>
                        </div>
                    </div>
                    <div class="my-3">
                        <label class="form-label mb-3"><strong>Seller Type</strong></label>
                        <div class="">
                            <div class="d-flex align-items-center">
                                <input type="checkbox" class="filter-checkbox" name="userType"
                                    data-usertype="car_dealer" value="car_dealer" id="dealer_check">
                                <label for="" class="ms-2"
                                    style="font-size:16px ;color: #281F48;">Dealer</label>
                            </div>
                            <div class="d-flex align-items-center ">
                                <input type="checkbox" class="filter-checkbox" name="userType"
                                    data-usertype="private_dealer" value="private_dealer" id="private_seller_check">
                                <label for="" class="ms-2" style="font-size:16px ;color: #281F48;">Private
                                    Seller</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row gy-3">
                    <div class="col-12">
                        <h1 class="m-0"><strong>Available Bikes</strong> <span id="postscount">
                                ({{ count($posts) }})</span> </h1>
                    </div>
                    <div class="mt-2  row">
                        <div class="col-6 col-md-3 ">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="p-0 col-5 pe-2 d-flex justify-content-end"> <img
                                                src="https://staging.autojazeera.pk/web/images/sortimg.png" class=""
                                                style="    height: 15px;
                                                        width: 15px;
                                                        
                                                        margin-right: 6px;
                                                        margin-top: 6px;">
                                            <p class="pt-1 text-end"
                                                style="font-size:12px;font-weight:500 ; color: #281F48;">Sort by:</p>
                                        </div>
                                        <div class="p-0 col-5">
                                            <select class="p-1 formcontrol"
                                                style="  line-height: 12.68px !important; font-size:12px !important; border-radius: 5px;"
                                                id="sortbyorder">
                                                <option value="" selected="">All</option>
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
                    @if (count($posts) < 1)
                        <div class="p-3 col-12" style="border:1px solid #281F48;border-radius:9px;">
                            <div class="row">
                                <div class="col-3 text-center">
                                    <img src="{{ asset('web/images/noinputs.svg') }}" alt="" class="img-fluid"
                                        srcset="">
                                </div>
                                <div class="col-9 text-start">
                                    <h1 style="color:#281F48"><strong>Sorry</strong></h1>
                                    <p style="color:#281F48">No matches found for your search. Try adjusting your filters
                                        or expanding your criteria
                                        to
                                        explore available bikes!</p>

                                </div>
                            </div>
                        </div>
                    @endif
                    <div id="bike-listings">
                        <div class="">
                            @if ($posts->hasPages())
                                <nav class="d-flex justify-content-end align-items-center">
                                    <!-- Page Info -->


                                    <!-- Pagination -->
                                    <ul class="pagination"
                                        style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                                        @if ($posts->onFirstPage())
                                            <li style="display: inline-block;">
                                                <span
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&laquo;</span>
                                            </li>
                                        @else
                                            @if (request()->isMethod('post'))
                                                <li style="display: inline-block;">
                                                    <form method="POST" action="{{ url()->current() }}">
                                                        @csrf
                                                        <input type="hidden" name="page"
                                                            value="{{ $posts->currentPage() - 1 }}">
                                                        <button type="submit"
                                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #444; color: #fff; border: none;">&laquo;</button>
                                                    </form>
                                                </li>
                                            @else
                                                <li style="display: inline-block;">
                                                    <a href="{{ $posts->previousPageUrl() }}"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&laquo;</a>
                                                </li>
                                            @endif
                                        @endif

                                        @foreach ($posts->links()->elements as $element)
                                            @if (is_string($element))
                                                <li style="display: inline-block;">
                                                    <span
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">{{ $element }}</span>
                                                </li>
                                            @endif

                                            @if (is_array($element))
                                                @foreach ($element as $page => $url)
                                                    @if ($page == $posts->currentPage())
                                                        <li style="display: inline-block;">
                                                            <span
                                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #f56; color: #fff;">{{ $page }}</span>
                                                        </li>
                                                    @else
                                                        @if (request()->isMethod('post'))
                                                            <li style="display: inline-block;">
                                                                <form method="POST" action="{{ url()->current() }}">
                                                                    @csrf
                                                                    <input type="hidden" name="page"
                                                                        value="{{ $page }}">
                                                                    <button type="submit"
                                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #444; color: #fff; border: none;">{{ $page }}</button>
                                                                </form>
                                                            </li>
                                                        @else
                                                            <li style="display: inline-block;">
                                                                <a href="{{ $url }}"
                                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">{{ $page }}</a>
                                                            </li>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach

                                        @if ($posts->hasMorePages())
                                            @if (request()->isMethod('post'))
                                                <li style="display: inline-block;">
                                                    <form method="POST" action="{{ url()->current() }}">
                                                        @csrf
                                                        <input type="hidden" name="page"
                                                            value="{{ $posts->currentPage() + 1 }}">
                                                        <button type="submit"
                                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #444; color: #fff; border: none;">&raquo;</button>
                                                    </form>
                                                </li>
                                            @else
                                                <li style="display: inline-block;">
                                                    <a href="{{ $posts->nextPageUrl() }}"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&raquo;</a>
                                                </li>
                                            @endif
                                        @else
                                            <li style="display: inline-block;">
                                                <span
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&raquo;</span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            @endif
                            <div class="d-flex justify-content-end">
                                <span class="pt-md-3 pagination_count"
                                    style="font-size: 18px; color: #FD5631; font-weight:700 ">
                                    Showing {{ ($posts->currentPage() - 1) * $posts->perPage() + 1 }}
                                    to {{ min($posts->currentPage() * $posts->perPage(), $posts->total()) }}
                                    of {{ $posts->total() }} Results
                                </span>
                            </div>
                        </div>
                        @foreach ($posts as $post)
                            <div class="col-lg-12">
                                <div class="wishlist-card rounded" style=" border:1px solid #0000001F">
                                    <a href="{{ route('bikedetail', $post->id) }}"
                                        style="text-decoration: none; color: #ffffff;">
                                        <div class="row">
                                            <div class="col-lg-4 pe-0">
                                                <div class="img-bg-3" style="border-radius:10px 0px 0px 10px;">
                                                    <img src="{{ $post->media[0]->file_path ?? asset('web/bikes/images/logo.svg') }}"
                                                        class="img-adj-card" style="border-radius:10px 0px 0px 10px;">
                                                </div>
                                            </div>
                                            <div class="col-lg-8  my-auto">
                                                <div class="pe-lg-3 px-lg-0 pb-lg-0  p-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6>{{ $post->year }}</h6>
                                                        <span class="rounded px-3 text-capitalize"
                                                            style="background-color:{{ $post->condition == 'used' ? '#0EB617;' : '#4581F9;' }}">{{ $post->condition }}</span>
                                                    </div>
                                                    <h4>{{ $post->makename . ' ' . $post->modelname }}</h4>
                                                    <h5 style="color: #281F48;"><b>PKR
                                                            {{ number_format($post->price) }}</b>
                                                    </h5>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="mb-0"><i class="bi bi-geo-alt"></i>
                                                            {{ $post->location->cityname }}</h6>
                                                        <span style="color: #281F48;">Last Updated:
                                                            {{ \Carbon\Carbon::parse($post->updated_at)->format('F j, Y') }}
                                                        </span>
                                                    </div>
                                                    <hr style="border: none; height: 1px; background-color: #66666680;">

                                                    <div class="row pb-2">
                                                        <div class="col-4">
                                                            <div class="text-center py-2"
                                                                style="background-color:#F0F3F6; border-radius: 10px;">
                                                                <i style="color: #281F48;" class="bi bi-speedometer2"></i>
                                                                <h6>{{ (float) $post->mileage >= 1000 ? rtrim(number_format((float) $post->mileage / 1000, 1), '.0') . 'KM' : (float) $post->mileage }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="text-center py-2"
                                                                style="background-color:#F0F3F6; border-radius: 10px;">
                                                                <i style="color: #281F48;"
                                                                    class="bi bi-car-front-fill"></i>
                                                                <h6>{{ $post->transmission }}</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="text-center py-2"
                                                                style="background-color:#F0F3F6; border-radius: 10px;">
                                                                <i style="color: #281F48;"
                                                                    class="bi bi-fuel-pump-diesel"></i>
                                                                <h6>{{ $post->fuel_type }}</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>



                                </div>
                            </div>
                        @endforeach

                       <div class="">
            @if ($posts->hasPages())
                <nav class="d-flex justify-content-end align-items-center">
                    <!-- Page Info -->


                    <!-- Pagination -->
                    <ul class="pagination"
                        style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                        @if ($posts->onFirstPage())
                            <li style="display: inline-block;">
                                <span
                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&laquo;</span>
                            </li>
                        @else
                            @if (request()->isMethod('post'))
                                <li style="display: inline-block;">
                                    <form method="POST" action="{{ url()->current() }}">
                                        @csrf
                                        <input type="hidden" name="page" value="{{ $posts->currentPage() - 1 }}">
                                        <button type="submit"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #444; color: #fff; border: none;">&laquo;</button>
                                    </form>
                                </li>
                            @else
                                <li style="display: inline-block;">
                                    <a href="{{ $posts->previousPageUrl() }}"
                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&laquo;</a>
                                </li>
                            @endif
                        @endif

                        @foreach ($posts->links()->elements as $element)
                            @if (is_string($element))
                                <li style="display: inline-block;">
                                    <span
                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">{{ $element }}</span>
                                </li>
                            @endif

                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $posts->currentPage())
                                        <li style="display: inline-block;">
                                            <span
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #f56; color: #fff;">{{ $page }}</span>
                                        </li>
                                    @else
                                        @if (request()->isMethod('post'))
                                            <li style="display: inline-block;">
                                                <form method="POST" action="{{ url()->current() }}">
                                                    @csrf
                                                    <input type="hidden" name="page" value="{{ $page }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #444; color: #fff; border: none;">{{ $page }}</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $url }}"
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        @if ($posts->hasMorePages())
                            @if (request()->isMethod('post'))
                                <li style="display: inline-block;">
                                    <form method="POST" action="{{ url()->current() }}">
                                        @csrf
                                        <input type="hidden" name="page" value="{{ $posts->currentPage() + 1 }}">
                                        <button type="submit"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #444; color: #fff; border: none;">&raquo;</button>
                                    </form>
                                </li>
                            @else
                                <li style="display: inline-block;">
                                    <a href="{{ $posts->nextPageUrl() }}"
                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&raquo;</a>
                                </li>
                            @endif
                        @else
                            <li style="display: inline-block;">
                                <span
                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&raquo;</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            @endif
            <div class="d-flex justify-content-end">
                <span class="pt-md-3 pagination_count" style="font-size: 18px; color: #FD5631; font-weight:700 ">
                    Showing {{ ($posts->currentPage() - 1) * $posts->perPage() + 1 }}
                    to {{ min($posts->currentPage() * $posts->perPage(), $posts->total()) }}
                    of {{ $posts->total() }} Results
                </span>
            </div>
        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const priceMin = document.getElementById("priceMin");
            const priceMax = document.getElementById("priceMax");
            const minPrice = document.getElementById("minPrice");
            const maxPrice = document.getElementById("maxPrice");
            const rangeProgress = document.getElementById("rangeProgress");

            const minValue = parseInt(priceMin.min);
            const maxValue = parseInt(priceMax.max);

            function updateInputs() {
                minPrice.value = priceMin.value;
                maxPrice.value = priceMax.value;
                updateProgress();
            }

            function updateProgress() {
                const minPercent = ((priceMin.value - minValue) / (maxValue - minValue)) * 100;
                const maxPercent = ((priceMax.value - minValue) / (maxValue - minValue)) * 100;
                rangeProgress.style.left = `${minPercent}%`;
                rangeProgress.style.width = `${maxPercent - minPercent}%`;
            }

            priceMin.addEventListener("input", function() {
                if (parseInt(priceMin.value) >= parseInt(priceMax.value)) {
                    priceMin.value = priceMax.value - 1;
                }
                updateInputs();
            });

            priceMax.addEventListener("input", function() {
                if (parseInt(priceMax.value) <= parseInt(priceMin.value)) {
                    priceMax.value = parseInt(priceMin.value) + 1;
                }
                updateInputs();
            });

            minPrice.addEventListener("input", function() {
                let value = parseInt(minPrice.value) || minValue;
                if (value < minValue) value = minValue;
                if (value >= parseInt(priceMax.value)) value = parseInt(priceMax.value) - 1;
                priceMin.value = value;
                updateInputs();
            });

            maxPrice.addEventListener("input", function() {
                let value = parseInt(maxPrice.value) || maxValue;
                if (value > maxValue) value = maxValue;
                if (value <= parseInt(priceMin.value)) value = parseInt(priceMin.value) + 1;
                priceMax.value = value;
                updateInputs();
            });

            updateInputs();
        });
    </script>

    <script>
        document.getElementById('make_filter').addEventListener('change', function() {
            var makeId = this.value;
            //alert(makeId);
            var modelSelect = document.getElementById('model_filter');

            // Clear the current city options
            modelSelect.innerHTML = '<option value="" selected>Select Model</option>';

            // Fetch cities based on selected province
            if (makeId) {
                fetch(`/getBikeModels/${makeId}`)
                    .then(response => response.json())
                    .then(data => {
                        //console.log(data);
                        data.forEach(model => {
                            var option = document.createElement('option');
                            option.value = model.id;
                            option.textContent = model.name;
                            modelSelect.appendChild(option);

                        });

                    })
                    .catch(error => console.error('Error fetching models:', error));
            }
        });
    </script>

    <script>
        document.getElementById('province').addEventListener('change', function() {
            var provinceId = this.value;

            var citySelect = document.getElementById('city');

            // Clear the current city options
            citySelect.innerHTML = '<option value="" selected>Select City</option>';

            // Fetch cities based on selected province
            if (provinceId) {
                fetch(`/getCities/${provinceId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(city => {
                            var option = document.createElement('option');
                            option.value = city.id;
                            option.textContent = city.name;
                            citySelect.appendChild(option);

                        });

                    })
                    .catch(error => console.error('Error fetching cities:', error));
            }
        });
    </script>

    {{-- filters code start --}}
    <script>
        function fetchFilteredBikes(page = 1) {
            const data = {
                condition: [],
                make: $('#make_filter').val(),
                model: $('#model_filter').val(),
                min_price: $('#priceMin').val(),
                max_price: $('#priceMax').val(),
                fuel_capacity: $('#engine_capacity_filter').val(),
                year_from: $('#from-year-filter').val(),
                year_to: $('#to-year-filter').val(),
                mileage_from: $('#mileage_from').val(),
                mileage_to: $('#mileage_to').val(),
                body_type: $('#seating_capacity_filter').val(),
                sort_by: $('#sortbyorder').val(),
                assembly: $('#assembly').val(),
                province: $('#province').val(),
                city: $('#city').val(),
                fuel_type: $('#fuel_type').val(),
                color: $('#color').val(),
                is_featured: $('#is_featured').is(':checked') ? 'on' : 'off',
                userType: $('input[name="userType"]:checked').map(function() {
                    return this.value;
                }).get(),
                page: page,
                _token: "{{ csrf_token() }}"
            };

            // Get selected conditions
            $('.condition_filter:checked').each(function() {
                data.condition.push($(this).val());
            });

            $.ajax({
                url: "{{ route('bikes.filter') }}",
                method: "POST",
                data: data,
                success: function(response) {
                    $('#bike-listings').html(response.html);
                    $('#postscount').text('(' + response.count + ')');
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseText);
                }
            });
        }

        // Trigger filters
        $(document).on('change',
            '.filter-checkbox, .form-select, #minPrice,#maxPrice, #priceMin, #priceMax, #mileage_from, #mileage_to, #is_featured, #private_seller_check, #dealer_check, #sortbyorder',
            function() {
                fetchFilteredBikes();
            });

        // Pagination click
        $(document).on('click', '.page-link', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            if (page) {
                fetchFilteredBikes(page);
            }
        });
    </script>

    {{-- filters code end --}}

@endsection
