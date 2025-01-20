@extends('layouts.admin.main')
@section('title', 'Blogs')
@section('content')

<!-- Breadcrumbs and header component -->
<x-pages.pageheader 
    color="bg-primary" 
    title="Blogs" 
    buttonTitle="Add New Blog" 
    url="{{ route('blogs.create') }}"  />

<!-- Main Content -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <!-- Table of Blog Posts -->
                    <table
                        class="footable posts table table-striped"
                        data-page-size="8"
                        data-filter="#filter">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Date Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="postsBody">
                            @if (!empty($posts) && $posts->count() > 0)
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->author }}</td>
                                    <td>{{ $post->created_at }}</td>

                                    <td>
                                        <a href="{{ route('admin.blog', $post->id) }}" class="btn btn-outline-info">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('blogs.edit', $post->id) }}" class="btn btn-outline-success">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('blogs.destroy', $post->id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="btn btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to delete this blog?');">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            @else
                                <tr>
                                    <td colspan="4" class="text-center">No blogs available</td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    {{ $posts->links('pagination::bootstrap-4') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
