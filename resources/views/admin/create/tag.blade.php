@extends('layouts.admin.main')
@section('title', 'Create Tag')
@section('content')

<x-pages.pageheader 
    color="bg-primary" 
    title="Add Tag" 
    buttonTitle="Cancel" 
    url="{{ route('admin.tags') }}" 
    style="margin-bottom:5px;" />

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                </div>
                <div class="ibox-content">

                    @if(session('error_message'))
                        <div class="alert alert-danger">{{ session('error_message') }}</div>
                    @endif

                    @if(session('success_message'))
                        <div class="alert alert-success">{{ session('success_message') }}</div>
                    @endif

                    <form method="POST" action="{{ route('tags.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Tag Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter tag name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group row">
                            <div class="col-sm-4 offset-sm-2">
                                <button class="btn btn-primary btn-sm" type="submit" id="create_category">Save Tag</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
