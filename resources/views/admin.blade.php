@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Administrare</h1>
    <ul class="list-group mt-4">
        <li class="list-group-item">
            <a href="{{ route('utilizatori.index') }}">Editează utilizatorii</a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('rates.index') }}">Editează ratele de schimb</a>
        </li>
    </ul>
</div>
@endsection