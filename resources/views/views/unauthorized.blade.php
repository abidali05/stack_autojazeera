@extends('layout.panel_layout.main')
@section('content')
<div class="container mb-5">
    {{-- <div class="row align-items-center my-lg-4">
        <div class="col-1">
            <a href="{{route('superadmin.dashboard')}}" class="text-white me-3">
                <img src="{{asset('web/images/back-arrow.png')}}" alt="back-arrow" width="40px" height="24px">
            </a>
        </div>
    </div> --}}

    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="error-container">
                <!-- Animated Logo -->
                <div class="logo-container mb-4">
                    <img src="{{asset('web/images/logo.png')}}" alt="Logo" class="animated-logo">
                </div>

                <div class="error-content">
                    <h1 class="error-code">403</h1>
                    <h2 class="error-title">Access Denied</h2>
                    <p class="error-message">You don't have permission to access this page</p>
                    
                    <div class="mt-5 d-flex justify-content-center gap-3 align-items-center">
                        <a href="{{route('dashboard')}}" class="btn custom-btn-nav rounded">
                            <i class="bi bi-house-door"></i> Return to Dashboard
                        </a>
                        {{-- <button onclick="window.history.back()" class="btn btn-outline-primary rounded">
                            <i class="bi bi-arrow-left"></i> Go Back
                        </button> --}}
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .error-container {
        padding: 3rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        backdrop-filter: blur(10px);
    }

    .logo-container {
        margin-bottom: 2rem;
    }

    .animated-logo {
        width: 150px;
        /* animation: float 3s ease-in-out infinite; */
    }

    @keyframes float {
        0% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
        100% { transform: translateY(0px) rotate(0deg); }
    }

    .error-code {
        font-size: 8rem;
        font-weight: bold;
        color: #FD5631;
        margin: 0;
        line-height: 1;
        animation: fadeInDown 1s ease-out;
    }

    .error-title {
        font-size: 2.5rem;
        color: #281F48;
        margin-bottom: 1rem;
        animation: fadeIn 1s ease-out 0.5s both;
    }

    .error-message {
        font-size: 1.2rem;
        color: #281F48;
        margin-bottom: 2rem;
        animation: fadeIn 1s ease-out 1s both;
    }

    .custom-btn-nav {
        background: #FD5631;
        color: white !important;
        padding: 0.8rem 1.5rem;
        transition: all 0.3s ease;
    }

    .custom-btn-nav:hover {
        background: #e64a28;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(253, 86, 49, 0.2);
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .btn-outline-secondary {
        border-color: #ccc;
        color: #666;
        padding: 0.8rem 1.5rem;
        transition: all 0.3s ease;
    }

    .btn-outline-secondary:hover {
        background: #f5f5f5;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth entrance for the error container
    const errorContainer = document.querySelector('.error-container');
    errorContainer.style.opacity = '0';
    errorContainer.style.transform = 'translateY(20px)';
    errorContainer.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
    
    setTimeout(() => {
        errorContainer.style.opacity = '1';
        errorContainer.style.transform = 'translateY(0)';
    }, 100);
});
</script>
@endsection