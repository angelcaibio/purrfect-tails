@extends('layouts.user.main')
@section('title','Purrfect Tails | Register')
@section('content')

<div
    class="container d-flex justify-content-center align-items-center responsive-height"
    style="height: 100vh;">
    <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">

        <h5 class="text-center mb-4">Register</h5>

        <!-- Check if there are any error messages -->
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form role="form" method="POST" action="{{ route('register') }}">
            @csrf
            <!-- Name Input -->
            <div class="mb-3">
                <label for="username" class="form-label">Full Name</label>
                <input type="text" name="username" class="form-control" required="required" value="{{ old('username') }}">
            </div>

            <!-- Email Input -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required="required" value="{{ old('email') }}">
            </div>

            <!-- Password Input -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required="required">
            </div>

            <!-- Confirm Password Input -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required="required">
            </div>

            <button type="submit" class="btn btn-primary w-100" name="register">Register</button>
            <div class="text-center mt-3">
                <a href="{{ route('user.login') }}">Already have an account? Login</a>
            </div>
            <div class="text-center mt-4">
                <hr class="my-4">
                <p class="text-muted mb-2">Or login with</p>
            </div>
            <div class="d-grid gap-2">
                <a href="{{ url('login/google') }}" class="btn btn-danger d-flex align-items-center justify-content-center">
                    <i class="bi bi-google me-2"></i> Login with Google
                </a>
                <a href="{{ url('login/facebook') }}" class="btn btn-primary d-flex align-items-center justify-content-center">
                    <i class="bi bi-facebook me-2"></i> Login with Facebook
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
