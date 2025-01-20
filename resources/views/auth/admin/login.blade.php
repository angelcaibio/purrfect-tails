@extends('layouts.admin.auth')
@section('title', 'Login')
@section('content')
    <h3>Welcome to Purrfect Tails</h3>
    <p>Please enter your credentials to access the admin dashboard.</p>
    <form method="POST" action="{{ route('admin.login') }}">
    @csrf
        <div class="form-group">
            <input
                placeholder="Email"
                id="email" 
                type="email" 
                class="form-control @error('email') is-invalid @enderror" name="email" 
                value="{{ old('email') }}" required autocomplete="email" 
                autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
        </div>
        <div class="form-group">
            <input
                placeholder="Password"
                id="password" 
                type="password" 
                class="form-control @error('password') is-invalid @enderror" 
                name="password" 
                required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
        </div>
        <button type="submit" class="btn btn-primary block full-width m-b" name="login">Login</button>
        <a href="{{ route('password.request') }}" class="password">
            <small>Forgot password?</small>
        </a>
    </form>
    <p class="m-t">
        <small>&copy; 2024 Purrfect Tails</small>
    </p>
@endsection
