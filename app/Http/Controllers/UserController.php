<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Metoda pentru a afișa lista utilizatorilor
    public function index(Request $request)
    {
        $query = User::query();

        // Filtrare
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('username', 'like', '%' . $request->search . '%')
                ->orWhere('role', 'like', '%' . $request->search . '%');
        }

        // Obține utilizatorii cu paginare
        $utilizatori = $query->paginate(10);

        return view('admin.utilizatori', compact('utilizatori'));
    }

    // Metoda pentru a actualiza utilizatorul
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json(['success' => 'Utilizator actualizat cu succes!']);
    }

    // Metoda pentru a afișa formularul de editare a utilizatorului
    public function edit($id)
    {
        $utilizator = User::findOrFail($id);
        return view('admin.edit_user', compact('utilizator'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|integer',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return response()->json(['success' => 'Utilizator adăugat cu succes!']);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Utilizator șters cu succes.']);
    }
}
