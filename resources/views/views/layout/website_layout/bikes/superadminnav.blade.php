<style>
    .custom-btn-nava {
        background-color: #FD5631 !important;
        border: 0px !important;
        border-radius: 50px;
        padding: 13px 20px !important;
        color: white ;
        line-height: 15px !important;
        font-size: 15px !important;
    }
        .custom-btn-nava:hover {
        background-color: #1F1B2D !important;
        color: white !important;
    }
        .log{
        border:none;
            background-color:white;
            width:100%;
            text-align:start;
    
        }
        .dropdown-item:focus, .dropdown-item:hover {
        color: white !important;
        background-color:#FD5631;
                
    }
        .log:hover{
        color:white;
            background-color:#FD5631;
        
        }
    </style>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: white; box-shadow:0px 4px 10px 0px rgba (0,0,0,0.25);">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="{{route('superadmin.dashboard')}}">
                 <img src="{{asset('web/images/Final Logo.svg')}}" alt="Logo" style="height:55px; width:180px" class="img-fluid">
            </a>
    
            <!-- Navbar Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
    
            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto align-items-center ">
                    <li class="nav-item">
                        <a class="nav-link p-0" href="{{route('superadmin.home')}}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link p-0" href="{{route('superadmin.cars','used')}}">Used Cars</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link p-0" href="{{route('superadmin.cars','new')}}">New Cars</a>
                    </li>
                   <!-- <li class="nav-item">
                        <a class="nav-link p-0" href="{{route('superadmin.comingsoon')}}" >
                            <img src="{{asset('web/images/bike.png')}}" alt="Bikes Icon">
                            <span> New & Used Bikes</span>
                        </a>
                    </li>  -->
    
                    <li class="nav-item">
                        @if (Route::has('login'))
    
                        @auth
    
                        <a class="nav-link p-0" href="{{ url('superadmin/dashboard') }}">Dashboard</a>
                        @else
    
                        <a class="nav-link p-0" href="{{ route('login') }}" >Sign in</a>
    
                        @endauth
    
                        @endif
    
                    </li>
    
                </ul>
                <div class="d-flex align-items-center justify-content-center">
                    <!-- Post An Ad Button -->
                    @if (Route::has('login'))
    
                    @auth
    
                    <a href="{{route('superadmin.ads.create')}}" class="btn custom-btn-nava me-2 p-0">Post
                        An Ad
                    </a>
    
    
                    <!-- <a href="#" class="btn custom-btn-nav me-2" data-bs-toggle="modal" data-bs-target="#exampleModal-3">Post
                            An Ad
                        </a> -->
    
    
                    @else
    
                    <a href="{{route('superadmin.login')}}" class="btn custom-btn-nava me-2 p-0" >Post
                        An Ad
                    </a>
    
                    @endauth
    
                    @endif
    
                    <!-- Profile Dropdown -->
                    <div class="dropdown">
                        <img class="dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown"
                            aria-expanded="false" src="{{asset('web/images/Group 2911.png')}}" alt="Bikes Icon" width="100px">
                        <ul class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                            <li class="dropdown-item p-0"> @if (Route::has('login'))
    
                                @auth
                                <a class="btn border-0 w-100 p-0 px-2 py-2 text-start" href="{{route('superadmin.dashboard')}}">My Account</a>
                            </li>
                            <li class="dropdown-item  p-0">
                            <a class="btn border-0 p-0 px-2 py-2 w-100 text-start" href="{{route('superadmin.dealer.index')}}">Manage Dealer</a>
                            </li>
                            <li class="dropdown-item p-0">
                            <a class="btn border-0 p-0 px-2 py-2 w-100 text-start" href="{{route('superadmin.ads.index')}}">Manage Ads</a>
                            </li>
                            <li class="dropdown-item p-0">
                            <a class="btn border-0 p-0 px-2 py-2 w-100 text-start" href="{{route('superadmin.subscription.index')}}">Manage Subscription</a>
                            </li>
                            <li class="dropdown-item p-0">
                            <a class="btn border-0 p-0 px-2 py-2 w-100 text-start" href="{{route('superadmin.user.index')}}">Manage User</a>
                            </li>
                            <li class="dropdown-item p-0">
                            <a class="btn border-0 p-0 px-2 py-2 w-100 text-start" href="{{route('superadmin.color.index')}}">Manage Color</a>
                            </li>
                            <li class="dropdown-item p-0">
                            <a class="btn border-0 p-0 px-2 py-2 w-100 text-start" href="{{route('superadmin.feature.index')}}">Manage Feature</a>
                            </li>
                            <li class="dropdown-item p-0">
                            <a class="btn border-0 p-0 px-2 py-2 w-100 text-start" href="{{route('superadmin.make.index')}}">Manage Make</a>
                            </li>
                            <li class="dropdown-item p-0">
                            <a class="btn border-0 p-0 px-2 py-2 w-100 text-start" href="{{route('superadmin.model.index')}}">Manage Model</a>
                            </li>
                            <li class="dropdown-item p-0">
                            <a class="btn border-0 p-0 px-2 py-2 w-100 text-start" href="{{route('superadmin.bodytype.index')}}">Manage Bodytype</a>
                            </li>
                            @else
                            <li  class="dropdown-item p-0">
                            <a class="btn w-100 text-start  border-0 p-0 py-2 ps-1 w-100 text-start" href="{{route('superadmin.login')}}">Sign In</a></li>
                            @endauth
                            @endif
                            <!-- <li><a class="dropdown-item" href="#">Logout</a></li> -->
                            <li class="dropdown-item p-0">
                                <form action="{{route('superadmin.logout')}}" method="post">
                                    @csrf
                                    <button type="submit" class="log py-2" style="width:100%">Logout</button>
    
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>