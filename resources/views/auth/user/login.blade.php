@extends('layouts.user.main')
@section('title','Purrfect Tails | Login')
@section('content')

<div
    class="container d-flex justify-content-center align-items-center responsive-height"
    style="height: 100vh;">
    <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">

        <h5 class="text-center mb-4">Login</h5>

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

        <form role="form" method="POST" action="{{ route('user.login') }}">
            @csrf
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

            <button type="submit" class="btn btn-primary w-100" name="login">Login</button>
            <div class="text-center mt-3">
                <a href="register.php">Don't have an account? Register</a>
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
