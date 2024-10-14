@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="width: 400px;">
        <h3 class="text-center mb-4">Autentificare</h3>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Username Input -->
            <div class="mb-3">
                <label for="username" class="form-label">Nume de utilizator</label>
                <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autofocus>

                @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="mb-3">
                <label for="password" class="form-label">Parola</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- Remember Me Checkbox -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Ține-mă minte!</label>
            </div>

            <!-- Submit Button -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Logare</button>
            </div>

            <!-- Forgot Password Link -->
            @if (Route::has('password.request'))
                <div class="text-center mt-3">
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        Ai uitat parola?
                    </a>
                    <p class="mt-2">
                        Nu ai un cont? 
                        <a href="{{ route('register') }}">Inregistrare aici</a>.
                    </p>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection