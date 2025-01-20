@extends('layouts.user.main')

@section('content')
    <section class="section bg-light">
        <div class="container">
            <div class="row align-items-stretch retro-layout">
                @foreach ($posts as $post)
                    <div class="col-md-4">
                        <a href="{{ route('post.show', $post->id) }}" class="h-entry mb-30 v-height gradient">
                        @php
                            $firstImage = 'storage/posts/default.jpg'; 
                            if (!empty($post->photo)) {
                                $photos = explode(',', $post->photo);
                                $firstImage = isset($photos[0]) && $photos[0] 
                                            ? 'storage/posts/' . trim($photos[0]) 
                                            : 'storage/posts/default.jpg';
                            }
                        @endphp
                        <div class="featured-img" 
                            style="background-image: url('{{ asset($firstImage) }}'); 
                                    background-size: cover; background-position: center;">
                        </div>
                            <div class="text">
                                <span class="date">{{ \Carbon\Carbon::parse($post->created_at)->format('M. jS, Y') }}</span>
                                <h2>{{ $post->title }}</h2>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Second Section with Latest Posts -->
    <section class="section posts-entry">
        <div class="container">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h2 class="posts-entry-title">Latest Posts</h2>
                </div>
                <div class="col-sm-6 text-sm-end">
                    <a href="{{ route('user.index') }}" class="read-more">View All</a>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-md-9">
                    <div class="row g-3">
                        @foreach ($posts as $post)
                            <div class="col-md-6">
                                <div class="blog-entry">
                                    <a href="{{ route('post.show', $post->id) }}" class="img-link">
                                        <img src="{{ $post->first_photo_url }}" alt="{{ $post->title }}" class="img-fluid" style="object-fit: cover; height: 260px; width: 450px;">
                                    </a>
                                    <span class="date">{{ \Carbon\Carbon::parse($post->created_at)->format('M. jS, Y') }}</span>
                                    <h2>
                                        <a href="{{ route('post.show', $post->id) }}">{{ $post->title }}</a>
                                    </h2>
                                    <p>{{ Str::limit(strip_tags($post->content), 100) }}...</p>
                                    <p>
                                        <a href="{{ route('post.show', $post->id) }}" class="btn btn-sm btn-outline-primary">Read More</a>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-3">
                    <ul class="list-unstyled blog-entry-sm">
                        @foreach ($posts as $post)
                            <li>
                                <span class="date">{{ \Carbon\Carbon::parse($post->created_at)->format('M. jS, Y') }}</span>
                                <h3>
                                    <a href="{{ route('post.show', $post->id) }}">{{ $post->title }}</a>
                                </h3>
                                <p>{{ Str::limit(strip_tags($post->content), 50) }}...</p>
                                <p>
                                    <a href="{{ route('post.show', $post->id) }}" class="read-more">Continue Reading</a>
                                </p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
