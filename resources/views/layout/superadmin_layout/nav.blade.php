 <!-- Main Container -->
 <style>
    .buttontoddle {
    font-size: 14px !important ;
    background-color: #281f4825 !important;
    padding: 8px 12px !important;
 
    border-radius: 5px !important;
    border: none !important;
}
 </style>
 <div id="main-container">
     <!-- Navbar -->
     <nav class="navbar navbar-expand-lg bg-light">
         <div class="container-fluid">
             <button id="toggleSidebar" class="buttontoddle me-2">☰</button>

             <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                 aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                 <span class="navbar-toggler-icon"></span>
             </button>

             <div class="collapse navbar-collapse text-center" id="navbarNav">
                 <div class="ms-auto">
                     <a href="{{ url('/faqs') }}" class="faqsanker" target="_blank">FAQs</a>
                     <a href="{{ url('/contact-us') }}" class="ms-2 faqsanker" target="_blank">Contact us</a>
                     <a class="nesd ms-2" href="{{ url('/') }}" target="_blank">Website</a>
                 </div>
                 @auth
                     <div class="d-flex align-items-center ms-3">
                         <img src="{{ Auth::user()->image ? asset('web/profile/' . Auth::user()->image) : asset('web/images/avatar.png') }}"
                             class="rounded me-2" alt="User" width="40" height="40">
                         <div>
                             <h6 class="menu pb-0 mb-1">{{ Auth::user()->name }}</h6>
                             <p class="menus pb-0 mb-0">
                                 <span class="badge bg-success">Superadmin</span>
                             </p>
                         </div>
                     </div>
                 @endauth


             </div>
         </div>
     </nav>

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

     // setActiveClass(navbarLinks);
     // setActiveClass(sidebarLinks);
 </script>
