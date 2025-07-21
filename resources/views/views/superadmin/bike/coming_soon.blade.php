@extends('layout.panel_layout.main')
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
            background-color: #FD5631;
            top: 50%;
            transform: translateY(0%);
            border-radius: 5px;
            z-index: 2;
        }

        .slider {
            position: absolute;
            width: 100%;
            pointer-events: none;
            background: #282435;
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
            border: 2px solid #FD5631;
            background-color: #1F1B2D;
            border-radius: 4px;
            /* Optional: rounded corners */
            cursor: pointer;
            display: inline-block;
            position: relative;
        }

        /* Style for the checkbox when checked */
        .filter-checkbox:checked {
            background-color: #FD5631;
            border-color: #FD5631;
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
            border: 2px solid #FD5631;
            background-color: #1F1B2D;
            border-radius: 4px;
            /* Optional: rounded corners */
            cursor: pointer;
            display: inline-block;
            position: relative;
        }

        /* Styles for when the checkbox is checked */
        .transmission-filter:checked {
            background-color: #FD5631;
            border-color: #FD5631;
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
            color: #FFFFFF;
            background-color: #282435 !important;
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
            background-color: #282435;
            color: white;
            border: none;
            padding: 7px;
            font-size: 16px;
            border-radius: 5px;
            width: 100%;
        }

        .price_class::placeholder {
            color: white;
        }

        .price_class:focus {
            color: none;
            background-color: #282435 !important;
            border-color: #86b7fe;
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
            scrollbar-color: #FD5631 #1F1B2D;
            scrollbar-width: thin;
        }	.select2-container--default .select2-selection--single .select2-selection__rendered {
color: white;
line-height: 28px;
}.select2-dropdown {

border:none; 

}.select2-container--default .select2-results__option--highlighted[aria-selected] {
background-color: #FD5631 !important;
color: white !important; /* Change text color for better contrast */
}
    </style>
<div class="container mt-5 mb-5">
     <div class="row">
            <div class="col-lg-3">
                <div class="sidebar-filter">

                    <!-- Condition Filter -->
                    <div class="d-flex justify-content-between">
                    </div>              
                    <div class="search-container mb-3">
                        <button type="submit" style="color:#FD5631;font-weight:900 !important ; border:1px solid #FD5631; padding:5px; border-radius:5px">Clear Filters</button>
                 
                        <h6 class="form-label m-0" style="color:#FD5631"><strong>Condition</strong></h6>
                    </div>
                    <div class="">
                        <div class="my-3" style="display: flex; gap: 10px; align-items: center ;">
                            <div class="{{ request()->name == 'new' ? 'd-none' : '' }}">
                                <input type="checkbox" class="filter-checkbox condition_filter" name="condition"
                                    data-filter="condition" value="used" id="usedCars_check"
                                  >
                                <label for="usedCars" style="font-size:16px">Used Bikes</label>
                            </div>
                            <div class="{{ request()->name == 'used' ? 'd-none' : '' }}">
                                <input type="checkbox" class="filter-checkbox condition_filter" name="condition"
                                    data-filter="condition" value="new" id="newCars_check"
                                   >
                                <label for="newCars" style="font-size:16px">New Bikes</label>
                            </div>
                        </div>
                    </div>

                    <!-- Year Filter -->
                    <!-- Year Filter -->
                    <div class="my-2">
						<label class="form-label mb-2"><strong>Year</strong></label>
                   
                        <div class="row p-1">
                            <div style="position: relative;">
                                <div class="col-12 ">
                                    <div class="row">
                                        <div class="col-6 p-0 pe-1 my-3">
                                            <div class="select-wrapper">
                                                <select class="form-select from-year-filter" id="from-year-filter"
                                                    aria-label="Default select example">
                                                    <option value="" selected>From</option>
                                                    <option value="">2002</option>
                                                        <option value="">2002</option>
                                                        <option value="">2002</option>
                                                </select>
                                                <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                                            </div>
                                        </div>
                                        <div class="col-6 p-0 ps-1 my-3">
                                            <div class="select-wrapper">
                                                <select class="form-select to-year-filter" id="to-year-filter"
                                                    aria-label="Default select example">
                                                    <option value="" selected>To</option>
                                                    <option value="">2002</option>
                                                        <option value="">2002</option>
                                                        <option value="">2002</option>
                                                </select>
                                                <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <i class="bi bi-dash" style="color: #BFBEC3;position: absolute;top: 35% ;right: 47%;  "></i>
                            </div>




                        </div>
                    </div>
                    <!-- Make & Model Filters -->
                    <div class="my-2">
                        <label class="form-label mb-4"><strong>Make</strong></label>
                        <div class="select-wrapper mt-2">
                            <select id="make_filter" class="form-select select-search mb-2 make-filter filter-style"
                                style="width:100% !important" name="make">
                                <option value="" selected>lamborgini</option>
                                <option value="" selected>audi</option>
                                <option value="" selected>suzuki</option>
                            </select> <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                        </div>

                        <div class="select-wrapper mt-3">
                            <label class="form-label modellabel "> <strong>Model</strong></label>
                            <div id="model_filter_wrapper"
                                style="max-height: 200px !important ;     overflow-y: scroll;
                                    scrollbar-color: #FD5631 #1F1B2D;
                                    scrollbar-width: thin;">
                            </div>
                        </div>

               

                    </div>
                    <!-- Province & City Filters -->
                    <div class="my-2">
                        <label class="form-label mb-3"><strong>Province</strong></label>
                        <div class="select-wrapper mt-2">
                            <select class="form-select mb-2  select-search filter-style " style="width:100% !important"
                                id="province_filter">
                                <option value="" disabled selected>Select Province</option>
                                <option value="" disabled selected>kpk</option>
                                <option value="" disabled selected>punjab</option>
                            </select><i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                        </div>
                    </div>
                  

                    <div class="my-2">
                        <label class="form-label mb-3 citylabel "><strong>City</strong></label>
                        <div id="city_filter_wrapper"
                            style="max-height: 200px !important ;     overflow-y: scroll;
                            scrollbar-color: #FD5631 #1F1B2D;
                            scrollbar-width: thin;">
                        
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
                            <input type="range" id="minRange" min="0" max="60000000" value="300000"
                                class="slider" readonly>
                            <input type="range" id="maxRange" min="0" max="60000000" value="60000000"
                                class="slider" readonly>
                        </div>

                        <div class="row pt-5">
                            <div style="position: relative;">
                                <div class="col-12 px-2">
                                    <div class="row">
                                        <div class="col-6 p-0 pe-2">
                                            <input type="number" id="minPrice_filter" class="price_class"
                                                value="0">
                                        </div>
                                        <div class="col-6 p-0 ps-2">
                                            <input type="number" id="maxPrice_filter" class="price_class"
                                                value="60000000">
                                        </div>
                                    </div>
                                </div>
                                <i class="bi bi-dash-lg"
                                    style="color: #BFBEC3;position: absolute;top: 23%;right: 47%;"></i>
                            </div>
                        </div>

                    </div>



                    <!-- Engine Capacity, Mileage, and Price Range Filters -->
                    <div class="my-3">
                        <label class="form-label mb-4 mt-2"><strong>Engine Capacity (CC)</strong></label>
                        <div class="select-wrapper my-2">
                        
                            <select class="form-select  engine-capacity-filter select-search filter-style"
                                id="engine_capacity_filter">
                                <option value="">Select Engine Capacity</option>
                                <option value="1.6L">1.6L</option>
                                <option value="2.0L">2.0L</option>
                                <option value="3.0L+">3.0L+</option>
                              
                            </select>
                            <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                        </div>


                    </div>
                    <div class="my-3">
                        <label class="form-label mb-2 mt-2"><strong>Mileage</strong></label>
                       
                        <div class="row mt-3">
                            <div style="position: relative;">
                                <div class="col-12 px-2">
                                    <div class="row">
                                        <div class="col-6 p-0 pe-2">
                                            <input type="email" class="price_class" id="mileage_from" placeholder="0">
                                        </div>
                                        <div class="col-6 p-0 ps-2">
                                            <input type="email" class="price_class" style=" background-color: #282435;"
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
                        <label class="form-label mb-3 mt-2"><strong>Body type</strong></label>
                      
                            <div class="my-2">
                                <input type="checkbox" class="filter-checkbox me-2 body_type_filter"
                                    value="" id="body_type_filter" >
                                <label for="usedCars" style="font-size:16px; color: white;">compact</label>
                            </div>
                            <div class="my-2">
                                <input type="checkbox" class="filter-checkbox me-2 body_type_filter"
                                    value="" id="body_type_filter" >
                                <label for="usedCars" style="font-size:16px; color: white;">Sedan</label>
                            </div> <div class="my-2">
                                <input type="checkbox" class="filter-checkbox me-2 body_type_filter"
                                    value="" id="body_type_filter" >
                                <label for="usedCars" style="font-size:16px; color: white;">SUV</label>
                            </div> <div class="my-2">
                                <input type="checkbox" class="filter-checkbox me-2 body_type_filter"
                                    value="" id="body_type_filter" >
                                <label for="usedCars" style="font-size:16px; color: white;">Wagon</label>
                            </div> <div class="my-2">
                                <input type="checkbox" class="filter-checkbox me-2 body_type_filter"
                                    value="" id="body_type_filter" >
                                <label for="usedCars" style="font-size:16px; color: white;">Crossover</label>
                            </div> <div class="my-2">
                                <input type="checkbox" class="filter-checkbox me-2 body_type_filter"
                                    value="" id="body_type_filter" >
                                <label for="usedCars" style="font-size:16px; color: white;">Coupe</label>
                            </div> <div class="my-2">
                                <input type="checkbox" class="filter-checkbox me-2 body_type_filter"
                                    value="" id="body_type_filter" >
                                <label for="usedCars" style="font-size:16px; color: white;">Pickup</label>
                            </div>



                    </div>
                    <!-- Fuel Type Filter -->
                    <div class="my-2">
                        <label class="form-label mb-2 "><strong>Fuel Type</strong></label>
                        <div class="divheight">
                          
                            <div class="my-2">
                                <input type="checkbox" class="filter-checkbox me-2 fuel_type_filter" value="Diesel"
                                    id="DieselfuelType">
                                <label for="DieselfuelType" style="font-size:16px; color: white;">Diesel</label>
                            </div>
                            <div class="my-2">
                                <input type="checkbox" class="filter-checkbox me-2 fuel_type_filter"
                                    id="ElectricfuelType" value="Electric">
                                <label for="ElectricfuelType" style="font-size:16px; color: white;">Electric</label>
                            </div>
                            <div class="my-2">
                                <input type="checkbox" class="filter-checkbox me-2 fuel_type_filter"
                                    id="GasolinefuelType" value="Gasoline">
                                <label for="GasolinefuelType" style="font-size:16px; color: white;">Gasoline</label>
                            </div>
                            <div class="my-2">
                                <input type="checkbox" class="filter-checkbox me-2 fuel_type_filter" id="HybridfuelType"
                                    value="Hybrid">
                                <label for="HybridfuelType" style="font-size:16px; color: white;">Hybrid</label>
                            </div>
                            <div class="my-2">
                                <input type="checkbox" class="filter-checkbox me-2 fuel_type_filter"
                                    id="HydrogenfuelType" value="Hydrogen">
                                <label for="HydrogenfuelType" style="font-size:16px; color: white;">Hydrogen</label>
                            </div>
                            <div class="my-2">
                                <input type="checkbox" class="filter-checkbox me-2 fuel_type_filter"
                                    id="Plug-in-HybridfuelType" value="Plug-in Hybrid">
                                <label for="Plug-in-HybridfuelType" style="font-size:16px; color: white;">Plug-in
                                    Hybrid</label>
                            </div>
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
                                <option value="" selected>Seating Capacity</option>
                                <option value="2">2</option>
                                <option value="4">4</option>
                                <option value="5+">5+</option>
                            </select> <i class="bi bi-chevron-down" style="color: #BFBEC3; "></i>
                        </div>
                      
                    </div>
                    <!-- Transmission Filter -->
                    <div class="my-3">
                        <label class="form-label mb-3 mt-2"> <strong>Transmission </strong></label>
                        <div class="d-flex align-items-center">
                            <input type="checkbox" class=" transmission-filter me-2 transmission_filter"
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
                        <label class="form-label mb-4"> <strong>Door Count </strong></label>
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
                        <label class="form-label mb-4 mt-1"><strong>Assembly</strong></label>
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
                    <!-- Body Type Filter -->
              










                    <!-- Exterior Color Filter -->
                    <div class="my-3 ">
                        <label class="form-label mb-3 mt-2"><strong>Exterior Color</strong></label>

                     
                        <div class="col-12 divheight">
                        
                                <div class="my-2">
                                    <input type="checkbox" class="filter-checkbox  exterior_color_filter"
                                        value="" id="exterior_color_filter">
                                    <label for=""
                                        style="font-size:16px; color: white;"> <span
                                        
                                            class=" p-0 m-0 px-4 me-2" style="background-color:red;border-radius: 5px;"></span>red</label>
                                </div>
                    

                                <div class="my-2">
                                    <input type="checkbox" class="filter-checkbox  exterior_color_filter"
                                        value="" id="exterior_color_filter">
                                    <label for=""
                                        style="font-size:16px; color: white;"> <span
                                        
                                            class=" p-0 m-0 px-4 me-2" style="background-color:green;border-radius: 5px;"></span>green</label>
                                </div>
                                <div class="my-2">
                                    <input type="checkbox" class="filter-checkbox  exterior_color_filter"
                                        value="" id="exterior_color_filter">
                                    <label for=""
                                        style="font-size:16px; color: white;"> <span
                                        
                                            class=" p-0 m-0 px-4 me-2" style="background-color:pink;border-radius: 5px;"></span>pink</label>
                                </div>
                                <div class="my-2">
                                    <input type="checkbox" class="filter-checkbox  exterior_color_filter"
                                        value="" id="exterior_color_filter">
                                    <label for=""
                                        style="font-size:16px; color: white;"> <span
                                        
                                            class=" p-0 m-0 px-4 me-2" style="background-color:orange;border-radius: 5px;"></span>orange</label>
                                </div>
                                <div class="my-2">
                                    <input type="checkbox" class="filter-checkbox  exterior_color_filter"
                                        value="" id="exterior_color_filter">
                                    <label for=""
                                        style="font-size:16px; color: white;"> <span
                                        
                                            class=" p-0 m-0 px-4 me-2" style="background-color:white;border-radius: 5px;"></span>white</label>
                                </div>
                                <div class="my-2">
                                    <input type="checkbox" class="filter-checkbox  exterior_color_filter"
                                        value="" id="exterior_color_filter">
                                    <label for=""
                                        style="font-size:16px; color: white;"> <span
                                        
                                            class=" p-0 m-0 px-4 me-2" style="background-color:yellow;border-radius: 5px;"></span>yellow</label>
                                </div>

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
                                value="car_dealer" id="dealer_check"
                                >
                            <label for=""  class="ms-2" style="font-size:16px">Dealer</label>
                        </div>
                        <div class="d-flex align-items-center ms-3">
                            <input type="checkbox" class="filter-checkbox" name="userType" data-usertype="private_dealer"
                                value="private_dealer" id="private_seller_check" 
                                >
                            <label for=""  class="ms-2" style="font-size:16px">Private Seller</label>
                        </div>
                        </div>
                    </div>
                </div>     </div>
            <div class="col-lg-9">
                <div class="row gy-3">
                    <div class="col-lg-12">
                        <div class="wishlist-card">
					
                      <a href="{{ route('bike_details') }}" style="text-decoration: none; color: #ffffff;">
	
                                <div class="row">
                                    <div class="col-lg-4 ">
                                      <div class="img-bg-home-2">

                                                            <img src="{{asset('web/images/imagebikee.svg')}}" class="img-adj-card">
                                                        </div>
                                    </div>
                                    <div class="col-lg-8  my-auto">
                                        <div class="pe-lg-3 px-lg-0 pb-lg-0  p-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6>2024</h6>
                                                <span class="rounded px-3" style="background-color:#4581F9;">New</span>
                                            </div>
                                            <h4>Suzuki Gixxer kjhgfd Bike</h4>
                                            <h5 style="color: #FD5631;"><b>PKR 1,110,000</b></h5>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0"><i class="bi bi-geo-alt"></i> Turbat</h6>
                                                <span>Last Updated: April 19,2002 </span>
                                            </div>
                                            <hr>
                                            <div class="row pb-2">
                                                <div class="col-4">
                                                    <div class="text-center py-2"
                                                        style="background-color:#1F1B2D; border-radius: 10px;">
                                                        <i class="bi bi-speedometer2"></i>
                                                        <h6>48 KM</h6>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="text-center py-2"
                                                        style="background-color:#1F1B2D; border-radius: 10px;">
                                                        <i class="bi bi-car-front-fill"></i>
                                                        <h6>Auto</h6>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="text-center py-2"
                                                        style="background-color:#1F1B2D; border-radius: 10px;">
                                                        <i class="bi bi-fuel-pump-diesel"></i>
                                                        <h6>Gasoline</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>



                        </div>
                    </div>
                     <div class="col-lg-12">
                        <div class="wishlist-card">
					
                      <a href="{{ route('bike_details') }}" style="text-decoration: none; color: #ffffff;">
	
                                <div class="row">
                                    <div class="col-lg-4 ">
                                      <div class="img-bg-home-2">

                                                            <img src="{{asset('web/images/imagebikee.svg')}}" class="img-adj-card">
                                                        </div>
                                    </div>
                                    <div class="col-lg-8  my-auto">
                                        <div class="pe-lg-3 px-lg-0 pb-lg-0  p-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6>2024</h6>
                                                <span class="rounded px-3" style="background-color:#4581F9;">New</span>
                                            </div>
                                            <h4>Suzuki Gixxer kjhgfd Bike</h4>
                                            <h5 style="color: #FD5631;"><b>PKR 1,110,000</b></h5>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0"><i class="bi bi-geo-alt"></i> Turbat</h6>
                                                <span>Last Updated: April 19,2002 </span>
                                            </div>
                                            <hr>
                                            <div class="row pb-2">
                                                <div class="col-4">
                                                    <div class="text-center py-2"
                                                        style="background-color:#1F1B2D; border-radius: 10px;">
                                                        <i class="bi bi-speedometer2"></i>
                                                        <h6>48 KM</h6>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="text-center py-2"
                                                        style="background-color:#1F1B2D; border-radius: 10px;">
                                                        <i class="bi bi-car-front-fill"></i>
                                                        <h6>Auto</h6>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="text-center py-2"
                                                        style="background-color:#1F1B2D; border-radius: 10px;">
                                                        <i class="bi bi-fuel-pump-diesel"></i>
                                                        <h6>Gasoline</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>



                        </div>
                    </div>       <div class="col-lg-12">
                        <div class="wishlist-card">
					
                      <a href="{{ route('bike_details') }}" style="text-decoration: none; color: #ffffff;">
	
                                <div class="row">
                                    <div class="col-lg-4 ">
                                      <div class="img-bg-home-2">

                                                            <img src="{{asset('web/images/imagebikee.svg')}}" class="img-adj-card">
                                                        </div>
                                    </div>
                                    <div class="col-lg-8  my-auto">
                                        <div class="pe-lg-3 px-lg-0 pb-lg-0  p-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6>2024</h6>
                                                <span class="rounded px-3" style="background-color:#4581F9;">New</span>
                                            </div>
                                            <h4>Suzuki Gixxer kjhgfd Bike</h4>
                                            <h5 style="color: #FD5631;"><b>PKR 1,110,000</b></h5>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0"><i class="bi bi-geo-alt"></i> Turbat</h6>
                                                <span>Last Updated: April 19,2002 </span>
                                            </div>
                                            <hr>
                                            <div class="row pb-2">
                                                <div class="col-4">
                                                    <div class="text-center py-2"
                                                        style="background-color:#1F1B2D; border-radius: 10px;">
                                                        <i class="bi bi-speedometer2"></i>
                                                        <h6>48 KM</h6>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="text-center py-2"
                                                        style="background-color:#1F1B2D; border-radius: 10px;">
                                                        <i class="bi bi-car-front-fill"></i>
                                                        <h6>Auto</h6>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="text-center py-2"
                                                        style="background-color:#1F1B2D; border-radius: 10px;">
                                                        <i class="bi bi-fuel-pump-diesel"></i>
                                                        <h6>Gasoline</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>



                        </div>
                    </div>       <div class="col-lg-12">
                        <div class="wishlist-card">
					
                      <a href="{{ route('bike_details') }}" style="text-decoration: none; color: #ffffff;">
	
                                <div class="row">
                                    <div class="col-lg-4 ">
                                      <div class="img-bg-home-2">

                                                            <img src="{{asset('web/images/imagebikee.svg')}}" class="img-adj-card">
                                                        </div>
                                    </div>
                                    <div class="col-lg-8  my-auto">
                                        <div class="pe-lg-3 px-lg-0 pb-lg-0  p-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6>2024</h6>
                                                <span class="rounded px-3" style="background-color:#4581F9;">New</span>
                                            </div>
                                            <h4>Suzuki Gixxer kjhgfd Bike</h4>
                                            <h5 style="color: #FD5631;"><b>PKR 1,110,000</b></h5>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0"><i class="bi bi-geo-alt"></i> Turbat</h6>
                                                <span>Last Updated: April 19,2002 </span>
                                            </div>
                                            <hr>
                                            <div class="row pb-2">
                                                <div class="col-4">
                                                    <div class="text-center py-2"
                                                        style="background-color:#1F1B2D; border-radius: 10px;">
                                                        <i class="bi bi-speedometer2"></i>
                                                        <h6>48 KM</h6>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="text-center py-2"
                                                        style="background-color:#1F1B2D; border-radius: 10px;">
                                                        <i class="bi bi-car-front-fill"></i>
                                                        <h6>Auto</h6>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="text-center py-2"
                                                        style="background-color:#1F1B2D; border-radius: 10px;">
                                                        <i class="bi bi-fuel-pump-diesel"></i>
                                                        <h6>Gasoline</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>



                        </div>
                    </div>       <div class="col-lg-12">
                        <div class="wishlist-card">
					
                      <a href="{{ route('bike_details') }}" style="text-decoration: none; color: #ffffff;">
	
                                <div class="row">
                                    <div class="col-lg-4 ">
                                      <div class="img-bg-home-2">

                                                            <img src="{{asset('web/images/imagebikee.svg')}}" class="img-adj-card">
                                                        </div>
                                    </div>
                                    <div class="col-lg-8  my-auto">
                                        <div class="pe-lg-3 px-lg-0 pb-lg-0  p-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6>2024</h6>
                                                <span class="rounded px-3" style="background-color:#4581F9;">New</span>
                                            </div>
                                            <h4>Suzuki Gixxer kjhgfd Bike</h4>
                                            <h5 style="color: #FD5631;"><b>PKR 1,110,000</b></h5>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0"><i class="bi bi-geo-alt"></i> Turbat</h6>
                                                <span>Last Updated: April 19,2002 </span>
                                            </div>
                                            <hr>
                                            <div class="row pb-2">
                                                <div class="col-4">
                                                    <div class="text-center py-2"
                                                        style="background-color:#1F1B2D; border-radius: 10px;">
                                                        <i class="bi bi-speedometer2"></i>
                                                        <h6>48 KM</h6>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="text-center py-2"
                                                        style="background-color:#1F1B2D; border-radius: 10px;">
                                                        <i class="bi bi-car-front-fill"></i>
                                                        <h6>Auto</h6>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="text-center py-2"
                                                        style="background-color:#1F1B2D; border-radius: 10px;">
                                                        <i class="bi bi-fuel-pump-diesel"></i>
                                                        <h6>Gasoline</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>



                        </div>
                    </div>
                    </div>   
                </div>
            </div>
        </div>

@endsection