@extends('layout.website_layout.bikes.car_main')
@section('title', 'Forum - Auto Jazeera')
@section('content')
<style>
    .btnb{
color: #281F48;
background-color:white;
border: 1px solid #281F48;
padding: 10px 20px;
border-radius: 5px;
font-size: 14px;
font-weight: 500;
    }
    .redd{
        color: #D90600;
    }
    .blu{
        color: #281F48;
    }
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
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 style="color: #281F48; font-weight: 700;">Discussion Forum</h2>
                    @auth
                        <a href="{{ route('forum.favorites') }}" class="btnb">
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
                                                style="color: #281F48; text-decoration: none; font-weight: 600;">
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
                                                <small class="blu">
                                                    <a class="redd" href="{{ route('forum.thread', $thread->id) }}">
                                                        {{ Str::limit($thread->title, 30) }}
                                                    </a>
                                                    {{ $thread->created_at->shortAbsoluteDiffForHumans() }}
                                                </small>
                                                <br>
                                            @endforeach
                                        @else
                                            <small class="blu">No threads yet</small>
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
