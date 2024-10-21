@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg form-login" style="width: 400px;">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Username Input -->
            <div class="mb-3">
                <label for="username" class="form-label">Nume de utilizator</label>
                <input id="username" type="username" class="input-login form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autofocus>

                @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="mb-3">
                <label for="password" class="form-label">Parola</label>
                <input id="password" type="password" class="input-login form-control @error('password') is-invalid @enderror" name="password" required>

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <!-- Submit Button -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-login" style="display:none">Logare</button>
            </div>
        </form>
    </div>
</div>
@endsection