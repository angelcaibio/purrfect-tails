@extends('layouts.user.main')
@section('content')
    <div class="section search-result-wrap">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="heading">Category: {{ $category->name }}</div>
                </div>
            </div>

            <div class="row posts-entry">
                <div class="col-lg-8">
                    @if($posts->isNotEmpty())
                        @foreach($posts as $post)
                        <div class="blog-entry d-flex blog-entry-search-item">
                            <a href="{{ route('post.show', $post->id) }}" class="img-link me-4">
                                <img src="{{ asset('storage/posts/' . explode(',', $post->photo)[0]) }}" alt="Image" class="img-fluid" style="width: 150px; height: 150px; object-fit: cover;">
                            </a>
                            <div>
                                <span class="date">{{ $post->created_at->format('F j, Y') }}</span>
                                <h2><a href="{{ route('post.show', $post->id) }}">{{ $post->title }}</a></h2>
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 150) }}...</p>
                                <a href="{{ route('post.show', $post->id) }}" class="btn btn-sm btn-outline-primary">Read More</a>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p>No results found in "{{ $category->name }}".</p>
                    @endif

                    <div class="row text-start pt-5 border-top">
                        <div class="col-md-12">
                            <div class="custom-pagination">
                                @if($page > 1)
                                    <a href="{{ route('users.category', ['categoryId' => $category->id, 'page' => $page - 1]) }}">
                                        <i class="bi bi-chevron-compact-left"></i>
                                    </a>
                                @endif
                                @for ($i = 1; $i <= $totalPages; $i++)
                                    <a href="{{ route('users.category', ['categoryId' => $category->id, 'page' => $i]) }}" class="{{ $i == $page ? 'active' : '' }}">{{ $i }}</a>
                                @endfor
                                @if($page < $totalPages)
                                    <a href="{{ route('users.category', ['categoryId' => $category->id, 'page' => $page + 1]) }}">
                                        <i class="bi bi-chevron-compact-right"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 sidebar">
                    <div class="sidebar-box">
                        <h3 class="heading">Latest Posts</h3>
                        <div class="post-entry-sidebar">
                            <ul>
                                @foreach($recentPosts as $post)
                                    <li>
                                        <a href="{{ route('post.show', $post->id) }}">
                                            <img src="{{ asset('storage/posts/' . explode(',', $post->photo)[0]) }}" alt="Image" class="me-4 rounded">
                                            <div class="text">
                                                <h4>{{ $post->title }}</h4>
                                                <div class="post-meta">
                                                    <span class="mr-2">{{ $post->created_at->format('F j, Y') }}</span>
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
    </div>
@endsection
