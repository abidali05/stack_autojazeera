@extends('layout.website_layout.bikes.car_main')
@section('title', 'Forum - Auto Jazeera')
@section('content')

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 style="color: #281F48; font-weight: 700;">Discussion Forum</h2>
                    @auth
                        <a href="{{ route('forum.favorites') }}" class="btn btn-outline-warning">
                            <i class="fas fa-star"></i> My Favorites
                        </a>
                    @endauth
                </div>

                <div class="card">
                    <div class="card-header" style="background-color: #281F48; color: white;">
                        <h5 class="mb-0">Categories</h5>
                    </div>
                    <div class="card-body p-0">
                        @foreach ($categories as $category)
                            <div class="border-bottom p-3">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <h6 class="mb-1">
                                            <a href="{{ route('forum.category', $category->id) }}"
                                                style="color: #281F48; text-decoration: none;">
                                                {{ $category->name }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">{{ $category->description }}</small>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <strong>{{ $category->threads_count }}</strong><br>
                                        <small class="text-muted">Threads</small>
                                    </div>
                                    <div class="col-md-4">
                                        @if ($category->latestThreads->count())
                                            @foreach ($category->latestThreads as $thread)
                                                <small>
                                                    <a href="{{ route('forum.thread', $thread->id) }}">
                                                        {{ Str::limit($thread->title, 30) }}
                                                    </a>
                                                    {{ $thread->created_at->shortAbsoluteDiffForHumans() }}
                                                </small>
                                                <br>
                                            @endforeach
                                        @else
                                            <small class="text-muted">No threads yet</small>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
