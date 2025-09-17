@extends('layout.website_layout.bikes.car_main')
@section('title', 'Forum - Auto Jazeera')
@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4" style="color: #281F48; font-weight: 700;">Discussion Forum</h2>
            
            <div class="card">
                <div class="card-header" style="background-color: #281F48; color: white;">
                    <h5 class="mb-0">Categories</h5>
                </div>
                <div class="card-body p-0">
                    @foreach($categories as $category)
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
                                @if($category->latestThread)
                                <small>
                                    Latest: <a href="{{ route('forum.thread', $category->latestThread->id) }}">
                                        {{ Str::limit($category->latestThread->title, 30) }}
                                    </a><br>
                                    by {{ $category->latestThread->user->name }} 
                                    {{ $category->latestThread->created_at->diffForHumans() }}
                                </small>
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