{{-- @dd($shop->rating) --}}

@extends('layout.website_layout.services.main')


<style>
    body {
        padding: 0;
        margin: 0;

    }

    * {
        padding: 0;
        margin: 0;
    }

    .buttons {
        background-color: white;
        color: #1F1B2D;
        border: 1px solid #1F1B2D;
        border-radius: 20px;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 800px;
    }

    .button11 {
        background-color: #D90600;
        color: white;
        border: 1px solid #D90600;
        border-radius: 20px;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 700px;
    }

    .button111 {
        background-color: #D90600;
        color: white;
        border: 1px solid #D90600;
        border-radius: 20px;
        padding: 5px 10px;
        font-size: 10px;
        font-weight: 700px;
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

    .sixteen {
        color: #281F48;
        font-weight: 500;
        font-size: 16px;
    }

    .twentyfour {
        color: #281F48;
        font-weight: 700;
        font-size: 24px;
    }

    .twentyfourgrey {
        color: #BFBEC3;
        font-weight: 600;
        font-size: 24px;
    }

    .twentygrey {
        color: #BFBEC3;
        font-weight: 600;
        font-size: 16px;
    }

    .twentygreen {
        color: #0EB617;
        font-weight: 600;
        font-size: 16px;
    }


    .twentyfourlabel {
        color: #281F48;
        font-weight: 500;
        font-size: 18px;
    }

    .eighteen {
        color: #281F48;
        font-size: 18px;
        font-weight: 600;
    }

    .twentyeight {
        color: #281F48;
        font-weight: 700;
        font-size: 28px;
    }

    .fourteen {
        color: #281F48;
        font-weight: 600;
        font-size: 14px;
    }

    .twelve {
        color: #281F48;
        font-weight: 600;
        font-size: 11px;
    }

    .twelvebold {
        color: #281F48;
        font-weight: 700;
        font-size: 11px;
    }

    .fourtyeight {
        color: #281F48;
        font-weight: 700;
        font-size: 48px;
    }

    .sixteen {
        color: #281F48;
        font-weight: 600;
        font-size: 16px;
    }

    .twelve {
        color: #281F48;
        font-weight: 600;
        font-size: 12px;
    }

    .imagewidth {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .imagediv {
        overflow: hidden;
        width: 100%;
        height: 100%;
        border-radius: 20px 0px 0px 20px;
    }

    .breadcrumb-item a {
        color: #0000004D;
        font-size: 16px;
        font-weight: 500;
        text-decoration: none;
    }

    .breadcrumb-item.active {
        color: #281F48;
        font-size: 18px;
        font-weight: 600;
    }

    .wishlist-card {
        background-color: #F0F3F6;
    }

    .backcolor {
        background-color: #F0F3F6;
    }

    .backblueclr {
        background-color: #281F48;
    }

    .whitebtn {
        background-color: white;
        border: 1px solid #281F48;
        color: #281F48;
        padding: 5px 20px;
        border-radius: 5px;
        font-size: 16px;
        font-weight: 600;
    }

    .bluebtn {
        background-color: #281F48;
        border: 1px solid #281F48;
        color: white;
        padding: 5px 20px;
        border-radius: 5px;
        font-size: 16px;
        font-weight: 600;
    }

    .mapbutton {
        background-color: transparent;
        border: 1px solid #281F48;
        padding: 5px 10px;
        border-radius: 5px;
    }

    .bigfont {
        font-size: 120px;
        font-weight: 700px;
        color: #281F48;
    }


    .rating-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .stars {
        display: flex;
        gap: 5px;
        cursor: pointer;
    }

    .star-circle {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s;
        background-color: #D6D6D6;
        /* default inactive bg */
    }

    .star-circle.active {
        background-color: #281F48;
        /* active purple bg */
    }

    .star {
        font-size: 14px;
        color: #ffffff88;
        /* faint white by default */
        transition: color 0.2s;
    }

    .star.filled {
        color: #ffffff;
        /* bright white */
    }

    .star.clicked {
        color: #f1c40f;
        /* yellow on click */
    }

    .review-text {
        font-size: 14px;
        color: #333;
    }

    .borderleft {
        border-left: 1px solid #1F1B2D;
    }

    .borderbottom {
        border-bottom: 1px solid #66666680;
    }

    .rating-wrapper {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .star-group {
        display: flex;
        gap: 5px;
        cursor: pointer;
    }

    .star-wrapper {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s;
        background-color: #D6D6D6;
        /* default inactive */
    }

    .star-wrapper.active-star {
        background-color: #281F48;
        /* active purple */
    }

    .star-icon {
        font-size: 14px;
        color: #ffffff88;
        /* faint white */
        transition: color 0.2s;
    }

    .star-icon.filled-star {
        color: #ffffff;
        /* bright white */
    }

    .star-icon.clicked-star {
        color: #f1c40f;
        /* yellow after click */
    }

    .rating-label {
        font-size: 14px;
        color: #333;
    }

    /* Optional extra classes */
    .border-left {
        border-left: 1px solid #1F1B2D;
    }

    .border-bottom {
        border-bottom: 1px solid #66666680;
    }

    .thumbnail-image {
        cursor: pointer;
        transition: border 0.3s ease;
    }

    .thumbnail-image.active-thumb {
        border: 2px solid red !important;
    }




    /* home page */
    .bakgimg {

        background-image: url('./images/Frame\ 1618873199.svg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 150px;
        width: 99%;
    }

    .input-group {
        width: 100%;
        padding: 10px;
    }

    .form-control,
    .form-selects {
        border-right: 0;
        border-left: 0;
        padding: 10px;
        font-size: 16px;
        color: #281F48 !important;
    }

    .form-selects {
        --bs-form-select-bg-img: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e);
        display: block;
        width: 100%;
        padding: .375rem 2.25rem .375rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #281F48;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-color: var(--bs-body-bg);
        background-image: var(--bs-form-select-bg-img), var(--bs-form-select-bg-icon, none);
        background-repeat: no-repeat;
        background-position: right .75rem center;
        background-size: 16px 12px;
        border: var(--bs-border-width) solid var(--bs-border-color);
        border-radius: var(--bs-border-radius);
        max-width: 200px !important;
        text-align: start;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .form-control::placeholder {
        color: #281F48;
    }

    .btn {
        border-left: 0;
        font-size: 16px;
    }

    .bbrder {
        position: relative;
        height: 90%;
        margin: auto;
    }

    .bbrder::before {
        content: "";
        position: absolute;
        left: 0;
        top: 10%;
        height: 80%;
        width: 2px;
        background-color: #281F48;
    }

    .imgbak {

        background-image: url('./images/Frame\ 1171275423.svg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .colors {
        color: #281F48;
    }

    .crouserheading1 {
        color: #281F48;
        font-size: 35px;
        padding-left: 100px;
        padding-top: 60px;
        font-weight: 700;
    }

    .crouserheading11 {
        color: #281F48;
        font-size: 34px;
        padding-left: 100px;
        padding-top: 100px;
        font-weight: 700;
    }

    .imgcrs {
        height: 400px;
        width: 570px;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 15px;
        /* Adjust arrow size */
        height: 15px;
        filter: brightness(0) invert(1);
        /* Make arrows white */
    }

    .img-bg-home-2 {
        width: 100%;

        overflow: hidden;
        border-radius: 20px 0px 0px 20px;
    }

    .img-adj-card {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }


    .crouserheading {
        color: #281F48;
        font-size: 35px;
        padding-left: 100px;
        padding-top: 70px;
        font-weight: 800;
    }

    .carousel-indicators .active {
        opacity: 1;

        background-color: #D90600 !important;
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

    #customCarousel {
        background-image: url('/web/images/backimgrola.svg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 450px;
    }

    .paddingthis {
        padding-left: 100px;
        padding-top: 30px;
    }

    .search-box {
        display: flex;
        align-items: center;
        background-color: red;
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

    a {
        text-decoration: none;
    }

    .form-controles {
        display: block;
        width: 100%;
        padding: .375rem .75rem;
        font-size: 12px;
        font-weight: 400;
        line-height: 1.5;
        color: #281F48;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-color: #F0F3F6;
        background-clip: padding-box;
        border: var(--bs-border-width) solid #F0F3F6;
        border-radius: var(--bs-border-radius);
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .form-select {
        --bs-form-select-bg-img: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e);
        display: block;
        width: 100%;
        padding: .375rem 2.25rem .375rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #281F48;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-color: #F0F3F6;
        background-image: var(--bs-form-select-bg-img), var(--bs-form-select-bg-icon, none);
        background-repeat: no-repeat;
        background-position: right .75rem center;
        background-size: 16px 12px;
        border: var(--bs-border-width) solid #F0F3F6;
        border-radius: var(--bs-border-radius);
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .feature_ad {
        width: 18px;
        height: 18px;
        background-color: transparent;
        border: 2px solid #00000080;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .feature_ad:checked {
        background-color: #281F48;
        border-color: #281F48;
    }

    .custom-modal-width {
        width: 80%;
        max-width: 80%;
    }

    .divcolor {
        background-color: #F0F3F6;
        border-radius: 20px 20px 20px 20px;
    }

    #custom-star-container {
        display: flex;
        gap: 5px;
    }

    .custom-star {
        font-size: 1.5rem;
        color: #1F1B2D;
        cursor: pointer;
        background-color: #979797;
        border-radius: 5px;
        transition: color 0.3s;
        padding: 5px;
    }



    .progress-bar-wrapper {
        width: 100%;
        margin: 0 auto;
        font-family: 'Arial', sans-serif;
    }

    .rating-bar {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .rating-bar span {
        width: 60px;
        margin-right: 10px;
        color: white;
    }

    .progress {
        flex: 1;
        height: 10px;
        background-color: #DBDBDB;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background-color: #281F48;
        width: 0%;
        transition: width 0.5s ease-in-out;
    }

    .fill-5 {
        width: 90%;
    }

    .fill-4 {
        width: 70%;
    }

    .fill-3 {
        width: 50%;
    }

    .fill-2 {
        width: 30%;
    }

    .fill-1 {
        width: 15%;
    }

    #feedback-stars-group {
        display: flex;
        gap: 5px;
    }

    .feedback-star-item {
        font-size: 1.3 rem;
        color: #FFFFFF;
        cursor: pointer;
        background-color: #281F48;
        border-radius: 5px;
        transition: color 0.3s;
        padding: 5px;
    }

    .feedback-star-item:hover,
    .feedback-star-item.selected {
        color: #ff9900;
    }


    .popbuton {
        background-color: white;
        color: #A7A7A7;
        border: 1px solid #A7A7A7;
        border-radius: 15px;
        padding: 5px 20px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;

    }

    .classcrol {
        height: 380px;
        overflow-y: auto;
        /* important for scrolling */
    }

    /* Scrollbar track */
    .classcrol::-webkit-scrollbar {
        width: 8px;
        /* width of scrollbar */
    }

    /* Scrollbar thumb */
    .classcrol::-webkit-scrollbar-thumb {
        background-color: red;
        /* color of scrollbar handle */
        border-radius: 10px;
        /* optional: rounded corners */
    }

    /* Scrollbar track background */
    .classcrol::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* light background (optional) */
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

    /* Star Rating System Styling */
    .feedback-star-item.selected {
        color: #FFC107 !important;
        /* Gold/yellow color for selected stars */
        transform: scale(1.1);
    }

    .custom-star.highlighted {
        background-color: #281F48 !important;
        /* Shop's theme color for highlighted stars */
        color: #FFFFFF !important;
    }

    /* Animation for star selection */
    .feedback-star-item,
    .custom-star {
        transition: all 0.2s ease-in-out;
    }

    /* Rating modal styles */
    #modal-feedback-stars .feedback-star-item {
        font-size: 2rem;
        /* Larger stars in the review modal */
    }

    /* Image removal styling */
    .image-box {
        position: relative;
    }

    .remove-image {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: rgba(255, 0, 0, 0.7);
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 12px;
        z-index: 10;
    }

    .remove-image:hover {
        background-color: red;
    }

    .sixteennn {
        font-size: 16px;
        font-weight: 400;
        color: #281F48;
    }
</style>


{{-- review modal css start  --}}
<style>
    .dropzone {
        position: relative;
        width: 100%;
        height: 120px;
        border: 2px dashed #ccc;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: #f9f9f9;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .dropzone:hover {
        background-color: #eef;
    }

    .upload-icon {
        font-size: 24px;
        margin-bottom: 8px;
        color: #333;
    }

    .upload-text {
        font-weight: bold;
        font-size: 12px;
        color: #281F48;
    }

    .upload-subtext {
        font-size: 8px;
        color: #281F48;
    }

    .upload-input {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        top: 0;
        left: 0;
    }

    .image-box img {
        width: 100%;
        height: auto;
        margin-top: 10px;
        border-radius: 8px;
        object-fit: cover;
    }

    .form-controless {
        display: block;
        width: 100%;
        padding: .375rem .75rem;
        font-size: 12px;
        font-weight: 400;
        line-height: 1.5;
        color: #281F48;
        background-color: white;
        background-clip: padding-box;
        border: 1px solid #A7A7A7;
        border-radius: var(--bs-border-radius);
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .reed {
        font-size: 12px;
        color: red;

    }
</style>
{{-- review modal css end --}}


{{-- step form css start  --}}
<style>
    .step-content {
        display: none;
    }

    .step-content.active {
        display: block;
    }
</style>
{{-- step form css end --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class=" col-md-12">
                <div class="row mt-2">
                    <div class="col-12 col-md-3">
                        <div class="d-flex justify-content-center align-items-center" style="height:240px"><img
                                src="{{ $shop->logo }}" class="img-fluid"
                                style="width:200px ; height:200px ;border-radius:50%" alt="..."></div>
                    </div>
                    <div class="col-12 col-md-9 pt-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="fourtyeight">{{ $shop->name }}</h1>
								       <p class="m-0 mt-4">
                            @foreach ($shop->shop_services as $i => $shopservice)
                                @if ($i < 3)
                                    <span class="eighteen m-0 me-4 mt-3">{{ $shopservice->service->name }}</span>
                                @endif
                            @endforeach
                        </p>
                            </div>
                            <div>
                                <div class="feedback-rating-container align-items-center ">
                                    <div class="mb-2" id="review-stars">

                                        <span class="custom-star {{ $shop->rating >= 1 ? 'highlighted' : '' }}"
                                            data-value="1">&#9733;</span>
                                        <span class="custom-star {{ $shop->rating >= 2 ? 'highlighted' : '' }}"
                                            data-value="2">&#9733;</span>
                                        <span class="custom-star {{ $shop->rating >= 3 ? 'highlighted' : '' }}"
                                            data-value="3">&#9733;</span>
                                        <span class="custom-star {{ $shop->rating >= 4 ? 'highlighted' : '' }}"
                                            data-value="4">&#9733;</span>
                                        <span class="custom-star {{ $shop->rating >= 5 ? 'highlighted' : '' }}"
                                            data-value="5">&#9733;</span>
                                    </div>
                                    <p class="text-end m-0">{{ number_format($shop->rating, 1) }}
                                        ({{ $shop->total_ratings }} Reviews)</p>
                                </div>
     <div class="d-flex justify-content-end align-items-center mt-4">
                            <span class="eighteen  " style="font-size:20px">{{$shop->views ?? '0' }}</span><i class="bi bi-eye fs-4 ms-2 me-2"></i>
                            @auth
							@if(Auth::user()->role == '2' || Auth::user()->role == '3')
					
							
							<button style="background-color: transparent; border: none; color:#281F48 !important">
                                    <i class="bi bi-heart' fs-5"></i></button>
							
							@else
							
                                @php
                                    $check = \App\Models\AutoServices\ShopWishlist::where('user_id', auth()->id())
                                        ->where('shop_id', $shop->id)
                                        ->first();
                                @endphp

                                <a href="{{ route('shops.wishlist.add', ['shop' => $shop->id, 'user' => auth()->id()]) }}"
                                    style="background-color: transparent; border: none; color:#281F48 !important">
                                    <i class="bi {{ $check ? 'bi-heart-fill text-danger' : 'bi-heart' }} fs-5"></i>
                                </a>
							@endif
                            @endauth


                            @guest
                                <a href="{{ route('login') }}" style="background-color: transparent; border: none;">
                                    <i class="bi bi-heart fs-4"></i>
                                </a>
                            @endguest
                        </div>
                            </div>
                        </div>
                    </div>
                  </div>


                    @php
                        $currentDay = date('l');
                        $timings = $shop->shop_timings->where('day', $currentDay)->first();
                    @endphp



                    @if ($timings)
                        <div class="row">
                            <div class="col-md-4">
                                <span class="twentygreen ">Open Now<span
                                        class="twentygrey ms-4">{{ date('h:i A', strtotime($timings->start_time)) }} -
                                        {{ date('h:i A', strtotime($timings->end_time)) }}</span></span>

                            </div>
                            <div class="col-md-8 text-end">
                                <span class="twentyfourlabel ">{{ $shop->address }} (14 km
                                    away) <img src="{{ asset('web/services/images/Icon (Stroke).svg') }}"
                                        class="img-fluid ms-2" alt="..."></span>
                            </div>
                        </div>
                    @else
                        <span style="color: orangered;">Closed</span>
                    @endif
                </div>


            </div>
            <div class="row">
                <div class="col-6 ">
                    @auth
                        @php
                            $user = Auth::user();
                            if ($user->role == '1') {
                                $userId = $user->id;
                            }
                            if ($user->role == '2') {
                                $userId = $user->dealer_id;
                            }
                        @endphp
                        @if ( Auth::user()->id == $shop->dealer_id)
                            <button class="button11 me-2 mt-4"
                                onclick="alert('You can not request a quote from your own shop')">Request a Quote
                            </button>
                        @else
					@if(Auth::user()->role == '2' || Auth::user()->role == '3')
					 <button class="button11 me-2 mt-4"
                            onclick="alert('You are not authorized for this action!')">
                            <strong>Request a Quote</strong></button>
					@else
                            <button class="button11 me-2 mt-4" data-bs-toggle="modal"
                                data-bs-target="#requestQuoteModal">Request a Quote
                            </button>
					@endif
                        @endif
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="button11 me-2 mt-4"><strong>Request a Quote</strong>
                        </a>
                    @endguest

                    {{-- <a href="tel:{{ $shop->number }}" class="buttons me-2 mt-4 "><img
                                src="{{ asset('web/services/images/Icon7.svg') }}" class="img-fluid me-2 pb-1"
																						  style="height: 20px; width: 20px;" alt="..."><strong>Call</strong></a>
                        <a href="https://wa.me/{{ $shop->number }}" class="buttons me-2 mt-4 "><img
                                src="{{ asset('web/services/images/Icon7.svg') }}" class="img-fluid me-2 pb-1"
                                style="height: 20px; width: 20px;" alt="..."><strong>WhatsApp</strong></a> --}}
                    @auth
					@if(Auth::user()->role == '2' || Auth::user()->role == '3')
					
					
					<button class="buttons me-2 mt-4" onclick="alert('You are not authorized for this action!')"><img
                                src="{{ asset('web/services/images/starr.svg') }}" class="img-fluid me-2 pb-1"
                                style="height: 20px; width: 20px;" alt="..."><strong>Write
                                a review</strong></button>
					
					
					
					@else
                        <button class="buttons me-2 mt-4" data-bs-toggle="modal" data-bs-target="#reviewModal"><img
                                src="{{ asset('web/services/images/starr.svg') }}" class="img-fluid me-2 pb-1"
                                style="height: 20px; width: 20px;" alt="..."><strong>Write
                                a review</strong></button>
					@endif
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="buttons me-2 mt-4"><strong>Write
                                a review</strong></a>
                    @endguest

                    <button class="buttons me-2 mt-4 "
                        onclick="shareLink()"><img
                            src="{{ asset('web/services/images/icon8.svg') }}"
                            class="img-fluid me-2 "style="height: 13px; width: 20px;"
                            alt="..."><strong>Share</strong></button>
 @auth
					@if(auth()->id() == $shop->dealer_id )
					   <button class="buttons me-2 mt-4 "
                            onclick="alert('You can not chat with yourself')">
                            <strong>Chat</strong></button>
					@else
                    @if ($shop->dealer->shop_pkg && $shop->dealer->shop_pkg->metadata->chat_allowed == '1')
					
					@if(Auth::user()->role == '2' || Auth::user()->role == '3')
					 <button class="buttons me-2 mt-4 "
                            onclick="alert('You are not authorized for this action!')">
                            <strong>Chat</strong></button>
					@else
					
                        <button class="buttons me-2 mt-4 "
                            onclick="createOrOpenChat({{ $shop->id }}, {{ $shop->dealer_id }})">
                            <strong>Chat</strong></button>
					@endif
                    @endif
					@endif
					  @endauth
					
					   @guest
					 <a href="{{url('login')}}" class="buttons me-2 mt-4 ">
                            <strong>Chat</strong></a>
					   @endguest
                </div>
                <div class="col-md-6 mt-3 text-end align-items-center">

					 @if ($shop->dealer->shop_pkg && $shop->dealer->shop_pkg->metadata->number_allowed == '1')
                   @if ($shop->number)
    <i class="bi bi-telephone-fill fs-2 pt-5"
       onclick="window.location.href='tel:{{ str_replace(' ', '', $shop->number) }}'"></i>
@endif
					@endif
 @if ($shop->dealer->shop_pkg && $shop->dealer->shop_pkg->metadata->whatsapp_allowed == '1')
@if ($shop->number)
    <i class="bi bi-whatsapp ms-3 fs-2 pt-5"
       onclick="window.location.href='https://wa.me/{{ str_replace(' ', '', $shop->number) }}'"></i>
@endif
					@endif

                    @if ($shop->facebook)
                        <i class="bi bi-facebook ms-3 fs-2 pt-5"
                            onclick="window.location.href='{{ $shop->facebook }}'"></i>
                    @endif
                    @if ($shop->instagram)
                        <i class="bi bi-instagram ms-3 fs-2 pt-5"
                            onclick="window.location.href='{{ $shop->instagram }}'"></i>
                    @endif
                    @if ($shop->twitter)
                        <i class="bi bi-twitter-x ms-3 fs-2 pt-5"
                            onclick="window.location.href='{{ $shop->twitter }}'"></i>
                    @endif

                </div>
            </div>
            <div class="row">
   
            </div>
            <div class="row">
                <div class="col-md-7 col-12 p-3">
                    <div class="row">
                        <div class="col-12 p-0">
                            @if (count($shop->shop_images) > 0)
                            <h2 class="twentyeight my-3">Photos & Videos</h2>
                            <div id="mainCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($shop->shop_images as $index => $image)
                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                            <img src="{{ asset($image->path) }}" class="d-block w-100 rounded"
                                                style="height: 300px; object-fit: contain;" alt="...">
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Left Arrow -->
                                <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"
                                        style=" border-radius: 50%; padding: 10px;"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>

                                <!-- Right Arrow -->
                                <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"
                                        style=" border-radius: 50%; padding: 10px;"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                            @endif 
                            <h2 class="my-3 twentyeight">Services Offered</h2>
                            <div class="row">
                                @foreach ($shop->shop_services as $service)
                                    <div class="col-md-4 col-6">
                                        <div class="row mb-2 d-flex align-items-center">
                                            <div class="col-md-3"><img src="{{ $service->service->icon }}"
                                                    class="img-fluid " style="width: 40px; height: 40px;" alt="...">
                                            </div>
                                            <div class="col-md-9 ps-0">
                                                <p class="sixteennn">{{ $service->service->name }}</p>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach


                            </div>

                            <h2 class="my-3 twentyeight">Amenities</h2>

                            <div class="row">
                                @foreach ($shop->shop_amenities as $amenity)
                                    <div class="col-md-4 col-6">
                                        <div class="row mb-2 d-flex align-items-center">

                                            <div class="col-md-9 ps-0">
                                                <p class="sixteennn ms-2 ps-1">{{ $amenity->amenity->name }}</p>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach


                            </div>
                            <div class="row">

                                <div class="col-12 divcolor rounded-3 p-3">
                                    <div class="row text-center">
                                        <div class="col-12 col-md-4 p-0 m-0 ">
                                            <span
                                                class="bigfont  p-0 m-0"><strong>{{ number_format($shop->rating, 1) }}</strong></span>

                                        </div>
                                        <div class="col-md-4 text-end col-12 p-0 m-0">
                                            <p class=" pt-4 text-end  twentyfour">Reviews</p>
                                            <p class="p-0 m-0 eighteen text-end ">{{ $shop->name }}</p>
											<p class="p-0 twelve mt-2 text-end ">{{ $shop->address }}</p>
                                        </div>

                                        <div class="col-12 col-md-4 p-0 m-0">
                                            <div
                                                class="custom-rating-wrapper d-flex align-items-center justify-content-center ">
                                                <div id="custom-star-container">
                                                    <span
                                                        class="custom-star {{ $shop->rating >= 1 ? 'highlighted' : '' }}"
                                                        data-value="1">&#9733;</span>
                                                    <span
                                                        class="custom-star {{ $shop->rating >= 2 ? 'highlighted' : '' }}"
                                                        data-value="2">&#9733;</span>
                                                    <span
                                                        class="custom-star {{ $shop->rating >= 3 ? 'highlighted' : '' }}"
                                                        data-value="3">&#9733;</span>
                                                    <span
                                                        class="custom-star {{ $shop->rating >= 4 ? 'highlighted' : '' }}"
                                                        data-value="4">&#9733;</span>
                                                    <span
                                                        class="custom-star {{ $shop->rating >= 5 ? 'highlighted' : '' }}"
                                                        data-value="5">&#9733;</span>
                                                </div>
                                            </div>
                                            @foreach ($shop->shop_services->take(3) as $index => $service)
                                                <p class="fourteen {{ $index === 0 ? 'mt-3' : '' }}">
                                                    {{ $service->service->name }}</p>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mt-3">
                                    <h2 class="twentyeight">About Business</h2>
                                    <p class="fourteen"> {{ $shop->description }}
                                    </p>
                                </div>
                            </div>
                            @php
                                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                            @endphp
                            <div class="row">
                                <div class="col-md-12">
                                    <h2 class="twentyeight">Hours & Location</h2>
                                    <div class="row">
                                        <div class="col-4" style="font-weight: 600;color: #000000;">
                                            @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                                <p class="sixteen">{{ $day }}</p>
                                            @endforeach
                                        </div>
                                        <div class="col-8" style="font-weight: 600; color: #000000;">
                                            @foreach ($days as $day)
                                                @php
                                                    $timing = $shop->shop_timings->where('day', $day)->first();
                                                @endphp
                                                <p id="preview-{{ strtolower($day) }}-hours" class="sixteen text-end">
                                                    @if ($timing)
                                                        {{ date('h:i A', strtotime($timing->start_time)) }} -
                                                        {{ date('h:i A', strtotime($timing->end_time)) }}
                                                    @else
                                                        <span style="color: orangered">Closed</span>
                                                    @endif
                                                </p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-12 mt-5 pt-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row g-2" id="thumbnailGallery">
                                        @foreach ($shop->shop_images as $index => $image)
                                            <div class="col-md-4">
                                                <img src="{{ asset($image->path) }}"
                                                    class="w-100 rounded thumbnail-image" data-bs-target="#mainCarousel"
                                                    data-bs-slide-to="{{ $index }}"
                                                    data-index="{{ $index }}"
                                                    style="height: 130px; object-fit: cover; border: 2px solid #281F48;">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">

                                    <div class="map-container rounded-3">
                                        <iframe width="100%" height="300px" frameborder="0" class="{{$shop->dealer->shop_pkg && $shop->dealer->shop_pkg->metadata->map_allowed == '1' ? '' : 'd-none'}}"
                                            style="border:0; border-radius: 8px;"
                                            src="https://www.google.com/maps?q={{ $shop->latitude }},{{ $shop->longitude }}&output=embed"
                                            allowfullscreen>
                                        </iframe>

                                        <div class="d-flex justify-content-between mt-2 align-items-center">
                                            <p class="sixteen m-0"> {{ $shop->address }}</p>
											 @if ($shop->dealer->shop_pkg && $shop->dealer->shop_pkg->metadata->map_allowed == '1')
                                            <button
                                                onclick="window.open('https://www.google.com/maps?q={{ $shop->latitude }},{{ $shop->longitude }}&output=embed', '_blank')"
                                                class="mapbutton ms-4">Get Directions <img
                                                    src="{{ asset('web/services/images/Group 1171275297.svg') }}"
                                                    class="img-fluid ms-2" style="height: 20px; width: 20px;"
                                                    alt="..."></button>
											
											@endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
     
        <div class="col-md-12">

            <div class="row">


                <div class="col-12 col-md-12 p-3">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="row d-flex justify-content-between">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-2 pe-0">
                                            <div>
                                                <p class="fourtyeight m-0">{{ number_format($shop->rating, 1) }}</p>
                                                <p class="fourteen">{{ $shop->shop_reviews->count() ?? 0 }} reviews
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <p class="eighteen m-0 mt-2">Overall rating</p>
                                            <div class="d-flex justify-content-between">
                                                <div class="feedback-rating-container d-flex align-items-center">
                                                    <div id="overall-stars-display">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <span
                                                                class="feedback-star-item {{ $shop->rating >= $i ? 'selected' : '' }}"
                                                                data-score="{{ $i }}">&#9733;</span>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-end">
                                    @auth
									@if(Auth::user()->role == '2' || Auth::user()->role == '3')
					 <button class="bluebtn"
                            onclick="alert('You are not authorized for this action!')">
                            Write a Review</button>
									
									@else
                                        <button class="bluebtn" data-bs-toggle="modal" data-bs-target="#reviewModal">Write a
                                            Review</button>
                                    </div>
								@endif
                                @endauth

                                @guest
                                    <a href="{{ route('login') }}" class="bluebtn">Write a Review</a>
                                </div>
                            @endguest
                        </div>


                    </div>
                    <div class="col-12 col-md-12">
                        <div class="progress-bar-wrapper ">
                            <div class="rating-bar">
                                <span style="color: #281F48; font-size: 12px; font-weight: 600;">5 star</span>
                                <div class="progress">
                                    <div class="progress-fill"
                                        style="width: {{ isset($shop->rating_distribution) && isset($shop->rating_distribution[5]) ? $shop->rating_distribution[5] * 100 . '%' : '0%' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="rating-bar">
                                <span style="color: #281F48; font-size: 12px; font-weight: 600;">4 star</span>
                                <div class="progress">
                                    <div class="progress-fill"
                                        style="width: {{ isset($shop->rating_distribution) && isset($shop->rating_distribution[4]) ? $shop->rating_distribution[4] * 100 . '%' : '0%' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="rating-bar">
                                <span style="color: #281F48; font-size: 12px; font-weight: 600;">3 star</span>
                                <div class="progress">
                                    <div class="progress-fill"
                                        style="width: {{ isset($shop->rating_distribution) && isset($shop->rating_distribution[3]) ? $shop->rating_distribution[3] * 100 . '%' : '0%' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="rating-bar">
                                <span style="color: #281F48; font-size: 12px; font-weight: 600;">2 star</span>
                                <div class="progress">
                                    <div class="progress-fill"
                                        style="width: {{ isset($shop->rating_distribution) && isset($shop->rating_distribution[2]) ? $shop->rating_distribution[2] * 100 . '%' : '0%' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="rating-bar">
                                <span style="color: #281F48; font-size: 12px; font-weight: 600;">1 star</span>
                                <div class="progress">
                                    <div class="progress-fill"
                                        style="width: {{ isset($shop->rating_distribution) && isset($shop->rating_distribution[1]) ? $shop->rating_distribution[1] * 100 . '%' : '0%' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <h2 class="twentyeight">Reviews</h2>
                    <p class="eighteen">sort<i class="bi bi-arrow-down-up ms-2"></i></p>
                </div>
                <div class="row">
                    @if (isset($shop->shop_reviews) && count($shop->shop_reviews) > 0)
                        @foreach ($shop->shop_reviews as $index => $review)
                            <div class="col-md-6 p-3 review-item {{ $index >= 2 ? 'd-none' : '' }}">
                                <div class="row rounded p-3" style="background-color:#F4F4F4">
                                    <div class="col-12 d-flex justify-content-between " >
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="d-flex">
                                                    <img src="{{ asset('web/profile/' . $review->user->image ?? 'web/services/images/Group 1171275217.svg') }}"
                                                        class="img-fluid" alt="User"
                                                        style="width: 60px; height: 60px; border-radius: 50%;">
                                                    <span class="eighteen ms-2 ">{{ $review->user->name ?? 'Anonymous' }}
                                                        <br><span class="twelve">{{ $review->user->address ?? '' }}</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 ps-0">
                                                <div class="feedback-rating-container align-items-center text-end ">
                                                    <div class="mb-2 d-flex align-items-baseline"
                                                        id="review-stars-{{ $review->id }}">
                                                        <p style="color:#979797; font-size:12px;">
                                                            {{ $review->rating }}</p>
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <span
                                                                class="feedback-star-item ms-2 {{ $review->rating >= $i ? 'selected' : '' }}"
                                                                data-score="{{ $i }}">&#9733;</span>
                                                        @endfor
                                                    </div>
                                                    <span
                                                        class="ms-3 twelve text-end ">{{ \Carbon\Carbon::parse($review->created_at)->format('d/m/Y') }}</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div>
                                        <p class="fourteen mt-3"
                                            style="text-align: justify; text-justify: inter-word; word-break: break-word; overflow-wrap: break-word;">
                                            {{ $review->comment }}
                                        </p>
                                    </div>
                                    @if (isset($review->review_images) && count($review->review_images) > 0)
                                        <div class="col-12 d-flex p-0 m-0">
                                            @foreach ($review->review_images as $index => $image)
                                                @if ($index < 3)
                                                    <div class="col-4 px-2">
                                                        <div class="row">
                                                            <div class="col-12">

                                                                <img src="{{ $image->path }}" class="img-fluid"
                                                                    alt="Review image">

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12 text-center">
                            <p class="eighteen mt-4">No reviews yet. Be the first to review!</p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-12 text-end my-2">
                <a href="javascript:void(0)" id="toggle-reviews" style="color:red; font-size:16px; font-weight:500">Show
                    More</a>
            </div>









        </div>
    </div>
    </div>
    </div>



    <!-- review Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">


                <div class="modal-body">
                    <form action="{{ route('review.store') }}" method="post" enctype="multipart/form-data"
                        id="reviewForm">
                        @csrf

                        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                        <div class="row mb-3">
                            <div class="col-md-12 d-flex justify-content-between">
                                <p class="fourtyeight">{{ $shop->name }}</p>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="feedback-rating-container align-items-center ">
                                    <div id="feedback-stars-group">
                                        <span class="feedback-star-item" data-score="1">&#9733;</span>
                                        <span class="feedback-star-item" data-score="2">&#9733;</span>
                                        <span class="feedback-star-item" data-score="3">&#9733;</span>
                                        <span class="feedback-star-item" data-score="4">&#9733;</span>
                                        <span class="feedback-star-item" data-score="5">&#9733;</span>
                                        <input type="hidden" name="rating" id="rating-value" value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <textarea class="form-controless" id="exampleFormControlTextarea1" rows="3" name="comment"></textarea>
                                    <p class="reed" style="display: none; color: red;">Your review should have at least
                                        20 characters.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Dropzone + Images Row -->
                      <div class="row g-3">
    <div class="col-md-3">
        <div id="reviewImagesDropzone" class="border border-dashed rounded p-2 text-center mb-3" 
             style="cursor: pointer; min-height: 150px;">
            <i class="bi bi-cloud-arrow-up fs-1 mb-3" style="color: #281F48;"></i>
            <p class="mb-2" style="font-size:12px">Click or drag files here to upload</p>
            <button type="button" class="btn p-0 px-2 py-2" style="font-size:12px;background-color:#281F48; color:white">
                Select Files
            </button>

            <input type="file" id="review_images" name="review_images[]" multiple
                   accept="image/jpeg,image/jpg,image/png" class="d-none">
        </div>
        
     
    </div>
       <div id="review_images_preview" class="d-flex flex-wrap gap-3 mt-3">
            <!-- Preview boxes will be added here -->
            <div class="image-box" style="width: 120px; height: 120px;"></div>
            <div class="image-box" style="width: 120px; height: 120px;"></div>
            <div class="image-box" style="width: 120px; height: 120px;"></div>
            <div class="image-box" style="width: 120px; height: 120px;"></div>
            <div class="image-box" style="width: 120px; height: 120px;"></div>
            <div class="image-box" style="width: 120px; height: 120px;"></div>
            <div class="image-box" style="width: 120px; height: 120px;"></div>
            <div class="image-box" style="width: 120px; height: 120px;"></div>
            <div class="image-box" style="width: 120px; height: 120px;"></div>
            <div class="image-box" style="width: 120px; height: 120px;"></div>
        </div>
</div>

                      
                    
                </div>

                <div class="modal-footer d-flex justify-content-start" style="border: none;">
                    <button type="button" class="whitebtn py-2" data-bs-dismiss="modal"
                        onclick="window.location.reload();">Cancel</button>
                    <button type="submit" class="bluebtn py-2" id="submit-review-btn">Submit Review</button>
                </div>
                </form>

            </div>
        </div>
    </div>



    {{-- request quote modal start --}}
    <div class="modal fade classcrol" id="requestQuoteModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="requestQuoteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable custom-modal-width">
            <div class="modal-content">
                <form id="multiStepForm">
                    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                    <div class="modal-header" style="border: none;">
                        <!-- Optional Header -->
                    </div>
                    <div class="modal-body pt-0">
                        <div class="d-flex justify-content-between">
                            <p class="fourtyeight ps-4 m-0 ms-3 p-0">Request a Quote</p>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <!-- Steps Start -->
                        <div class="step-content active" id="step0">
                            <div class="row classcrol">
                                <div class="col-md-5 ps-5">
                                    <div class="scrollable-content">
                                        <p class="twentyeight mt-4">Select your Vehicle </p>

                                        <div class="checkbox-group">
                                            <label class="checkbox-button">
                                                <input type="radio" name="vehicle-type" value="bike" hidden>
                                                <span>Bike</span>
                                            </label>
                                            <label class="checkbox-button">
                                                <input type="radio" name="vehicle-type" value="car" hidden>
                                                <span>Car</span>
                                            </label>
                                        </div>
                                        <div id="vehicle-error" class="reed mt-2" style="display:none;">Please select a
                                            vehicle type</div>

                                    </div>
                                    <div class="d-flex justify-content-end mt-5">
                                        <button type="button" class="bluebtn ms-auto next-validate px-5">Next</button>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <img src="{{ asset('web/services/images/carbike.svg') }}" class="img-fluid"
                                        alt="...">
                                </div>
                            </div>
                        </div>
                        <!-- Step 1 -->
                        <div class="step-content active" id="step1">
                            <div class="row classcrol">
                                <div class="col-md-5 ps-5">
                                    <div class="scrollable-content">
                                        <p class="twentyeight mt-4">Select body type</p>
                                        <div id="body-type-error" class="reed mt-2" style="display:none;">Please select a
                                            body type</div>



                                        <div class="checkbox-group">
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>Bike</span>
                                            </label>
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>Sedan</span>
                                            </label>
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>SUV</span>
                                            </label>
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>Crossover</span>
                                            </label>
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>Coupe</span>
                                            </label>
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>Pickup</span>
                                            </label>
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>Sport Coupe</span>
                                            </label>
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>Hatchback</span>
                                            </label>
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>Convertible</span>
                                            </label>
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>Family Van</span>
                                            </label>
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>Bike</span>
                                            </label>
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>Commercial Large Vehicle</span>
                                            </label>
                                        </div>

                                    </div>
                                    <div class=" d-flex justify-content-between mt-5">
                                        <button type="button" class="whitebtn prev px-5 ">Back</button>
                                        <button type="button" class="bluebtn ms-auto next px-5"
                                            id="secondstepbtn">Next</button>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <img src="{{ asset('web/services/images/Frameee.svg') }}" class="img-fluid"
                                        alt="...">

                                </div>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="step-content" id="step2">
                            <div class="row classcrol">
                                <div class="col-md-5 ps-5">
                                    <div class="scrollable-content">
                                        <p class="twentyeight mt-4">Select Make</p>

                                        <div class="checkbox-group">
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>Honda</span>
                                            </label>
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>toyota</span>
                                            </label>
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>corola</span>
                                            </label>
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>Exterior Car Wash</span>
                                            </label>
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>Interior Car Wash</span>
                                            </label>
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>Exterior Polish</span>
                                            </label>
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>Interior Full Luster</span>
                                            </label>
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>Full Exterior</span>
                                            </label>
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>Not Sure</span>
                                            </label>
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>Other</span>
                                            </label>
                                        </div>

                                    </div>
                                    <div class="d-flex justify-content-between mt-5 ">
                                        <button type="button" class="whitebtn prev px-5">Back</button>
                                        <button type="button" class="bluebtn  next px-5">Next</button>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <img src="{{ asset('web/services/images/Frameee.svg') }}" class="img-fluid"
                                        alt="...">
                                </div>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="step-content" id="step3">
                            <div class="row classcrol">
                                <div class="col-md-5 ps-5">
                                    <div class="scrollable-content">
                                        <p class="twentyeight mt-4">Select Model</p>

                                        <div class="checkbox-group">
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>Honda</span>
                                            </label>
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>toyota</span>
                                            </label>
                                            <label class="checkbox-button">
                                                <input type="checkbox" hidden>
                                                <span>corola</span>
                                            </label>

                                        </div>

                                    </div>
                                    <div class="d-flex justify-content-between mt-5">
                                        <button type="button" class="whitebtn prev px-5">Back</button>
                                        <button type="button" class="bluebtn  next px-5">Next</button>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <img src="{{ asset('web/services/images/Frameee.svg') }}" class="img-fluid"
                                        alt="...">
                                </div>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="step-content" id="step4">
                            <div class="row classcrol">
                                <div class="col-md-5 ps-5">
                                    <div class="scrollable-content">
                                        <p class="twentyeight mt-4">Select Year</p>
                                        <div id="year-error" class="reed mt-2" style="display:none;">Please select a year
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
                                        <button type="button" class="whitebtn prev px-5">Back</button>
                                        <button type="button" class="bluebtn  next px-5">Next</button>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <img src="{{ asset('web/services/images/popupimg.svg') }}" class="img-fluid"
                                        alt="...">
                                </div>
                            </div>
                        </div>

                        <!-- Step 5 -->
                        <div class="step-content" id="step5">
                            <div class="row classcrol">
                                <div class="col-md-5 ps-5">
                                    <div class="scrollable-content">
                                        <p class="twentyeight mt-4">Select services you need</p>
                                        <div class="checkbox-group">
                                            @foreach ($shop->shop_services as $shopservice)
                                                <label class="checkbox-button">
                                                    <input type="checkbox" hidden value="{{ $shopservice->id }}"
                                                        name="services[]">
                                                    <span>{{ $shopservice->service->name }}</span>
                                                </label>
                                            @endforeach

                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-5">
                                        <button type="button" class="whitebtn prev px-5">Back</button>
                                        <button type="button" class="bluebtn  next px-5">Next</button>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <img src="{{ asset('web/services/images/popupimg.svg') }}" class="img-fluid"
                                        alt="...">
                                </div>
                            </div>
                        </div>

                        <!-- Step 6 -->
                        <div class="step-content" id="step6">
                            <div class="row classcrol">
                                <div class="col-md-5 ps-5">
                                    <div class="scrollable-content">
                                        <p class="twentyeight mt-4">Describe your Needs </p>
                                        <textarea class="form-controles" style="height: 200px;" placeholder="Type..." rows="3"
                                            name="needs_description" required></textarea>

                                        <div class="row mt-2">
                                            <div class="col-9 p-3 rounded-3" style="background-color: #F9F9F9;">
                                                <div class="row">
                                                    <div class="g-recaptcha"
                                                        data-sitekey="6Ld-aDMrAAAAANY_bODNkw-CVxYZ3-uZDz8RNxF6"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-5">
                                        <button type="button" class="whitebtn prev px-5">Back</button>
                                        <button type="button" class="bluebtn  next px-5">Submit</button>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <img src="{{ asset('web/services/images/popupimg.svg') }}" class="img-fluid"
                                        alt="...">
                                </div>
                            </div>
                        </div>

                        <!-- Step 7 -->
                        <div class="step-content" id="step7">
                            <div class="row classcrol">
                                <div class="col-md-12 ps-5">
                                    <div class="scrollable-content">
                                        <div class="text-center ">
                                            <img src="{{ asset('web/services/images/image 57.svg') }}" class="w-25"
                                                alt="...">
                                            <p class="eighteen">Sending your request</p>
                                        </div>


                                    </div>
                                    <div class="col-md-5 d-flex justify-content-between mt-5 d-none">

                                        <button type="button" class="whitebtn prev  px-5">Back</button>
                                        <button type="button" class="bluebtn me-5  next px-5">Next</button>

                                    </div>
                                </div>


                            </div>
                        </div>

                        <!-- Step 8 (Final Step) -->
                        <div class="step-content" id="step8">
                            <div class="row classcrol">
                                <div class="col-md-12 ps-5">
                                    <div class="scrollable-content">
                                        <div class="text-center ">
                                            <img src="{{ asset('web/services/images/image (290).svg') }}" class=""
                                                style="height: 125px; width:180px" alt="...">
                                            <p class="eighteen m-0">Your request has been sent</p>
                                            <p class="twelve">You will receive quote in email and message box </p>
                                            <a href="{{ route('services.home') }}" type="button"
                                                class="btn btn-danger py-2 px-2" style="font-size: 12px;">Find More Auto
                                                Services</a>
                                        </div>

                                    </div>
                                    <div class="col-md-5 d-flex justify-content-between mt-5 d-none">

                                        <button type="button" class="whitebtn prev  px-5">Back</button>
                                        <button type="button" class="bluebtn me-5  next px-5">Next</button>

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
    </div>
    {{-- request quote modal end --}}




    <div class="modal fade" id="reviewresponse" tabindex="-1" aria-labelledby="reviewresponseLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                <!-- Modal Header -->
                <div class="modal-header" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                    <h5 class="modal-title" id="reviewresponseLabel"><strong> Review </strong></h5>
                    <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body text-center" style="background-color: #F0F3F6; color: #FD5631;">
                    <p>{{ session('reviewresponse') }}</p>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                    <button type="button"   class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- success modal end --}}

    @if (session('reviewresponse'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                let modal = new bootstrap.Modal(document.getElementById('reviewresponse'));
                modal.show();
            });
        </script>
    @endif


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const thumbnails = document.querySelectorAll('.thumbnail-image');
            const carousel = document.querySelector('#mainCarousel');

            function setActiveThumbnail(index) {
                thumbnails.forEach(t => t.classList.remove('active-thumb'));
                const active = document.querySelector(`.thumbnail-image[data-index="${index}"]`);
                if (active) active.classList.add('active-thumb');
            }

            // Click on thumbnail
            thumbnails.forEach((thumb, i) => {
                thumb.addEventListener('click', () => {
                    setActiveThumbnail(i);
                });
            });

            // Change on slide
            carousel.addEventListener('slid.bs.carousel', function(e) {
                setActiveThumbnail(e.to);
            });

            // Set default first active
            setActiveThumbnail(0);
        });
    </script>


    <script>
        async function createOrOpenChat(shopId, dealerId) {
            try {
                toastr.success('Please wait...');
                const response = await fetch('/create-service-chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        shop_id: shopId,
                        dealer_id: dealerId,
                    })
                });

                const result = await response.json();
                if (result.success) {
                    window.location.href = `/service-chats`;
                    // alert('Chat created or opened successfully.');
                } else {
                    toastr.error('cannot chat with the dealer at the moment, please try again later.');
                }
            } catch (error) {
                toastr.error('cannot chat with the dealer at the moment, please try again later.');

                console.error('Error creating chat:', error);
            }
        }
    </script>
    <div class="modal fade" id="wishlistresponse" tabindex="-1" aria-labelledby="wishlistresponseLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                <!-- Modal Header -->
                <div class="modal-header" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;" >
                    <h5 class="modal-title" id="wishlistresponseLabel"><strong> Wishlist </strong></h5>
                    <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body text-center"  style="background-color: transparent !important; color: #281F48;">
                    <p>{{ session('wishlistresponse') }}</p>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                    <button type="button"  class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    </div>



    {{-- success modal end --}}

    @if (session('wishlistresponse'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                let modal = new bootstrap.Modal(document.getElementById('wishlistresponse'));
                modal.show();
            });
        </script>
    @endif

    <script src="{{ asset('customjs/shopdetail.js') }}"></script>
    <script>
        $('#submitBtn').click(function(e) {
            var comment = $('#exampleFormControlTextarea1').val().trim();
            if (comment.length < 20) {
                $('.reed').show();
                e.preventDefault(); // Prevent form submission
            } else {
                $('.reed').hide();
                // Optionally, submit the form here or let default behavior proceed
                // For example, if using a form: $('#yourFormId').submit();
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropzone = document.getElementById('reviewImagesDropzone');
    const fileInput = document.getElementById('review_images');
    const previewContainer = document.getElementById('review_images_preview');
    const imageCounter = document.getElementById('image-counter');
    const maxImages = 10;
    let uploadedFiles = [];
    let imageBoxes = Array.from(document.querySelectorAll('.image-box'));

    // Click handler
    dropzone.addEventListener('click', function() {
        fileInput.click();
    });

    // Drag and drop handlers
    dropzone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.style.borderColor = '#281F48';
        this.style.backgroundColor = 'rgba(40, 31, 72, 0.1)';
    });

    dropzone.addEventListener('dragleave', function() {
        this.style.borderColor = '';
        this.style.backgroundColor = '';
    });

    dropzone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.style.borderColor = '';
        this.style.backgroundColor = '';
        
        if (e.dataTransfer.files.length) {
            handleImageFiles(e.dataTransfer.files);
        }
    });

    // File input change handler
    fileInput.addEventListener('change', function() {
        if (this.files.length) {
            handleImageFiles(this.files);
        }
    });

    function handleImageFiles(files) {
        const availableBoxes = imageBoxes.filter(box => !box.querySelector('img'));
        const filesToProcess = Math.min(files.length, availableBoxes.length);
        
        if (filesToProcess === 0) {
            alert("Maximum 10 images already uploaded");
            return;
        }

        Array.from(files).slice(0, filesToProcess).forEach((file, index) => {
            // Validate file type
            if (!file.type.match(/image\/(jpeg|jpg|png)/)) {
                alert('Only JPG, JPEG, and PNG files are allowed.');
                return;
            }
            
            // Validate file size
            if (file.size > 8 * 1024 * 1024) {
                alert('Each image must be smaller than 8MB.');
                return;
            }
            
            // Add to uploaded files
            uploadedFiles.push(file);
            
            // Create preview
            const reader = new FileReader();
            reader.onload = function(e) {
                const box = availableBoxes[index];
                box.innerHTML = '';
                
                const imgContainer = document.createElement('div');
                imgContainer.className = 'position-relative w-100 h-100';
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail w-100 h-100';
                img.style.objectFit = 'cover';
                
                const removeBtn = document.createElement('button');
                removeBtn.innerHTML = '×';
                removeBtn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle';
                removeBtn.style.transform = 'translate(50%, -50%)';
                removeBtn.onclick = function() {
                    const boxIndex = imageBoxes.indexOf(box);
                    uploadedFiles.splice(boxIndex, 1);
                    box.innerHTML = '';
                    updateCounter();
                    updateFileInput();
                };
                
                imgContainer.appendChild(img);
                imgContainer.appendChild(removeBtn);
                box.appendChild(imgContainer);
                
                updateCounter();
                updateFileInput();
            };
            reader.readAsDataURL(file);
        });
    }
    
    function updateCounter() {
        const uploadedCount = imageBoxes.filter(box => box.querySelector('img')).length;
        imageCounter.textContent = `${uploadedCount}/${maxImages} photos`;
    }
    
    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        uploadedFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }
});
</script>


    <script>
        $(document).ready(function() {
            $('#toggle-reviews').click(function() {
                const hiddenItems = $('.review-item.d-none');

                if (hiddenItems.length > 0) {
                    $('.review-item').removeClass('d-none');
                    $(this).text('Show Less');
                } else {
                    $('.review-item').each(function(index) {
                        if (index >= 2) {
                            $(this).addClass('d-none');
                        }
                    });
                    $(this).text('Show More');
                }
            });
        });
    </script>
<script>
function shareLink() {
    if (navigator.share) {
        navigator.share({
            title: document.title,
            text: 'Check this out!',
            url: window.location.href
        }).catch((error) => console.log('Error sharing', error));
    } else {
        navigator.clipboard.writeText(window.location.href);
        alert('Link copied!');
    }
}
</script>
@endsection
