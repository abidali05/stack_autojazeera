@extends('layout.panel_layout.main')
@section('content')
    <!-- Banner -->
    <div class="container-fluid section-bg-1">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-xl-4">
                    <h1 class="banner">Join us as a<br>
                        Car Dealer</h1>
                    <p class="banner">Join our marketplace to showcase your vehicles and elevate your dealership’s
                        presence.
                        Connect with
                        millions of potential customers and drive new business to your doorstep! </p>
                    <p class="sub">Secure our flat rate registration now, this special offer won’t last long!</p>
                    <img src="{{asset('web/images/car-mob.png')}}" alt="" srcset="" class="d-md-none d-block img-fluid">
                </div>

            </div>
        </div>
    </div>
    <!-- Section -->
@include('layout.plan_and_price')
    <!-- Section -->
@include('layout.payment')
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-xl">
            <div class="modal-content">
                <div class="modal-body p-5">
                    <div class="row gx-5">
                        <div class="col-lg-4">
                            <div class="col-stlying">
                                <img src="{{asset('web/images/heart.png')}}" alt="" srcset="" class="mb-2">
                                <h4 class="text-white">My Wishlist</h4>
                                <p class="text-white">This site is provided as a service to our visitors and may be used
                                    for
                                    informational
                                    purposes only.</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-stlying">
                                <img src="{{asset('web/images/file-icon.png')}}" alt="" srcset="" class="mb-2">
                                <h4 class="text-white">My Submitted Forms</h4>
                                <p class="text-white">This site is provided as a service to our visitors and may be used
                                    for informational purposes only.</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-stlying">
                                <img src="{{asset('web/images/profile-icon.png')}}" alt="" srcset="" class="mb-2">
                                <h4 class="text-white">Personal Information</h4>
                                <p class="text-white">This site is provided as a service to our visitors and may be used
                                    for informational purposes only.</p>
                            </div>
                        </div>
                        <div class="col-lg-12 text-end mt-4">
  

                        <form action="{{route('superadmin.logout')}}" method="post">
                            @csrf
                            <button type="submit" class="btn modal-btn">Logout</button>

                    </form>
                            <!-- <a href="#" class="btn modal-btn"> Logout
                            </a> -->
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal-2 -->
    <div class="modal fade" id="exampleModal-2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-xl">
            <div class="modal-content">
                <div class="modal-body p-5">
                    <div class="row gy-3">
                        <div class="col-lg-4">
                            <div class="col-stlying">
                                <img src="{{asset('web/images/icon.png')}}" alt="" srcset="" class="mb-2">
                                <h4 class="text-white">Post an Ad</h4>
                                <p class="text-white">This site is provided as a service to our visitors and may be used
                                    for informational purposes only.</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-stlying">
                                <img src="{{asset('web/images/Mask group.png')}}" alt="" srcset="" class="mb-2">
                                <h4 class="text-white">Manage Ads</h4>
                                <p class="text-white">This site is provided as a service to our visitors and may be used
                                    for informational purposes only.</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-stlying">
                                <img src="{{asset('web/images/cards 1.png')}}" alt="" srcset="" class="mb-2">
                                <h4 class="text-white">Manage Subscription</h4>
                                <p class="text-white">This site is provided as a service to our visitors and may be used
                                    for informational purposes only.</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-stlying">
                                <img src="{{asset('web/images/Mask group (2).png')}}" alt="" srcset="" class="mb-2">
                                <h4 class="text-white">View Leads</h4>
                                <p class="text-white">This site is provided as a service to our visitors and may be used
                                    for informational purposes only.</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-stlying">
                                <img src="{{asset('web/images/double-profile.png')}}" alt="" srcset="" class="mb-2">
                                <h4 class="text-white">Manage Users</h4>
                                <p class="text-white">This site is provided as a service to our visitors and may be used
                                    for informational purposes only.</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-stlying">
                                <img src="{{asset('web/images/profile-icon.png')}}" alt="" srcset="" class="mb-2">
                                <h4 class="text-white">Personal Information</h4>
                                <p class="text-white">This site is provided as a service to our visitors and may be used
                                    for informational purposes only.</p>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="col-stlying">
                                <img src="{{asset('web/images/profile-icon.png')}}" alt="" srcset="" class="mb-2">
                                <h4 class="text-white">My Wishlist</h4>
                                <p class="text-white">This site is provided as a service to our visitors and may be used
                                    for informational purposes only.</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-stlying">
                                <img src="{{asset('web/images/file-icon.png')}}" alt="" srcset="" class="mb-2">
                                <h4 class="text-white">My Submitted Forms</h4>
                                <p class="text-white">This site is provided as a service to our visitors and may be used
                                    for informational purposes only.</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-stlying">
                                <img src="{{asset('web/images/lock.png')}}" alt="" srcset="" class="mb-2">
                                <h4 class="text-white">Login & Security</h4>
                                <p class="text-white">This site is provided as a service to our visitors and may be used
                                    for informational purposes only.</p>
                            </div>
                        </div>


                        <div class="col-lg-12 text-end mt-4">
                        <form action="{{route('superadmin.logout')}}" method="post">
                            @csrf
                            <button type="submit" class="btn modal-btn">Logout</button>

                    </form>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- beforesignin-->
    <div class="modal fade" id="beforesignin" class="beforesignin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-xl">
            <div class="modal-content">
                <div class="modal-body p-5">
                    <div class="row gy-3 text-center">
              

                    
                     
                        <div class="">
                            <div class="col-stlying">
                                <a href="{{url('login')}}">
                                <img src="{{asset('web/images/lock.png')}}" alt="" srcset="" class="mb-2">
                                <h4 class="text-white">Login</h4>
                                </a>
                            </div>
                        </div>
                        <div class="">
                            <div class="col-stlying">
                            <a href="{{url('register')}}">
                                <img src="{{asset('web/images/lock.png')}}" alt="" srcset="" class="mb-2">
                                <h4 class="text-white">Sign Up</h4>
                            </a>
                            </div>
                        </div>


                     

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal-3 -->
    <div class="modal fade" id="exampleModal-3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-xl">
            <div class="modal-content">
                <div class="modal-body p-5">
                    <div class="row gy-3">
                        <div class="col-lg-4">
                            <div class="col-stlying">
                                <img src="{{asset('web/images/icon.png')}}" alt="" srcset="" class="mb-2">
                                <h4 class="text-white">Create/Manage Dealer</h4>
                                <p class="text-white">This site is provided as a service to our visitors and may be used
                                    for informational purposes only.</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-stlying">
                                <img src="{{asset('web/images/Mask group.png')}}" alt="" srcset="" class="mb-2">
                                <h4 class="text-white">Manage Dealer Ads</h4>
                                <p class="text-white">This site is provided as a service to our visitors and may be used
                                    for informational purposes only.</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-stlying">
                                <img src="{{asset('web/images/Mask group (1).png')}}" alt="" srcset="" class="mb-2">
                                <h4 class="text-white">Manage Dealer Subscription</h4>
                                <p class="text-white">This site is provided as a service to our visitors and may be used
                                    for informational purposes only.</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-stlying">
                                <img src="{{asset('web/images/profile-icon.png')}}" alt="" srcset="" class="mb-2">
                                <h4 class="text-white">Create/Manage Dealer Users</h4>
                                <p class="text-white">This site is provided as a service to our visitors and may be used
                                    for informational purposes only.</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-stlying">
                                <img src="{{asset('web/images/file-icon.png')}}" alt="" srcset="" class="mb-2">
                                <h4 class="text-white">My Submitted Forms</h4>
                                <p class="text-white">This site is provided as a service to our visitors and may be used
                                    for informational purposes only.</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-stlying">
                                <img src="{{asset('web/images/lock.png')}}" alt="" srcset="" class="mb-2">
                                <h4 class="text-white">Login & Security</h4>
                                <p class="text-white">This site is provided as a service to our visitors and may be used
                                    for informational purposes only.</p>
                            </div>
                        </div>


                        <div class="col-lg-12 text-end mt-4">
                        <form action="{{route('superadmin.logout')}}" method="post">
                            @csrf
                            <button type="submit" class="btn modal-btn">Logout</button>

                    </form>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection