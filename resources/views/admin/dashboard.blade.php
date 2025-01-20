@extends('layouts.admin.main') @section('title', 'Dashboard')
@section('content')
<x-pages.pageheader color="bg-primary" title="Dashboard"/>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        @foreach ([ ['label' => 'Posts', 'count' => $totalPosts, 'class' => 'success'],
        ['label' => 'Users', 'count' => $totalUsers, 'class' => 'info'], ['label' =>
        'Comments', 'count' => $totalComments, 'class' => 'danger'] ] as $panel)
        <div class="col-lg-4">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools">
                        <span class="label label-{{ $panel['class'] }} float-right">Total</span>
                    </div>
                    <h5>{{ $panel['label'] }}</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $panel['count'] }}</h1>
                    <small>Total number of
                        {{ strtolower($panel['label']) }}</small>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Recent Comments</h5>
                </div>
                <div class="ibox-content">
                    @if (empty($commentDetails))
                    <p class="text-center text-muted">No recent comments available.</p>
                    @else
                    <ul class="stat-list">
                        @foreach ($commentDetails as $detail)
                        <li>
                            <div class="feed-activity-list mt-1 mb-2">
                                <div class="feed-element">
                                    <a class="float-left">
                                        <img
                                           alt="Profile Picture"
                                            class="rounded-circle"
                                            src="{{ filter_var($detail['profile_picture'], FILTER_VALIDATE_URL) ? $detail['profile_picture'] : asset('storage/profile_picture/' . ($detail['profile_picture'] ?? 'default.jpg')) }}"
                                            style="object-fit: cover;">
                                    </a>
                                    <div class="media-body">
                                        <strong>{{ $detail['username'] }}</strong>
                                        commented on "{{ $detail['post_title'] }}"
                                        <br>
                                        <p class="mb-2 mt-1">{{ $detail['comment'] }}</p>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($detail['created_at'])->format('l g:i a - d.m.Y') }}</small><br>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Recent Users</h5>
                </div>
                <div class="ibox-content">
                    @if ($recentUsers->isEmpty())
                    <!-- Check if the collection is empty -->
                    <p class="text-center text-muted">No recent users available.</p>
                    @else @foreach ($recentUsers as $user)
                    <div>
                        <div class="feed-activity-list mt-1 mb-2">
                            <div class="feed-element">
                                <a class="float-left">
                                <img 
                                    src="{{ filter_var($user->profile_picture) ? $user->profile_picture : asset('storage/profile_picture/' . ($user->profile_picture ?? 'default.jpg')) }}" 
                                    alt="Profile Picture"
                                    style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                </a>
                                <div class="media-body">
                                    <strong>{{ $user->username }}</strong>
                                    has joined your blog
                                    <br>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($user->created_at)->format('l g:i a - d.m.Y') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection