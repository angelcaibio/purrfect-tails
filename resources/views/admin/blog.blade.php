@extends('layouts.admin.main')
@section('title', '' . $post->title)
@section('content')

<x-pages.pageheader 
    color="bg-primary" 
    title="{{ $post->title }}" 
    buttonTitle="Back" 
    url="{{ route('admin.blogs') }}"  
/>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <h5>{{ $post->author }}</h5>
                    <p>{{ $post->created_at->format('F j, Y') }}</p> 
                    <p>
                        <span class="badge badge-secondary">{{ $category_name }}</span>
                    </p>
                    <div>{!! nl2br($post->content) !!}</div>
                    @if (!empty($photos))
                    <div class="row">
                        @foreach ($photos as $photo)
                            <div class="col-md-4">
                                <img src="{{ asset('storage/' . $photo) }}" class="img-fluid" alt="Blog Photo">                          
                            </div>
                        @endforeach
                    </div>
                @endif

                    <hr>

                    @if (!empty($tags))
                        <div class="d-flex flex-wrap">
                            @foreach ($tags as $tag)
                                <div class="badge bg-primary mr-2" style="font-size: .5rem; padding: 0.5rem 1rem;">
                                    {{ $tag }} 
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
