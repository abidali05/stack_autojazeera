<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Auto Jazeera')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('web/bikes/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('web/bikes/css/bike_home.css') }}">

    <link href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="icon" href="{{ asset('web/images/Jazeera App logo.png') }}" type="image/x-icon" sizes="512x512">

    <style>
        .loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255,255,255,0.7);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}

        .loader {
    width: 60px;
    aspect-ratio: 1;
    border: 15px solid #ddd;
    border-radius: 50%;
    position: relative;
    transform: rotate(45deg);
}

.loader::before {
    content: "";
    position: absolute;
    inset: -15px;
    border-radius: 50%;
    border: 15px solid #514b82;
    animation: l18 2s infinite linear;
}
@keyframes l18 {
    0%   {clip-path: polygon(50% 50%,0 0,0 0,0 0,0 0,0 0)}
    25%  {clip-path: polygon(50% 50%,0 0,100% 0,100% 0,100% 0,100% 0)}
    50%  {clip-path: polygon(50% 50%,0 0,100% 0,100% 100%,100% 100%,100% 100%)}
    75%  {clip-path: polygon(50% 50%,0 0,100% 0,100% 100%,0 100%,0 100%)}
    100% {clip-path: polygon(50% 50%,0 0,100% 0,100% 100%,0 100%,0 0)}
}
        .subscription-card {
            background-color: #2e2b45;
            /* Card background color */
            border: 1px solid #6c6783;
            /* Border color */
            border-radius: 10px;
            padding: 20px;
            color: #fff;
        }


        .card-header i {
            margin-right: 8px;
            color: #fd5631;
            /* Icon color */
            font-size: 18px;
        }

        .card-body {
            margin-bottom: 15px;
        }

        .plan-name {
            font-size: 22px;
            color: #fd5631;
            /* Highlighted text color */
            margin: 0;
        }

        .plan-name .price {
            font-weight: bold;
        }

        .plan-name .duration {
            font-size: 14px;
            color: #a09fb5;
        }

        .next-billing {
            font-size: 12px;
            color: #a09fb5;
            margin-top: 8px;
        }

        .card-footer {
            display: flex;
            gap: 10px;
            justify-content: space-between;
            align-items: center;
        }

        /*
    .btn {
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    } */

        .change-plan {
            background-color: #fd5631;
            color: #fff;
            transition: background-color 0.3s;
        }

        .change-plan:hover {
            background-color: #e65028;
        }

        .cancel-plan {
            background-color: #2e2b45;
            color: #fff;
            border: 1px solid #6c6783;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .cancel-plan:hover {
            background-color: #393656;
            border-color: #fd5631;
        }

        .credit-card {
            background-color: #2e2b45;
            border: 1px solid #6c6783;
            border-radius: 10px;
            width: 300px;
            padding: 20px;
            margin-bottom: 20px;
            position: relative;
        }


        .card-logo {
            font-size: 24px;
            font-weight: bold;
            color: #fff;
        }

        .card-actions i {
            font-size: 18px;
            margin-left: 10px;
            cursor: pointer;
        }

        .edit-icon {
            color: #281F48;
        }

        .delete-icon {
            color: #e74c3c;
        }

        .card-number {
            font-size: 20px;
            letter-spacing: 3px;
            margin-bottom: 15px;
        }

        .last-digits {
            font-weight: bold;
        }

        .card-details {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
        }

        .card-details span {
            font-size: 12px;
            color: #a09fb5;
        }

        .card-holder p,
        .card-expiry p {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
        }

        .add-card-btn {
            background-color: #fd5631;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-card-btn i {
            font-size: 18px;
        }

        .add-card-btn:hover {
            background-color: #e65028;
        }

        /*
    th {
        color: #FD5631 !important;
    }

    tbody,
    td,
    tfoot,
    th,
    thead,
    tr {
        border: none !important;
    }

    .col-form-label {
        font-family: Maven Pro;
        font-size: 17.6px;
        font-weight: 400;
        line-height: 20.68px;
        text-align: left;
        color: #FD5631;
    }
    */
    </style>
    <style>
        .profile-card {
            padding: 20px;
            background-color: #282435;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 20px auto;
        }

        .profile-image {
            flex-shrink: 0;
            margin-right: 15px;
        }

        .profile-image img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 2px solid #ddd;
            object-fit: cover;
        }

        hr {
            border-top: 1px solid #ddd;
        }

        .upload-box {

            border: 2px dashed #6c6783;
            /* Dashed border color */
            border-radius: 10px;
            /* Rounded corners */
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #a09fb5;
            /* Text color */
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            /* Smooth hover effect */
        }

        .upload-box:hover {
            border-color: #fd5631;
            /* Border color on hover */
            color: #fd5631;
            /* Text color on hover */
        }

        /* .form-select {
            background-color: #ffffff00 !important;
            border: none !important;
        }

        .accordion-button {
            color: #ffffff !important;
            background-color: #282435 !important;
            font-weight: 700;
        }

        .accordion {
            --bs-accordion-color: white !important;
            --bs-accordion-bg: #282435 !important;
        } */
        #brochurePreview img {
            max-width: 50px;
            /* Set the maximum width */
            max-height: 50px;
            /* Set the maximum height */
            width: auto;
            /* Maintain aspect ratio */
            height: auto;
            /* Maintain aspect ratio */
        }

        #brochurePreview1 img {
            max-width: 50px;
            /* Set the maximum width */
            max-height: 50px;
            /* Set the maximum height */
            width: auto;
            /* Maintain aspect ratio */
            height: auto;
            /* Maintain aspect ratio */
        }

        #brochurePreview2 img {
            max-width: 50px;
            /* Set the maximum width */
            max-height: 50px;
            /* Set the maximum height */
            width: auto;
            /* Maintain aspect ratio */
            height: auto;
            /* Maintain aspect ratio */
        }

        #brochurePreview3 img {
            max-width: 50px;
            /* Set the maximum width */
            max-height: 50px;
            /* Set the maximum height */
            width: auto;
            /* Maintain aspect ratio */
            height: auto;
            /* Maintain aspect ratio */
        }

        .image-preview img {
            max-width: 50px;
            /* Set the maximum width */
            max-height: 50px;
            /* Set the maximum height */
            width: auto;
            /* Maintain aspect ratio */
            height: auto;
            /* Maintain aspect ratio */
        }

        tbody,
        td,
        tfoot,
        th,
        thead,
        tr {
            border: none !important;
        }

        .modal-content {
            background-color: #1F1B2D !important;
        }

        .col-form-label {
            font-family: Maven Pro;
            font-size: 17.6px;
            font-weight: 400;
            line-height: 20.68px;
            text-align: left;
            color: #281F48;
        }

        th,
        td {
            vertical-align: middle;
            /* Aligns text vertically in the center */
            white-space: nowrap;
            /* Prevents text from wrapping */
        }

        .color-box {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            border: 2px solid #333;
        }

        .btn-close {
            --bs-btn-close-color: #000;
            --bs-btn-close-bg: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e);
            --bs-btn-close-opacity: 0.5;
            --bs-btn-close-hover-opacity: 0.75;
            --bs-btn-close-focus-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            --bs-btn-close-focus-opacity: 1;
            --bs-btn-close-disabled-opacity: 0.25;
            --bs-btn-close-white-filter: invert(1) grayscale(100%) brightness(200%);
            box-sizing: content-box;
            width: 1em;
            height: 1em;
            padding: .25em .25em;
            color: var(--bs-btn-close-color);
            background: #ffffff var(--bs-btn-close-bg) center / 1em auto no-repeat !important;
            border: 0;
            border-radius: .375rem;
            opacity: 1 !important;
        }

        a {
            text-decoration: none;
        }

        .step-header {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .step-content {
            display: none;
        }

        .step-content.active {
            display: block;
        }

        .char-counter {
            text-align: right;
            font-size: 0.85rem;
            color: #6c757d;
        }

        .carousel-control-next-icon {
            background-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e);
        }

        ;
        height:60px;
        width:60px;
        }

        .step-header {
            color: #281F48;
        }

        .alert {
            background-color: unset;
            border: none;
            color: red;
        }

        <style>#goToTop,
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
        footer {
    background-color: #282435;
}
    </style>

</head>


<body style="  font-family: 'Poppins !important', serif; background-color:#FBFBFB !important">
        
    @include('layout.firebase')
    @if (Request::is('superadmin/*'))
        @include('layout.website_layout.bikes.superadminnav')
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>



    </script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>


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
</body>

</html>
