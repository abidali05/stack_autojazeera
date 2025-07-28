@extends('layout.panel_layout.main')
@section('content')
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
            color: #1f1b2d;
            border: 1px solid #1f1b2d;
            border-radius: 20px;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: 800px;
        }

        .button11 {
            background-color: #d90600;
            color: white;
            border: 1px solid #d90600;
            border-radius: 20px;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: 700px;
        }

        .button111 {
            background-color: #d90600;
            color: white;
            border: 1px solid #d90600;
            border-radius: 20px;
            padding: 5px 10px;
            font-size: 10px;
            font-weight: 700px;
        }

        .sixteen {
            color: #281f48;
            font-weight: 500;
            font-size: 16px;
        }
		  .sixteenmm {
            color: #281f48;
            font-weight: 400;
            font-size: 16px;
        }

        .twentyfour {
            color: #281f48;
            font-weight: 700;
            font-size: 24px;
        }

        .twentyfourgrey {
            color: #bfbec3;
            font-weight: 600;
            font-size: 24px;
        }

        .twentyfourlabel {
            color: #281f48;
            font-weight: 500;
            font-size: 18px;
        }

        .eighteen {
            color: #281f48;
            font-size: 18px;
            font-weight: 600;
        }

        .twentyeight {
            color: #281f48;
            font-weight: 700;
            font-size: 28px;
        }

        .fourteen {
            color: #281f48;
            font-weight: 600;
            font-size: 14px;
        }

        .twelve {
            color: #281f48;
            font-weight: 600;
            font-size: 11px;
        }

        .twelvebold {
            color: #281f48;
            font-weight: 700;
            font-size: 11px;
        }

        .fourtyeight {
            color: #281f48;
            font-weight: 700;
            font-size: 48px;
        }

        .sixteen {
            color: #281f48;
            font-weight: 600;
            font-size: 16px;
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
            color: #0000004d;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #281f48;
            font-size: 18px;
            font-weight: 600;
        }

        .wishlist-card {
            background-color: #f0f3f6;
        }

        .backcolor {
            background-color: #f0f3f6;
        }

        .backblueclr {
            background-color: #281f48;
        }

        .whitebtn {
            background-color: white;
            border: 1px solid #281f48;
            color: #281f48;
            padding: 5px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
        }

        .bluebtn {
            background-color: #281f48;
            border: 1px solid #281f48;
            color: white;
            padding: 5px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
        }

        .mapbutton {
            background-color: transparent;
            border: 1px solid #281f48;
            padding: 5px 10px;
            border-radius: 5px;
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
            background-color: #d6d6d6;
            /* default inactive bg */
        }

        .star-circle.active {
            background-color: #281f48;
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
            border-left: 1px solid #1f1b2d;
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
            background-color: #d6d6d6;
            /* default inactive */
        }

        .star-wrapper.active-star {
            background-color: #281f48;
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
            border-left: 1px solid #1f1b2d;
        }

        .border-bottom {
            border-bottom: 1px solid #66666680;
        }

        /* home page */
        .bakgimg {
            background-image: url("./images/Frame\ 1618873199.svg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 150px;
            width: 100% !important;
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
            color: #281f48 !important;
        }

        .form-selects {
            --bs-form-select-bg-img: url(data:image/svg + xml,
     %3csvgxmlns="http://www.w3.org/2000/svg"viewBox="0 0 16 16" %3e%3cpathfill="none" stroke="%23343a40" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m2 5 6 6 6-6" /%3e%3c/svg%3e);
            display: block;
            width: 100%;
            padding: 0.375rem 2.25rem 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #281f48;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-color: var(--bs-body-bg);
            background-image: var(--bs-form-select-bg-img),
                var(--bs-form-select-bg-icon, none);
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            border: var(--bs-border-width) solid var(--bs-border-color);
            border-radius: var(--bs-border-radius);
            max-width: 200px !important;
            text-align: start;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control::placeholder {
            color: #281f48;
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
            background-color: #281f48;
        }

        .imgbak {
            background-image: url("./images/Frame\ 1171275423.svg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .colors {
            color: #281f48;
        }

        .crouserheading1 {
            color: #281f48;
            font-size: 35px;
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
            color: #281f48;
            font-size: 35px;
            padding-left: 100px;
            padding-top: 70px;
            font-weight: 800;
        }

        .carousel-indicators .active {
            opacity: 1;

            background-color: #d90600 !important;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 40px;
            /* Adjust size */
            height: 40px;
            background-color: #281f48;
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
            background-color: #d6d6d6;
            background-clip: padding-box;
            border: 0;
            border-top: 10px solid transparent;
            border-bottom: 10px solid transparent;
            opacity: 0.5;
            transition: opacity 0.6s ease;
            border-radius: 50%;
        }

        #customCarousel {
            background-image: url("/web/images/backimgrola.svg");
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
            padding: 0.375rem 0.75rem;
            font-size: 12px;
            font-weight: 400;
            line-height: 1.5;
            color: #281f48;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-color: #f0f3f6;
            background-clip: padding-box;
            border: var(--bs-border-width) solid #f0f3f6;
            border-radius: var(--bs-border-radius);
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-select {
            --bs-form-select-bg-img: url(data:image/svg + xml,
     %3csvgxmlns="http://www.w3.org/2000/svg"viewBox="0 0 16 16" %3e%3cpathfill="none" stroke="%23343a40" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m2 5 6 6 6-6" /%3e%3c/svg%3e);
            display: block;
            width: 100%;
            padding: 0.375rem 2.25rem 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #281f48;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-color: #f0f3f6;
            background-image: var(--bs-form-select-bg-img),
                var(--bs-form-select-bg-icon, none);
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            border: var(--bs-border-width) solid #f0f3f6;
            border-radius: var(--bs-border-radius);
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
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
            background-color: #281f48;
            border-color: #281f48;
        }

        .custom-modal-width {
            width: 80%;
            max-width: 80%;
        }
    </style>


    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="row mt-2">
                    <div class="col-12 col-md-2 pt-3" style="height:140px">
                        <div class="d-flex justify-content-center"><img src="{{ $shop->logo }}" class="img-fluid " style="border-radius:50%;height:140px"
                                alt="...">
                        </div>
                    </div>
                    <div class="col-12 col-md-9 pt-3">
                        <div class="d-flex justify-content-between ">
                            <h1 class="fourtyeight ">{{ $shop->name }} </h1>
                            <span class="sixteen">
                                <a href="{{ route('shop.edit', $shop->id) }}" class="mapbutton btn-sm">Edit Shop</a>
                            </span>
                        </div>
                        <small><span
                                class="badge {{ $shop->status == '1' ? 'bg-success' : 'bg-danger' }}">{{ $shop->status == '1' ? 'Active' : ($shop->status == '2' ? 'Rejected' : 'Inactive') }}</span>
                        </small>
                        <br>
                        <span >
                            {{ $shop->address }} </span>
                        <div class="">
                            <span class="sixteen me-5"><i class="bi bi-telephone me-2"></i>{{ $shop->number }} </span> <span
                                class="sixteen "><i class="bi bi-envelope me-2"></i>{{ $shop->email }} </span>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-5 {{ $shop->status == '2' ? '' : 'd-none' }}">
                        <h2 class="twentyeight">Rejection Reason</h2>
                        <p class="sixteenmm" style="text-align:justify; text-justify:inter-word; color:red;">
                            {{ $shop->rejection_reason }}
                        </p>
                    </div>
					<div class="col-12 mt-5">
                        <h2 class="twentyeight">About Shop</h2>
                        <p class="sixteenmm" style="text-align:justify; text-justify:inter-word">
                            {{ $shop->description }}
                        </p>
                    </div>
                </div>
           <div class="row">
 <div class="col-md-12">
    <h2 class="twentyeight mb-4">Photos & Videos</h2>

    <div class="row">
        @if (isset($shop->shop_images) && count($shop->shop_images) > 0)
            @foreach ($shop->shop_images as $image)
                <div class="col-6 col-sm-6 col-md-3 mb-4">
                    <img src="{{ asset($image->path) }}"
                         class="img-fluid rounded"
                         style="width: 100%; height: 200px; object-fit: cover;"
                         alt="Shop Image">
                </div>
            @endforeach
        @else
            <div class="col-12">
                <p>No images available.</p>
            </div>
        @endif
    </div>
</div>

</div>

                <div class="row">
                    <div class="col-md-12 col-12 p-3">
                        <div class="row">
                            <div class="col-12 ">

                                <h2 class="mt-5 mb-3 twentyeight">Services Offered</h2>
                                <div class="row">
                                    @if ($shop->shop_services && $shop->shop_services->count() > 0)
                                        @foreach ($shop->shop_services->chunk(3) as $chunk)
                                            <div class="col-md-4 col-6" style="font-weight: 700;">
                                                @foreach ($chunk as $service)
                                                    <p class="sixteenmm {{ $loop->last ? '' : 'mb-3' }}">
                                                        <img src="{{ asset($service->service->icon) }}"
                                                            class="img-fluid me-3"
                                                            alt="{{ $service->service->name ?? '' }}"
                                                            style="width: 40px; height: 40px;">
                                                        {{ $service->service->name ?? '' }}
                                                    </p>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12">
                                            <p>No services available</p>
                                        </div>
                                    @endif
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-12 p-3 mb-1 ">

                        <div class="map-container rounded-3">

                            <iframe
                            width="100%"
                            height="300px"
                            frameborder="0"
                            style="border:0; border-radius: 8px;"
                            src="https://www.google.com/maps?q={{ $shop->latitude }},{{ $shop->longitude }}&output=embed"
                            allowfullscreen>
                        </iframe>
                        
                            <p class="sixteenmm mt-2">
                                {{ $shop->address }}
                                <a href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($shop->address) }}"
                                    target="_blank" class="mapbutton ms-4 py-2 text-decoration-none">
                                    Get Directions
                                    <img src="{{ asset('web/services/images/Group 1171275297.svg') }}"
                                        class="img-fluid ms-2" style="height: 20px; width: 20px;" alt="Directions icon">
                                </a>
                            </p>
                        </div>

                    </div>
                    <div class="col-md-12 col-lg-12 col-12">
                        <div class="row">
                            <div class="col-md-6 col-12 px-4">
                                <h2 class="twentyeight">Hours & Location</h2>
                                <div class="row">
                                    <div class="col-4" style="font-weight: 600;color: #000000;">
                                        @php
                                            $daysInOrder = [
                                                'Monday',
                                                'Tuesday',
                                                'Wednesday',
                                                'Thursday',
                                                'Friday',
                                                'Saturday',
                                                'Sunday',
                                            ];
                                            $timingsByDay = [];

                                            // Organize timings by day
                                            foreach ($shop->shop_timings as $timing) {
                                                $timingsByDay[$timing->day] = [
                                                    'start' => $timing->start_time,
                                                    'end' => $timing->end_time,
                                                ];
                                            }
                                        @endphp

                                        @foreach ($daysInOrder as $day)
                                            <p class="sixteen">{{ $day }}</p>
                                        @endforeach
                                    </div>

                                    <div class="col-8" style="font-weight: 600; color: #000000;">
                                        @foreach ($daysInOrder as $day)
                                            @if (isset($timingsByDay[$day]))
                                                @php
                                                    // Format time (remove seconds and format AM/PM)
                                                    $start = date('g:i A', strtotime($timingsByDay[$day]['start']));
                                                    $end = date('g:i A', strtotime($timingsByDay[$day]['end']));
                                                @endphp
                                                <p class="sixteen text-end">{{ $start }} - {{ $end }}</p>
                                            @else
                                                <p class="sixteen text-end" style="color: orangered;">Closed</p>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12" style="color: #000000;">
                                <div class="row">
                                    <h2 class="twentyeight">Amenities</h2>

                                    @if ($shop->shop_amenities && $shop->shop_amenities->count() > 0)
                                        @php
                                            // Split amenities into chunks of 2 for two-column layout
                                            $amenityChunks = $shop->shop_amenities->chunk(2);
                                        @endphp

                                        @foreach ($amenityChunks as $chunk)
                                            <div class="d-flex justify-content-between sixteenb">
                                                @foreach ($chunk as $amenity)
                                                    <p class="sixteen {{ $loop->odd ? '' : 'text-end' }}">
                                                        {{ $amenity->amenity->name }}
                                                    </p>
                                                @endforeach

                                                {{-- Add empty element if odd number to maintain layout --}}
                                                @if ($chunk->count() < 2)
                                                    <p class="sixteen"></p>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="sixteen">No amenities listed</p>
                                    @endif

                                    <p class="twentyeight mt-4">Our Social Media</p>
                                    <div class="col-md-12 twelve" style="font-weight: 600; color: #000000;">
                                        <span class="me-5" onclick="window.open('{{ $shop->facebook }}','_blank')"><img
                                                src="{{ asset('web/services/images/facebook.svg') }}"
                                                class="img-fluid me-2" alt="Facebook icon"> Facebook</span>
                                        <span class="me-5"
                                            onclick="window.open('{{ $shop->instagram }}','_blank')"><img
                                                src="{{ asset('web/services/images/instagram.svg') }}"
                                                class="img-fluid me-2" alt="Instagram icon"> Instagram</span>
                                        <span onclick="window.open('{{ $shop->twitter }}','_blank')"><img
                                                src="{{ asset('web/services/images/Social Iconsxxx.svg') }}"
                                                class="img-fluid me-2" alt="X icon"> X</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- success modal start --}}


    <div class="modal fade" id="response" tabindex="-1" aria-labelledby="responseLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"  style="border-radius: 10px; overflow: hidden;">
                <!-- Modal Header -->
                <div class="modal-header" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                    <h5 class="modal-title" id="responseLabel"><strong>Shop </strong></h5>
                    <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body text-center" style="background-color: white !important; color: #281F48;">
                    <p>{{ session('response') }}</p>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer justify-content-center border-0 p-0 pb-3" style="background-color: white !important;">
                    <button type="button"   class="btn btn-light px-4 py-2 "
                            style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>gi
    </div>

    {{-- success modal end --}}

    @if (session('response'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                let modal = new bootstrap.Modal(document.getElementById('response'));
                modal.show();
            });
        </script>
    @endif
@endsection
