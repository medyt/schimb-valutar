<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Importă modelul User

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all(); // Obține toți utilizatorii
        return view('admin', compact('users'));
    }
}