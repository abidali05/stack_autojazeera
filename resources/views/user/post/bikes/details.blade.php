{{-- @dd($features) --}}
@extends('layout.website_layout.bikes.bike_main')
@section('content')
    <style>
        body {
            font-family: 'Maven Pro', sans-serif !important;
        }

 #toast-container > .toast {
    color: white !important;
	 background-color:green;
}

        .ddd {
            background-color: #F0F3F6;
        }

  

           .carousel-control-prev,
    .carousel-control-next {
        width: 40px;
        /* Adjust size */
        height: 40px;
        background-color: #281F48 !important;
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
		.carousel-control-next-icon, .carousel-control-prev-icon {
    background-color: #281F48 !important;
    border-radius: 50%;
}
  .carousel-control-prev {
    left: -20px !important;
}
.carousel-control-next {
    right: -20px !important;
}
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 20px;
        }

        p {
            color: #281F48;
        }

        .img-adj-card {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #f45139;
            /* Red shade */
            border-radius: 34px;
            transition: 0.4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 15px;
            width: 15px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #f45139;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }

        h2 {
            color: #281F48;
        }

        a {
            text-decoration: none;
        }

        span {
            color: #281F48;
        }

        .feature-item {
            color: #281F48;
        }

        .info-item {
            color: #281F48;
        }

        .info-value {
            color: #281F48;
        }
    </style>
    <style>
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
            background-color: #281F48 !important;
            border: 0px !important;
            border-radius: 5px;
            padding: 10px 20px !important;
            color: white;
            line-height: 15px !important;
            font-size: 12px !important;
        }

        .modalbackcolor {
            background-color: #F0F3F6;
        }

        .maincolor {
            color: #281F48;
        }

        .form-select {
            max-width: 100%;
            color: #281F48;
        }

        .height {
            height: 400px !important;
        }
        
    .featureicn {
   
        background: #BF0000;
        color: white;
        font-size: 12px;
        font-weight: 500;
        border-radius: 5px;
        padding: 5px 10px;
        margin-left: 10px
    }
    </style>
    <div class="container  pt-4">
        <div class="breadcrumb-nav mb-3 " style="color: #281F48;">
            <a href="{{ url('/') }}" class="breadcrumb-item " style="color: #281F48;">Home</a>
            <span class="breadcrumb-separator" style="color: #281F48;">></span>
            <a href="{{ url('/bikes') }}" class="breadcrumb-item " style="color: #281F48;">Bikes</a>
            <span class="breadcrumb-separator" style="color: #281F48;">></span>
            <span class="breadcrumb-item active"><strong>{{ $post->makename . ' ' . $post->modelname }}</strong></span>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <h2><strong>{{ $post->makename . ' ' . $post->modelname . ' ' . $post->year }} </strong></h2>
            </div>
            <div class="col-lg-4 text-end">
                <div class="action-buttons">
                    (<strong> <i class="bi bi-eye"></i> {{ $post->views }} </strong>)
                    <i class="bi bi-share-fill me-3" style="color: #281F48;"></i>

                    @auth
                        @php
                            $check = \App\Models\Bike\BikeWishlist::where('user_id', auth()->id())
                                ->where('post_id', $post->id)
                                ->first();

                        @endphp
                        <a
                            @if (!Request::is('superadmin/*')) href="{{ route('bike_ads.add-to-wishlist', $post->id) }}" @else href="" @endif>
                            <i class="bi bi-heart-fill"
                                style="color: {{ $check && $check->status == '1' ? '#D90600;' : '#281F48;' }}"></i></a>
                    @endauth
                    @guest
                        <a href="{{ url('/login') }}"> <i class="bi bi-heart-fill" style="color: #281F48;"></i></a>
                    @endguest
                    {{-- <i class="bi bi-heart-fill" style="color: #FD5631;"></i> --}}

                </div>
            </div>
        </div>
    </div>

    <div class="container mb">
        <div class="row">
            <div class="col-lg-7">
                <div class="container mt-4 p-0">
                    <!-- Main Carousel -->
                    <div id="photoCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                        <div class="carousel-inner text-center">
                            @foreach ($post->media as $i => $media)
                                <div class="carousel-item height {{ $i == 0 ? 'active' : '' }}">
                                    <div style="width:97%; height:400px; overflow: hidden;">
                                        <img src="{{ $media->file_path }}"
                                            style="width: 100%; height: 100%; border-radius: 8px; object-fit: contain; cursor: pointer;"
                                            class="open-modal" data-bs-toggle="modal" data-bs-target="#photoModal"
                                            data-img="{{ $media->file_path }}" data-index="{{ $i }}"
                                            alt="Image {{ $i + 1 }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#photoCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#photoCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    </div>

                    <!-- Thumbnail Preview -->
                    <div class="row ps-md-3 justify-content-center">
                        @foreach ($post->media as $i => $media)
                            <div class="col-1 me-3 divimgl p-0" style="height:50px !important; width:50px !important; ">
                                <a href="#" class="open-modal" data-img="{{ $media->file_path }}"
                                    data-index="{{ $i }}">
                                    <img src="{{ $media->file_path }}" class="thumbnail-photo rounded imgstyl"
                                        style="height: 50px !important; width: 60px !important; cursor: pointer; border-radius: 8px; border:2px solid #281F48;"
                                        alt="Thumbnail {{ $i + 1 }}">
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-fullscreen">
                            <div class="modal-content" style="border-radius: 12px; background-color:#F0F3F6 !important;">
                                <div class="modal-body text-center p-4">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        style="position: absolute; top: 15px; right: 15px;"></button>

                                    <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner" id="carouselInner">
                                            <!-- Images are loaded dynamically with jQuery -->
                                        </div>

                                        <!-- Controls -->
                                        <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel"
                                            data-bs-slide="prev"
                                            style="width: 4%; left: 10px; top: 50%; transform: translateY(-50%); position: absolute;">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                            data-bs-target="#imageCarousel" data-bs-slide="next"
                                            style="width: 4%; right: 10px; top: 50%; transform: translateY(-50%); position: absolute;">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        </button>
                                    </div>

                                    <!-- Modal Thumbnails (Optional if needed) -->
                                    <div class="row ps-md-3 mt-3 justify-content-center">
                                        <div class="col-8">
                                            <div class="row justify-content-center">
                                                @foreach ($post->media as $index => $media)
                                                    <div class="col-1 me-1 divimgl p-0">
                                                        <a href="#" class="open-modal"
                                                            data-img="{{ $media->file_path }}"
                                                            data-index="{{ $index }}">
                                                            <img src="{{ $media->file_path }}"
                                                                class="thumbnail-photo rounded imgstyl"
                                                                style="height: 50px !important; width: 60px !important; cursor: pointer; border-radius: 8px; border:2px solid #281F48 !important;"
                                                                alt="Thumbnail {{ $index }}">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="d-flex flex-wrap gap-2 my-3">
                    <button type="button" class="btn custom-btn-nav rounded text-white" data-bs-toggle="modal"
                        data-bs-target="#staticBackdrop">
                        Book An Appointment
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                                <div class="modal-header " style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                                    <h2 class="modal-title"><strong>Book an Appointment</strong>  </h2>
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
                                    <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body "  style="background-color: #F0F3F6; color: #FD5631;">
                                  
                                    <form id="book_bike_appointment_form" method="post"
                                        action="{{ route('bike_ads.book_appointment') }}">
                                        @csrf
                                        <div class="row mb-3">
                                            <input type="hidden" name="type" value="Book an Appointment">
                                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                                            <div class="col-md-6 mb-3">
                                                <label for="fullName" class="form-label maincolor">Full Name*</label>
                                                <input type="text" name="name" class="form-control formcontrol"
                                                    id="fullName" required>
                                            </div>


                                            <div class="col-md-6 mb-3">
                                                <label for="email" class="form-label maincolor">Email*</label>
                                                <input type="email" name="email" class="form-control formcontrol"
                                                    id="email"required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="phoneNo" class="form-label maincolor">Phone Number</label>
                                                <input type="tel" name="number" class="form-control formcontrol"
                                                    id="phoneNo" maxlength="14" value="+92" onfocus="ensureSpace()"
                                                    oninput="formatPhone(this)" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="dateofbirth" class="form-label maincolor">Date</label>
                                                <input type="date" name="date" class="form-control formcontrol"
                                                    id="dateofbirth">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="time" class="form-label maincolor">Time</label>
                                                <input type="time" name="time" class="form-control formcontrol"
                                                    id="time"required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="method" class="form-label maincolor">Preferred Contact
                                                    Method</label>
                                                <select class="form-select filter-style" name="method" id="method"
                                                    required>
                                                    <option value="" selected>Preferred Contact Method</option>
                                                    <option value="number">Phone Number</option>
                                                    <option value="email">Email</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="message" class="form-label maincolor">Message</label>
                                            <textarea class="form-control formcontrol" id="message" name="message" rows="4" maxlength="1000" required></textarea>
                                        </div>

                                        <div class="text-end"> <button type="submit"
                                                class="btn custom-btn-nav rounded px-5" style="color:white">Send
                                                Message</button></div>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="container my-4">
                    <h3 style="color: #281F48;"><strong>Specifications</strong></h3>

                    <!-- Row 1 -->
                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Make</strong></span>
                            <span>{{ $post->makename }}</span>
                        </div>
                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Condition</strong></span>
                            <span>{{ $post->condition }}</span>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Model</strong></span>
                            <span>{{ $post->modelname }}</span>
                        </div>



                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Year</strong></span>
                            <span>{{ $post->year }}</span>
                        </div>

                    </div>


                    <!-- Row 3 -->
                    <div class="row">

                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Fuel Tank Capacity</strong></span>
                            <span>{{ $post->fuel_capacity }} L</span>
                        </div>

                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Transmission</strong></span>
                            <span>{{ $post->transmission }}</span>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong> Body Type</strong></span>
                            <span>{{ $post->bodytypename }}</span>
                        </div>


                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Exterior Colour</strong></span>
                            <span>{{ $post->colorname }}</span>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Fuel Type </strong></span>
                            <span>{{ $post->fuel_type }}</span>
                        </div>
                    </div>


                    <!-- Features Section -->
                    <div class="mt-4">
                        <h3 style="color: #281F48;"><strong>Features</strong></h3>
                        <div class="row mt-3 p-3 rounded" style="background-color:#F0F3F6; border:1px solid #281F48">
                            @foreach ($features as $category => $featureGroup)
                                @foreach ($featureGroup as $feature)
                                    @if (in_array($feature->id, $bike_features))
                                        <div class="col-md-4 feature-item mb-3 d-flex align-items-center">
                                            <img src="{{ $feature->icon }}" alt="{{ $feature->name }}"
                                                style="width: 15px; margin-right: 10px;">
                                            <span>{{ $feature->name }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                    </div>

                    <!-- Seller's Description Section -->
                    <div class="description mt-4">
                        <h3 style="color: #281F48;"><strong>Seller's Description</strong></h3>
                        <p style="color: #281F48;">{{ $post->description }}</p>
                        <div class="mt-3">
                            <a href="{{ $post->document_brouchure }}" target="_blank" class=" custom-btn-nav ">Download
                                Brochure</a>
                            <a href="{{ $post->document_auction }}" target="_blank" class=" custom-btn-nav ">Download
                                Auction Sheet</a>
                        </div>
                    </div>
                    <!-- Information Section -->
                    <div class="info-section mt-4">
                        <div class="row text-start border-top border-bottom">
                            <div class="col-md-3">
                                <div class="info-item">Published:</div>
                                <div class="info-value">{{ \Carbon\Carbon::parse($post->created_at)->format('F j, Y') }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-item">Last Updated:</div>
                                <div class="info-value">{{ \Carbon\Carbon::parse($post->updated_at)->format('F j, Y') }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-item">Ad Id:</div>
                                <div class="info-value">{{ $post->id }}</div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-item">Member Since:</div>
                                <div class="info-value">
                                    {{ \Carbon\Carbon::parse($post->dealer->created_at)->format('F j, Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="col-lg-5">
                <div class="row align-items-center mb-4">
                    <!-- Left Side Buttons -->
                    <div class="col-8 d-flex align-items-center">
                        <button class="btn custom-btn-3 text-capitalize"
                            style="background-color: {{ $post->condition == 'used' ? '#0EB617 !important;' : '#4581F9 !important;' }}#4581F9 !important; color:white;">{{ $post->condition }}</button>
                                @if ($post->is_featured == 1)
                                                        <span class="featureicn">
                                                            <img src="{{ asset('web/bikes/images/Star 7.svg') }}"
                                                                class="img-fluid">
                                                            Featured</span>
                                                    @endif
                    </div>
                    @php
                        $price_alert = App\Models\Bike\BikePriceAlert::where([
                            'post_id' => $post->id,
                            'user_id' => Auth::id(),
                            'status' => 1,
                        ])->first();

                    @endphp

                    <!-- Right Side Toggle Switch -->
                    <div class="col-4 text-end align-items-center" style="background-color:#281F48 ; border-radius:5px">
                        <div class="toggle-container d-flex align-items-center justify-content-center">
                            <span class="me-2 text-white">Price Alert</span>
                            <a href="{{ route('bike_ads.add-price-alert', $post->id) }}" class="action-btn-2">
                                <i
                                    class="bi {{ $price_alert && $price_alert->status == 1 ? 'bi-toggle2-on fs-4 text-danger' : 'bi-toggle2-off fs-4 text-light' }} "></i>
                            </a>

                        </div>
                    </div>
                </div>
                <div class="row align-items-center mb-3">
                    <!-- First Column -->
                    <div class="col-md-7">
                        <h4 class="mb-1"><span style="color: #F40000;"><strong>PKR
                                    {{ number_format($post->price) }}</strong></span>
                            @if ($post->price < $post->previous_price)
                                <small> <span
                                        style="text-decoration: line-through; color:red; font-size:smaller;">{{ number_format($post->previous_price) }}</span>
                                </small>
                            @endif

                        </h4>
                        <div class="row">
                            <div class="col-auto">
                                <p>{{ number_format($post->mileage >= 1000 ? $post->mileage / 1000 : $post->mileage, $post->mileage >= 1000 ? 1 : 0) }}{{ $post->mileage >= 1000 ? 'K' : '' }}
                                    miles</p>

                            </div>
                            <div class="col-auto">
                                <p>{{ $post->location->cityname }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Second Column -->
                    <div class="col-md-5 text-end">
                        <p><strong>Posted on:</strong> <span
                                style="font-size:12px">{{ \Carbon\Carbon::parse($post->created_at)->format('F j, Y') }}</span>
                        </p>
                    </div>
                </div>
                <div class="rounded-4"style="background-color: #F0F3F6;border:none ; color:white">
                    <div class="p-3 ">
                        <div class="row d-flex justify-content-between align-items-center">
                            <!-- Dummy Circular Image -->
                            <div class="col-3 pe-0">
                                <img src="{{ asset('web/profile') . '/' . $post->dealer->image }}" alt="Dealer Image"
                                    class="rounded-circle " style="width: 80px; height: 80px;">
                            </div>
                            <!-- Dealer Name and Designation -->
                            <div class="col-4 p-0">
                                <h5 class="card-title" style="color: #281F48;">{{ $post->dealer->name }}</h5>
                                <p class="card-text">
                                    {{ $post->dealer->userType == 'car_dealer' ? 'Car Dealer' : 'Private Seller' }}</p>
                            </div>
                            <div class="col-5">
                                <a style="color:#281F48; font-size:14px; text-decoration: underline; text-decoration-color: #281F48;"
                                    href="{{ route('dealer.bikeposts.all', $post->dealer->id) }}" class="ads">
                                    Other Ads by this dealer
                                </a>


                            </div>
                        </div>
                        <div>
                            <p class="{{ $post->dealer->number ? '' : 'd-none' }}"><i class="bi bi-telephone me-2"></i>
                                {{ $post->dealer->number }}</p>
                            <p><i class="bi bi-envelope me-2"></i> <a style="color: #281F48;"
                                    href="mailto:{{ $post->dealer->email }}">{{ $post->dealer->email }}</a></p>
                            <p><i class="bi bi-geo-alt me-2"></i>
                                {{ $post->dealer->address . ', ' . $post->dealer->city }}</p>
                            <p><i class="bi bi-calendar me-2"></i> Member Since
                                {{ \Carbon\Carbon::parse($post->dealer->created_at)->format('F j, Y') }}</p>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <!-- Call Button -->
                                <a href="tel:{{ $post->dealer->number }}"
                                    class="btn custom-btn-nav me-1 py-2 {{ $post->dealer->number ? '' : 'd-none' }}">
                                    <i class="bi bi-telephone me-1"></i> Call
                                </a>
                                <!-- WhatsApp Button -->
                                <a href="https://wa.me/{{ $post->dealer->number }}"
                                    class="btn custom-btn-nav me-1 py-2 {{ $post->dealer->number ? '' : 'd-none' }}"
                                    target="_blank">
                                    <i class="bi bi-whatsapp me-1"></i> WhatsApp
                                </a>
                                <!-- Share Button -->
                                <button class="btn custom-btn-nav me-1 py-2"
                                    onclick="shareLink()">
                                    <i class="bi bi-share me-1"></i> Share
                                </button>
                                <!-- SMS Button -->
                                @auth
								<button onclick="createOrOpenChat({{ $post->id }}, {{ $post->dealer_id }})"
                                    class="btn custom-btn-nav py-2 {{ $post->dealer->number ? '' : 'd-none' }}">
                                    <i class="bi bi-chat-dots me-1"></i> Chat
                                </button>
								@endauth
								
								@guest
								<a href="{{url('login')}}" 
                                    class="btn custom-btn-nav py-2 {{ $post->dealer->number ? '' : 'd-none' }}">
                                    <i class="bi bi-chat-dots me-1"></i> Chat
                                </a>
								
								@endguest
                            </div>

                        </div>
                    </div>

                </div>
                <div class="col-12 mt-3">
                    <h5 class="mb-4 primary-color-custom" style="color:#281F48 !important">Request More
                        Information</h5>
                    <div class="p-3" style="border: 1px solid #454056; border-radius: 10px;">
                        <form id="bike_request_more_info_form" method="post"
                            action="{{ route('bike_ads.request_more_info') }}">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div class="row mb-3">
                                <div class="col-md-12 mb-3">
                                    <input type="hidden" name="type" value="Request more Information">
                                    <label for="firstName" class="form-label"
                                        style="color:#281F48 !important"><strong>Full
                                            Name*</strong></label>
                                    <input type="text" name="name" class="form-control formcontrol" id="fullName"
                                        required>
                                </div>



                                <div class="col-md-12 mb-3">
                                    <label for="email" class="form-label"
                                        style="color:#281F48 !important"><strong>Email*</strong></label>
                                    <input type="email" name="email" class="form-control formcontrol" id="email"
                                        required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="phoneNo" class="form-label"
                                        style="color:#281F48 !important"><strong>Phone
                                            Number</strong></label>
                                    <input type="text" id="phoneNum" name="number" class="form-control formcontrol"
                                        placeholder="+92 3XX XXXXXXXX" maxlength="15" required>


                                </div>


                            </div>
                            <div class="mb-3">
                                <label for="phoneNfv" class="form-label"
                                    style="color:#281F48 !important"><strong>Message</strong></label>
                                <textarea class="form-control formcontrol" style="    line-height: 1.2 !important;" id="message" name="message" rows="4" placeholder=""
                                    maxlength="1000" required></textarea>
                            </div>
                            <button type="submit" class="btn custom-btn-nav rounded px-5">Send
                                Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <h3 class="mb-5 mt-3">Similar Ads</h3>
            <div class="container mt-2">
                <div id="adsCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($posts->chunk(3) as $chunkIndex => $chunk)
                            <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                                <div class="row">
                                    @foreach ($chunk as $p)
                                        <div class="col-lg-4">
                                            <div class="wishlist-card ddd " style="border-radius:20px !important">
                                                <a style="  text-decoration: none;color: inherit;"
                                                    @if (Request::is('superadmin/*')) href="{{ route('superadmin.bikedetail', $p->id) }}" 
                                            @else 
                                                href="{{ route('bikedetail', $p->id) }}" @endif>
                                                    <div class="img-bg-home">


                                                        <img src="{{ $p->media[0]->file_path }}" class="img-adj-card"
                                                            style="height: 250px; border-radius:20px 20px 0px 0px">

                                                    </div>
                                                    <div class="p-3">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6>{{ $p->year }}</h6>
                                                            <span class="rounded px-3 py-1 text-capitalize"
                                                                style="background-color:{{ $p->condition == 'new' ? '#4581F9 ;' : '#2AB500;' }}; font-size:12px;">
                                                                {{ $p->condition }}
                                                            </span>
                                                        </div>
                                                        <h4>{{ $p->modelname }}</h4>
                                                        <h5 style="color: #FD5631;"><b>PKR
                                                                {{ number_format($p->price) }}</b></h5>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="mb-0">
                                                                <i class="bi bi-geo-alt"></i>
                                                                {{ $p->location->cityname ?? '' }}
                                                            </h6>
                                                            <span style="font-size:14px;">Last Updated:
                                                                {{ \Carbon\Carbon::parse($p->dealer->updated_at)->format('F j, Y') }}
                                                            </span>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <div class="text-center py-2"
                                                                    style="background-color:#002D690F; border-radius: 10px;">
                                                                    <i class="bi bi-speedometer2"></i>
                                                                    @php
                                                                        $mileage = (float) $p->mileage;
                                                                        if ($mileage >= 1000000) {
                                                                            // For values in millions, display 'M'
                                                                            $formattedMileage =
                                                                                rtrim(
                                                                                    number_format(
                                                                                        $mileage / 1000000,
                                                                                        1,
                                                                                    ),
                                                                                    '.0',
                                                                                ) . 'M';
                                                                        } elseif ($mileage >= 1000) {
                                                                            // For values in thousands, display 'K'
                                                                            $formattedMileage =
                                                                                rtrim(
                                                                                    number_format($mileage / 1000, 1),
                                                                                    '.0',
                                                                                ) . 'K';
                                                                        } else {
                                                                            // For values less than 1000, display the raw number
                                                                            $formattedMileage = $mileage;
                                                                        }
                                                                    @endphp
                                                                    <h6>{{ $formattedMileage }}</h6>
                                                                </div>
                                                            </div>

                                                            <div class="col-4">
                                                                <div class="text-center py-2"
                                                                    style="background-color:#002D690F; border-radius: 10px;">
                                                                    <i class="fa fa-motorcycle fs-5" aria-hidden="true"
                                                                        style="color: #281F48;"></i>
                                                                    <h6>{{ $p->transmission }}</h6>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="text-center py-2"
                                                                    style="background-color:#002D690F; border-radius: 10px;">
                                                                    <i class="bi bi-fuel-pump-diesel"></i>
                                                                    <h6>{{ $p->fuel_type }}</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Carousel Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#adsCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#adsCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

        </div>


        {{-- wishlist response start --}}
        @if (session('wishlistresponse'))
            <div class="modal fade" id="wishlistresponse" tabindex="-1" aria-labelledby="wishlistresponseLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                        <div class="modal-header"  style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                            <h5 class="modal-title" id="wishlistresponseLabel"><strong> Wishlist </strong></h5>
                            <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center "  style="background-color: #F0F3F6; color: #FD5631;"  id="wishlistresponseBody">
                            <p style="color:#281F48"> {{ session('wishlistresponse') }}</p>
                        </div>
                        <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                            <button type="button"
                               class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;"
                                data-bs-dismiss="modal" onclick="location.reload();">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        @if (session('wishlistresponse'))
            <script>
                window.addEventListener('DOMContentLoaded', () => {
                    let modal = new bootstrap.Modal(document.getElementById('wishlistresponse'));
                    modal.show();
                });
            </script>
        @endif
        {{-- wishlist response end --}}


        {{-- request_more_info_response start --}}
        @if (session('request_more_info_response'))
            <div class="modal fade" id="request_more_info_response" tabindex="-1"
                aria-labelledby="request_more_info_responseLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                        <div class="modal-header" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                            <h5 class="modal-title" id="request_more_info_responseLabel"> <strong> Request More Information Response</strong>
                            </h5>
                            <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center " id="request_more_info_responseBody"  style="background-color: #F0F3F6; color: #FD5631;">
                            <p style="color: #281F48"> {{ session('request_more_info_response') }}</p>
                        </div>
                        <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                            <button type="button"
                                class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;"
                                data-bs-dismiss="modal" onclick="location.reload();">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        @if (session('request_more_info_response'))
            <script>
                window.addEventListener('DOMContentLoaded', () => {
                    let modal = new bootstrap.Modal(document.getElementById('request_more_info_response'));
                    modal.show();
                });
            </script>
        @endif
        {{-- request_more_info_response end --}}


        {{-- book_appointment_response start --}}
        @if (session('book_appointment_response'))
            <div class="modal fade" id="book_appointment_response" tabindex="-1"
                aria-labelledby="book_appointment_responseLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                        <div class="modal-header" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                            <h5 class="modal-title" id="book_appointment_responseLabel"><strong> Request More Information Response</strong>
                            </h5>
                            <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center " id="book_appointment_responseBody" style="background-color: #F0F3F6; color: #FD5631;">
                            <p style="color: #281F48"> {{ session('book_appointment_response') }}</p>
                        </div>
                        <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                            <button type="button"
                                class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;"
                                data-bs-dismiss="modal" onclick="location.reload();">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if (session('book_appointment_response'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                let modal = new bootstrap.Modal(document.getElementById('book_appointment_response'));
                modal.show();
            });
        </script>
    @endif
    {{-- book_appointment_response end --}}







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#phoneNum").val("+92 ").on("input", function() {
                let phoneValue = $(this).val().replace(/[^0-9]/g, '').replace(/^92/, '');

                let formatted = '+92 ' + phoneValue.substring(0, 3);
                if (phoneValue.length > 3) {
                    formatted += ' ' + phoneValue.substring(3, 10);
                }

                $(this).val(formatted.substring(0, 15));
            }).on("keydown", function(e) {
                if ($(this).val().length <= 4 && e.key === "Backspace") {
                    e.preventDefault(); // Prevent deleting "+92 "
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            let images = []; // Image paths
            let currentIndex = 0;
            const $carouselInner = $("#carouselInner");
            const $thumbnails = $(".thumbnail-photo");
            const $photoModal = $("#photoModal");
            const modalInstance = new bootstrap.Modal($photoModal[0]);

            // Load all image sources once
            $(".open-modal").each(function() {
                const img = $(this).data("img");
                if (!images.includes(img)) {
                    images.push(img);
                }
            });

            // Click handler
            $(".open-modal").on("click", function(e) {
                e.preventDefault();
                currentIndex = parseInt($(this).data("index"));
                loadCarouselImages();
                modalInstance.show();
            });

            // Load and render carousel slides dynamically
            function loadCarouselImages() {
                $carouselInner.empty();
                $.each(images, function(index, image) {
                    const activeClass = index === currentIndex ? "active" : "";
                    $carouselInner.append(`
                <div class="carousel-item ${activeClass}">
                    <img src="${image}" class="d-block w-100" style="height: 500px; object-fit: contain; border-radius: 10px;">
                </div>
            `);
                });
                highlightActiveThumbnail();
            }

            // Highlight active thumbnail
            function highlightActiveThumbnail() {
                $thumbnails.each(function(i) {
                    if (i === currentIndex) {
                        $(this).css("border", "2px solid #FD5631");
                    } else {
                        $(this).css("border", "2px solid #281F48");
                    }
                });
            }

            // Update current index on carousel slide change
            $("#imageCarousel").on('slid.bs.carousel', function(event) {
                currentIndex = event.to;
                highlightActiveThumbnail();
            });

            // Clear images when modal closes
            $photoModal.on("hidden.bs.modal", function() {
                $carouselInner.empty();
            });
        });
    </script>


    <script>
        async function createOrOpenChat(carId, dealerId) {
            try {
                toastr.success('Please wait...');
                const response = await fetch('/create-chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        car_id: carId,
                        dealer_id: dealerId,
                        vehicle_type: 'bike'
                    })
                });

                const result = await response.json();
                if (result.success) {
                    window.location.href = `/chats`;
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
