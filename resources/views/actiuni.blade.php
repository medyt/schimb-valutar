@extends('layouts.app')

@section('content')
    <header class="bg-primary text-black">
        <div class="aciuni-info">
            <div>{{ $data }}</div>
            <div>
                <div style="display: inline;">{{ $casadeschimb->name }} - {{ $casadeschimb->Address }}</div>
                <div class="actiuni-role">{{ $role }}</div>
            </div>
        </div>
        <nav>
            <ul class="nav justify-content-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-black" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Tranzacții
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('cumparare') }}">Cumpărare</a>
                        <a class="dropdown-item" href="{{ route('vanzare') }}">Vânzare</a>
                        <a class="dropdown-item" href="{{ route('cumpararevanzare') }}">Cumpărare și Vânzare</a>
                    </div>
                </li>                
                <li class="nav-item">
                    <a class="nav-link text-black" href="#rates">Curs valutar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-black" href="#services">Transferuri</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-black" href="#services">Rapoarte PSV</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-black" href="#services">Functii IF</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-black" href="#services">Utilizare</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link text-black" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Delogare</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </header>
    <section id="rates" class="container my-5" style="display:none">
        <h2 class="text-center">Rate de Schimb</h2>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Valută</th>
                    <th>Denumire Valută</th>
                    <th>Oficial</th>
                    <th>Cumpărare</th>
                    <th>Vânzare</th>
                    <th>Paritate</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rate as $rata)
                <tr>
                    <td>{{ $rata->valuta }}</td>
                    <td>{{ $rata->denumire_valuta }}</td>
                    <td>{{ $rata->oficial }}</td>
                    <td>{{ $rata->cumparare }}</td>
                    <td>{{ $rata->vanzare }}</td>
                    <td>{{ $rata->paritate }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection