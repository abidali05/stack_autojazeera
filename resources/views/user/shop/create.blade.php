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

        .time-picker-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .time-picker-wrapper input[type="time"] {
            padding-right: 0px;
        }

        .time-picker-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #555;
            font-size: 18px;
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
            line-height: 2.3;
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

        #dropzone {
            border: 2px dashed #6c5ce7;
            padding: 30px;
            text-align: center;
            cursor: pointer;
        }

        .preview-img {
            max-width: 120px;
            margin: 10px;
            position: relative;
        }

        .remove-btn {
            position: absolute;
            top: 2px;
            right: 2px;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 12px;
            cursor: pointer;
            width: 20px;
            height: 20px;
        }
    </style>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
    <style>
        .dropzone {
            width: 100%;
            height: 150px;
            border: 2px dashed #7e6592;
            border-radius: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.3s;
            overflow: hidden;
            position: relative;
        }

        .upload-icon {
            width: 30px;
            opacity: 0.6;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }

        .upload-text {
            color: #aaa;
            font-size: 12px;
            text-align: center;
            margin: 0;
            transition: all 0.3s ease;
        }

        .dropzone img.upload-preview {
            width: 100%;
            height: 100%;
            object-fit: contain;
            position: absolute;
            top: 0;
            left: 0;
        }
    </style>

    <style>
        /* Add these styles to your existing CSS */
        #preview-services-container p,
        #preview-amenities-container p {
            margin-bottom: 0.5rem;
        }

        #preview-shop-images img {
            transition: transform 0.3s ease;
        }

        #preview-shop-images img:hover {
            transform: scale(1.02);
        }

        .modal-content {
            border-radius: 15px;
            overflow: hidden;
        }

        .modal-body {
            padding: 2rem;
        }

        /* Social media icons */
        #preview-facebook img,
        #preview-instagram img,
        #preview-twitter img,
        #preview-website img {
            width: 16px;
            height: 16px;
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p class="m-0 fourtyeight">Shop</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form id="shopForm" action="{{ route('shop.store') }}" method="Post" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                    <div class="row d-flex align-items-baseline">
                        <div class="col-md-9 ps-">
                            <label for="shop_name" class="form-label twentyfourlabel">Shop name*</label>
                            <input type="text" class="form-controles" id="shop_name" name="shop_name"
                                placeholder="Enter Shop name" value="{{ old('shop_name') }}" >
                        </div>
                        @error('shop_name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                        <div class="col-md-3">
                            <div id="logoDropzone" class="dropzone text-center border border-dashed p-4 rounded"
                                style="cursor: pointer; min-height: 150px;">
                                <div id="logoPreviewContainer">
                                    <p id="logoDropText" class="upload-text">Click here to upload<br>Shop Logo</p>
                                </div>
                                <input type="file" id="shop_logo" name="shop_logo" accept="image/png,image/svg+xml"
                                    hidden>
                            </div>
                        </div>


                        @error('shop_logo')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
            </div>

            <div class="col-md-6">
                <label for="shop_contact" class="form-label twentyfourlabel">Shop Phone number*</label>
                <input type="text" class="form-controles" id="shop_contact" name="shop_contact"
                    placeholder="+92 300 1234567" maxlength="16" value="{{ old('shop_contact') }}" >

            </div>
            @error('shop_contact')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
            <div class="col-md-6 ">
                <label for="shop_email" class="form-label twentyfourlabel">Shop Email*</label>
                <input type="email" class="form-controles" id="shop_email" name="shop_email"
                    placeholder="Enter Shop Email" value="{{ old('shop_email') }}">
            </div>
            @error('shop_email')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
            <div class="col-md-4  mt-3">
                <label for="province" class="form-label twentyfourlabel">Province*</label>
                <select class="form-select" aria-label="Default select example" name="province"
                    style="background-color:#F0F3F6 !important ; color:#000000 ; width:100% !important"
                    id="province">
                    <option selected>Select province</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->id }}" {{ old('province') == $province->id ? 'selected' : '' }}>
                            {{ $province->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('province')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
            <div class="col-md-4 mt-3">
                <label for="city" class="form-label twentyfourlabel">city*</label>
                <select class="form-select" aria-label="Default select example" name="city"
                    style="background-color:#F0F3F6 !important ; color:#000000 ; width:100% !important" id="city"
                    >
                    <option selected>Select Province first</option>
                    {{-- @foreach ($cities as $city)
                        <option value="{{ $city->id }}" {{old('city') == $city->id ? 'selected' : ''}}>{{ $city->name }}</option>
                    @endforeach --}}
                </select>
            </div>
            @error('city')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
            <div class="col-md-4  mt-3">
                <label for="postal_code" class="form-label twentyfourlabel">Postal Code*</label>
                <input type="text" class="form-controles" id="postal_code" placeholder="Enter Postal Code"
                    value="{{ old('postal_code') }}" name="postal_code" >
            </div>
            @error('postal_code')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
            <div class="col-md-12  mt-3">
                <label for="shop_address" class="form-label twentyfourlabel">Shop Address*</label>
                <input type="text" class="form-controles" id="shop_address" name="shop_address"
                    value="{{ old('shop_address') }}" placeholder="Enter Shop Address" autocomplete="off">
            </div>
            @error('shop_address')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror






            <script
                src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places&callback=initAutocomplete"
                async defer></script>

            <script>
                let selectedPlace = false;

                function initAutocomplete() {
                    const input = document.getElementById("shop_address");
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







            <div class="col-md-12  mt-3">
                <label for="description" class="form-label twentyfourlabel">About Shop*</label>
                <textarea class="form-controles" id="description" name="description" rows="3" placeholder="details..."
                    >{{ old('description') }}</textarea>
            </div>
            @error('description')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
            <div class="col-md-12  mt-3">
                <label for="website" class="form-label twentyfourlabel">Website (if any)</label>
                <input type="text" class="form-controles" id="website" name="website"
                    value="{{ old('website') }}" placeholder="Enter Website">
            </div>
            @error('website')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
            <div class="col-md-12 mt-3">
                <label for="facebook" class="form-label twentyfourlabel">Facebook (if any)</label>
                <input type="text" class="form-controles" id="facebook" name="facebook"
                    value="{{ old('facebook') }}" placeholder="Enter Facebook">
            </div>
            @error('facebook')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
            <div class="col-md-12  mt-3">
                <label for="instagram" class="form-label twentyfourlabel">Instagram (if any)</label>
                <input type="text" name="instagram" value="{{ old('instagram') }}" class="form-controles"
                    id="instagram" placeholder="Enter Instagram">
            </div>
            @error('instagram')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
            <div class="col-md-12  mt-3">
                <label for="twitter" class="form-label twentyfourlabel">X (if any)</label>
                <input type="text" class="form-controles" id="twitter" name="twitter"
                    value="{{ old('twitter') }}" placeholder="Enter X account">
            </div>
            @error('twitter')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
            <div
                class="col-md-12 px-5 py-3 backcolor rounded  mt-3 {{ Auth::user()->shop_pkg->metadata->images_allowed == '0' ? 'd-none' : '' }}">
                <h4 style="color:#281F48">Photos</h4>
                <p class="alert alert-dark p-2 rounded p-3" style="background-color:#281F48; color:#9D9D9D !important">
                    You can upload a minimum of <strong>1</strong> and a maximum of
                    <strong>{{ Auth::user()->shop_pkg->metadata->images_allowed }}</strong> photos.
                    The maximum file size per photo is <strong>8 MB</strong>. Allowed formats:
                    <strong>JPEG, JPG, PNG</strong>. Put the main image first.
                </p>

                <div id="imagesDropzone" class="upload-area border border-dashed rounded p-4 text-center mb-3"
                    style="cursor: pointer; min-height: 150px;">
                    <i class="bi bi-cloud-arrow-up fs-1 primary-color-custom mb-3"></i>
                    <p class="mb-2">Click or drag files here to upload</p>
                    <button type="button" class="btn" style="background-color:#281F48; color:white">
                        Select Files
                    </button>
                </div>

                <input type="file" id="shop_images" name="shop_images[]" multiple
                    accept="image/jpeg,image/jpg,image/png" class="d-none">

                <div id="shop_images_preview" class="d-flex flex-wrap gap-2 mt-3"></div>
                <div id="error-msg" class="text-danger mt-2"></div>
            </div>

            @error('shop_images')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
            <div class="col-md-12 ">
                <div class="row px-5 py-3 backcolor rounded mt-3">
                    <div class="col-md-12 ">
                        <p class="twentyeight">Services</p>
                    </div>
                    @foreach ($services as $category => $serviceGroup)
                        <p class="eighteen">{{ $category }}</p>
                        <div class="row">
                            @foreach ($serviceGroup as $service)
                                <div class="col-md-4 my-2">
                                    <div class="form-check">
                                        <input class="form-check-input feature_ad me-2  serviceee" type="checkbox"
                                            value="{{ $service->id }}" name="services[]"
                                            id="service_{{ $service->id }}">
                                        <label class="form-check-label  " for="service_{{ $service->id }}">
                                            {{ $service->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    @endforeach

                </div>
                @error('services')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-12">
                <div class="row">
                    @php
                        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                    @endphp

                    <div class="col-md-6 px-4 mt-3">
                        <div class="row">
                            <div class="col-md-12 rounded border pb-5 p-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="eighteen">Day & Time</p>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach ($days as $day)
                                        <div class="col-md-6">
                                            <div class="form-check pt-3">
                                                <input class="form-check-input  me-2" type="checkbox"
                                                    name="days[{{ $day }}][active]"
                                                    id="check_{{ $day }}">
                                                <label class="form-check-label "
                                                    for="check_{{ $day }}">{{ $day }}</label>
                                            </div>
                                        </div>
                                        <div
                                            class="col-md-6 text-end d-flex justify-content-end align-items-center gap-2 mb-1">
                                            <div class="time-picker-wrapper">
                                                <input type="time" style="    line-height: 0.9 !important;
"
                                                    name="days[{{ $day }}][start]"
                                                    id="startTimeInput{{ $day }}" value="09:00"
                                                    class="form-control">
                                                <span class="time-picker-icon"
                                                    onclick="document.getElementById('startTimeInput{{ $day }}').showPicker()">
                                                    🕒
                                                </span>
                                            </div>
                                            <span>-</span>
                                            <div class="time-picker-wrapper">
                                                <input type="time" style="    line-height: 0.9 !important;
"
                                                    name="days[{{ $day }}][end]"
                                                    id="endTimeInput{{ $day }}" value="17:00"
                                                    class="form-control">
                                                <span class="time-picker-icon"
                                                    onclick="document.getElementById('endTimeInput{{ $day }}').showPicker()">
                                                    🕒
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('days')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 border rounded mt-3 p-3 ">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="eighteen">Amenities</p>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($amenities as $amenity)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input feature_ad me-2" type="checkbox"
                                            value="{{ $amenity->id }}" id="amenity_{{ $amenity->id }}"
                                            name="amenities[]">
                                        <label class="form-check-label " for="amenity_{{ $amenity->id }}">
                                            {{ $amenity->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

            </div>
        </div>
        @php
            $shouldShowField = old('online_quotes') !== null;
        @endphp
        <div class="col-md-12 p-0 mt-3 d-none">
            <label for="exampleFormControlInput1" class="form-label twentyfourlabel">Do you provide online
                quotes?</label>
            <select class="form-controles" id="exampleFormControlInput1" name="online_quotes"
                {{ $shouldShowField ? 'required' : '' }}>
                <option value="" disabled selected>Select an option</option>
                <option value="1" {{ old('online_quotes') == '1' ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ old('online_quotes') == '0' ? 'selected' : '' }}>No</option>
            </select>

        </div>
        @error('online_quotes')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
        <div class="col-md-12 p-0 mt-3 d-none">
            <label for="exampleFormControlInput1" class="form-label twentyfourlabel">Do you offer services?</label>
            <select name="offer_services" class="form-controles">
                <option value="" disabled selected>Select an option</option>
                <option value="1" {{ old('offer_services') == '1' ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ old('offer_services') == '0' ? 'selected' : '' }}>No</option>
            </select>

        </div>
        @error('offer_services')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
        <div class="col-md-12 d-flex justify-content-end my-3">
            <button class="whitebtn px-5" type="button" data-bs-toggle="modal"
                data-bs-target="#previewmodal">Preview</button>
            <button class="bluebtn px-5 ms-3" type="submit">Save</button>
        </div>
        </form>
    </div>
    </div>


    {{-- preview modal start  --}}
    <!-- Preview Modal -->
    <div class="modal fade" id="previewmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog custom-modal-width">
            <div class="modal-content">
                <div class="modal-header" style="border:none !important">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="row mt-2">
                                    <div class="col-12 col-md-2">
                                        <div class="d-flex justify-content-center">
                                            <img id="preview-logo"
                                                src="{{ asset('web/services/images/Union (121).svg') }}"
                                                class="img-fluid" style="max-width: 100px;" alt="Shop Logo">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-9 pt-3">
                                        <h1 id="preview-shop-name" class="fourtyeight">Business Name</h1>
                                        <span id="preview-shop-address" class="twentyfourgrey">Address not provided</span>
                                        <div class="mt-2">
                                            <span id="preview-shop-phone" class="sixteen me-5"><i
                                                    class="bi bi-telephone me-2"></i>Not provided</span>
                                            <span id="preview-shop-email" class="sixteen"><i
                                                    class="bi bi-envelope me-2"></i>Not provided</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-5">
                                        <h2 class="twentyeight">About Shop</h2>
                                        <p id="preview-shop-description" class="sixteen">No description provided</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2 class="twentyeight">Photos</h2>
                                        <div class="row" id="preview-shop-images">
                                            <!-- Images will be added here dynamically -->
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-12 p-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <h2 class="mt-5 mb-3 twentyeight">Services Offered</h2>
                                                <div class="row" id="preview-services-container">
                                                    <!-- Services will be added here dynamically -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 p-3 mb-1">
                                        <div class="map-container rounded-3">
                                            <iframe id="preview-map" width="100%" height="300px" frameborder="0"
                                                style="border:0; border-radius: 8px;"
                                                src="https://www.google.com/maps?q=Unknown+Location&output=embed"
                                                allowfullscreen>
                                            </iframe>
                                            <p id="preview-map-address" class="sixteen">Address not provided <button
                                                    class="mapbutton ms-4">Get Directions <img
                                                        src="./images/Group 1171275297.svg" class="img-fluid ms-2"
                                                        style="height: 20px; width: 20px;" alt="..."></button></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-12">
                                        <div class="row">
                                            <div class="col-md-6 col-12 px-4">
                                                <h2 class="twentyeight">Hours</h2>
                                                <div class="row">
                                                    <div class="col-4" style="font-weight: 600;color: #000000;">
                                                        <p class="sixteen">Monday</p>
                                                        <p class="sixteen">Tuesday</p>
                                                        <p class="sixteen">Wednesday</p>
                                                        <p class="sixteen">Thursday</p>
                                                        <p class="sixteen">Friday</p>
                                                        <p class="sixteen">Saturday</p>
                                                        <p class="sixteen">Sunday</p>
                                                    </div>
                                                    <div class="col-8" style="font-weight: 600; color: #000000;">
                                                        <p id="preview-monday-hours" class="sixteen text-end">Closed</p>
                                                        <p id="preview-tuesday-hours" class="sixteen text-end">Closed</p>
                                                        <p id="preview-wednesday-hours" class="sixteen text-end">Closed
                                                        </p>
                                                        <p id="preview-thursday-hours" class="sixteen text-end">Closed</p>
                                                        <p id="preview-friday-hours" class="sixteen text-end">Closed</p>
                                                        <p id="preview-saturday-hours" class="sixteen text-end">Closed</p>
                                                        <p id="preview-sunday-hours" class="sixteen text-end">Closed</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12" style="color: #000000;">
                                                <div class="row">
                                                    <h2 class="twentyeight">Amenities</h2>
                                                    <div class="row" id="preview-amenities-container">
                                                        <!-- Amenities will be added here dynamically -->
                                                    </div>
                                                    <p class="twentyeight mt-3">Our Social Media</p>
                                                    <div class="col-md-12 twelve"
                                                        style="font-weight: 600; color: #000000;">
                                                        <span id="preview-facebook" class="me-5 d-none"><img
                                                                src="./images/facebook.svg" class="img-fluid me-2"
                                                                alt="..."> Facebook</span>
                                                        <span id="preview-instagram" class="me-5 d-none"><img
                                                                src="./images/instagram.svg" class="img-fluid me-2"
                                                                alt="..."> Instagram</span>
                                                        <span id="preview-twitter" class="d-none"><img
                                                                src="./images/Social Iconsxxx.svg" class="img-fluid me-2"
                                                                alt="..."> X</span>
                                                        <span id="preview-website" class="me-5 d-none"><img
                                                                src="./images/website-icon.svg" class="img-fluid me-2"
                                                                alt="..."> Website</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{-- preview modal end --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('shopForm');

            // Rules matching your Laravel validation
            const rules = {
                dealer_id: {
                    required: true
                },
                shop_name: {
                    required: true,
                    max: 255
                },
                shop_contact: {
                    required: true,
                    min: 13,
                    max: 20
                },
                shop_email: {
                    required: true,
                    email: true,
                    max: 255
                },
                services: {
                    required: true
                },
                days: {
                    required: true
                },
                province: {
                    required: true
                },
                city: {
                    required: true
                },
                postal_code: {
                    required: true,
                    max: 20
                },
                shop_address: {
                    required: true
                },
                description: {
                    required: true
                },
                shop_logo: {
                    required: true,
                    filetypes: ['jpg', 'jpeg', 'png'],
                    maxsize: 8192
                },
                website: {
                    url: true,
                    max: 255
                },
                facebook: {
                    url: true,
                    max: 255
                },
                instagram: {
                    url: true,
                    max: 255
                },
                twitter: {
                    url: true,
                    max: 255
                }
            };

            function showError(field, message) {
                removeError(field);
                field.classList.add('is-invalid');
                const errorDiv = document.createElement('div');
                errorDiv.className = 'text-danger mt-1 field-error';
                errorDiv.innerText = message;
                field.parentNode.appendChild(errorDiv);
            }

            function removeError(field) {
                field.classList.remove('is-invalid');
                const existingError = field.parentNode.querySelector('.field-error');
                if (existingError) existingError.remove();
            }

            function validateField(name, field) {
                const rule = rules[name];
                if (!rule) return true;

                let value = field.value?.trim?.() ?? '';
                let file = field.files && field.files[0];

                // Special case: services[]
                if (name == 'services') {
                    alert('hello');
                    let servicesChecked = form.querySelectorAll('input[name="services[]"]:checked').length;
                    if (rule.required && servicesChecked === 0) {
                        showError(field.closest('.backcolor') || field, 'Please select at least one service.');
                        return false;
                    }
                    removeError(field.closest('.backcolor') || field);
                    return true;
                }

                // Special case: days
                if (name === 'days') {
                    let dayBlocks = form.querySelectorAll('input[name^="days["][type="checkbox"]');
                    let validDays = false;
                    let daysError = '';

                    dayBlocks.forEach(cb => {
                        if (cb.checked) {
                            validDays = true;
                            let dayName = cb.name.match(/days\[(.*?)\]/)[1];
                            let start = form.querySelector(`[name="days[${dayName}][start]"]`)?.value;
                            let end = form.querySelector(`[name="days[${dayName}][end]"]`)?.value;
                            if (!start || !end) {
                                daysError = `Please provide start and end time for ${dayName}.`;
                            }
                        }
                    });

                    if (!validDays) {
                        showError(dayBlocks[0].closest('.border'), 'Please select at least one day.');
                        return false;
                    }
                    if (daysError) {
                        showError(dayBlocks[0].closest('.border'), daysError);
                        return false;
                    }

                    removeError(dayBlocks[0].closest('.border'));
                    return true;
                }

                // Required
                if (rule.required && (!value && !file)) {
                    showError(field, 'This field is required.');
                    return false;
                }

                // Max length
                if (rule.max && value.length > rule.max) {
                    showError(field, `Maximum ${rule.max} characters allowed.`);
                    return false;
                }

                // Min length
                if (rule.min && value.length < rule.min) {
                    showError(field, `Minimum ${rule.min} characters required.`);
                    return false;
                }

                // Email format
                if (rule.email && value && !/^\S+@\S+\.\S+$/.test(value)) {
                    showError(field, 'Please enter a valid email.');
                    return false;
                }

                // URL format
                if (rule.url && value && !/^(https?:\/\/)?([\w-]+\.)+[\w-]{2,}(\/.*)?$/.test(value)) {
                    showError(field, 'Please enter a valid URL.');
                    return false;
                }

                // File type check
                if (file && rule.filetypes) {
                    const ext = file.name.split('.').pop().toLowerCase();
                    if (!rule.filetypes.includes(ext)) {
                        showError(field, `Allowed file types: ${rule.filetypes.join(', ')}`);
                        return false;
                    }
                }

                // File size check (KB)
                if (file && rule.maxsize) {
                    const sizeKB = file.size / 1024;
                    if (sizeKB > rule.maxsize) {
                        showError(field, `Max file size is ${rule.maxsize / 1024} MB`);
                        return false;
                    }
                }

                removeError(field);
                return true;
            }


            form.addEventListener('submit', function(e) {
                let valid = true;
                Object.keys(rules).forEach(name => {
                    const field = document.getElementById(name) || form.querySelector(
                        `[name="${name}"]`);
                    if (field && !validateField(name, field)) {
                        valid = false;
                    }
                });
                if (!valid) e.preventDefault();
            });


            // Live validation
            Object.keys(rules).forEach(name => {
                const field = document.getElementById(name) || form.querySelector(`[name="${name}"]`);
                if (field) {
                    field.addEventListener('input', () => validateField(name, field));
                    field.addEventListener('change', () => validateField(name, field));
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imagesDropzone = document.getElementById('imagesDropzone');
            const imagesInput = document.getElementById('shop_images');
            const previewContainer = document.getElementById('shop_images_preview');
            const errorMsg = document.getElementById('error-msg');
            const maxAllowedImages = parseInt(`{{ Auth::user()->shop_pkg->metadata->images_allowed }}` || 0);
            let uploadedFiles = [];

            // Handle click
            imagesDropzone.addEventListener('click', function() {
                imagesInput.click();
            });

            // Handle drag and drop
            imagesDropzone.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('border-primary');
            });

            imagesDropzone.addEventListener('dragleave', function() {
                this.classList.remove('border-primary');
            });

            imagesDropzone.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('border-primary');

                if (e.dataTransfer.files.length) {
                    handleImageFiles(e.dataTransfer.files);
                }
            });

            // Handle file selection
            imagesInput.addEventListener('change', function() {
                if (this.files.length) {
                    handleImageFiles(this.files);
                }
            });

            function handleImageFiles(files) {
                errorMsg.textContent = '';

                // Check total files count
                if (uploadedFiles.length + files.length > maxAllowedImages) {
                    errorMsg.textContent = `You can upload maximum ${maxAllowedImages} images.`;
                    return;
                }

                // Process each file
                Array.from(files).forEach(file => {
                    // Check if file already exists
                    if (uploadedFiles.some(f => f.name === file.name && f.size === file.size)) {
                        return;
                    }

                    // Validate file type
                    if (!['image/jpeg', 'image/jpg', 'image/png'].includes(file.type)) {
                        errorMsg.textContent = 'Only JPG, JPEG, and PNG files are allowed.';
                        return;
                    }

                    // Validate file size
                    if (file.size > 8 * 1024 * 1024) {
                        errorMsg.textContent = 'Each image must be smaller than 8MB.';
                        return;
                    }

                    // Add to uploaded files
                    uploadedFiles.push(file);

                    // Create preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewItem = document.createElement('div');
                        previewItem.className = 'position-relative';
                        previewItem.style.width = '120px';
                        previewItem.style.height = '120px';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-thumbnail w-100 h-100';
                        img.style.objectFit = 'cover';

                        const removeBtn = document.createElement('button');
                        removeBtn.innerHTML = '×';
                        removeBtn.className =
                            'btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle';
                        removeBtn.style.transform = 'translate(50%, -50%)';
                        removeBtn.onclick = function() {
                            uploadedFiles = uploadedFiles.filter(f => f !== file);
                            previewItem.remove();
                            updateImagesInput();
                        };

                        previewItem.appendChild(img);
                        previewItem.appendChild(removeBtn);
                        previewContainer.appendChild(previewItem);

                        updateImagesInput();
                    };
                    reader.readAsDataURL(file);
                });
            }

            function updateImagesInput() {
                const dataTransfer = new DataTransfer();
                uploadedFiles.forEach(file => dataTransfer.items.add(file));
                imagesInput.files = dataTransfer.files;
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dayCheckboxes = document.querySelectorAll('input[type="checkbox"][id^="check_"]');

            dayCheckboxes.forEach(checkbox => {
                const day = checkbox.id.replace('check_', '');
                const startInput = document.querySelector(`input[name="days[${day}][start]"]`);
                const endInput = document.querySelector(`input[name="days[${day}][end]"]`);

                // Initial state
                toggleTimeFields(checkbox, startInput, endInput);

                checkbox.addEventListener('change', function() {
                    toggleTimeFields(checkbox, startInput, endInput);
                });
            });

            function toggleTimeFields(checkbox, startInput, endInput) {
                const enabled = checkbox.checked;
                startInput.disabled = !enabled;
                endInput.disabled = !enabled;
            }
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('[data-bs-target="#previewmodal"]').addEventListener('click', function() {
                // Basic info
                document.getElementById('preview-shop-name').textContent =
                    document.getElementById('shop_name').value || 'Business Name';

                document.getElementById('preview-shop-address').textContent =
                    document.getElementById('shop_address').value || 'Address not provided';

                document.getElementById('preview-shop-phone').innerHTML =
                    '<i class="bi bi-telephone me-2"></i>' +
                    (document.getElementById('shop_contact').value || 'Not provided');

                document.getElementById('preview-shop-email').innerHTML =
                    '<i class="bi bi-envelope me-2"></i>' +
                    (document.getElementById('shop_email').value || 'Not provided');

                document.getElementById('preview-shop-description').textContent =
                    document.getElementById('description').value || 'No description provided';

                // Map update
                const address = document.getElementById('shop_address').value || 'Unknown Location';
                document.getElementById('preview-map').src =
                    `https://www.google.com/maps?q=${encodeURIComponent(address)}&output=embed`;
                document.getElementById('preview-map-address').textContent = address;

                // Days and hours
                const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                days.forEach(day => {
                    const checkbox = document.getElementById(`check_${day}`);
                    const startTime = document.querySelector(`input[name="days[${day}][start]"]`)
                        .value;
                    const endTime = document.querySelector(`input[name="days[${day}][end]"]`).value;

                    const dayHours = document.getElementById(`preview-${day.toLowerCase()}-hours`);

                    if (checkbox.checked && startTime && endTime) {
                        dayHours.textContent = `${startTime} - ${endTime}`;
                        dayHours.style.color = 'green';
                    } else {
                        dayHours.textContent = 'Closed';
                        dayHours.style.color = 'orangered';
                    }
                });

                // Services (without icons/images)
                const servicesContainer = document.getElementById('preview-services-container');
                servicesContainer.innerHTML = '';

                const selectedServices = Array.from(document.querySelectorAll(
                        'input[name="services[]"]:checked'))
                    .map(service => ({
                        id: service.value,
                        name: service.nextElementSibling.textContent.trim()
                    }));

                if (selectedServices.length === 0) {
                    servicesContainer.innerHTML = '<p class="sixteen">No services selected</p>';
                } else {
                    const chunkSize = Math.ceil(selectedServices.length / 3);
                    for (let i = 0; i < 3; i++) {
                        const colDiv = document.createElement('div');
                        colDiv.className = 'col-md-4 col-6';

                        const servicesChunk = selectedServices.slice(i * chunkSize, (i + 1) * chunkSize);
                        servicesChunk.forEach(service => {
                            const serviceElement = document.createElement('p');
                            serviceElement.className = 'eighteen';
                            serviceElement.textContent = service.name;
                            colDiv.appendChild(serviceElement);
                        });

                        servicesContainer.appendChild(colDiv);
                    }
                }

                // Amenities
                const amenitiesContainer = document.getElementById('preview-amenities-container');
                amenitiesContainer.innerHTML = '';

                const selectedAmenities = Array.from(document.querySelectorAll(
                        'input[name="amenities[]"]:checked'))
                    .map(amenity => amenity.nextElementSibling.textContent.trim());

                if (selectedAmenities.length === 0) {
                    amenitiesContainer.innerHTML = '<p class="sixteen">No amenities selected</p>';
                } else {
                    const chunkSize = Math.ceil(selectedAmenities.length / 2);
                    for (let i = 0; i < 2; i++) {
                        const colDiv = document.createElement('div');
                        colDiv.className = 'col-md-6';

                        const amenitiesChunk = selectedAmenities.slice(i * chunkSize, (i + 1) * chunkSize);
                        amenitiesChunk.forEach(amenity => {
                            const amenityElement = document.createElement('p');
                            amenityElement.className = 'sixteen';
                            amenityElement.innerHTML =
                                `<i class="bi bi-check-circle me-2"></i>${amenity}`;
                            colDiv.appendChild(amenityElement);
                        });

                        amenitiesContainer.appendChild(colDiv);
                    }
                }

                // Social media
                const website = document.getElementById('website').value;
                const facebook = document.getElementById('facebook').value;
                const instagram = document.getElementById('instagram').value;
                const twitter = document.getElementById('twitter').value;

                const previewWebsite = document.getElementById('preview-website');
                const previewFacebook = document.getElementById('preview-facebook');
                const previewInstagram = document.getElementById('preview-instagram');
                const previewTwitter = document.getElementById('preview-twitter');



                if (facebook) {
                    previewFacebook.classList.remove('d-none');
                    previewFacebook.innerHTML =
                        `<img src="{{ asset('web/services/images/facebook.svg') }}" class="img-fluid me-2" alt="..."> ${facebook}`;
                } else {
                    previewFacebook.classList.add('d-none');
                }

                if (instagram) {
                    previewInstagram.classList.remove('d-none');
                    previewInstagram.innerHTML =
                        `<img src="{{ asset('web/services/images/instagram.svg') }}" class="img-fluid me-2" alt="..."> ${instagram}`;
                } else {
                    previewInstagram.classList.add('d-none');
                }

                if (twitter) {
                    previewTwitter.classList.remove('d-none');
                    previewTwitter.innerHTML =
                        `<img src="{{ asset('web/services/images/Social Iconsxxx.svg') }}" class="img-fluid me-2" alt="..."> ${twitter}`;
                } else {
                    previewTwitter.classList.add('d-none');
                }

                const imagesPreview = document.getElementById('preview-shop-images');
                imagesPreview.innerHTML = '';

                const imageThumbnails = document.querySelectorAll('#shop_images_preview img');

                if (imageThumbnails.length > 0) {
                    imageThumbnails.forEach((img, index) => {
                        const colDiv = document.createElement('div');
                        colDiv.className = index === 0 ? 'col-md-9' : 'col-md-3';

                        const imgDiv = document.createElement('div');
                        imgDiv.className = 'col-12 mt-md-0 mt-3';

                        const newImg = document.createElement('img');
                        newImg.src = img.src;
                        newImg.className = 'img-fluid';
                        newImg.alt = 'Shop image';
                        newImg.style.borderRadius = '8px';
                        newImg.style.maxHeight = index === 0 ? '300px' : '140px';
                        newImg.style.width = '100%';
                        newImg.style.objectFit = 'cover';

                        imgDiv.appendChild(newImg);
                        colDiv.appendChild(imgDiv);
                        imagesPreview.appendChild(colDiv);
                    });
                } else {
                    imagesPreview.innerHTML = '<p class="sixteen">No images uploaded</p>';
                }

            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoDropzone = document.getElementById('logoDropzone');
            const logoInput = document.getElementById('shop_logo');
            const logoPreviewContainer = document.getElementById('logoPreviewContainer');
            const logoDropText = document.getElementById('logoDropText');

            // Handle click
            logoDropzone.addEventListener('click', function() {
                logoInput.click();
            });

            // Handle drag and drop
            logoDropzone.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('border-primary');
            });

            logoDropzone.addEventListener('dragleave', function() {
                this.classList.remove('border-primary');
            });

            logoDropzone.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('border-primary');

                if (e.dataTransfer.files.length) {
                    logoInput.files = e.dataTransfer.files;
                    handleLogoFile(e.dataTransfer.files[0]);
                }
            });

            // Handle file selection
            logoInput.addEventListener('change', function() {
                if (this.files.length) {
                    handleLogoFile(this.files[0]);
                }
            });

            function handleLogoFile(file) {
                // Validate file type
                if (!['image/png', 'image/svg+xml'].includes(file.type)) {
                    alert('Only PNG and SVG files are allowed for the logo.');
                    return;
                }

                // Validate file size
                if (file.size > 8 * 1024 * 1024) {
                    alert('Logo must be smaller than 8MB.');
                    return;
                }

                // Create preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    logoPreviewContainer.innerHTML = '';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '100%';
                    img.style.maxHeight = '100%';
                    img.style.objectFit = 'contain';

                    logoPreviewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('shop_contact');

            function formatPhoneNumber(input) {
                let value = input.value.replace(/\D/g, ''); // Remove non-digits

                if (!value.startsWith('92')) {
                    value = '92' + value;
                }

                value = value.substring(0, 13); // Max: 92 + 11 digits

                // Format: +92 XXX XXXXXXX
                let formatted = '+92';
                if (value.length > 2) {
                    formatted += ' ' + value.substring(2, 5);
                }
                if (value.length > 5) {
                    formatted += ' ' + value.substring(5, 12);
                }

                input.value = formatted;
            }

            input.addEventListener('input', function() {
                formatPhoneNumber(this);
            });

            input.addEventListener('keydown', function(e) {
                if (this.selectionStart <= 4 && (e.key === 'Backspace' || e.key === 'Delete')) {
                    e.preventDefault(); // Prevent deleting "+92"
                }
            });

            // Optional: format existing value on page load
            formatPhoneNumber(input);
        });
    </script>

    <!-- In your <head> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Replace the icon span -->
    <span class="time-picker-icon" onclick="document.getElementById('startTimeInput').showPicker()">

    </span>
@endsection
