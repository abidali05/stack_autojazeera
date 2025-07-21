<style>
	.dropdown-menu .dropdown-item:hover {
    background-color: #FD5631 !important;
    color: white !important;
			border-radius:5px !important;
}
	.ab{
	color: #FD5631
	}
	.ab:hover {
	color:white;
		background-color:#FD5631 !important;
		border-radius:5px !important;
	}
	
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
</style>

<nav class="navbar navbar-expand-lg navbar-light" style=" background-color:White; box-shadow:0px 4px 10px 0px rgba(0,0,0,0.25)">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{route('home')}}">
            <img src="{{asset('web/images/Final Logo.svg')}}" alt="Logo" style="height:55px; width:190px" class="img-fluid">
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
                    <a class="nav-link p-0" href="{{url('/')}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link p-0" href="{{route('cars','used')}}">Used Cars</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link p-0" href="{{route('cars','new')}}">New Cars</a>
                </li>
                <!--<li class="nav-item">
                    <a class="nav-link p-0" href="{{route('comingsoon')}}">
                        <img src="{{asset('web/images/bike.png')}}" alt="Bikes Icon">
                        <span> New & Used Bikes</span>
                    </a>
                </li>-->

                <li class="nav-item">
                    @if (Route::has('login'))

                    @auth

                    <a class="nav-link p-0" href="{{ url('/dashboard') }}">Dashboard</a>
                    @else

                   {{-- <a class="nav-link p-0" href="{{ route('login') }}">Sign in</a>--}}

                    @endauth

                    @endif

                </li>

            </ul>
            <div class="d-flex align-items-center justify-content-center">
                <!-- Post An Ad Button -->
                @if (Route::has('login'))

                @auth

                   <a @if(Auth::user()->role != "0" ) href="{{route('ads.create')}}" @else href="{{route('subscription.index')}}" @endif class="btn custom-btn-nava me-2 p-0">Post
                    An Ad
                </a>


                <!-- <a href="#" class="btn custom-btn-nav me-2 p-0" data-bs-toggle="modal" data-bs-target="#exampleModal-3">Post
                        An Ad
                    </a> -->


                @else

                <a href="{{route('login')}}" class="btn custom-btn-nava me-2 p-0" >Post
                    An Ad
                </a>

                @endauth

                @endif

                <!-- Profile Dropdown -->
                <div class="dropdown">
                    <img class="dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown"
                        aria-expanded="false" src="{{asset('web/images/Group 2911.png')}}" alt="Bikes Icon" width="100px">
                    <ul class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                       <!-- <li class="dropdown-item p-0">
                            @if (Route::has('login'))

                            @auth
                            <a class="btn" href="{{route('dashboard')}}">My Account</a>
                       
                        @else
                        <a class="btn " href="{{route('login')}}">Sign In</a>
                        
                        @endauth
                        </li>
                        @endif-->
                        @auth
                        @if (Auth::user()->role == '1')
                            
                        <li class="dropdown-item p-0"><a class="btn p-0 p-2 w-100 text-start" href="{{url('/ads')}}">Manage Ads</a></li> 
                        <li class="dropdown-item p-0"><a class="btn p-0 p-2 w-100 text-start" href="{{url('/subscription-plan')}}">Manage Subscription</a></li> 
		
                        <li class="dropdown-item p-0"><a class="btn p-0 p-2 w-100 text-start" href="{{url('/lead')}}">View Lead</a></li> 
                        <li class="dropdown-item p-0"><a class="btn p-0 p-2 w-100 text-start" href="{{url('/dealer_user')}}">Manage Users</a></li> 
                        <li class="dropdown-item p-0"><a class="btn p-0 p-2 w-100 text-start" href="{{url('/personal-info')}}">Personal Info</a></li> 
                        <li class="dropdown-item p-0"><a class="btn p-0 p-2 w-100 text-start" href="{{url('/whishlist')}}">My Wishlist</a></li> 
                        <li class="dropdown-item p-0"><a class="btn p-0 p-2 w-100 text-start" href="{{url('/submitted-forms')}}">My Submitted Forms</a></li> 
						<li class="dropdown-item p-0"><a class="btn p-0 p-2 w-100 text-start" href="{{url('/price-alert')}}">My Price Alerts</a></li>
										 <li class="dropdown-item p-0"><a class="btn p-0 p-2 w-100 text-start" href="{{url('chats')}}">Chats</a></li>
                      {{--  <li class="dropdown-item p-0"><a class="btn p-0 p-2 w-100 text-start" href="{{url('/login-security')}}">Login & Security</a></li> --}}
                        @elseif (Auth::user()->role == '0')
						<li class="dropdown-item p-0"><a class="btn p-0 p-2 w-100 text-start" href="{{url('/personal-info')}}">Personal Info</a></li> 
                        <li class="dropdown-item p-0"><a class="btn p-0 p-2 w-100 text-start" href="{{url('/whishlist')}}">My Wishlist</a></li> 
						<li class="dropdown-item p-0"><a class="btn p-0 p-2 w-100 text-start" href="{{url('/price-alert')}}">My Price Alerts</a></li>
						
                        <li class="dropdown-item p-0"><a class="btn p-0 p-2 w-100 text-start" href="{{url('/submitted-forms')}}">My Submitted Forms</a></li>
						     
						
                        @endif
                        <li class="dropdown-item p-0 " >
                            <form action="{{route('logout')}}" method="post">
                                @csrf
                                <button type="submit" class="btn w-100  p-0 p-2 text-start" style="width=100%">Logout</button>

                            </form>
                            @else
							  <a class="nav-link " style="color:#FD5631" href="{{ route('login') }}"> <li class=" ab dropdown-item py-2 d-flex justify-content-center">
						 <span class="" style=" ; font-weight:400">Sign in</span></li></a>
                           <a class="  text-center" style="color:#FD5631" href="{{route('register')}}"> <li class=" ab dropdown-item py-2 d-flex justify-content-center">
						 <span class="" style=" ; font-weight:400"> Sign Up</span></li>         
                            @endif
                        </li></a>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>