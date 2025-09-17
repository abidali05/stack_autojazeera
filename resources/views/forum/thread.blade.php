@extends('layout.website_layout.bikes.car_main')
@section('title', $thread->title . ' - Forum')
@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('forum.index') }}">Forum</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('forum.category', $thread->category->id) }}">{{ $thread->category->name }}</a></li>
                    <li class="breadcrumb-item active">{{ Str::limit($thread->title, 50) }}</li>
                </ol>
            </nav>

            <div class="card mb-4">
                <div class="card-header" style="background-color: #281F48; color: white;">
                    <h5 class="mb-0">{{ $thread->title }}</h5>
                </div>
            </div>

            @foreach($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 text-center border-end">
                            <strong>{{ $post->user->name }}</strong><br>
                            <small class="text-muted">{{ $post->created_at->format('M d, Y') }}</small>
                        </div>
                        <div class="col-md-10">
                            <div class="mb-3">{!! nl2br(e($post->body)) !!}</div>
                            
                            @auth
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-sm btn-outline-primary reply-btn" 
                                        data-post-id="{{ $post->id }}">
                                    Reply
                                </button>
                                @if($post->user_id === Auth::id())
                                <form action="{{ route('forum.delete-post', $post->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                                @endif
                            </div>
                            @endauth

                            <!-- Reply Form -->
                            @auth
                            <div class="reply-form mt-3" id="reply-form-{{ $post->id }}" style="display: none;">
                                <form action="{{ route('forum.store-reply', $thread->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="parent_id" value="{{ $post->id }}">
                                    <div class="mb-3">
                                        <textarea name="body" class="form-control" rows="3" 
                                                  placeholder="Write your reply..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-sm" 
                                            style="background-color: #F40000; color: white;">
                                        Post Reply
                                    </button>
                                    <button type="button" class="btn btn-sm btn-secondary cancel-reply">
                                        Cancel
                                    </button>
                                </form>
                            </div>
                            @endauth

                            <!-- Nested Replies -->
                            @foreach($post->replies as $reply)
                            <div class="ms-4 mt-3 border-start ps-3">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $reply->user->name }}</strong>
                                    <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="mt-2">{!! nl2br(e($reply->body)) !!}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            {{ $posts->links() }}

            @auth
            @if(!$thread->is_locked)
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Post Reply</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('forum.store-reply', $thread->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="body" class="form-control" rows="5" 
                                      placeholder="Write your reply..." required></textarea>
                        </div>
                        <button type="submit" class="btn" 
                                style="background-color: #F40000; color: white;">
                            Post Reply
                        </button>
                    </form>
                </div>
            </div>
            @else
            <div class="alert alert-warning">
                This thread is locked. No new replies can be posted.
            </div>
            @endif
            @else
            <div class="alert alert-info">
                Please <a href="{{ route('login') }}">login</a> to post a reply.
            </div>
            @endauth
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reply button functionality
    document.querySelectorAll('.reply-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const postId = this.dataset.postId;
            const form = document.getElementById(`reply-form-${postId}`);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        });
    });

    // Cancel reply
    document.querySelectorAll('.cancel-reply').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.reply-form').style.display = 'none';
        });
    });
});
</script>

@endsection