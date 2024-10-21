@extends('layouts.app')

@section('content')
    <header class="bg-primary text-black">
        <div class="aciuni-info">
            <div>{{ $data }}</div>
            <div>
                <div style="display: inline;">{{ $casadeschimb->name }} - {{ $casadeschimb->Address }}</div>
                <div class="actiuni-role">
                @if($role === 'Admin')
                    <a class="admin-link" href="/admin">{{ $role }}</a>
                @else
                    {{ $role }}
                @endif
                </div>
            </div>
        </div>
        <nav>
            <ul class="nav justify-content-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-black" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Tranzacții
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#cumparareModal">Cumpărare</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#vanzareModal"">Vânzare</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#cumpavanzModal">Cumpărare și Vânzare</a>
                    </div>
                </li>                
                <li class="nav-item">
                    <a class="nav-link text-black" href="#" data-toggle="modal" data-target="#ratesModal">Curs valutar</a>
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
                    <a class="nav-link text-black" href="#services">Utilitare</a>
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
    <!-- Modal pentru curs valutar -->
    <div class="modal fade" id="ratesModal" tabindex="-1" role="dialog" aria-labelledby="ratesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-design">
                <div class="modal-body">
                    <!-- Mută secțiunea #rates aici -->
                    <section id="rates">
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
                </div>
            </div>
        </div>
    </div>
    <!-- Modal pentru cumparare-->
    <div class="modal fade" id="cumparareModal" tabindex="-1" role="dialog" aria-labelledby="cumparareModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content modal-cumparare">
                <div class="modal-body">
                    <div class="header container">
                        <div class="row">
                            <!-- Issuer Information -->
                            <div class="col-md-6">
                                <p><strong>Emitent: {{ $casadeschimb->name }}</strong></p>
                                <p><strong>Sediul: {{ $casadeschimb->sediu_social }}</strong></p>
                                <p><strong>PSV 1 - {{ $casadeschimb->Address }}</strong></p>
                            </div>
                            <!-- Date and Time -->
                            <div class="col-md-6 text-right">
                                <p><strong>Data: {{ $factura['dataFactura'] }}, Ora: {{ $factura['oraFactura'] }}</strong></p>
                            </div>
                        </div>
                        <div class="row text-center">
                            <!-- Receipt Title -->
                            <div class="col-12">
                                <h3>Chitanța de Schimb Valutar - Cumpărare</h3>
                                <h4>Seria SITUR Numărul 5</h4>
                            </div>
                        </div>
                    </div>
                    @include('cumparare')
                </div>                
            </div>
        </div>
    </div>

    <!-- Modal pentru vanzare-->
    <div class="modal fade" id="vanzareModal" tabindex="-1" role="dialog" aria-labelledby="vanzareModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content modal-cumparare">
                <div class="modal-body">
                    <div class="header container">
                        <div class="row">
                            <!-- Issuer Information -->
                            <div class="col-md-6">
                                <p><strong>Emitent: {{ $casadeschimb->name }}</strong></p>
                                <p><strong>Sediul: {{ $casadeschimb->sediu_social }}</strong></p>
                                <p><strong>PSV 1 - {{ $casadeschimb->Address }}</strong></p>
                            </div>
                            <!-- Date and Time -->
                            <div class="col-md-6 text-right">
                                <p><strong>Data: {{ $factura['dataFactura'] }}, Ora: {{ $factura['oraFactura'] }}</strong></p>
                            </div>
                        </div>
                        <div class="row text-center">
                            <!-- Receipt Title -->
                            <div class="col-12">
                                <h3>Chitanța de Schimb Valutar - Vanzare</h3>
                                <h4>Seria SITUR Numărul 5</h4>
                            </div>
                        </div>
                    </div>
                    @include('vanzare')
                </div>                
            </div>
        </div>
    </div>

    <!-- Modal pentru cumparare si vanzare-->
    <div class="modal fade" id="cumpavanzModal" tabindex="-1" role="dialog" aria-labelledby="cumpavanzModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content modal-cumparare">
                <div class="modal-body">
                    <div class="header container">
                        <div class="row">
                            <!-- Issuer Information -->
                            <div class="col-md-6">
                                <p><strong>Emitent: {{ $casadeschimb->name }}</strong></p>
                                <p><strong>Sediul: {{ $casadeschimb->sediu_social }}</strong></p>
                                <p><strong>PSV 1 - {{ $casadeschimb->Address }}</strong></p>
                            </div>
                            <!-- Date and Time -->
                            <div class="col-md-6 text-right">
                                <p><strong>Data: {{ $factura['dataFactura'] }}, Ora: {{ $factura['oraFactura'] }}</strong></p>
                            </div>
                        </div>
                        <div class="row text-center">
                            <!-- Receipt Title -->
                            <div class="col-12">
                                <h3>Chitanța de Schimb Valutar - Cumpărare si Vanzare</h3>
                                <h4>Seria SITUR Numărul 5</h4>
                            </div>
                        </div>
                    </div>
                    @include('cumpararevanzare')
                </div>                
            </div>
        </div>
    </div>
@endsection