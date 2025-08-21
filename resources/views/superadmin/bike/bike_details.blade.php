@extends('layout.panel_layout.main')
@section('content')

<style>.toggle-switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 20px;
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
    background-color: #f45139; /* Red shade */
    border-radius: 34px;
    transition: 0.4s;
	    height: 20px;
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

input:checked + .slider {
    background-color: #f45139;
}

input:checked + .slider:before {
    transform: translateX(26px);
}
</style>
  <div class="container mb-4 mt-5">
        <div class="breadcrumb-nav mb-3">
            <a href="#" class="breadcrumb-item text-white">Home</a>
            <span class="breadcrumb-separator">></span>
            <a href="#" class="breadcrumb-item text-white">Used Cars</a>
            <span class="breadcrumb-separator">></span>
            <span class="breadcrumb-item active">Mercedes-Benz E 400 Cabriolet</span>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <h2>Mercedes-Benz E 400 Cabriolet 2024</h2>
            </div>
            <div class="col-lg-4 text-end">
                <div class="action-buttons">
               
                        <i class="bi bi-share-fill me-3"></i>
                 
            
                        <i class="bi bi-heart-fill"></i>
                 
                </div>
            </div>
        </div>
    </div>
 <div class="container mb-4">
        <div class="row">
            <div class="col-lg-7">
                <img src="{{asset('web/images/imagebike.svg')}}" alt="" srcset="" class="img-fluid">
                <div class="d-flex flex-wrap gap-2 my-3">
                    <button class="btn custom-btn-3 rounded">Book An Appointment</button>
                    <button class="btn custom-btn-3 rounded">Schedule Test Drive</button>
                    <button class="btn custom-btn-3 rounded">General Inquiry</button>
                    <button class="btn custom-btn-3 rounded">Request More Information</button>
                    <button class="btn custom-btn-3 rounded">Email A Friend</button>
                </div>
                <div class="container my-4">
                    <h3 style="color: #FD5631;">Specifications</h3>
                 
                    <!-- Row 1 -->
                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Make</strong></span>
                            <span>Honda</span>
                        </div>   <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Condition</strong></span>
                            <span>Used</span>
                        </div>
                        
                    </div>

                    <div class="row">   <div class="col-md-6 d-flex justify-content-between">
                        <span><strong>Model</strong></span>
                        <span>2004</span>
                    </div>
                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>VIN</strong></span>
                            <span>KNDPMCAC8H7092278</span>
                        </div>
                     
                    </div>

                    <!-- Row 2 -->
                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Year</strong></span>
                            <span>2017</span>
                        </div>
                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Stock Number</strong></span>
                            <span>9725</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Trim</strong></span>
                            <span>LX AWD</span>
                        </div>
                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Cylinder </strong></span>
                            <span>Cylinder</span>
                        </div>
                    </div>

                    <!-- Row 3 -->
                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Drivetrain</strong></span>
                            <span>All-Wheel Drive</span>
                        </div>
                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Fuel Tank Capacity</strong></span>
                            <span>62 L</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Engine</strong></span>
                            <span>181 hp 2.4L I4</span>
                        </div>
                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>General Fuel Combustion</strong></span>
                            <span>10.4 L/100km</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Transmission</strong></span>
                            <span>Transmissions</span>
                        </div> <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Highway Combustion</strong></span>
                            <span>9.4 L/100km</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Horsepower</strong></span>
                            <span>181 hp</span>
                        </div>
                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>City Combustion </strong></span>
                            <span>11.2 L/100km</span>
                        </div>
                    </div>   <div class="row">
                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Body Type</strong></span>
                            <span>SUV / Crossover</span>
                        </div>
                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Fuel Type </strong></span>
                            <span>Gasoline</span>
                        </div>
                    </div>   <div class="row">
                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Exterior Colour</strong></span>
                            <span>Mineral Silver</span>
                        </div>
                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Transmission </strong></span>
                            <span>Automatic</span>
                        </div>
                    </div> <div class="row">
                        <div class="col-md-6 d-flex justify-content-between">
                            <span><strong>Interior Colour</strong></span>
                            <span> Black</span>
                        </div>
                       
                    </div>

                    <!-- Features Section -->
                    <div class="features mt-4">
                        <h3 style="color: #FD5631;">Features</h3>
                        <div class="row mt-3">
                            <div class="col-md-4 feature-item">
                               <i class="bi bi-fan fs-1"></i>  Air Conditioning
                            </div>
                            <div class="col-md-4 feature-item">
                                <i class="bi bi-shield-shaded fs-1"></i> Air Bags
                            </div>
                            <div class="col-md-4 feature-item">
                                <i class="bi bi-radio fs-1"></i> AM / FM Radio
                            </div>
                            <div class="col-md-4 feature-item">
                                <i class="bi bi-cassette-fill fs-1"></i> Cassette Player
                            </div>
                            <div class="col-md-4 feature-item">
                                <i class="bi bi-thermometer-half fs-1"></i> Cool Box
                            </div>
                            <div class="col-md-4 feature-item">
                                <i class="bi bi-speedometer2 fs-1"></i> Cruise Control
                            </div>
                            <div class="col-md-4 feature-item">
                                <i class="bi bi-disc fs-1"></i> DVD Player
                            </div>
                            <div class="col-md-4 feature-item">
                                <i class="bi bi-speaker fs-1"></i> Front Speaker
                            </div>
                            <div class="col-md-4 feature-item">
                                <i class="bi bi-camera-video fs-1"></i> Front Camera
                            </div>
                            <div class="col-md-4 feature-item">
                                <i class="bi bi-key fs-1"></i> Keyless Entry
                            </div>
                            <div class="col-md-4 feature-item">
                                <i class="bi bi-shield fs-1"></i> Immobilizer Key
                            </div>
                            <div class="col-md-4 feature-item">
                                <i class="bi bi-map fs-1"></i> Navigation System
                            </div>
                            <div class="col-md-4 feature-item">
                                <i class="bi bi-mirror fs-1"></i> Power Mirror
                            </div>
                            <div class="col-md-4 feature-item">
                                <i class="bi bi-steering-wheel fs-1"></i> Power Steering
                            </div>
                            <div class="col-md-4 feature-item">
                                <i class="bi bi-lock fs-1"></i> Power Lock
                            </div>
                            <div class="col-md-4 feature-item">
                                <i class="bi bi-thermometer-sun fs-1"></i> Heated Seats
                            </div>
                            <div class="col-md-4 feature-item">
                                <i class="bi bi-cloud fs-1"></i> Climate Control
                            </div>
                            <div class="col-md-4 feature-item">
                                <i class="bi bi-rim fs-1"></i> Alloy Rim
                            </div>
                        </div>
                    </div>
                    <!-- Seller's Description Section -->
                    <div class="description mt-4">
                        <h3 style="color: #FD5631;">Seller's Description</h3>
                        <p>Lorem tincidunt lectus vitae id vulputate diam quam. Imperdiet non scelerisque turpis sed
                            etiam ultrices. Blandit mollis dignissim egestas consectetur porttitor. Vulputate dolor
                            pretium, dignissim eu augue sit.</p>
                        <div class="mt-3">
                            <button class=" custom-btn-3 py-2 px-3 rounded-2">Download Brochure</button>
                            <button class=" custom-btn-3 py-2 px-3 rounded-2">Download Auction Sheet</button>
                        </div>
                    </div>
                    <!-- Information Section -->
                    <div class="info-section mt-4">
                        <div class="row text-start border-top border-bottom">
                            <div class="col-md-3">
                                <div class="info-item">Published:</div>
                                <div class="info-value">May 9, 2021</div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-item">Last Updated:</div>
                                <div class="info-value">May 9, 2021</div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-item">Ad Id:</div>
                                <div class="info-value">6810</div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-item">Member Since:</div>
                                <div class="info-value">April 19, 2012</div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="col-lg-5">
                <div class="row align-items-center mb-4">
                    <!-- Left Side Buttons -->
                    <div class="col d-flex align-items-center">
                        <button class="btn custom-btn-3"  style="background-color: #4581F9 !important;">New</button>
                        <button class="btn custom-btn-3 ms-2" style="background-color: #0EB617 !important;">Used</button>
                    </div>

                    <!-- Right Side Toggle Switch -->
                    <div class="col text-end">
                        <div class="toggle-container">
                            Price Alert
                            <label class="toggle-switch">
                                <input type="checkbox" id="priceAlertToggle">
                                <span class="slider"></span>
                            </label>
                            
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mb-3">
                    <!-- First Column -->
                    <div class="col-md-8">
                        <h5 class="mb-1"><span style="color: #FD5631;">PKR 34,353.00</span></h5>
                        <div class="row">
                            <div class="col-auto">
                                <p>25K miles</p>
                            </div>
                            <div class="col-auto">
                                <p>Chicago, IL 60603</p>
                            </div>
                        </div>
                    </div>
                    <!-- Second Column -->
                    <div class="col-md-4 text-end">
                        <p><strong>Posted on:</strong> 24 March 2024</p>
                    </div>
                </div>
                <div class="card"style="background-color: #1F1B2D;border:none ; color:white">
                    <div class="card-body " >
                        <div class="d-flex align-items-center">
                        <!-- Dummy Circular Image -->
                        <img src="{{asset('web/images/Ellipse 133.svg')}}" alt="Dealer Image" class="rounded-circle me-3">
                        <!-- Dealer Name and Designation -->
                        <div>
                            <h5 class="card-title">Saima</h5>
                            <p class="card-text">Dealer</p>
                        </div>
                    </div>
                        <div>
                            <p class="mt-3"><i class="bi bi-telephone me-2 "></i> (316) 123 4567</p>
            <p><i class="bi bi-envelope me-2"></i> <a style="color: white;" href="mailto:saima@gmail.com">saima@gmail.com</a></p>
            <p><i class="bi bi-geo-alt me-2"></i> Any Street, Any Block, Islamabad</p>
            <p><i class="bi bi-calendar me-2"></i> Member Since April 19, 2002</p>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <!-- Call Button -->
                                <a href="tel:+3161234567" class="btn custom-btn-3 me-1 py-2">
                                    <i class="bi bi-telephone me-1"></i> Call
                                </a>
                                <!-- WhatsApp Button -->
                                <a href="https://wa.me/3161234567" class="btn custom-btn-3 me-1 py-2" target="_blank">
                                    <i class="bi bi-whatsapp me-1"></i> WhatsApp
                                </a>
                                <!-- Share Button -->
                                <button class="btn custom-btn-3 me-1 py-2" onclick="alert('Share functionality goes here!')">
                                    <i class="bi bi-share me-1"></i> Share
                                </button>
                                <!-- SMS Button -->
                                <a href="sms:+3161234567" class="btn custom-btn-3 py-2">
                                    <i class="bi bi-chat-dots me-1"></i> SMS
                                </a>
                            </div>
                            <div class="col-12 mt-3">
                                <h5 class="mb-4 primary-color-custom">Request More Information</h5>
                                <div class="p-3" style="border: 1px solid #454056; border-radius: 10px;">
                                    <form >
                                    
                                        <div class="row mb-3">
                                            <div class="col-md-12 mb-3">
                                                <input type="hidden" name="type" value="Request more Information">
                                                <label for="firstName" class="form-label"><strong>Full Name*</strong></label>
                                                <input type="text" name="fullname" class="form-control formcontrol"
                                                    id="fullName">
                                            </div>
                                    
                                   
                                     
                                            <div class="col-md-12 mb-3">
                                                <label for="email" class="form-label"><strong>Email*</strong></label>
                                                <input type="email" name="email" class="form-control formcontrol"
                                                    id="email">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="phoneNo" class="form-label"><strong>Phone Number</strong></label>
                                                <input type="tel" name="number" class="form-control formcontrol"
                                                    id="phoneNo">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="phoneNo" class="form-label"><strong>Message</strong></label>
                                            <textarea class="form-control formcontrol" id="message" name="Comment" rows="4" placeholder=""
                                                maxlength="1000"></textarea>
                                        </div>
                                        <button type="submit" class="btn custom-btn-nav rounded px-5">Send Message</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
            </div>
        </div>
	 
        <div class="row">
            <div class="col-lg-4">
                <div class="wishlist-card">
                        <div class="img-bg-home-2">

                                                            <img src="{{asset('web/images/imagebikee.svg')}}" class="img-adj-card">
                                                        </div>
                    <div class="p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6>2024</h6>
                            <span class="rounded px-3" style="background-color:#4581F9;">New</span>
                        </div>

                        <h4>Mercedes-Benz reveals</h4>
                        <h5 style="color: #FD5631;"><b>PKR 35000000</b></h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"> <i class="bi bi-geo-alt"></i> Turbat</h6>
                            <span>Last Updated: April 19,2002 </span>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-4">
                                <div class="text-center py-2" style="background-color:#1F1B2D; border-radius: 10px;">
                                    <i class="bi bi-speedometer2"></i>
                                    <h6>48 KM</h6>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center py-2" style="background-color:#1F1B2D; border-radius: 10px;">
                                    <i class="bi bi-car-front-fill"></i>
                                    <h6>Auto</h6>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center py-2" style="background-color:#1F1B2D; border-radius: 10px;">
                                    <i class="bi bi-fuel-pump-diesel"></i>
                                    <h6>Gasoline</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-4">
                <div class="wishlist-card">
                       <div class="img-bg-home-2">

                                                            <img src="{{asset('web/images/imagebikee.svg')}}" class="img-adj-card">
                                                        </div>
                    <div class="p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6>2024</h6>
                            <span class="rounded px-3" style="background-color:#4581F9;">New</span>
                        </div>

                        <h4>Mercedes-Benz reveals</h4>
                        <h5 style="color: #FD5631;"><b>PKR 35000000</b></h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"> <i class="bi bi-geo-alt"></i> Turbat</h6>
                            <span>Last Updated: April 19,2002 </span>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-4">
                                <div class="text-center py-2" style="background-color:#1F1B2D; border-radius: 10px;">
                                    <i class="bi bi-speedometer2"></i>
                                    <h6>48 KM</h6>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center py-2" style="background-color:#1F1B2D; border-radius: 10px;">
                                    <i class="bi bi-car-front-fill"></i>
                                    <h6>Auto</h6>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center py-2" style="background-color:#1F1B2D; border-radius: 10px;">
                                    <i class="bi bi-fuel-pump-diesel"></i>
                                    <h6>Gasoline</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-4">
                <div class="wishlist-card">
              <div class="img-bg-home-2">

                                                            <img src="{{asset('web/images/imagebikee.svg')}}" class="img-adj-card">
                                                        </div>
                    <div class="p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6>2024</h6>
                            <span class="rounded px-3" style="background-color:#4581F9;">New</span>
                        </div>

                        <h4>Mercedes-Benz reveals</h4>
                        <h5 style="color: #FD5631;"><b>PKR 35000000</b></h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"> <i class="bi bi-geo-alt"></i> Turbat</h6>
                            <span>Last Updated: April 19,2002 </span>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-4">
                                <div class="text-center py-2" style="background-color:#1F1B2D; border-radius: 10px;">
                                    <i class="bi bi-speedometer2"></i>
                                    <h6>48 KM</h6>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center py-2" style="background-color:#1F1B2D; border-radius: 10px;">
                                    <i class="bi bi-car-front-fill"></i>
                                    <h6>Auto</h6>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center py-2" style="background-color:#1F1B2D; border-radius: 10px;">
                                    <i class="bi bi-fuel-pump-diesel"></i>
                                    <h6>Gasoline</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    
            </div>
        </div>

    </div>

@endsection('content')