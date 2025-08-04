@extends('layout.superadmin_layout.main')

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
            padding-right: 2.5rem;
            /* Space for the icon */
            line-height: 1.5;
        }

        .time-picker-icon {
            position: absolute;
            top: 50%;
            right: 0.75rem;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            font-size: 1.2rem;
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

        .time-picker-wrapper input[type="time"] {
            padding-right: 0rem;
            line-height: 1;
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

                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                @if (session('response'))
                    <div class="alert alert-success">
                        {{ session('response') }}
                    </div>
                @endif



                <form action="{{ route('superadmin.shops.update', $shop->id) }}" method="Post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="latitude" id="latitude" value="{{ $shop->latitude }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ $shop->longitude }}">
                    <div class="row d-flex align-items-baseline">
                        <div class="col-md-9 ps-0">
                            <label for="shop_name" class="form-label twentyfourlabel">Shop name*</label>
                            <input type="text" class="form-controles" id="shop_name" name="shop_name"
                                placeholder="Enter Shop name" value="{{ $shop->name }}" required>
                        </div>
                        @error('shop_name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                        <div class="col-md-3">
                            <div id="logoDropzone" class="dropzone text-center border border-dashed p-4 rounded"
                                style="cursor: pointer; min-height: 150px;">
                                <div id="logoPreviewContainer">
                                    <img id="previewIcon" src="{{ $shop->logo ?? 'default-logo.png' }}" alt="Shop Logo"
                                        class="img-fluid" style="max-height: 100px;">
                                    <p id="logoDropText" class="upload-text mt-2">Click or drag logo here</p>
                                </div>
                                <input type="file" id="shop_logo" name="shop_logo" accept="image/*" hidden>
                            </div>
                        </div>
                        @error('shop_logo')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
            </div>

            <div class="col-md-6 ps-0">
                <label for="shop_contact" class="form-label twentyfourlabel">Shop Phone number*</label>
                <input type="text" class="form-controles" id="shop_contact" name="shop_contact"
                    placeholder="Enter Shop Phone number"
                    value="+92 {{ substr($shop->number, 3, 3) }} {{ substr($shop->number, 7) }}" maxlength="16" required
                    oninput="formatPhoneNumber(this)" />


            </div>
            @error('shop_contact')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
            <div class="col-md-6 pe-0">
                <label for="shop_email" class="form-label twentyfourlabel">Shop Email*</label>
                <input type="email" class="form-controles" id="shop_email" name="shop_email"
                    placeholder="Enter Shop Email" value="{{ $shop->email }}"required>
            </div>
            @error('shop_email')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
            <div class="col-md-4 ps-0 mt-3">
                <label for="province" class="form-label twentyfourlabel">Province*</label>
                <select class="form-select" aria-label="Default select example" name="province"
                    style="background-color:#F0F3F6 !important ; color:#000000" id="province"required>
                    <option selected>Select province</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->id }}" {{ $shop->province == $province->id ? 'selected' : '' }}>
                            {{ $province->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('province')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
            <div class="col-md-4 mt-3">
                <label for="city" class="form-label twentyfourlabel">city*</label>
                <select class="form-select" aria-label="Default select example" name="city" id="city"
                    style="background-color:#F0F3F6 !important ; color:#000000 ; width:100% !important" required>
                    <option selected>Select Province first</option>
                    @foreach ($cities as $city)
                        @if ($shop->city == $city->id)
                            <option value="{{ $city->id }}" {{ $shop->city == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            @error('city')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
            <div class="col-md-4 pe-0 mt-3">
                <label for="postal_code" class="form-label twentyfourlabel">Postal Code*</label>
                <input type="text" class="form-controles" id="postal_code" placeholder="Enter Postal Code"
                    value="{{ $shop->postal_code }}" name="postal_code" required>
            </div>
            @error('postal_code')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
            <div class="col-md-12 p-0 mt-3">
                <label for="shop_address" class="form-label twentyfourlabel">Shop Address*</label>
                <input type="text" class="form-controles" id="shop_address" name="shop_address"
                    value="{{ $shop->address }}" placeholder="Enter Shop Address"required>
            </div>
            @error('shop_address')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror



            <script
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHTfGE9bbvleasezO-T-j1u5UVm6aTnl0&libraries=places&callback=initAutocomplete"
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
            <div class="col-md-12 p-0 mt-3">
                <label for="description" class="form-label twentyfourlabel">About Shop*</label>
                <textarea class="form-controles" id="description" name="description" rows="3" placeholder="details..."
                    required>{{ $shop->description }}</textarea>
            </div>
            @error('description')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
            <div class="col-md-12 p-0 mt-3">
                <label for="website" class="form-label twentyfourlabel">Website (if any)</label>
                <input type="text" class="form-controles" id="website" name="website"
                    value="{{ $shop->website }}" placeholder="Enter Website">
            </div>
            @error('website')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
            <div class="col-md-12 p-0 mt-3">
                <label for="facebook" class="form-label twentyfourlabel">Facebook (if any)</label>
                <input type="text" class="form-controles" id="facebook" name="facebook"
                    value="{{ $shop->facebook }}" placeholder="Enter Facebook">
            </div>
            @error('facebook')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
            <div class="col-md-12 p-0 mt-3">
                <label for="instagram" class="form-label twentyfourlabel">Instagram (if any)</label>
                <input type="text" name="instagram" value="{{ $shop->instagram }}" class="form-controles"
                    id="instagram" placeholder="Enter Instagram">
            </div>
            @error('instagram')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
            <div class="col-md-12 p-0 mt-3">
                <label for="twitter" class="form-label twentyfourlabel">X (if any)</label>
                <input type="text" class="form-controles" id="twitter" name="twitter"
                    value="{{ $shop->twitter }}" placeholder="Enter X account">
            </div>
            @error('twitter')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
            <div class="col-md-12 px-5 py-3 backcolor rounded p-0 mt-3">
                <h4 style="color:#281F48">Photos</h4>
                <p class="alert alert-dark p-2 rounded p-3" style="background-color:#281F48; color:#9D9D9D !important">
                    You can upload a minimum of 1 and a maximum of
                    <span id="maxImagesAllowed">20</span> photos.
                    Max file size: 8 MB. Allowed formats: JPEG, JPG, PNG.
                </p>

                <div id="imagesDropzone" class="border border-dashed rounded p-4 text-center mb-3"
                    style="cursor: pointer; min-height: 150px;">
                    <i class="bi bi-cloud-arrow-up fs-1 mb-3" style="color: #281F48;"></i>
                    <p class="mb-2">Click or drag files here to upload</p>
                    <button type="button" class="btn" style="background-color:#281F48; color:white">
                        Select Files
                    </button>
                </div>

                <input type="file" id="shop_images" name="shop_images[]" multiple
                    accept="image/jpeg,image/jpg,image/png" class="d-none">

                <div id="shop_images_preview" class="d-flex flex-wrap gap-2 mt-3">
                    <!-- Existing images from backend will be loaded here -->
                    @foreach ($shop->shop_images as $image)
                        <div class="position-relative" style="width: 120px; height: 120px;">
                            <img src="{{ $image->path }}" class="img-thumbnail w-100 h-100" style="object-fit: cover;"
                                alt="Existing Image">
                            <a href="{{ route('superadmin.delete.shop.image', [$image->id, $shop->id]) }}"
                                class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle"
                                style="transform: translate(50%, -50%);"
                                >×</a>
                            <input type="hidden" name="existing_images[]" value="{{ $image->id }}">
                        </div>
                    @endforeach
                </div>
                <div id="error-msg" class="text-danger mt-2"></div>
            </div>
            @error('shop_images')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
            <div class="col-md-12 px-5 py-3 backcolor rounded p-0 mt-3">
                <div class="row">
                    <div class="col-md-12 ">
                        <p class="twentyeight">Services</p>
                    </div>
                    @php
                        $shopservices = $shop->shop_services->pluck('service_id')->toArray();
                    @endphp
                    @foreach ($services as $category => $serviceGroup)
                        <p class="eighteen">{{ $category }}</p>
                        <div class="row">
                            @foreach ($serviceGroup as $service)
                                <div class="col-md-4 my-2">
                                    <div class="form-check">
                                        <input class="form-check-input feature_ad me-2 serviceee" type="checkbox"
                                            value="{{ $service->id }}" name="services[]"
                                            id="service_{{ $service->id }}"
                                            {{ in_array($service->id, $shopservices) ? 'checked' : '' }}>
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

                    <div class="col-md-6 pe-4 mt-3">
                        <div class="row">
                            <div class="col-md-12 rounded border pb-5 p-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="eighteen">Day & Time</p>
                                    </div>
                                </div>
                                <div class="row">
                                    @php
                                        $shopDays = $shop->shop_timings->pluck('day')->toArray();
                                        $shopTimings = $shop->shop_timings->keyBy('day'); // Create a key-value array by day for easy access
                                    @endphp

                                    @foreach ($days as $day)
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input me-2" type="checkbox"
                                                    name="days[{{ $day }}][active]"
                                                    id="check_{{ $day }}"
                                                    @if (in_array($day, $shopDays)) checked @endif>
                                                <label class="form-check-label "
                                                    for="check_{{ $day }}">{{ $day }}</label>
                                            </div>
                                        </div>
                                        <div
                                            class="col-md-6 text-end d-flex justify-content-end align-items-center gap-2 mb-1">

                                            <div class="time-picker-wrapper">
                                                <input type="time" style="    line-height: 1 !important;"
                                                    name="days[{{ $day }}][start]"
                                                    id="startTimeInput_{{ $day }}"
                                                    value="{{ isset($shopTimings[$day]) ? $shopTimings[$day]->start_time : '09:00' }}"
                                                    class="form-control ps-0 pe-2">
                                                <span class="time-picker-icon ps-5"
                                                    onclick="document.getElementById('startTimeInput_{{ $day }}').showPicker()">
                                                    🕒
                                                </span>
                                            </div>
                                            <span>-</span>
                                            <div class="time-picker-wrapper">
                                                <input type="time" style="    line-height: 1 !important;"
                                                    name="days[{{ $day }}][end]"
                                                    id="endTimeInput_{{ $day }}"
                                                    value="{{ isset($shopTimings[$day]) ? $shopTimings[$day]->end_time : '17:00' }}"
                                                    class="form-control ps-0 pe-2">
                                                <span class="time-picker-icon ps-5"
                                                    onclick="document.getElementById('endTimeInput_{{ $day }}').showPicker()">
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
                            @php
                                $shopAmenities = $shop->shop_amenities->pluck('amenity_id')->toArray();
                            @endphp
                            @foreach ($amenities as $amenity)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input feature_ad me-2" type="checkbox"
                                            value="{{ $amenity->id }}" id="amenity_{{ $amenity->id }}"
                                            name="amenities[]"
                                            {{ in_array($amenity->id, $shopAmenities) ? 'checked' : '' }}>
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
        <div class="col-md-12 p-0 mt-3 d-none">
            <label for="exampleFormControlInput1" class="form-label twentyfourlabel">Do you provide online
                quotes?</label>
            <select class="form-controles" id="exampleFormControlInput1" name="online_quotes" required>
                <option value="" disabled selected>Select an option</option>
                <option value="1" {{ $shop->online_quotes == '1' ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ $shop->online_quotes == '0' ? 'selected' : '' }}>No</option>
            </select>

        </div>
        @error('online_quotes')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
        <div class="col-md-12 p-0 mt-3 d-none">
            <label for="exampleFormControlInput1" class="form-label twentyfourlabel">Do you offer services?</label>
            <select name="offer_services" class="form-controles">
                <option value="" disabled selected>Select an option</option>
                <option value="1" {{ $shop->offer_services == '1' ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ $shop->offer_services == '0' ? 'selected' : '' }}>No</option>
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


    {{-- Preview Modal --}}
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
                                    <div class="col-12 col-md-2 d-flex align-items-center">
                                        <div class="d-flex justify-content-center" style="height:120px ; width:100%">
                                            <img id="preview-logo" src="{{ $shop->logo }}" class="img-fluid"
                                                style="max-width: 100px;border-radius:50%;" alt="Shop Logo">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-9 pt-3">
                                        <h1 id="preview-shop-name" class="fourtyeight">{{ $shop->name }}</h1>
                                        <span id="preview-shop-address"
                                            class="twentyfourgrey">{{ $shop->address }}</span>
                                        <div class="mt-2">
                                            <span id="preview-shop-phone" class=" me-5"><i
                                                    class="bi bi-telephone me-2"></i>{{ $shop->number }}</span>
                                            <span id="preview-shop-email" class=""><i
                                                    class="bi bi-envelope me-2"></i>{{ $shop->email }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-5">
                                        <h2 class="twentyeight">About Shop</h2>
                                        <p id="preview-shop-description" class="">{{ $shop->description }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2 class="twentyeight">Photos</h2>
                                        <div class="row" id="preview-shop-images">
                                            {{-- First large image --}}
                                            @if (count($shop->shop_images) > 0)
                                                <div class="col-md-9 mb-3">
                                                    <img src="{{ $shop->shop_images[0]->path }}" class="img-fluid"
                                                        style="max-height: 300px; width: 100%; object-fit: cover; border-radius: 8px;"
                                                        alt="Shop Image">
                                                </div>
                                            @endif

                                            {{-- Next two stacked vertically in col-md-3 --}}
                                            @if (count($shop->shop_images) > 2)
                                                <div class="col-md-3 d-flex flex-column gap-3">
                                                    @for ($i = 1; $i <= 2; $i++)
                                                        @if (isset($shop->shop_images[$i]))
                                                            <div>
                                                                <img src="{{ $shop->shop_images[$i]->path }}"
                                                                    class="img-fluid"
                                                                    style="max-height: 140px; width: 100%; object-fit: cover; border-radius: 8px;"
                                                                    alt="Shop Image">
                                                            </div>
                                                        @endif
                                                    @endfor
                                                </div>
                                            @endif

                                            {{-- Remaining images (4th and 5th...) shown horizontally --}}
                                            @if (count($shop->shop_images) > 3)
                                                <div class="col-md-12 mt-3 d-flex gap-3 flex-wrap">
                                                    @foreach ($shop->shop_images as $index => $image)
                                                        @if ($index > 2)
                                                            <div style="width: 200px;">
                                                                <img src="{{ $image->path }}" class="img-fluid"
                                                                    style="height: 140px; width: 100%; object-fit: cover; border-radius: 8px;"
                                                                    alt="Shop Image">
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-12 p-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <h2 class="mt-5 mb-3 twentyeight">Services Offered</h2>
                                                <div class="row" id="preview-services-container">
                                                    @foreach ($shop->shop_services->chunk(ceil($shop->shop_services->count() / 3)) as $chunk)
                                                        <div class="col-md-4 col-6">
                                                            <div class="row d-flex align-items-center">
                                                                @foreach ($chunk as $service)
                                                                    <div class="col-md-3 mt-2">

                                                                        <img class="img-fluid rounded"
                                                                            src="{{ $service->service->icon }}"
                                                                            alt="">

                                                                    </div>
                                                                    <div class="col-md-9 mt-2">

                                                                        <p class="">{{ $service->service->name }}
                                                                        </p>

                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 p-3 mb-1">
                                        <div class="map-container rounded-3">
                                            <iframe id="preview-map" width="100%" height="300px" frameborder="0"
                                                style="border:0; border-radius: 8px;"
                                                src="https://www.google.com/maps?q={{ urlencode($shop->address) }}&output=embed"
                                                allowfullscreen>
                                            </iframe>
                                            <p id="preview-map-address" class="">{{ $shop->address }} <button
                                                    class="mapbutton ms-4">Get Directions <img
                                                        src="{{ asset('web/services/images/Group 1171275297.svg') }}"
                                                        class="img-fluid ms-2" style="height: 20px; width: 20px;"
                                                        alt="..."></button></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-12">
                                        <div class="row">
                                            <div class="col-md-6 col-12 px-4">
                                                <h2 class="twentyeight">Hours</h2>
                                                <div class="row">
                                                    <div class="col-4" style="font-weight: 400;color: #000000;">
                                                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                                            <p class="sixteen">{{ $day }}</p>
                                                        @endforeach
                                                    </div>
                                                    <div class="col-8" style="font-weight: 400; color: #000000;">
                                                        @foreach ($days as $day)
                                                            @php
                                                                $timing = $shop->shop_timings
                                                                    ->where('day', $day)
                                                                    ->first();
                                                            @endphp
                                                            <p id="preview-{{ strtolower($day) }}-hours"
                                                                class="sixteen text-end">
                                                                @if ($timing)
                                                                    {{ $timing->start_time }} - {{ $timing->end_time }}
                                                                @else
                                                                    Closed
                                                                @endif
                                                            </p>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12" style="color: #000000;">
                                                <div class="row">
                                                    <h2 class="twentyeight">Amenities</h2>
                                                    <div class="row" id="preview-amenities-container">
                                                        @foreach ($shop->shop_amenities->chunk(ceil($shop->shop_amenities->count() / 2)) as $chunk)
                                                            <div class="col-md-6">
                                                                @foreach ($chunk as $amenity)
                                                                    <p class="sixteen"><i
                                                                            class="bi bi-check-circle me-2"></i>{{ $amenity->amenity->name }}
                                                                    </p>
                                                                @endforeach
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <p class="twentyeight mt-3">Our Social Media</p>
                                                    <div class="col-md-12 twelve"
                                                        style="font-weight: 600; color: #000000;">
                                                        @if ($shop->facebook)
                                                            <p id="preview-facebook" class="me-5"><img
                                                                    src="{{ asset('web/services/images/facebook.svg') }}"
                                                                    class="img-fluid me-2" alt="...">
                                                                {{ $shop->facebook }}</p>
                                                        @endif
                                                        @if ($shop->instagram)
                                                            <p id="preview-instagram" class="me-5"><img
                                                                    src="{{ asset('web/services/images/instagram.svg') }}"
                                                                    class="img-fluid me-2" alt="...">
                                                                {{ $shop->instagram }}</p>
                                                        @endif
                                                        @if ($shop->twitter)
                                                            <p id="preview-twitter"><img
                                                                    src="{{ asset('web/services/images/Social Iconsxxx.svg') }}"
                                                                    class="img-fluid me-2" alt="...">
                                                                {{ $shop->twitter }}</p>
                                                        @endif

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



    {{-- success modal start --}}


    <div class="modal fade" id="imagedeleteresponse" tabindex="-1" aria-labelledby="imagedeleteresponseLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                <!-- Modal Header -->
                <div class="modal-header"
                    style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                    <h5 class="modal-title" id="imagedeleteresponseLabel"><strong> Edit Shop</strong></h5>
                    <button type="button" class="btn-close"
                        style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body text-center" style="background-color: #F0F3F6; color: #FD5631;">
                    <p>{{ session('imagedeleteresponse') }}</p>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                    <button type="button" class="btn btn-light px-4 py-2 "
                        style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- success modal end --}}

    @if (session('imagedeleteresponse'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                let modal = new bootstrap.Modal(document.getElementById('imagedeleteresponse'));
                modal.show();
            });
        </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imagesDropzone = document.getElementById('imagesDropzone');
            const imagesInput = document.getElementById('shop_images');
            const previewContainer = document.getElementById('shop_images_preview');
            const errorMsg = document.getElementById('error-msg');
            const maxAllowedImages = parseInt(document.getElementById('maxImagesAllowed').textContent) || 10;

            // Count existing images from backend
            const existingImages = document.querySelectorAll('#shop_images_preview .position-relative');
            let uploadedFiles = [];
            let existingImagesCount = existingImages.length;

            // Click handler
            imagesDropzone.addEventListener('click', function() {
                imagesInput.click();
            });

            // Drag and drop handlers
            imagesDropzone.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.style.borderColor = '#281F48';
                this.style.backgroundColor = 'rgba(40, 31, 72, 0.1)';
            });

            imagesDropzone.addEventListener('dragleave', function() {
                this.style.borderColor = '';
                this.style.backgroundColor = '';
            });

            imagesDropzone.addEventListener('drop', function(e) {
                e.preventDefault();
                this.style.borderColor = '';
                this.style.backgroundColor = '';

                if (e.dataTransfer.files.length) {
                    handleImageFiles(e.dataTransfer.files);
                }
            });

            // File input change handler
            imagesInput.addEventListener('change', function() {
                if (this.files.length) {
                    handleImageFiles(this.files);
                }
            });

            function handleImageFiles(files) {
                errorMsg.textContent = '';

                // Check total files count (existing + new)
                if (existingImagesCount + uploadedFiles.length + files.length > maxAllowedImages) {
                    errorMsg.textContent =
                        `Maximum ${maxAllowedImages} files allowed (${existingImagesCount} existing).`;
                    return;
                }

                // Process each file
                Array.from(files).forEach(file => {
                    // Check if file already exists
                    if (uploadedFiles.some(f => f.name === file.name && f.size === file.size)) {
                        return;
                    }

                    // Validate file type
                    if (!file.type.match(/image\/(jpeg|jpg|png)/)) {
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

            // Function to handle existing image removal
            window.removeExistingImage = function(button, imageId) {
                if (confirm('Are you sure you want to remove this image?')) {
                    const container = button.closest('.position-relative');

                    // Create a hidden input to mark this image for deletion
                    const deleteInput = document.createElement('input');
                    deleteInput.type = 'hidden';
                    deleteInput.name = 'deleted_images[]';
                    deleteInput.value = imageId;
                    document.querySelector('form').appendChild(deleteInput);

                    // Remove the image container
                    container.remove();
                    existingImagesCount--;
                }
            };
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoDropzone = document.getElementById('logoDropzone');
            const logoInput = document.getElementById('shop_logo');
            const logoPreviewContainer = document.getElementById('logoPreviewContainer');
            const previewIcon = document.getElementById('previewIcon');
            const logoDropText = document.getElementById('logoDropText');

            // Click handler
            logoDropzone.addEventListener('click', function() {
                logoInput.click();
            });

            // Drag and drop handlers
            logoDropzone.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.style.borderColor = '#281F48';
                this.style.backgroundColor = 'rgba(40, 31, 72, 0.1)';
            });

            logoDropzone.addEventListener('dragleave', function() {
                this.style.borderColor = '';
                this.style.backgroundColor = '';
            });

            logoDropzone.addEventListener('drop', function(e) {
                e.preventDefault();
                this.style.borderColor = '';
                this.style.backgroundColor = '';

                if (e.dataTransfer.files.length) {
                    handleLogoFile(e.dataTransfer.files[0]);
                }
            });

            // File input change handler
            logoInput.addEventListener('change', function() {
                if (this.files.length) {
                    handleLogoFile(this.files[0]);
                }
            });

            function handleLogoFile(file) {
                // Validate file type
                if (!file.type.match('image.*')) {
                    alert('Please select an image file');
                    return;
                }

                // Validate file size (8MB)
                if (file.size > 8 * 1024 * 1024) {
                    alert('File size must be less than 8MB');
                    return;
                }

                // Create preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewIcon.src = e.target.result;
                    previewIcon.style.display = 'block';
                    logoDropText.style.display = 'none';
                };
                reader.readAsDataURL(file);
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
            // Preview button click handler
            document.querySelector('[data-bs-target="#previewmodal"]').addEventListener('click', function() {
                // Basic info
                document.getElementById('preview-shop-name').textContent =
                    document.getElementById('shop_name').value || '{{ $shop->name }}';

                document.getElementById('preview-shop-address').textContent =
                    document.getElementById('shop_address').value || '{{ $shop->address }}';

                document.getElementById('preview-shop-phone').innerHTML =
                    '<i class="bi bi-telephone me-2"></i>' +
                    (document.getElementById('shop_contact').value || '{{ $shop->number }}');

                document.getElementById('preview-shop-email').innerHTML =
                    '<i class="bi bi-envelope me-2"></i>' +
                    (document.getElementById('shop_email').value || '{{ $shop->email }}');

                document.getElementById('preview-shop-description').textContent =
                    document.getElementById('description').value || '{{ $shop->description }}';

                // Update map
                const address = document.getElementById('shop_address').value || '{{ $shop->address }}';
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

                // Services
                const servicesContainer = document.getElementById('preview-services-container');
                servicesContainer.innerHTML = '';

                const selectedServices = Array.from(document.querySelectorAll(
                        'input[name="services[]"]:checked'))
                    .map(service => ({
                        id: service.value,
                        name: service.nextElementSibling.textContent.trim()
                    }));

                if (selectedServices.length === 0) {
                    // Show existing services if none selected
                    servicesContainer.innerHTML = `{!! $shop->shop_services->map(function ($service) {
                            return '<div class="col-md-4 col-6"><p class="eighteen">' . $service->service->name . '</p></div>';
                        })->implode('') !!}`;
                } else {
                    // Group services by 3 columns
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
                    // Show existing amenities if none selected
                    amenitiesContainer.innerHTML = `{!! $shop->shop_amenities->map(function ($amenity) {
                            return '<div class="col-md-6"><p class="sixteen"><i class="bi bi-check-circle me-2"></i>' .
                                $amenity->amenity->name .
                                '</p></div>';
                        })->implode('') !!}`;
                } else {
                    // Group amenities by 2 columns
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

                // Social media links
                const website = document.getElementById('website').value;
                const facebook = document.getElementById('facebook').value;
                const instagram = document.getElementById('instagram').value;
                const twitter = document.getElementById('twitter').value;

                // Update social media links in preview if they exist
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

                // Shop images preview
                const imagesPreview = document.getElementById('preview-shop-images');
                // imagesPreview.innerHTML = '';

                const imagesInput = document.getElementById('shop_images');
                if (imagesInput.files && imagesInput.files.length > 0) {
                    const files = Array.from(imagesInput.files).slice(0, 3); // Show max 3 images in preview

                    files.forEach((file, index) => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const colDiv = document.createElement('div');
                            colDiv.className = index === 0 ? 'col-md-9' : 'col-md-3';

                            const imgDiv = document.createElement('div');
                            imgDiv.className = index === 0 ? 'col-12' : 'col-12 mt-md-0 mt-3';

                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'img-fluid';
                            img.alt = 'Shop image';
                            img.style.borderRadius = '8px';
                            img.style.maxHeight = index === 0 ? '300px' : '140px';
                            img.style.width = '100%';
                            img.style.objectFit = 'cover';

                            imgDiv.appendChild(img);
                            colDiv.appendChild(imgDiv);
                            imagesPreview.appendChild(colDiv);
                        };
                        reader.readAsDataURL(file);
                    });
                } else {
                    // Show existing images if no new ones uploaded
                    @foreach ($shop->shop_images as $image)
                        @if ($loop->first)
                            imagesPreview.innerHTML += `
                            <div class="col-md-9">
                                <img src="{{ $image->path }}" class="img-fluid" style="max-height: 300px; width: 100%; object-fit: cover; border-radius: 8px;" alt="Shop Image">
                            </div>
                        `;
                        @else
                            imagesPreview.innerHTML += `
                            <div class="col-md-3">
                                <img src="{{ $image->path }}" class="img-fluid" style="max-height: 140px; width: 100%; object-fit: cover; border-radius: 8px;" alt="Shop Image">
                            </div>
                        `;
                        @endif
                    @endforeach
                }
            });

            // Toggle time fields based on checkbox state
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

            // City dropdown based on province selection
            document.getElementById('province').addEventListener('change', function() {
                const provinceId = this.value;
                const citySelect = document.getElementById('city');

                if (provinceId) {
                    fetch(`/get-cities/${provinceId}`)
                        .then(response => response.json())
                        .then(data => {
                            citySelect.innerHTML = '<option selected>Select City</option>';
                            data.forEach(city => {
                                citySelect.innerHTML +=
                                    `<option value="${city.id}">${city.name}</option>`;
                            });
                        });
                } else {
                    citySelect.innerHTML = '<option selected>Select Province first</option>';
                }
            });

            // Image upload and preview
            const dropzone = document.getElementById('dropzone');
            const shop_images = document.getElementById('shop_images');
            const preview = document.getElementById('shop_images_preview');
            const errorMsg = document.getElementById('error-msg');

            dropzone.addEventListener('click', () => shop_images.click());

            dropzone.addEventListener('dragover', e => {
                e.preventDefault();
                dropzone.classList.add('border-primary');
            });

            dropzone.addEventListener('dragleave', () => {
                dropzone.classList.remove('border-primary');
            });

            dropzone.addEventListener('drop', e => {
                e.preventDefault();
                dropzone.classList.remove('border-primary');
                shop_images.files = e.dataTransfer.files;
                previewSelectedFiles(e.dataTransfer.files);
            });

            shop_images.addEventListener('change', e => {
                previewSelectedFiles(e.target.files);
            });

            function previewSelectedFiles(files) {
                errorMsg.textContent = '';
                preview.innerHTML = '';

                const validImages = Array.from(files).filter(file => {
                    if (!file.type.match(/image\/(jpeg|jpg|png)/)) {
                        errorMsg.textContent = 'Only JPEG, JPG, and PNG formats are allowed.';
                        return false;
                    }
                    if (file.size > 8 * 1024 * 1024) {
                        errorMsg.textContent = 'Each file must be less than 8 MB.';
                        return false;
                    }
                    return true;
                });

                if (validImages.length > 30) {
                    errorMsg.textContent = 'Maximum 30 files allowed.';
                    return;
                }

                validImages.forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const wrapper = document.createElement('div');
                        wrapper.classList.add('preview-img');
                        wrapper.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" />`;
                        preview.appendChild(wrapper);
                    };
                    reader.readAsDataURL(file);
                });
            }

            // Logo preview
            const shopLogoInput = document.getElementById('shop_logo');
            const previewIcon = document.getElementById('previewIcon');

            shopLogoInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewIcon.src = e.target.result;
                    previewIcon.classList.add('upload-preview');
                };
                dropText.style.display = 'none';
                reader.readAsDataURL(file);
            });
        });
    </script>
    <script>
        function formatPhoneNumber(input) {
            let value = input.value.replace(/\D/g, ''); // Remove non-numeric
            if (!value.startsWith('92')) {
                value = '92' + value; // Always start with 92
            }
            value = value.substring(0, 13); // Limit to full number (92 + 11 digits)

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
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imagesDropzone = document.getElementById('imagesDropzone');
            const imagesInput = document.getElementById('shop_images');
            const previewContainer = document.getElementById('shop_images_preview');
            const errorMsg = document.getElementById('error-msg');
            const maxAllowedImages = parseInt(document.getElementById('maxImagesAllowed').textContent) || 10;
            let uploadedFiles = [];

            // Click handler
            imagesDropzone.addEventListener('click', function() {
                imagesInput.click();
            });

            // Drag and drop handlers
            imagesDropzone.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.style.borderColor = '#281F48';
                this.style.backgroundColor = 'rgba(40, 31, 72, 0.1)';
            });

            imagesDropzone.addEventListener('dragleave', function() {
                this.style.borderColor = '';
                this.style.backgroundColor = '';
            });

            imagesDropzone.addEventListener('drop', function(e) {
                e.preventDefault();
                this.style.borderColor = '';
                this.style.backgroundColor = '';

                if (e.dataTransfer.files.length) {
                    handleImageFiles(e.dataTransfer.files);
                }
            });

            // File input change handler
            imagesInput.addEventListener('change', function() {
                if (this.files.length) {
                    handleImageFiles(this.files);
                }
            });

            function handleImageFiles(files) {
                errorMsg.textContent = '';

                // Check total files count
                if (uploadedFiles.length + files.length > maxAllowedImages) {
                    errorMsg.textContent = `Maximum ${maxAllowedImages} files allowed.`;
                    return;
                }

                // Process each file
                Array.from(files).forEach(file => {
                    // Check if file already exists
                    if (uploadedFiles.some(f => f.name === file.name && f.size === file.size)) {
                        return;
                    }

                    // Validate file type
                    if (!file.type.match(/image\/(jpeg|jpg|png)/)) {
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
@endsection
