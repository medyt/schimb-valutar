<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ActiuniController extends Controller
{
    public function index()
    {
        // Interogăm tabela rate_schimb
        $rate = DB::table('rate_schimb')->get();

        // detaliile casei de schimb de care apartine utilizatorul logat
        $user = auth()->user();
        $casadeschimb = $user->casadeschimb;

        // Returnăm datele către view-ul 'actiuni'
        return view('actiuni', ['rate' => $rate, 'casadeschimb' => $casadeschimb]);
    }
}