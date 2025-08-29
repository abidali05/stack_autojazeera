@extends('layout.panel_layout.main')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Connect Your Facebook Page</h4>
                </div>

                <div class="card-body">
                    <p class="text-muted text-center mb-4">
                        Please select the Facebook Page you want to connect with your dealer account.
                    </p>

                    <form action="{{ route('facebook.savePage') }}" method="POST">
                        @csrf

                        <div class="list-group">
                            @foreach($pages as $page)
                                <label class="list-group-item d-flex align-items-center">
                                    <input type="radio" name="page_id" value="{{ $page['id'] }}|{{ $page['access_token'] }}" class="form-check-input me-3" required>
                                    <div>
                                        <h6 class="mb-1">{{ $page['name'] }}</h6>
                                        <small class="text-muted">Page ID: {{ $page['id'] }}</small>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fab fa-facebook me-2"></i> Connect Page
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
