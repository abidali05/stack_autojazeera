@extends('layout.superadmin_layout.main')
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
       .btnbb{
color: white;
background-color:#281F48;
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
    </style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-12 mt-3">
                    <h1 class="blu" style="font-weight: 700">Edit Forum Category</h1>
                </div>
                <div class="col-md-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a class="blu" href="{{ route('superadmin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a class="blu" href="{{ route('superadmin.forum-categories.index') }}">Categories</a></li>
                        <li class="breadcrumb-item active" style="color: #F40000">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div  class=" p-3 rounded" style="border: 1px solid #281F48">
                        <div class="card-header">
                            <h3 class="card-title">Edit Category: {{ $category->name }}</h3>
                        </div>
                        <form action="{{ route('superadmin.forum-categories.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="my-3" for="name">Category Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $category->name) }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label  class="my-3" for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="4">{{ old('description', $category->description) }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btnb">Update Category</button>
                                <a href="{{ route('superadmin.forum-categories.index') }}" class="btnbb">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection