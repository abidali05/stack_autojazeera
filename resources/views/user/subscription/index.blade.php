{{-- @dd($plans['car_dealer_plans'][0]->metadata->type); --}}
@extends('layout.panel_layout.main')
@section('content')
    <style>
        .backimg {
            background-image: url('{{ asset('web/images/renamepic.svg') }}');
            /* Correct image URL */
            background-size: cover;
            /* Make the image cover the element */
            background-position: center;
            /* Center the image */
            background-repeat: no-repeat;
            /* Prevent tiling */
            width: 100%;
            /* Adjust width as needed */
        }

        .backimg1 {
            background-image: url('{{ asset('web/images/hero-bg 2 (1).svg') }}');
            /* Correct image URL */
            background-size: cover;
            /* Make the image cover the element */
            background-position: center;
            /* Center the image */
            background-repeat: no-repeat;
            /* Prevent tiling */
            width: 100%;
            /* Adjust width as needed */
        }

        .modal-title {
            font-size: 28px;
            font-weight: bold;
            color: #2D2D2D;
            margin-bottom: 15px;
        }

        .modal-description {
            font-size: 14px;
            color: #6E6E6E;
            margin-bottom: 20px;
        }

        .form-label {
            font-size: 12px;
            color: #2D2D2D;
            font-weight: 500;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #D9D9D9;
            height: 40px;
            font-size: 14px;
            padding: 8px 12px;
            margin-bottom: 20px;
        }

        #card-element {
            border-radius: 5px;
            border: 1px solid #D9D9D9;
            height: 40px;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .btn-confirm-payment {
            background-color: #E2342D;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            padding: 12px;


            cursor: pointer;
        }

        .btn-confirm-payment:hover {
            background-color: #271F41;
            color: white;
        }

        .small-text {
            font-size: 12px;
            color: #6E6E6E;
            margin-top: 10px;
        }

        .small-text a {
            color: #E2342D;
            text-decoration: none;
        }

        .small-text a:hover {
            text-decoration: underline;
        }

        .row input {
            margin-bottom: 10px;
        }

        .topclas {
            top: -20px;
            right: 0px;
            position: absolute;
            color: white !important;
            background-color: #271F41;
            border-radius: 12px;
        }

        .premiumbadge {
            position: absolute;
            font-size: 12px;
            background-color: #FFFFFF29;
            border-radius: 10px;
            padding: 5px;
            color: white;
            right: 0px;
        }

        .textclas {
            color: white !important;
        }

        .textclrbluee {
            color: #271F41 !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('web/css/user_sub_plans.css') }}">
    <div class="container-fluid backimg ">


        @auth
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 ">
                    <div class="row d-flex justify-content-center">
                        <div class="col-11 ">
                            <p class="pt-5" style="font-size: 64px ; font-weight: 600; color: white;">Join US Today!
                            </p>

                            <div class="text-end mb-2">
                                <a href="{{ route('subscription_history') }}" class="text-white mb-2">Subscription History</a>
                            </div>
                            @if (Auth::user()->packagename)
                                <div class="col-md-12 rounded-2 backcur p-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="twenty"><img
                                                    src="{{ asset('web/images/material-symbols-light_workspace-premium-outline.svg') }}"
                                                    class="img-fluid me-2">Current Subscription Plan for Cars / Bikes</p>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row d-flex justify-content-between align-items-baseline">
                                                <div class="col-md-6">
                                                    <p class="m-0 wtwentysix">{{ Auth::user()->packagename ?? '' }}</p>
                                                </div>
                                                <div class="col-md-4 d-flex justify-content-end">
                                                    <a href="#private_seller_packages" class="redbttn mx-2">Change Plan</a>
                                                    <button class="blubttn mx-2" data-bs-toggle="modal"
                                                        data-bs-target="#cancelplanmodal">Cancel Plan</button>
                                                    {{-- <button class="whtbttn px-4">Invoice</button> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12 rounded-2 backcur p-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="twenty"><img
                                                    src="{{ asset('web/images/material-symbols-light_workspace-premium-outline.svg') }}"
                                                    class="img-fluid me-2">Current Subscription Plan for Cars / Bikes</p>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row d-flex justify-content-between align-items-baseline">
                                                <div class="col-md-6">
                                                    <p class="m-0 wtwentysix">You have not subscribed to any plan yet.</p>
                                                </div>
                                                <div class="col-md-4 d-flex justify-content-end">
                                                    <a href="#private_seller_packages" class="redbttn mx-2">Buy a Plan</a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (Auth::user()->service_package_name)
                                <div class="col-md-12 rounded-2 backcur p-3 rounded-2 backcur p-3 my-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="twenty"><img
                                                    src="{{ asset('web/images/material-symbols-light_workspace-premium-outline.svg') }}"
                                                    class="img-fluid me-2">Current Subscription Plan for Services</p>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row d-flex justify-content-between align-items-baseline">
                                                <div class="col-md-6">
                                                    <p class="m-0 wtwentysix">{{ Auth::user()->service_package_name ?? '' }}</p>
                                                </div>
                                                <div class="col-md-4 d-flex justify-content-end">
                                                    <a href="#services_packages" class="redbttn mx-2">Change Plan</a>
                                                    <button class="blubttn mx-2" data-bs-toggle="modal"
                                                        data-bs-target="#servicecancelplanmodal">Cancel Plan</button>
                                                    {{-- <button class="whtbttn px-4">Invoice</button> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12 rounded-2 backcur p-3 my-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="twenty"><img
                                                    src="{{ asset('web/images/material-symbols-light_workspace-premium-outline.svg') }}"
                                                    class="img-fluid me-2">Current Subscription Plan for Services</p>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row d-flex justify-content-between align-items-baseline">
                                                <div class="col-md-6">
                                                    <p class="m-0 wtwentysix">You have not subscribed to any plan yet.</p>
                                                </div>
                                                <div class="col-md-4 d-flex justify-content-end">
                                                    <a href="#services_packages" class="redbttn mx-2">Buy a Plan</a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-5  ">
                <div class="col-12">
                    <div class="row shadowss">
                        <div class="col-md-12 colorback p-3">
                            <p class="m-0" style="color: white">Advertisement Plans </p>
                        </div>
                        <div class="col-md-12 p-3 borderdiv">
                            <p class="m-0 mb-3">Just One Simple Monthly Fee: No Ad Expiry, No Additional Payments for Featured
                                Ads. </br>
                                💰 One Flat Monthly Fee — All-Inclusive</br>
                                📈 Better ROI, Guaranteed - Get longer visibility, more inquiries, and higher turnover — without
                                breaking the bank.</br>

                                <span><strong>Choose the Plan That Suits You and Start Posting Today!</strong></span>
                            </p>
                            <span class="mt-5"
                                style="background-color: #F40000; color:white; font-size:22px ;font-weight:600;border-radius:5px; padding:5px">
                                First month free with any paid plan</span>
                            <img src="{{ asset('web/images/Group (2).svg') }}" class="img-fluid md-3" alt="...">
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 mt-4">
                    <p class="m-0 headsub">Want to Post Car/Bike Ad?</p>
                </div>
            </div>
        </div>
        <div class="container-fluid backimg1  p-5">
            <div class="row  d-flex justify-content-center ">
                <div class="col-11 rounded-5" style="background-color: #E6F1FE;">

                    <div class="row" id="private_seller_packages">
                        <div class="col-12 p-3" style="position: relative">
                            <p class="m-0 twentysix">Private Seller Plans</p>
                            <div class="row ">
                                @foreach ($plans['private_seller_plans'] as $ads_plan)
                                    <div class="col-md-3 col-12 p-3 {{ $ads_plan->metadata->is_recomended == '1' ? 'topclas' : '' }}"
                                        id="card1-1">
                                        <div class="row">
                                            <div class="col-12 ">
                                                <p
                                                    class="m-0 premiumbadge {{ $ads_plan->metadata->is_recomended == '1' ? '' : 'd-none' }}">
                                                    Recommended</p>
                                                <p
                                                    class="twenty mt-5  {{ $ads_plan->metadata->is_recomended == '1' ? 'textclas' : '' }}">
                                                    {{ $ads_plan->name }}</p>
                                                <p class="headsured keep-color" style="font-size:28px !important">
                                                    @if ($ads_plan->price)
                                                        Rs {{ $ads_plan->price }} <span
                                                            class="{{ $ads_plan->metadata->is_recomended == '1' ? 'textclas' : 'textclrbluee' }}">/month</span>
                                                    @else
                                                        Free Forever
                                                    @endif
                                                </p>
                                                @foreach ($ads_plan->marketing_features as $feature)
                                                    <div class="d-flex">
                                                        <div><img src="{{ asset('web/images/check-circle-1.svg') }}"
                                                                class="img-fluid me-3" alt="..."></div>
                                                        <div>
                                                            <p
                                                                class="{{ $ads_plan->metadata->is_recomended == '1' ? 'textclas' : '' }}">
                                                                {{ $feature->name }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                @if ($ads_plan->price)
                                                    @if ($ads_plan->id == Auth::user()->package)
                                                        <button class="btnsub" style="background-color: #f4000079"
                                                            id="btn1-1" disabled>Already Purchased</button>
                                                    @else
                                                        <button class="btnsub" style="background-color: #F40000"
                                                            id="btn1-1"
                                                            onclick="openModal('{{ $ads_plan->id }}', {{ $ads_plan->price }}, 'ads'); changeText(this);">Choose
                                                            plan</button>
                                                    @endif
                                                @else
                                                    @if (Auth::user()->free_package_availed == '1')
                                                        <button class="btnsub" style="background-color: #f4000079"
                                                            id="btn1-1" disabled>Not Available</button>
                                                    @else
                                                        <button class="btnsub" style="background-color: #F40000"
                                                            id="btn1-1"
                                                            onclick="window.location.href='signupwithfreeplan'">Choose
                                                            plan</button>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid backimg1 p-5">
            <div class="row d-flex justify-content-center">
                <div class="col-11 rounded-5" style="background-color: #E6F1FE;">
                    <div class="row">
                        <div class="col-12 p-3" style="position: relative">
                            <p class="m-0 twentysix">Car/Bike Dealer Plans</p>
                            <div class="row">
                                @foreach ($plans['car_dealer_plans'] as $ads_plan)
                                    <div class="col-md-3 col-12 p-3 {{ $ads_plan->metadata->is_recomended == '1' ? 'topclas' : '' }}"
                                        id="card1-1">
                                        <div class="row">
                                            <div class="col-12 ">
                                                <p
                                                    class="m-0 premiumbadge  {{ $ads_plan->metadata->is_recomended == '1' ? '' : 'd-none' }}">
                                                    Recommended</p>
                                                <p
                                                    class="twenty mt-5 {{ $ads_plan->metadata->is_recomended == '1' ? 'textclas' : '' }}">
                                                    {{ $ads_plan->name }}</p>
                                                <p class="headsured keep-color" style="font-size:28px !important">
                                                    @if ($ads_plan->price)
                                                        Rs {{ $ads_plan->price }} <span
                                                            class="{{ $ads_plan->metadata->is_recomended == '1' ? 'textclas' : 'textclrbluee' }}">/month</span>
                                                    @else
                                                        Free Forever
                                                    @endif
                                                </p>
                                                @foreach ($ads_plan->marketing_features as $feature)
                                                    <div class="d-flex">
                                                        <div><img src="{{ asset('web/images/check-circle-1.svg') }}"
                                                                class="img-fluid me-3" alt="..."></div>
                                                        <div>
                                                            <p
                                                                class="{{ $ads_plan->metadata->is_recomended == '1' ? 'textclas' : '' }}">
                                                                {{ $feature->name }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                @if ($ads_plan->id == Auth::user()->package)
                                                    <button class="btnsub" style="background-color: #f4000079" id="btn1-1"
                                                        disabled>Already Purchased</button>
                                                @else
                                                    <button class="btnsub" style="background-color: #F40000" id="btn1-1"
                                                        onclick="openModal('{{ $ads_plan->id }}', {{ $ads_plan->price }}, 'ads'); changeText(this);">Choose
                                                        plan</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row" id="services_packages">
                <div class="col-md-12 mt-4">
                    <p class="m-0 headsub">Want to advertise Auto Service Business ?</p>
                </div>
            </div>
        </div>
        <div class="container-fluid backimg1 p-5">
            <div class="row d-flex justify-content-center py-5">
                <div class="col-11 rounded-5" style="background-color: #E6F1FE;">
                    <div class="row">
                        <div class="col-12 p-3 " style="position: relative">
                            <p class="m-0 twentysix">Service Plans</p>
                            <div class="row">
                                @foreach ($plans['service_plans'] as $plan)
                                    <div class="col-md-3 col-12 p-3 {{ $plan->metadata->is_recomended == '1' ? 'topclas' : '' }}"
                                        id="card1-1">
                                        <div class="row">
                                            <div class="col-12 ">
                                                <p
                                                    class="m-0 premiumbadge  {{ $plan->metadata->is_recomended == '1' ? '' : 'd-none' }}">
                                                    Recommended</p>
                                                <p
                                                    class="twenty mt-5 {{ $plan->metadata->is_recomended == '1' ? 'textclas' : '' }}">
                                                    {{ $plan->name }}</p>
                                                <p class="headsured keep-color" style="font-size:28px !important">
                                                    @if ($plan->price)
                                                        Rs {{ $plan->price }} <span
                                                            class="{{ $plan->metadata->is_recomended == '1' ? 'textclas' : 'textclrbluee' }}">/month</span>
                                                    @else
                                                        Free Forever
                                                    @endif
                                                </p>
                                                @foreach ($plan->marketing_features as $feature)
                                                    <div class="d-flex">
                                                        <div><img src="{{ asset('web/images/check-circle-1.svg') }}"
                                                                class="img-fluid me-3" alt="..."></div>
                                                        <div>
                                                            <p
                                                                class="{{ $plan->metadata->is_recomended == '1' ? 'textclas' : '' }}">
                                                                {{ $feature->name }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                @if ($plan->id == Auth::user()->shop_package)
                                                    <button class="btnsub" style="background-color: #f4000079" id="btn1-1"
                                                        disabled>Already Purchased</button>
                                                @else
                                                    <button class="btnsub" style="background-color: #F40000" id="btn1-1"
                                                        onclick="openModal('{{ $plan->id }}', {{ $plan->price }}, 'service'); changeText(this);">Choose
                                                        plan</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal" id="payment-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog modal-fullscreen-sm-down">
                <div class="modal-content" style="background-color: white !imprtant; border-radius: 20px;">
                    <div class="modal-header d-flex justify-content-end"
                        style="border: none; background-color: white !important; border-top-left-radius: 20px; border-top-right-radius: 20px;">
                        <button type="button" class="btn p-0 text-end  rounded-circle" data-bs-dismiss="modal"
                            aria-label="Close" style=" display: flex; align-items: center; justify-content: center;">
                            <img src="{{ asset('web/images/Vector (3).svg') }}" class="img-fluid " alt="...">
                        </button>

                    </div>
                    <div class="modal-body pt-0"
                        style="background-color: white !important ; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
                        <form id="payment-form" action="{{ route('payment.process') }}" method="POST">
                            @csrf

                            <input type="hidden" name="plan_id" id="plan_id">
                            <input type="hidden" name="amount" id="amount">
                            <input type="hidden" name="stripe_token" id="stripe_token">
                            <input type="hidden" name="sub_type" id="sub_type">

                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="modal-title d-flex justify-content-between"><span
                                                style="font-size:20px; font-weight:600;">Payment</span></p>
                                        <p class="modal-description">We’re thrilled to have you on board! To make things
                                            easier, enjoy your first month free. Start promoting and driving sales today!</p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="billed-to" class="form-label">Billed to*</label>
                                            <input type="text" class="form-control" id="cardName"
                                                placeholder="Sameed Akram" value="{{ Auth::user()->name }}" name="cardName"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label for="card-element" class="form-label d-flex justify-content-between"><span
                                                class="m-0"
                                                style="    font-family: Maven Pro;
    font-size: 17.6px;
    font-weight: 500;
    line-height: 20.68px;
    text-align: left;">Card
                                                Information*</span><span>
                                                <img src="{{ asset('web/images/Frame 45.svg') }}" class="img-fluid me-3"
                                                    alt="...">
                                                <img src="{{ asset('web/images/Frame 46.svg') }}" class="img-fluid me-3"
                                                    alt="...">
                                                {{-- <img src="{{ asset('web/images/Frame 47.svg') }}" class="img-fluid me-3" alt="..."> --}}
                                            </span></label>
                                        <div id="card-number" class="rounded py-2 ps-2"
                                            style="background-color: white; border: 1px solid black;"></div>
                                        <div id="cardNumber-errors" role="alert" class="text-danger mt-2"></div>
                                    </div>
                                    <div class="col-md-6 mb-2 pe-2">
                                        <label for="expiry-element" class="form-label">Expiration Date*</label>
                                        <div id="card-expiry" class="rounded py-2 ps-2"
                                            style="background-color: white; border: 1px solid black;"></div>
                                        <div id="expireDate-errors" role="alert" class="text-danger mt-2"></div>
                                    </div>

                                    <div class="col-md-6 mb-2 ps-2">
                                        <label for="cvc-element" class="form-label">CVV*</label>
                                        <div id="card-cvc" class="rounded py-2 ps-2"
                                            style="background-color: white; border: 1px solid black;"></div>
                                        <div id="cvv-errors" role="alert" class="text-danger mt-2"></div>
                                    </div>

                                    <!-- Payment Button -->
                                    <div class="col-md-12 mt-2" id="payment-button-container">
                                        <button class="w-100 btn-confirm-payment" type="submit"
                                            id="payment-submit-button">Confirm Payment</button>
                                    </div>

                                    <div class="col-md-12 mt-2 d-none" id="loader">
                                        <button
                                            class="w-100 btn-confirm-payment d-flex align-items-center justify-content-center"
                                            type="button" disabled>
                                            <span class="spinner-border spinner-border-sm me-2" role="status"
                                                aria-hidden="true"></span>
                                            Processing...
                                        </button>
                                    </div>


                                    <!-- Footer Info -->
                                    <div class="col-md-12 mt-4">
                                        <p class="">You can cancel your subscription anytime .</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        {{-- cancelplanmodal start --}}


        <div class="modal fade" id="cancelplanmodal" tabindex="-1" aria-labelledby="cancelplanmodalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                    <!-- Modal Header -->
                    <div class="modal-header" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                        <h5 class="modal-title" id="cancelplanmodalLabel"><strong> Cancel Plan </strong></h5>
                        <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body text-center"  style="background-color: #F0F3F6  !important; color: #281F48;">
                        <p>Are you sure to cancel the plan?</p>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                        <a href="{{ url('cancel-plan') }}" type="button"  class="btn btn-light px-4 py-2 " style="background-color: white; font-weight:600; color: #281F48; border-radius: 5px;">Yes</a>
                        <button type="button"  class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- cancelplanmodal end --}}

        {{-- cancelplanmodal FOR SERVICES PLANS start --}}


        <div class="modal fade" id="servicecancelplanmodal" tabindex="-1" aria-labelledby="servicecancelplanmodalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content"  style="border-radius: 10px; overflow: hidden;">
                    <!-- Modal Header -->
                    <div class="modal-header" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;" >
                        <h5 class="modal-title" id="servicecancelplanmodalLabel"><strong> Cancel Plan </strong></h5>
                        <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body text-center"  style="background-color: #F0F3F6  !important; color: #281F48;">
                        <p>Are you sure to cancel the plan?</p>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                        <a href="{{ url('cancel-service-plan') }}" type="button" class="btn btn-light px-4 py-2 " style="background-color: white; font-weight:600; color: #281F48; border-radius: 5px;">Yes</a>
                        <button type="button" class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- cancelplanmodal end --}}


        {{-- success modal start --}}


        <div class="modal fade" id="paymentresponse" tabindex="-1" aria-labelledby="paymentresponseLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                    <!-- Modal Header -->
                    <div class="modal-header" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                        <h5 class="modal-title" id="paymentresponseLabel"><strong> Payment </strong></h5>
                        <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body text-center" style="background-color: #F0F3F6  !important; color: #281F48;">
                        <p>{{ session('paymentresponse') }}</p>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                        <button type="button" class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- success modal end --}}
    @endauth


    @guest
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 ">
                <div class="row d-flex justify-content-center">
                    <div class="col-11 ">
                        <p class="pt-5" style="font-size: 64px ; font-weight: 600; color: white;">Join US Today!
                        </p>

                        <div class="text-end mb-2">
                            <a href="#" class="text-white mb-2">No Subscription History Yet</a>
                        </div>


                        <div class="col-md-12 rounded-2 backcur p-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="twenty"><img
                                            src="{{ asset('web/images/material-symbols-light_workspace-premium-outline.svg') }}"
                                            class="img-fluid me-2">Current Subscription Plan for Cars / Bikes</p>
                                </div>

                                <div class="col-md-12">
                                    <div class="row d-flex justify-content-between align-items-baseline">
                                        <div class="col-md-6">
                                            <p class="m-0 wtwentysix">You have not subscribed to any plan yet.</p>
                                        </div>
                                        <div class="col-md-4 d-flex justify-content-end">
                                            <a href="#private_seller_packages" class="redbttn mx-2">Buy a Plan</a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 rounded-2 backcur p-3 my-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="twenty"><img
                                            src="{{ asset('web/images/material-symbols-light_workspace-premium-outline.svg') }}"
                                            class="img-fluid me-2">Current Subscription Plan for Services</p>
                                </div>

                                <div class="col-md-12">
                                    <div class="row d-flex justify-content-between align-items-baseline">
                                        <div class="col-md-6">
                                            <p class="m-0 wtwentysix">You have not subscribed to any plan yet.</p>
                                        </div>
                                        <div class="col-md-4 d-flex justify-content-end">
                                            <a href="#services_packages" class="redbttn mx-2">Buy a Plan</a>

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
        <div class="container">
            <div class="row mt-5  ">
                <div class="col-12">
                    <div class="row shadowss">
                        <div class="col-md-12 colorback p-3">
                            <p class="m-0" style="color: white">Advertisement Plans </p>
                        </div>
                        <div class="col-md-12 p-3 borderdiv">
                            <p class="m-0 mb-3">Just One Simple Monthly Fee: No Ad Expiry, No Additional Payments for Featured
                                Ads. </br>
                                💰 One Flat Monthly Fee — All-Inclusive</br>
                                📈 Better ROI, Guaranteed - Get longer visibility, more inquiries, and higher turnover — without
                                breaking the bank.</br>

                                <span><strong>Choose the Plan That Suits You and Start Posting Today!</strong></span>
                            </p>
                            <span class="mt-5"
                                style="background-color: #F40000; color:white; font-size:22px ;font-weight:600;border-radius:5px; padding:5px">
                                First month free with any paid plan</span>
                            <img src="{{ asset('web/images/Group (2).svg') }}" class="img-fluid md-3" alt="...">
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 mt-4">
                    <p class="m-0 headsub">Want to Post Car/Bike Ad?</p>
                </div>
            </div>
        </div>
        <div class="container-fluid backimg1  p-5">
            <div class="row  d-flex justify-content-center ">
                <div class="col-11 rounded-5" style="background-color: #E6F1FE;">

                    <div class="row" id="private_seller_packages">
                        <div class="col-12 p-3" style="position: relative">
                            <p class="m-0 twentysix">Private Seller Plans</p>
                            <div class="row ">
                                @foreach ($plans['private_seller_plans'] as $ads_plan)
                                    @if ($ads_plan->metadata->type == 'private_seller')
                                        <div class="col-md-3 col-12 p-3 {{ $ads_plan->metadata->is_recomended == '1' ? 'topclas' : '' }}"
                                            id="card1-1">
                                            <div class="row">
                                                <div class="col-12 ">
                                                    <p
                                                        class="m-0 premiumbadge {{ $ads_plan->metadata->is_recomended == '1' ? '' : 'd-none' }}">
                                                        Recommended</p>
                                                    <p
                                                        class="twenty mt-5  {{ $ads_plan->metadata->is_recomended == '1' ? 'textclas' : '' }}">
                                                        {{ $ads_plan->name }}</p>
                                                    <p class="headsured keep-color" style="font-size:28px !important">
                                                        @if ($ads_plan->price)
                                                            Rs {{ $ads_plan->price }} <span
                                                                class="{{ $ads_plan->metadata->is_recomended == '1' ? 'textclas' : 'textclrbluee' }}">/month</span>
                                                        @else
                                                            Free Forever
                                                        @endif
                                                    </p>
                                                    @foreach ($ads_plan->marketing_features as $feature)
                                                        <div class="d-flex">
                                                            <div><img src="{{ asset('web/images/check-circle-1.svg') }}"
                                                                    class="img-fluid me-3" alt="..."></div>
                                                            <div>
                                                                <p
                                                                    class="{{ $ads_plan->metadata->is_recomended == '1' ? 'textclas' : '' }}">
                                                                    {{ $feature->name }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach


                                                    <button id="btn1-1" class="btnsub" style="background-color: #F40000;"
                                                        onclick="window.location='/login'">
                                                        Choose plan
                                                    </button>


                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid backimg1 p-5">
            <div class="row d-flex justify-content-center">
                <div class="col-11 rounded-5" style="background-color: #E6F1FE;">
                    <div class="row">
                        <div class="col-12 p-3" style="position: relative">
                            <p class="m-0 twentysix">Car/Bike Dealer Plans</p>
                            <div class="row">
                                @foreach ($plans['car_dealer_plans'] as $ads_plan)
                                    @if ($ads_plan->metadata->type == 'car_dealer')
                                        <div class="col-md-3 col-12 p-3 {{ $ads_plan->metadata->is_recomended == '1' ? 'topclas' : '' }}"
                                            id="card1-1">
                                            <div class="row">
                                                <div class="col-12 ">
                                                    <p
                                                        class="m-0 premiumbadge  {{ $ads_plan->metadata->is_recomended == '1' ? '' : 'd-none' }}">
                                                        Recommended</p>
                                                    <p
                                                        class="twenty mt-5 {{ $ads_plan->metadata->is_recomended == '1' ? 'textclas' : '' }}">
                                                        {{ $ads_plan->name }}</p>
                                                    <p class="headsured keep-color" style="font-size:28px !important">
                                                        @if ($ads_plan->price)
                                                            Rs {{ $ads_plan->price }} <span
                                                                class="{{ $ads_plan->metadata->is_recomended == '1' ? 'textclas' : 'textclrbluee' }}">/month</span>
                                                        @else
                                                            Free Forever
                                                        @endif
                                                    </p>
                                                    @foreach ($ads_plan->marketing_features as $feature)
                                                        <div class="d-flex">
                                                            <div><img src="{{ asset('web/images/check-circle-1.svg') }}"
                                                                    class="img-fluid me-3" alt="..."></div>
                                                            <div>
                                                                <p
                                                                    class="{{ $ads_plan->metadata->is_recomended == '1' ? 'textclas' : '' }}">
                                                                    {{ $feature->name }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach


                                                    <button id="btn1-1" class="btnsub" style="background-color: #F40000;"
                                                        onclick="window.location='/login'">
                                                        Choose plan
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row" id="services_packages">
                <div class="col-md-12 mt-4">
                    <p class="m-0 headsub">Want to advertise Auto Service Business ?</p>
                </div>
            </div>
        </div>
        <div class="container-fluid backimg1 p-5">
            <div class="row d-flex justify-content-center py-5">
                <div class="col-11 rounded-5" style="background-color: #E6F1FE;">
                    <div class="row">
                        <div class="col-12 p-3 " style="position: relative">
                            <p class="m-0 twentysix">Service Plans</p>
                            <div class="row">
                                @foreach ($plans['service_plans'] as $plan)
                                    <div class="col-md-3 col-12 p-3 {{ $plan->metadata->is_recomended == '1' ? 'topclas' : '' }}"
                                        id="card1-1">
                                        <div class="row">
                                            <div class="col-12 ">
                                                <p
                                                    class="m-0 premiumbadge  {{ $plan->metadata->is_recomended == '1' ? '' : 'd-none' }}">
                                                    Recommended</p>
                                                <p
                                                    class="twenty mt-5 {{ $plan->metadata->is_recomended == '1' ? 'textclas' : '' }}">
                                                    {{ $plan->name }}</p>
                                                <p class="headsured keep-color" style="font-size:28px !important">
                                                    @if ($plan->price)
                                                        Rs {{ $plan->price }} <span
                                                            class="{{ $plan->metadata->is_recomended == '1' ? 'textclas' : 'textclrbluee' }}">/month</span>
                                                    @else
                                                        Free Forever
                                                    @endif
                                                </p>
                                                @foreach ($plan->marketing_features as $feature)
                                                    <div class="d-flex">
                                                        <div><img src="{{ asset('web/images/check-circle-1.svg') }}"
                                                                class="img-fluid me-3" alt="..."></div>
                                                        <div>
                                                            <p
                                                                class="{{ $plan->metadata->is_recomended == '1' ? 'textclas' : '' }}">
                                                                {{ $feature->name }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach


                                                <button id="btn1-1" class="btnsub" style="background-color: #F40000;"
                                                    onclick="window.location='/login'">
                                                    Choose plan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>




        {{-- cancelplanmodal start --}}


        <div class="modal fade" id="cancelplanmodal" tabindex="-1" aria-labelledby="cancelplanmodalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                    <!-- Modal Header -->
                    <div class="modal-header"  style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;" >
                        <h5 class="modal-title" id="cancelplanmodalLabel"><strong> Cancel Plan </strong></h5>
                        <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body text-center" style="background-color: #F0F3F6  !important; color: #281F48;">
                        <p>Are you sure to cancel the plan?</p>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                        <a href="{{ url('cancel-plan') }}" type="button" class="btn btn-light px-4 py-2 " style="background-color: white; font-weight:600; color: #281F48; border-radius: 5px;">Yes</a>
                        <button type="button" class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- cancelplanmodal end --}}

        {{-- cancelplanmodal FOR SERVICES PLANS start --}}


        <div class="modal fade" id="servicecancelplanmodal" tabindex="-1" aria-labelledby="servicecancelplanmodalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                    <!-- Modal Header -->
                    <div class="modal-header" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;" >
                        <h5 class="modal-title" id="servicecancelplanmodalLabel"><strong> Cancel Plan </strong></h5>
                        <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body  text-center" style="background-color: #F0F3F6  !important; color: #281F48;">
                        <p>Are you sure to cancel the plan?</p>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                        <a href="{{ url('cancel-service-plan') }}" type="button" class="btn btn-light px-4 py-2 " style="background-color: white; font-weight:600; color: #281F48; border-radius: 5px;">Yes</a>
                        <button type="button" class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- cancelplanmodal end --}}


        {{-- success modal start --}}


        <div class="modal fade" id="paymentresponse" tabindex="-1" aria-labelledby="paymentresponseLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                    <!-- Modal Header -->
                    <div class="modal-header" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                        <h5 class="modal-title" id="paymentresponseLabel"><strong> Payment </strong></h5>
                        <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body text-center" style="background-color: #F0F3F6 !important ; color: #281F48;">
                        <p>{{ session('paymentresponse') }}</p>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                        <button type="button" class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- success modal end --}}
    @endguest

    @if (session('paymentresponse'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                let modal = new bootstrap.Modal(document.getElementById('paymentresponse'));
                modal.show();
            });
        </script>
    @endif

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // Move the openModal function to the global scope so it can be accessed by inline onclick handlers
        function openModal(id, amount, type) {
            document.getElementById('plan_id').value = id;
            document.getElementById('amount').value = amount;
            document.getElementById('sub_type').value = type;
            const modal = document.getElementById('payment-modal');
            modal.style.display = 'block';
            // Use Bootstrap's modal method if available
            if (typeof bootstrap !== 'undefined') {
                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Stripe with your publishable key
            const stripe = Stripe(
                'pk_test_51P9UuSP2COuPjTaiiMu3M5sYksW1ClhLwGsxBmZwLNClNXyIWJwd3nwNMyubS6GOy2FlhsTvJMcdLL0Wpvs4z7C600m4dd2sHD'
            );
            const elements = stripe.elements({
                loader: 'auto'
            });
            const style = {
                base: {
                    color: '#271F41',
                    fontFamily: 'Arial, sans-serif',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#271F41'
                    },
                },
                invalid: {
                    color: '#fa755a'
                },
            };

            // Create card elements
            const cardNumber = elements.create('cardNumber', {
                style,
                disableLink: true
            });
            const cardExpiry = elements.create('cardExpiry', {
                style
            });
            const cardCvc = elements.create('cardCvc', {
                style
            });


            // Mount the elements to respective divs
            cardNumber.mount('#card-number');
            cardExpiry.mount('#card-expiry');
            cardCvc.mount('#card-cvc');


            // Handle real-time validation errors
            cardNumber.addEventListener('change', function(event) {
                const displayError = document.getElementById('cardNumber-errors');
                displayError.textContent = event.error ? event.error.message : '';
            });

            cardExpiry.addEventListener('change', function(event) {
                const displayError = document.getElementById('expireDate-errors');
                displayError.textContent = event.error ? event.error.message : '';
            });

            cardCvc.addEventListener('change', function(event) {
                const displayError = document.getElementById('cvv-errors');
                displayError.textContent = event.error ? event.error.message : '';
            });


            // Add event listener to the close button
            document.querySelector('.btn-close').addEventListener('click', function() {
                const modal = document.getElementById('payment-modal');
                modal.style.display = 'none';
                // Use Bootstrap's modal method if available
                if (typeof bootstrap !== 'undefined') {
                    const bsModal = bootstrap.Modal.getInstance(modal);
                    if (bsModal) bsModal.hide();
                }
            });


            // Handle form submission
            const form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                document.getElementById('payment-submit-button').disabled = true;
                event.preventDefault();

                // Create a Payment Method
                stripe.createPaymentMethod({
                    type: 'card',
                    card: cardNumber,
                    billing_details: {
                        name: document.getElementById('cardName').value,
                    },
                }).then(function(result) {
                    if (result.error) {
                        // alert(result.error.message);
                        // Display error to the user
                        document.getElementById('cardNumber-errors').textContent = result.error
                            .message;
                        document.getElementById('payment-submit-button').disabled = false;
                    } else {
                        document.getElementById('payment-button-container').classList.add('d-none');
                        document.getElementById('loader').classList.remove('d-none');
                        // Send the PaymentMethod ID to the server
                        stripePaymentMethodHandler(result.paymentMethod);
                    }
                });
            });

            // Send Payment Method to the server
            function stripePaymentMethodHandler(paymentMethod) {
                document.getElementById('stripe_token').value = paymentMethod.id;


                form.submit();
            }



            // Province-city selector logic
            const provinceSelect = document.getElementById('province');
            if (provinceSelect) {
                provinceSelect.addEventListener('change', function() {
                    var provinceId = this.value;
                    var citySelect = document.getElementById('city');

                    // Clear the current city options
                    citySelect.innerHTML = '<option value="" disabled selected>Select City</option>';

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
            }
        });

        function changeText(element) {
            document.querySelectorAll('.btn.custom-btn-2.w-100').forEach(anchor => {
                anchor.innerText = "Choose plan";
            });

            element.innerText = "Selected";
            //   element.disabled = true;
        }
    </script>
@endsection
