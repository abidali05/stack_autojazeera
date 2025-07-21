 <!-- Main Container -->
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
                        <a href="{{url('/faqs')}}" class="faqsanker">FAQs</a>
                        <a href="{{url('/contact-us')}}" class="ms-2 faqsanker">Contact us</a>
                        <a class="nesd ms-2" href="{{url('/')}}">Website</a>
                    </div>
                    <div class="d-flex align-items-center ms-3">
                        <img src="{{ Auth::user()->image ? asset('web/profile/' .Auth::user()->image) : asset('web/images/avatar.png') }}" class="rounded me-2" alt="User" width="40" height="40">
                        <div>
                            <h6 class="menu pb-0 mb-1">{{ Auth::user()->name }}</h6>
                            <p class="menus pb-0 mb-0">Dealer</p>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

    </div>