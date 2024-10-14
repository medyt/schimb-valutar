<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateSchimb extends Model
{
    use HasFactory;

    protected $table = 'rate_schimb'; // Asigură-te că folosești numele corect al tabelei

    // Definirea câmpurilor care pot fi umplute (mass assignment)
    protected $fillable = [
        'valuta',
        'denumire_valuta',
        'oficial',
        'cumparare',
        'vanzare',
        'paritate'
    ];
}