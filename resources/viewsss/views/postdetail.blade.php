@extends('layout.website_layout.main')

@section('content')
    @if (session('price_alert'))
        <style>
            .modal-image {
                opacity: 0;
                transition: opacity 0.5s ease-in-out;
            }

            .modal-image.show {
                opacity: 1;
            }

            body {
                background-color: white !important;
            }

            .carousel-item {
                transition: transform 0.5s ease;
                /* Smooth transition for slides */
            }

            .carousel-inner {
                height: 400px;


            }

            .custom-btn-3 {
                background-color: #FD5631 !important;
                border: 0px;
                color: white;
                line-height: 12px !important;
                font-size: 14px !important;
            }

            .carousel-inner img {
                height: 400px;
                object-fit: contain;

            }

            .custom-btn-3 {
                background-color: #281F48 !important;
                border: 0px;
                color: white;
                line-height: 20px;
                font-size: 14px !important;
            }
            
        </style>

        <div class="modal fade" id="pricealertmodal" tabindex="-1" aria-labelledby="pricealertmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                    <!-- Modal Header -->
                    <div class="modal-header" style="background-color: #FD5631; color: white; border-bottom: none;">
                        <h5 class="modal-title" id="pricealertmodalLabel">Success</h5>
                        <button type="button" class="btn-close" style="background-color: white; color: #FD5631;"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body text-center p-4">
                        <i class="bi bi-patch-check-fill fs-1"></i>

                        <h6 class="" style="line-height: 1.6;">
                            {{ session('price_alert') }}
                            <br><br>

                        </h6>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer justify-content-center border-0">
                        <a href="#" class="btn btn-light px-4 py-2 "
                            style="background-color: white; font-weight:600; color: #FD5631; border-radius: 5px;"
                            data-bs-dismiss="modal">close</a>

                    </div>
                </div>
            </div>
        </div>

        <script>
            // Show the modal when the page loads
            document.addEventListener('DOMContentLoaded', function() {
                const myModal = new bootstrap.Modal(document.getElementById('pricealertmodal'));
                myModal.show();
            });
        </script>
    @endif
    <style>
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
   .carousel-control-prev {
    left: -20px !important;
}
.carousel-control-next {
    right: -20px !important;
}
        .carousel-control-next-icon,
        .carousel-control-prev-icon {
            background-color: #281F48 !important;
            border-radius: 5px;
        }

        .height {
            height: 400px !important;
        }

        .carousel-control-next-icon,
        .carousel-control-prev-icon {
            background-color: #281F48 !important;
            border-radius: 50%;
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
    <div class="container mt-4 ">
        <div class="breadcrumb-nav mb-3">
            <a href="{{ url('/') }}" class="breadcrumb-item " style="color:#9691A4 !important">Home</a>
            <span class="breadcrumb-separator" style="color:#9691A4 !important">></span>
            <a href="{{ $post->condition == 'new' ? url('cars/new') : url('cars/used') }}" class="breadcrumb-item "
                style="color:#9691A4 !important">{{ $post->condition == 'new' ? 'New Car' : 'Used Car' }}</a>
            <span class="breadcrumb-separator" style="color:#281F48 !important">></span>
            <span class="breadcrumb-item active"
                style="color:#281F48 !important"><strong>{{ $post->modelname }}</strong></span>
        </div>
        <div class="row d-flex justify-content-between">
            <div class="col-lg-8 ">

                <h2 class="m-0" style="color:#281F48 !important"><strong>{{ $post->modelname }} {{ $post->year ?? '' }}
                    </strong></h2>
            </div>
            <div class="col-lg-2 text-end d-flex justify-content-end align-items-center">
                {{--  <div class="action-buttons">
                    <button class="action-btn-2 border-0" style="background-color: #ffffff00;" onclick="shareContent()">
                        <i class="bi bi-share-fill text-white"></i>
                    </button>


                </div> --}}
                <div class="newstyl">
                    <strong> <i class="bi bi-eye"></i> {{ $post->views }} </strong>

                    <button class="action-btn-2 border-0 sharebtn" style="background-color: #ffffff00;"
                        data-url="{{ route('cardetail', ['id' => $post->id]) }}">
                        <i class="bi bi-share-fill " style="color:#281F48"></i>
                    </button>
                    <?php
                    
                    use Illuminate\Support\Facades\Auth;
                    
                    if (isset($post->whishlist) && isset(Auth::user()->id)) {
                        $wishlist = \App\Models\Whishlist::where('user_id', Auth::user()->id)
                            ->where('post_id', $post->id)
                            ->where('status', 1)
                            ->first();
                    }
                    
                    ?>
                    @auth
                        <a @if (!Request::is('superadmin/*')) href="{{ route('add-to-wishlist', ['post_id' => $post->id, 'dealer_id' => Auth::id()]) }}"  @else href="" @endif
                            class="action-btn-2 ">
                            <i
                                @if (isset($wishlist)) class="bi bi-heart-fill  text-danger" style="" @else class="bi bi-heart-fill  " style="color:#281F48" @endif></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="action-btn-2 ms-3">
                            <i class="bi bi-heart-fill "style="color:#281F48"></i>
                        </a>
                    @endauth

                </div>
            </div>
        </div>
    </div>
    <div class="container mb-4">
        <div class="row">
            <?php
            $main = $post->document->first();
            use App\Models\Document;
            $mainimages = Document::where('post_id', $post->id)->where('doc_type', 'image')->get();
            ?>
            <div class="col-lg-7 p-0 ">
                {{--  
                <img src="{{ url('posts/doc/' . $main->doc_name) }}" alt="" srcset="" height="100%"
                    width="100%" class="img-fluid rounded">
                    --}}
                <div class="container mt-4 p-0">
                    <!-- Main Display with Slider -->
                    <div id="photoCarousel" class="carousel slide  mb-4" data-bs-ride="carousel"
                        style="position: relative; margin-bottom: 16px;">
                        <div class="carousel-inner" style="text-align: center;">
                            @foreach ($mainimages as $index => $mainimage)
                                <div class="carousel-item height {{ $index == 0 ? 'active' : '' }}">
                                    <div style="width:97%; height:400px; overflow: hidden;">
                                        <img src="{{ url('posts/doc/' . $mainimage->doc_name) }}"
                                            style="width: 100%; height: 100%; border-radius: 8px; object-fit: contain;"
                                            class="open-modal" data-img="{{ url('posts/doc/' . $mainimage->doc_name) }}"
                                            alt="Image {{ $index }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#photoCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#photoCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                    <!-- Thumbnails -->
                    <div class="row ps-md-3 justify-content-center">
                        @foreach ($mainimages as $index => $mainimage)
                            <div class="col-1 me-3 divimgl p-0" style="height:50px !important; width:50px !important;">
                                <a href="#" class="open-modal" data-bs-toggle="modal" data-bs-target="#photoModal"
                                    data-img="{{ url('posts/doc/' . $mainimage->doc_name) }}"
                                    data-index="{{ $index }}">
                                    <img src="{{ url('posts/doc/' . $mainimage->doc_name) }}"
                                        style="height: 50px !important; width: 60px !important; cursor: pointer; border-radius: 8px; transition: opacity 0.3s ease; border:2px solid #281F48"
                                        class="rounded thumbnail-photo imgstyl" alt="Thumbnail {{ $index }}">
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Single Modal sdfdsfdsf -->
                    <div class="modal fade" id="photoModal" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">

                        <div class="modal-dialog modal-dialog-centered modal-fullscreen">
                            <div class="modal-content"
                                style="border-radius: 12px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);">
                                <div class="modal-body text-center p-4"
                                    style="border-radius: 12px; background: #1F1B2D; position: relative;">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        style="position: absolute; top: 15px; right: 15px; z-index:1"></button>

                                    <!-- Carousel Container -->
                                    <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner" id="carouselInner"></div>

                                        <!-- Carousel Controls -->
                                        <button class="carousel-control-prev" type="button"
                                            data-bs-target="#imageCarousel" data-bs-slide="prev"
                                            style="width: 4%; border-radius: 50%; position: absolute; left: 10px; top: 50%; transform: translateY(-50%);">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        </button>

                                        <button class="carousel-control-next" type="button"
                                            data-bs-target="#imageCarousel" data-bs-slide="next"
                                            style="width: 4%; border-radius: 50%; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        </button>
                                    </div>

                                    <!-- Thumbnail Row -->
                                    <div class="row ps-md-3 mt-3 justify-content-center">

                                        @foreach ($mainimages as $index => $mainimage)
                                            <div class="col-1 me-3 divimgl p-0"
                                                style="height:50px !important; width:50px !important;">
                                                <a href="#" class="open-modal"
                                                    data-img="{{ url('posts/doc/' . $mainimage->doc_name) }}"
                                                    data-index="{{ $index }}">
                                                    <img src="{{ url('posts/doc/' . $mainimage->doc_name) }}"
                                                        style="height: 50px !important; width: 60px !important; cursor: pointer; border-radius: 8px; 										transition: opacity 0.3s ease; border:2px solid white"
                                                        class="rounded thumbnail-photo imgstyl"
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

                <div class="d-flex flex-wrap gap-2 my-3">
                    @if (Auth::check())
                        <button class="btn custom-btn-3 rounded" data-bs-toggle="modal" data-bs-target="#appoinment">
                            Book An Appointment
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="btn custom-btn-3 rounded">
                            Book An Appointment
                        </a>
                    @endif

                    @if ($post->dealer->offer_test_drive == 'Yes')
                        <button class="btn custom-btn-3 rounded d-none"
                            @if (isset(Auth::user()->id)) data-bs-toggle="modal" data-bs-target="#testdrive" @endif>Schedule
                            Test Drive</button>
                    @endif
                    <button class="btn custom-btn-3 rounded d-none"
                        @if (isset(Auth::user()->id)) data-bs-toggle="modal" data-bs-target="#inquiry" @endif>General
                        Inquiry</button>
                    <button class="btn custom-btn-3 rounded d-none"
                        @if (isset(Auth::user()->id)) data-bs-toggle="modal" data-bs-target="#emailFriend" @endif>Email
                        A Friend</button>
                </div>
                <div class="container my-5">
                    <h3 style="color: #281F48; font-weight:500"><strong>Specifications</strong></h3>

                    <!-- Row 1 -->
                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-between">
                            <span style="color: #281F48;"><strong>Manufacturing Year</strong></span>
                            <span style="color:#9691A4">{{ $post->year }}</span>
                        </div>
                        <div class="col-md-6 d-flex justify-content-between">
                            <span style="color: #281F48;"><strong>Registered?</strong></span>
                            <span style="color:#9691A4">Yes</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-between">
                            <span style="color: #281F48;"><strong>Make</strong></span>
                            <span style="color:#9691A4">{{ $post->makename }}</span>
                        </div>
                        <div class="col-md-6 d-flex justify-content-between">
                            <span style="color: #281F48;"><strong>Model</strong></span>
                            <span style="color:#9691A4">{{ $post->modelname }}</span>
                        </div>
                    </div>

                    <!-- Row 2 -->
                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-between">
                            <span style="color: #281F48;"><strong>Transmission</strong></span>
                            <span style="color:#9691A4">{{ $post->transmission }}</span>
                        </div>
                        <div class="col-md-6 d-flex justify-content-between">
                            <span style="color: #281F48;"><strong>Assembly</strong></span>
                            <span style="color:#9691A4" class="text-capitalize">{{ $post->assembly }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-between">
                            <span style="color: #281F48;"> <strong>Door Count</strong></span>
                            <span style="color:#9691A4">{{ $post->doors }}</span>
                        </div>
                        <div class="col-md-6 d-flex justify-content-between">
                            <span style="color: #281F48;"><strong>Fuel Type</strong></span>
                            <span style="color:#9691A4">{{ $post->fuel }}</span>
                        </div>
                    </div>

                    <!-- Row 3 -->
                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-between">
                            <span style="color: #281F48;"><strong>Engine Capacity</strong></span>
                            <span style="color:#9691A4">{{ $post->engine_capacity }}</span>
                        </div>
                        <div class="col-md-6 d-flex justify-content-between">
                            <span style="color: #281F48;"><strong>Mileage</strong></span>
                            <span style="color:#9691A4">
                                @php
                                    $mileage = (float) $post->milleage;
                                    if ($mileage >= 1000000) {
                                        // For values in millions, display 'M'
                                        $formattedMileage = rtrim(number_format($mileage / 1000000, 1), '.0') . 'M';
                                    } elseif ($mileage >= 1000) {
                                        // For values in thousands, display 'K'
                                        $formattedMileage = rtrim(number_format($mileage / 1000, 1), '.0') . 'K';
                                    } else {
                                        // For values less than 1000, display the raw number
                                        $formattedMileage = $mileage;
                                    }
                                @endphp
                                {{ $formattedMileage }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-between">
                            <span style="color: #281F48;"><strong>Body Type</strong></span>
                            <span style="color:#9691A4">{{ $post->bodytypename }}</span>
                        </div>
                        <div class="col-md-6 d-flex justify-content-between">
                            <span style="color: #281F48;"><strong>Exterior Color</strong></span>
                            <span style="color:#9691A4">{{ $post->excolorname }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-between">
                            <span style="color: #281F48;"><strong>Seating Capacity</strong></span>
                            <span style="color:#9691A4">{{ $post->seating_capacity }}</span>
                        </div>
                    </div>

                    <!-- Features Section -->
                    <div class="features mt-4 col-12">
                        <h3 style="color: #281F48; font-weight:500"><strong>Features</strong></h3>
                        <div class="row mt-3 rounded p-3" style="border: 1px solid #454056; background-color:#F0F3F6">

                            @foreach ($post->feature as $feature)
                                <div class="col-md-4 feature-item my-2">
                                    <!-- <i class="bi bi-fan"></i>  -->

                                    <img src="{{ asset('posts/features/' . $feature->mainfeature->icon) }}"
                                        height="30px" width="30px">
                                    {{ $feature->feature_name }}
                                </div>
                            @endforeach
                            <!-- <div class="col-md-4 feature-item">
                                                                <i class="bi bi-shield-shaded"></i> Air Bags
                                                            </div> -->
                            <!-- <div class="col-md-4 feature-item">
                                                                <i class="bi bi-radio"></i> AM / FM Radio
                                                            </div>
                                                            <div class="col-md-4 feature-item">
                                                                <i class="bi bi-cassette-fill"></i> Cassette Player
                                                            </div>
                                                            <div class="col-md-4 feature-item">
                                                                <i class="bi bi-thermometer-half"></i> Cool Box
                                                            </div>
                                                            <div class="col-md-4 feature-item">
                                                                <i class="bi bi-speedometer2"></i> Cruise Control
                                                            </div>
                                                            <div class="col-md-4 feature-item">
                                                                <i class="bi bi-disc"></i> DVD Player
                                                            </div>
                                                            <div class="col-md-4 feature-item">
                                                                <i class="bi bi-speaker"></i> Front Speaker
                                                            </div> -->
                            <!-- <div class="col-md-4 feature-item">
                                                                <i class="bi bi-camera-video"></i> Front Camera
                                                            </div>
                                                            <div class="col-md-4 feature-item">
                                                                <i class="bi bi-key"></i> Keyless Entry
                                                            </div>
                                                            <div class="col-md-4 feature-item">
                                                                <i class="bi bi-shield"></i> Immobilizer Key
                                                            </div>
                                                            <div class="col-md-4 feature-item">
                                                                <i class="bi bi-map"></i> Navigation System
                                                            </div>
                                                            <div class="col-md-4 feature-item">
                                                                <i class="bi bi-mirror"></i> Power Mirror
                                                            </div>
                                                            <div class="col-md-4 feature-item">
                                                                <i class="bi bi-steering-wheel"></i> Power Steering
                                                            </div>
                                                            <div class="col-md-4 feature-item">
                                                                <i class="bi bi-lock"></i> Power Lock
                                                            </div>
                                                            <div class="col-md-4 feature-item">
                                                                <i class="bi bi-thermometer-sun"></i> Heated Seats
                                                            </div>
                                                            <div class="col-md-4 feature-item">
                                                                <i class="bi bi-cloud"></i> Climate Control
                                                            </div>
                                                            <div class="col-md-4 feature-item">
                                                                <i class="bi bi-rim"></i> Alloy Rim
                                                            </div> -->
                        </div>
                    </div>
                    <!-- Seller's Description Section -->
                    <div class="description mt-4">
                        <h3 style="color: #281F48; font-weight:500"><strong>Seller's Description</strong></h3>
                        <p style="color: #281F48; word-wrap: break-word; overflow-wrap: break-word; hyphens: auto;">
                            {{ $post->dealer_comment }}.
                        </p>

                        <div class="mt-3 d-flex justify-content-center">
                            @if ($post->document_brochure)
                                <a class="btn custom-btn-3 p-2 me-3"
                                    href="{{ asset('posts/brocuhre/' . $post->document_brochure) }}" target="_blank"
                                    frameborder="0">Download
                                    Brochure</a>
                            @endif


                            @if ($post->document_auction)
                                <a class="btn custom-btn-3 p-2"
                                    href="{{ asset('posts/auction/' . $post->document_auction) }}" target="_blank"
                                    frameborder="0">Download
                                    Auction Sheet</a>
                            @endif

                            <!-- <button class="btn custom-btn-3 p-3">Download Brochure</button>
                                                            <button class="btn custom-btn-3 p-3">Download Auction Sheet</button> -->
                        </div>
                    </div>
                    <!-- Information Section -->
                    <div class="info-section mt-4">
                        <div class="row text-start py-2 border-top border-bottom">
                            <div class="col-md-3">
                                <div class="info-item" style="color: #281F48;">Published:</div>
                                <div class="info-value" style="color: #281F48;">
                                    {{ \Carbon\Carbon::parse($post->created_at)->format('F j, Y') }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-item" style="color: #281F48;">Last Updated:</div>
                                <div class="info-value " style="color: #281F48;">
                                    {{ \Carbon\Carbon::parse($post->updated_at)->format('F j, Y') }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-item" style="color: #281F48;">Ad Id:</div>
                                <div class="info-value" style="color: #281F48;">{{ $post->id }}</div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-item" style="color: #281F48;">Member Since:</div>
                                <div class="info-value" style="color: #281F48;">
                                    {{ \Carbon\Carbon::parse($post->dealer->created_at)->format('F j, Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="col-lg-5 pt-4">
                <div class="row align-items-center justify-content-between mb-4 pe-2">

                    <!-- Left Side Buttons -->
                    <div class="col-6 d-flex align-items-center">
                        <button class="btn custom-btn-3 px-4"
                            style="background-color:#0EB617 !important">{{ $post->condition }}</button>
                        @if ($post->feature_ad == 1)
                            <span class="featureicn">
                                <img src="{{ asset('web/bikes/images/Star 7.svg') }}" class="img-fluid">
                                Featured</span>
                        @endif
                        <!-- <button class="btn custom-btn-3 ms-2">Used</button> -->
                    </div>

                    <!-- Right Side Toggle Switch -->
                    <div class="col-4   text-end align-items-center" style="background-color:#281F48 ; border-radius:5px">
                        <div class="toggle-container d-flex align-items-center justify-content-center">
                            <span class="me-2 text-white">Price Alert</span>

                            @auth
                                <a @if (!Request::is('superadmin/*')) href="{{ route('add-price-alert', ['post_id' => $post->id, 'dealer_id' => Auth::user()->id]) }}" @else href="" @endif
                                    class="action-btn-2">
                                    <i
                                        @if (isset($price_alert) && $price_alert->status == 1) class="bi bi-toggle2-on fs-4 text-danger" @else class="bi bi-toggle2-off fs-4 text-light" @endif></i>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="action-btn-2">
                                    <i class="bi bi-toggle2-off fs-3 text-light"></i>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mb-3">
                    <!-- First Column -->
                    <div class="col-md-8">
                        <h4 class="mb-1"><span style="color: #FD5631;">PKR {{ number_format($post->price) }}</span>
                            @if ($post->price < $post->previous_price)
                                <span
                                    style="text-decoration: line-through;">{{ number_format($post->previous_price) }}</span>
                            @endif

                        </h4>
                        <div class="row">
                            <div class="col-auto">
                                <p><img src="{{ asset('web/images/mile.png') }}" class="me-lg-2 img-fluid">
                                    @php
                                        $mileage = (float) $post->milleage;
                                        if ($mileage >= 1000000) {
                                            // For values in millions, display 'M'
                                            $formattedMileage = rtrim(number_format($mileage / 1000000, 1), '.0') . 'M';
                                        } elseif ($mileage >= 1000) {
                                            // For values in thousands, display 'K'
                                            $formattedMileage = rtrim(number_format($mileage / 1000, 1), '.0') . 'K';
                                        } else {
                                            // For values less than 1000, display the raw number
                                            $formattedMileage = $mileage;
                                        }
                                    @endphp
                                    {{ $formattedMileage }} KM
                                </p>
                            </div>
                            <div class="col-auto">
                                <p><img src="{{ asset('web/images/map.png') }}"
                                        class="me-lg-2 img-fluid">{{ $post->location->cityname }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Second Column -->
                    <div class="col-md-4 p-0 pe-2">
                        <p class="font-size:12px text-end"><strong>Posted on:<br></strong><span style="font-size: 14px;">
                                {{ \Carbon\Carbon::parse($post->created_at)->format('F j, Y') }} </span></p>
                    </div>
                </div>
                <div class="wishlist-card p-3">
                    <div class="card-body ">
                        <div class="d-flex align-items-center justify-content-between">
                            <!-- Dealer Image and Details -->
                            <div class="d-flex align-items-center">
                                <!-- Dealer Image -->
                                <div class="profile-image">
                                    <img src="{{ isset($post->dealer->image) ? asset('web/profile/' . $post->dealer->image) : asset('web/images/logo version.svg') }}"
                                        alt="Dealer Image">
                                </div>

                                <!-- Dealer Name and Designation -->
                                <div>
                                    <h5 class="card-title">{{ $post->dealer->name }}</h5>
                                    <p class="card-text primary-color-custom">
                                        <strong>{{ $post->dealer->userType == 'car_dealer' ? 'Car Dealer' : 'Private Seller' }}</strong>
                                    </p>
                                </div>
                            </div>

                            <!-- Top-Right Text -->
                            <div>
                                <a style="color:#281F48" href="{{ route('dealer.posts.all', $post->dealer->id) }}"
                                    class="ads">Other Ads by
                                    this dealer</a>

                            </div>
                        </div>

                        <div class="my-3">
                            <p class="mb-1  {{ isset($post->dealer->number) ? '' : 'd-none' }}"><i
                                    class="bi bi-telephone me-2 " style="color:#281F48"></i>
                                @php
                                    $formattedNumber = isset($post->dealer->number)
                                        ? preg_replace('/^\+92(\d{3})(\d{7})$/', '+92 $1 $2', $post->dealer->number)
                                        : '';
                                @endphp
                                {{ $formattedNumber }}
                            </p>
                            <p style="color:#281F48" class="mb-1 "><i class="bi bi-envelope me-2 "
                                    style="color:#281F48"></i> <a href="mailto:saima@gmail.com" class=""
                                    style="color:#281F48">{{ $post->dealer->email }}</a></p>
                            <p style="color:#281F48" class="mb-1 {{ isset($post->dealer->address) ? '' : 'd-none' }}"><i
                                    class="bi bi-geo-alt me-2 " style="color:#281F48"></i>
                                {{ $post->dealer->address }}</p>
                            <p class="mb-1 " style="color:#281F48"><i class="bi bi-calendar me-2 "
                                    style="color:#281F48"></i> Member
                                Since {{ \Carbon\Carbon::parse($post->dealer->created_at)->format('F j, Y') }}</p>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <!-- Call Button -->
                                <a href="tel:{{ $post->dealer->number }}"
                                    class="btn custom-btn-3 {{ isset($post->dealer->number) ? '' : 'd-none' }}">
                                    <i class="bi bi-telephone me-1"></i> Call
                                </a>
                                <!-- WhatsApp Button -->
                                <a href="https://wa.me/{{ $post->dealer->number }}"
                                    class="btn custom-btn-3 {{ isset($post->dealer->number) ? '' : 'd-none' }}"
                                    target="_blank">
                                    <i class="bi bi-whatsapp me-1"></i> WhatsApp
                                </a>
                                <!-- Share Button -->


                                <button class="btn custom-btn-3 "
                                    data-url="{{ route('cardetail', ['id' => $post->id]) }}" onclick="shareLink()">
                                    <i class="bi bi-share me-1"></i> Share
                                </button>
								@auth
                                <button class="btn custom-btn-3 "
                                    onclick="createOrOpenChat({{ $post->id }}, {{ $post->dealer_id }})">
                                    <i class="bi bi-chat me-1"></i> Chat
                                </button>
								@endauth
								
								
								@guest
                                <a href="{{url('login')}}" class="btn custom-btn-3 ">
                                    <i class="bi bi-chat me-1"></i> Chat
                                </a>
								@endguest


                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-12 mt-3">
                    <h5 class="mb-4 " style="color:#281F48">Request More Information</h5>
                    <div class="p-3" style="border: 1px solid #454056; border-radius: 10px;">
                        <!-- Modal -->
                        <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="modalTitle"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalTitle">Response</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <p style="color:#281F48" id="modalMessage"></p>
                                    </div>
                                    <div class="modal-footer  border-0  p-0 pb-2">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form id="informationform" method="post" action="{{ route('submitted-forms.store') }}">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-12 mb-3">
                                    <input type="hidden" name="type" value="Request more Information">
                                    <label for="firstName" class="form-label">Full Name*</label>
                                    <input type="text" name="fullname" class="form-control " id="fullName">
                                </div>
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <input type="hidden" name="dealer_id" value="{{ $post->dealer_id }}">
                                @if (isset(Auth::user()->id))
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                @endif
                                <div class="col-md-12 mb-3">
                                    <label for="email" class="form-label">Email*</label>
                                    <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" readonly id="email">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="phoneNo" class="form-label">Phone Number</label>
                                    <input type="tel" name="number" class="form-control " id="phoneNo">
                                </div>

                                {{-- <div class="col-md-12 mb-3">
                            <select class="form-select filter-style" name="Method" id="province">
                                <option value="" selected="">Preferred Contact Method</option>
                                <option value="number">Phone Number</option>
                                <option value="email">Email</option>
                              
                            </select>
                        </div> --}}
                            </div>
                            <div class="mb-3">
                                <label for="phoneNo" class="form-label">Message</label>
                                <textarea class="form-control " style="    line-height: 1.2 !important;" id="message" name="Comment"
                                    rows="4" placeholder="" maxlength="1000"></textarea>
                            </div>
                            <button type="submit" class="btn custom-btn-nav rounded px-5">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <h3 class="mb-5 mt-3" style="color: #281F48"><strong>Similar Ads</strong></h3>
            <div class="container mt-2">
                <div id="adsCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($posts->chunk(3) as $chunkIndex => $chunk)
                            <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                                <div class="row">
                                    @foreach ($chunk as $p)
                                        <div class="col-lg-4">
                                            <div class="wishlist-card">
                                                <a style="  text-decoration: none;color: inherit;"
                                                    @if (Request::is('superadmin/*')) href="{{ route('superadmin.cardetail', $p->id) }}" 
                                            @else 
                                                href="{{ route('cardetail', $p->id) }}" @endif>
                                                    <div class="img-bg-home">
                                                        <?php $main = $p->document->first(); ?>
                                                        @if (isset($main))
                                                            <img src="{{ url('posts/doc/' . $main->doc_name) }}"
                                                                class="img-adj-card">
                                                        @else
                                                            <img src="{{ asset('web/bikes/images/logo.svg') }}"
                                                                class="img-adj-card">
                                                        @endif
                                                    </div>
                                                    <div class="p-3">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6>{{ $p->year }}</h6>
                                                            <span class="rounded px-3 py-1 text-capitalize"
                                                                style="background-color:{{ $p->condition == 'new' ? '#4581F9 ;' : '#2AB500;' }}; font-size:12px;">
                                                                {{ $p->condition }}
                                                            </span>

                                                        </div>
                                                        <h4 style="color: #281F48">{{ $p->modelname }}</h4>
                                                        <h5 style="color: #FD5631;"><b>PKR
                                                                {{ number_format($p->price) }}</b></h5>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="mb-0">
                                                                <i class="bi bi-geo-alt"></i>
                                                                {{ $p->location->cityname ?? '' }}
                                                            </h6>
                                                            <span style="font-size:14px;">Last Updated:
                                                                {{ $p->dealer ? \Carbon\Carbon::parse($p->dealer->updated_at)->format('F j, Y') : '' }}
                                                            </span>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <div class="text-center py-2"
                                                                    style="background-color:#002D690F; border-radius: 10px;">
                                                                    <i class="bi bi-speedometer2"></i>
                                                                    @php
                                                                        $mileage = (float) $p->milleage;
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
                                                                    <i class="bi bi-car-front-fill"></i>
                                                                    <h6>{{ $p->transmission }}</h6>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="text-center py-2"
                                                                    style="background-color:#002D690F; border-radius: 10px;">
                                                                    <i class="bi bi-fuel-pump-diesel"></i>
                                                                    <h6>{{ $p->fuel }}</h6>
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

    </div>
    @include('user.modal.appoinment')
    @include('user.modal.testdrive')
    @include('user.modal.inquiry')
    @include('user.modal.information')
    @include('user.modal.emailFriend')
    <div class="modal fade" id="copyurlmodal" tabindex="-1" aria-labelledby="copyurlmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="copyurlmodalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body text-center p-4">
                    <i class="bi bi-patch-check-fill fs-1"></i>

                    <h6 class="" style="line-height: 1.6;color:#281F48">
                        Link to this ad is copied to your clipboard, you can share it with others
                        <br><br>

                    </h6>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer justify-content-center border-0">
                    <a href="#" class="btn btn-light px-4 py-2 "
                        style="background-color: white; font-weight:600; color: #FD5631; border-radius: 5px;"
                        data-bs-dismiss="modal">close</a>

                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#informationform").submit(function(e) {
                e.preventDefault(); // Stop normal form submission

                $(".error-message").remove(); // Clear old error messages

                let form = $(this); // Store form reference

                $.ajax({
                    url: form.attr("action"),
                    type: "POST",
                    data: form.serialize(),
                    success: function(response) {
                        let modalMessage = "";

                        if (response.success) {
                            modalMessage = "Your message has been sent successfully!";
                            form[0].reset(); // Reset form on success
                        } else if (response.warning) {
                            modalMessage = "You have already submitted this request!";
                        } else {
                            modalMessage = "An unexpected error occurred.";
                        }

                        $("#modalMessage").text(modalMessage);
                        $("#responseModal").modal("show"); // Show modal
                    },
                    error: function(xhr) {
                        $("#modalMessage").text("You are not login. Please login first");
                        $("#responseModal").modal("show");
                    }
                });

                return false; // Prevent any default submission
            });

            // Close modal properly without reloading the page
            $("#responseModal").on("hidden.bs.modal", function() {
                $(this).modal("hide"); // Ensure modal hides properly
            });

            // Close modal manually
            $("#responseModal .btn-close, #responseModal .btn-secondary").click(function() {
                $("#responseModal").modal("hide");
            });
        });




        function shareContent() {
            const message = encodeURIComponent("Check this out! I found this really interesting. Have a look at: " + window
                .location.href);
            const whatsappURL = `https://wa.me/?text=${message}`;

            // Open the WhatsApp share URL in a new tab
            window.open(whatsappURL, '_blank');
        }


        const shareButtons = document.querySelectorAll('.sharebtn');

        shareButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Get the value of the data-url attribute
                const urlToCopy = button.getAttribute('data-url');

                // Copy the URL to the clipboard
                //navigator.clipboard.writeText(urlToCopy).then(() => {
                //  const copyUrlModal = new bootstrap.Modal(document.getElementById(
                //    'copyurlmodal'));
                // copyUrlModal.show();
                // }).catch(err => {
                //   console.error('Failed to copy URL: ', err);
                // });
                if (navigator.share) {
                    navigator.share({
                            title: 'Check out this vehicle, found on Auto Jazeera',
                            text: 'Here is an interesting car ad for you!',
                            url: urlToCopy
                        })
                        .then(() => console.log('Share was successful'))
                        .catch((error) => console.log('Sharing failed', error));
                } else {
                    // Fallback if navigator.share is not supported (e.g., on desktop)
                    console.log('Sharing is not supported in this browser.');
                }
            });
        });
    </script>
    <script>
        const carousel = document.getElementById('mouseCarousel');
        let startX = 0;

        // Add event listeners for touch and mouse gestures
        carousel.addEventListener('mousedown', (e) => {
            startX = e.clientX;
        });

        carousel.addEventListener('mouseup', (e) => {
            const endX = e.clientX;
            if (startX > endX + 50) {
                // Swipe left
                bootstrap.Carousel.getInstance(carousel).next();
            } else if (startX < endX - 50) {
                // Swipe right
                bootstrap.Carousel.getInstance(carousel).prev();
            }
        });

        carousel.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
        });

        carousel.addEventListener('touchend', (e) => {
            const endX = e.changedTouches[0].clientX;
            if (startX > endX + 50) {
                // Swipe left
                bootstrap.Carousel.getInstance(carousel).next();
            } else if (startX < endX - 50) {
                // Swipe right
                bootstrap.Carousel.getInstance(carousel).prev();
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".open-modal").forEach(function(thumbnail) {
                thumbnail.addEventListener("click", function() {
                    let imgSrc = this.getAttribute("data-img");
                    document.getElementById("modalImage").src = imgSrc;
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            let images = []; // Store image URLs
            let currentIndex = 0; // Track current index
            const $carouselInner = $("#carouselInner"); // Carousel container
            const $thumbnails = $(".thumbnail-photo"); // All thumbnail images
            const $photoModal = $("#photoModal"); // Modal reference
            const modalInstance = new bootstrap.Modal($photoModal[0]); // Bootstrap modal instance

            // Collect all image URLs from thumbnails and main carousel
            $(".open-modal, .carousel-item img").each(function(index) {
                const $element = $(this);

                if ($element.hasClass("open-modal")) {
                    images.push($element.data("img"));
                } else if ($element.prop("tagName") === "IMG") {
                    images.push($element.attr("src"));
                }

                // Open modal and set the correct image
                $element.on("click", function(event) {
                    event.preventDefault();
                    currentIndex = index;
                    loadCarouselImages();
                    modalInstance.show();
                });
            });

            // Function to load images into carousel
            function loadCarouselImages() {
                $carouselInner.empty(); // Clear previous images

                $.each(images, function(index, image) {
                    const activeClass = index === currentIndex ? "active" :
                        ""; // Set active class for current image
                    $carouselInner.append(`
                <div class="carousel-item ${activeClass}">
                    <img src="${image}" class="d-block w-100" style="height: 500px; object-fit: contain; border-radius: 10px;">
                </div>
            `);
                });
                highlightActiveThumbnail(); // Highlight the corresponding thumbnail
            }

            // Highlight the active thumbnail with a red border
            function highlightActiveThumbnail() {
                $thumbnails.each(function(index) {
                    if (index === currentIndex) {
                        $(this).css("border", "2px solid #FD5631"); // Add red border to active thumbnail
                    } else {
                        $(this).css("border", "2px solid white"); // Remove red border from others
                    }
                });
            }
            // Bootstrap carousel event listener for when slide changes
            $("#imageCarousel").on('slid.bs.carousel', function(event) {
                currentIndex = event.to; // Update currentIndex based on the active slide
                highlightActiveThumbnail(); // Highlight the corresponding thumbnail
            });
            // Reset modal when closed
            $photoModal.on("hidden.bs.modal", function() {
                $carouselInner.empty(); // Clear images to prevent issues
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#phoneNo").val("+92 ").on("input", function() {
                let phoneValue = $(this).val().replace(/[^0-9]/g, '').replace(/^92/,
                    ''); // Remove non-numeric except "92"
                let formatted = '+92 ' + phoneValue.substring(0, 3) + (phoneValue.length > 3 ? ' ' +
                    phoneValue.substring(3, 11) : '');
                $(this).val(formatted.substring(0, 15));
            }).on("keydown", function(e) {
                if ($(this).val().length <= 4 && e.key === "Backspace") e
                    .preventDefault(); // Prevent deleting "+92 "
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
                        vehicle_type: 'car'
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
