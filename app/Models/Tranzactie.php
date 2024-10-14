<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tranzactie extends Model
{
    use HasFactory;

    // Specificăm numele tabelei corecte
    protected $table = 'tranzactii';

    // Definim campurile care pot fi completate automat
    protected $fillable = ['valuta', 'suma', 'tip_tranzactie', 'client_nume', 'document_identitate'];
}