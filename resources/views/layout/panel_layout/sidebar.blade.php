<style>
    body {
        margin: 0;
        overflow-x: hidden;
    }

    #sidebar {
        position: static;
        top: 0;
        left: 0;
        width: 200px;
        height: 100vh;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        overflow-x: hidden;
        overflow-y: scroll;
		   scrollbar-color: #281F48 #f8f9fa; /* For Firefox */
 scrollbar-width: 1px;
    }

    #sidebar.closed {
        width: 60px;
    }

    #sidebar::-webkit-scrollbar {
        width: 2px;
        /* Width of the scrollbar */
    }

    #sidebar::-webkit-scrollbar-track {
        background: #281F48;
        /* Background of the scrollbar track */
    }

    #sidebar::-webkit-scrollbar-thumb {
        background-color: #281F48;
        /* Scrollbar thumb */
        border-radius: 4px;
    }

    #sidebar::-webkit-scrollbar-thumb:hover {
        background-color: #281F48;
        /* Thumb color on hover */
    }

    #sidebar a {
        display: flex;
        align-items: center;
        padding: 12px 5px;
        text-decoration: none;
        color: #281F48;
        font-size: 16px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    #sidebar a:hover {
        background-color: #e9ecef;
    }

    #sidebar a .icon {
        font-size: 20px;
        width: 30px;
        text-align: center;
    }

    #sidebar.closed a .text {
        visibility: hidden;
        opacity: 0;
        width: 0;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    #sidebar a .text {
        margin-left: 10px;
        white-space: nowrap;
        color: #002D69;
        font-size: 12px;
    }

    span {
        margin-left: 12px;
        white-space: nowrap;
        color: #002D69;
        font-size: 12px;
    }

    #main-container {
        margin-left: 200px;
        height: 100% !important;
        transition: margin-left 0.3s ease;
    }

    #main-container.sidebar-closed {
        margin-left: 60px;
    }

    .imgheightfix {
        height: 40px;
        width: 120px;
    }

    .eighteenblue {
        font-size: 16px;
        color: #000000;
        font-weight: 500;
    }

    .nesd {
        background-color: #D90600;
        color: white;
        font-size: 14px;
        font-weight: 600;
        padding: 8px 15px;
        border-radius: 20px;
    }

    .buttontoddle {
        font-size: 12px;
        padding: 5px 8px;
        border: 1px solid grey;
        border-radius: 5px;
    }

    .menu {
        color: #000000;
        font-size: 16px;
        font-family: 600;
    }

    .menus {
        color: #000000;
        font-size: 12px;
        font-family: 400;
    }

    .fourteen {
        color: #B4B3B8;
        font-size: 12px;
        font-weight: 500;
    }

    .bi::before,
    [class^="bi-"]::before,
    [class*=" bi-"]::before {
        font-size: 14px !important;
        display: inline-block;
        font-family: bootstrap-icons !important;
        font-style: normal;
        font-weight: normal !important;
        font-variant: normal;
        text-transform: none;
        line-height: 1;
        vertical-align: -0.125em;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .eighteengreyy {
        color: #B4B3B8;
        font-size: 18px;
        font-weight: 500;
    }

    .eighteenwhite {
        color: white;
        font-size: 18px;
        font-weight: 500;
    }

    .twentywhite {
        color: white;
        font-size: 20px;
        font-weight: 700;
    }

    .input-group {
        background-color: #2C2147;
        border-radius: 12px;
        padding: 5px;
        border: 1px solid #FFFFFF33;
    }

    .custom-input::placeholder {
        color: #C0BCCF;
        font-size: 14px;
    }

    .custom-input {
        color: #C0BCCF !important;
        font-size: 14px;
    }

    .faqsanker {
        font-size: 16px;
        color: #281F48;
        font-weight: 500;
        text-decoration: underline;
    }

    /* Media Queries */
    @media (max-width: 430px) {
        #main-container {
            margin-left: 0;


        }

        .thispos {
            position: absolute;
            z-index: 999;
            width: 100%;
        }

        #main-container.sidebar-closed {
            margin-left: 0;
        }

        #sidebar {
            position: absolute;
            width: 100%;
            z-index: 998;
        }

        #sidebar.closed {
            width: 0;
        }

        #sidebar.open {
            width: 250px;
            height: 100%;
        }
    }

    @media (min-width: 431px) {
        #main-container.sidebar-closed {
            margin-left: 0px;
        }

        #sidebar {
            position: fixed;
        }
    }

    .nav-link.active,
    #sidebar a.active {
        background-color: #007bff;
        color: #fff;
    }

    a {
        text-decoration: none;
    }



    #sidebar .active {
        background-color: #f8f9fa;
        color: white !important;
        background-color: #281f4825 !important;
        font-weight: 500;
        border-radius: 4px;
    }

    #sidebar .nav-link.active,
    #sidebar .nav-link.active:hover,
    #sidebar .nav-link.active:focus {
        color: white !important;
    }
</style>



@if (Auth::user()->role == '0')
    <!-- Sidebar -->
    <div id="sidebar">
        <a id="sidebarLogo" class="navbar-brand d-flex justify-content-center " href="{{ route('dashboard') }}">
            <img src="{{ asset('web/images/Frame 1171275409.svg') }}" class="imgheightfix" alt="...">
        </a>
        <a href="{{ route('dashboard') }}"
            class="mt-3 d-flex align-items-baseline @if (request()->routeIs('dashboard')) active @endif">
            <span class="icon"><img src="{{ asset('web/images/Icon (1).svg') }}"
                    style="height:25px !important ; width:25px !important; " alt="..."></span>
            <span class="text" style="   font-size: 12px;">Dashboard</span>
        </a>

        @if (!Auth::user()->shop_package)
            <!-- Subscription -->
            <a class="nav-link d-flex justify-content-between align-items-center @if (Request::is('subscription') || Request::is('subscription-history') || Request::is('service-subscription-history')) active @endif"
                data-bs-toggle="collapse" href="#Subscription" role="button"
                aria-expanded="{{ Request::is('subscription') || Request::is('subscription-history') ? 'true' : 'false' }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/subscription.svg') }}"
                        style="height:20px !important ; width:20px !important;" class="me-2" alt="...">
                    Subscription
                </span>
                <i class="bi bi-chevron-compact-down toggle-icon"></i>
            </a>
            <div class="collapse ps-4 {{ Request::is('subscription') || Request::is('subscription-history') ? 'show' : '' }}"
                id="Subscription">
                <a class="nav-link {{ Request::is('subscription') ? 'active' : '' }}" href="{{ url('subscription') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/subscriptionplan.svg') }}"
                            style="height:20px !important ; width:20px !important;" class="me-2" alt="...">
                        Plans
                    </span>
                </a>
                <a class="nav-link {{ Request::is('subscription-history') ? 'active' : '' }}"
                    href="{{ url('subscription-history') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/subhistory.svg') }}"
                            style="height:20px !important ; width:20px !important;" class="me-2" alt="...">
                        History
                    </span>
                </a>
                {{-- <a class="nav-link {{ Request::is('service-subscription-history') ? 'active' : '' }}"
                    href="{{ url('subscription-history') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/subhistory.svg') }}"
                            style="height:20px !important ; width:20px !important;" class="me-2" alt="...">
                        History
                    </span>
                </a> --}}
            </div>
        @endif



        <!-- submitted Leads -->
        <a class="nav-link d-flex justify-content-between align-items-center @if (Request::is('submitted-forms') || Request::is('submitted-bike-leads') || Request::is('service-quotes')) active @endif"
            data-bs-toggle="collapse" href="#Submitted" role="button"
            aria-expanded="{{ Request::is('submitted-forms') || Request::is('submitted-bike-leads') || Request::is('service-quotes') ? 'true' : 'false' }}"
            aria-controls="Submitted">
            <span class="d-flex align-items-center">
                <img src="{{ asset('web/images/submitedfrms.svg') }}"
                    style="height:20px !important ; width:20px !important; " class=" me-2" alt="...">
                <span class="m-0" style="font-size: 12px;">Submitted Leads</span>
            </span>
            <i class="bi bi-chevron-compact-down toggle-icon"></i>
        </a>

        <!-- Collapsed Menu -->
        <div class="collapse ps-4 {{ Request::is('submitted-forms') || Request::is('submitted-bike-leads') || Request::is('service-quotes') ? 'show' : '' }}"
            id="Submitted">
            <a class="nav-link {{ Request::is('submitted-forms') ? 'active' : '' }}"
                href="{{ url('submitted-forms') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/car1.svg') }}"
                        style="height:20px !important ; width:20px !important; " style="height: 20px; width: 20px"
                        class="me-2" alt="...">
                    Car
                </span>
            </a>
            <a class="nav-link {{ Request::is('submitted-bike-leads') ? 'active' : '' }}"
                href="{{ url('submitted-bike-leads') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/Vector (2).svg') }}"
                        style="height:20px !important ; width:20px !important; " style="height: 20px; width: 20px"
                        class="me-2" alt="...">
                    Bike
                </span>
            </a>
            @if (!Auth::user()->shop_package)
                {{-- <a class="nav-link {{ Request::is('service-quotes') ? 'active' : '' }}"
                    href="{{ url('service-quotes') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/submitedfrms.svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2"
                            alt="...">Service
                    </span>
                </a> --}}
                 <a href="javascript:void(0);" id="serviceQuotesBtn" class="nav-link">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/submitedfrms.svg') }}" class="me-2"
                            style="height:20px; width:20px;" alt="...">
                        Service
                    </span>
                </a>
            @endif
        </div>

        <!-- price alert  -->
        <a class="nav-link d-flex justify-content-between align-items-center @if (Request::is('price-alert') || Request::is('bike/price-alert')) active @endif"
            data-bs-toggle="collapse" href="#price" role="button"
            aria-expanded="{{ Request::is('price-alert') || Request::is('bike/price-alert') ? 'true' : 'false' }}"
            aria-controls="price">
            <span class="d-flex align-items-center">
                <img src="{{ asset('web/images/pricealert2.svg') }}" class="img-fluid me-2"
                    style="height:20px !important ; width:20px !important; " alt="...">
                <span class="m-0" style="font-size: 12px;">Price alert</span>
            </span>
            <i class="bi bi-chevron-compact-down toggle-icon"></i>
        </a>

        <!-- Collapsed Menu -->
        <div class="collapse ps-4 {{ Request::is('price-alert') || Request::is('bike/price-alert') ? 'show' : '' }}"
            id="price">
            <a class="nav-link {{ Request::is('price-alert') ? 'active' : '' }}" href="{{ url('price-alert') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/car1.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                    Car price alert
                </span>
            </a>
            <a class="nav-link {{ Request::is('bike/price-alert') ? 'active' : '' }}"
                href="{{ url('bike/price-alert') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/Vector (2).svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                    Bike price alert
                </span>
            </a>
        </div>




        <!-- Chats -->
        <a class="nav-link {{ Request::is('chats') ? 'active' : '' }}" href="{{ url('chats') }}">
            <span class="d-flex align-items-center">
                <img src="{{ asset('web/images/chats.svg') }}"
                    style="height:20px !important ; width:20px !important; " class="me-2" alt="..."> Chats
            </span>
        </a>
        @if (!Auth::user()->shop_package)
            <a class="nav-link {{ Request::is('service-chats') ? 'active' : '' }}"
                href="{{ url('service-chats') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/chats.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                    Service
                    Chats
                </span>
            </a>
        @endif





        <a class="nav-link d-flex justify-content-between align-items-center @if (Request::is('whishlist') || Request::is('bike/wishlist') || Request::is('shops/wishlist')) active @endif"
            data-bs-toggle="collapse" href="#Wishlist" role="button"
            aria-expanded="{{ Request::is('whishlist') || Request::is('bike/wishlist') || Request::is('shops/wishlist') ? 'true' : 'false' }}"
            aria-controls="Wishlist">
            <span class="d-flex align-items-center">
                <img src="{{ asset('web/images/wishlist1.svg') }}"
                    style="height:20px !important ; width:20px !important; " class="img-fluid me-2" alt="...">
                <span class="m-0" style="font-size: 12px;">Wishlist</span>
            </span>
            <i class="bi bi-chevron-compact-down toggle-icon"></i>
        </a>

        <!-- Collapsed Menu -->
        <div class="collapse ps-4 {{ Request::is('whishlist') || Request::is('bike/wishlist') || Request::is('shops/wishlist') ? 'show' : '' }}"
            id="Wishlist">
            <a class="nav-link {{ Request::is('whishlist') ? 'active' : '' }}" href="{{ url('whishlist') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/car1.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                    Car
                </span>
            </a>
            <a class="nav-link {{ Request::is('bike/wishlist') ? 'active' : '' }}"
                href="{{ url('bike/wishlist') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/Vector (2).svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                    Bike
                </span>
            </a>
            @if (!Auth::user()->shop_package)
                <a class="nav-link {{ Request::is('shops/wishlist') ? 'active' : '' }}"
                    href="{{ url('shops/wishlist') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/wishlist1.svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                        Service Wishlist
                    </span>
                </a>
            @endif
        </div>


        <!-- Manage System Main Toggle -->
        <a class="nav-link d-flex justify-content-between align-items-center {{ Auth::user()->shop_package ? '' : 'd-none' }} @if (Request::is('shop') || Request::is('shop/create') || Request::is('shop/edit') ||
                Request::is('subscription') ||
                Request::is('subscription-history') ||
                Request::is('service-quotes') ||
                Request::is('submitted-service-quotes') ||
                Request::is('service-chats') ||
                Request::is('shops/wishlist') ||
                Request::is('service/users')) active @endif"
            data-bs-toggle="collapse" href="#Systemee" role="button"
            aria-expanded="{{ Request::is('shop') || Request::is('shop/create') || Request::is('shop/edit') || Request::is('subscription') || Request::is('subscription-history') || Request::is('service-quotes') || Request::is('submitted-service-quotes') || Request::is('service-chats') || Request::is('shops/wishlist') || Request::is('service/users') ? 'true' : 'false' }}"
            aria-controls="Systemee">
            <span class="d-flex align-items-center">
                <img src="{{ asset('web/images/Shop.svg') }}"
                    style="height:25px !important ; width:25px !important; " class="" alt="...">
                <span style="font-size: 12px;">Manage Shop</span>
            </span>
            <i class="bi bi-chevron-compact-down toggle-icon"></i>
        </a>

        <!-- First Level Collapse: Manage Shop -->
        <div class="collapse ps-3 {{ Request::is('shop') || Request::is('shop/create') || Request::is('shop/edit') || Request::is('subscription') || Request::is('subscription-history') || Request::is('service-quotes') || Request::is('submitted-service-quotes') || Request::is('service-chats') || Request::is('shops/wishlist') || Request::is('service/users') ? 'show' : '' }} {{ Auth::user()->shop_package ? '' : 'd-none' }}"
            id="Systemee">

            <a class="nav-link {{ Request::is('shop') || Request::is('shop/create') || Request::is('shop/edit') ? 'active' : '' }}" href="{{ url('shop') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/Mask group.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="..."> Ad
                </span>
            </a>

            <!-- Subscription (nested collapse) -->
            <a class="nav-link d-flex justify-content-between align-items-center @if (Request::is('subscription-history')) active @endif"
                data-bs-toggle="collapse" href="#Subscription" role="button"
                aria-expanded="{{ Request::is('subscription-history') ? 'true' : 'false' }}"
                aria-controls="Subscription">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/subscription.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                    Subscription
                </span>
                <i class="bi bi-chevron-compact-down toggle-icon"></i>
            </a>

            <!-- Subscription Items -->
            <div class="collapse ps-4 {{  Request::is('subscription-history') ? 'show' : '' }}"
                id="Subscription">
                <a class="nav-link {{ Request::is('subscription') ? 'active' : '' }}"
                    href="{{ url('subscription') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/subscriptionplan.svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                        Plans
                    </span>
                </a>
                <a class="nav-link {{ Request::is('service-subscription-history') ? 'active' : '' }}"
                    href="{{ url('service-subscription-history') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/subhistory.svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                        History
                    </span>
                </a>
            </div>

            <!-- Leads -->
            <a class="nav-link {{ Request::is('service-quotes') ? 'active' : '' }}"
                href="{{ url('service-quotes') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/customer.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="..."> Leads
                </span>
            </a>

            <!-- Submitted Leads -->
            <a class="nav-link {{ Request::is('submitted-service-quotes') ? 'active' : '' }}"
                href="{{ url('submitted-service-quotes') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/submitedfrms.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2"
                        alt="...">Submitted Leads
                </span>
            </a>

            <!-- Chats -->
            <a class="nav-link {{ Request::is('service-chats') ? 'active' : '' }}"
                href="{{ url('service-chats') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/chats.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="..."> Chats
                </span>
            </a>

            <a class="nav-link {{ Request::is('shops/wishlist') ? 'active' : '' }}"
                href="{{ url('shops/wishlist') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/wishlist1.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                    Wishlist
                </span>
            </a>

            <!-- Users -->
            @if (Auth::user()->shop_package != null && Auth::user()->shop_pkg->metadata->users_allowed == '1')
                <a class="nav-link {{ Request::is('service/users') ? 'active' : '' }}"
                    href="{{ url('service/users') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/manageemployee.svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                        Users
                    </span>
                </a>
            @endif
        </div>





        <a href="{{ url('personal-info') }}" class="{{ Request::is('personal-info') ? 'active' : '' }}">
            <span class="icon d-flex align-items-baseline">
                <img src="{{ asset('web/images/Icon (Stroke).svg') }}"
                    style="height:25px !important ; width:25px !important;" class="" alt="...">
            </span>
            <span class="text m-0 ms-2" style="font-size: 12px;">User Profile</span>
        </a>




        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-link text-decoration-none d-flex align-items-center">
                <span class="icon m-0 d-flex align-items-baseline"><img src="{{ asset('web/images/logout.svg') }}"
                        style="height:25px !important ; width:25px !important; " class=""
                        alt="..."></span>
                <span class="text m-0 ms-3" style="   font-size: 12px;font-weight:500 !important ">Logout</span>
            </button>

        </form>



    </div>
@endif

@if (Auth::user()->role == '1')
    <!-- Sidebar -->
    <div id="sidebar">
        <a id="sidebarLogo" class="navbar-brand d-flex justify-content-center" href="{{ route('dashboard') }}">
            <img src="{{ asset('web/images/Frame 1171275409.svg') }}" class="imgheightfix" alt="...">
        </a>

        <!-- Dashboard Link -->
        <a href="{{ route('dashboard') }}"
            class="mt-3 d-flex align-items-baseline @if (request()->routeIs('dashboard')) active @endif">
            <span class="icon"><img src="{{ asset('web/images/Icon (1).svg') }}"
                    style="height:25px !important ; width:25px !important; " alt="..."></span>
            <span class="text" style="font-size: 12px;">Dashboard</span>
        </a>

        @php
            // Define all routes that should make Manage Dealership active
            $manageDealershipRoutes = [
                'dealership-information',
                'ads',
                'ads/*',
                'bike/ads',
                'bike/ads/*',
                'subscription',
                'subscription/*',
                'subscription-history',
        
                'lead',
                'lead/*',
                'leads/bikes',
                'leads/bikes/*',
                'get-price-alerts',
                'submitted-forms',
                'submitted-bike-leads',
                'submitted-service-quotes',
                'price-alert',
                'price-alert/*',
                'bike/price-alert',
                'bike/price-alert/*',
                'chats',
                'service-chats',
                'whishlist',
                'bike/wishlist',
                'shops/wishlist',
                'dealer_user',
            ];

            $isManageSystemActive = request()->is($manageDealershipRoutes);

            // Check specific submenu states
            $isAdsActive = request()->is(['ads', 'ads/*', 'bike/ads', 'bike/ads/*']);
            $isSubscriptionActive = request()->is(['subscription', 'subscription/*', 'subscription-history']);
            $isLeadsActive = request()->is(['lead', 'lead/*', 'leads/bikes', 'leads/bikes/*', 'get-price-alerts']);
            $isSubmittedLeadsActive = request()->is([
                'submitted-forms',
                'submitted-bike-leads',
                'submitted-service-quotes',
            ]);
            $isPriceAlertActive = request()->is([
                'price-alert',
                'price-alert/*',
                'bike/price-alert',
                'bike/price-alert/*',
            ]);
            $isWishlistActive = request()->is(['whishlist', 'bike/wishlist', 'shops/wishlist']);

            // Define routes for Manage Shop
            $manageShopRoutes = [
                'shop',
                'shop/create',
                'shop/edit',
                'service-quotes',
                'submitted-service-quotes',
                'service-chats',
                'shops/wishlist',
                'service/users',
            ];

            $isManageShopActive = request()->is($manageShopRoutes);
        @endphp

        <!-- Manage Dealership/My Account Main Toggle -->
        <a class="nav-link d-flex justify-content-between align-items-center {{ $isManageSystemActive ? 'active' : '' }}"
            data-bs-toggle="collapse" href="#System" role="button"
            aria-expanded="{{ $isManageSystemActive ? 'true' : 'false' }}" aria-controls="System">
            <span class="d-flex align-items-center">
                <img src="{{ asset('web/images/dealership 1.svg') }}"
                    style="height:25px !important; width:25px !important;" class="" alt="...">
                <span style="font-size: 12px;">
                    {{ Auth::user()->userType == 'private_seller' ? 'My Account' : 'Manage Dealership' }}
                </span>
            </span>
            <i class="bi bi-chevron-compact-down toggle-icon"></i>
        </a>

        <!-- Manage Dealership Submenu -->
        <div class="collapse ps-3 {{ $isManageSystemActive ? 'show' : '' }}" id="System">

            <!-- Dealership Details -->
            <a class="nav-link {{ Auth::user()->userType == 'private_seller' ? 'd-none' : '' }} {{ request()->is('dealership-information') ? 'active' : '' }}"
                href="{{ url('dealership-information') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/Icon (Stroke).svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                    Dealership Details
                </span>
            </a>

            <!-- Ads Submenu -->
            <a class="nav-link d-flex justify-content-between align-items-center {{ $isAdsActive ? 'active' : '' }}"
                data-bs-toggle="collapse" href="#bikeSubmenu" role="button"
                aria-expanded="{{ $isAdsActive ? 'true' : 'false' }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/Mask group.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="..."> Ads
                </span>
                <i class="bi bi-chevron-compact-down toggle-icon"></i>
            </a>
            <div class="collapse ps-4 {{ $isAdsActive ? 'show' : '' }}" id="bikeSubmenu">
                <a class="nav-link {{ request()->is(['ads', 'ads/*']) ? 'active' : '' }}"
                    href="{{ url('ads') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/car1.svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                        Car ads
                    </span>
                </a>
                <a class="nav-link {{ request()->is(['bike/ads', 'bike/ads/*']) ? 'active' : '' }}"
                    href="{{ url('bike/ads') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/Vector (2).svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                        Bike ads
                    </span>
                </a>
            </div>

            <!-- Subscription Submenu -->
            <a class="nav-link d-flex justify-content-between align-items-center {{ $isSubscriptionActive ? 'active' : '' }}"
                data-bs-toggle="collapse" href="#Subscription" role="button"
                aria-expanded="{{ $isSubscriptionActive ? 'true' : 'false' }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/subscription.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                    Subscription
                </span>
                <i class="bi bi-chevron-compact-down toggle-icon"></i>
            </a>
            <div class="collapse ps-4 {{ $isSubscriptionActive ? 'show' : '' }}" id="Subscription">
                <a class="nav-link {{ request()->is(['subscription', 'subscription/*']) ? 'active' : '' }}"
                    href="{{ url('subscription') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/subscriptionplan.svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                        Plans
                    </span>
                </a>
                <a class="nav-link {{ request()->is('subscription-history') ? 'active' : '' }}"
                    href="{{ url('subscription-history') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/subhistory.svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                       Ad History
                    </span>
                </a>
              {{-- <a class="nav-link {{ request()->is('service-subscription-history') ? 'active' : '' }}"
                    href="{{ url('service-subscription-history') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/subhistory.svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                        History
                    </span>
                </a>  --}}
            </div>

            <!-- Leads Submenu -->
            <a class="nav-link d-flex justify-content-between align-items-center {{ $isLeadsActive ? 'active' : '' }}"
                data-bs-toggle="collapse" href="#busSubmenu" role="button"
                aria-expanded="{{ $isLeadsActive ? 'true' : 'false' }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/customer.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="..."> Leads
                </span>
                <i class="bi bi-chevron-compact-down toggle-icon"></i>
            </a>
            <div class="collapse ps-4 {{ $isLeadsActive ? 'show' : '' }}" id="busSubmenu">
                <a class="nav-link {{ request()->is(['lead', 'lead/*']) ? 'active' : '' }}"
                    href="{{ url('lead') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/car1.svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                        Car Leads
                    </span>
                </a>
                <a class="nav-link {{ request()->is(['leads/bikes', 'leads/bikes/*']) ? 'active' : '' }}"
                    href="{{ url('leads/bikes') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/Vector (2).svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                        Bike Leads
                    </span>
                </a>
                <a class="nav-link {{ request()->is('get-price-alerts') ? 'active' : '' }}"
                    href="{{ url('get-price-alerts') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/lead.svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                        Price Alert
                    </span>
                </a>
            </div>

            <!-- Submitted Leads Submenu -->
            <a class="nav-link d-flex justify-content-between align-items-center {{ $isSubmittedLeadsActive ? 'active' : '' }}"
                data-bs-toggle="collapse" href="#Submitted" role="button"
                aria-expanded="{{ $isSubmittedLeadsActive ? 'true' : 'false' }}" aria-controls="Submitted">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/submitedfrms.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                    <span class="m-0" style="font-size: 12px;">Submitted Leads</span>
                </span>
                <i class="bi bi-chevron-compact-down toggle-icon"></i>
            </a>
            <div class="collapse ps-4 {{ $isSubmittedLeadsActive ? 'show' : '' }}" id="Submitted">
                <a class="nav-link {{ request()->is('submitted-forms') ? 'active' : '' }}"
                    href="{{ url('submitted-forms') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/car1.svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                        Car
                    </span>
                </a>
                <a class="nav-link {{ request()->is('submitted-bike-leads') ? 'active' : '' }}"
                    href="{{ url('submitted-bike-leads') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/Vector (2).svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                        Bike
                    </span>
                </a>
                @if (!Auth::user()->shop_package)
                    <a class="nav-link {{ request()->is('submitted-service-quotes') ? 'active' : '' }}"
                        href="{{ url('submitted-service-quotes') }}">
                        <span class="d-flex align-items-center">
                            <img src="{{ asset('web/images/submitedfrms.svg') }}"
                                style="height:20px !important ; width:20px !important; " class="me-2"
                                alt="...">Service Leads
                        </span>
                    </a>
                @endif
            </div>

            <!-- Price Alert Submenu -->
            <a class="nav-link d-flex justify-content-between align-items-center {{ $isPriceAlertActive ? 'active' : '' }}"
                data-bs-toggle="collapse" href="#price" role="button"
                aria-expanded="{{ $isPriceAlertActive ? 'true' : 'false' }}" aria-controls="price">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/pricealert2.svg') }}" class="img-fluid me-2"
                        style="height:20px !important ; width:20px !important; " alt="...">
                    <span class="m-0" style="font-size: 12px;">Price alert</span>
                </span>
                <i class="bi bi-chevron-compact-down toggle-icon"></i>
            </a>
            <div class="collapse ps-4 {{ $isPriceAlertActive ? 'show' : '' }}" id="price">
                <a class="nav-link {{ request()->is(['price-alert', 'price-alert/*']) ? 'active' : '' }}"
                    href="{{ url('price-alert') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/car1.svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                        Car price alert
                    </span>
                </a>
                <a class="nav-link {{ request()->is(['bike/price-alert', 'bike/price-alert/*']) ? 'active' : '' }}"
                    href="{{ url('bike/price-alert') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/Vector (2).svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                        Bike price alert
                    </span>
                </a>
            </div>

            <!-- Chats -->
            <a class="nav-link {{ request()->is('chats') ? 'active' : '' }}" href="{{ url('chats') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/chats.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="..."> Chats
                </span>
            </a>

            @if (!Auth::user()->shop_package)
                <!-- Service Chats -->
                <a class="nav-link {{ request()->is('service-chats') ? 'active' : '' }}"
                    href="{{ url('service-chats') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/chats.svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                        Service Chats
                    </span>
                </a>
            @endif

            <!-- Wishlist Submenu -->
            <a class="nav-link d-flex justify-content-between align-items-center {{ $isWishlistActive ? 'active' : '' }}"
                data-bs-toggle="collapse" href="#Wishlist" role="button"
                aria-expanded="{{ $isWishlistActive ? 'true' : 'false' }}" aria-controls="Wishlist">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/wishlist1.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="img-fluid me-2"
                        alt="...">
                    <span class="m-0" style="font-size: 12px;">Wishlist</span>
                </span>
                <i class="bi bi-chevron-compact-down toggle-icon"></i>
            </a>
            <div class="collapse ps-4 {{ $isWishlistActive ? 'show' : '' }}" id="Wishlist">
                <a class="nav-link {{ request()->is('whishlist') ? 'active' : '' }}"
                    href="{{ url('whishlist') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/car1.svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                        Car
                    </span>
                </a>
                <a class="nav-link {{ request()->is('bike/wishlist') ? 'active' : '' }}"
                    href="{{ url('bike/wishlist') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/Vector (2).svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                        Bike
                    </span>
                </a>
                @if (!Auth::user()->shop_package)
                    <a class="nav-link {{ request()->is('shops/wishlist') ? 'active' : '' }}"
                        href="{{ url('shops/wishlist') }}">
                        <span class="d-flex align-items-center">
                            <img src="{{ asset('web/images/wishlist1.svg') }}"
                                style="height:20px !important ; width:20px !important; " class="me-2"
                                alt="...">
                            Service
                        </span>
                    </a>
                @endif
            </div>

            <!-- Users -->
            <a class="nav-link {{ Auth::user()->userType == 'private_seller' ? 'd-none' : '' }} {{ request()->is('dealer_user') ? 'active' : '' }}"
                href="{{ url('dealer_user') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/manageemployee.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="..."> Users
                </span>
            </a>
        </div>

        <!-- Manage Shop Main Toggle -->
        <a class="nav-link d-flex justify-content-between align-items-center {{ Auth::user()->shop_package ? '' : 'd-none' }} {{ $isManageShopActive ? 'active' : '' }}"
            data-bs-toggle="collapse" href="#Systemee" role="button"
            aria-expanded="{{ $isManageShopActive ? 'true' : 'false' }}" aria-controls="Systemee">
            <span class="d-flex align-items-center">
                <img src="{{ asset('web/images/Shop.svg') }}"
                    style="height:25px !important ; width:25px !important; " class="" alt="...">
                <span style="font-size: 12px;">Manage Shop</span>
            </span>
            <i class="bi bi-chevron-compact-down toggle-icon"></i>
        </a>

        <!-- Manage Shop Submenu -->
        <div class="collapse ps-3 {{ Auth::user()->shop_package ? '' : 'd-none' }} {{ $isManageShopActive ? 'show' : '' }}"
            id="Systemee">
            <a class="nav-link {{ request()->is('shop') || request()->is('shop/create') || request()->is('shop/edit') ? 'active' : '' }}" href="{{ url('shop') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/Mask group.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="..."> Ad
                </span>
            </a>

            <!-- Shop Subscription (Note: This uses same ID as main subscription - you may want to change this) -->
            <a class="nav-link d-flex justify-content-between align-items-center {{ $isSubscriptionActive ? 'active' : '' }}"
                data-bs-toggle="collapse" href="#ShopSubscription" role="button"
                aria-expanded="{{ $isSubscriptionActive ? 'true' : 'false' }}" aria-controls="ShopSubscription">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/subscription.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                    Subscription
                </span>
                <i class="bi bi-chevron-compact-down toggle-icon"></i>
            </a>
            <div class="collapse ps-4 {{ $isSubscriptionActive ? 'show' : '' }}" id="ShopSubscription">
                <a class="nav-link {{ request()->is(['subscription', 'subscription/*']) ? 'active' : '' }}"
                    href="{{ url('subscription') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/subscriptionplan.svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                        Plans
                    </span>
                </a>
                {{-- <a class="nav-link {{ request()->is('subscription-history') ? 'active' : '' }}"
                    href="{{ url('subscription-history') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/subhistory.svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                        History
                    </span>
                </a> --}}
                <a class="nav-link {{ request()->is('service-subscription-history') ? 'active' : '' }}"
                    href="{{ url('service-subscription-history') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/subhistory.svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                       Service History
                    </span>
                </a>
            </div>

            <!-- Shop Leads -->
            <a class="nav-link {{ request()->is('service-quotes') ? 'active' : '' }}"
                href="{{ url('service-quotes') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/customer.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="..."> Leads
                </span>
            </a>

            <!-- Shop Submitted Leads -->
            <a class="nav-link {{ request()->is('submitted-service-quotes') ? 'active' : '' }}"
                href="{{ url('submitted-service-quotes') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/submitedfrms.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2"
                        alt="...">Submitted Leads
                </span>
            </a>

            <!-- Shop Chats -->
            <a class="nav-link {{ request()->is('service-chats') ? 'active' : '' }}"
                href="{{ url('service-chats') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/chats.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="..."> Chats
                </span>
            </a>

            <!-- Shop Wishlist -->
            <a class="nav-link {{ request()->is('shops/wishlist') ? 'active' : '' }}"
                href="{{ url('shops/wishlist') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/wishlist1.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                    Wishlist
                </span>
            </a>

            <!-- Shop Users -->
            @if (Auth::user()->shop_package != null && Auth::user()->shop_pkg->metadata?->users_allowed == '1')
                <a class="nav-link {{ request()->is('service/users') ? 'active' : '' }}"
                    href="{{ url('service/users') }}">
                    <span class="d-flex align-items-center">
                        <img src="{{ asset('web/images/manageemployee.svg') }}"
                            style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                        Users
                    </span>
                </a>
            @endif
        </div>

        <!-- User Profile -->
        <a href="{{ url('personal-info') }}" class="{{ request()->is('personal-info') ? 'active' : '' }}">
            <span class="icon d-flex align-items-baseline"><img src="{{ asset('web/images/Icon (Stroke).svg') }}"
                    style="height:25px !important ; width:25px !important; " class="" alt="..."></span>
            <span class="text m-0 ms-2" style="font-size: 12px;">User Profile</span>
        </a>

        <!-- Logout -->
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-link text-decoration-none d-flex align-items-center">
                <span class="icon m-0 d-flex align-items-baseline"><img src="{{ asset('web/images/logout.svg') }}"
                        style="height:25px !important ; width:25px !important; " class=""
                        alt="..."></span>
                <span class="text m-0 ms-3" style="font-size: 12px;font-weight:500 !important ">Logout</span>
            </button>
        </form>
    </div>
@endif

@if (Auth::user()->role == '2')
    @php

        $userPermissions = \App\Models\UserPermission::where('user_id', Auth::user()->id)
            ->pluck('permissions')
            ->toArray();
    @endphp


    <!-- Main Link -->

    <!-- Sidebar -->
    <div id="sidebar">
        <a id="sidebarLogo" class="navbar-brand d-flex justify-content-center" href="{{ route('dashboard') }}">
            <img src="{{ asset('web/images/Frame 1171275409.svg') }}" class="imgheightfix" alt="...">
        </a>
        <a href="{{ route('dashboard') }}" class="mt-3 d-flex align-items-baseline @if (request()->routeIs('dashboard')) active @endif">
            <span class="icon"><img src="{{ asset('web/images/Icon (1).svg') }}"
                    style="height:25px !important ; width:25px !important; " alt="..."></span>
            <span class="text" style="   font-size: 12px;">Dashboard</span>
        </a>




@php
     $isAdsActive = request()->is(['ads/create', 'bike/ads/create']);
@endphp
        {{-- post ad start  --}}
        <a class="nav-link d-flex justify-content-between align-items-center {{ in_array('post_ads', $userPermissions) ? '' : 'd-none' }}  {{ $isAdsActive ? 'active' : '' }} "
            data-bs-toggle="collapse" href="#bikeSubmenuqq" role="button" aria-expanded="false">
            <span class="d-flex align-items-center">
                <img src="{{ asset('web/images/Mask group.svg') }}"
                    style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                Post An Ad
            </span>
            <i class="bi bi-chevron-compact-down toggle-icon"></i>
        </a>
        <div class="collapse ps-4 {{ in_array('post_ads', $userPermissions) ? '' : 'd-none' }}  {{ $isAdsActive ? 'show' : '' }}
            " id="bikeSubmenuqq">
            <a class="nav-link {{ request()->is('ads/create') ? 'active' : '' }}" href="{{ url('ads/create') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/car1.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                    Car ads
                </span>
            </a>
            <a class="nav-link {{ request()->is('bike/ads/create') ? 'active' : '' }}" href="{{ url('bike/ads/create') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/Vector (2).svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                    Bike ads
                </span>
            </a>
        </div>
        {{-- post ad end --}}



@php
     $isManageAdsActive = request()->is(['ads', 'bike/ads']);
@endphp



        <a class="nav-link d-flex justify-content-between align-items-center {{ in_array('manage_ads', $userPermissions) ? '' : 'd-none' }} {{ $isManageAdsActive ? 'active' : '' }}"
            data-bs-toggle="collapse" href="#bikeSubmenu" role="button" aria-expanded="false">
            <span class="d-flex align-items-center">
                <img src="{{ asset('web/images/Mask group.svg') }}"
                    style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                Ads
            </span>
            <i class="bi bi-chevron-compact-down toggle-icon"></i>
        </a>
        <div class="collapse ps-4 {{ in_array('manage_ads', $userPermissions) ? '' : 'd-none' }} {{ $isManageAdsActive ? 'show' : '' }}
            " id="bikeSubmenu">
            <a class="nav-link {{ request()->is('ads') ? 'active' : '' }}" href="{{ url('ads') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/car1.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                    Car ads
                </span>
            </a>
            <a class="nav-link {{ request()->is('bike/ads') ? 'active' : '' }}" href="{{ url('bike/ads') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/Vector (2).svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                    Bike ads
                </span>
            </a>
        </div>

@php
     $isLeadsActive = request()->is(['lead', 'leads/bikes','get-price-alerts']);
@endphp

        <!-- Leads -->
        <a class="nav-link d-flex justify-content-between align-items-center {{ in_array('view_leads', $userPermissions) ? '' : 'd-none' }} {{ $isLeadsActive ? 'active' : '' }}"
            data-bs-toggle="collapse" href="#busSubmenu" role="button" aria-expanded="false">
            <span class="d-flex align-items-center">
                <img src="{{ asset('web/images/customer.svg') }}"
                    style="height:20px !important ; width:20px !important; " class="me-2" alt="..."> Leads
            </span>
            <i class="bi bi-chevron-compact-down toggle-icon"></i>
        </a>
        <div class="collapse ps-4 {{ in_array('view_leads', $userPermissions) ? '' : 'd-none' }} {{ $isLeadsActive ? 'show' : '' }}
            " id="busSubmenu">
            <a class="nav-link {{ request()->is('lead') ? 'active' : '' }}" href="{{ url('lead') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/car1.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                    Car Leads
                </span>
            </a>
            <a class="nav-link {{ request()->is('leads/bikes') ? 'active' : '' }}"  href="{{ url('leads/bikes') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/Vector (2).svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                    Bike Leads
                </span>
            </a>
            <a class="nav-link {{ request()->is('get-price-alerts') ? 'active' : '' }}" href="{{ url('get-price-alerts') }}">
                <span class="d-flex align-items-center">
                    <img src="{{ asset('web/images/lead.svg') }}"
                        style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                    Price Alert
                </span>
            </a>
        </div>



        <a href="{{ url('personal-info') }}" class="{{ request()->is('personal-info') ? 'active' : '' }}">
            <span class="icon d-flex align-items-baseline"><img src="{{ asset('web/images/Icon (Stroke).svg') }}"
                    style="height:25px !important ; width:25px !important; " class="" alt="..."></span>
            <span class="text m-0 ms-2" style="   font-size: 12px;">User Profile</span>
        </a>



        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-link text-decoration-none d-flex align-items-center">
                <span class="icon m-0 d-flex align-items-baseline"><img src="{{ asset('web/images/logout.svg') }}"
                        style="height:25px !important ; width:25px !important; " class=""
                        alt="..."></span>
                <span class="text m-0 ms-3" style="   font-size: 12px;font-weight:500 !important ">Logout</span>
            </button>

        </form>



    </div>
@endif

@if (Auth::user()->role == '3')
    <!-- Sidebar -->
    <div id="sidebar">
        <a id="sidebarLogo" class="navbar-brand d-flex justify-content-center" href="{{ route('dashboard') }}">
            <img src="{{ asset('web/images/Frame 1171275409.svg') }}" class="imgheightfix" alt="...">
        </a>
        <a href="{{ route('dashboard') }}" class="mt-3 d-flex align-items-baseline @if (request()->routeIs('dashboard')) active @endif">
            <span class="icon"><img src="{{ asset('web/images/Icon (1).svg') }}"
                    style="height:25px !important ; width:25px !important; " alt="..."></span>
            <span class="text" style="   font-size: 12px;">Dashboard</span>
        </a>


        <!--  Leads -->
        <a class="nav-link {{ request()->is(['service-quotes']) ? 'active' : '' }}" href="{{ url('service-quotes') }} ">
            <span class="d-flex align-items-center">
                <img src="{{ asset('web/images/customer.svg') }}"
                    style="height:20px !important ; width:20px !important; " class="me-2" alt="...">
                Leads
            </span>
        </a>


        <!-- Chats -->
        <a class="nav-link {{ request()->is('service-chats') ? 'active' : '' }}" href="{{ url('service-chats') }}">
            <span class="d-flex align-items-center">
                <img src="{{ asset('web/images/chats.svg') }}"
                    style="height:20px !important ; width:20px !important; " class="me-2" alt="..."> Chats
            </span>
        </a>


        <a href="{{ url('personal-info') }}" class="{{ request()->is('personal-info') ? 'active' : '' }}">
            <span class="icon d-flex align-items-baseline"><img src="{{ asset('web/images/Icon (Stroke).svg') }}"
                    style="height:25px !important ; width:25px !important; " class="" alt="..."></span>
            <span class="text m-0 ms-2" style="   font-size: 12px;">User Profile</span>
        </a>



        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-link text-decoration-none d-flex align-items-center">
                <span class="icon m-0 d-flex align-items-baseline"><img src="{{ asset('web/images/logout.svg') }}"
                        style="height:25px !important ; width:25px !important; " class=""
                        alt="..."></span>
                <span class="text m-0 ms-3" style="   font-size: 12px;font-weight:500 !important ">Logout</span>
            </button>

        </form>



    </div>
@endif

<script>
    document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(toggle => {
        const targetId = toggle.getAttribute('href');
        const icon = toggle.querySelector('.toggle-icon');
        const collapseEl = document.querySelector(targetId);

        if (collapseEl && icon) {
            collapseEl.addEventListener('show.bs.collapse', () => {
                icon.classList.remove('bi-chevron-compact-down');
                icon.classList.add('bi-chevron-compact-up');
            });
            collapseEl.addEventListener('hide.bs.collapse', () => {
                icon.classList.remove('bi-chevron-compact-up');
                icon.classList.add('bi-chevron-compact-down');
            });
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // This will ensure dropdowns stay open after page reload
        const currentPath = window.location.pathname;
        const sidebarLinks = document.querySelectorAll('#sidebar a');

        sidebarLinks.forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');

                // Find and open parent dropdowns
                let parentCollapse = link.closest('.collapse');
                while (parentCollapse) {
                    const collapseId = parentCollapse.getAttribute('id');
                    if (collapseId) {
                        const toggleElement = document.querySelector(`[href="#${collapseId}"]`);
                        if (toggleElement) {
                            toggleElement.classList.add('active');
                            toggleElement.setAttribute('aria-expanded', 'true');
                        }
                        parentCollapse.classList.add('show');
                    }
                    parentCollapse = parentCollapse.parentElement.closest('.collapse');
                }
            }
        });
    });
</script>
