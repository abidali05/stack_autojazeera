@extends('layout.website_layout.services.main')

@section('content')<style>
        .dropzone {
            border: 2px dashed #ccc;
            padding: 10px;
            border-radius: 10px;
            cursor: pointer;
            height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .dropzone input[type="file"] {
            opacity: 0;
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            cursor: pointer;
        }

        .image-box {
            position: relative;
        }

        .image-preview {
            height: 150px;
            width: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            font-size: 16px;
            line-height: 22px;
            text-align: center;
            cursor: pointer;
        }

        .remove-btn:hover {
            background: red;
        }
    </style>

    <style>
        body {
            padding: 0%;
            margin: 0%;

        }

        * {
            padding: 0%;
            margin: 0%;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
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
            0% {
                clip-path: polygon(50% 50%, 0 0, 0 0, 0 0, 0 0, 0 0)
            }

            25% {
                clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 0, 100% 0, 100% 0)
            }

            50% {
                clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 100% 100%, 100% 100%)
            }

            75% {
                clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 0 100%, 0 100%)
            }

            100% {
                clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 0 100%, 0 0)
            }
        }

        .bg-cover {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            width: 100%;
            height: 500px;
            /* Full height of viewport */
        }

        .custom-input {
            display: flex;
            align-items: center;
            background-color: red;
            color: white;
            border-radius: 50px;
            padding: 10px 15px;
            width: 250px;
            /* Adjust the width as needed */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .custom-input i {
            font-size: 20px;
            margin-right: 10px;
        }

        .custom-input input {
            border: none;
            background: transparent;
            outline: none;
            color: white;
            font-size: 16px;
            flex: 1;
        }

        .custom-input input::placeholder {
            color: white;
            opacity: 0.8;
        }

        .hh {
            height: 450px !important;
            background-size: cover;
            background-position: center;
        }

        .sliderp {
            font-size: 28px;
            font-weight: 700;
            color: #281F48;
        }

        .carousel-item {
            height: 500px;
            /* Match parent height */
        }

        .carousel-caption {
            top: 0;
            bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }



        .hover-grow {
            transition: transform 0.3s ease-in-out;
            /* Smooth scaling effect */
            width: 100%;
            /* Make the image fill the container */
            height: 100%;
            /* Maintain the height */
            object-fit: cover;
            /* Ensure the image doesn't distort */
        }

        .hover-grow:hover {
            transform: scale(1.2);
            /* Increase the size by 20% on hover */
        }

        /* Style for hover effect */
        .card:hover img {
            transform: scale(1.3);
            /* Grow the image */
            transition: transform 0.3s ease;
            /* Smooth transition */
        }

        .card:hover .card-title {
            color: #007bff;
            /* Change the title color */
            font-weight: bold;
            /* Make the title bold */
            transition: color 0.3s ease, font-weight 0.3s ease;
            /* Smooth transition */
        }

        .heightt {
            transition: transform 0.5s ease;
            /* Ensure smooth transition for image */
        }

        h1 {
            color: white;
        }

        .search-container {
            position: relative;
            width: 100%;
        }

        .search-container input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            /* Adjust padding for the icon */
            border: 1px solid white;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            background-color: #1F1B2D;
        }

        .search-container .search-icon {
            position: absolute;
            top: 50%;
            left: 15px;

            transform: translateY(-50%);
            font-size: 18px;
            color: white;
            pointer-events: none;

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

        .divcolor {
            background-color: #F0F3F6;
            border-radius: 20px 20px 20px 20px;
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

        .heading {
            color: #281F48;
        }

        .button1 {
            background-color: #D6D6D6;
            color: #281F48;
            border: 1px solid #D6D6D6;
            border-radius: 20px;
            padding: 5px 10px;
            font-size: 16px;
            font-weight: 700px;
        }



        .mapbutton {
            background-color: #ffffff;
            color: #281F48;
            border: 1px solid #281F48;
            border-radius: 8px;
            padding: 5px 10px;
            font-size: 16px;
            font-weight: 700px;
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

        .button5 {
            background-color: #FD5631;
            color: white;
            width: 100%;
            border: 1px solid #FD5631;
            border-radius: 20px;
            padding: 10px 10px;
            font-size: 18px;
            font-weight: 700px;
        }

        .button55 {
            background-color: #D90600;
            color: white;
            width: 100%;
            border: 1px solid #D90600;
            border-radius: 10px;
            padding: 10px 10px;
            font-size: 16px;
            font-weight: 700px;
        }

        .input-group {
            width: 100%;
            padding: 10px;
        }

        .form-control,
        .form-select {
            border-right: 0;
            border-left: 0;
            padding: 10px;
            font-size: 16px;
        }

        .form-select {
            max-width: 200px;
            text-align: center;
        }

        .btn {
            border-left: 0;
            font-size: 16px;
        }

        .bbrder {
            position: relative;
            border-left: 2px solid #281F48;
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


        .select2-container--default .select2-selection--single {
            border-radius: 8px !important;
            background-color: white !important;
            border: 0px !important;
            height: 34px !important;
            padding-top: 3px;
            padding-left: 0rem !important;
            box-shadow: none !important;
            color: #281F48 !important;
        }

        .bakgimg {

            background-image: url('./images/Frame\ 1618873199.svg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 150px;
            width: 100% !important;
        }

        .imgbak {

            background-image: url('./images/Frame\ 1171275423.svg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;


        }

        .spancolor {
            color: #1F1B2D;
        }

        .eighteenwhitee {
            color: #1F1B2D;
            font-size: 16px;
            font-weight: 700px;
        }

        .eighteenwhite {
            color: white;
            font-size: 16px;
            font-weight: 700px;
        }

        .twelvewhite {
            color: white;
            font-size: 12px;
            font-weight: 700px;
        }

        .twelvewhitee {
            color: #281F48;
            font-size: 12px;
            font-weight: 700px !important;
        }

        h6 {
            color: #281F48 !important;
        }

        h1 {
            color: #281F48 !important;
        }

        .borderr {
            border-left: 1px solid white;
            height: 90%;
            margin: auto 0px;
        }

        .rating-stars {
            display: flex;
            gap: 5px;
        }

        .star {

            display: flex;
            justify-content: center;
            align-items: center;


            cursor: pointer;
            transition: background-color 0.3s;
        }

        .star.active {
            color: #FFB700;
            /* Orange for active stars */
        }

        .star i {
            color: white;
        }

        svg:not(:host).svg-inline--fa,
        svg:not(:root).svg-inline--fa {
            overflow: visible;
            box-sizing: content-box;
            padding: 5px;
            background: #281F48;
            border-radius: 50%;
            color: white;
        }

        .eighteenorange {
            color: #281F48;
            font-size: 18px;
            font-weight: 600;
        }

        .eighteengreen {
            color: #0EB617;
            font-size: 18px;
            font-weight: 600;
        }

        h2 {
            color: white;
        }

        .bigfont {
            font-size: 120px;
            font-weight: 700px;
            color: #281F48;
        }

        .twentyfourwhite {
            color: #281F48;
            font-size: 24px;
            font-weight: 800px;
        }

        .twentyfourblack {
            color: black !important;
            font-size: 24px;
            font-weight: 800px;
        }

        .twelveorange {
            font-size: 12px;
            font-weight: 500px;
            color: #FD5631;
        }

        .divborder {
            border: 1px solid #BFBEC34D;
            background-color: #281F48;
            border-radius: 15px;
        }

        .divborderr {
            border: 1px solid #BFBEC34D;
            background-color: #F0F3F6;
            border-radius: 15px;
        }

        #map {
            height: 400px;
            /* Adjust height */
            width: 100%;
            /* Full width */
            border: 2px solid black;
            border-radius: 8px;
        }

        .ab {
            font-size: 16px;
            font-weight: 500;
            color: #FFFFFF;
        }

        .firstpp {
            color: #B4B3B8;
            font-size: 14px;
            font-weight: 500;
        }

        .footertag {
            list-style: none;

        }

        .footertag li a {
            text-decoration: none;
            color: #B4B3B8;
            font-size: 14px;
            font-weight: 500;
        }

        .footerl {
            font-size: 16px;
            font-weight: 500;
            color: #B4B3B8;
        }

        .copyright {
            font-size: 14px;
            font-weight: 500;
            color: #B4B3B8;
        }

        .custom-input-group {
            background-color: #281F48;
            /* Dark blue background */
            border: 1px solid #4b6179;
            /* Border color */
            border-radius: 8px;
            /* Rounded corners */
        }

        .custom-input-group input {
            background-color: transparent;
            border: none;
            color: #bfc7d5;
            /* Text color */
        }

        .custom-input-group input::placeholder {
            color: #bfc7d5;
            /* Placeholder color */
        }

        .custom-input-group .input-group-text {
            background-color: transparent;
            border: none;
        }

        .custom-input-group .input-group-text img {
            width: 20px;
            height: 20px;
        }

        .custom-input-group button {
            background-color: #e63946;
            border: none;
            border-radius: 8px;
        }

        .custom-input-group button img {
            width: 16px;
            height: 16px;
        }

        .custom-input-group input:focus {
            outline: none;
            box-shadow: none;
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

        .custom-star:hover,
        .custom-star.highlighted {
            color: #ffa500;
        }

        #user-star-box {
            display: flex;
            gap: 5px;
        }

        .user-star-icon {
            font-size: 1.5rem;
            color: #1F1B2D;
            cursor: pointer;
            background-color: #979797;
            border-radius: 5px;
            transition: color 0.3s;
            padding: 5px;
        }

        .user-star-icon:hover,
        .user-star-icon.filled {
            color: #ffcc00;
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
            height: 8px;
            background-color: #707070;
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

        h4 {
            color: white;
        }

        .heightt {
            height: 150px !important;
            width: 150px;
        }

        .img-adj-card {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .img-bg-home-2 {
            width: 100%;
            height: 240px;
            overflow: hidden;
            border-radius: 20px 0px 0px 20px;
        }

        .ddd {
            background-color: #F0F3F6;
        }

        a {
            text-decoration: none;
        }

        h3 {
            color: white;
        }

        h6 {
            color: white;
        }

        .bb {
            border-top: 1px solid #66666680;
        }

        .form-check-label {
            color: #281F48;
            font-size: 14px;
            font-weight: 500;
        }

        .distancecheck {
            border: 1px solid #281F48;
            background-color: white;
            color: #281F48;
            border-radius: 20px;
            padding: 5px 10px;
        }

        .custom-checkbox {
            appearance: none;
            -webkit-appearance: none;
            width: 15px;
            height: 15px;
            border: 2px solid #281F48;
            background-color: white;
            border-radius: 4px;
            cursor: pointer;
            position: relative;
            transition: background-color 0.3s, border-color 0.3s;
        }

        /* Checked state */
        .custom-checkbox:checked {
            background-color: #281F48;
            border-color: #281F48;
        }

        /* Optional checkmark icon using ::after */
        .custom-checkbox:checked::after {

            color: white;
            position: absolute;
            top: -1px;
            left: 3px;
            font-size: 14px;
        }

        .dropdown-item {

            padding: 0px 25px;

        }

        .btn-checkbox {
            display: none;
        }

        .btn-label {
            padding: 6px 16px;
            border: 1px solid #281F48;
            color: #281F48ed;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 400;
            transition: all 0.3s ease;
            background-color: white;
        }

        .btn-checkbox:checked+.btn-label {
            background-color: #281F48;
            color: white;
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


        .select2-container--default .select2-selection--single {
            border-radius: 8px !important;
            background-color: white !important;
            border: 0px !important;
            height: 34px !important;
            padding-top: 3px;
            padding-left: 0rem !important;
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

        .dropheight {
            height: 300px;
            overflow-y: auto;
            background-color: white;
            scrollbar-color: r #281F48ed transparent;
            /* For Firefox */
        }

        /* For WebKit browsers (Chrome, Safari) */
        .dropheight::-webkit-scrollbar {
            width: 4px;
        }

        .dropheight::-webkit-scrollbar-track {
            background: transparent;
        }

        .dropheight::-webkit-scrollbar-thumb {
            background-color: #281F48;
            border-radius: 4px;
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

        .featureicn {
            position: absolute;
            left: 0;
            background: #281F48;
            color: white;
            font-size: 12px;
            font-weight: 500;
            border-radius: 5px;
            padding: 5px 10px;
            margin-top: 30px;
            margin-left: 60px;
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
            margin-top: 30px;
            margin-left: 60px;
        }

        @media (min-width: 300px) and (max-width: 500px) {
            .fourtyeight {
                font-size: 28px;
                /* Example size, adjust as needed */

            }
        }
    </style>
    {{-- step form css end --}}

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <div class="container mb-5">

        <div class="row d-flex justify-content-between">
            <div class="col-md-12">
                <h1 class="fourtyeight">Available Records</h1>
            </div>

        </div>
        <div class="row d-flex justify-content-between align-items-baseline">
            <div class="col-md-10 d-flex flex-wrap mt-4">

                <div class="dropdown mt-2 me-2">
                    <button class="distancecheck dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">

                        <img src="{{ asset('web/services/images/Filter 1.svg') }}" class="img-fluid me-2" alt="...">
                        All
                    </button>
                    <ul class="dropdown-menu p-2 px-4 dropheight" aria-labelledby="dropdownMenuButton">
                        <p class="m-0"><strong>All Filter</strong></p>
                        <form id="filterform">
                            <input type="hidden" name="latitude" id="latitude">
                            <input type="hidden" name="longitude" id="longitude">
                            <p class="m-0 mt-2 text-danger"><strong>Distance</strong></p>

                            <li class="mb-2">
                                <select class="form-select ps-0 select2 select-form mb-2"
                                    style="font-size: 11px !important ;font-weight:500; text-start !important ;background-color:white !important; border:none;    width: 100% !important;"
                                    aria-label="Default select example" id="province1" name="province">
                                    <option selected>Select Province</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </li>
                            <li>
                                <select class="form-select  mt-2 ps-0" id="city1"
                                    style="font-size: 11px !important ;font-weight:500; text-start !important;background-color:white !important; border:none;width: 100% !important;"
                                    aria-label="Default select example" name="city">
                                    <option selected>Select Province First</option>

                                </select>
                            </li>
                            <li>
                                <div class="form-check dropdown-item">
                                    <input class="form-check-input custom-checkbox" type="radio" value="5"
                                        id="5kmdistance" name="distance">
                                    <label class="form-check-label" for="5kmdistance">Within 5km</label>
                                </div>
                            </li>

                            <li>
                                <div class="form-check dropdown-item">
                                    <input class="form-check-input custom-checkbox" type="radio" value="10"
                                        id="10kmdistance" name="distance">
                                    <label class="form-check-label" for="10kmdistance">Within 10km</label>
                                </div>
                            </li>

                            <li>
                                <div class="form-check dropdown-item">
                                    <input class="form-check-input custom-checkbox" type="radio" value="15"
                                        id="15kmdistance" name="distance">
                                    <label class="form-check-label" for="15kmdistance">Within 15km</label>
                                </div>
                            </li>

                            <li>
                                <div class="form-check dropdown-item">
                                    <input class="form-check-input custom-checkbox" type="radio" value="custom"
                                        id="customdistancecheck" name="distance">
                                    <label class="form-check-label" for="customdistancecheck">Custom Distance ? </label>
                                </div>
                            </li>



                            <li class="mb-2">
                                <input class="form-control" type="number" value="" id="custom_distance"
                                    name="custom_distance" placeholder="Distance" style=" height:30px">
                            </li>

                            <p class="m-0 text-danger"><strong>Service type</strong></p>
                            @foreach ($service_categories as $category)
                                <li>
                                    <div class="form-check dropdown-item">
                                        <input class="form-check-input custom-checkbox" type="checkbox"
                                            value="{{ $category->id }}" id="Checkme1" name="category[]">
                                        <label class="form-check-label" for="Checkme3">{{ $category->name }}</label>
                                    </div>
                                </li>
                            @endforeach

                            <p class="m-0 text-danger"><strong>Amenities</strong></p>
                            @foreach ($amenities as $amenity)
                                <li>
                                    <div class="form-check dropdown-item">
                                        <input class="form-check-input custom-checkbox" type="checkbox"
                                            value="{{ $amenity->id }}" name="amenity[]" id="Checkme3">
                                        <label class="form-check-label" for="Checkme3">{{ $amenity->name }}</label>
                                    </div>
                                </li>
                            @endforeach

                            <li>
                                <div class="form-check dropdown-item p-0">
                                    <button type="button"
                                        style="background-color: #D90600;border:none;color: white;padding: 5px; font-size: 12px; font-weight: 500; border-radius: 5px; width: 100%;"
                                        id="searchFilterBtn">Search</button>
                                </div>
                            </li>
                    </ul>
                    </form>
                </div>

                <div class="dropdown mt-2 me-2">
                    <button class="distancecheck dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                        Location
                    </button>
                    <ul class="dropdown-menu p-2 px-2" aria-labelledby="dropdownMenuButton">
                        <form id="filterform4">

                            <input type="hidden" name="latitude" id="latitude3">
                            <input type="hidden" name="longitude" id="longitude3">
                            <li>
                                <select class="form-select select2 ps-0"
                                    style="font-size: 11px !important ;font-weight:500; text-start !important ;background-color:white !important; border:none;"
                                    aria-label="Default select example" id="province" name="province">
                                    <option selected>Select Province</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </li>
                            <li>
                                <select class="form-select mt-2 ps-0" id="city"
                                    style="font-size: 11px !important ;font-weight:500; text-start !important;background-color:white !important; border:none;"
                                    aria-label="Default select example" name="city">
                                    <option selected>Select Province First</option>

                                </select>
                            </li>


                            <li>
                                <div class="form-check dropdown-item p-0">
                                    <button type="button"
                                        style="background-color: #D90600;border:none;color: white;padding: 5px; font-size: 12px; font-weight: 500; border-radius: 5px; width: 100%;"id="searchFilterBtn4">Search</button>
                                </div>
                            </li>




                        </form>
                    </ul>
                </div>



                <div class="dropdown mt-2">
                    <button class=" distancecheck dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Distance
                    </button>
                    <ul class="dropdown-menu p-2 px-4" aria-labelledby="dropdownMenuButton">
                        <form id="filterform1">
                            <input type="hidden" name="latitude" id="latitude1">
                            <input type="hidden" name="longitude" id="longitude1">
                            <p class="m-0"><strong>Distance</strong></p>

                            <li>
                                <div class="form-check dropdown-item">
                                    <input class="form-check-input custom-checkbox" type="radio" value="5"
                                        id="5kmdistance" name="distance">
                                    <label class="form-check-label" for="5kmdistance">Within 5km</label>
                                </div>
                            </li>

                            <li>
                                <div class="form-check dropdown-item">
                                    <input class="form-check-input custom-checkbox" type="radio" value="10"
                                        id="10kmdistance" name="distance">
                                    <label class="form-check-label" for="10kmdistance">Within 10km</label>
                                </div>
                            </li>

                            <li>
                                <div class="form-check dropdown-item">
                                    <input class="form-check-input custom-checkbox" type="radio" value="15"
                                        id="15kmdistance" name="distance">
                                    <label class="form-check-label" for="15kmdistance">Within 15km</label>
                                </div>
                            </li>

                            <li>
                                <div class="form-check dropdown-item">
                                    <input class="form-check-input custom-checkbox" type="radio" value="custom"
                                        id="customdistancecheck" name="distance">
                                    <label class="form-check-label" for="customdistancecheck">Custom Distance ? </label>
                                </div>
                            </li>



                            <li class="mb-2">
                                <input class="form-control" type="number" value="" id="custom_distance"
                                    name="custom_distance" placeholder="Distance" style=" height:30px">
                            </li>

                            <div class="form-check dropdown-item p-0">
                                <button type="button"
                                    style="background-color: #D90600;border:none;color: white;padding: 5px; font-size: 12px; font-weight: 500; border-radius: 5px; width: 100%;"
                                    id="searchFilterBtn1">Search</button>
                            </div>
                            </li>
                        </form>
                    </ul>
                </div>
                <div class="dropdown mt-2 ms-2">
                    <button class=" distancecheck dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Service Type
                    </button>
                    <ul class="dropdown-menu p-2 px-4" aria-labelledby="dropdownMenuButton">
                        <form id="filterform2">
                            <input type="hidden" name="latitude" id="latitude2">
                            <input type="hidden" name="longitude" id="longitude2">
                            <p class="m-0"><strong>Auto Detailing</strong></p>
                            @foreach ($service_categories as $category)
                                <li>
                                    <div class="form-check dropdown-item">
                                        <input class="form-check-input custom-checkbox" type="checkbox"
                                            value="{{ $category->id }}" id="Checkme1" name="category[]">
                                        <label class="form-check-label" for="Checkme1">{{ $category->name }}</label>
                                    </div>
                                </li>
                            @endforeach



                            <li>
                                <div class="form-check dropdown-item p-0">
                                    <button type="button"
                                        style="background-color: #D90600;border:none;color: white;padding: 5px; font-size: 12px; font-weight: 500; border-radius: 5px; width: 100%;"
                                        id="searchFilterBtn2">Search</button>
                                </div>
                            </li>
                        </form>
                    </ul>
                </div>
                <div class="dropdown mt-2 ms-2 me-2">
                    <button class=" distancecheck dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Amenities
                    </button>
                    <ul class="dropdown-menu p-2 px-4" aria-labelledby="dropdownMenuButton">
                        <p class="m-0"><strong>Amenities</strong></p>
                        <form id="filterform3">
                            <input type="hidden" name="latitude" id="latitude3">
                            <input type="hidden" name="longitude" id="longitude3">

                            @foreach ($amenities as $amenity)
                                <li>
                                    <div class="form-check dropdown-item">
                                        <input class="form-check-input custom-checkbox" type="checkbox"
                                            value="{{ $amenity->id }}" id="Checkme1" name="amenity[]">
                                        <label class="form-check-label" for="Checkme1">{{ $amenity->name }}</label>
                                    </div>
                                </li>
                            @endforeach

                            <li>
                                <div class="form-check dropdown-item p-0">
                                    <button type="button"
                                        style="background-color: #D90600;border:none;color: white;padding: 5px; font-size: 12px; font-weight: 500; border-radius: 5px; width: 100%;"id="searchFilterBtn3">Search</button>
                                </div>
                            </li>
                        </form>
                    </ul>
                </div>
                {{-- <div class="dropdown me-2">
                    <button class=" distancecheck dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Location
                    </button>
                    <ul class="dropdown-menu p-2 px-2" aria-labelledby="dropdownMenuButton">
                        <form id="filterform4">

                            <input type="hidden" name="latitude" id="latitude3">
                            <input type="hidden" name="longitude" id="longitude3">
                            <li>
                                <select class="form-select ps-0"
                                    style="font-size: 11px !important ;font-weight:500; text-start !important ;background-color:white !important; border:none;"
                                    aria-label="Default select example" id="province" name="province">
                                    <option selected>Select Province</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </li>
                            <li>
                                <select class="form-select mt-2 ps-0" id="city"
                                    style="font-size: 11px !important ;font-weight:500; text-start !important;background-color:white !important; border:none;"
                                    aria-label="Default select example" name="city">
                                    <option selected>Select Province First</option>

                                </select>
                            </li>


                            <li>
                                <div class="form-check dropdown-item p-0">
                                    <button type="button"
                                        style="background-color: #D90600;border:none;color: white;padding: 5px; font-size: 12px; font-weight: 500; border-radius: 5px; width: 100%;"id="searchFilterBtn4">Search</button>
                                </div>
                            </li>




                        </form>
                    </ul>
                </div> --}}


                <input type="checkbox" id="openToggle" class="btn-checkbox">
                <label for="openToggle" class="btn-label mt-2">Open Now</label>
                <label class="btn-label ms-1 mt-2" onclick="window.location.reload()">Clear Filters</label>
            </div>

            <div class="col-md-2 d-flex justify-content-end">



                <div class="dropdown">
                    <span class="sixteen dropdown-toggle" id="sortDropdown" data-bs-toggle="dropdown"
                        aria-expanded="false" style="cursor: pointer;">
                        Sort <i class="bi bi-arrow-down-up ms-2"></i>
                    </span>

                    <ul class="dropdown-menu" aria-labelledby="sortDropdown">

                        <li><a class="dropdown-item" href="#" onclick="sortBy('latest')">Rating (High to Low)</a>
                        </li>
                        <li><a class="dropdown-item" href="#" onclick="sortBy('oldest')">Rating (Low to High)</a>
                        </li>

                    </ul>
                </div>
            </div>
            <div id="filterdynamicdiv">
                {{-- @if ($shops->hasPages()) --}}
                @php
                    $start = ($shops->currentPage() - 1) * $shops->perPage() + 1;
                    $end = min($shops->currentPage() * $shops->perPage(), $shops->total());
                @endphp

                <div class="row mt-3">
                    <div class="col-md-6">
                        <span class="row ">
                            {{ $start }} - {{ $end }} of {{ $shops->total() }} Results
                        </span>
                    </div>
                    <div class="col-md-6">
                        <nav class="d-flex justify-content-end align-items-center">
                            <!-- Page Info -->


                            <!-- Pagination -->
                            <ul class="pagination"
                                style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">

                                {{-- Previous Page Button --}}
                                @if ($shops->onFirstPage())
                                    <li style="display: inline-block;">
                                        <span
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</span>
                                    </li>
                                @else
                                    @if (request()->isMethod('post'))
                                        <li style="display: inline-block;">
                                            <form method="POST" action="{{ url()->current() }}">
                                                @csrf
                                                <input type="hidden" name="page"
                                                    value="{{ $shops->currentPage() - 1 }}">
                                                <input type="hidden" name="search" value="{{ request('search') }}">
                                                <input type="hidden" name="city" value="{{ request('city') }}">
                                                <button type="submit"
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                            </form>
                                        </li>
                                    @else
                                        <li style="display: inline-block;">
                                            <a href="{{ $shops->previousPageUrl() }}"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                        </li>
                                    @endif
                                @endif

                                {{-- Pagination Links --}}
                                @foreach ($shops->links()->elements as $element)
                                    @if (is_string($element))
                                        <li style="display: inline-block;">
                                            <span
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                        </li>
                                    @endif

                                    @if (is_array($element))
                                        @foreach ($element as $page => $url)
                                            @if ($page == $shops->currentPage())
                                                <li style="display: inline-block;">
                                                    <span
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #281F48; color: #fff;">{{ $page }}</span>
                                                </li>
                                            @else
                                                @if (request()->isMethod('post'))
                                                    <li style="display: inline-block;">
                                                        <form method="POST" action="{{ url()->current() }}">
                                                            @csrf
                                                            <input type="hidden" name="page"
                                                                value="{{ $page }}">
                                                            <input type="hidden" name="search"
                                                                value="{{ request('search') }}">
                                                            <input type="hidden" name="city"
                                                                value="{{ request('city') }}">
                                                            <button type="submit"
                                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">{{ $page }}</button>
                                                        </form>
                                                    </li>
                                                @else
                                                    <li style="display: inline-block;">
                                                        <a href="{{ $url }}"
                                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $page }}</a>
                                                    </li>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach

                                {{-- Next Page Button --}}
                                @if ($shops->hasMorePages())
                                    @if (request()->isMethod('post'))
                                        <li style="display: inline-block;">
                                            <form method="POST" action="{{ url()->current() }}">
                                                @csrf
                                                <input type="hidden" name="page"
                                                    value="{{ $shops->currentPage() + 1 }}">
                                                <input type="hidden" name="search" value="{{ request('search') }}">
                                                <input type="hidden" name="city" value="{{ request('city') }}">
                                                <button type="submit"
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                            </form>
                                        </li>
                                    @else
                                        <li style="display: inline-block;">
                                            <a href="{{ $shops->nextPageUrl() }}"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&raquo;</a>
                                        </li>
                                    @endif
                                @else
                                    <li style="display: inline-block;">
                                        <span
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&raquo;</span>
                                    </li>
                                @endif
                            </ul>

                        </nav>
                    </div>
                </div>
                {{-- @endif --}}

                @if (count($shops) == 0)
                    <div class=col-md-12>
                        <div class="row d-flex justify-content-center my-3">
                            <div class="p-3 col-8" style="border:1px solid #281F48;border-radius:9px;">
                                <div class="row">
                                    <div class="col-md-3 text-center text-md-start ">
                                        <img src="{{ asset('web/images/noinputs.svg') }}" alt=""
                                            class="img-fluid" srcset="">
                                    </div>
                                    <div class="col-md-9 text-start">
                                        <h1 style="color:#FD5631">Sorry</h1>
                                        <p>No matches found for your search. Try adjusting your filters or expanding your
                                            criteria
                                            to
                                            explore available Shop!</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="shops-container" style="width:100%">
                    <div id="loadingSpinner" class="loading-overlay d-none">
                        <div class=" loader" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    @foreach ($shops as $shop)
                        <div class="row mt-3 shopdiv car" data-rating = "{{ $shop->rating }}"
                            data-longitude="{{ $shop->longitude }}" data-latitude="{{ $shop->latitude }}">
                            <div class="col-md-12" style="background-color: #F0F3F6; border-radius: 10px;">
                                <div class="row">
                                    <div class="col-md-3 p-0 ">
                                        <a href="{{ route('shopdetail', $shop->id) }}">
                                            <div class="imagediv" style="height: 240px;">
                                                <img src="{{ $shop->logo }}" class="imagewidth" alt="...">
                                            </div>

                                            @if ($shop->is_top_rated == '1')
                                                <span class="featureicn">
                                                    <img src="{{ asset('web/bikes/images/Star 7.svg') }}"
                                                        class="img-fluid">
                                                    Top Rated
                                                </span>
                                            @endif
                                            @if ($shop->is_featured == '1')
                                                <span class="featureicoxn">
                                                    <img src="{{ asset('web/bikes/images/Star 7.svg') }}"
                                                        class="img-fluid">
                                                    Featured
                                                </span>
                                            @endif

                                        </a>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="row py-3 px-2">

                                            <div class="col-md-7" onclick="{{ route('shopdetail', $shop->id) }}"
                                                style="cursor: pointer">
                                                <a href="{{ route('shopdetail', $shop->id) }}">
                                                    <div class="row">
                                                        <div class="col-md-12 px-4">
                                                            <div class="row">
                                                                <div class="col-8">
                                                                    <p class="twentyfour">{{ $shop->name }}</p>
                                                                </div>
                                                                <div class="col-4 d-flex justify-content-end">


                                                                    <div class="rating-container">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            @php
                                                                                $rounded = round($shop->rating * 2) / 2; // e.g., 2.7 → 2.5
                                                                            @endphp
                                                                            <div class="star active"
                                                                                data-value="{{ $i }}">
                                                                                @if ($i <= floor($rounded))
                                                                                    <i class="fas fa-star"></i>
                                                                                    <!-- full star -->
                                                                                @elseif ($i == ceil($rounded) && fmod($rounded, 1) != 0)
                                                                                    <i class="fas fa-star-half-alt"></i>
                                                                                    <!-- half star -->
                                                                                @else
                                                                                    <i class="far fa-star"></i>
                                                                                    <!-- empty star -->
                                                                                @endif
                                                                            </div>
                                                                        @endfor

                                                                    </div>

                                                                </div>
                                                                <div class="col-12 d-flex justify-content-between">

                                                                    @php
                                                                        $currentDay = date('l');
                                                                        $timings = $shop->shop_timings
                                                                            ->where('day', $currentDay)
                                                                            ->first();
                                                                    @endphp
                                                                    <p class="fourteen">
                                                                        @if ($timings)
                                                                            <span style="color: #2ab500;font-weight: 600;"
                                                                                class="openclosed">Open
                                                                                Now
                                                                            </span>
                                                                            {{ date('h:i A', strtotime($timings->start_time)) }}
                                                                            -
                                                                            {{ date('h:i A', strtotime($timings->end_time)) }}
                                                                        @else
                                                                            <span style="color: orangered;"
                                                                                class="openclosed">Closed</span>
                                                                        @endif
                                                                    </p>


                                                                    <div class="review-text" style="font-weight: 500;"
                                                                        id="reviewText">
                                                                        {{ $shop->rating }}
                                                                        ({{ $shop->total_ratings }} reviews)
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12 d-flex justify-content-between">
                                                                    @foreach ($shop->shop_services as $i => $shopservice)
                                                                        @if ($i < 3)
                                                                            <strong>
                                                                                <p class="eighteenwhitee mt-3">
                                                                                    {{ $shopservice->service->name }}</p>
                                                                            </strong>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                                <div class="col-12 borderbottom">
                                                                    {{-- <p> <span class="fourteen "> <img
                                                                                src="{{ asset('web/services/images/Icon (Stroke).svg') }}"
                                                                                class="img-fluid me-2"
                                                                                alt="...">{{ $shop->address }}
                                                                            (<span class="distance">...</span>)
                                                                        </span></p> --}}
                                                                </div>
                                                                <div class="col-12 mt-3">
                                                                    <p class="fourteen m-0">
                                                                        {{ Str::limit($shop->description, 60) }}
                                                                        <span style="color: #FD5631;">more</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-md-5 borderleft">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="">
                                                        @auth
                                                            @if ($shop->dealer_id == auth()->user()->id)
                                                                <button class="button11 "
                                                                    onclick="alert('You can not request a quote from your own shop')">Request
                                                                    a
                                                                    Quote</button>
                                                                <button class="button11 "
                                                                    onclick="alert('You can not write a review from your own shop')"><i
                                                                        class="bi bi-star text-white me-2"></i>Write
                                                                    a review</button>
                                                            @else
                                                                @if (Auth::user()->role == '2' || Auth::user()->role == '3')
                                                                    <button class="button11 "
                                                                        onclick="alert('You are not authorized for this action!')">Request
                                                                        a
                                                                        Quote</button>
                                                                    <button class="button11 "
                                                                        onclick="alert('You are not authorized for this action!')"><i
                                                                            class="bi bi-star text-white me-2"></i>Write
                                                                        a review</button>
                                                                @else
                                                                    <button class="button11 " data-bs-toggle="modal"
                                                                        data-bs-target="#requestQuoteModal{{ $shop->id }}">Request
                                                                        a
                                                                        Quote</button>
                                                                    <button class="button11 " data-bs-toggle="modal"
                                                                        data-bs-target="#reviewModal{{ $shop->id }}"><i
                                                                            class="bi bi-star text-white me-2"></i>Write
                                                                        a review</button>
                                                                @endif
                                                            @endif
                                                        @endauth

                                                        @guest
                                                            <a href="{{ route('login') }}" class="button11 ">Request a
                                                                Quote</a>
                                                            <a href="{{ route('login') }}" class="button11 "><i
                                                                    class="bi bi-star text-white me-2"></i>Write
                                                                a review</a>
                                                        @endguest
                                                    </div>
                                                    <div class="d-flex justify-content-end align-items-center mt-2">


                                                        <span class="d-flex align-items-center">
                                                            @auth
                                                                @php
                                                                    $check = \App\Models\AutoServices\ShopWishlist::where(
                                                                        'user_id',
                                                                        auth()->id(),
                                                                    )
                                                                        ->where('shop_id', $shop->id)
                                                                        ->first();
                                                                @endphp

                                                                {{-- <a href="{{ route('shops.wishlist.add', ['shop' => $shop->id, 'user' => auth()->id()]) }}"
                                                                    style="background-color: transparent; border: none; color:#281F48 !important">
                                                                    <i
                                                                        class="bi {{ $check ? 'bi-heart-fill text-danger' : 'bi-heart' }} fs-4"></i>
                                                                </a> --}}
                                                            @endauth


                                                            @guest
                                                                <a href="{{ route('login') }}"
                                                                    style="background-color: transparent; border: none;">
                                                                    <i class="bi bi-heart fs-4"></i>
                                                                </a>
                                                            @endguest

                                                            <img src="{{ asset('web/services/images/Group 1171275361.svg') }}"
                                                                class="img-fluid ms-3" style="cursor: pointer"
                                                                alt="google map"
                                                                onclick="window.open('https://www.google.com/maps?q={{ $shop->latitude }},{{ $shop->longitude }}&output=embed', '_blank')">
                                                        </span>
                                                    </div>
                                                    <div class="mt-2 ">
                                                        <p> <span class="fourteen "> <img
                                                                    src="{{ asset('web/services/images/Icon (Stroke).svg') }}"
                                                                    class="img-fluid me-2"
                                                                    alt="...">{{ $shop->address }}
                                                                (<span class="distance">...</span>)
                                                            </span></p>



                                                    </div>
                                                    <div class="d-flex align-items-center ">
                                                        @if ($shop->dealer->shop_pkg && $shop->dealer->shop_pkg->metadata->whatsapp_allowed == '1')
                                                            @php
                                                                // remove all non-numeric characters except +
                                                                $whatsappNumber = preg_replace(
                                                                    '/[^0-9]/',
                                                                    '',
                                                                    $shop->number,
                                                                );
                                                            @endphp
                                                            <span class="twelvewhitee {{ $shop->number ? '' : 'd-none' }}"
                                                                onclick="window.open('https://wa.me/{{ $whatsappNumber }}','_blank')"
                                                                style="cursor: pointer">
                                                                <img src="{{ asset('web/services/images/whatsapp.svg') }}"
                                                                    class="img-fluid me-3" alt="...">
                                                            </span>
                                                        @endif


                                                        <span class="twelvewhitee {{ $shop->facebook ? '' : 'd-none' }}"
                                                            onclick="window.open('{{ $shop->facebook }}','_blank')"
                                                            style="cursor: pointer">
                                                            <img src="{{ asset('web/services/images/facebook.svg') }}"
                                                                class="img-fluid me-3" alt="...">
                                                        </span>
                                                        <span class="twelvewhitee {{ $shop->instagram ? '' : 'd-none' }}"
                                                            onclick="window.open('{{ $shop->instagram }}','_blank')"
                                                            style="cursor: pointer"><img
                                                                src="{{ asset('web/services/images/instagram.svg') }}"
                                                                class="img-fluid me-3" alt="...">
                                                        </span>
                                                        <span class="twelvewhitee {{ $shop->twitter ? '' : 'd-none' }}"
                                                            onclick="window.open('{{ $shop->twitter }}','_blank')"
                                                            style="cursor: pointer"><img
                                                                src="{{ asset('web/services/images/Vector0.svg') }}"
                                                                class="img-fluid me-3" alt="...">
                                                        </span>
                                                        <span class=" sixteen me-3"
                                                            style="word-break: break-word; max-width: 300px; display: inline-block;">
                                                            @if ($shop->website)
                                                                <a href="  {{ $shop->website }}" style="color:#281F48"><i
                                                                        class="bi bi-globe fs-4"></i></a>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>




                <!-- review Modal -->
                <div class="modal fade" id="reviewModal{{ $shop->id }}" tabindex="-1"
                    aria-labelledby="uploadModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg  modal-dialog-centered">
                        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                            <div class="modal-header"
                                style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                                <h5 class="modal-title" id="newsletterresponseLabel">
                                    <strong>{{ $shop->name }}</strong>
                                </h5>
                                <button type="button" class="btn-close"
                                    style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="background-color: white !important; color: #281F48;">
                                <form action="{{ route('review.store') }}" method="post" enctype="multipart/form-data"
                                    id="reviewForm">
                                    @csrf
                                    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                                    <div class="row mb-3">

                                        <div class="col-md-12 mb-2">
                                            <div class="feedback-rating-container align-items-center ">
                                                <div id="feedback-stars-group">
                                                    <span class="feedback-star-item" data-score="1">&#9733;</span>
                                                    <span class="feedback-star-item" data-score="2">&#9733;</span>
                                                    <span class="feedback-star-item" data-score="3">&#9733;</span>
                                                    <span class="feedback-star-item" data-score="4">&#9733;</span>
                                                    <span class="feedback-star-item" data-score="5">&#9733;</span>
                                                    <input type="hidden" name="rating" id="rating-value"
                                                        value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <textarea class="form-controless" id="exampleFormControlTextarea1" rows="3" name="comment"></textarea>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Dropzone + Images Row -->
                                    <div class="row g-3" id="image-upload-row">
                                        <!-- Dropzone uploader -->
                                        <div class="col-2">
                                            <div class="dropzone text-center position-relative">
                                                <div class="upload-icon">
                                                    <img src="{{ asset('web/services/images/upload.svg') }}"
                                                        class="img-fluid" alt="Upload">
                                                </div>
                                                <div class="upload-text">Upload Photo Here</div>
                                                <div class="upload-subtext">Maximum 10 Photos</div>
                                                <div id="image-counter" class="mt-1"
                                                    style="font-size: 10px; color: #281F48;">
                                                    0/10 photos
                                                </div>
                                                <input type="file" multiple class="upload-input" accept="image/*"
                                                    name="review_images[]" id="imageInput" />
                                            </div>
                                        </div>

                                        <!-- Previews -->
                                    </div>


                                    <!-- Second row for more image slots -->
                                    <div class="row g-3 mt-2">
                                        <div class="col-2 image-box"></div>
                                        <div class="col-2 image-box"></div>
                                        <div class="col-2 image-box"></div>
                                        <div class="col-2 image-box"></div>
                                        <div class="col-2 image-box"></div>
                                    </div>
                            </div>

                            <div class="modal-footer justify-content-center border-0 p-0 pb-3"
                                style="background-color: white !important;">
                                <button type="button" class="whitebtn py-2" data-bs-dismiss="modal"
                                    onclick="window.location.reload();" class="btn btn-light px-4 py-2 "
                                    style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;">Cancel</button>
                                <button type="submit" class="btn btn-light px-4 py-2 ms-2"
                                    style="background-color: white; font-weight:600; color: #281F48; border-radius: 5px; border:1px solid #281F48;"
                                    id="submit-review-btn">Submit Review</button>
                            </div>
                            </form>

                        </div>
                    </div>
                </div>



                {{-- request quote modal start --}}
                <div class="modal fade classcrol" id="requestQuoteModal{{ $shop->id }}" data-bs-backdrop="static"
                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="requestQuoteModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable custom-modal-width">
                        <div class="modal-content">
                            <form id="multiStepForm{{ $shop->id }}" class="multiStepForm">
                                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
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
                                                    <div class="checkbox-group mb-3">
                                                        <label class="checkbox-button">
                                                            <input type="radio" name="vehicle_type" value="bike"
                                                                hidden>
                                                            <span>Bike</span>
                                                        </label>
                                                        <label class="checkbox-button">
                                                            <input type="radio" name="vehicle_type" value="car"
                                                                hidden>
                                                            <span>Car</span>
                                                        </label>
                                                    </div>
                                                    <div id="vehicle-error" class="reed mt-2" style="display:none;">
                                                        Please select a
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
                                                    <div id="body_type-error" class="reed mt-2" style="display:none;">
                                                        Please select a
                                                        body type</div>



                                                    <div class="checkbox-group">

                                                    </div>

                                                </div>
                                                <div class=" d-flex justify-content-between mt-5">
                                                    <button type="button" class="whitebtn prev px-5 ">Back</button>
                                                    <button type="button" class="bluebtn ms-auto next px-5"
                                                        id="secondstepbtn">Next</button>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="vehicle-image-container mt-3">
                                                    <!-- Image will be injected here -->
                                                    <img src="{{ asset('web/services/images/Frameee.svg') }}"
                                                        class="img-fluid" alt="...">
                                                    <img src="{{ asset('web/services/images/bike_request_qoute.svg') }}"
                                                        class="img-fluid" alt="...">
                                                    <img src="{{ asset('web/services/images/carbike.svg') }}"
                                                        class="img-fluid" alt="...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step 2 -->
                                    <div class="step-content step2" id="step2">
                                        <div class="row classcrol">
                                            <div class="col-md-5 ps-5">
                                                <div class="scrollable-content">
                                                    <p class="twentyeight mt-4">Select Make</p>
                                                    <div id="make-error" class="error" style=" display: none;">Please
                                                        select a make.</div>

                                                    <div class="checkbox-group">

                                                    </div>

                                                </div>
                                                <div class="d-flex justify-content-between mt-5 ">
                                                    <button type="button" class="whitebtn prev px-5">Back</button>
                                                    <button type="button" class="bluebtn  next px-5">Next</button>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="vehicle-image-container mt-3">
                                                    <!-- Image will be injected here -->
                                                    <img src="{{ asset('web/services/images/Frameee.svg') }}"
                                                        class="img-fluid" alt="...">
                                                    <img src="{{ asset('web/services/images/bike_request_qoute.svg') }}"
                                                        class="img-fluid" alt="...">
                                                    <img src="{{ asset('web/services/images/carbike.svg') }}"
                                                        class="img-fluid" alt="...">
                                                </div>
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
                                                    <!-- Error Message -->
                                                    <div id="model-error" class="error" style=" display: none;">
                                                        Please select a vehicle model.
                                                    </div>
                                                    <div class="checkbox-group">




                                                    </div>

                                                </div>
                                                <div class="d-flex justify-content-between mt-5">
                                                    <button type="button" class="whitebtn prev px-5">Back</button>
                                                    <button type="button" class="bluebtn  next px-5">Next</button>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="vehicle-image-container mt-3">
                                                    <!-- Image will be injected here -->
                                                    <img src="{{ asset('web/services/images/Frameee.svg') }}"
                                                        class="img-fluid" alt="...">
                                                    <img src="{{ asset('web/services/images/bike_request_qoute.svg') }}"
                                                        class="img-fluid" alt="...">
                                                    <img src="{{ asset('web/services/images/carbike.svg') }}"
                                                        class="img-fluid" alt="...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step 4 -->
                                    <div class="step-content step4" id="step4">
                                        <div class="row classcrol">
                                            <div class="col-md-5 ps-5">
                                                <div class="scrollable-content">
                                                    <p class="twentyeight mt-4">Select Year</p>
                                                    <div id="year-error" class="reed mt-2" style="display:none;">Please
                                                        select a
                                                        year
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
                                                <div class="vehicle-image-container mt-3">
                                                    <!-- Image will be injected here -->
                                                    <img src="{{ asset('web/services/images/Frameee.svg') }}"
                                                        class="img-fluid" alt="...">
                                                    <img src="{{ asset('web/services/images/bike_request_qoute.svg') }}"
                                                        class="img-fluid" alt="...">
                                                    <img src="{{ asset('web/services/images/carbike.svg') }}"
                                                        class="img-fluid" alt="...">
                                                </div>
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
                                                    <div id="service-error" class="reed mt-2" style="display:none;">
                                                        Please select a service</div>

                                                    <div class="checkbox-group">
                                                        @foreach ($shop->shop_services as $shopservice)
                                                            <label class="checkbox-button">
                                                                <input type="checkbox" hidden
                                                                    value="{{ $shopservice->id }}" name="services[]">
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
                                              <img src="{{ asset('web/images/service_quotes.svg') }}"
                                                        class="img-fluid" alt="...">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Step 6 -->
                                    <!-- Step 6 -->
                                    <div class="step-content step6" id="step6">
                                        <div class="row classcrol">
                                            <div class="col-md-5 ps-5">
                                                <div class="scrollable-content">
                                                    <div id="description-error" class="reed mt-2" style="display:none;">
                                                        Please enter a description</div>
                                                    <div id="captcha-error" class="reed mt-2" style="display:none;">
                                                        Please complete the CAPTCHA</div>
                                                    <p class="twentyeight mt-4">Describe your Needs</p>
                                                    <textarea class="form-controles" style="height: 200px;" placeholder="Type..." rows="3"
                                                        name="needs_description" required></textarea>
                                                    <div class="row mt-2">
                                                        <div class="col-9 p-3 rounded-3"
                                                            style="background-color: #F9F9F9;">
                                                            <div class="row">
                                                                <!-- Use class instead of ID for reCAPTCHA -->
                                                                <div class="g-recaptcha recaptcha-container"
                                                                    data-sitekey="6Ld03I4rAAAAAIzu8T5yEAhaC_OiY1GB5s2YSHCW">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between mt-5">
                                                    <button type="button" class="whitebtn prev px-5">Back</button>
                                                    <button type="button" class="bluebtn next px-5"
                                                        id="submit-btn-{{ $shop->id }}">Submit</button>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                               <img src="{{ asset('web/images/service_quotes.svg') }}"
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

                                                    <button type="button" class="whitebtn prev  px-5">Back</button>
                                                    <button type="button" class="bluebtn me-5  next px-5">Next</button>

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
                                                            class="btn btn-danger py-2 px-2" style="font-size: 12px;">Find
                                                            More
                                                            Auto
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

                {{-- request quote modal end --}}
                @endforeach
            </div>
            {{-- @if ($shops->hasPages()) --}}

            <div class="row mt-3">
                <div class="col-md-6">
                    <span class="row ">
                        {{ $start }} - {{ $end }} of {{ $shops->total() }} Results
                    </span>
                </div>
                <div class="col-md-6">
                    <nav class="d-flex justify-content-end align-items-center mt-2">
                        <!-- Page Info -->


                        <!-- Pagination -->
                        <ul class="pagination"
                            style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">

                            {{-- Previous Page Button --}}
                            @if ($shops->onFirstPage())
                                <li style="display: inline-block;">
                                    <span
                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</span>
                                </li>
                            @else
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page"
                                                value="{{ $shops->currentPage() - 1 }}">
                                            <input type="hidden" name="search" value="{{ request('search') }}">
                                            <input type="hidden" name="city" value="{{ request('city') }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $shops->previousPageUrl() }}"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                    </li>
                                @endif
                            @endif

                            {{-- Pagination Links --}}
                            @foreach ($shops->links()->elements as $element)
                                @if (is_string($element))
                                    <li style="display: inline-block;">
                                        <span
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                    </li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $shops->currentPage())
                                            <li style="display: inline-block;">
                                                <span
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #281F48; color: #fff;">{{ $page }}</span>
                                            </li>
                                        @else
                                            @if (request()->isMethod('post'))
                                                <li style="display: inline-block;">
                                                    <form method="POST" action="{{ url()->current() }}">
                                                        @csrf
                                                        <input type="hidden" name="page"
                                                            value="{{ $page }}">
                                                        <input type="hidden" name="search"
                                                            value="{{ request('search') }}">
                                                        <input type="hidden" name="city"
                                                            value="{{ request('city') }}">
                                                        <button type="submit"
                                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">{{ $page }}</button>
                                                    </form>
                                                </li>
                                            @else
                                                <li style="display: inline-block;">
                                                    <a href="{{ $url }}"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                            {{-- Next Page Button --}}
                            @if ($shops->hasMorePages())
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page"
                                                value="{{ $shops->currentPage() + 1 }}">
                                            <input type="hidden" name="search" value="{{ request('search') }}">
                                            <input type="hidden" name="city" value="{{ request('city') }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $shops->nextPageUrl() }}"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&raquo;</a>
                                    </li>
                                @endif
                            @else
                                <li style="display: inline-block;">
                                    <span
                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&raquo;</span>
                                </li>
                            @endif
                        </ul>

                    </nav>
                </div>
            </div>


            {{-- @endif --}}
        </div>


        <div class="modal fade" id="reviewresponse" tabindex="-1" aria-labelledby="reviewresponseLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewresponseLabel">Review</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <p>{{ session('reviewresponse') }}</p>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
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



    <div class="modal fade" id="wishlistresponse" tabindex="-1" aria-labelledby="wishlistresponseLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="wishlistresponseLabel">Wishlist</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <p>{{ session('wishlistresponse') }}</p>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

    </div>

    {{-- step form logic start  --}}
    <!-- Include this in your HTML head or before closing body -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    {{-- <div class="g-recaptcha recaptcha-container" data-sitekey="6LdWxY4rAAAAABzF1TAq6DwgnyyDRxhviKx-5VWg"></div> --}}

    <script>
        // $("#loadingSpinner").removeClass("d-none");

        document.addEventListener("DOMContentLoaded", function() {
            // Object to store reCAPTCHA widget IDs for each modal
            let recaptchaWidgets = {};

            // Function to render or reset reCAPTCHA for a specific modal
            function renderRecaptchaForModal(modal, shopId) {
                const container = modal.querySelector('.recaptcha-container');

                if (!container) {
                    console.error(
                        `reCAPTCHA container with class 'recaptcha-container' not found in modal for shop ${shopId}`
                    );
                    return;
                }

                // If widget already exists for this shop, reset it
                if (recaptchaWidgets[shopId] !== undefined) {
                    try {
                        grecaptcha.reset(recaptchaWidgets[shopId]);
                        console.log(`reCAPTCHA reset for shop ${shopId}`);
                    } catch (e) {
                        console.error(`Error resetting reCAPTCHA for shop ${shopId}:`, e);
                    }
                    return;
                }

                // Render new reCAPTCHA widget
                try {
                    const widgetId = grecaptcha.render(container, {
                        'sitekey': '{{ env('RECAPTCHA_KEY') }}',
                        'callback': function(response) {
                            console.log(`reCAPTCHA verified for shop ${shopId}:`, response);
                        },
                        'expired-callback': function() {
                            console.log(`reCAPTCHA expired for shop ${shopId}`);
                        }
                    });
                    recaptchaWidgets[shopId] = widgetId;
                    console.log(`reCAPTCHA rendered for shop ${shopId}, widget ID: ${widgetId}`);
                } catch (e) {
                    console.error(`Error rendering reCAPTCHA for shop ${shopId}:`, e);
                }
            }

            // Handle modal show event to render reCAPTCHA
            document.querySelectorAll('[id^="requestQuoteModal"]').forEach(modal => {
                modal.addEventListener('show.bs.modal', function() {
                    const shopId = this.id.replace('requestQuoteModal', '');
                    // Delay rendering slightly to ensure modal DOM is ready
                    setTimeout(() => renderRecaptchaForModal(this, shopId), 100);
                });

                // Reset reCAPTCHA when modal is hidden
                modal.addEventListener('hidden.bs.modal', function() {
                    const shopId = this.id.replace('requestQuoteModal', '');
                    if (recaptchaWidgets[shopId] !== undefined) {
                        try {
                            grecaptcha.reset(recaptchaWidgets[shopId]);
                            console.log(`reCAPTCHA reset for shop ${shopId}`);
                        } catch (e) {
                            console.error(`Error resetting reCAPTCHA for shop ${shopId}:`, e);
                        }
                    }
                });
            });

            // Multi-step form logic
            document.querySelectorAll(".multiStepForm").forEach((form) => {
                let currentStep = 0;
                const steps = form.querySelectorAll(".step-content");
                const shopId = form.id.replace('multiStepForm', '');

                function showStep(index) {
                    steps.forEach((step, i) => {
                        step.classList.toggle("active", i === index);
                    });
                }

                function validateStep(step) {
                    // Step 0: Vehicle type
                    if (step.classList.contains("step0")) {
                        const vehicle = step.querySelector('input[name="vehicle_type"]:checked');
                        const error = step.querySelector("#vehicle-error");
                        if (!vehicle) {
                            if (error) error.style.display = "block";
                            return false;
                        }
                        if (error) error.style.display = "none";

                        // Load body types dynamically
                        fetch(`/get-vehicle-body-type/${vehicle.value}`)
                            .then(res => res.json())
                            .then(data => {
                                const container = form.querySelector(".step1 .checkbox-group");
                                container.innerHTML = "";
                                data.body_types?.forEach(bodyType => {
                                    const label = document.createElement("label");
                                    label.className = "checkbox-button";
                                    label.innerHTML = `
                                    <input type="radio" name="body_type" value="${bodyType.id}" hidden>
                                    <span>${bodyType.name}</span>
                                `;
                                    container.appendChild(label);
                                });
                            })
                            .catch(err => console.error('Error fetching body types:', err));
                    }

                    // Step 1: Body type
                    if (step.classList.contains("step1")) {
                        const body = step.querySelector('input[name="body_type"]:checked');
                        const error = step.querySelector("#body_type-error");
                        if (!body) {
                            if (error) error.style.display = "block";
                            return false;
                        }
                        if (error) error.style.display = "none";

                        const vehicleType = form.querySelector('input[name="vehicle_type"]:checked')?.value;
                        fetch(`/get-vehicle-make/${vehicleType}`)
                            .then(res => res.json())
                            .then(data => {
                                const container = form.querySelector(".step2 .checkbox-group");
                                container.innerHTML = "";
                                data.makes?.forEach(make => {
                                    const label = document.createElement("label");
                                    label.className = "checkbox-button";
                                    label.innerHTML = `
                                    <input type="radio" name="vehicle_make" value="${make.id}" hidden>
                                    <span>${make.name}</span>
                                `;
                                    container.appendChild(label);
                                });
                            })
                            .catch(err => console.error('Error fetching makes:', err));
                    }

                    // Step 2: Vehicle make
                    if (step.classList.contains("step2")) {
                        const make = step.querySelector('input[name="vehicle_make"]:checked');
                        const error = step.querySelector("#make-error");
                        if (!make) {
                            if (error) error.style.display = "block";
                            return false;
                        }
                        if (error) error.style.display = "none";

                        const vehicleType = form.querySelector('input[name="vehicle_type"]:checked')?.value;
                        fetch(`/get-vehicle-model/${vehicleType}/${make.value}`)
                            .then(res => res.json())
                            .then(data => {
                                const container = form.querySelector(".step3 .checkbox-group");
                                container.innerHTML = "";
                                data.models?.forEach(model => {
                                    const label = document.createElement("label");
                                    label.className = "checkbox-button";
                                    label.innerHTML = `
                                    <input type="radio" name="vehicle_model" value="${model.id}" hidden>
                                    <span>${model.name}</span>
                                `;
                                    container.appendChild(label);
                                });
                            })
                            .catch(err => console.error('Error fetching models:', err));
                    }

                    // Step 3: Vehicle model
                    if (step.classList.contains("step3")) {
                        const model = step.querySelector('input[name="vehicle_model"]:checked');
                        const error = step.querySelector("#model-error");
                        if (!model) {
                            if (error) error.style.display = "block";
                            return false;
                        }
                        if (error) error.style.display = "none";
                    }

                    // Step 4: Year
                    if (step.classList.contains("step4")) {
                        const year = step.querySelector('input[name="year"]:checked');
                        const error = step.querySelector("#year-error");
                        if (!year) {
                            if (error) error.style.display = "block";
                            return false;
                        }
                        if (error) error.style.display = "none";
                    }

                    // Step 5: Services
                    if (step.classList.contains("step5")) {
                        const services = step.querySelectorAll('input[name="services[]"]:checked');
                        const error = step.querySelector("#service-error");
                        if (services.length === 0) {
                            if (error) error.style.display = "block";
                            return false;
                        }
                        if (error) error.style.display = "none";
                    }

                    // Step 6: Description only (reCAPTCHA validation removed)
                    if (step.classList.contains("step6")) {
                        const description = step.querySelector('textarea[name="needs_description"]');
                        const descriptionError = step.querySelector("#description-error");
                        let valid = true;

                        if (!description.value.trim()) {
                            if (descriptionError) descriptionError.style.display = "block";
                            valid = false;
                        } else {
                            if (descriptionError) descriptionError.style.display = "none";
                        }

                        return valid;
                    }

                    return true;
                }

                // Handle Next button clicks
                form.querySelectorAll(".next").forEach((btn) => {
                    btn.addEventListener("click", () => {
                        const currentStepEl = steps[currentStep];
                        const valid = validateStep(currentStepEl);
                        if (!valid) return;

                        // Submit on step 6
                        if (currentStepEl.classList.contains("step6")) {
                            const submitBtn = btn;
                            submitBtn.disabled = true;
                            submitBtn.innerHTML = "Submitting...";

                            const formData = new FormData(form);

                            currentStep++;
                            showStep(currentStep); // Show loading step (step7)

                            fetch("/submit-service-quote", {
                                    method: "POST",
                                    body: formData,
                                    headers: {
                                        Accept: "application/json",
                                        "X-Requested-With": "XMLHttpRequest",
                                        "X-CSRF-TOKEN": document.querySelector(
                                                'meta[name="csrf-token"]')
                                            ?.getAttribute("content"),
                                    },
                                })
                                .then((response) => response.json())
                                .then((data) => {
                                    if (data.success) {
                                        currentStep++;
                                        showStep(
                                            currentStep); // Show success step (step8)
                                    } else {
                                        currentStep = 6;
                                        showStep(currentStep);
                                        alert(data.message || "Something went wrong.");
                                        grecaptcha.reset(recaptchaWidgets[shopId]);
                                    }
                                })
                                .catch((error) => {
                                    currentStep = 6;
                                    showStep(currentStep);
                                    alert("An error occurred. Please try again.");
                                    console.error('Submission error:', error);
                                    grecaptcha.reset(recaptchaWidgets[shopId]);
                                })
                                .finally(() => {
                                    submitBtn.disabled = false;
                                    submitBtn.innerHTML = "Submit";
                                });

                            return;
                        }

                        if (currentStep < steps.length - 1) {
                            currentStep++;
                            showStep(currentStep);
                        }
                    });
                });

                // Handle Previous button clicks
                form.querySelectorAll(".prev").forEach((btn) => {
                    btn.addEventListener("click", () => {
                        if (currentStep > 0) {
                            currentStep--;
                            showStep(currentStep);
                        }
                    });
                });

                // Style checked radio/checkbox buttons
                form.addEventListener("change", function(e) {
                    const input = e.target;

                    if (input.matches('.checkbox-button input[type="radio"]')) {
                        const name = input.name;
                        form.querySelectorAll(`input[name="${name}"] + span`).forEach((span) => {
                            span.style.backgroundColor = "white";
                            span.style.color = "#A7A7A7";
                            span.style.borderColor = "#A7A7A7";
                        });
                        const span = input.nextElementSibling;
                        if (input.checked) {
                            span.style.backgroundColor = "#281F48";
                            span.style.color = "white";
                            span.style.borderColor = "#281F48";
                        }
                    }

                    if (input.matches('.checkbox-button input[type="checkbox"]')) {
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
                    }
                });

                showStep(currentStep);
                $("#loadingSpinner").addClass("d-none");
            });
        });
    </script>
    {{-- step form logic end --}}

    {{-- filter logic start --}}
    <script>
        $(document).ready(function() {
            document.getElementById('searchFilterBtn').addEventListener('click', function() {
                const form = document.getElementById('filterform');

                // Ensure the form element exists before proceeding
                // Uncheck "Open Now" toggle if selected
                const openToggle = document.getElementById('openToggle');
                if (openToggle && openToggle.checked) {
                    openToggle.checked = false;
                }


                if (form) {
                    var data = new FormData(form);
                    data.append('is_ajax', 1);
                    $("#loadingSpinner").removeClass("d-none");
                    // Debug: Log form data
                    console.log("Form data:", data);

                    // Send the filter data to the backend

                    fetch('{{ route('services.filter') }}', {
                            method: 'POST', // Use POST to send form data in the body
                            body: data,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token for security
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Ensure the response has the correct HTML content
                            console.log("Filter response data:", data);

                            const shopContainer = document.querySelector('#filterdynamicdiv');
                            if (shopContainer) {
                                shopContainer.innerHTML = ''; // Clear the container

                                // Check if the HTML is correctly returned
                                if (data.html) {
                                    shopContainer.innerHTML = data.html; // Replace content
                                } else {
                                    console.error('No HTML content in response');
                                }
                            } else {
                                console.error('Filter container #filterdynamicdiv not found');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching filter data:', error);
                            $("#loadingSpinner").addClass("d-none");
                        });
                } else {
                    console.error('Form element not found');
                }
            });

            document.getElementById('searchFilterBtn1').addEventListener('click', function() {
                const form = document.getElementById('filterform1');

                // ✅ Uncheck "Open Now" toggle if selected
                const openToggle = document.getElementById('openToggle');
                if (openToggle && openToggle.checked) {
                    openToggle.checked = false;
                }

                if (form) {
                    const data = new FormData(form);

                    // ✅ Show loader
                    $("#loadingSpinner").removeClass("d-none");

                    fetch('{{ route('services.filter') }}', {
                            method: 'POST',
                            body: data,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log("Filter response data:", data);

                            const shopContainer = document.querySelector('#filterdynamicdiv');
                            if (shopContainer) {
                                shopContainer.innerHTML = '';
                                if (data.html) {
                                    shopContainer.innerHTML = data.html;
                                } else {
                                    console.error('No HTML content in response');
                                }
                            } else {
                                console.error('Filter container #filterdynamicdiv not found');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching filter data:', error);
                        })
                        .finally(() => {
                            // ✅ Hide loader when done
                            $("#loadingSpinner").addClass("d-none");
                        });
                } else {
                    console.error('Form element not found');
                }
            });

            document.getElementById('searchFilterBtn2').addEventListener('click', function() {
                const form = document.getElementById('filterform2');

                const openToggle = document.getElementById('openToggle');
                if (openToggle && openToggle.checked) {
                    openToggle.checked = false;
                }

                if (form) {
                    var data = new FormData(form);
                    data.append('is_ajax', 1);

                    // ✅ Show loader before fetch
                    $("#loadingSpinner").removeClass("d-none");

                    fetch('{{ route('services.filter') }}', {
                            method: 'POST',
                            body: data,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            const shopContainer = document.querySelector('#filterdynamicdiv');
                            if (shopContainer) {
                                shopContainer.innerHTML = '';
                                if (data.html) {
                                    shopContainer.innerHTML = data.html;
                                } else {
                                    console.error('No HTML content in response');
                                }
                            } else {
                                console.error('Filter container #filterdynamicdiv not found');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching filter data:', error);
                        })
                        .finally(() => {
                            // ✅ Hide loader when done (success or error)
                            $("#loadingSpinner").addClass("d-none");
                        });
                } else {
                    console.error('Form element not found');
                }
            });


            document.getElementById('searchFilterBtn3').addEventListener('click', function() {
                const form = document.getElementById('filterform3');

                // ✅ Uncheck "Open Now" toggle if selected
                const openToggle = document.getElementById('openToggle');
                if (openToggle && openToggle.checked) {
                    openToggle.checked = false;
                }

                if (form) {
                    const data = new FormData(form);

                    // ✅ Show loader before request
                    $("#loadingSpinner").removeClass("d-none");

                    fetch('{{ route('services.filter') }}', {
                            method: 'POST',
                            body: data,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            const shopContainer = document.querySelector('#filterdynamicdiv');
                            if (shopContainer) {
                                shopContainer.innerHTML = '';
                                if (data.html) {
                                    shopContainer.innerHTML = data.html;
                                } else {
                                    console.error('No HTML content in response');
                                }
                            } else {
                                console.error('Filter container #filterdynamicdiv not found');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching filter data:', error);
                        })
                        .finally(() => {
                            // ✅ Always hide loader after fetch is done (success or error)
                            $("#loadingSpinner").addClass("d-none");
                        });
                } else {
                    console.error('Form element not found');
                }
            });

            document.getElementById('searchFilterBtn4').addEventListener('click', function() {
                const form = document.getElementById('filterform4');

                // Ensure the form element exists before proceeding

                // Uncheck "Open Now" toggle if selected
                const openToggle = document.getElementById('openToggle');
                if (openToggle && openToggle.checked) {
                    openToggle.checked = false;
                }

                if (form) {
                    var data = new FormData(form);
                    data.append('is_ajax', 1);
                    $("#loadingSpinner").removeClass("d-none");
                    // Debug: Log form data
                    console.log("Form data:", data);

                    // Send the filter data to the backend
                    fetch('{{ route('services.filter') }}', {

                            method: 'POST', // Use POST to send form data in the body
                            body: data,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token for security
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Ensure the response has the correct HTML content
                            console.log("Filter response data:", data);

                            const shopContainer = document.querySelector('#filterdynamicdiv');
                            if (shopContainer) {
                                shopContainer.innerHTML = ''; // Clear the container

                                // Check if the HTML is correctly returned
                                if (data.html) {
                                    shopContainer.innerHTML = data.html; // Replace content
                                } else {
                                    console.error('No HTML content in response');
                                }
                            } else {
                                console.error('Filter container #filterdynamicdiv not found');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching filter data:', error);
                            $("#loadingSpinner").addClass("d-none");
                        });
                } else {
                    console.error('Form element not found');
                }
            });
        });
    </script>

    {{-- filter logic end --}}


    {{-- get user location start  --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById("latitude").value = position.coords.latitude;
                    document.getElementById("longitude").value = position.coords.longitude;

                    document.getElementById("latitude1").value = position.coords.latitude;
                    document.getElementById("longitude1").value = position.coords.longitude;

                    document.getElementById("latitude2").value = position.coords.latitude;
                    document.getElementById("longitude2").value = position.coords.longitude;

                    document.getElementById("latitude3").value = position.coords.latitude;
                    document.getElementById("longitude3").value = position.coords.longitude;

                    // alert("Latitude: " + position.coords.latitude + "\nLongitude: " + position.coords.longitude);
                }, function(error) {
                    console.warn("Geolocation failed or was denied:", error.message);
                });
            } else {
                console.warn("Geolocation is not supported by this browser.");
            }
        });
    </script>
    <script>
        async function getAddressFromCoordinates(lat, lng, callback) {
            try {
                const response = await fetch(
                    `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=AIzaSyBHTfGE9bbvleasezO-T-j1u5UVm6aTnl0`
                );
                const data = await response.json();

                if (data.status === "OK" && data.results.length > 0) {
                    const address = data.results[0].formatted_address;
                    if (callback) callback(address);
                } else {
                    console.warn("No address found.");
                    if (callback) callback(null);
                }
            } catch (err) {
                console.error("Geocoding error:", err.message);
                if (callback) callback(null);
            }
        }
    </script>
    {{-- get user location end --}}



    {{-- open now logic start --}}
    <script>
        document.getElementById('openToggle').addEventListener('change', function() {
            const spinner = document.getElementById("loadingSpinner");
            spinner.classList.remove("d-none");

            setTimeout(() => {
                const shopDivs = document.querySelectorAll('.shopdiv');

                shopDivs.forEach(shop => {
                    const statusElement = shop.querySelector('.openclosed');
                    const isOpen = statusElement && statusElement.textContent.trim().toLowerCase()
                        .includes('open');

                    if (this.checked) {
                        // Show only open shops
                        shop.style.display = isOpen ? 'block' : 'none';
                    } else {
                        // Show all shops
                        shop.style.display = 'block';
                    }
                });

                spinner.classList.add("d-none"); // Hide spinner after filtering
            }, 500); // simulate loading delay
        });
    </script>

    {{-- open now logic end --}}

    <script>
        $(document).ready(function() {
            // Initialize Select2 for province and city
            $('#province1').select2();
            $('#city1').select2();

            // Handle province change
            $('#province1').on('change', function() {
                var provinceId = $(this).val();
                var $citySelect = $('#city1');

                // Clear existing options and destroy previous Select2 instance
                $citySelect.select2('destroy'); // Important: remove old instance
                $citySelect.html('<option value="" selected>Select City</option>');

                if (provinceId) {
                    fetch(`/getCities/${provinceId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(city => {
                                const option = new Option(city.name, city.id, false, false);
                                $citySelect.append(option);
                            });

                            // Re-initialize Select2 with new options
                            $citySelect.select2();
                        })
                        .catch(error => console.error('Error fetching cities:', error));
                } else {
                    // Re-initialize even if no province selected
                    $citySelect.select2();
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 for province and city
            $('#province').select2();
            $('#city').select2();

            // Handle province change
            $('#province').on('change', function() {
                var provinceId = $(this).val();
                var $citySelect = $('#city');

                // Clear existing options and destroy previous Select2 instance
                $citySelect.select2('destroy'); // Important: remove old instance
                $citySelect.html('<option value="" selected>Select City</option>');

                if (provinceId) {
                    fetch(`/getCities/${provinceId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(city => {
                                const option = new Option(city.name, city.id, false, false);
                                $citySelect.append(option);
                            });

                            // Re-initialize Select2 with new options
                            $citySelect.select2();
                        })
                        .catch(error => console.error('Error fetching cities:', error));
                } else {
                    // Re-initialize even if no province selected
                    $citySelect.select2();
                }
            });
        });
    </script>
    {{-- sorting logic start here --}}

    <script>
        function sortBy(order) {
            const shopDivs = document.querySelectorAll('.shopdiv');
            const isAscending = order === 'oldest';

            const sortedShops = Array.from(shopDivs).sort((a, b) => {
                const ratingA = parseFloat(a.getAttribute('data-rating'));
                const ratingB = parseFloat(b.getAttribute('data-rating'));
                return isAscending ? ratingA - ratingB : ratingB - ratingA;
            });

            const shopContainer = document.querySelector('.shops-container');
            shopContainer.innerHTML = '';
            sortedShops.forEach(shop => shopContainer.appendChild(shop));
        }
    </script>
    <script>
        // Prevent dropdown from closing when interacting with selects
        document.querySelectorAll('.dropdown-menu select').forEach(select => {
            select.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });

        // Optional: prevent it from closing when clicking inside custom fields
        document.querySelectorAll('.dropdown-menu input').forEach(input => {
            input.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.dropdown-menu select, .dropdown-menu input').forEach(el => {
                el.addEventListener('click', function(e) {
                    e.stopPropagation(); // prevents dropdown from closing
                });
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('imageInput');
            const row = document.getElementById('image-upload-row');
            const imageCounter = document.getElementById('image-counter');
            let selectedImages = [];

            imageInput.addEventListener('change', function(e) {
                const files = Array.from(e.target.files);

                // Stop if over 10
                if (selectedImages.length + files.length > 10) {
                    alert("You can upload up to 10 images only.");
                    return;
                }

                files.forEach((file, index) => {
                    const previewURL = URL.createObjectURL(file);
                    const col = document.createElement('div');
                    col.className = 'col-2 image-box mb-3';

                    const img = document.createElement('img');
                    img.src = previewURL;
                    img.className = 'image-preview';

                    const btn = document.createElement('button');
                    btn.className = 'remove-btn';
                    btn.innerHTML = '&times;';
                    btn.onclick = function() {
                        col.remove();

                        // Remove file from selectedImages
                        const inputFiles = new DataTransfer();
                        selectedImages = selectedImages.filter(f => f !== file);
                        selectedImages.forEach(f => inputFiles.items.add(f));
                        imageInput.files = inputFiles.files;

                        updateCounter();
                    };

                    col.appendChild(img);
                    col.appendChild(btn);
                    row.appendChild(col);

                    selectedImages.push(file);

                    updateCounter();
                });

                // Reset original input's files
                const dt = new DataTransfer();
                selectedImages.forEach(file => dt.items.add(file));
                imageInput.files = dt.files;
            });

            function updateCounter() {
                imageCounter.textContent = `${selectedImages.length}/10 photos`;
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Track selected vehicle type globally
            let selectedVehicle = null;
            const vehicleCheckboxes = document.querySelectorAll('input[name="vehicle_type"]');

            // Function to update all vehicle images in all steps
            function updateAllVehicleImages() {
                // Get selected value (only one can be selected)
                const selectedValue = document.querySelector('input[name="vehicle_type"]:checked')?.value;
                selectedVehicle = selectedValue || null;

                // Determine image source
                let imgSrc = '';
                if (selectedVehicle === 'car') {
                    imgSrc = "{{ asset('web/services/images/Frameee.svg') }}";
                } else if (selectedVehicle === 'bike') {
                    imgSrc = "{{ asset('web/services/images/bike_request_qoute.svg') }}";
                }

                // Update all image containers
                document.querySelectorAll('.vehicle-image-container').forEach(container => {
                    container.innerHTML = imgSrc ?
                        `<img src="${imgSrc}" class="img-fluid" alt="${selectedVehicle} image">` :
                        '';
                });
            }

            // Make vehicle selection mutually exclusive
            vehicleCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        // Uncheck other vehicle options
                        vehicleCheckboxes.forEach(cb => {
                            if (cb !== this) cb.checked = false;
                        });
                        updateAllVehicleImages();
                    } else {
                        // Prevent unchecking the last checked option
                        const anyChecked = [...vehicleCheckboxes].some(cb => cb.checked);
                        if (!anyChecked) {
                            this.checked = true;
                        }
                    }
                });
            });

            // Initialize images on load
            updateAllVehicleImages();
        });
    </script>


@endsection
