@extends('layouts.admin.main')
@section('title', 'Comments')
@section('content')

<x-pages.pageheader color="bg-primary" title="Comments"/>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <table
                        class="footable comments table table-striped"
                        data-page-size="8"
                        data-filter="#filter">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Comment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="commentsBody">
                            @foreach ($comments as $comment)
                                <tr>
                                    <td>
                                        <img
                                            src="{{ filter_var($comment->profile_picture, FILTER_VALIDATE_URL) ? $comment->profile_picture : asset('storage/profile_picture/' . ($comment->profile_picture ?? 'default.jpg')) }}" 
                                            alt="Profile Picture"
                                            class="rounded-circle"
                                            style="width: 40px; height: 40px; object-fit: cover;">
                                    </td>
                                    <td>{{ $comment->username }}</td> <!-- Access username directly -->
                                    <td>{{ $comment->post_title }}</td> <!-- Post title -->
                                    <td>{{ $comment->comment_text }}</td> <!-- Comment text -->
                                    <td>
                                        <!-- View Post Button -->
                                        <a href="{{ route('admin.blog', $comment->post_id) }}" class="btn btn-outline-info">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <!-- Delete Comment Button -->
                                        <form action="{{ route('comment.remove', $comment->comment_id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="btn btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to delete this comment?');">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <!-- Pagination for comments -->
                                    {{ $comments->links('pagination::bootstrap-4') }}
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
