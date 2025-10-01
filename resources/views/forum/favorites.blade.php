@extends('layout.website_layout.bikes.car_main')
@section('title', 'My Favorites - Forum')
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
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('forum.index') }}" class="blu">Forum</a></li>
                    <li class="breadcrumb-item active" style="color:#F40000">My Favorites</li>
                </ol>
            </nav>

            <h2 class="mb-4" style="color: #281F48; font-weight: 700;">My Favorite Threads</h2>

            <div class="card mb-3">
                <div class="card-body p-0">
                    @forelse($favorites as $favorite)
                    <div class="border-bottom p-3">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h6 class="mb-1">
                                    <a href="{{ route('forum.thread', $favorite->thread->id) }}" 
                                       style="color: #281F48; text-decoration: none; font-weight: 600;font-size: 18px;">
                                        {{ $favorite->thread->title }}
                                    </a>
                                </h6>
                                <small class="blu" style="font-size: 14px;">
                                    in <a href="{{ route('forum.category', $favorite->thread->category->id) }}" class="redd" >
                                        {{ $favorite->thread->category->name }}
                                    </a>
                                    by {{ $favorite->thread->user->name }} 
                                    {{ $favorite->thread->created_at->diffForHumans() }}
                                </small>
                                <div class="mt-1">
                                    <small class="text-muted me-3">
                                        <i class="fas fa-heart text-danger"></i> {{ $favorite->thread->likes_count }}
                                    </small>
                                    <small class="text-muted me-3">
                                        <i class="fas fa-eye"></i> {{ $favorite->thread->views_count }}
                                    </small>
                                    <small class="text-muted">
                                        <i class="fas fa-comments"></i> {{ $favorite->thread->posts()->count() }}
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <small class="blu">
                                    Favorited {{ $favorite->created_at->diffForHumans() }}
                                </small>
                                <div class="mt-2">
                                    <button class="btn btn-sm  favorite-btn btnb" 
                                            data-thread-id="{{ $favorite->thread->id }}"
                                            data-favorited="true">
                                        <i class="fas fa-star "></i> Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center text-muted">
                        <i class="fas fa-star fa-3x mb-3 blu"></i>
                        <h5 class="blu">No favorite threads yet</h5>
                        <p class="blu">Start exploring the forum and save threads you find interesting!</p>
                        <a href="{{ route('forum.index') }}" class="btnb">Browse Forum</a>
                    </div>
                    @endforelse
                </div>
            </div>

            {{ $favorites->links() }}
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Favorite functionality
    document.querySelectorAll('.favorite-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const threadId = this.dataset.threadId;
            
            fetch('{{ route("forum.toggle-favorite") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ thread_id: threadId })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.favorited) {
                    // Remove the favorite item from the list
                    this.closest('.border-bottom').remove();
                }
            });
        });
    });
});
</script>

@endsection