@extends('layout.website_layout.bikes.car_main')
@section('content')
@section('title', '{{ $blog->title }} - Auto Jazeera')
<link rel="stylesheet" href="{{ asset('web/bikes/css/bike_home.css') }}">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    body {
        font-family: 'poppins', sans-serif !important;
        background-color: #FBFBFB !important;
    }

    .blog-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .blog-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .blog-title {
        color: #281F48;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 15px;
        line-height: 1.3;
    }

    .blog-meta {
        color: #666;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .blog-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 30px;
    }

    .blog-content {
        color: #333;
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 30px;
    }

    .blog-tags {
        margin-top: 30px;
    }

    .tag {
        display: inline-block;
        background-color: #F40000;
        color: white;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 12px;
        margin-right: 8px;
        margin-bottom: 8px;
    }

    .back-btn {
        background-color: #281F48;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 20px;
        transition: background-color 0.3s;
    }

    .back-btn:hover {
        background-color: #1a1530;
        color: white;
        text-decoration: none;
    }
</style>

<div class="container mt-5">
    <div class="row">
    <div class="col-md-12">
          <a href="{{ route('all-blogs') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Blogs
        </a>

        <div class="blog-header">
            <h1 class="blog-title">{{ $blog->title }}</h1>
            <div class="blog-meta">
                <i class="fas fa-calendar"></i> Published on {{ $blog->created_at->format('F d, Y') }}
            </div>
        </div>

        @if ($blog->image)
            <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="blog-image">
        @endif

        <div class="blog-content">
            {!! $blog->description !!}
        </div>

        @if ($blog->tags)
            <div class="blog-tags">
                <h5 style="color: #281F48; margin-bottom: 15px;">Tags:</h5>
                @foreach (json_decode($blog->tags) as $tag)
                    <span class="tag">{{ trim($tag) }}</span>
                @endforeach
            </div>
        @endif
    </div>
    </div>
</div>

@endsection
