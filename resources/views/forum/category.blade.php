@extends('layout.website_layout.bikes.car_main')
@section('title', $category->name . ' - Forum')
@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('forum.index') }}">Forum</a></li>
                    <li class="breadcrumb-item active">{{ $category->name }}</li>
                </ol>
            </nav>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 style="color: #281F48; font-weight: 700;">{{ $category->name }}</h2>
                @auth
                <a href="{{ route('forum.create-thread', $category->id) }}" 
                   class="btn" style="background-color: #F40000; color: white;">
                    New Thread
                </a>
                @endauth
            </div>

            <div class="card">
                <div class="card-body p-0">
                    @forelse($threads as $thread)
                    <div class="border-bottom p-3">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    @if($thread->is_pinned)
                                    <i class="fas fa-thumbtack text-warning me-2"></i>
                                    @endif
                                    @if($thread->is_locked)
                                    <i class="fas fa-lock text-danger me-2"></i>
                                    @endif
                                    <div>
                                        <h6 class="mb-1">
                                            <a href="{{ route('forum.thread', $thread->id) }}" 
                                               style="color: #281F48; text-decoration: none;">
                                                {{ $thread->title }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">
                                            by {{ $thread->user->name }} 
                                            {{ $thread->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <strong>{{ $thread->posts_count }}</strong><br>
                                <small class="text-muted">Posts</small>
                            </div>
                            <div class="col-md-4">
                                @if($thread->latestPost)
                                <small>
                                    Last post by {{ $thread->latestPost->user->name }}<br>
                                    {{ $thread->latestPost->created_at->diffForHumans() }}
                                </small>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center text-muted">
                        No threads in this category yet.
                    </div>
                    @endforelse
                </div>
            </div>

            {{ $threads->links() }}
        </div>
    </div>
</div>

@endsection