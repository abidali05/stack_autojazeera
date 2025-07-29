{{-- @dd($plans['car_dealer_plans'][0]->metadata->type); --}}
@extends('layout.website_layout.services.main')
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
.navbar {
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
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
          
            color: black !important;
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
            right: 95px;
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


        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 d-none ">
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
                        <div class="col-md-12 p-3 pb-0 borderdiv" style="border: none">
                            <p class="m-0 mb-3">Just One Simple Monthly Fee: No Ad Expiry, No Additional Payments for Featured
                                Ads. </br>
                                💰 One Flat Monthly Fee — All-Inclusive</br>
                                📈 Better ROI, Guaranteed - Get longer visibility, more inquiries, and higher turnover — without
                                breaking the bank.</br>

                                <span><strong>Choose the Plan That Suits You and Start Posting Today!</strong>    <img src="{{ asset('web/images/start_posting.svg') }}" style="height:60px;width:60px" class="img-fluid md-3 ms-3 " alt="...">
                        </div></span>
                            </p>
                       
                        
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
                        <div class="col-12 p-3" >
                            <p class="m-0 twentysix">Private Seller Plans</p>
                            <div class="row ">
                                @foreach ($plans['private_seller_plans'] as $ads_plan)
                                    @if ($ads_plan->metadata->type == 'private_seller')
                                        <div class="col-md-3 col-12 p-3 {{ $ads_plan->metadata->is_recomended == '1' ? 'topclas' : '' }}"
                                            id="card1-1">
                                            <div class="row">
                                               <div class="col-12 d-flex flex-column " style="height: 390px">
                                                    <p
                                                        class="m-0 premiumbadge {{ $ads_plan->metadata->is_recomended == '1' ? '' : 'd-none' }}">
                                                        Recommended</p>
                                                    <p
                                                        class="twenty mt-5 d-flex justify-content-between align-items-center  {{ $ads_plan->metadata->is_recomended == '1' ? 'textclas' : '' }}">
                                                        {{ $ads_plan->name }}
                                                    @if ($loop->first)
        <img src="{{ asset('web/images/free_trail.svg') }}" style="height:60px;width:60px" class="img-fluid md-3" alt="...">
    @else
    <img src="{{ asset('web/images/other_icon.svg') }}" style="height:50px;width:10px" class="img-fluid mb-3" >
@endif</p>
                                                    <p class="headsured keep-color" style="font-size:26px !important">
                                                        @if ($ads_plan->price)
                                                            Rs {{number_format($ads_plan->price) }} <span
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
    </div>

    {{-- Bottom Button --}}
    <div class="mt-auto">

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
                                                <div class="col-12 d-flex flex-column " style="height: 390px">
                                                    <p
                                                        class="m-0 premiumbadge  {{ $ads_plan->metadata->is_recomended == '1' ? '' : 'd-none' }}">
                                                        Recommended</p>
                                                    <p
                                                        class="twenty mt-5 d-flex justify-content-between align-items-center {{ $ads_plan->metadata->is_recomended == '1' ? 'textclas' : '' }}">
                                                        {{ $ads_plan->name }} @if ($loop->first)
        <img src="{{ asset('web/images/Group (2).svg') }}" style="height:80px;width:80px" class="img-fluid md-3" alt="...">
    @else
    <img src="{{ asset('web/images/other_icon.svg') }}" style="height:60px;width:10px" class="img-fluid mb-3" >
@endif</p>
                                                    <p class="headsured keep-color" style="font-size:26px !important">
                                                        @if ($ads_plan->price)
                                                            Rs {{number_format($ads_plan->price) }} <span
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
                                             </div>
    <div class="mt-auto">

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
                        <div class="col-12 p-3 " >
                            <p class="m-0 twentysix">Service Plans</p>
                            <div class="row">
                                @foreach ($plans['service_plans'] as $plan)
                                    <div class="col-md-3 col-12 p-3 {{ $plan->metadata->is_recomended == '1' ? 'topclas' : '' }}"
                                        id="card1-1">
                                        <div class="row">
                                           <div class="col-12 d-flex flex-column " style="height: 650px">
                                                <p
                                                    class="m-0 premiumbadge  {{ $plan->metadata->is_recomended == '1' ? '' : 'd-none' }}">
                                                    Recommended</p>
                                                <p
                                                    class="twenty mt-5 d-flex justify-content-between align-items-center {{ $plan->metadata->is_recomended == '1' ? 'textclas' : '' }}">
                                                    {{ $plan->name }} @if ($loop->first)
        <img src="{{ asset('web/images/Group (2).svg') }}" style="height:80px;width:80px" class="img-fluid md-3" alt="...">
    @else
    <img src="{{ asset('web/images/other_icon.svg') }}" style="height:60px;width:10px" class="img-fluid mb-3" >
@endif</p>
                                                <p class="headsured keep-color" style="font-size:26px !important">
                                                    @if ($plan->price)
                                                        Rs {{ number_format($plan->price) }} <span
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
                                             </div>
    <div class="mt-auto">

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
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="cancelplanmodalLabel">Cancel Plan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <p>Are you sure to cancel the plan?</p>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <a href="{{ url('cancel-plan') }}" type="button" class="btn btn-secondary">Yes</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- cancelplanmodal end --}}

        {{-- cancelplanmodal FOR SERVICES PLANS start --}}


        <div class="modal fade" id="servicecancelplanmodal" tabindex="-1" aria-labelledby="servicecancelplanmodalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="servicecancelplanmodalLabel">Cancel Plan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <p>Are you sure to cancel the plan?</p>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <a href="{{ url('cancel-service-plan') }}" type="button" class="btn btn-secondary">Yes</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- cancelplanmodal end --}}


        {{-- success modal start --}}


        <div class="modal fade" id="paymentresponse" tabindex="-1" aria-labelledby="paymentresponseLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentresponseLabel">Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <p>{{ session('paymentresponse') }}</p>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- success modal end --}}


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
                    } else {
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
