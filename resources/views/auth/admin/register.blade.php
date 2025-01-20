@extends('layouts.admin.auth')
@section('title', 'Register')
@section('content')
    <h3>Welcome to Purrfect Tails</h3>
    <p>Please enter your details to create an admin account.</p>
    <form method="POST" action="{{ route('admin.register') }}">
        @csrf
        <div class="form-group">
            <input
                placeholder="Full Name"
                id="username" 
                type="text" 
                class="form-control @error('username') is-invalid @enderror" 
                name="username" 
                value="{{ old('username') }}" required autocomplete="username" 
                autofocus>
            @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <input
                placeholder="Email"
                id="email" 
                type="email" 
                class="form-control @error('email') is-invalid @enderror" 
                name="email" 
                value="{{ old('email') }}" required autocomplete="email">
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
                required autocomplete="new-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <input
                placeholder="Confirm Password"
                id="password_confirmation" 
                type="password" 
                class="form-control @error('password_confirmation') is-invalid @enderror" 
                name="password_confirmation" 
                required autocomplete="new-password">
            
            @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary block full-width m-b" name="register">Register</button>

    </form>

    <p class="m-t">
        <small>&copy; 2024 Purrfect Tails</small>
    </p>
@endsection
