@extends('layouts.admin.main')
@section('title', 'Tags')
@section('content')

<x-pages.pageheader 
    color="bg-primary" 
    title="Tags" 
    buttonTitle="Add Tag" 
    url="{{ route('tags.create') }}"  />

<!-- Main Content -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">


                    <table class="table table-striped footable tags" data-page-size="8" data-filter="#filter">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Date Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tags as $tag)
                                <tr>
                                    <td>{{ $tag->name}}</td>
                                    <td>{{ $tag->created_at}}</td>
                                    <td>
                                        <!-- Edit Tag Modal Trigger -->
                                        <a href="javascript:void(0);" 
                                           data-toggle="modal" 
                                           data-target="#editTagModal-{{ $tag->id }}" 
                                           class="btn btn-outline-success">
                                            <i class="fa fa-pencil"></i>
                                        </a>

                                        <!-- Delete Tag Form -->
                                        <form method="POST" action="{{ route('tags.destroy', $tag->id) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="btn btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to delete this tag?');">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Include Edit Modal -->
                                @include('admin.edit.tag', ['tag' => $tag])
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No tags available</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right" >
                                    {{ $tags->links('pagination::bootstrap-4') }}
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
