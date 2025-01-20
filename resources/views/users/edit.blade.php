@extends('layouts.main')
@section('content')
    <x-pages.pageheader color="bg-primary" num="Update Student" />
    <div class="wrapper wrapper-content">
        <div class="d-flex justify-content-end mb-3">
            <a class="btn btn-success text-white" href="{{ route('pages.page1') }}">Cancel</a>
        </div>
        <div class="ibox-content bg-white p-5">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('users.update', [$user->id]) }}" class="p-5">
                @method('PUT')
                @csrf
                <div class="row m-2">
                    <input type="text" placeholder="Full Name" name="name" value="{{old('name', $user->name)}}" class="form-control w-100">
                </div>
                <div class="row m-2">
                    <input type="email" placeholder="Email" name="email" value="{{old('email', $user->email)}}" class="form-control w-100">
                </div>
                <div class="row m-2">
                    <input type="submit" value="UPDATE" class="btn btn-primary w-100">
                </div>
            </form>
        </div>
    </div>
@endsection
