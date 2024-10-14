@extends('layouts.app')

@section('content')
    <header class="bg-primary text-white text-center py-5">
        <h1>Bine ai venit la Casa de Schimb Valutar!</h1>
        <nav>
            <ul class="nav justify-content-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Tranzacții
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('cumparare') }}">Cumpărare</a>
                        <a class="dropdown-item" href="{{ route('vanzare') }}">Vânzare</a>
                        <a class="dropdown-item" href="{{ route('cumpararevanzare') }}">Cumpărare și Vânzare</a>
                    </div>
                </li>                
                <li class="nav-item">
                    <a class="nav-link text-white" href="#rates">Curs valutar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#services">Transferuri</a>
                </li>
            </ul>
        </nav>
    </header>

    <section class="container text-center my-5">
        <h2>Despre Casa de Schimb Valutar</h2>
        <p>Oferim cele mai bune rate de schimb și servicii rapide pentru toate valutele internaționale.</p>
        <p>Fie că ai nevoie să schimbi bani pentru o călătorie sau pentru alte tranzacții, noi suntem aici să te ajutăm!</p>
    </section>

    <section id="rates" class="container my-5">
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