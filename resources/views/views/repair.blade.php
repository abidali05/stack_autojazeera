@extends('layout.website_layout.bikes.bike_main')
@section('content')
  <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Services</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Auto Repair</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row d-flex justify-content-between">
            <div class="col-md-4">
                <h1 class="fourtyeight">Auto Repair</h1>
            </div>
            <div class="col-md-6"></div>
        </div>
        <div class="row d-flex justify-content-between align-items-baseline">
            <div class="col-md-8 col-12 mt-4">
                <button class="buttons me-3"><img src="./images/Filter 1.svg" class="img-fluid me-2"
                        alt="...">All</button>
                <div class="btn-group me-3">
                    <button type="button " class=" buttons dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Distance
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Separated link</a></li>
                    </ul>
                </div>
                <button class="buttons me-3">Open Now</button>
                <button class="buttons me-3">Service Type</button>
                <button class="buttons me-3">Amenities </button>
            </div>
            <div class="col-md-4 d-flex justify-content-end">
                <span class="me-4 sixteen">
                    1 - 30 of 571 Results
                </span>
                <span class="sixteen">
                    sort<i class="bi bi-arrow-down-up ms-2 sixteen"></i>
                </span>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12" style="background-color: #F0F3F6; border-radius: 10px;">
                <div class="row">
                    <div class="col-md-3 p-0">
                        <div class="imagediv">
                            <img src="./images/image (2).svg" class="imagewidth" alt="...">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row py-5 px-3">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-12 px-4">
                                        <div class="row">
                                            <div class="col-7">
                                                <p class="twentyfour"> Sestito Mobile Detailing</p>
                                            </div>
                                            <div class="col-5 d-flex justify-content-end">


                                                <div class="rating-container">
                                                    <div class="stars" id="stars"></div>

                                                </div>

                                            </div>
                                            <div class="col-12 d-flex justify-content-between">

                                                <p class="fourteen"><span style="color: #2AB500;">Open Now</span> 9:00
                                                    am - 7:00 pm</p>
                                                <div class="review-text" id="reviewText">4.5 (12 reviews)</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-between">
                                                <p><strong>Window Washing</strong></p>
                                                <p><strong>Auto Detailing</strong></p>
                                                <p><strong>Pressure Washing</strong></p>
                                            </div>
                                            <div class="col-12 borderbottom">
                                                <p> <span class="fourteen "> <img src="./images/Icon (Stroke).svg"
                                                            class="img-fluid me-2" alt="...">Satellite town Rawalpindi
                                                        (14 km away)</span></p>
                                            </div>
                                            <div class="col-12 mt-3">
                                                <p class="fourteen">Sestito Mobile Detailing is your all-in-one solution
                                                    for premium car and home care. We specialize in both interior...
                                                    <span style="color: #FD5631;">more</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 borderleft">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="">
                                            <button class="button11 ">Request a Quote</button>
                                            <button class="button11 "><i class="bi bi-star text-white me-2"></i>Request
                                                a review</button>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-4">
                                            <span class=" pt-3 sixteen"> www.website.com</span> <span><img
                                                    src="./images/Icon.svg" class="img-fluid" alt="..."><img
                                                    src="./images/Group 1171275361.svg" class="img-fluid ms-3"
                                                    alt="..."></span>
                                        </div>
                                        <div class="mt-4 pt-3">
                                            <p class="sixteen">Any Street, Any Block, Islamabad</p>



                                        </div>
                                        <div class="d-flex justify-content-between pt-4">
                                            <span class="twelvewhitee"><img src="./images/whatsapp.svg"
                                                    class="img-fluid me-2" alt="..."></span><span class="twelvewhitee">
                                                <img src="./images/facebook.svg" class="img-fluid me-2"
                                                    alt="..."></span> <span class="twelvewhitee"><img
                                                    src="./images/instagram.svg" class="img-fluid me-2"
                                                    alt="..."></span><span class="twelvewhitee"><img
                                                    src="./images/Vector0.svg" class="img-fluid me-2" alt="..."></span>
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
  <script>
        const starsContainer = document.getElementById("stars");
        const reviewText = document.getElementById("reviewText");
        const totalStars = 5;
        let currentRating = 4.5;
        let reviewCount = 12;

        function renderStars(rating) {
            starsContainer.innerHTML = "";
            const fullStars = Math.floor(rating);

            for (let i = 1; i <= totalStars; i++) {
                const circle = document.createElement("div");
                circle.classList.add("star-circle");
                if (i <= fullStars) circle.classList.add("active");

                const star = document.createElement("span");
                star.textContent = "★";
                star.classList.add("star");
                if (i <= fullStars) star.classList.add("filled");

                // click event to rate
                circle.addEventListener("click", () => {
                    currentRating = i;
                    reviewCount++;
                    updateRating(currentRating);
                });

                circle.appendChild(star);
                starsContainer.appendChild(circle);
            }
        }

        function updateRating(rating) {
            const circles = starsContainer.querySelectorAll(".star-circle");
            const stars = starsContainer.querySelectorAll(".star");

            circles.forEach((circle, index) => {
                circle.classList.toggle("active", index < rating);
            });

            stars.forEach((star, index) => {
                star.classList.remove("filled", "clicked");
                if (index < rating) {
                    star.classList.add("clicked");
                }
            });

            reviewText.textContent = `${rating.toFixed(1)} (${reviewCount} reviews)`;
        }

        renderStars(currentRating);
    </script>
@endsection