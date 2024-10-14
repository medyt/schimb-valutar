<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasaDeSchimb extends Model
{
    protected $table = 'case_de_schimb'; // Asigură-te că folosești numele corect al tabelei

    // Definirea câmpurilor care pot fi umplute (mass assignment)
    protected $fillable = [
        'name',
        'Adress',
        'city'
    ];
}
