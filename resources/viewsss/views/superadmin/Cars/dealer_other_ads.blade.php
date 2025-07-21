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
            background-color: red;
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

        .select2-container--default .select2-search--dropdown .select2-search__field {
            padding: 10px 20px;
            font-size: 14px;
            background: .select2-search--dropdown;
            background: #282435;
            border-radius: 5px;
            color: white;
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
            overflow-y: scroll;
            height: 200px;
            scrollbar-color: #FD5631 #1F1B2D;
            scrollbar-width: thin;
        }
		.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255,255,255,0.7);
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
    0%   {clip-path: polygon(50% 50%,0 0,0 0,0 0,0 0,0 0)}
    25%  {clip-path: polygon(50% 50%,0 0,100% 0,100% 0,100% 0,100% 0)}
    50%  {clip-path: polygon(50% 50%,0 0,100% 0,100% 100%,100% 100%,100% 100%)}
    75%  {clip-path: polygon(50% 50%,0 0,100% 0,100% 100%,0 100%,0 100%)}
    100% {clip-path: polygon(50% 50%,0 0,100% 0,100% 100%,0 100%,0 0)}
}
    </style>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-4 pt-4">


                <div class="wishlist-card p-3">
                    <div class="card-body ">
                        <div class="d-flex align-items-center justify-content-between">
                            <!-- Dealer Image and Details -->
                            <div class="d-flex align-items-center">
                                <!-- Dealer Image -->
                                <div class="profile-image">
                                    <img src="{{ isset($dealer->image) ? asset('web/profile/' . $dealer->image) : asset('web/images/logo version.svg') }}"
                                        alt="Dealer Image">
                                </div>

                                <!-- Dealer Name and Designation -->
                                <div>
                                    <h5 class="card-title">{{ $dealer->name }}</h5>
                                    <p class="card-text primary-color-custom">
                                        <strong>{{ $dealer->userType == 'car_dealer' ? 'Car Dealer' : 'Private Seller' }}</strong>
                                    </p>
                                </div>
                            </div>

                            <!-- Top-Right Text -->

                        </div>

                        <div class="my-3">
                            <p class="mb-1  {{ isset($dealer->number) ? '' : 'd-none' }}"><i
                                    class="bi bi-telephone me-2 primary-color-custom"></i>
                                @php
                                    $formattedNumber = isset($dealer->number)
                                        ? preg_replace('/^\+92(\d{3})(\d{7})$/', '+92 $1 $2', $dealer->number)
                                        : '';
                                @endphp
                                {{ $formattedNumber }}
                            </p>
                            <p class="mb-1 "><i class="bi bi-envelope me-2 primary-color-custom"></i> <a
                                    href="mailto:saima@gmail.com" class="text-white"
                                    style="color:#281F48 !important">{{ $dealer->email }}</a></p>
                            <p class="mb-1  {{ isset($dealer->address) ? '' : 'd-none' }}"><i
                                    class="bi bi-geo-alt me-2 primary-color-custom"></i>
                                {{ $dealer->address }}</p>
                            <p class="mb-1 "><i class="bi bi-calendar me-2 primary-color-custom"></i> Member
                                Since {{ \Carbon\Carbon::parse($dealer->created_at)->format('F j, Y') }}</p>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <!-- Call Button -->
                                <a href="tel:{{ $dealer->number }}"
                                    class="btn custom-btn-3 {{ isset($dealer->number) ? '' : 'd-none' }}">
                                    <i class="bi bi-telephone me-1"></i> Call
                                </a>
                                <!-- WhatsApp Button -->
                                <a href="https://wa.me/{{ $dealer->number }}"
                                    class="btn custom-btn-3 {{ isset($dealer->number) ? '' : 'd-none' }}" target="_blank">
                                    <i class="bi bi-whatsapp me-1"></i> WhatsApp
                                </a>
                                <!-- Share Button -->




                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="col-lg-8 ps-md-4">
                <div class="d-flex justify-content-between">
                    <h3 class="mb-2 " style="color: #281F48">Available Cars <small> (<span
                                id="filter_available_results">{{ count($posts) }}</span>) </small></h3>
          



                </div>
                <div class="row">
                    <div class="col-md-6 d-flex justify-content-start">
						          <span class=" pagination_count" style="font-size: 18px; color: #281F48; font-weight:700 ">
                        Showing {{ ($posts->currentPage() - 1) * $posts->perPage() + 1 }}
                        to {{ min($posts->currentPage() * $posts->perPage(), $posts->total()) }}
                        of {{ $posts->total() }} Results
                    </span>
						     </div>
						      <div class="col-md-6 d-flex justify-content-end">
                     
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
                                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #FD5631; color: #fff;">{{ $page }}</span>
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
                   
                    </div>
                </div>

                <div class="row mb-3 mt-2">
                    <div class="col-6 col-md-3 ">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-5 p-0 pe-2 d-flex justify-content-end"> <img
                                            src="{{ asset('web/images/sortimg.png') }}" class=""
                                            style="    height: 15px;
    width: 15px;
    
    margin-right: 6px;
    margin-top: 6px;">
                                        <p class="text-end pt-1" style="font-size:12px;font-weight:500">Sort by:</p>
                                    </div>
                                    <div class="col-5 p-0">
                                        <select class=" formcontrol p-1"
                                            style="  line-height: 12.68px !important; font-size:12px !important;    background-color: #F0F3F6 !important;"
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
                <div id="no_results_message" class=" row   pt-5 d-none">
					     <div id="loadingSpinner" class="loading-overlay d-none">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                    <div class="col-12 p-3" style="border:1px solid #FD5631;border-radius:9px;">
                        <div class="row">
                            <div class="col-3">
                                <img src="{{ asset('web/images/noinput.svg') }}" alt="" class="img-fluid"
                                    srcset="">
                            </div>
                            <div class="col-9 text-start">
                                <h1 style="color:#FD5631">Sorry</h1>
                                <p>No matches found for your search. Try adjusting your filters or expanding your criteria
                                    to explore available cars!</p>
                                <a href="{{ url('/') }}"
                                    style="background-color:#FD5631;color:white;padding:10px 15px;border-radius:5px;font-size:12px;">Go
                                    Back To Home</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row gy-3 mb-3" id="postresultsContainer">
                    @if (count($posts) < 1)
                        <h3 class="text-center p-5" style="color:#281F48 ">No cars available<h3>
                            @else
                                @foreach ($posts as $post)
                                    <div class="col-lg-12 post-item" data-condition="{{ $post->condition }}"
                                        data-year="{{ $post->year }}" data-seating="{{ $post->seating_capacity }}"
                                        data-doors="{{ $post->doors }}" data-assembly="{{ $post->assembly }}"
                                        data-make="{{ $post->make }}" data-model="{{ $post->model }}"
                                        data-province="{{ $post->location->province ?? '' }}"
                                        data-city="{{ $post->location->city ?? '' }}"
                                        data-engine="{{ $post->engine_capacity }}" data-mileage="{{ $post->milleage }}"
                                        data-price="{{ $post->price }}" data-body-type="{{ $post->body_type }}"
                                        data-fuel="{{ $post->fuel }}" data-color="{{ $post->exterior_color }}"
                                        data-transmission="{{ $post->transmission }}"
                                        data-ad-type="{{ $post->feature_ad }}"
                                        data-date="{{ $post->created_at->toIso8601String() }}">
                                        <a @if (Request::is('superadmin/*')) href="{{ route('superadmin.cardetail', $post->id) }}" @else href="{{ route('cardetail', $post->id) }}" @endif
                                            class="text-white">
                                            <div class="wishlist-card">
                                                <div class="row"
                                                    style="background-color: white ; border:1px solid #0000001F ;border-radius:20px">
                                                    <?php
                                                    $main = $post->document->first();
                                                    
                                                    ?>
                                                    <div class="col-lg-4 ps-0">
                                                        <div class="img-bg-home-2">

                                                            <img src="{{ url('posts/doc/' . $main->doc_name) }}"
                                                                class="img-adj-card">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 my-auto">
                                                        <div class="pe-lg-3 px-lg-0 pb-lg-0  p-3">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <h6>{{ $post->year }}</h6>
                                                                <div>
                                                                    @if ($post->feature_ad == 1)
                                                                        <span class="rounded px-3 py-1 text-capitalize"
                                                                            style="background-color:#BF0000; font-size:12px; "><img
                                                                                src="{{ asset('web/images/star-icon.svg') }}"
                                                                                class="me-2 mb-1 img-fluid">{{ 'featured' }}</span>
                                                                    @endif
                                                                    <span class="rounded px-3 py-1 text-capitalize"
                                                                        style="background-color:{{ $post->condition == 'used' ? '#0EB617' : '#4581F9' }}; font-size:12px;">{{ $post->condition }}</span>
                                                                </div>

                                                            </div>
                                                            <h4 style="color:#281F48 ">{{ $post->makename }}
                                                                {{ $post->modelname }}</h4>
                                                            <h5 style="color: #FD5631;"><b>PKR
                                                                    {{ number_format($post->price) }}</b></h5>

                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <h6 class="mb-0" style="color:#281F48 !important "><i
                                                                        class="bi bi-geo-alt"></i>
                                                                    {{ $post->location->cityname ?? '' }}</h6>
                                                                <?php
                                                                
                                                                $date = $post->updated_at;
                                                                $formattedDate = 'Last Updated: ' . date('F j, Y', strtotime($date));
                                                                ?>
                                                                <span
                                                                    style="font-size:14px; color:#281F48 ">{{ $formattedDate }}</span>
                                                            </div>
                                                            <hr
                                                                style="border: none; height: 1px; background-color: #66666680;">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <div class="text-center py-1"
                                                                        style="background-color:#F0F3F6; border-radius: 10px;">
                                                                        <i style="color:#281F48 "
                                                                            class="bi bi-speedometer2"></i>
                                                                        @php
                                                                            $formattedMileage =
                                                                                $post->milleage >= 1000
                                                                                    ? rtrim(
                                                                                        number_format(
                                                                                            $post->milleage / 1000,
                                                                                            1,
                                                                                        ),
                                                                                        '.0',
                                                                                    )
                                                                                    : $post->milleage;
                                                                        @endphp
                                                                        <h6>{{ $formattedMileage }} KM</h6>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="text-center py-1"
                                                                        style="background-color:#F0F3F6; border-radius: 10px;">
                                                                        <i style="color:#281F48 "
                                                                            class="bi bi-car-front-fill"></i>
                                                                        <h6>{{ $post->transmission }}</h6>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="text-center py-1"
                                                                        style="background-color:#F0F3F6; border-radius: 10px;">
                                                                        <i style="color:#281F48 "
                                                                            class="bi bi-fuel-pump-diesel"></i>
                                                                        <h6>{{ $post->fuel }}</h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                                <div class="d-none">
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
                                                                        <form method="POST"
                                                                            action="{{ url()->current() }}">
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
                    @endif
                </div>
                <div style="display: flex;justify-content: space-between;margin-bottom: 10px;">
                    <div>
                        <span class="pt-md-3 pagination_count" style="font-size: 18px; color: #281F48; font-weight:700 ">
                            Showing {{ ($posts->currentPage() - 1) * $posts->perPage() + 1 }}
                            to {{ min($posts->currentPage() * $posts->perPage(), $posts->total()) }}
                            of {{ $posts->total() }} Results
                        </span>
                    </div>
                    <div>
            
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
                                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #FD5631; color: #fff;">{{ $page }}</span>
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
              
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#province_filter').change(function(e) {
            var provinceId = this.value;
            var cityWrapper = document.getElementById('city_filter_wrapper');

            // Clear the existing city checkboxes
            cityWrapper.innerHTML = '';

            // Fetch cities based on the selected province
            if (provinceId) {
                fetch(`/getCities/${provinceId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(city => {
                            var div = document.createElement('div');
                            div.classList.add('form-check', 'my-2');

                            var checkbox = document.createElement('input');
                            checkbox.type = 'checkbox';
                            checkbox.classList.add('form-check-input', 'city_filter');
                            checkbox.id = 'city_' + city.id;
                            checkbox.value = city.id;
                            checkbox.name = 'city[]';

                            var label = document.createElement('label');
                            label.classList.add('form-check-label');
                            label.htmlFor = 'city_' + city.id;
                            label.textContent = city.name;

                            div.appendChild(checkbox);
                            div.appendChild(label);
                            cityWrapper.appendChild(div);
                        });
                    })
                    .catch(error => console.error('Error fetching cities:', error));
            }

            // applyFilters(); // Ensure filters are applied after fetching cities
        });




        // to get models based on selected make
        $('#make_filter').change(function(e) {
            var makeId = this.value;

            var modelWrapper = document.getElementById('model_filter_wrapper');

            // Clear the current city options
            modelWrapper.innerHTML = '';

            // Fetch cities based on selected province
            if (makeId) {
                fetch(`/getmodel/${makeId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(model => {
                            var div = document.createElement('div');
                            div.classList.add('form-check', 'my-2');

                            var checkbox = document.createElement('input');
                            checkbox.type = 'checkbox';
                            checkbox.classList.add('form-check-input', 'model-filter');
                            checkbox.id = 'model_' + model.id;
                            checkbox.value = model.id;
                            checkbox.name = 'model[]';

                            var label = document.createElement('label');
                            label.classList.add('form-check-label');
                            label.htmlFor = 'model_' + model.id;
                            label.textContent = model.name + ' (' + (model.count || 0) + ')';

                            div.appendChild(checkbox);
                            div.appendChild(label);
                            modelWrapper.appendChild(div);

                        });

                    })
                    .catch(error => console.error('Error fetching models:', error));
            }
        });
    </script>
    {{-- price range script --}}
    <script>
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
            let minValue = parseInt(minRange.value);
            let maxValue = parseInt(maxRange.value);

            if (minValue > maxValue - 50) {
                minRange.value = maxValue - 50;
                minValue = maxValue - 50;
            }
            if (maxValue < minValue + 50) {
                maxRange.value = minValue + 50;
                maxValue = minValue + 50;
            }

            minPrice.value = minValue;
            maxPrice.value = maxValue;
            updateProgress();
        }

        function updateInputs() {
            let minValue = parseInt(minPrice.value);
            let maxValue = parseInt(maxPrice.value);

            if (minValue < parseInt(minRange.min)) {
                minPrice.value = minRange.min;
            }
            if (maxValue > parseInt(maxRange.max)) {
                maxPrice.value = maxRange.max;
            }
            if (minValue > maxValue - 50) {
                minPrice.value = maxValue - 50;
            }
            if (maxValue < minValue + 50) {
                maxPrice.value = minValue + 50;
            }

            minRange.value = minPrice.value;
            maxRange.value = maxPrice.value;
            updateProgress();
        }

        minRange.addEventListener("input", updateRange);
        maxRange.addEventListener("input", updateRange);
        minPrice.addEventListener("input", updateInputs);
        maxPrice.addEventListener("input", updateInputs);

        updateProgress();
    </script>





    {{-- filters script  --}}


    <script>
        $('#make_filter').change(function() {
            applyFilters();
        });
        $(document).on('change', '.model-filter', function() {
            applyFilters();
        });
        $('#minPrice_filter').change(function() {
            applyFilters();
        });
        $('#maxPrice_filter').change(function() {
            applyFilters();
        });
        $('#from-year-filter').change(function() {
            if ($('#to-year-filter').val() != '' && $('#to-year-filter').val() != 'To') {
                applyFilters();
            }
        });
        $('#to-year-filter').change(function() {
            if ($('#from-year-filter').val() != '' && $('#from-year-filter').val() != 'From') {
                applyFilters();
            }
        });
        $('#mileage_from').change(function() {
            applyFilters();
        });
        $('#mileage_to').change(function() {
            applyFilters();
        });
        $('#province_filter').change(function() {
            applyFilters();
        });
        $(document).on('change', '.city_filter', function() {
            applyFilters();
        });
        $('#engine_capacity_filter').change(function() {
            applyFilters();
        });
        $('.body_type_filter').change(function() {
            applyFilters();
        });
        $('.fuel_type_filter').change(function() {
            applyFilters();
        });
        $('#seating_capacity_filter').change(function() {
            applyFilters();
        });
        $('.door_count_filter').change(function() {
            applyFilters();
        });
        $('.assembly_filter').change(function() {
            applyFilters();
        });
        $('.exterior_color_filter').change(function() {
            applyFilters();
        });
        $('.transmission_filter').change(function() {
            applyFilters();
        });
        $('#featureAd_filter').change(function() {
            applyFilters();
        });
        $('#minRange').change(function() {
            applyFilters();
        });
        $('#maxRange').change(function() {
            applyFilters();
        });



        function applyFilters() {
            const makeId = document.getElementById('make_filter').value.trim();
            const modelIds = [...document.querySelectorAll('.model-filter:checked')].map(cb => cb.value.toLowerCase()
            .trim());
            const minPrice = parseInt(document.getElementById('minPrice_filter').value) || 0;
            const maxPrice = parseInt(document.getElementById('maxPrice_filter').value) || 60000000;
            const minYear = parseInt(document.getElementById('from-year-filter').value) || 1960;
            const maxYear = parseInt(document.getElementById('to-year-filter').value) || new Date().getFullYear();
            const minMileage = parseInt(document.getElementById('mileage_from').value) || 0;
            const maxMileage = parseInt(document.getElementById('mileage_to').value) || 300000;
            const provinceId = document.getElementById('province_filter').value;
            const cityIds = [...document.querySelectorAll('.city_filter:checked')].map(cb => cb.value.toLowerCase().trim());
            const engineCapacity = document.getElementById('engine_capacity_filter').value;
            const bodyType = Array.from(document.querySelectorAll('.body_type_filter:checked')).map(cb => cb.value);
            const fuelType = Array.from(document.querySelectorAll('.fuel_type_filter:checked')).map(cb => cb.value);
            const seatingCapacity = document.getElementById('seating_capacity_filter').value;
            const doorCount = document.querySelector('.door_count_filter')?.value || "";
            const assembly = document.querySelector('.assembly_filter')?.value || "";
            const exteriorColor = Array.from(document.querySelectorAll('.exterior_color_filter:checked')).map(cb => cb
                .value);
            const transmission = Array.from(document.querySelectorAll('.transmission_filter:checked')).map(cb => cb.value);
            const featureAd = document.getElementById('featureAd_filter').checked;

            document.querySelectorAll('.post-item').forEach(postItem => {
                const postPrice = parseInt(postItem.dataset.price);
                const postYear = parseInt(postItem.dataset.year);
                const postMileage = parseInt(postItem.dataset.mileage);

                const postModel = postItem.dataset.model ? postItem.dataset.model.toString().trim().toLowerCase() :
                    "";
                const postMake = postItem.dataset.make ? postItem.dataset.make.toString().trim() : "";

                const makeMatch = !makeId || (postMake && postMake === makeId);
                const modelMatch = modelIds.length === 0 || modelIds.includes(postModel);

                const postProvince = postItem.dataset.province ? postItem.dataset.province.toString().trim() : "";
                const postCity = postItem.dataset.city ? postItem.dataset.city.toString().trim().toLowerCase() : "";
                const cityMatch = cityIds.length === 0 || cityIds.includes(postCity);
                const postEngine = postItem.dataset.engine;
                const postBody = postItem.dataset.bodyType;
                const postFuel = postItem.dataset.fuel;
                const postSeating = postItem.dataset.seating;
                const postDoors = postItem.dataset.doors;
                const postAssembly = postItem.dataset.assembly;
                const postColor = postItem.dataset.color;
                const postTransmission = postItem.dataset.transmission;
                const postFeature = postItem.dataset.adType === "1";

                const matches = [
                    makeMatch,
                    modelMatch,
                    (postPrice >= minPrice && postPrice <= maxPrice),
                    (postYear >= minYear && postYear <= maxYear),
                    (postMileage >= minMileage && postMileage <= maxMileage),
                    (!provinceId || postProvince === provinceId),
                    cityMatch,
                    (!engineCapacity || postEngine === engineCapacity),
                    (bodyType.length === 0 || bodyType.includes(postBody)),
                    (fuelType.length === 0 || fuelType.includes(postFuel)),
                    (!seatingCapacity || postSeating === seatingCapacity),
                    (!doorCount || postDoors === doorCount),
                    (!assembly || postAssembly === assembly),
                    (exteriorColor.length === 0 || exteriorColor.includes(postColor)),
                    (transmission.length === 0 || transmission.includes(postTransmission)),
                    (!featureAd || postFeature)
                ].every(condition => condition);
                postItem.style.display = matches ? 'block' : 'none';
            });



            const visiblePosts = document.querySelectorAll('.post-item[style="display: block;"]');
            document.getElementById('filter_available_results').textContent = visiblePosts.length;
            if (visiblePosts.length === 0) {
                document.getElementById('no_results_message').classList.remove('d-none');
            } else {
                document.getElementById('no_results_message').classList.add('d-none');
            }
            const totalVisible = visiblePosts.length;
            const paginationCountElements = document.querySelectorAll('.pagination_count');
            if (totalVisible === 0) {
                paginationCountElements.forEach(el => el.classList.add('d-none'));
            } else {
                paginationCountElements.forEach(el => el.classList.remove('d-none'));
            }
            const paginationElements = document.querySelectorAll('.pagination');
            if (totalVisible <= 30) {
                paginationElements.forEach(el => el.classList.add('d-none'));
            } else {
                paginationElements.forEach(el => el.classList.remove('d-none'));
            }

            // Update pagination counters
            document.querySelectorAll('.pagination_count').forEach(element => {
                const start = 1;
                const end = totalVisible;
                element.textContent = `Showing ${start} to ${end} of ${totalVisible} Results`;
            });

            // Show/hide no results message
            document.getElementById('no_results_message').classList.toggle('d-none', totalVisible > 0);
        }


        // sort by order script 
        $('#sortbyorder').change(function() {
            const sortValue = $(this).val();
            const $container = $('#postresultsContainer'); // Parent container of post items
            const $posts = $('.post-item');

            // Convert to array for sorting
            const postsArray = $posts.get();

            postsArray.sort(function(a, b) {
                const $a = $(a);
                const $b = $(b);

                switch (sortValue) {
                    case 'Newest First':
                        return new Date($b.data('date')) - new Date($a.data('date'));
                    case 'Oldest First':
                        return new Date($a.data('date')) - new Date($b.data('date'));
                    case 'Price: Low to High':
                        return parseFloat($a.data('price')) - parseFloat($b.data('price'));
                    case 'Price: High to Low':
                        return parseFloat($b.data('price')) - parseFloat($a.data('price'));
                    case 'Model Year: Latest First':
                        return parseInt($b.data('year')) - parseInt($a.data('year'));
                    case 'Model Year: Oldest First':
                        return parseInt($a.data('year')) - parseInt($b.data('year'));
                    case 'Mileage: High to Low':
                        return parseFloat($b.data('mileage')) - parseFloat($a.data('mileage'));
                    case 'Mileage: Low to High':
                        return parseFloat($a.data('mileage')) - parseFloat($b.data('mileage'));
                    default:
                        return 0;
                }
            });

            // Detach and reattach sorted elements
            $container.children('.post-item').detach();
            $container.append(postsArray);
        });
    </script>


@endsection
