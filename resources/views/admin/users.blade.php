@extends('layouts.admin.main')
@section('title', 'Users')
@section('content')

<x-pages.pageheader 
    color="bg-primary" 
    title="Users" />

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <table
                        class="footable users table table-striped"
                        data-page-size="8"
                        data-filter="#filter">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Number of Likes</th>
                                <th>Number of Comments</th>
                            </tr>
                        </thead>
                        <tbody id="usersBody">
                            @if ($users->count() > 0)
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img 
                                                    src="{{ filter_var($user->profile_picture, FILTER_VALIDATE_URL) ? $user->profile_picture : asset('storage/profile_picture/' . ($user->profile_picture ?? 'default.jpg')) }}" 
                                                    alt="Profile Picture" 
                                                    class="rounded-circle" 
                                                    style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
                                            </div>
                                        </td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->likes }}</td>
                                        <td>{{ $user->comments }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">No users available</td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    {{ $users->links('pagination::bootstrap-4') }}
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
