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

     /* Custom scrollbar */
     #sidebar::-webkit-scrollbar {
         width: 5px;
     }

     #sidebar::-webkit-scrollbar-track {
         background: #f1f1f1;
     }

     #sidebar::-webkit-scrollbar-thumb {
         background-color: #999;
         border-radius: 10px;
         border: 1px solid #ccc;
     }

     /* Optional: For Firefox */
     #sidebar {
         scrollbar-width: thin;
         /* "auto" or "thin" */
         scrollbar-color: #281F48 #F4F4F4;
         /* thumb and track */
     }


     #sidebar.closed {
         width: 60px;
     }

     #sidebar::-webkit-scrollbar {
         width: 6px;
         /* Slightly wider for visibility */
     }

     #sidebar::-webkit-scrollbar-track {
         background: #F4F4F4;
         /* Red background for the track */
     }

     #sidebar::-webkit-scrollbar-thumb {
         background-color: #281F48;
         /* Green scroll thumb */
         border-radius: 4px;
     }

     #sidebar::-webkit-scrollbar-thumb:hover {
         background-color: #281F48;
         /* Optional: darker green on hover */
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
         height: 60px;
         width: 140px;
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
 </style>
 @if (Auth::guard('superadmin')->user()->role == '')
     <div id="sidebar">
         <a id="sidebarLogo" class="navbar-brand d-flex justify-content-center" href="{{ url('superadmin/dashboard') }}">
             <img src="{{ asset('web/bikes/images/logo.svg') }}" class="imgheightfix" alt="...">
         </a>

         <a href="{{ url('superadmin/dashboard') }}" class="mt-3">
             <span class="icon"><img src="{{ asset('web/images/Icon (1).svg') }}" alt="..."></span>
             <span class="text">Dashboard</span>
         </a>
         <!-- Main Link -->
         <a class="nav-link d-flex  align-items-center" data-bs-toggle="collapse" href="#postAnAdMenu" role="button"
             aria-expanded="false" aria-controls="postAnAdMenu">
             <span class="text-nowrap"><img src="{{ asset('web/images/Icon (2).svg') }}" class="me-2"
                     alt="..."></span><span> Post An
                 Ad</span>
             <i class="bi bi-chevron-down ms-auto"></i>

         </a>

         <!-- Collapsed Menu -->
         <div class="collapse ps-3" id="postAnAdMenu">
             <a class="nav-link" href="{{ url('superadmin/ads/create') }}"> <span class="d-flex align-items-center">
                     <img src="{{ asset('web/images/car1.svg') }}"
                         style="height:20px !important ; width:20px !important; " class="me-2"
                         alt="...">Car</span></a>
             <a class="nav-link" href="{{ url('superadmin/bike-ads/create') }}"> <span
                     class="d-flex align-items-center"><img src="{{ asset('web/images/Vector (2).svg') }}"
                         style="height: 20px; width: 20px" class="me-2" alt="...">Bike</span></a>
         </div>



         <a class="nav-link d-flex  align-items-center" data-bs-toggle="collapse" href="#manageAdMenu" role="button"
             aria-expanded="false" aria-controls="manageAdMenu">
             <span class="text-nowrap"><img src="{{ asset('web/images/Mask group.svg') }}" class=""
                     alt="..."></span><span>Manage
                 Ads</span>
             <i class="bi bi-chevron-down ms-auto"></i>

         </a>

         <!-- Collapsed Menu -->
         <div class="collapse ps-3" id="manageAdMenu">
             <a class="nav-link" href="{{ url('superadmin/ads') }}"> <span class="d-flex align-items-center"> <img
                         src="{{ asset('web/images/car1.svg') }}"
                         style="height:20px !important ; width:20px !important; " class="me-2"
                         alt="...">Car</span></a>
             <a class="nav-link" href="{{ url('superadmin/bike-ads') }}"> <span class="d-flex align-items-center"><img
                         src="{{ asset('web/images/Vector (2).svg') }}" style="height: 20px; width: 20px"
                         class="me-2" alt="...">Bike</span></a>
         </div>

         <a href="{{ url('superadmin/user') }}" class="d-flex align-items-baseline">
             <span class="icon"><img src="{{ asset('web/images/manageemployee.svg') }}" class=""
                     alt="..."></span>
             <span class="text">Manage Users</span>
         </a>

         <!-- Manage System Main Toggle -->
         <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#System" role="button"
             aria-expanded="false" aria-controls="System">
             <span class="text-nowrap">
                 <img src="{{ asset('web/images/manage_system_icon.svg') }}" class="img-fluid " alt="...">
                 <span>Manage System</span>
             </span>
             <i class="bi bi-chevron-down ms-auto"></i>

         </a>

         <!-- First Level Collapse: Manage System -->
         <div class="collapse ps-3" id="System">

             <!-- Car with Submenu -->
             <a class="nav-link d-flex align-items-center" style="font-size:12px" href="{{ url('superadmin/color') }}">
                 <img src="{{ asset('web/images/colornew.svg') }}" style="height: 20px; width: 20px" class="me-2"
                     alt="...">Color
             </a>


             <!-- Bike with Submenu -->
             <a class="nav-link d-flex align-items-center" style="font-size:12px" data-bs-toggle="collapse"
                 href="#bikeSubmenu" role="button">
                 <img src="{{ asset('web/images/newfeature.svg') }}" style="height: 20px; width: 20px" class="me-2"
                     alt="...">Features
                 <i class="bi bi-chevron-down ms-auto"></i>

             </a>
             <div class="collapse ps-4" id="bikeSubmenu">
                 <a class="nav-link" href="{{ url('superadmin/feature') }}"> <img
                         src="{{ asset('web/images/car1.svg') }}"
                         style="height:20px !important ; width:20px !important; " alt="..."><span
                         class="text-secondary">Cars</span></a>
                 <a class="nav-link" href="{{ url('superadmin/bike-features') }}"><img
                         src="{{ asset('web/images/Vector (2).svg') }}" style="height: 20px; width: 20px"
                         class="" alt="..."><span class="text-secondary">Bikes</span></a>
             </div>
             <a class="nav-link d-flex align-items-center" style="font-size:12px" data-bs-toggle="collapse"
                 href="#bodytype" role="button">
                 <img src="{{ asset('web/bikes/images/hahah.svg') }}" style="height: 20px; width: 20px"
                     class="me-2" alt="...">Body type
                 <i class="bi bi-chevron-down ms-auto"></i>

             </a>
             <div class="collapse ps-4" id="bodytype">
                 <a class="nav-link" href="{{ url('superadmin/bodytype') }}"> <img
                         src="{{ asset('web/images/car1.svg') }}"
                         style="height:20px !important ; width:20px !important; " alt="..."><span
                         class="text-secondary">Cars</span></a>
                 <a class="nav-link" href="{{ url('superadmin/bike-bodytype') }}"><img
                         src="{{ asset('web/images/Vector (2).svg') }}" style="height: 20px; width: 20px"
                         class="" alt="..."><span class="text-secondary">Bikes</span></a>
             </div>

             <!-- Truck with Submenu -->
             <a class="nav-link d-flex align-items-center" style="font-size:12px" data-bs-toggle="collapse"
                 href="#truckSubmenu" role="button">
                 <img src="{{ asset('web/images/truck.svg') }}" style="height: 20px; width: 20px" class="me-2"
                     alt="...">Model
                 <i class="bi bi-chevron-down ms-auto"></i>

             </a>
             <div class="collapse ps-4" id="truckSubmenu">
                 <a class="nav-link" href="{{ url('superadmin/model') }}"> <img
                         src="{{ asset('web/images/car1.svg') }}"
                         style="height:20px !important ; width:20px !important; " alt="..."><span
                         class="text-secondary">Cars</span></a>
                 <a class="nav-link" href="{{ url('superadmin/bike-model') }}"><img
                         src="{{ asset('web/images/Vector (2).svg') }}" style="height: 20px; width: 20px"
                         class="" alt="..."><span class="text-secondary">Bikes</span></a>
             </div>

             <!-- Bus with Submenu -->
             <a class="nav-link d-flex align-items-center" style="font-size:12px" data-bs-toggle="collapse"
                 href="#busSubmenu" role="button">
                 <img src="{{ asset('web/images/bus.svg') }}" style="height: 20px; width: 20px" class="me-2"
                     alt="...">Make
                 <i class="bi bi-chevron-down ms-auto"></i>

             </a>
             <div class="collapse ps-4" id="busSubmenu">
                 <a class="nav-link" href="{{ url('superadmin/make') }}"> <img
                         src="{{ asset('web/images/car1.svg') }}"
                         style="height:20px !important ; width:20px !important; " alt="..."><span
                         class="text-secondary">Cars</span></a>
                 <a class="nav-link" href="{{ url('superadmin/bike-make') }}"><img
                         src="{{ asset('web/images/Vector (2).svg') }}" style="height: 20px; width: 20px"
                         class="" alt="..."><span class="text-secondary">Bikes</span></a>
             </div>

         </div>

         <a href="{{ url('superadmin/blogs') }}" class="d-flex align-items-baseline">
             <span class="icon"><i class="fas fa-newspaper"></i></span>
             <span class="text">Blogs</span>
         </a>

         <a href="{{ url('superadmin/shops') }}" class="d-flex align-items-baseline">
             <span class="icon"><img src="{{ asset('web/images/Shop.svg') }}" class=""
                     alt="..."></span>
             <span class="text">Shops</span>
         </a>
         <a href="{{ url('superadmin/shop-reviews') }}" class="d-flex align-items-baseline">
             <span class="icon"><img src="{{ asset('web/images/reviews_icon.svg') }}" class=""
                     alt="..."></span>
             <span class="text">Reviews</span>
         </a>
         <a class="nav-link d-flex  align-items-center" data-bs-toggle="collapse" href="#Subscription"
             role="button" aria-expanded="false" aria-controls="Subscription">
             <span class="text-nowrap"><img src="{{ asset('web/images/subscription.svg') }}" class=""
                     alt="..."></span><span>
                 Subscription</span>
             <i class="bi bi-chevron-down ms-auto"></i>

         </a>

         <!-- Collapsed Menu -->
         <div class="collapse ps-3" id="Subscription">
             <a class="nav-link" href="{{ url('superadmin/subscriptions/ads') }}"> <span
                     class="d-flex align-items-center"><img src="{{ asset('web/images/Mask group.svg') }}"
                         style="height: 20px; width: 20px" class="me-2" alt="...">Adds</span></a>
             <a class="nav-link" href="{{ url('superadmin/subscriptions/service') }}"> <span
                     class="d-flex align-items-center"><img src="{{ asset('web/images/Autoservices.svg') }}"
                         style="height: 20px; width: 20px" class="me-2" alt="...">Auto
                     Services</span></a>


         </div>
         <a class="nav-link d-flex  align-items-center" data-bs-toggle="collapse" href="#Services" role="button"
             aria-expanded="false" aria-controls="Services">
             <span class="text-nowrap"><img src="{{ asset('web/images/Mask group (1).svg') }}" class="img-fluid"
                     alt="..."><span>Manage
                     Services</span>
                 <i class="bi bi-chevron-down ms-auto"></i>

         </a>

         <!-- Collapsed Menu -->

         <div class="collapse ps-3" id="Services">
             <a class="nav-link" href="{{ url('superadmin/service-categories') }}"> <span
                     class="d-flex align-items-center"><img src="{{ asset('web/images/manage_service_icon.svg') }}"
                         style="height: 20px; width: 20px" class="me-2" alt="...">Services
                     type</span></a>
             <a class="nav-link" href="{{ url('superadmin/services') }}"> <span
                     class="d-flex align-items-center"><img src="{{ asset('web/images/services_icon.svg') }}"
                         style="height: 20px; width: 20px" class="me-2" alt="...">Services</span></a>
             <a class="nav-link" href="{{ url('superadmin/amenities') }}"> <span
                     class="d-flex align-items-center"><img src="{{ asset('web/images/amenities_icon.svg') }}"
                         style="height: 20px; width: 20px" class="me-2" alt="...">Amenities</span></a>

         </div>




         <a href="{{ url('superadmin/personal-info') }}" class="d-flex align-items-baseline">
             <span class="icon"><img src="{{ asset('web/images/Icon (Stroke).svg') }}" class=""
                     alt="..."></span>
             <span class="text">Personal Info</span>
         </a>

         <a href="{{ url('superadmin/news-letter') }}" class="">
             <span class="icon"><img src="{{ asset('web/images/Icon (1).svg') }}" alt="..."></span>
             <span class="text">News Letter</span>
         </a>

         <a href="{{ url('superadmin/admins') }}" class="">
             <span class="icon"><img src="{{ asset('web/images/Icon (1).svg') }}" alt="..."></span>
             <span class="text">Manage Admins</span>
         </a>


         <form action="{{ route('superadmin.logout') }}" method="post">
             @csrf
             <button type="submit" class="btn btn-link text-decoration-none d-flex align-items-center">
                 <span class="icon"><img src="{{ asset('web/images/logout.svg') }}" class=""
                         alt="..."></span>
                 <span class="text">Logout</span>
             </button>

         </form>



     </div>
 @else
     <div id="sidebar">
         <a id="sidebarLogo" class="navbar-brand d-flex justify-content-center"
             href="{{ url('superadmin/dashboard') }}">
             <img src="{{ asset('web/bikes/images/logo.svg') }}" class="imgheightfix" alt="...">
         </a>

         <a class="nav-link d-flex  align-items-center" data-bs-toggle="collapse" href="#manageAdMenu"
             role="button" aria-expanded="false" aria-controls="manageAdMenu">
             <span class="text-nowrap"><img src="{{ asset('web/images/Mask group.svg') }}" class=""
                     alt="..."></span><span>Manage
                 Ads</span>
             <i class="bi bi-chevron-down ms-auto"></i>

         </a>

         <!-- Collapsed Menu -->
         <div class="collapse ps-3" id="manageAdMenu">
             <a class="nav-link" href="{{ url('superadmin/ads') }}"> <span class="d-flex align-items-center"> <img
                         src="{{ asset('web/images/car1.svg') }}"
                         style="height:20px !important ; width:20px !important; " class="me-2"
                         alt="...">Car</span></a>
             <a class="nav-link" href="{{ url('superadmin/bike-ads') }}"> <span
                     class="d-flex align-items-center"><img src="{{ asset('web/images/Vector (2).svg') }}"
                         style="height: 20px; width: 20px" class="me-2" alt="...">Bike</span></a>
         </div>

         <a href="{{ url('superadmin/user') }}" class="d-flex align-items-baseline">
             <span class="icon"><img src="{{ asset('web/images/manageemployee.svg') }}" class=""
                     alt="..."></span>
             <span class="text">Manage Users</span>
         </a>

         <a href="{{ url('superadmin/shops') }}" class="d-flex align-items-baseline">
             <span class="icon"><img src="{{ asset('web/images/Shop.svg') }}" class=""
                     alt="..."></span>
             <span class="text">Shops</span>
         </a>


         <form action="{{ route('superadmin.logout') }}" method="post">
             @csrf
             <button type="submit" class="btn btn-link text-decoration-none d-flex align-items-center">
                 <span class="icon"><img src="{{ asset('web/images/logout.svg') }}" class=""
                         alt="..."></span>
                 <span class="text">Logout</span>
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
                 icon.classList.remove('bi bi-chevron-down');
                 icon.classList.add('bi bi-chevron-up');
             });
             collapseEl.addEventListener('hide.bs.collapse', () => {
                 icon.classList.remove('bi bi-chevron-up');
                 icon.classList.add('bi bi-chevron-down');
             });
         }
     });
 </script>
