@extends('layout.panel_layout.main')
@section('content')
    <style>
        body {
            font-family: 'Maven Pro', sans-serif !important;
        }

        .double-border-radio-group {
            display: flex;
            gap: 60px;
            justify-content: start;
            align-items: center;

            padding: 20px;
        }

        .double-border-radio {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 16px;
            color: #281F48;
            cursor: pointer;
        }

        .double-border-radio input[type="radio"] {
            appearance: none;
            -webkit-appearance: none;
            background-color: transparent;
            margin: 0;
            width: 30px;
            height: 30px;
            border: 2px solid #241F48;
            border-radius: 50%;
            display: grid;
            place-content: center;
            position: relative;
        }

        .double-border-radio input[type="radio"]::before {
            content: "";
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: transparent;
            border: 2px solid #241F48;
            transition: all 0.2s ease;
        }

        .double-border-radio input[type="radio"]:checked::before {
            background-color: #241F48;
        }

        .divclr {

            background-color: #f0f3f6;
        }

        h1 {
            font-weight: 700;
            color: #DD1F1A !important;
            font-size: 48px;
        }

        #goToTop,
        #goToBottom {
            position: fixed;
            right: 20px;
            padding: 10px;
            padding-left: 15px;
            padding-right: 15px;
            font-size: 20px;
            background-color: #FD5631;
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
            background-color: #f94922;
        }

        /* Show buttons with fade-in effect */
        #goToTop.show,
        #goToBottom.show {
            opacity: 1;
            visibility: visible;
        }

        .custom-btn-nav {
            background-color: #281F48;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            padding: 5px 50px;
        }

        .custom-btn-nav:hover {

            border: 1px solid #281F48;
        }

        .custom-btn-nave {
            background-color: white;
            color: #281F48;
            border: 1px solid #281F48;
            font-size: 16px;
            border-radius: 5px;
            padding: 5px 50px;
        }

        .custom-btn-nave:hover {
            background-color: #281F48;
            color: white;
            border: 1px solid #281F48;
            font-size: 16px;
            border-radius: 5px;
            padding: 5px 50px;
        }

        h4 {
            color: #281F48;
        }

        @media (min-width: 300px) and (max-width: 600px) {

            /* Your styles here */
            h1 {
                font-size: 30px;
            }
        }
    </style>

@if(Request::is('superadmin/*'))
    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <h1>Select Advertisement Type</h1>
            </div>
            <div class="col-12 mt-2 rounded divclr p-3">
                <h4>Please share the type of ad this is?</h4>
                <div class="double-border-radio-group">
                    <label class="double-border-radio">
                        <input type="radio" name="vehicle" value="car" checked>
                        New / Used Car
                    </label>

                    <label class="double-border-radio">
                        <input type="radio" name="vehicle" value="bike">
                        New / Used Bike
                    </label>
                </div>
            </div>
            <div class="col-12 my-3 d-flex justify-content-end">
                <button class="btn custom-btn-nav  ">Back</button>
                <a href="{{route('superadmin.ads.create')}}" class="btn custom-btn-nave  ms-3" id="gotobtn">Next</a>
            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
      $('input[name="vehicle"]').on('change', function() {
        var val = $(this).val();
        if(val == 'bike') {
          $('#gotobtn').attr('href', "{{ url('superadmin/bike-ads/create') }}");
        } else{
          $('#gotobtn').attr('href', "{{ route('superadmin.ads.create') }}");
        }
      });
    </script>
    @else
    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <h1>Select Advertisement Type</h1>
            </div>
            <div class="col-12 mt-2 rounded divclr p-3">
                <h4>Please share the type of ad this is?</h4>
                <div class="double-border-radio-group">
                    <label class="double-border-radio">
                        <input type="radio" name="vehicle" value="car" checked>
                        New / Used Car
                    </label>

                    <label class="double-border-radio">
                        <input type="radio" name="vehicle" value="bike">
                        New / Used Bike
                    </label>
                </div>
            </div>
            <div class="col-12 my-3 d-flex justify-content-end">
                <button class="btn custom-btn-nav  ">Back</button>
                <a href="{{route('ads.create')}}" class="btn custom-btn-nave  ms-3" id="gotobtn">Next</a>
            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
      $('input[name="vehicle"]').on('change', function() {
        var val = $(this).val();
        if(val == 'bike') {
          $('#gotobtn').attr('href', "{{ route('bike_ads.create') }}");
        } else{
          $('#gotobtn').attr('href', "{{ route('ads.create') }}");
        }
      });
    </script>
    @endif




    @if (session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    @if (session('error'))
                        var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                        errorModal.show();
                    @endif
                });
            </script>
        @endif
        <!-- Error Modal -->
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow">
                    <div class="modal-header bg-danger" style="border:none !important">
                        <h5 class="modal-title" id="errorModalLabel">Error</h5>
                        <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-danger">
                        {{ session('error') }}
                    </div>
                    <div class="modal-footer justify-content-end border-0">
                        <a href="#" class="btn btn-light px-4 py-2 "
                            style="background-color: white; font-weight:600; color: #FD5631; border-radius: 5px;"
                            data-bs-dismiss="modal">close</a>

                    </div>
                </div>
            </div>
        </div>

@endsection
