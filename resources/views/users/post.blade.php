@extends('layouts.user.main')
@section('title', $post->title)

@section('content')

<div class="site-cover site-cover-sm same-height overlay single-page" 
     style="background-image: url('{{ $background }}'); background-size: cover; background-position: center;">
    <div class="container">
        <div class="row same-height justify-content-center">
            <div class="col-md-6">
                <div class="getPost-entry text-center">
                    <h1 class="mb-4">{{ $post->title }}</h1>
                    <div class="getPost-meta align-items-center text-center">
                        <figure class="author-figure mb-0 me-3 d-inline-block">
                            <img src="{{ $author_image }}" alt="Author Image" class="img-fluid rounded-circle author-photo">
                        </figure>
                        <span class="d-inline-block mt-1">By {{ $post->author }}</span>
                        <span>&nbsp;-&nbsp;{{ \Carbon\Carbon::parse($post->created_at)->format('F j, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="row blog-entries element-animate">
            <div class="col-md-12 col-lg-8 main-content">
                <div class="getPost-content-body">
                    <div>{!! nl2br($post->content) !!}</div>
                    <div class="pt-5">
                        <p>Category: <a href="#">{{ $category_name }}</a></p>
                        <p>Tags:
                            @foreach ($tags as $tag)
                                <a href="#">{{ $tag }}</a>@if (!$loop->last), @endif
                            @endforeach
                        </p>
                    </div>

                    <div class="like-share-container">
                        @guest
                            <div class="unregistered-like mt-5">
                                <span class="badge bg-primary">{{ $likeCount }} Likes</span>
                            </div>
                        @else
                            <div class="mt-5">
                                <form id="likeForm" action="{{ route('likePost', $post->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <button id="likeButton" data-post-id="{{ $post->id }}" class="text-bg-light" style="border: none;">
                                        <i class="{{ auth()->user()->hasLiked($post->id) ? 'bi bi-heart-fill' : 'bi bi-heart' }}"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="like-button mt-5">
                                <span id="likeCount" class="badge bg-primary">{{ $likeCount }} Likes</span>
                            </div>
                        @endguest
                        <div class="share-buttons mt-5">
                            <div>
                                <span class="badge text-bg-secondary" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#shareModal">
                                    <i class="bi bi-share"></i> Share
                                </span>
                            </div>
                        </div>
                    </div>

  <!-- Comments Section -->
  <div class="comments-section">
        <h5 class="mb-3 mt-5">Comments</h5>

        @guest
            <div class="alert alert-primary text-center p-5">
                <p>Please log in or register to leave a comment.</p>
                <a href="{{ route('user.login') }}" class="btn btn-outline-primary">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-secondary">Register</a>
            </div>
        @else
            <!-- Comment Form -->
            <form id="commentForm" action="{{ route('comment.store', $post->id) }}" method="POST">
                @csrf
                <textarea class="form-control" name="comment" rows="3" required="required"></textarea>
                <button type="submit" class="btn btn-primary mt-2">Submit Comment</button>
            </form>
        @endguest
    </div>
<!-- Display Comments -->
<div class="pt-5 comment-wrap">
    <h3 class="mb-5 heading" id="commentCount">{{ count($comments) }} Comment{{ count($comments) > 1 ? 's' : '' }}</h3>
    <ul id="commentsList" class="comment-list">
        @foreach ($comments as $comment)
            <li id="comment_{{ $comment->id }}" class="comment">
                <div class="vcard">
                    <!-- Profile Picture -->
                    <img src="{{ filter_var($comment->user->profile_picture, FILTER_VALIDATE_URL) ? $comment->user->profile_picture : asset('storage/profile_picture/' . ($comment->user->profile_picture ?? 'default.jpg')) }}" 
                        alt="{{ $comment->user->name }}" 
                        class="img-fluid rounded-circle" 
                        style="height:50px; width:50px; object-fit: cover;">
                </div>
                <div class="comment-body">
                    <h5>{{ $comment->user->username }}</h5>
                    <div class="meta">{{ \Carbon\Carbon::parse($comment->created_at)->format('F j, Y \a\t h:i A') }}</div>
                    <p>{{ $comment->comment }}</p>
                    <!-- Delete button for the logged-in user who made the comment -->
                    @if (auth()->check() && auth()->id() == $comment->user_id)
                    <form action="{{ route('comment.delete', $comment->id) }}" method="POST" class="delete-form" data-id="{{ $comment->id }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="badge bg-danger delete-btn" style="cursor: pointer;">Delete</button>
                        </form>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
</div>

                </div>
            </div>

            <div class="col-md-12 col-lg-4 sidebar">
                <div class="sidebar-box">
                    <h3 class="heading">Latest Posts</h3>
                    <div class="post-entry-sidebar">
                        <ul>
                            @foreach($recentPosts as $post)
                                <li>
                                    <a href="{{ route('post.show', $post->id) }}">
                                        @php
                                            $firstImage = explode(',', $post->photo)[0];
                                        @endphp
                                        <img src="{{ asset('storage/posts/' . $firstImage) }}" alt="Image" class="me-4 rounded">
                                        <div class="text">
                                            <h4>{{ $post->title }}</h4>
                                            <div class="post-meta">
                                                <span class="mr-2">{{ \Carbon\Carbon::parse($post->created_at)->format('F j, Y') }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('includes.user.share')

@endsection
