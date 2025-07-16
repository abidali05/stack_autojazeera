@extends('layout.website_layout.main')
@section('content')
<style>
	h4{
	color:#281F48;
	}
	.aboutbackimg{
	  background-image: url('web/images/aboutback.svg');
  background-size: cover;         /* Adjust to fit container */
  background-repeat: no-repeat;   /* Prevent repeating */
  background-position: center;    /* Center the image */
	}
</style>
    <!-- Banner -->
    <div class="container-fluid rounded-5 rounded-top-0 p-lg-5 p-3 aboutbackimg" >
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h4 class="text-white">WELCOME TO</h4>
                    <h1 class="banner text-white text-uppercase" style="color: #1F1B2D;">Auto Jazeera</h1>
                    <p class="banner">Join our marketplace to showcase your
                        vehicles and elevate your dealership’s presence. </p>
                </div>
            </div>
        </div>

    </div>
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h4 class="sec">Pakistan's Ultimate Online Marketplace for All Things Automotive.</h4>
                <p>At Auto Jazeera, our mission is simple yet ambitious: to redefine the car buying and
                    selling experience across Pakistan. We believe in making this journey smooth, transparent, and
                    enjoyable for everyone whether you're a buyer searching for your dream car or a dealer looking to
                    reach more customers. </p>
            </div>
            <div class="col-lg-5">
                <img src="{{asset('web/images/about.png')}}" alt="" srcset="" class="img-fluid">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mb-5 g-3">
            <h4 class="sec mb-4">Why Choose Auto Jazeera?</h4>
            <div class="col-lg-4">
                <div class="col-stlying px-lg-4 px-3"  style="height: 250px;">
                    <img src="{{asset('web/images/handshak.svg')}}" alt="" srcset="" class="mb-3" width="50px" height="50px">
                    <h4 class="">Trusted Platform</h4>
                    <p class="" style="font-size: 14px;">We prioritize your peace of mind. Auto Jazeera is
                        built on trust, ensuring
                        that every transaction is secure and straightforward.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="col-stlying px-lg-4 px-3"  style="height: 250px;">
                    <img src="{{asset('web/images/threeman.svg')}}" alt="" srcset="" class="mb-3" width="50px" height="50px">
                    <h4 class="">Comprehensive Dealer Network</h4>
                    <p class="" style="font-size: 14px;">Connect with a vast network of dealers across
                        Pakistan. Whether you're looking
                        for new or used vehicles, Auto Jazeera brings a wide selection to your fingertips.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="col-stlying px-lg-4 px-3" style="height: 250px;">
                    <img src="{{asset('web/images/namesvg.svg')}}" alt="" srcset="" class="mb-3" width="50px" height="50px">
                    <h4 class="">Advanced Search & Filters</h4>
                    <p class="" style="font-size: 14px;">Finding the right car should be effortless. Our
                        state-of-the-art filtering
                        system helps you quickly zero in on vehicles that match your preferences, making the search
                        process as efficient as possible.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mb-5">

            <div class="col-lg-6">
                <div class="col-stlying p-4">
                    <h4 class="sec mb-4">For Dealers</h4>
                    <p>Auto Jazeera isn’t just a marketplace—it’s a powerful tool for your business. </p>
                    <div class="row mb-3">
                        <div class="col-2">
                            <img src="{{asset('web/images/circle-icon.png')}}" alt="" srcset="" class="mb-2 img-fluid">
                        </div>
                        <div class="col-10">
                            <h4 class="">Broad Reach</h4>
                            <p class="" style="font-size: 14px;">Showcase your inventory to a large and
                                diverse audience.  <br> &nbsp;</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-2">
                            <img src="{{asset('web/images/circle-icon.png')}}" alt="" srcset="" class="mb-2 img-fluid">
                        </div>
                        <div class="col-10">
                            <h4 class="">Efficient Management</h4>
                            <p class="" style="font-size: 14px;">Our user-friendly platform makes listing and
                                managing your vehicles a breeze, giving you more time to focus on sales <br> &nbsp;</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-2">
                            <img src="{{asset('web/images/circle-icon.png')}}" alt="" srcset="" class="mb-2 img-fluid">
                        </div>
                        <div class="col-10">
                            <h4 class="">Direct Communication</h4>
                            <p class="" style="font-size: 14px;">Engage with potential buyers directly through
                                multiple channels, including Call, SMS, WhatsApp, and Web Forms, making it easier than
                                ever to connect and close deals. <br> &nbsp;</p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-6">
                <div class="col-stlying p-4">
                    <h4 class="sec mb-4">For Buyers</h4>
                    <p>Buying a car is a significant decision, and we’re here to make it as simple and enjoyable as
                        possible.</p>
                    <div class="row mb-3">
                        <div class="col-2">
                            <img src="{{asset('web/images/circle-icon.png')}}" alt="" srcset="" class="mb-2 img-fluid">
                        </div>
                        <div class="col-10">
                            <h4 class="">Extensive Inventory</h4>
                            <p class="" style="font-size: 14px;">Browse a wide range of vehicles from trusted
                                dealers across Pakistan, all from the comfort of your home.</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-2">
                            <img src="{{asset('web/images/circle-icon.png')}}" alt="" srcset="" class="mb-2 img-fluid">
                        </div>
                        <div class="col-10">
                            <h4 class="">Easy Connections</h4>
                            <p class="" style="font-size: 14px;">With several communication options at your
                                disposal, reaching out to dealers is fast and convenient, allowing you to take the next
                                steps with confidence.</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-2">
                            <img src="{{asset('web/images/circle-icon.png')}}" alt="" srcset="" class="mb-2 img-fluid">
                        </div>
                        <div class="col-10">
                            <h4 class="">Direct Communication</h4>
                            <p class="" style="font-size: 14px;">Engage with car dealers directly through
                                multiple channels, including Call, SMS, WhatsApp, and Web Forms, making it easier than
                                ever to connect with dealer. In addition, subscribe to our Price Drop feature to receive
                                price alerts. </p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <div class="container">
        <div class="row mb-5 g-3">
            <h4 class="sec mb-4">Our Values</h4>
            <div class="col-lg-6">
                <div class="col-stlying p-3">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{asset('web/images/currency.svg')}}" alt="" srcset="" class="me-2">
                        <h4 class=" mb-0">Innovation</h4>
                    </div>
                    <p class="" style="font-size: 14px;">Innovative Design Meets User-Friendly Software
                        Transform<br>&nbsp;</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="col-stlying p-3">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{asset('web/images/currency.svg')}}" alt="" srcset="" class="me-2">
                        <h4 class=" mb-0">Transform</h4>
                    </div>
                    <p class="" style="font-size: 14px;">Transforming the Automotive Industry: Digitally
                        Showcasing Pakistan's Car Dealers.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="col-stlying p-3">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{asset('web/images/currency.svg')}}" alt="" srcset="" class="me-2">
                        <h4 class=" mb-0">Integrity</h4>
                    </div>
                    <p class="" style="font-size: 14px;">Connecting buyers and dealers on a reliable platform for smooth and trustworthy auto transactions.
                        </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="col-stlying p-3">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{asset('web/images/currency.svg')}}" alt="" srcset="" class="me-2">
                        <h4 class=" mb-0">Socially Responsible</h4>
                    </div>
                    <p class="" style="font-size: 14px;">A socially responsible platform designed to meet the needs of local communities, fostering trust and fairness.</p>
                </div>
            </div>
        </div>
    </div>
@endsection