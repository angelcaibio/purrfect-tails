@extends('layouts.admin.main')
@section('title', 'Media Library')
@section('content')

<!-- Breadcrumbs and header component -->
<x-pages.pageheader 
    color="bg-primary" 
    title="Media Library" />

<!-- Main Content -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        @if (!empty($existing_photos) && count($existing_photos) > 0)
            @foreach ($existing_photos as $photo)
                <div class="col-md-3 mb-2">
                    <div class="card h-100">
                        <img
                            src="{{ asset('storage/' . $photo['photo']) }}" 
                            class="card-img-top img-fluid"
                            alt="Photo"
                            data-toggle="modal"
                            data-target="#photoModal"
                            data-photo="{{ asset('storage/' . $photo['photo']) }}" 
                            data-title="{{ $photo['title'] }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $photo['title'] }}</h5>
                            <div class="card-text">
                                @if (!empty($photo['tags']))
                                    @foreach ($photo['tags'] as $tag)
                                        <span class="badge badge-secondary">{{ trim($tag) }}</span>
                                    @endforeach
                                @else
                                    <span class="badge badge-secondary">No Tags</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p style="margin-left: 10px;">No photos available.</p>
        @endif
    </div>
</div>

<!-- Modal for displaying the full-size photo -->
<div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Photo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="" id="modalPhoto" class="img-fluid" alt="Full-size Photo">
            </div>
        </div>
    </div>
</div>

@endsection
