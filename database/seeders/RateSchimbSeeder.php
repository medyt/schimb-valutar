<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RateSchimbSeeder extends Seeder
{
    public function run()
    {
        DB::table('rate_schimb')->insert([
            ['valuta' => 'EUR', 'denumire_valuta' => 'Euro', 'oficial' => 4.9772, 'cumparare' => 4.9236, 'vanzare' => 4.9586, 'paritate' => 1.00],
            ['valuta' => 'USD', 'denumire_valuta' => 'Dolar american', 'oficial' => 4.4866, 'cumparare' => 4.4631, 'vanzare' => 4.5364, 'paritate' => 1.10],
            ['valuta' => 'GBP', 'denumire_valuta' => 'Lira sterlină', 'oficial' => 5.9207, 'cumparare' => 5.8032, 'vanzare' => 5.8780, 'paritate' => 0.84],
            ['valuta' => 'CHF', 'denumire_valuta' => 'Franc elvețian', 'oficial' => 5.3189, 'cumparare' => 5.1672, 'vanzare' => 5.2640, 'paritate' => 0.93],
            ['valuta' => 'UAH', 'denumire_valuta' => 'Hryvna ucraineană', 'oficial' => 0.1089, 'cumparare' => 0.0800, 'vanzare' => 0.1200, 'paritate' => 45.70],
            ['valuta' => 'CAD', 'denumire_valuta' => 'Dolar canadian', 'oficial' => 1.0000, 'cumparare' => 1.0000, 'vanzare' => 1.0000, 'paritate' => 4.97],
            ['valuta' => 'SEK', 'denumire_valuta' => 'Coroană suedeză', 'oficial' => 1.0000, 'cumparare' => 0.0000, 'vanzare' => 0.0000, 'paritate' => 4.97],
            ['valuta' => 'DKK', 'denumire_valuta' => 'Coroană daneză', 'oficial' => 1.0000, 'cumparare' => 0.0000, 'vanzare' => 0.0000, 'paritate' => 4.97],
            ['valuta' => 'PLN', 'denumire_valuta' => 'Zlot polonez', 'oficial' => 1.0000, 'cumparare' => 0.0000, 'vanzare' => 0.0000, 'paritate' => 4.97],
            ['valuta' => 'MDL', 'denumire_valuta' => 'Leu moldovenesc', 'oficial' => 0.2500, 'cumparare' => 0.0000, 'vanzare' => 0.0000, 'paritate' => 19.90],
            ['valuta' => 'NOK', 'denumire_valuta' => 'Coroană norvegiană', 'oficial' => 1.0000, 'cumparare' => 0.0000, 'vanzare' => 0.0000, 'paritate' => 9.95],
            ['valuta' => 'BGN', 'denumire_valuta' => 'Leva bulgărească', 'oficial' => 1.0000, 'cumparare' => 0.0000, 'vanzare' => 0.0000, 'paritate' => 4.97],
            ['valuta' => 'HUF', 'denumire_valuta' => 'Forint maghiar', 'oficial' => 0.2500, 'cumparare' => 0.0000, 'vanzare' => 0.0000, 'paritate' => 1990.88]
        ]);
    }
}