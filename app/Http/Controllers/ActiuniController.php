<?php

namespace App\Http\Controllers;

use DB;
use DateTime;

class ActiuniController extends Controller
{
    public function index()
    {
        // Interogăm tabela rate_schimb
        $rate = DB::table('rate_schimb')->get();

        // detaliile casei de schimb de care apartine utilizatorul logat
        $user = auth()->user();
        $casadeschimb = $user->casadeschimb;

        //data de azi
        $date = new DateTime();

        // Traducerea zilelor și lunilor în română
        $zile = [
            'Sunday' => 'Duminică',
            'Monday' => 'Luni',
            'Tuesday' => 'Marți',
            'Wednesday' => 'Miercuri',
            'Thursday' => 'Joi',
            'Friday' => 'Vineri',
            'Saturday' => 'Sâmbătă'
        ];

        $luni = [
            'January' => 'Ianuarie',
            'February' => 'Februarie',
            'March' => 'Martie',
            'April' => 'Aprilie',
            'May' => 'Mai',
            'June' => 'Iunie',
            'July' => 'Iulie',
            'August' => 'August',
            'September' => 'Septembrie',
            'October' => 'Octombrie',
            'November' => 'Noiembrie',
            'December' => 'Decembrie'
        ];

        // Formatează data și traduce
        $ziua = $zile[$date->format('l')];
        $luna = $luni[$date->format('F')];
        $data = $ziua . ', ' . $date->format('d') . ' ' . $luna . ' ' . $date->format('Y');

        $userRole = $user->role == 1 ? 'Admin' : 'Tehnician Service';

        // Returnăm datele către view-ul 'actiuni'
        return view('actiuni', ['rate' => $rate, 'casadeschimb' => $casadeschimb, 'data' => $data, 'role' => $userRole]);
    }
}