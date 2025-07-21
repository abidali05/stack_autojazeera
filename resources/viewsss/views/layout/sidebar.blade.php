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
        }

        #sidebar.closed {
            width: 60px;
        }

        #sidebar::-webkit-scrollbar {
            width: 8px;
            /* Width of the scrollbar */
        }

        #sidebar::-webkit-scrollbar-track {
            background: #f8f9fa;
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

            #main-container.sidebar-closed {
                margin-left: 0;
            }

            #sidebar {
                position: absolute;
                width: 100%;
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

</style>
<!-- Sidebar -->
    <div id="sidebar">
        <a id="sidebarLogo" class="navbar-brand d-flex justify-content-center" href="{{route('dashboard')}}">
            <img src="{{asset('web/images/Frame 1171275409.svg')}}" class="imgheightfix" alt="...">
        </a>

        <a href="{{route('dashboard')}}" class="mt-3">
            <span class="icon"><img src="{{asset('web/images/Icon (1).svg')}}" alt="..."></span>
            <span class="text">Dashboard</span>
        </a>
        <!-- Main Link -->
        <a class="nav-link d-flex  align-items-center" data-bs-toggle="collapse" href="#postAnAdMenu" role="button"
            aria-expanded="false" aria-controls="postAnAdMenu">
            <span class="text-nowrap"><img src="{{asset('web/images/Icon (2).svg')}}" class="me-2" alt="..."></span><span> Post An
                Ad</span>
        </a>

        <!-- Collapsed Menu -->
        <div class="collapse ps-3" id="postAnAdMenu">
            <a class="nav-link" href="{{url('ads/create')}}"> <span class="d-flex align-items-center"><img
                        src="{{asset('web/images/car.svg')}}" style="height: 20px; width: 20px" class="me-2"
                        alt="...">Car</span></a>
            <a class="nav-link" href="{{url('bike/ads/create')}}"> <span class="d-flex align-items-center"><img
                        src="{{asset('web/images/Vector (2).svg')}}" style="height: 20px; width: 20px" class="me-2"
                        alt="...">Bike</span></a>
        </div>



        <a class="nav-link d-flex  align-items-center" data-bs-toggle="collapse" href="#manageAdMenu" role="button"
            aria-expanded="false" aria-controls="manageAdMenu">
            <span class="text-nowrap"><img src="{{asset('web/images/Mask group.svg')}}" class="img-fluid" alt="..."><span>Manage
                    Ads</span>
        </a>

        <!-- Collapsed Menu -->
        <div class="collapse ps-3" id="manageAdMenu">
            <a class="nav-link" href="{{url('ads')}}"> <span class="d-flex align-items-center"><img
                        src="{{asset('web/images/car.svg')}}" style="height: 20px; width: 20px" class="me-2"
                        alt="...">Car</span></a>
            <a class="nav-link" href="{{url('bike/ads')}}"> <span class="d-flex align-items-center"><img
                        src="{{asset('web/images/Vector (2).svg')}}" style="height: 20px; width: 20px" class="me-2"
                        alt="...">Bike</span></a>
        </div>
        <a href="personal_info.html" class="d-flex align-items-baseline">
            <span class="icon"><img src="{{asset('web/images/Shop.svg')}}" class="" alt="..."></span>
            <span class="text">Shop</span>
        </a>
        <a class="nav-link d-flex  align-items-center" data-bs-toggle="collapse" href="#Subscription" role="button"
            aria-expanded="false" aria-controls="Subscription">
            <span class="text-nowrap"><img src="{{asset('web/images/subscription.svg')}}" class="" alt="..."></span><span>
                Subscription</span>
        </a>

        <!-- Collapsed Menu -->
        <div class="collapse ps-3" id="Subscription">
            <a class="nav-link" href="post_car.html"> <span class="d-flex align-items-center"><img
                        src="{{asset('web/images/Mask group.svg')}}" style="height: 20px; width: 20px" class="me-2"
                        alt="...">Adds</span></a>
            <a class="nav-link" href="post_bike.html"> <span class="d-flex align-items-center"><img
                        src="{{asset('web/images/Autoservices.svg')}}" style="height: 20px; width: 20px" class="me-2" alt="...">Auto
                    Services</span></a>
        </div>

        <a class="nav-link d-flex  align-items-center" data-bs-toggle="collapse" href="#viewleads" role="button"
            aria-expanded="false" aria-controls="viewleads">
            <span class="text-nowrap"><img src="{{asset('web/images/Mask group (1).svg')}}" class="img-fluid" alt="..."><span>View
                    Leads</span>
        </a>

        <!-- Collapsed Menu -->

        <div class="collapse ps-3" id="viewleads">
            <a class="nav-link" href="post_car.html"> <span class="d-flex align-items-center"><img
                        src="{{asset('web/images/car.svg')}}" style="height: 20px; width: 20px" class="me-2"
                        alt="...">Car</span></a>
            <a class="nav-link" href="post_bike.html"> <span class="d-flex align-items-center"><img
                        src="{{asset('web/images/Vector (2).svg')}}" style="height: 20px; width: 20px" class="me-2"
                        alt="...">Bike</span></a>
            <a class="nav-link" href="post_car.html"> <span class="d-flex align-items-center"><img
                        src="{{asset('web/images/Autoservices.svg')}}" style="height: 20px; width: 20px" class="me-2" alt="...">Auto
                    Services</span></a>

        </div>
        <a class="nav-link d-flex  align-items-center" data-bs-toggle="collapse" href="#Wishlist" role="button"
            aria-expanded="false" aria-controls="Wishlist">
            <span class="text-nowrap"><img src="{{asset('web/images/wishlist.svg')}}" class="img-fluid" alt="..."><span>Wishlist</span>
        </a>

        <!-- Collapsed Menu -->
        <div class="collapse ps-3" id="Wishlist">
            <a class="nav-link" href="post_car.html"> <span class="d-flex align-items-center"><img
                        src="{{asset('web/images/car.svg')}}" style="height: 20px; width: 20px" class="me-2"
                        alt="...">Car</span></a>
            <a class="nav-link" href="post_bike.html"> <span class="d-flex align-items-center"><img
                        src="{{asset('web/images/Vector (2).svg')}}" style="height: 20px; width: 20px" class="me-2"
                        alt="...">Bike</span></a>
            <a class="nav-link" href="post_car.html"> <span><img src="{{asset('web/images/Autoservices.svg')}}"
                        style="height: 20px; width: 20px" class="me-2" alt="...">Auto Services</span></a>
        </div>
        <a class="nav-link d-flex  align-items-center" data-bs-toggle="collapse" href="#Submitted" role="button"
            aria-expanded="false" aria-controls="Submitted">
            <span class="text-nowrap"><img src="{{asset('web/images/submitedfrms.svg')}}" class="img-fluid" alt="..."><span>Submitted
                    Forms</span>
        </a>

        <!-- Collapsed Menu -->
        <div class="collapse ps-3" id="Submitted">
            <a class="nav-link" href="post_car.html"> <span class="d-flex align-items-center"><img
                        src="{{asset('web/images/car.svg')}}" style="height: 20px; width: 20px" class="me-2"
                        alt="...">Car</span></a>
            <a class="nav-link" href="post_bike.html"> <span class="d-flex align-items-center"><img
                        src="{{asset('web/images/Vector (2).svg')}}" style="height: 20px; width: 20px" class="me-2"
                        alt="...">Bike</span></a>

        </div>
        <a class="nav-link d-flex  align-items-center" data-bs-toggle="collapse" href="#price" role="button"
            aria-expanded="false" aria-controls="price">
            <span class="text-nowrap"><img src="{{asset('web/images/pricealert.svg')}}" class="img-fluid" alt="..."><span>Price
                    Alert</span>
        </a>

        <!-- Collapsed Menu -->
        <div class="collapse ps-3" id="price">
            <a class="nav-link" href="post_car.html"> <span class="d-flex align-items-center"><img
                        src="{{asset('web/images/car.svg')}}" style="height: 20px; width: 20px" class="me-2"
                        alt="...">Car</span></a>
            <a class="nav-link" href="post_bike.html"> <span class="d-flex align-items-center"><img
                        src="{{asset('web/images/Vector (2).svg')}}" style="height: 20px; width: 20px" class="me-2"
                        alt="...">Bike</span></a>

        </div>
        <a href="personal_info.html">
            <span class="icon"><img src="{{asset('web/images/manageemployee.svg')}}" class="" alt="..."></span>
            <span class="text">Manage Employees</span>
        </a>
        <a href="personal_info.html">
            <span class="icon"><img src="{{asset('web/images/chats.svg')}}" class="" alt="..."></span>
            <span class="text">Chats</span>
        </a>


        <a href="personal_info.html">
            <span class="icon"><img src="{{asset('web/images/Icon (Stroke).svg')}}" class="" alt="..."></span>
            <span class="text">Personal Info</span>
        </a>


        <a href="login_and_security.html">
            <span class="icon"><img src="{{asset('web/images/logout.svg')}}" class="" alt="..."></span>
            <span class="text">Logout</span>
        </a>

    </div>



        <script>
        const toggleSidebar = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const mainContainer = document.getElementById('main-container');
        const sidebarLogoImg = document.querySelector('#sidebarLogo img');

        toggleSidebar.addEventListener('click', () => {
            sidebar.classList.toggle('closed');
            mainContainer.classList.toggle('sidebar-closed');

            if (sidebar.classList.contains('closed')) {
                sidebarLogoImg.style.display = 'none';
            } else {
                sidebarLogoImg.style.display = 'block'; // or 'flex' depending on design
            }
        });

        // Ensure correct logo visibility on page load
        window.addEventListener('DOMContentLoaded', () => {
            if (sidebar.classList.contains('closed')) {
                sidebarLogoImg.style.display = 'none';
            }
        });

        // Highlight active sidebar and navbar links
        const navbarLinks = document.querySelectorAll('.navbar-nav .nav-link');
        const sidebarLinks = document.querySelectorAll('#sidebar a');

        const currentPath = window.location.pathname.split('/').pop().split('#')[0];

        const setActiveClass = (links) => {
            links.forEach(link => {
                const linkPath = link.getAttribute('href').split('/').pop().split('#')[0];
                if (linkPath === currentPath) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        };

        setActiveClass(navbarLinks);
        setActiveClass(sidebarLinks);
    </script>