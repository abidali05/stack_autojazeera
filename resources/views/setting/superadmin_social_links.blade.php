@extends('layout.superadmin_layout.main')

@section('content')
    <div class="container py-5">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="text-center mb-5">
            <h2 class="fw-bold primary-color-custom">Social Links</h2>
            <p class="text-muted">Manage your connected social accounts</p>
        </div>

        <div class="row justify-content-center g-4">

            <!-- Facebook -->
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm text-center p-4 h-100">
                    <div class="d-flex justify-content-center mb-3">
                        <i class="bi bi-facebook text-primary" style="font-size: 60px;"></i>
                    </div>
                    <h6 class="fw-bold">Facebook</h6>

                    @if ($facebookToken)
                        <p class="small">✅ Connected</p>
                        <span class="badge bg-success px-3 py-2">Connected</span>
                    @else
                        <p class="small text-muted mb-1">No account connected</p>
                        <a href="{{ route('superadmin.facebook.login') }}" class="btn btn-primary btn-sm mt-2">Connect</a>
                    @endif
                </div>
            </div>

            <!-- Instagram -->
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm text-center p-4 h-100">
                    <div class="d-flex justify-content-center mb-3">
                        <i class="bi bi-instagram text-danger" style="font-size: 60px;"></i>
                    </div>
                    <h6 class="fw-bold">Instagram</h6>

                    @if (isset($facebookToken->instagram_business_id) ?? false)
                        <p class="small">✅ Connected</p>
                        <span class="badge bg-success px-3 py-2">Connected</span>
                    @else
                        <p class="small text-muted mb-1">No account connected</p>
                        <a href="{{ route('superadmin.facebook.login') }}" class="btn btn-danger btn-sm mt-2">Connect</a>
                    @endif
                </div>
            </div>

           

            <!-- TikTok -->
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm text-center p-4 h-100">
                    <div class="d-flex justify-content-center mb-3">
                        {{-- <i class="bi bi-tiktok" style="font-size: 60px; color: #000;"></i> --}}
                        <!-- If Bootstrap Icons doesn't have TikTok, use FontAwesome -->
                        <i class="fa-brands fa-tiktok" style="font-size:60px; color:#000;"></i> 
                    </div>
                    <h6 class="fw-bold">TikTok</h6>

                    {{-- @if (isset($tiktokToken) ?? false)
                        <p class="small">✅ Connected</p>
                        <span class="badge bg-success px-3 py-2">Connected</span>
                    @else
                        <p class="small text-muted mb-1">No account connected</p> --}}
                        <a href="#"
                            class="btn btn-dark btn-sm mt-2 text-white">Comming Soon</a>
                    {{-- @endif --}}
                </div>
            </div>


        </div>
    </div>

    <style>
        .card {
            border-radius: 12px;
            transition: 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
