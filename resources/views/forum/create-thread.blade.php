@extends('layout.website_layout.bikes.car_main')
@section('title', 'New Thread - ' . $category->name)
@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('forum.index') }}">Forum</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('forum.category', $category->id) }}">{{ $category->name }}</a></li>
                    <li class="breadcrumb-item active">New Thread</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header" style="background-color: #281F48; color: white;">
                    <h5 class="mb-0">Create New Thread in {{ $category->name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('forum.store-thread', $category->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Thread Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="body" class="form-label">Message</label>
                            <textarea class="form-control @error('body') is-invalid @enderror" 
                                      id="body" name="body" rows="8" required>{{ old('body') }}</textarea>
                            @error('body')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('forum.category', $category->id) }}" 
                               class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn" 
                                    style="background-color: #F40000; color: white;">
                                Create Thread
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection