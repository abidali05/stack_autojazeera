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

    .quickfilter {
        color: #281F48 !important;
        font-weight: 500 !important;
    }

    .smalldiv {
        background-color: #D6D6D6 !important;
        border-radius: 10px !important;
    }

    .lastupdate {
        font-size: 14px !important;
        color: #281F48 !important;
    }

    .neworange {
        color: #FD5631 !important;
    }

    .newborder {
        border: 1px solid #281F48 !important;
        border-radius: 9px !important;
    }

    .quickbfac {
        background-color: #F0F3F6;
        border-radius: 5px;
    }

    .imagslider {
        height: 200px;
        border-radius: 25px 25px 0px 0px;
    }

    .onesix {
        width: 160px !important;
    }

    .onefour {
        width: 140px !important;
    }

    .onefive {
        width: 150px !important;
    }

    .redcolor {
        background-color: #F40000 !important;
    }

    .point {
        cursor: pointer
    }

    .bluecolor {
        color: #281F48 !important;
    }

    .minmaxbtn {
        background-color: #F40000 !important;
        color: white !important;
        font-size: 17px !important;
    }

    .featuredcar {
        color: #281F48 !important;
        font-size: 24px !important;
    }

    .viewcar {
        font-size: 14px !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        color: #281F48 !important;
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

    .twenty {
        font-size: 24px;
        color: #281F48;
        font-weight: 500;
    }

    .sixteen {
        font-size: 16px;
        color: #281F48;
        font-weight: 500;
    }

    .fouteen {
        font-size: 14px;
        color: #281F48;
        font-weight: 400;
    }

    .create {
        border: none;
        padding: 10px 20px;
        background-color: #281F48;
        color: white;
        font-size: 14px;
        font-weight: 500;
        border-radius: 5px;
    }

    .filter {
        border: 1px solid #281F48;
        padding: 5px 20px;
        background-color: white;
        color: #281F48;
        font-size: 14px;
        font-weight: 500;
        border-radius: 5px;
    }

    .eighteen {
        font-size: 18px;
        color: #D90600;
        font-weight: 500;
    }

    .spanclas {
        background-color: #281F48;
        padding: 5px;
        color: white;
        font-size: 12px;
        font-weight: 400;
        border-radius: 5px;
    }

    .labell {
        font-size: 16px;
        color: #281F48;
        font-weight: 500;
    }

    /* Pagination container spacing */
    .pagination {
        gap: 6px;
        /* little space between buttons */
    }

    /* Active page */
    .page-item.active .page-link {
        background-color: #281F48 !important;
        color: #fff !important;
        border-color: #281F48 !important;
    }

    /* Normal page */
    .page-link {
        background-color: #fff;
        color: #281F48;
        border: 1px solid #281F48;
        border-radius: 6px;
        /* little rounded */
        padding: 6px 12px;
        transition: all 0.2s ease-in-out;
    }

    /* Hover effect */
    .page-link:hover {
        background-color: #281F48;
        color: #fff;
    }

    .twelb {
        font-size: 12px;
        color: #281F48;
        font-weight: 400;
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


<div class="container p-3">
    <div class="row">
        <div class="col-md-12 mt-3">
            <div class="row">
                @forelse ($blogs as $blog)
                    <div class="col-md-4 p-4">
                        <a href="{{ route('blog-detail', $blog->id) }}">
                            <div class="row rounded" style="background-color: #F4F4F4;">
                                <div class="col-md-12 p-0">
                                    <img class="img-fluid w-100"
                                        src="{{ $blog->image ? asset($blog->image) : asset('web/images/blog-img.svg') }}"
                                        alt="{{ $blog->title }}"
                                        style="height: 200px; object-fit: cover; border-radius:10px 10px 0px 0px;">
                                </div>
                                @php
                                    $tags = $blog->tags ? json_decode($blog->tags, true) : [];
                                @endphp
                                <div class="col-md-12 mt-3 d-flex justify-content-between align-items-baseline">
                                    <div>
                                        @php
                                            $allTags = explode(',', $blog->tags ?? 'General');
                                            $maxTags = 3; // sirf 3 tags dikhane hain
                                        @endphp

                                        @foreach ($allTags as $index => $tag)
                                            @if ($index < $maxTags)
                                                @php
                                                    // Tag ke words limit karna
                                                    $words = explode(' ', trim($tag));
                                                    $limited = implode(' ', array_slice($words, 0, 3));
                                                @endphp

                                                <button class="spanclas mt-1">
                                                    {{ $limited }}{{ count($words) > 3 ? '...' : '' }}
                                                </button>
                                            @endif
                                        @endforeach


                                    </div>


                                    <p class="m-0 fouteen">{{ $blog->created_at->format('d/m/Y h:i A') }}</p>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <p class="labell ">
                                        {!! Str::limit(strip_tags($blog->title), 40, '...') !!}
                                    </p>
                                    <p class="fouteen">
                                        {!! Str::limit(strip_tags($blog->description), 120, '...') !!}

                                    </p>
                                </div>
                                <div class="col-12 mt-4 mb-3">
                                    <a href="{{ route('blog-detail', $blog->id) }}"
                                        class="spanclas d-flex justify-content-center align-items-center">
                                        Learn More <i class="bi bi-arrow-right ms-3 fs-4"></i>
                                    </a>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="text-center">No blogs available.</p>
                @endforelse
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $blogs->links('pagination::bootstrap-5') }}
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
