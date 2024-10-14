<?php

namespace App\Http\Controllers;

use App\Models\RateSchimb;
use Illuminate\Http\Request;

class RatesController extends Controller
{
    public function index()
    {
        $rateSchimb = RateSchimb::all(); // Obține toate ratele de schimb
        return view('admin.rates', compact('rateSchimb'));
    }

    public function store(Request $request)
    {

        // Validarea datelor
        $request->validate([
            'valuta' => 'required|string|max:3',
            'denumire_valuta' => 'required|string',
            'oficial' => 'required|numeric',
            'cumparare' => 'required|numeric',
            'vanzare' => 'required|numeric',
            'paritate' => 'required|numeric',
        ]);

        RateSchimb::create($request->all()); // Crează o nouă rată de schimb

        return response()->json(['success' => 'Rata de schimb a fost creată cu succes!']);
    }

    public function update(Request $request, $id)
    {
        // Validarea datelor
        $request->validate([
            'valuta' => 'required|string|max:3',
            'denumire_valuta' => 'required|string',
            'oficial' => 'required|numeric',
            'cumparare' => 'required|numeric',
            'vanzare' => 'required|numeric',
            'paritate' => 'required|numeric',
        ]);

        $rate = RateSchimb::findOrFail($id); // Găsește rata de schimb
        $rate->update($request->all()); // Actualizează rata de schimb

        return response()->json(['success' => 'Rata de schimb a fost actualizată cu succes!']);
    }

    public function destroy($id)
    {
        $rate = RateSchimb::findOrFail($id); // Găsește rata de schimb
        $rate->delete(); // Șterge rata de schimb

        return response()->json(['success' => 'Rata de schimb a fost ștearsă cu succes!']);
    }
}