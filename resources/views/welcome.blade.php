@extends('layout.website_layout.bikes.car_main')
@section('content')
@section('title', 'Auto Jazeera - Home')
<link rel="stylesheet" href="{{ asset('web/bikes/css/bike_home.css') }}">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    body {
        font-family: 'poppins', sans-serif !important;
    }

    .carousel-indicators .active {
        opacity: 1;

        background-color: #D90600 !important;
    }

    .select2-container--default .select2-selection--single {
        width: 160px !important;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 40px;
        /* Adjust size */
        height: 40px;
        background-color: #281F48;
        /* Dark background */
        border-radius: 50%;
        /* Circular shape */
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 1;
        /* Full visibility */
        position: absolute;
        top: 50%;
        /* Center vertically */
        transform: translateY(-50%);
        /* Adjust vertical alignment */
        z-index: 10;
    }

    body {
        background-color: #FBFBFB !important;
    }

    .carousel-control-prev {
        left: -10px;
        /* Move left */
    }

    .carousel-control-next {
        right: -10px;
        /* Move right */
    }

    #goToTop,
    #goToBottom {
        position: fixed;
        right: 20px;
        padding: 10px;
        padding-left: 15px;
        padding-right: 15px;
        font-size: 20px;
        background-color: #F40000 !important;
        ;
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
        background-color: #F40000 !important;
        ;
    }

    /* Show buttons with fade-in effect */
    #goToTop.show,
    #goToBottom.show {
        opacity: 1;
        visibility: visible;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 15px;
        /* Adjust arrow size */
        height: 15px;
        filter: brightness(0) invert(1);
        /* Make arrows white */
    }


    .crouserheading {
        color: #281F48;
        font-size: 35px;
        padding-left: 100px;
        padding-top: 70px;
        font-weight: 800;
    }

    .crouserheading1 {
        color: #281F48;
        font-size: 36px;
        padding-left: 100px;
        padding-top: 100px;
        font-weight: 800;
    }

    .carousel-indicators [data-bs-target] {
        box-sizing: content-box;
        flex: 0 1 auto;
        width: 20px;
        height: 20px;
        padding: 0;
        margin-right: 3px;
        margin-left: 9px;
        text-indent: -999px;
        cursor: pointer;
        background-color: #D6D6D6;
        background-clip: padding-box;
        border: 0;
        border-top: 10px solid transparent;
        border-bottom: 10px solid transparent;
        opacity: .5;
        transition: opacity .6s ease;
        border-radius: 50%;
    }

    .form-select {
        --bs-form-select-bg-img: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e);
        display: block;
        width: 100%;
        padding: .375rem 2.25rem .375rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: var(--bs-body-color);
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-color: #F0F3F6;
        background-image: var(--bs-form-select-bg-img), var(--bs-form-select-bg-icon, none);
        background-repeat: no-repeat;
        background-position: right .75rem center;
        background-size: 16px 12px;
        border: var(--bs-border-width) solid var(--bs-border-color);
        border-radius: var(--bs-border-radius);
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        text-align: start !important;
    }

    .eighteenorange {
        font-weight: 500;
    }

    .crouserpara {
        color: #281F48;
        padding-left: 100px;
    }

    .paddingthis {
        padding-left: 100px;
        padding-top: 30px;
    }

    .navbar {
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .twentyfourblack {
        color: black !important;
        font-size: 24px;
        font-weight: 700;
    }

    #customCarousel {
        background-image: url('/web/images/backimgrola.svg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 450px;
    }

    .custom-select-icon select {
        padding-left: 2.5rem !important;
        /* Adjust padding to make room for the icon */
        font-size: 13.5px;
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
        margin-left: 10px
    }

    .dropdown-toggle::after {
        display: none !important;
        /* Hide default Bootstrap arrow */
    }

    .dropdown-toggle i {
        font-size: 0.8rem;
        margin-left: 5px;
    }

    .btn-light {
        --bs-btn-color: #000;
        --bs-btn-bg: #F0F3F6;
        --bs-btn-border-color: #F0F3F6;
        --bs-btn-hover-color: #000;
        --bs-btn-hover-bg: #d3d4d5;
        --bs-btn-hover-border-color: #c6c7c8;
        --bs-btn-focus-shadow-rgb: 211, 212, 213;
        --bs-btn-active-color: #000;
        --bs-btn-active-bg: #c6c7c8;
        --bs-btn-active-border-color: #babbbc;
        --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        --bs-btn-disabled-color: #000;
        --bs-btn-disabled-bg: #f8f9fa;
        --bs-btn-disabled-border-color: #f8f9fa;
    }

    .btn-check:checked+.btn,
    .btn.active,
    .btn.show,
    .btn:first-child:active,
    :not(.btn-check)+.btn:active {
        color: var(--bs-btn-active-color);
        background-color: #F0F3F6;
        border-color: #F0F3F6;
    }

    .btn-check:checked+.btn,
    .btn.active,
    .btn.show,
    .btn:first-child:active,
    :not(.btn-check)+.btn:active {
        color: var(--bs-btn-active-color);
        background-color: #F0F3F6;
        border-color: #F0F3F6;
    }

    @media (min-width: 992px) {
        .col-lg-1-1 {
            flex: 0 0 auto;
            width: 11.111111%;
        }
    }

    @media (min-width: 300px) and (max-width: 700px) {

        .crouserheading1 {
            color: #281F48;
            font-size: 24px;
            padding-left: 0px;
            text-align: center;
            padding-top: 50px;
            font-weight: 800;
        }

    }
</style>

<style>
    .select2-container--default .select2-selection--single {
        border-radius: 8px !important;
        background-color: #F0F3F6 !important;
        border: 0px !important;
        height: 34px !important;
        padding-top: 3px;
        padding-left: 2rem !important;
        box-shadow: none !important;
        color: #281F48 !important;
    }

    .custom-select-icon img {
        position: absolute;
        top: 50%;
        left: 0.5rem;
        font-size: 14px;
        transform: translateY(-50%);
        pointer-events: none;
        color: black;
        z-index: 999;
    }

    /* Also make dropdown match rounded corners */
    .select2-container--default .select2-dropdown {
        border-radius: 8px !important;
        border: 1px solid #ccc !important;
        overflow: hidden !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: black !important;
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<div class="container-fluid  ">
    <div class="row">

        <div id="customCarousel" class="carousel slide p-0" data-bs-wrap="false">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-11 col-12">
                                    <p class="crouserheading1">Looking for the perfect car to match your needs?</p>

                                    <div class="paddingthis">
                                        <a style="color:white" href="#"
                                            onclick="document.getElementById('searchBtn').click()">
                                            <div class="search-box">
                                                <i style="color:white" class="fa fa-search me-3"></i>
                                                Search a Car
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <img src="{{ asset('web/bikes/images/image 51.svg') }}" class=" w-100  pt-0 pt-md-5"
                                alt="Slide 2">
                        </div>
                    </div>
                </div>
                <div class="carousel-item ">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-11 col-12">
                                    <p class="crouserheading1">Looking for the perfect bike to match your needs?</p>

                                    <div class="paddingthis">
                                        <a style="color:white" href="#"
                                            onclick="document.getElementById('searchBtn').click()">
                                            <div class="search-box">
                                                <i style="color:white" class="fa fa-search me-3"></i>
                                                Search a Bike
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <img src="{{ asset('web/bikes/images/Group 1171275384.svg') }}" class="d-block w-75 imgcrs"
                                alt="Slide 3">
                        </div>
                    </div>

                </div>
                <div class="carousel-item ">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-11 col-12">
                                    <p class="crouserheading1">
                                        Quality Auto Services Reliable, Professional, On Time
                                    </p>

                                    <div class="paddingthis">
                                        <a style="color: white" href="#"
                                            onclick="document.getElementById('searchBtn').click()">
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

            </div>

            <div class="carousel-indicators">
                <button type="button" data-bs-target="#customCarousel" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#customCarousel" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#customCarousel" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
        </div>

    </div>
    {{--

<div class="container ">
<div class="row">
   <div class="col-md-12">
                <p class="twentyfourblack" style="color:#281F48 !important"><strong>Quick filters</strong></p>
            </div></div>
    <div class=" p-3 rounded-1" style="background-color: #F0F3F6;">
        <div class="row g-2 align-items-center justify-content-between">

            <!-- Vehicle Type -->
            <div class="col-auto">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                         <img src="{{ asset('web/bikes/images/Group12.svg') }}" class="me-2 img-fluid"> Vehicle Type <i class="bi bi-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Car</a></li>
                        <li><a class="dropdown-item" href="#">Bike</a></li>
                        <li><a class="dropdown-item" href="#">Truck</a></li>
                    </ul>
                </div>
            </div>

            <!-- Body Type -->
            <div class="col-auto">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                         <img src="{{ asset('web/bikes/images/Group12.svg') }}" class="me-2 img-fluid"> Body Type <i class="bi bi-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Sedan</a></li>
                        <li><a class="dropdown-item" href="#">SUV</a></li>
                        <li><a class="dropdown-item" href="#">Coupe</a></li>
                    </ul>
                </div>
            </div>

            <!-- Model -->
            <div class="col-auto">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <img src="{{ asset('web/bikes/images/Frame 1000002928.svg') }}" class="me-2 img-fluid"> Model <i class="bi bi-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">2023</a></li>
                        <li><a class="dropdown-item" href="#">2022</a></li>
                    </ul>
                </div>
            </div>

            <!-- Make -->
            <div class="col-auto">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                         <img src="{{ asset('web/bikes/images/Frame 1000002929.svg') }}" class="me-2 img-fluid"> Make <i class="bi bi-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Toyota</a></li>
                        <li><a class="dropdown-item" href="#">Honda</a></li>
                    </ul>
                </div>
            </div>

            <!-- Province -->
            <div class="col-auto">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <img src="{{ asset('web/bikes/images/Group 2680.svg') }}" class="me-2 img-fluid"> Province <i class="bi bi-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Punjab</a></li>
                        <li><a class="dropdown-item" href="#">Sindh</a></li>
                    </ul>
                </div>
            </div>

            <!-- City -->
            <div class="col-auto">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                             <img src="{{ asset('web/bikes/images/Group 2680.svg') }}" class="me-2 img-fluid"> City <i class="bi bi-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Lahore</a></li>
                        <li><a class="dropdown-item" href="#">Karachi</a></li>
                    </ul>
                </div>
            </div>

            <!-- Search Button -->
            <div class="col-auto">
                <button class="btn btn-danger px-4">Search</button>
            </div>

        </div>
    </div>
</div>
</div> --}}

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p class="twentyfourblack" style="color:#281F48 !important ;    font-weight: 500;"><strong>Quick filters</strong></p>
            </div>
            <div class="col-lg-12">
                <form method="post"
                    @if (Request::is('superadmin/*')) action="{{ route('superadmin.search') }}" @else  action="{{ route('search') }}" @endif
                    class="p-2" style="background-color: #F0F3F6; border-radius: 5px;">
                    @csrf

                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <div class="custom-select-icon flex-grow-1">
                            <img src="{{ asset('web/bikes/images/Group12.svg') }}" class="me-2 img-fluid">
                            <select id="condition" name="condition" style="width:160px !important;"
                                class="form-select condition-select2">
                                <option value="">Condition</option>
                                <option value="1e">Any</option>
                                <option value="new">New Cars</option>
                                <option value="used">Used Cars</option>
                            </select>
                        </div>

                        <div class="custom-select-icon flex-grow-1">
                            <img src="{{ asset('web/bikes/images/Group12.svg') }}" class="me-2 img-fluid">
                            <select id="bodyType" name="bodytype" style="width:140px !important;"
                                class="form-select body-type-select2">
                                <option value="">Body Type</option>
                                <option value="1e">Any</option>
                                @foreach ($bodytypes as $bodytype)
                                    <option value="{{ $bodytype->id }}">{{ $bodytype->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="custom-select-icon flex-grow-1">
                            <img src="{{ asset('web/bikes/images/Frame 1000002928.svg') }}" class="me-2 img-fluid">
                            <select id="makecompanydata" name="make" style="width:150px !important;"
                                class="form-select make-select2">
                                <option value="">Make</option>
                                <option value="1e">Any</option>
                                @foreach ($makes as $make)
                                    <option value="{{ $make->id }}">{{ $make->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="custom-select-icon flex-grow-1">
                            <img src="{{ asset('web/bikes/images/Frame 1000002929.svg') }}" class="me-2 img-fluid">
                            <select id="model" name="model" style="width:150px !important;"
                                class="form-select model-select2">
                                <option value="">Model</option>
                                <option value="1e">Any</option>
                            </select>
                        </div>

                        <div class="custom-select-icon flex-grow-1">
                            <img src="{{ asset('web/bikes/images/Group 2680.svg') }}" class="me-2 img-fluid">
                            <select id="province" name="province" style="width:150px !important;"
                                class="form-select province-select2">
                                <option value="">Province</option>
                                <option value="1e">Any</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="custom-select-icon flex-grow-1">
                            <img src="{{ asset('web/bikes/images/Group 2680.svg') }}" class="me-2 img-fluid">
                            <select id="city" name="city" style="width:150px !important;"
                                class="form-select city-select2">
                                <option value="">City</option>
                                <option value="1e">Any</option>
                            </select>
                        </div>

                        <div class="text-end flex-grow-1" style="z-index: 1000000000000000;">
                            <input type="submit" name="search" class="btn btn-danger w-100"
                                style="background-color:#F40000 !important; " value="Search"id="searchBtn">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="row">
                    <div class="col-md-3 col-6 p-3" data-aos="fade-down">
                        <a href="{{ url('cars/new') }}" style="cursor: pointer">
                            <div class="row">
                                <div class="col-12">
                                    <img src="{{ asset('web/bikes/images/Frame 25 (30).svg') }}" class="img-fluid"
                                        alt="...">
                                    <p class="mt-2 text-center eighteenorange">New Cars</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-6 p-3" data-aos="fade-right">
                        <a href="{{ url('cars/used') }}" style="cursor: pointer">
                            <div class="row">
                                <div class="col-12">
                                    <img src="{{ asset('web/bikes/images/Frame 25 (1).svg') }}" class="img-fluid"
                                        alt="...">
                                    <p class="mt-2 text-center eighteenorange">Used Cars</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-6 p-3" data-aos="fade-down">
                        <a href="{{ url('bikes/new') }}" style="cursor: pointer">
                            <div class="row">
                                <div class="col-12">
                                    <img src="{{ asset('web/bikes/images/Frame 25 (2).svg') }}" class="img-fluid"
                                        alt="...">
                                    <p class="mt-2 text-center eighteenorange">New Bikes</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-6 p-3" data-aos="fade-right">
                        <a href="{{ url('bikes/used') }}" style="cursor: pointer">
                            <div class="row">
                                <div class="col-12">
                                    <img src="{{ asset('web/bikes/images/Frame 25 (3).svg') }}" class="img-fluid"
                                        alt="...">
                                    <p class="mt-2 text-center  eighteenorange">Used Bikes</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 mt-4 d-flex align-items-center justify-content-between">
                <p class="twentyfourblack m-0 p-0" style="color:#281F48 !important">Cars by Body Type</p>
                <h6>
                    <a href="javascript:void(0)" id="viewBodyToggle" style="color: #281F48;"
                        class="view"><strong>View
                            All</strong></a>
                </h6>
            </div>

            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-5 m-0" id="bodytypesContainer">
                @foreach ($bodytypes as $key => $bodytype)
                    <div class="col mt-0 text-center {{ $key >= 10 ? 'd-none extra-body' : '' }}"
                        data-aos="{{ $key % 2 == 0 ? 'fade-right' : 'fade-down' }}">
                        <div class="card border-0 bg-transparent align-items-center justify-content-center m-0 p-0">
                            <a
                                href="{{ Request::is('superadmin/*')
                                    ? route('superadmin.search_data', ['id' => $bodytype->id, 'type' => 'bodytype'])
                                    : route('search_data', ['id' => $bodytype->id, 'type' => 'bodytype']) }}">
                                <img src="{{ isset($bodytype->icon) ? asset('posts/bodytypes/' . $bodytype->icon) : asset('web/images/sedan.png') }}"
                                    class="text-center heightt" alt="Body Type Icon">
                            </a>
                            <div class="card-body p-0">
                                <h6 class="card-title m-0 p-0">{{ $bodytype->name }}</h6>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>



    <div class="container mt-4">
        <div class="d-flex  justify-content-between">
            <p class="twentyfourblack m-0 mb-5 p-0" style="color:#281F48 !important">Search By Make</p>
            <h6>
                <a href="javascript:void(0)" id="viewAllToggle" style="color: #281F48;"
                    class="view mb-5"><strong>View
                        All</strong></a>
            </h6>
        </div>

        <div class="row g-4" id="makesContainer">
            @foreach ($makes as $key => $make)
                <div class="col-4 col-md-2 col-lg-1-1 text-center make-item d-flex justify-content-center 
            {{ $key >= 9 ? 'd-none extra-make' : '' }}"
                    data-aos="{{ $key % 2 == 0 ? 'fade-down' : 'fade-right' }}">
                    <a
                        href="{{ Request::is('superadmin/*')
                            ? route('superadmin.search_data', ['id' => $make->id, 'type' => 'make'])
                            : route('search_data', ['id' => $make->id, 'type' => 'make']) }}">
                        <div class="bg-transparent border-0 card">
                            <img src="{{ isset($make->icon) ? asset('posts/makes/' . $make->icon) : asset('web/images/toyota-ICON.png') }}"
                                class="card-img-top" alt="Make Icon">
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

    </div>


    <div class="container mt-4 mb-2" data-aos="fade-down">
        <p class="twentyfourblack" style="color:#281F48 !important">Search By Price</p>

        <form method="post"
            @if (Request::is('superadmin/*')) action="{{ route('superadmin.check-price-range') }}" @else action="{{ route('check-price-range') }}" @endif>
            @csrf


            <div class="row align-items-center">
                <div class="col-lg-3 col-12">
                    <div class="slider">
                        <div class="progress"></div>
                    </div>
                    <div class="range-input">
                        <input type="range" class="range-min" min="0" max="60000000" value="0"
                            step="10000">
                        <input type="range" class="range-max" min="0" max="60000000" value="60000000"
                            step="10000">
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="price-input">
                        <div class="field">
                            <span>Min</span>
                            <input type="number" class="input-min" value="0" id="minPrice" name="min"
                                min="0" max="60000000">
                        </div>
                        <div class="separator">-</div>
                        <div class="field">
                            <span>Max</span>
                            <input type="number" class="input-max" value="60000000" id="maxPrice" name="max"
                                min="0" max="60000000">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <button type="submit" class="py-2 rounded btn custom-btn w-100"
                        style="background-color: #F40000;color: white;font-size: 17px;">Search</button>
                </div>

            </div>
        </form>

    </div>
    <div class="container ">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center mb-3">
                <span class="twentyfourblack" style="color:#281F48 !important ;font-size:24px !important;">Recent
                    featured new cars</span>
                <span>
                    <a href="{{ url('cars/new') }}"
                        style="font-size: 14px; font-weight: 600; text-decoration: none; color: #281F48;">View all</a>
                </span>
            </div>

            <div id="featuredCarousel" style="min-height:500px !important" class="carousel slide"
                data-bs-ride="carousel">
                <div class="carousel-inner">
                    @if (count($featured_new_posts) == 0)
                        <div class="col-md-12 mt-5 pt-5">
                            <div class="row d-flex mt-5 justify-content-center my-3">
                                <div class="p-3 col-8" style="border:1px solid #281F48;border-radius:9px;">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-3">
                                            <img src="{{ asset('web/images/noinputs.svg') }}" alt=""
                                                class="img-fluid" srcset="">
                                        </div>
                                        <div class="col-9 text-start">

                                            <p class="m-0">No recent featured new cars found </p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @foreach ($featured_new_posts->chunk(3) as $chunkIndex => $chunk)
                        <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}" style="    height: 475px;">
                            <div class="row">
                                @foreach ($chunk as $key => $post)
                                    <div class="col-lg-4 mt-3 car"
                                        data-aos="{{ $key % 2 == 0 ? 'fade-right' : 'fade-up' }}"
                                        data-longitude="{{ $post->longitude }}"
                                        data-latitude="{{ $post->latitude }}" style="cursor: pointer"
                                        onclick="location.href='{{ Request::is('superadmin/*') ? route('superadmin.cardetail', $post->id) : route('cardetail', $post->id) }}'">
                                        <div class="wishlist-card ddd rounded-5">
                                            <div class="img-bg-home" style="position: relative">
                                                <?php $main = $post->document->first(); ?>
                                                <img src="{{ url('posts/doc/' . $main->doc_name) }}"
                                                    class="img-adj-card"
                                                    style="height: 200px; border-radius:25px 25px 0px 0px">

                                                @if ($post->feature_ad == 1)
                                                    <span class="featureicn">
                                                        <img src="{{ asset('web/bikes/images/Star 7.svg') }}"
                                                            class="img-fluid">
                                                        Featured</span>
                                                @endif
                                            </div>
                                            <div class="py-lg-3 px-lg-4 p-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 style="color: #281F48;">{{ $post->year ?? 'N/A' }}</h6>
                                                </div>
                                                <h4 style="color: #281F48;"><strong>{{ $post->modelname }}</strong>
                                                </h4>
                                                <h5 style="color: #FD5631;"><b>PKR
                                                        {{ number_format($post->price, 2) }}</b></h5>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0" style="color: #281F48;">
                                                        <i class="bi bi-geo-alt"></i>
                                                        {{ $post->location->cityname ?? '' }} <span
                                                            class="distance">calculating...</span>
                                                    </h6>
                                                    <span style="font-size:14px; color: #281F48;">
                                                        Last Updated:
                                                        {{ \Carbon\Carbon::parse($post->updated_at)->format('F d, Y') }}
                                                    </span>
                                                </div>
                                                <hr class="m-0 mt-2">
                                                <div class="row">
                                                    <div class="col-4 my-3">
                                                        <div class="text-center py-1"
                                                            style="background-color:#D6D6D6; border-radius: 10px;">
                                                            <i class="bi bi-speedometer2 fs-4"
                                                                style="color: #281F48;"></i>
                                                            @php
                                                                $mileage = (float) $post->milleage;
                                                                if ($mileage >= 1000000) {
                                                                    // For values in millions, display 'M'
                                                                    $formattedMileage =
                                                                        rtrim(
                                                                            number_format($mileage / 1000000, 1),
                                                                            '.0',
                                                                        ) . 'M';
                                                                } elseif ($mileage >= 1000) {
                                                                    // For values in thousands, display 'K'
                                                                    $formattedMileage =
                                                                        rtrim(number_format($mileage / 1000, 1), '.0') .
                                                                        'K';
                                                                } else {
                                                                    // For values less than 1000, display the raw number
                                                                    $formattedMileage = $mileage;
                                                                }
                                                            @endphp
                                                            <p class="cardp m-0">{{ $formattedMileage ?? 'N/A' }} Km
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 my-3">
                                                        <div class="text-center py-1"
                                                            style="background-color:#D6D6D6; border-radius: 10px;">
                                                            <i class="bi bi-car-front-fill fs-4"
                                                                style="color: #281F48;"></i>
                                                            <p class="cardp m-0">{{ $post->transmission ?? 'N/A' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 my-3">
                                                        <div class="text-center py-1"
                                                            style="background-color:#D6D6D6; border-radius: 10px;">
                                                            <i class="bi bi-fuel-pump-diesel fs-4"
                                                                style="color: #281F48;"></i>
                                                            <p class="cardp m-0">{{ $post->fuel ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#featuredCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#featuredCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

        </div>

        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center mb-3">
                <span class="twentyfourblack" style="color:#281F48 !important ; font-size:24px !important;">Recent
                    featured used cars</span>
                <span>
                    <a href="{{ url('cars/used') }}"
                        style="font-size: 14px; font-weight: 600; text-decoration: none; color: #281F48; ">View all</a>
                </span>
            </div>

            <div id="featuredCarousels" style="min-height:500px !important" class="carousel slide"
                data-bs-ride="carousel">
                <div class="carousel-inner">
                    @if (count($featured_used_posts) == 0)
                        <div class="col-md-12 mt-5 pt-5">
                            <div class="row mt-5 d-flex justify-content-center my-3">
                                <div class="p-3 col-8" style="border:1px solid #281F48;border-radius:9px;">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-3">
                                            <img src="{{ asset('web/images/noinputs.svg') }}" alt=""
                                                class="img-fluid" srcset="">
                                        </div>
                                        <div class="col-9 text-start">

                                            <p class="m-0">No recent featured used cars found </p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @foreach ($featured_used_posts->chunk(3) as $chunkIndex => $chunk)
                        <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}" style="    height: 475px;">
                            <div class="row">
                                @foreach ($chunk as $key => $post)
                                    <div class="col-lg-4 mt-3 car"
                                        data-aos="{{ $key % 2 == 0 ? 'fade-right' : 'fade-up' }}"
                                        data-longitude="{{ $post->longitude }}"
                                        data-latitude="{{ $post->latitude }}" style="cursor: pointer"
                                        onclick="location.href='{{ Request::is('superadmin/*') ? route('superadmin.cardetail', $post->id) : route('cardetail', $post->id) }}'">
                                        <div class="wishlist-card ddd rounded-5">
                                            <div class="img-bg-home" style="position: relative">
                                                <?php $main = $post->document->first(); ?>
                                                <img src="{{ url('posts/doc/' . $main->doc_name) }}"
                                                    class="img-adj-card"
                                                    style="height: 200px;border-radius:25px 25px 0px 0px">
                                                @if ($post->feature_ad == 1)
                                                    <span class="featureicn">
                                                        <img src="{{ asset('web/bikes/images/Star 7.svg') }}"
                                                            class="img-fluid">
                                                        Featured</span>
                                                @endif
                                            </div>
                                            <div class="py-lg-3 px-lg-4 p-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 style="color: #281F48;">{{ $post->year ?? 'N/A' }}</h6>
                                                </div>
                                                <h4 style="color: #281F48;"><strong>{{ $post->modelname }} </strong>
                                                </h4>
                                                <h5 style="color: #FD5631;"><b>PKR
                                                        {{ number_format($post->price, 2) }}</b></h5>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0" style="color: #281F48;">
                                                        <i class="bi bi-geo-alt"></i>
                                                        {{ $post->location->cityname ?? '' }} <span
                                                            class="distance">calculating...</span>
                                                    </h6>
                                                    <span style="font-size:14px; color: #281F48;">
                                                        Last Updated:
                                                        {{ \Carbon\Carbon::parse($post->updated_at)->format('F d, Y') }}
                                                    </span>
                                                </div>
                                                <hr class="m-0 mt-2">
                                                <div class="row">
                                                    <div class="col-4 my-3">
                                                        <div class="text-center py-1"
                                                            style="background-color:#D6D6D6; border-radius: 10px;">
                                                            <i class="bi bi-speedometer2 fs-4"
                                                                style="color: #281F48;"></i>
                                                            <p class="cardp m-0">
                                                                {{ (float) $post->milleage >= 1000
                                                                    ? rtrim(number_format((float) $post->milleage / 1000, 1), '.0') . 'KM'
                                                                    : (float) $post->milleage }}
                                                                Km
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 my-3">
                                                        <div class="text-center py-1"
                                                            style="background-color:#D6D6D6; border-radius: 10px;">
                                                            <i class="bi bi-car-front-fill fs-4"
                                                                style="color: #281F48;"></i>
                                                            <p class="cardp m-0">{{ $post->transmission ?? 'N/A' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 my-3">
                                                        <div class="text-center py-1"
                                                            style="background-color:#D6D6D6; border-radius: 10px;">
                                                            <i class="bi bi-fuel-pump-diesel fs-4"
                                                                style="color: #281F48;"></i>
                                                            <p class="cardp m-0">{{ $post->fuel ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Fixed Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#featuredCarousels"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#featuredCarousels"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
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
                            <div class="row  d-flex align-items-center justify-content-center">
                                <div class="col-10 ">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <h1 style="color: #281F48;" data-aos="fade-right"><strong>Download our
                                                    mobile
                                                    app.</strong>
                                            </h1>
                                            <p class="eighteenorange mt-3" data-aos="fade-right">From Auto to Auto Service — Pakistan’s Smart Platform.
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
										       <div class="col-md-12 d-flex  align-items-center mt-4">

                                          <img
                                                    src="{{ asset('web/bikes/images/Coming_Soon.svg') }}" class="img-fluid " style="width:160px"
                                                    alt="...">
												   </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 " data-aos="fade-right">
                            <img src="{{ asset('web/bikes/images/mobileauto.svg') }}" class="img-fluid"
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
        var carouselElement = document.querySelector("#customCarousel");
        var carousel = new bootstrap.Carousel(carouselElement, {
            interval: 5000, // Slide every 5 seconds
            ride: false // Prevent automatic cycling
        });

        var searchInputs = document.querySelectorAll(".search-box input"); // Select all input fields

        searchInputs.forEach(function(input) {
            input.addEventListener("focus", function() {
                console.log("Input field focused - Carousel Paused");
                carousel.pause();
            });

            input.addEventListener("click", function(event) {
                event.stopPropagation(); // Prevent accidental carousel resume
            });
        });

        document.addEventListener("click", function(event) {
            if (![...searchInputs].some(input => input.contains(event.target))) {
                console.log("Clicked outside - Carousel Resumed");
                carousel.cycle();
            }
        });
    });
</script>

<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script src="{{ asset('web/bikes/js/bike_home.js') }}"></script>

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
    document.getElementById('makecompanydata').addEventListener('change', function() {
        var makeId = this.value;
        //alert(makeId);
        var modelSelect = document.getElementById('model');

        // Clear the current city options
        modelSelect.innerHTML = '<option value="" selected>Select Model</option>';

        // Fetch cities based on selected province
        if (makeId) {
            fetch(`/getmodels/${makeId}`)
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


    document.getElementById("model").addEventListener("mouseenter", function() {
        var makeSelect = document.getElementById("makecompanydata");
        if (!makeSelect.value) {
            this.querySelector('option[value=""]').textContent = "Select Make First";
        }
    });
    document.getElementById("model").addEventListener("mouseleave", function() {
        var makeSelect = document.getElementById("makecompanydata");
        if (!makeSelect.value) {
            this.querySelector('option[value=""]').textContent = "Select Model";
        }
    });
    document.getElementById("city").addEventListener("mouseenter", function() {
        var makeSelect = document.getElementById("province");
        if (!makeSelect.value) {
            this.querySelector('option[value=""]').textContent =
                "Select Province First";
        }
    });
    document.getElementById("city").addEventListener("mouseleave", function() {
        var makeSelect = document.getElementById("province");
        if (!makeSelect.value) {
            this.querySelector('option[value=""]').textContent = "Select City";
        }
    });
</script>
<script>
    document.getElementById('viewAllToggle').addEventListener('click', function() {
        var hiddenItems = document.querySelectorAll('.extra-make');
        hiddenItems.forEach(function(item) {
            item.classList.toggle('d-none');
        });

        // Optional: Change button text between View All and View Less
        if (this.innerText.trim() === 'View All') {
            this.innerHTML = '<strong>View Less</strong>';
        } else {
            this.innerHTML = '<strong>View All</strong>';
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.condition-select2').select2({
            // minimumResultsForSearch: Infinity,
            placeholder: "Condition",
            dropdownAutoWidth: true,
            width: '100%'
        });

        $('.body-type-select2').select2({
            placeholder: "Body Type",
            allowClear: true,
            width: '100%'
        });

        $('.make-select2').select2({
            placeholder: "Make",
            allowClear: true,
            width: '100%'
        });

        $('.model-select2').select2({
            placeholder: "Model",
            allowClear: true,
            width: '100%'
        });

        $('.province-select2').select2({
            placeholder: "Province",
            allowClear: true,
            width: '100%'
        });

        $('.city-select2').select2({
            placeholder: "City",
            allowClear: true,
            width: '100%'
        });

        // Province -> City dependent
        $('#province').on('change', function() {
            const provinceId = $(this).val();
            const citySelect = $('#city');
            citySelect.empty().append('<option value="">Select City</option>');

            if (provinceId) {
                $.get('/getCities/' + provinceId, function(data) {
                    data.forEach(city => {
                        citySelect.append(
                            `<option value="${city.id}">${city.name}</option>`);
                    });
                    citySelect.trigger('change.select2');
                });
            }
        });

        // Make -> Model dependent
        $('#makecompanydata').on('change', function() {
            const makeId = $(this).val();
            const modelSelect = $('#model');
            modelSelect.empty().append('<option value="">Select Model</option>');

            if (makeId) {
                $.get('/getmodels/' + makeId, function(data) {
                    data.forEach(model => {
                        modelSelect.append(
                            `<option value="${model.id}">${model.name}</option>`);
                    });
                    modelSelect.trigger('change.select2');
                });
            }
        });

        // Hover logic for Model (depends on Make)
        $('#model').parent().on('mouseenter', function() {
            const makeValue = $('#makecompanydata').val();
            const select2Display = $('#model').next('.select2-container').find(
                '.select2-selection__rendered');
            if (!makeValue) {
                select2Display.data('original', select2Display.text()); // store original text
                select2Display.text('Select Make First');
            }
        }).on('mouseleave', function() {
            const makeValue = $('#makecompanydata').val();
            const select2Display = $('#model').next('.select2-container').find(
                '.select2-selection__rendered');
            const originalText = select2Display.data('original');
            if (!makeValue && originalText) {
                select2Display.text(originalText);
            }
        });

        // Hover logic for City (depends on Province)
        $('#city').parent().on('mouseenter', function() {
            const provinceValue = $('#province').val();
            const select2Display = $('#city').next('.select2-container').find(
                '.select2-selection__rendered');
            if (!provinceValue) {
                select2Display.data('original', select2Display.text());
                select2Display.text('Select Province First');
            }
        }).on('mouseleave', function() {
            const provinceValue = $('#province').val();
            const select2Display = $('#city').next('.select2-container').find(
                '.select2-selection__rendered');
            const originalText = select2Display.data('original');
            if (!provinceValue && originalText) {
                select2Display.text(originalText);
            }
        });
    });


    document.getElementById('viewBodyToggle').addEventListener('click', function() {
        var hiddenItems = document.querySelectorAll('.extra-body');
        hiddenItems.forEach(function(item) {
            item.classList.toggle('d-none');
        });

        // Change button text between View All and View Less
        if (this.innerText.trim() === 'View All') {
            this.innerHTML = '<strong>View Less</strong>';
        } else {
            this.innerHTML = '<strong>View All</strong>';
        }
    });
</script>

@endsection
