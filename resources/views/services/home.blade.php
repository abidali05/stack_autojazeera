@extends('layout.website_layout.services.main')
@section('content')
    <link rel="stylesheet" href="{{ asset('web/services/css/styles.css') }}">
    <style>
        #customCarousel {
            background-image: url("{{ asset('web/services/images/backimgrola.svg') }}");
        }

        .bakgimg {
            background-image: url("{{ asset('web/services/images/Frame\ 1618873199.svg') }}");
        }

        .bakgimg3211 {
            background-image: url("{{ asset('web/services/images/Frame\ 1618873199.svg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 150px;
            width: 100%;
        }

        .imgbak {
            background-image: url("{{ asset('web/services/images/Frame\ 1171275423.svg') }}");
        }

        .img-bg-home-2 {
            width: 100%;
            overflow: hidden;
            border-radius: 20px 20px 0px 0px;
        }
@media (min-width: 768px) {
    .col-md-1-5 {
        width: 20%;
        flex: 0 0 20%;
        max-width: 20%;
    }
}
        .featureicn {
            position: absolute;
            left: 0;
            background: #BF0000;
            color: white;
            font-size: 12px;
            font-weight: 500;
            border-radius: 5px;
            padding: 5px 10px;
            margin-top: 10px;
            margin-left: 10px;
        }

        .featureicoxn {
            position: absolute;
            left: 0;
            background: #BF0000;
            color: white;
            font-size: 12px;
            font-weight: 500;
            border-radius: 5px;
            padding: 5px 10px;
            margin-top: 10px;
            margin-left: 10px;
        }

        .crouserheading1 {
            color: #281f48;
            font-size: 36px;
            padding-left: 100px;
            padding-top: 60px;
            font-weight: 700;
        }

        .crouserheading11 {
            color: #281f48;
            font-size: 34px;
            padding-left: 100px;
            padding-top: 100px;
            font-weight: 700;
        }

        .crouserheading11 {
            color: #281f48;
            font-size: 34px;
            padding-left: 100px;
            padding-top: 100px;
            font-weight: 700;
        }

        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .checkbox-button {
            position: relative;
            cursor: pointer;
        }

        .checkbox-button input[type="checkbox"] {
            display: none;
        }

        /* Style the span */
        .checkbox-button span {
            display: inline-block;
            padding: 8px 16px;
            border: 1px solid #A7A7A7;
            border-radius: 30px;
            background-color: white;
            color: #A7A7A7;
            min-width: 120px;
            text-align: center;
            transition: all 0.3s ease;

        }

        /* When the checkbox is checked */
        .checkbox-button input[type="checkbox"]:checked+span {
            background-color: #281F48;
            color: white;
            border-color: #281F48;
        }

        .scrollable-content {
            height: 250px;
            /* height for scrollable area */
            overflow-y: auto;
            padding: 15px;
        }

        /* Scrollbar Red Color */
        .scrollable-content::-webkit-scrollbar {
            width: 8px;
        }

        .scrollable-content::-webkit-scrollbar-thumb {
            background-color: #281F48;
            border-radius: 10px;
        }

        .scrollable-content::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        @media screen and (min-width: 300px) and (max-width: 600px) {
            .crouserheading1 {
                color: #281f48;
                font-size: 18px;
                padding-left: 20px;
                padding-top: 20px;
                font-weight: 700;
                text-align: center;
            }

            .paddingthis {
                padding-left: 0px;
                padding-top: 10px;
            }

            .crouserheading11 {
                color: #281f48;
                font-size: 18px;
                padding-left: 20px;
                padding-top: 20px;
                font-weight: 700;
            }
        }

        .step-content {
            display: none;
        }

        .step-content.active {
            display: block;
        }

        .select2-container--default .select2-selection--single {
            border-radius: 0px !important;
            border: 0px !important;
            height: 44px;
            padding: 11px 12px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 24px;
        }

        .select2 select2-container select2-container--default {
            border-left: 2px solid black;
        }
     .select2-container--default .select2-selection--single .select2-selection__placeholder {
    color: black !important;
}
.select2-container--open .select2-dropdown--below {
    border-top: none;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
       border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
}.search-box {
    display: flex;
    align-items: center;
    background-color: #D90600;
    border-radius: 50px;
    padding: 10px 20px;
    width: 300px;
    
}

.search-box input {
    border: none;
    outline: none;
    background: none;
    color: white;
    font-size: 16px;
    flex: 1;
}

.search-box input::placeholder {
    color: white;
}

.search-box i {
    color: white;
    font-size: 18px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow b {
    border-color: #888 transparent transparent transparent;
    border-style: solid;
    border-width: 5px 4px 0 4px;
    height: 0;
    left: 50%;
    margin-left: -4px;
    margin-top: 5px ! important;
    position: absolute;
    top: 50%;
    width: 0;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 26px;
    position: absolute;
    top: 2px !important;
    right: 1px;
    width: 20px;
}
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 bakgimg3211">
                <div class="row d-flex justify-content-center">
                    <div class="col-10 col-md-9 pt-5">
                        <div class="input-group">
                            <form action="{{ route('services.search') }}" method="POST" class="col-12 d-flex">
                                @csrf
                                <input type="text" class="form-control"
                                    style="border-radius:5px 0px 0px 5px !important; border:0px !important"
                                    placeholder="Search By Shop Name" aria-label="Search" name="search" />
                                <div class=" py-3" style="border-left: 1px solid black"></div>
                                <select class="form-select select2-city-search"
                                    style="border-radius:0px !important ;border:0px !important" aria-label="Select City"
                                    name="city">
                                    <option value="" selected>Select City</option>
                                    <option value="1e">Any</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-danger" style="border-radius:0px 5px 5px 0px !important"
                                    type="submit" id="serviceSearchBtn">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div id="customCarousel" class="carousel slide">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="row">
                                    <div class="col-md-11 col-12">
                                        <p class="crouserheading1">
                                            Quality Auto Services Reliable, Professional, On Time
                                        </p>

                                        <div class="paddingthis d-none d-md-block">
                                            <a style="color: white" href="#"
                                                onclick="document.getElementById('serviceSearchBtn').click()">
                                                <div class="search-box">
                                                    <i style="color: white" class="fa fa-search me-3"></i>
                                                    Search a Service
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <img src="{{ asset('web/services/images/Frame.svg') }}" class="d-block w-100 imgcrs"
                                    alt="Slide 2" />
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-11 col-12">
                                        <p class="crouserheading11">
                                            Looking for the perfect car to match your needs?
                                        </p>

                                        <div class="paddingthis d-none d-md-block">
                                            <a style="color: white" href="#"
                                                onclick="document.getElementById('searchBtn').click()">
                                                <div class="search-box">
                                                    <i style="color: white" class="fa fa-search me-3"></i>
                                                    Search a car
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <img src="{{ asset('web/services/images/image 51.svg') }}" class="img-fluid"
                                    alt="Slide 3" />
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-11 col-12">
                                        <p class="crouserheading11">
                                            Looking for the perfect bike to match your needs?
                                        </p>

                                        <div class="paddingthis d-none d-md-block">
                                            <a style="color: white" href="#"
                                                onclick="document.getElementById('searchBtn').click()">
                                                <div class="search-box">
                                                    <i style="color: white" class="fa fa-search me-3"></i>
                                                    Search a Bike
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <img src="{{ asset('web/services/images/Group 1171275421 (1).svg') }}"
                                    class="d-block w-75 imgcrs" alt="Slide 3" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#customCarousel" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#customCarousel" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#customCarousel" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                    <!-- Add this new button -->
                </div>
            </div>
        </div>
    </div>
    <div class="container my-3">
        <div class="row">
            <div class="col-md-12">
                <p class="twentyeight m-0">Looking for auto today ?</p>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3 col-6 p-3">
                        <a href="{{ url('cars/new') }}" class="text-decoration-none text-dark">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="{{ asset('web/services/images/Frame 25 (3).svg') }}"
                                        class="img-fluid w-100" alt="..." />

                                </div>
                                <div class="col-md-12">

                                    <p class="text-center sixteen">New Cars</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3 col-6 p-3">
                        <a href="{{ url('cars/used') }}" class="text-decoration-none text-dark">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="{{ asset('web/services/images/Frame 25 (44).svg') }}"
                                        class="img-fluid  w-100" alt="Used Cars" />
                                    <p class="text-center sixteen">Used Cars</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3 col-6 p-3">
                        <a href="{{ url('bikes/new') }}" class="text-decoration-none text-dark">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="{{ asset('web/services/images/Frame 25 (4).svg') }}"
                                        class="img-fluid  w-100" alt="New Bikes" />
                                    <p class="text-center sixteen">New Bikes</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3 col-6  p-3">
                        <a href="{{ url('bikes/used') }}" class="text-decoration-none text-dark">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="{{ asset('web/services/images/Frame 25 (5).svg') }}"
                                        class="img-fluid  w-100" alt="Used Bikes" />
                                    <p class="text-center sixteen">Used Bikes</p>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
<!-- View All Toggle Section -->
<div class="col-md-12 d-flex justify-content-between align-items-center">
    <p class="twentyeight m-0">Looking for auto services today?</p>
    <span class="sixteen">
        <a href="javascript:void(0)" id="toggleServices" class="text-danger">View all</a>
    </span>
</div>

<!-- Services Grid -->
<div class="col-md-12">
    <div class="row d-flex flex-wrap justify-content-start" id="serviceCategories">
        @foreach ($service_categories as $key => $service_category)
            <div class="col-6 col-md-1-5 p-3 rounded-3 extra-service" 
                 style="cursor: pointer; {{ $key >= 10 ? 'display: none;' : '' }}">
                <div class="rounded-3 p-4" style="background-color:#F4F4F4">
                    <a href="{{ route('services.categorysearch', $service_category->name) }}"
                       class="text-decoration-none text-dark">
                        <img src="{{ $service_category->icon }}" class="img-fluid rounded"
                             style="height:100px; width:100%;" alt="{{ $service_category->name }}" />
                    </a>
                </div>
                <p class="text-center m-0 sixteen my-1">{{ $service_category->name }}</p>
            </div>
        @endforeach
    </div>
</div>


        </div>
    </div>
    <div class="container my-3">
        <div class="row">

            <div class="col-md-12">
                <p class=" my-4 d-flex justify-content-between"><span class="twentyeight">Top Rated Services</span><span
                        class="sixteen"><a class="sixteen text-danger" href="{{ route('services.toprated') }}">View
                            all</a></span></p>

                <div class="row">

                    <div id="topRatedCarousel" style="min-height:400px !important" class="carousel slide"
                        data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @if (count($top_rated_services) == 0)
                                <div class="col-md-12 mt-5 pt-5">
                                    <div class="row d-flex justify-content-center my-3">
                                        <div class="p-3 col-8" style="border:1px solid #281F48;border-radius:9px;">
                                            <div class="row d-flex align-items-center">
                                                <div class="col-3">
                                                    <img src="{{ asset('web/images/noinputs.svg') }}" alt=""
                                                        class="img-fluid" srcset="">
                                                </div>
                                                <div class="col-9 text-start">

                                                    <p class="m-0">No top rated services found </p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @foreach ($top_rated_services->chunk(3) as $chunkIndex => $serviceChunk)
                                <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}" style="height:395px !important">
                                    <div class="row">
                                        @foreach ($serviceChunk as $service)
                                            <div class="col-md-4 car" data-longitude="{{ $service->longitude }}"
                                                data-latitude="{{ $service->latitude }}">
                                                <a href="{{ route('shopdetail', $service->id) }}"
                                                    class="text-decoration-none text-dark">
                                                    <div class="wishlist-card ddd rounded-4">
                                                        <div class="img-bg-home-2 "
                                                            style="height: 200px;position: relative">
                                                            <img src="{{ $service->logo }}" style="height: 100%;"
                                                                class=" w-100" />
                                                            <span class="featureicn">
                                                                <img src="{{ asset('web/bikes/images/Star 7.svg') }}"
                                                                    class="img-fluid">
                                                                Top Rated</span>
                                                        </div>
                                                        <div class="py-lg-12 px-lg-12 px-3">
                                                            <div
                                                                class="row mt-2 d-flex justify-content-between align-items-baseline">
                                                                <div class="col-7">
                                                                    <p class="fourteen">
                                                                        <strong>{{ $service->name }}</strong>
                                                                    </p>
                                                                </div>
                                                                <div class="col-5 d-flex justify-content-start">
                                                                    <div class="rating-wrapper">
                                                                        <div class="star-group">
                                                                            @php
                                                                                $rounded =
                                                                                    round($service->rating * 2) / 2;
                                                                            @endphp
                                                                            @for ($i = 1; $i <= 5; $i++)
                                                                                <div
                                                                                    class="star-wrapper 
                                                                @if ($i <= floor($rounded)) active-star 
                                                                @elseif($i == ceil($rounded) && fmod($rounded, 1) != 0) half-star @endif">
                                                                                    <span
                                                                                        class="star-icon 
                                                                    @if ($i <= floor($rounded)) filled-star 
                                                                    @elseif($i == ceil($rounded) && fmod($rounded, 1) != 0) half-filled-star @endif">
                                                                                        ★
                                                                                    </span>
                                                                                </div>
                                                                            @endfor
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 d-flex justify-content-between">
                                                                @php
                                                                    $currentDay = date('l');
                                                                    $timings = $service->shop_timings
                                                                        ->where('day', $currentDay)
                                                                        ->first();
                                                                @endphp
                                                                <p class="fourteen">
                                                                    @if ($timings)
                                                                        <span style="color: #2ab500">Open Now </span>
                                                                        {{ date('h:i A', strtotime($timings->start_time)) }}
                                                                        -
                                                                        {{ date('h:i A', strtotime($timings->end_time)) }}
                                                                    @else
                                                                        <span style="color: orangered;">Closed</span>
                                                                    @endif
                                                                </p>

                                                                <div class="rating-label" id="ratingLabel">
                                                                    {{ $service->rating }} ({{ $service->total_ratings }}
                                                                    reviews)
                                                                </div>
                                                            </div>
                                                </a>
                                                <div class="col-md-12">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-7 pe-0">
                                                            <p class="twelve m-0">
                                                                <img src="{{ asset('web/services/images/Icon (Stroke).svg') }}"
                                                                    class="img-fluid me-2" alt="..." />
                                                                {{ Str::words($service->address, 5, '...more') }}
                                                                (<span class="distance">...</span>)
                                                            </p>
                                                        </div>
                                                        <div class="col-md-5 ps-0 text-end">
                                                            @auth
                                                                @if ($service->dealer_id == auth()->user()->id)
                                                                    <button class="button111" type="button"
                                                                        onclick="alert('You can not request a quote from your own shop')">Request
                                                                        a Quote</button>
                                                                @else
                                                                    @if (Auth::user()->role == '2' || Auth::user()->role == '3')
                                                                        <button class="button111" type="button"
                                                                            onclick="alert('You are not authorized for this action!')">
                                                                            Request a Quote</button>
                                                                    @else
                                                                        <button class="button111" type="button"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#requestQuoteModal{{ $service->id }}">Request
                                                                            a Quote</button>
                                                                    @endif
                                                                @endif

                                                            @endauth

                                                            @guest
                                                                <a href="{{ route('login') }}" class="button111"
                                                                    type="button">Request
                                                                    a Quote</a>
                                                            @endguest

                                                        </div>
                                                    </div>
                                                </div>

                                                <hr class="m-0 mt-2" />

                                                <div class="row">
                                                    @foreach ($service->shop_services as $i => $shopservice)
                                                        @if ($i < 3)
                                                            <div class="col-4 my-3">
                                                                <p class="twelvebold">
                                                                    {{ $shopservice->service->name }}</p>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>

                                            </div>
                                    </div>

                                </div>


                                {{-- request quote modal start --}}
                                <div class="modal fade classcrol" id="requestQuoteModal{{ $service->id }}"
                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                    aria-labelledby="requestQuoteModalLabel" aria-hidden="true">
                                    <div
                                        class="modal-dialog modal-dialog-centered modal-dialog-scrollable custom-modal-width">
                                        <div class="modal-content">
                                            <form id="multiStepForm{{ $service->id }}" class="multiStepForm">
                                                <input type="hidden" name="shop_id" value="{{ $service->id }}">
                                                <div class="modal-header" style="border: none;">
                                                    <!-- Optional Header -->
                                                </div>
                                                <div class="modal-body pt-0">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="fourtyeight ps-4 m-0 ms-3 p-0">Request a
                                                            Quote</p>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>

                                                    <!-- Steps Start -->
                                                    <div class="step-content active step0" id="step0">
                                                        <div class="row classcrol">
                                                            <div class="col-md-5 ps-5">
                                                                <div class="scrollable-content">
                                                                    <p class="twentyeight mt-4">Select your
                                                                        Vehicle </p>

                                                                    <div class="checkbox-group">
                                                                        <label class="checkbox-button">
                                                                            <input type="checkbox" name="vehicle_type"
                                                                                value="bike" hidden>
                                                                            <span>Bike</span>
                                                                        </label>
                                                                        <label class="checkbox-button">
                                                                            <input type="checkbox" name="vehicle_type"
                                                                                value="car" hidden>
                                                                            <span>Car</span>
                                                                        </label>
                                                                    </div>
                                                                    <div id="vehicle-error" class="reed mt-2"
                                                                        style="display:none;">Please select a
                                                                        vehicle type</div>

                                                                </div>
                                                                <div class="d-flex justify-content-end mt-5">
                                                                    <button type="button"
                                                                        class="bluebtn ms-auto next next-valid px-5">Next</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <img src="{{ asset('web/services/images/carbike.svg') }}"
                                                                    class="img-fluid" alt="...">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Step 1 -->
                                                    <div class="step-content step1" id="step1">
                                                        <div class="row classcrol">
                                                            <div class="col-md-5 ps-5">
                                                                <div class="scrollable-content">
                                                                    <p class="twentyeight mt-4">Select body
                                                                        type</p>
                                                                    <div id="body_type-error" class="reed mt-2"
                                                                        style="display:none;">Please select a
                                                                        body type</div>



                                                                    <div class="checkbox-group">

                                                                    </div>

                                                                </div>
                                                                <div class=" d-flex justify-content-between mt-5">
                                                                    <button type="button"
                                                                        class="whitebtn prev px-5 ">Back</button>
                                                                    <button type="button"
                                                                        class="bluebtn ms-auto next px-5"
                                                                        id="secondstepbtn">Next</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <img src="{{ asset('web/services/images/Frameee.svg') }}"
                                                                    class="img-fluid" alt="...">

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Step 2 -->
                                                    <div class="step-content step2" id="step2">
                                                        <div class="row classcrol">
                                                            <div class="col-md-5 ps-5">
                                                                <div class="scrollable-content">
                                                                    <p class="twentyeight mt-4">Select Make</p>

                                                                    <div class="checkbox-group">
                                                                        <div id="make-error" class="reed mt-2"
                                                                            style="display:none; color:red">Please select
                                                                            make</div>

                                                                    </div>

                                                                </div>
                                                                <div class="d-flex justify-content-between mt-5 ">
                                                                    <button type="button"
                                                                        class="whitebtn prev px-5">Back</button>
                                                                    <button type="button"
                                                                        class="bluebtn  next px-5">Next</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <img src="{{ asset('web/services/images/Frameee.svg') }}"
                                                                    class="img-fluid" alt="...">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Step 3 -->
                                                    <div class="step-content step3" id="step3">
                                                        <div class="row classcrol">
                                                            <div class="col-md-5 ps-5">
                                                                <div class="scrollable-content">
                                                                    <p class="twentyeight mt-4">Select Model
                                                                    </p>

                                                                    <div class="checkbox-group">
                                                                        <div id="model-error" class="reed mt-2"
                                                                            style="color:red;display:none; color:red;">
                                                                            Please select model
                                                                        </div>


                                                                    </div>

                                                                </div>
                                                                <div class="d-flex justify-content-between mt-5">
                                                                    <button type="button"
                                                                        class="whitebtn prev px-5">Back</button>
                                                                    <button type="button"
                                                                        class="bluebtn  next px-5">Next</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <img src="{{ asset('web/services/images/Frameee.svg') }}"
                                                                    class="img-fluid" alt="...">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Step 4 -->
                                                    <div class="step-content step4" id="step4">
                                                        <div class="row classcrol">
                                                            <div class="col-md-5 ps-5">
                                                                <div class="scrollable-content">
                                                                    <p class="twentyeight mt-4">Select Year</p>
                                                                    <div id="year-error" class="reed mt-2"
                                                                        style="display:none; color:red;">
                                                                        Please select year first.
                                                                    </div>


                                                                    <div class="checkbox-group">
                                                                        @for ($i = 1960; $i <= date('Y'); $i++)
                                                                            <label class="checkbox-button">
                                                                                <input type="radio" hidden
                                                                                    name="year"
                                                                                    value="{{ $i }}">
                                                                                <span>{{ $i }}</span>
                                                                            </label>
                                                                        @endfor


                                                                    </div>

                                                                </div>
                                                                <div class="d-flex justify-content-between mt-5">
                                                                    <button type="button"
                                                                        class="whitebtn prev px-5">Back</button>
                                                                    <button type="button"
                                                                        class="bluebtn  next px-5">Next</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <img src="{{ asset('web/services/images/popupimg.svg') }}"
                                                                    class="img-fluid" alt="...">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Step 5 -->
                                                    <div class="step-content step5" id="step5">
                                                        <div class="row classcrol">
                                                            <div class="col-md-5 ps-5">
                                                                <div class="scrollable-content">
                                                                    <p class="twentyeight mt-4">Select services
                                                                        you need</p>
                                                                    <div id="services-error" class="reed mt-2"
                                                                        style="display:none; color:red;">
                                                                        Please select at least one service
                                                                    </div>
                                                                    <div class="checkbox-group">
                                                                        @foreach ($service->shop_services as $shopservice)
                                                                            <label class="checkbox-button">
                                                                                <input type="checkbox" hidden
                                                                                    value="{{ $shopservice->id }}"
                                                                                    name="services[]">
                                                                                <span>{{ $shopservice->service->name }}</span>
                                                                            </label>
                                                                        @endforeach

                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-between mt-5">
                                                                    <button type="button"
                                                                        class="whitebtn prev px-5">Back</button>
                                                                    <button type="button"
                                                                        class="bluebtn  next px-5">Next</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <img src="{{ asset('web/services/images/popupimg.svg') }}"
                                                                    class="img-fluid" alt="...">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Step 6 -->
                                                    <div class="step-content step6" id="step6">
                                                        <div class="row classcrol">
                                                            <div class="col-md-5 ps-5">
                                                                <div class="scrollable-content">
                                                                    <p class="twentyeight mt-4">Describe your
                                                                        Needs </p>
                                                                    <textarea class="form-controles" style="height: 200px;" placeholder="Type..." rows="3"
                                                                        name="needs_description" required></textarea>

                                                                    <div class="row mt-2">
                                                                        <div class="col-9 p-3 rounded-3"
                                                                            style="background-color: #F9F9F9;">
                                                                            <div class="row">
                                                                                <div class="g-recaptcha"
                                                                                    data-sitekey="{{ env('RECAPTCHA_KEY') }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-between mt-5">
                                                                    <button type="button"
                                                                        class="whitebtn prev px-5">Back</button>
                                                                    <button type="button"
                                                                        class="bluebtn  next px-5">Submit</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <img src="{{ asset('web/services/images/popupimg.svg') }}"
                                                                    class="img-fluid" alt="...">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Step 7 -->
                                                    <div class="step-content step7" id="step7">
                                                        <div class="row classcrol">
                                                            <div class="col-md-12 ps-5">
                                                                <div class="">
                                                                    <div class="text-center ">
                                                                        <img src="{{ asset('web/services/images/image 57.svg') }}"
                                                                            class="w-25" alt="...">
                                                                        <p class="eighteen">Sending your
                                                                            request</p>
                                                                    </div>


                                                                </div>
                                                                <div
                                                                    class="col-md-5 d-flex justify-content-between mt-5 d-none">

                                                                    <button type="button"
                                                                        class="whitebtn prev  px-5">Back</button>
                                                                    <button type="button"
                                                                        class="bluebtn me-5  next px-5">Next</button>

                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>

                                                    <!-- Step 8 (Final Step) -->
                                                    <div class="step-content step8" id="step8">
                                                        <div class="row classcrol">
                                                            <div class="col-md-12 ps-5">
                                                                <div class="">
                                                                    <div class="text-center ">
                                                                        <img src="{{ asset('web/services/images/image (290).svg') }}"
                                                                            class=""
                                                                            style="height: 125px; width:180px"
                                                                            alt="...">
                                                                        <p class="eighteen m-0">Your request
                                                                            has been sent</p>
                                                                        <p class="twelve">You will receive
                                                                            quote in email and message box </p>
                                                                        <a href="{{ route('services.home') }}"
                                                                            type="button"
                                                                            class="btn btn-danger py-2 px-2"
                                                                            style="font-size: 12px;">Find More
                                                                            Auto
                                                                            Services</a>
                                                                    </div>

                                                                </div>
                                                                <div
                                                                    class="col-md-5 d-flex justify-content-between mt-5 d-none">

                                                                    <button type="button"
                                                                        class="whitebtn prev  px-5">Back</button>
                                                                    <button type="button"
                                                                        class="bluebtn me-5  next px-5">Next</button>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <!-- Steps End -->

                                        </div>
                                        </form>
                                    </div>
                                </div>

                                {{-- request quote modal end --}}
                            @endforeach
                        </div>
                    </div>
                    @endforeach

                </div>

                <!-- Carousel controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#topRatedCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#topRatedCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>


        </div>
    </div>
    <div class="col-md-12 mt-2">
        <p class=" my-4 d-flex justify-content-between"><span class="twentyeight">Recent Featured
                Services</span><span class="sixteen"><a class="sixteen text-danger"
                    href="{{ route('services.featured') }}">View
                    all</a></span></p>
        <div class="row">

            <div id="serviceCarousel" style="min-height:400px !important" class="carousel slide"
                data-bs-ride="carousel">
                <div class="carousel-inner">
                    @if (count($featured_services) == 0)
                        <div class="col-md-12 mt-5 pt-5">
                            <div class="row d-flex justify-content-center my-3">
                                <div class="p-3 col-8" style="border:1px solid #281F48;border-radius:9px;">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-3">
                                            <img src="{{ asset('web/images/noinputs.svg') }}" alt=""
                                                class="img-fluid" srcset="">
                                        </div>
                                        <div class="col-9 text-start">

                                            <p class="m-0">No recent featured
                                                services found </p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @foreach ($featured_services->chunk(3) as $chunkIndex => $serviceChunk)
                        <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}" style="height:395px !important">
                            <div class="row">
                                @foreach ($serviceChunk as $service)
                                    <div class="col-md-4 car" data-longitude="{{ $service->longitude }}"
                                        data-latitude="{{ $service->latitude }}">
                                        <a href="{{ route('shopdetail', $service->id) }}"
                                            class="text-decoration-none text-dark">
                                            <div class="wishlist-card ddd rounded-4">
                                                <div class="img-bg-home-2" style="height: 200px; position: relative">
                                                    <img src="{{ $service->logo }}" style="    
        height: 100%;"
                                                        class=" w-100" />
                                                    <span class="featureicoxn">
                                                        <img src="{{ asset('web/bikes/images/Star 7.svg') }}"
                                                            class="img-fluid">
                                                        Featured</span>
                                                </div>
                                                <div class="py-lg-12 px-lg-12 px-3">
                                                    <div
                                                        class="row mt-2 d-flex justify-content-between align-items-baseline">
                                                        <div class="col-7">
                                                            <p class="fourteen">
                                                                <strong>{{ $service->name }}</strong>
                                                            </p>
                                                        </div>
                                                        <div class="col-5 d-flex justify-content-start">
                                                            <div class="rating-wrapper">
                                                                <div class="star-group">
                                                                    @php
                                                                        $rounded = round($service->rating * 2) / 2;
                                                                    @endphp
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <div
                                                                            class="star-wrapper 
                                                                @if ($i <= floor($rounded)) active-star 
                                                                @elseif($i == ceil($rounded) && fmod($rounded, 1) != 0) half-star @endif">
                                                                            <span
                                                                                class="star-icon 
                                                                    @if ($i <= floor($rounded)) filled-star 
                                                                    @elseif($i == ceil($rounded) && fmod($rounded, 1) != 0) half-filled-star @endif">
                                                                                ★
                                                                            </span>
                                                                        </div>
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 d-flex justify-content-between">
                                                        @php
                                                            $currentDay = date('l');
                                                            $timings = $service->shop_timings
                                                                ->where('day', $currentDay)
                                                                ->first();
                                                        @endphp
                                                        <p class="fourteen">
                                                            @if ($timings)
                                                                <span style="color: #2ab500">Open Now </span>
                                                                {{ date('h:i A', strtotime($timings->start_time)) }}
                                                                -
                                                                {{ date('h:i A', strtotime($timings->end_time)) }}
                                                            @else
                                                                <span style="color: orangered;">Closed</span>
                                                            @endif
                                                        </p>

                                                        <div class="rating-label" id="ratingLabel">
                                                            {{ $service->rating }} ({{ $service->total_ratings }}
                                                            reviews)
                                                        </div>
                                                    </div>
                                        </a>
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <p>
                                                <span class="twelve">
                                                    <img src="{{ asset('web/services/images/Icon (Stroke).svg') }}"
                                                        class="img-fluid me-2" alt="..." />
                                                    {{ \Illuminate\Support\Str::words($service->address, 5, '...more') }}
                                                    (<span class="distance">...</span>)
                                                </span>
                                            </p>
                                            @auth
                                                @if ($service->dealer_id == auth()->user()->id)
                                                    <button class="button111" type="button"
                                                        onclick="alert('You can not request a quote from your own shop')">Request
                                                        a Quote</button>
                                                @else
                                                    <button class="button111" type="button" data-bs-toggle="modal"
                                                        data-bs-target="#requestQuoteModal{{ $service->id }}">Request
                                                        a Quote</button>
                                                @endif

                                            @endauth

                                            @guest
                                                <a href="{{ route('login') }}" class="button111" type="button">Request
                                                    a Quote</a>
                                            @endguest

                                        </div>

                                        <hr class="m-0 mt-2" />

                                        <div class="row">
                                            @foreach ($service->shop_services as $i => $shopservice)
                                                @if ($i < 3)
                                                    <div class="col-4 my-3">
                                                        <p class="twelvebold">
                                                            {{ $shopservice->service->name }}</p>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                            </div>

                        </div>

                        {{-- request quote modal start --}}
                        <div class="modal fade classcrol" id="requestQuoteModal{{ $service->id }}"
                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                            aria-labelledby="requestQuoteModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable custom-modal-width">
                                <div class="modal-content">
                                    <form id="multiStepForm{{ $service->id }}" class="multiStepForm">
                                        <input type="hidden" name="shop_id" value="{{ $service->id }}">
                                        <div class="modal-header" style="border: none;">
                                            <!-- Optional Header -->
                                        </div>
                                        <div class="modal-body pt-0">
                                            <div class="d-flex justify-content-between">
                                                <p class="fourtyeight ps-4 m-0 ms-3 p-0">Request a
                                                    Quote</p>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <!-- Steps Start -->
                                            <div class="step-content active step0" id="step0">
                                                <div class="row classcrol">
                                                    <div class="col-md-5 ps-5">
                                                        <div class="scrollable-content">
                                                            <p class="twentyeight mt-4">Select your
                                                                Vehicle </p>

                                                            <div class="checkbox-group">
                                                                <label class="checkbox-button">
                                                                    <input type="checkbox" name="vehicle_type"
                                                                        value="bike" hidden>
                                                                    <span>Bike</span>
                                                                </label>
                                                                <label class="checkbox-button">
                                                                    <input type="checkbox" name="vehicle_type"
                                                                        value="car" hidden>
                                                                    <span>Car</span>
                                                                </label>
                                                            </div>
                                                            <div id="vehicle-error" class="reed mt-2"
                                                                style="display:none;">Please select a
                                                                vehicle type</div>

                                                        </div>
                                                        <div class="d-flex justify-content-end mt-5">
                                                            <button type="button"
                                                                class="bluebtn ms-auto next next-valid px-5">Next</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <img src="{{ asset('web/services/images/carbike.svg') }}"
                                                            class="img-fluid" alt="...">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Step 1 -->
                                            <div class="step-content step1" id="step1">
                                                <div class="row classcrol">
                                                    <div class="col-md-5 ps-5">
                                                        <div class="scrollable-content">
                                                            <p class="twentyeight mt-4">Select body
                                                                type</p>
                                                            <div id="body_type-error" class="reed mt-2"
                                                                style="display:none;">Please select a
                                                                body type</div>



                                                            <div class="checkbox-group">

                                                            </div>

                                                        </div>
                                                        <div class=" d-flex justify-content-between mt-5">
                                                            <button type="button"
                                                                class="whitebtn prev px-5 ">Back</button>
                                                            <button type="button" class="bluebtn ms-auto next px-5"
                                                                id="secondstepbtn">Next</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <img src="{{ asset('web/services/images/Frameee.svg') }}"
                                                            class="img-fluid" alt="...">

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Step 2 -->
                                            <div class="step-content step2" id="step2">
                                                <div class="row classcrol">
                                                    <div class="col-md-5 ps-5">

                                                        <div class="scrollable-content">
                                                            <p class="twentyeight mt-4">Select Make</p>
                                                            <div id="make-error" class="reed mt-2" style="display:none;">
                                                                Please select
                                                                make</div>
                                                            <div class="checkbox-group">

                                                            </div>

                                                        </div>
                                                        <div class="d-flex justify-content-between mt-5 ">
                                                            <button type="button"
                                                                class="whitebtn prev px-5">Back</button>
                                                            <button type="button"
                                                                class="bluebtn  next px-5">Next</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <img src="{{ asset('web/services/images/Frameee.svg') }}"
                                                            class="img-fluid" alt="...">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Step 3 -->
                                            <div class="step-content step3" id="step3">
                                                <div class="row classcrol">
                                                    <div class="col-md-5 ps-5">
                                                        <div class="scrollable-content">
                                                            <p class="twentyeight mt-4">Select Model
                                                            </p>

                                                            <div class="checkbox-group">
                                                                <div id="model-error" class="reed mt-2"
                                                                    style="color:red;display:none; color:red;">
                                                                    Please select model
                                                                </div>

                                                            </div>

                                                        </div>
                                                        <div class="d-flex justify-content-between mt-5">
                                                            <button type="button"
                                                                class="whitebtn prev px-5">Back</button>
                                                            <button type="button"
                                                                class="bluebtn  next px-5">Next</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <img src="{{ asset('web/services/images/Frameee.svg') }}"
                                                            class="img-fluid" alt="...">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Step 4 -->
                                            <div class="step-content step4" id="step4">
                                                <div class="row classcrol">
                                                    <div class="col-md-5 ps-5">
                                                        <div class="scrollable-content">
                                                            <p class="twentyeight mt-4">Select Year</p>
                                                            <div id="year-error" class="reed mt-2"
                                                                style="display:none; color:red;">
                                                                Please select year first.
                                                            </div>


                                                            <div class="checkbox-group">
                                                                @for ($i = 1960; $i <= date('Y'); $i++)
                                                                    <label class="checkbox-button">
                                                                        <input type="radio" hidden name="year"
                                                                            value="{{ $i }}">
                                                                        <span>{{ $i }}</span>
                                                                    </label>
                                                                @endfor


                                                            </div>

                                                        </div>
                                                        <div class="d-flex justify-content-between mt-5">
                                                            <button type="button"
                                                                class="whitebtn prev px-5">Back</button>
                                                            <button type="button"
                                                                class="bluebtn  next px-5">Next</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <img src="{{ asset('web/services/images/popupimg.svg') }}"
                                                            class="img-fluid" alt="...">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Step 5 -->
                                            <div class="step-content step5" id="step5">
                                                <div class="row classcrol">
                                                    <div class="col-md-5 ps-5">
                                                        <div class="scrollable-content">
                                                            <p class="twentyeight mt-4">Select services
                                                                you need</p>
                                                            <div id="services-error" class="reed mt-2"
                                                                style="display:none; color:red;">
                                                                Please select at least one service
                                                            </div>
                                                            <div class="checkbox-group">

                                                                @foreach ($service->shop_services as $shopservice)
                                                                    <label class="checkbox-button">
                                                                        <input type="checkbox" hidden
                                                                            value="{{ $shopservice->id }}"
                                                                            name="services[]">
                                                                        <span>{{ $shopservice->service->name }}</span>
                                                                    </label>
                                                                @endforeach

                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between mt-5">
                                                            <button type="button"
                                                                class="whitebtn prev px-5">Back</button>
                                                            <button type="button"
                                                                class="bluebtn  next px-5">Next</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <img src="{{ asset('web/services/images/popupimg.svg') }}"
                                                            class="img-fluid" alt="...">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Step 6 -->
                                            <div class="step-content step6" id="step6">
                                                <div class="row classcrol">
                                                    <div class="col-md-5 ps-5">
                                                        <div class="scrollable-content">
                                                            <p class="twentyeight mt-4">Describe your
                                                                Needs </p>
                                                            <textarea class="form-controles" style="height: 200px;" placeholder="Type..." rows="3"
                                                                name="needs_description" required></textarea>

                                                            <div class="row mt-2">
                                                                <div class="col-9 p-3 rounded-3"
                                                                    style="background-color: #F9F9F9;">
                                                                    <div class="row">
                                                                        <div class="g-recaptcha"
                                                                            data-sitekey="{{ env('RECAPTCHA_KEY') }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between mt-5">
                                                            <button type="button"
                                                                class="whitebtn prev px-5">Back</button>
                                                            <button type="button"
                                                                class="bluebtn  next px-5">Submit</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <img src="{{ asset('web/services/images/popupimg.svg') }}"
                                                            class="img-fluid" alt="...">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Step 7 -->
                                            <div class="step-content step7" id="step7">
                                                <div class="row classcrol">
                                                    <div class="col-md-12 ps-5">
                                                        <div class="">
                                                            <div class="text-center ">
                                                                <img src="{{ asset('web/services/images/image 57.svg') }}"
                                                                    class="w-25" alt="...">
                                                                <p class="eighteen">Sending your
                                                                    request</p>
                                                            </div>


                                                        </div>
                                                        <div class="col-md-5 d-flex justify-content-between mt-5 d-none">

                                                            <button type="button"
                                                                class="whitebtn prev  px-5">Back</button>
                                                            <button type="button"
                                                                class="bluebtn me-5  next px-5">Next</button>

                                                        </div>
                                                    </div>


                                                </div>
                                            </div>

                                            <!-- Step 8 (Final Step) -->
                                            <div class="step-content step8" id="step8">
                                                <div class="row classcrol">
                                                    <div class="col-md-12 ps-5">
                                                        <div class="">
                                                            <div class="text-center ">
                                                                <img src="{{ asset('web/services/images/image (290).svg') }}"
                                                                    class="" style="height: 125px; width:180px"
                                                                    alt="...">
                                                                <p class="eighteen m-0">Your request
                                                                    has been sent</p>
                                                                <p class="twelve">You will receive
                                                                    quote in email and message box </p>
                                                                <a href="{{ route('services.home') }}" type="button"
                                                                    class="btn btn-danger py-2 px-2"
                                                                    style="font-size: 12px;">Find More
                                                                    Auto
                                                                    Services</a>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-5 d-flex justify-content-between mt-5 d-none">

                                                            <button type="button"
                                                                class="whitebtn prev  px-5">Back</button>
                                                            <button type="button"
                                                                class="bluebtn me-5  next px-5">Next</button>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- Steps End -->

                                </div>
                                </form>
                            </div>
                        </div>

                        {{-- request quote modal end --}}
                    @endforeach
                </div>
            </div>
            @endforeach

        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#serviceCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#serviceCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>


    </div>
    </div>
    </div>
    </div>
    <div class="container-fluid imgbak">
        <div class="row">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-11 py-5">
                        <div class="row">
                            <div class="col-md-7 d-flex align-items-center justify-content-center">
                                <div class="row d-flex align-items-center justify-content-center">
                                    <div class="col-10">
                                       <div class="row ">
                                        <div class="col-md-12">
                                            <h1 class="colors">
                                                <strong>Download our mobile app.</strong>
                                            </h1>
                                            <p class="eighteen mt-3">
                                                We are a professional and creative company and we
                                                offer you a trusty insurance on your veicle.
                                            </p>
                                        </div>
                                           <div class="col-md-12 d-flex  align-items-center mt-4">

                                            <a class=" text-start"><img
                                                    src="{{ asset('web/bikes/images/Group111.svg') }}" class="img-fluid " style="width:160px"
                                                    alt="..."></a>
                                            <a class=" text-start ms-3"><img
                                                    src="{{ asset('web/bikes/images/Group1111.svg') }}" style="width:160px"
                                                    class="img-fluid" alt="..."></a>

                                        </div>
                                          </div>
                                      
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <img src="{{ asset('web/bikes/images/newmobile.svg') }}" class="img-fluid"
                                    alt="...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".multiStepForm").forEach((form) => {
                let currentStep = 0;
                const steps = form.querySelectorAll(".step-content");

                function showStep(index) {
                    steps.forEach((step, i) => {
                        step.classList.toggle("active", i === index);
                    });
                }

                function validateStep(step) {
                    // Step 0 validation (vehicle_type)
                    if (step.classList.contains("step0")) {
                        const vehicle = step.querySelector('input[name="vehicle_type"]:checked');
                        const error = step.querySelector("#vehicle-error");
                        if (!vehicle) {
                            if (error) error.style.display = "block";
                            return false;
                        }
                        if (error) error.style.display = "none";

                        fetch(`/get-vehicle-body-type/${vehicle.value}`, {
                                method: "GET",
                                headers: {
                                    Accept: "application/json",
                                    "X-Requested-With": "XMLHttpRequest",
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                        ?.getAttribute("content"),
                                },
                            })
                            .then((response) => response.json())
                            .then((data) => {
                                const bodyTypeContainer = form.querySelector(".step1 .checkbox-group");
                                bodyTypeContainer.innerHTML = `
                            <div id="body_type-error" class="reed mt-2" style="display:none; color:red;">
                                Please select body type
                            </div>
                        `;
                                if (data.body_types?.length) {
                                    data.body_types.forEach((bodyType) => {
                                        const label = document.createElement("label");
                                        label.className = "checkbox-button";

                                        const input = document.createElement("input");
                                        input.type = "radio";
                                        input.name = "body_type";
                                        input.value = bodyType.id;
                                        input.hidden = true;

                                        const span = document.createElement("span");
                                        span.textContent = bodyType.name;

                                        label.appendChild(input);
                                        label.appendChild(span);
                                        bodyTypeContainer.appendChild(label);
                                    });
                                }
                            });
                    }

                    // Step 1 validation (body_type)
                    if (step.classList.contains("step1")) {
                        const body = step.querySelector('input[name="body_type"]:checked');
                        const error = step.querySelector("#body_type-error");
                        if (!body) {
                            if (error) error.style.display = "block";
                            return false;
                        }
                        if (error) error.style.display = "none";

                        const vehicleType = form.querySelector('input[name="vehicle_type"]:checked')?.value;
                        fetch(`/get-vehicle-make/${vehicleType}`, {
                                method: "GET",
                                headers: {
                                    Accept: "application/json",
                                    "X-Requested-With": "XMLHttpRequest",
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                        ?.getAttribute("content"),
                                },
                            })
                            .then((response) => response.json())
                            .then((data) => {
                                const makeContainer = form.querySelector(".step2 .checkbox-group");
                                makeContainer.innerHTML = `
                            <div id="make-error" class="reed mt-2" style="display:none; color:red;">
                                Please select make
                            </div>
                        `;
                                if (data.makes?.length) {
                                    data.makes.forEach((make) => {
                                        const label = document.createElement("label");
                                        label.className = "checkbox-button";

                                        const input = document.createElement("input");
                                        input.type = "radio";
                                        input.name = "vehicle_make";
                                        input.value = make.id;
                                        input.hidden = true;

                                        const span = document.createElement("span");
                                        span.textContent = make.name;

                                        label.appendChild(input);
                                        label.appendChild(span);
                                        makeContainer.appendChild(label);
                                    });
                                }
                            });
                    }

                    // Step 2 validation (make)
                    if (step.classList.contains("step2")) {
                        const make = step.querySelector('input[name="vehicle_make"]:checked');
                        const error = step.querySelector("#make-error");
                        if (!make) {
                            if (error) error.style.display = "block";
                            return false;
                        }
                        if (error) error.style.display = "none";

                        const vehicleType = form.querySelector('input[name="vehicle_type"]:checked')?.value;
                        fetch(`/get-vehicle-model/${vehicleType}/${make.value}`, {
                                method: "GET",
                                headers: {
                                    Accept: "application/json",
                                    "X-Requested-With": "XMLHttpRequest",
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                        ?.getAttribute("content"),
                                },
                            })
                            .then((response) => response.json())
                            .then((data) => {
                                const modelContainer = form.querySelector(".step3 .checkbox-group");
                                modelContainer.innerHTML = `
                            <div id="model-error" class="reed mt-2" style="display:none; color:red;">
                                Please select model
                            </div>
                        `;
                                if (data.models?.length) {
                                    data.models.forEach((model) => {
                                        const label = document.createElement("label");
                                        label.className = "checkbox-button";

                                        const input = document.createElement("input");
                                        input.type = "radio";
                                        input.name = "vehicle_model";
                                        input.value = model.id;
                                        input.hidden = true;

                                        const span = document.createElement("span");
                                        span.textContent = model.name;

                                        label.appendChild(input);
                                        label.appendChild(span);
                                        modelContainer.appendChild(label);
                                    });
                                }
                            });
                    }

                    // Step 3 validation (model)
                    if (step.classList.contains("step3")) {
                        const model = step.querySelector('input[name="vehicle_model"]:checked');
                        const error = step.querySelector("#model-error");
                        if (!model) {
                            if (error) error.style.display = "block";
                            return false;
                        }
                        if (error) error.style.display = "none";
                    }

                    // Step 4 validation (year)
                    if (step.classList.contains("step4")) {
                        const yearInputChecked = step.querySelector('input[name="year"]:checked');
                        const error = step.querySelector("#year-error");

                        if (!yearInputChecked) {
                            if (error) error.style.display = "block";
                            return false;
                        }

                        const yearValue = yearInputChecked.value.trim();
                        const currentYear = new Date().getFullYear();

                        if (+yearValue < 1900 || +yearValue > currentYear) {
                            if (error) error.style.display = "block";
                            return false;
                        } else {
                            if (error) error.style.display = "none";
                        }
                    }

                    // *** New Step 5 validation for services ***
                    if (step.classList.contains("step5")) {
                        const checkedServices = step.querySelectorAll('input[name="services[]"]:checked');
                        let error = step.querySelector("#services-error");

                        // Create error element if it doesn't exist
                        if (!error) {
                            error = document.createElement("div");
                            error.id = "services-error";
                            error.className = "reed mt-2";
                            error.style.color = "red";
                            error.style.display = "none";
                            error.textContent = "Please select at least one service";
                            const checkboxGroup = step.querySelector(".checkbox-group");
                            checkboxGroup.appendChild(error);
                        }

                        if (checkedServices.length === 0) {
                            error.style.display = "block";
                            return false;
                        } else {
                            error.style.display = "none";
                        }
                    }

                    // Step 6 submission
                    if (step.classList.contains("step6")) {
                        const submitBtn = step.querySelector("button.next");
                        if (!submitBtn) return true;

                        submitBtn.disabled = true;
                        submitBtn.innerHTML = "Submitting...";

                        const formData = new FormData(form);
                        const recaptchaResponse = grecaptcha.getResponse();
                        if (recaptchaResponse) formData.append("g-recaptcha-response", recaptchaResponse);

                        currentStep++;
                        showStep(currentStep); // Show loading step

                        fetch("/submit-service-quote", {
                                method: "POST",
                                body: formData,
                                headers: {
                                    Accept: "application/json",
                                    "X-Requested-With": "XMLHttpRequest",
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                        ?.getAttribute("content"),
                                },
                            })
                            .then((response) => response.json())
                            .then((data) => {
                                if (data.success) {
                                    currentStep++;
                                    showStep(currentStep); // Show success step
                                } else {
                                    currentStep = 6;
                                    showStep(currentStep);
                                    alert(data.message);
                                }
                            })
                            .catch(() => {
                                currentStep = 6;
                                showStep(currentStep);
                                alert(
                                    "An error occurred while submitting your request. Please try again."
                                );
                            })
                            .finally(() => {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = "Submit";
                            });

                        return false;
                    }

                    return true;
                }

                // Step navigation
                form.addEventListener("click", function(e) {
                    if (e.target.classList.contains("next")) {
                        const currentStepEl = steps[currentStep];
                        const valid = validateStep(currentStepEl);
                        if (!valid) return;
                        if (currentStep < steps.length - 1 && !currentStepEl.classList.contains(
                                "step6")) {
                            currentStep++;
                            showStep(currentStep);
                        }
                    }

                    if (e.target.classList.contains("prev")) {
                        if (currentStep > 0) {
                            currentStep--;
                            showStep(currentStep);
                        }
                    }
                });

                // Styling selected options and hiding errors on change
                form.addEventListener("change", function(e) {
                    if (e.target.matches(
                            '.checkbox-button input[type="radio"], .checkbox-button input[type="checkbox"]'
                        )) {
                        const input = e.target;
                        const name = input.getAttribute("name");

                        if (input.type === "radio") {
                            form.querySelectorAll(`input[name="${name}"] + span`).forEach((
                                span) => {
                                span.style.backgroundColor = "white";
                                span.style.color = "#A7A7A7";
                                span.style.borderColor = "#A7A7A7";
                            });
                        }

                        const span = input.nextElementSibling;
                        if (input.checked) {
                            span.style.backgroundColor = "#281F48";
                            span.style.color = "white";
                            span.style.borderColor = "#281F48";
                        } else {
                            span.style.backgroundColor = "white";
                            span.style.color = "#A7A7A7";
                            span.style.borderColor = "#A7A7A7";
                        }

                        // Hide specific errors when selecting input
                        if (input.name === "vehicle_make") {
                            const error = form.querySelector("#make-error");
                            if (error) error.style.display = "none";
                        }
                        if (input.name === "vehicle_model") {
                            const error = form.querySelector("#model-error");
                            if (error) error.style.display = "none";
                        }
                        if (input.name === "body_type") {
                            const error = form.querySelector("#body_type-error");
                            if (error) error.style.display = "none";
                        }
                        if (input.name === "vehicle_type") {
                            const error = form.querySelector("#vehicle-error");
                            if (error) error.style.display = "none";
                        }
                        if (input.name === "services[]") {
                            const error = form.querySelector("#services-error");
                            if (error) error.style.display = "none";
                        }
                    }

                    // Hide year error on input change
                    if (e.target.name === "year") {
                        const error = form.querySelector("#year-error");
                        if (error) error.style.display = "none";
                    }
                });

                // Show the first step on load
                showStep(currentStep);
            });
        });
    </script>
<!-- jQuery Toggle Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.getElementById('toggleServices').addEventListener('click', function() {
            const extraItems = document.querySelectorAll('.extra-service');
            extraItems.forEach(item => item.classList.toggle('d-none'));

            // Toggle link text
            if (this.innerText.trim() === 'View all') {
                this.innerHTML = 'View less';
            } else {
                this.innerHTML = 'View all';
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            $('.select2-city-search').select2({
                placeholder: "Select City",
                allowClear: true
                
            });
        });
    $(document).ready(function () {
        let isExpanded = false;
        

        $('#toggleServices').click(function () {
            if (!isExpanded) {
                $('.extra-service').show(); // Show hidden categories
                $(this).text('View less');
            } else {
                $('.extra-service').each(function(index) {
                    if (index >= 10) $(this).hide(); // Hide again
                });
                $(this).text('View all');
            }
            isExpanded = !isExpanded;
        });
    });
</script>
    </script>
@endsection
