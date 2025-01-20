@extends('layouts.admin.main')
@section('title', 'Categories')
@section('content')

<x-pages.pageheader 
    color="bg-primary" 
    title="Categories" 
    buttonTitle="Add Category" 
    url="{{ route('categories.create') }}"  />

<!-- Main Content -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">


                    <table class="table table-striped footable categories" data-page-size="8" data-filter="#filter">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Date Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $category->name}}</td>
                                    <td>{{ $category->created_at}}</td>
                                    <td>
                                        <!-- Edit Category Modal Trigger -->
                                        <a href="javascript:void(0);" 
                                           data-toggle="modal" 
                                           data-target="#editCategoryModal-{{ $category->id }}" 
                                           class="btn btn-outline-success">
                                            <i class="fa fa-pencil"></i>
                                        </a>

                                        <!-- Delete Category Form -->
                                        <form method="POST" action="{{ route('categories.destroy', $category->id) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="btn btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to delete this category?');">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Include Edit Modal -->
                                @include('admin.edit.category', ['category' => $category])
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No categories available</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">
                                    {{ $categories->links('pagination::bootstrap-4') }}
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
