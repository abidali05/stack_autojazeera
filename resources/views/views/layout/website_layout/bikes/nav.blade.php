<style>
.nav-link {
    /* FONT-WEIGHT: 600; */
    display: block;
    padding: var(--bs-nav-link-padding-y) var(--bs-nav-link-padding-x);
    font-size: var(--bs-nav-link-font-size);
    font-weight: var(--bs-nav-link-font-weight);
    font-weight: 600 !important;
    color: var(--bs-nav-link-color);
    text-decoration: none;
    background: 0 0;
    border: 0;
    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out;
}
</style>
<nav class="navbar navbar-expand-lg ">
    <div class="container">
        <a class="navbar-brand" href="{{url('/')}}"><img src="{{asset('web/bikes/images/logo.svg')}}" class="w-75" alt="..."></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarNav">
         <ul class="navbar-nav ms-auto text-center align-items-center">
    <li class="nav-item m-0 {{ Request::is('/') ? 'active' : '' }}">
        <a href="{{ url('/') }}" class="nav-link" style="{{ Request::is('/') ? 'color: #F40000; font-weight: bold;' : '' }}">
            Cars
        </a>
    </li>

    <li class="nav-item m-0 {{ Request::is('bikes') ? 'active' : '' }}">
        <a href="{{ url('/bikes') }}" class="nav-link" style="{{ Request::is('bikes') ? 'color: #F40000; font-weight: bold;' : '' }}">
            Bikes
        </a>
    </li>

    <li class="nav-item m-0 {{ Request::is('services') ? 'active' : '' }}">
        <a href="{{ url('/services') }}" class="nav-link" style="{{ Request::is('services') ? 'color: #F40000; font-weight: bold;' : '' }}">
            Auto Services
        </a>
    </li>

    <li class="nav-item m-0 {{ Request::is('dashboard') ? 'active' : '' }}">
        @if (Route::has('login'))
            @auth
                <a href="{{ Request::is('superadmin/*') ? route('superadmin.dashboard') : url('/dashboard') }}" class="nav-link" style="{{ Request::is('dashboard') ? 'color: #F40000; font-weight: bold;' : '' }}">
                    Dashboard
                </a>
            @endauth
        @endif
    </li>
</ul>

            <ul class="navbar-nav ms-auto text-center align-items-center">

                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="{{ Request::is('superadmin/*') ? route('superadmin.advertise') : route('advertise')}}"><button
                            style="border: none; padding: 5px 15px; color: white; background-color: #D90600; border-radius: 20px;">Advertise</button></a>
                </li>
                <li class="nav-item">
                   <div class="dropdown">
                    <img class="dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown"
                        aria-expanded="false" src="{{asset('web/images/Frame 2911.svg')}}" alt="Bikes Icon" width="100px">
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
                            
                {{--        <li class="dropdown-item p-0"><a class="btn p-0 p-2 w-100 text-start" href="{{url('/ads')}}">Manage Ads</a></li> 
                        <li class="dropdown-item p-0"><a class="btn p-0 p-2 w-100 text-start" href="{{url('/subscription')}}">Manage Subscription</a></li> 
		
                        <li class="dropdown-item p-0"><a class="btn p-0 p-2 w-100 text-start" href="{{url('/lead')}}">View Lead</a></li> 
                        <li class="dropdown-item p-0"><a class="btn p-0 p-2 w-100 text-start" href="{{url('/dealer_user')}}">Manage Users</a></li> 
                        <li class="dropdown-item p-0"><a class="btn p-0 p-2 w-100 text-start" href="{{url('/personal-info')}}">Personal Info</a></li> 
                        <li class="dropdown-item p-0"><a class="btn p-0 p-2 w-100 text-start" href="{{url('/whishlist')}}">My Wishlist</a></li> 
                        <li class="dropdown-item p-0"><a class="btn p-0 p-2 w-100 text-start" href="{{url('/submitted-forms')}}">My Submitted Forms</a></li> 
						<li class="dropdown-item p-0"><a class="btn p-0 p-2 w-100 text-start" href="{{url('/price-alert')}}">My Price Alerts</a></li>
										 <li class="dropdown-item p-0"><a class="btn p-0 p-2 w-100 text-start" href="{{url('chats')}}">Chats</a></li>--}}
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
						 <span class="" style=" color:#281F48; font-weight:400">Sign in</span></li></a>
                           <a class="  text-center" style="" href="{{route('register')}}"> <li class=" ab dropdown-item py-2 d-flex justify-content-center">
						 <span class="" style="color:#281F48 ; font-weight:400"> Sign Up</span></li>         
                            @endif
                        </li></a>
                    </ul>
                </div>
            </div>
                </li>

            </ul>   
        </div>
    </div>
</nav>