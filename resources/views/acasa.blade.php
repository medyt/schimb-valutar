@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header text-center bg-primary text-white">
                    <h2>Bun venit!</h2>
                </div>

                <div class="card-body text-center">
                    <h4 class="mb-4">Buna, {{ Auth::user()->name }}!</h4>
                    <p class="lead">Te-ai logat cu succes! Acum poti alege ce vrei sa faci in continuare.</p>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-lg">Editeaza profilul</a>
                        <a href="{{ route('actiuni') }}" class="btn btn-outline-secondary btn-lg">Actiuni</a>
                        <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-lg" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Delogare</a>
                    </div>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection