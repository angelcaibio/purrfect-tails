@extends('layouts.admin.main')
@section('title', 'Edit Blog')
@section('content')

<x-pages.pageheader color="bg-primary" title="{{$blog->title}}" buttonTitle="Cancel" url="{{ route('admin.blogs') }}" style="margin-bottom:5px;" />

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Edit Blog</h5>
                </div>
                <div class="ibox-content">

                    @if(session('error_message'))
                        <div class="alert alert-danger">{{ session('error_message') }}</div>
                    @endif

                    @if(session('success_message'))
                        <div class="alert alert-success">{{ session('success_message') }}</div>
                    @endif

                    <form method="POST" action="{{ route('blogs.update', $blog->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title Input -->
                        <div class="form-group row">
                            <label for="title" class="col-sm-2 col-form-label">Title</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $blog->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <!-- Content Input -->
                        <div class="form-group row">
                            <label for="content" class="col-sm-2 col-form-label">Content</label>
                            <div class="col-sm-10">
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="6" required>{{ old('content', $blog->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <!-- Tags Input -->
                        <div class="form-group row">
                            <label for="tags" class="col-sm-2 col-form-label">Tags</label>
                            <div class="col-sm-10">
                                @foreach($tags as $tag)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag_{{ $tag->id }}"
                                        {{ in_array($tag->id, old('tags', explode(',', $blog->tags))) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
                                    </div>
                                @endforeach
                                @error('tags')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <!-- Category Select -->
                        <div class="form-group row">
                            <label for="category" class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10">
                                <select class="form-control @error('category') is-invalid @enderror" id="category" name="category" required>
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category', $blog->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <!-- Existing Photos Display -->
                        <div class="form-group row" id="photos-container" data-blog-id="{{ $blog->id }}">
                            @if (!empty($blog->photo))
                                @foreach(explode(',', $blog->photo) as $photo)
                                    <div class="position-relative m-2" style="width: 150px; height: 150px;">
                                        <img src="{{ asset('storage/posts/' . $photo) }}" alt="Photo" class="img-thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute" 
                                                style="top: 5px; right: 5px;"
                                                onclick="deletePhoto('{{ $photo }}', this)">
                                            X
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <!-- Optionally, show a message or leave it empty -->
                                <p  class="col-sm-2 col-form-label">No photos available</p>
                            @endif
                        </div>
                        <!-- Photo Upload -->
                        <div class="form-group row">
                            <label for="photos" class="col-sm-2 col-form-label">Upload New Photos</label>
                            <div class="col-sm-10">
                                <div class="custom-file">
                                    <input id="inputGroupFile02" type="file" multiple name="photos[]" class="custom-file-input" onchange="updateFileLabel()">
                                    <label class="custom-file-label" for="inputGroupFile02">Choose multiple photos</label>
                                </div>
                                @error('photos')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <!-- Submit Button -->
                        <div class="form-group row">
                            <div class="col-sm-4 offset-sm-2">
                                <button class="btn btn-primary btn-sm" type="submit">Update Blog</button>
                                <a href="{{ route('admin.blogs') }}" class="btn btn-secondary btn-sm">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
