<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RateSchimb;
use App\Models\Tranzactie;

class TranzactiiController extends Controller
{
    public function cumparare()
    {
        // Preia valutele și cursurile de schimb din baza de date
        $rateSchimb = RateSchimb::all();

        // Trimite datele către view-ul de cumpărare
        return view('cumparare', compact('rateSchimb'));
    }

    public function buy(Request $request)
    {
        // Validarea datelor primite din formular
        $request->validate([
            'client_name' => 'required|string',
            'residency' => 'required|string',
            'tara' => 'required|string',
            'document' => 'required|string',
            'document_number' => 'required|string',
            'document_serie' => 'required|string',
            'valuta_cumparata.*' => 'required|string', // Valuta cumpărată trebuie să fie validă
            'valuta_vanduta.*' => 'required|string',   // Valuta vândută trebuie să fie validă
            'suma_vanduta.*' => 'required|numeric',    // Suma să fie numerică
            'suma_primita.*' => 'required|numeric',    // Suma să fie numerică
        ]);

        
        // Iterează prin valutele selectate și salvează fiecare tranzacție
        foreach ($request->valuta_cumparata as $index => $valuta_cumparata) {
            $tranzactie = new Tranzactie();
            $tranzactie->client_name = $request->client_name;
            $tranzactie->residency = $request->residency;
            $tranzactie->tara = $request->tara;
            $tranzactie->valuta_cumparata = $valuta_cumparata;
            $tranzactie->valuta_vanduta = 'RON';
            $tranzactie->suma_vanduta = $request->suma_vanduta[$index];
            $tranzactie->suma_primita = str_replace(" RON", "", $request->suma_primita);
            $tranzactie->document = $request->document;
            $tranzactie->document_number = $request->document_number;
            $tranzactie->document_serie = $request->document_serie;
            $tranzactie->tip_tranzactie = $request->tip_tranzactie;

            // Salvează tranzacția în baza de date
            $tranzactie->save();
        }

        // Redirecționează cu mesaj de succes
        return redirect()->route('actiuni')->with('success', 'Tranzacțiile au fost realizate cu succes!');
    }

    public function sell(Request $request)
    {
        // Validarea datelor primite din formular
        $request->validate([
            'client_name' => 'required|string',
            'residency' => 'required|string',
            'tara' => 'required|string',
            'document' => 'required|string',
            'document_number' => 'required|string',
            'document_serie' => 'required|string',
            'valuta_cumparata.*' => 'required|string', // Valuta cumpărată trebuie să fie validă
            'valuta_vanduta_vanzare.*' => 'required|string',   // Valuta vândută trebuie să fie validă
            'suma_vanduta_vanzare.*' => 'required|numeric',    // Suma să fie numerică
            'suma_primita_vanzare.*' => 'required|numeric',    // Suma să fie numerică
        ]);

        // Iterează prin valutele selectate și salvează fiecare tranzacție
        foreach ($request->valuta_vanduta_vanzare as $index => $valuta_vanduta) {
            $tranzactie = new Tranzactie();
            $tranzactie->client_name = $request->client_name;
            $tranzactie->residency = $request->residency;
            $tranzactie->tara = $request->tara;
            $tranzactie->valuta_cumparata = 'RON';
            $tranzactie->valuta_vanduta = $valuta_vanduta;
            $tranzactie->suma_vanduta = $request->suma_vanduta_vanzare[$index];
            $tranzactie->suma_primita = $request->suma_primita_vanzare[$index];
            $tranzactie->document = $request->document;
            $tranzactie->document_number = $request->document_number;
            $tranzactie->document_serie = $request->document_serie;
            $tranzactie->tip_tranzactie = $request->tip_tranzactie;

            // Salvează tranzacția în baza de date
            $tranzactie->save();
        }

        // Redirecționează cu mesaj de succes
        return redirect()->route('actiuni')->with('success', 'Tranzacțiile au fost realizate cu succes!');
    }

    public function buysell(Request $request)
    {
        // Validarea datelor primite din formular
        $request->validate([
            'client_name' => 'required|string',
            'residency' => 'required|string',
            'tara' => 'required|string',
            'document' => 'required|string',
            'document_number' => 'required|string',
            'document_serie' => 'required|string',
            'valuta_cumparata_cumpvanz.*' => 'required|string', // Valuta cumpărată trebuie să fie validă
            'valuta_vanduta_cumpvanz.*' => 'required|string',   // Valuta vândută trebuie să fie validă
            'suma_vanduta_cumpvanz.*' => 'required|numeric',    // Suma să fie numerică
            'suma_primita_cumpvanz.*' => 'required|numeric',    // Suma să fie numerică
        ]);

        // Iterează prin valutele selectate și salvează fiecare tranzacție
        foreach ($request->valuta_vanduta_cumpvanz as $index => $valuta_vanduta) {
            $tranzactie = new Tranzactie();
            $tranzactie->client_name = $request->client_name;
            $tranzactie->residency = $request->residency;
            $tranzactie->tara = $request->tara;
            $tranzactie->valuta_cumparata = $valuta_vanduta;
            $tranzactie->valuta_vanduta = $request->valuta_cumparata_cumpvanz[$index];
            $tranzactie->suma_vanduta = $request->suma_primita_cumpvanz[$index];
            $tranzactie->suma_primita = $request->suma_vanduta_cumpvanz[$index];
            $tranzactie->document = $request->document;
            $tranzactie->document_number = $request->document_number;
            $tranzactie->document_serie = $request->document_serie;
            $tranzactie->tip_tranzactie = $request->tip_tranzactie;

            // Salvează tranzacția în baza de date
            $tranzactie->save();
        }

        // Redirecționează cu mesaj de succes
        return redirect()->route('actiuni')->with('success', 'Tranzacțiile au fost realizate cu succes!');
    }

    public function vanzare()
    {
        $rateSchimb = RateSchimb::all(); // Obține toate ratele de schimb
        return view('vanzare', compact('rateSchimb'));
    }

    public function cumpararevanzare()
    {
        $rateSchimb = RateSchimb::all(); // Obține toate ratele de schimb
        return view('cumpararevanzare', compact('rateSchimb'));
    }
}