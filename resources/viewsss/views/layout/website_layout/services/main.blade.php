<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Auto Jazeera')</title>
    <meta name="format-detection" content="telephone=no,email=no,address=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
    <link rel="icon" href="{{ asset('web/images/Jazeera App logo.png') }}" type="image/x-icon" sizes="512x512">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="{{ asset('web/services/css/styles.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />

    <style>
        #goToTop,
        #goToBottom {
            position: fixed;
            right: 20px;
            padding: 10px;
            padding-left: 15px;
            padding-right: 15px;
            font-size: 20px;
            background-color: #F40000 !important;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            opacity: 0;
            /* Start hidden */
            visibility: hidden;
            /* Prevent interaction when hidden */
            transition: opacity 0.3s ease, visibility 0.3s ease;
            /* Smooth transition */
        }

        #goToTop {
            bottom: 80px;
        }

        #goToBottom {
            bottom: 20px;
        }

        #goToTop:hover,
        #goToBottom:hover {
            background-color: #F40000 !important;
        }

        /* Show buttons with fade-in effect */
        #goToTop.show,
        #goToBottom.show {
            opacity: 1;
            visibility: visible;
        }
    </style>
</head>


<body style="background-color:#FBFBFB !important">
    @include('layout.firebase')
    @if (Request::is('superadmin/*'))
        @include('layout.website_layout.bikes.nav')
    @else
        @include('layout.website_layout.bikes.nav')
    @endif

    @yield('content')

    <!-- Section -->
    @if (!Request::is('superadmin/*'))
        @include('layout.website_layout.bikes.footer')
    @endif


    <button id="goToTop" onclick="scrollToTop()">
        <i class="bi bi-arrow-up"></i>
    </button>
    <button id="goToBottom" onclick="scrollToBottom()">
        <i class="bi bi-arrow-down"></i>
    </button>



    @auth

        {{-- firebase  --}}
        <script>
            document.addEventListener('DOMContentLoaded', () => {

                setUserOnline();

                // Listen for window events
                window.addEventListener('online', () => setUserOnline()); // Detects when internet is restored
                window.addEventListener('offline', () => setUserOffline()); // Detects when internet is lost
                window.addEventListener('beforeunload', () =>
                    setUserOffline()); // Detects when the user leaves the page

                // Detect when user switches tabs
                document.addEventListener('visibilitychange', () => {
                    if (document.visibilityState === 'visible') {
                        setUserOnline();
                    } else {
                        setUserOffline();
                    }
                });




                // Keep the user online every 30 seconds (if they are still active)
                setInterval(() => {
                    if (navigator.onLine) {
                        setUserOnline();
                    }
                }, 30000);


            });

            // Function to set user as Online
            async function setUserOnline() {
                try {
                    await fetch('{{ route('set.user.online') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            state: 'Online'
                        })
                    });
                } catch (error) {
                    console.error('Failed to set user online:', error);
                }
            }

            // Function to set user as Offline
            async function setUserOffline() {
                try {
                    await fetch('{{ route('set.user.offline') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            state: 'Offline'
                        })
                    });
                } catch (error) {
                    console.error('Failed to set user offline:', error);
                }
            }
        </script>


        <script>
            const goToTopButton = document.getElementById('goToTop');
            const goToBottomButton = document.getElementById('goToBottom');

            function scrollToTop() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            function scrollToBottom() {
                window.scrollTo({
                    top: document.body.scrollHeight,
                    behavior: 'smooth'
                });
            }

            window.addEventListener('scroll', () => {
                const scrollPosition = window.scrollY;
                const scrollHeight = document.body.scrollHeight;
                const clientHeight = window.innerHeight;

                // Show or hide "Go to Top" button
                if (scrollPosition > 200) {
                    goToTopButton.classList.add('show');
                } else {
                    goToTopButton.classList.remove('show');
                }

                // Show or hide "Go to Bottom" button
                if (scrollPosition + clientHeight < scrollHeight - 100) {
                    goToBottomButton.classList.add('show');
                } else {
                    goToBottomButton.classList.remove('show');
                }
            });
        </script>

    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $('.select2').select2({
            theme: 'bootstrap-5',

        });
        $('.datatable').DataTable({
            lengthChange: false
        });

        document.getElementById('province').addEventListener('change', function() {
            var provinceId = this.value;

            var citySelect = document.getElementById('city');

            // Clear the current city options
            citySelect.innerHTML = '<option value="" selected>Select City</option>';

            // Fetch cities based on selected province
            if (provinceId) {
                fetch(`/getCities/${provinceId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(city => {
                            var option = document.createElement('option');
                            option.value = city.id;
                            option.textContent = city.name;
                            citySelect.appendChild(option);

                        });

                    })
                    .catch(error => console.error('Error fetching cities:', error));
            }
        });
    </script>
</body>

</html>
