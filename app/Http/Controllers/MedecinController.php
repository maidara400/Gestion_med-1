<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\User;
class MedecinController extends Controller
{

    public function index()
    {
        $medecin = User::where('role', 'medecin')->get();
        return view('Medecin.index', compact('medecin'));
    }
    public function create()
    {
        return view('Medecin.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $medecin = new User();
        $medecin->name = $validated['name'];
        $medecin->email = $validated['email'];
        $medecin->password = bcrypt($validated['password']);
        $medecin->role = 'medecin';
        $medecin->save();

        return redirect()->route('medecin.index')->with('success', 'Médecin ajouté avec succès.');
    }
    public function edit($id)
    {
        $medecin = User::findOrFail($id);
        return view('Medecin.update', compact('medecin'));
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'required|string|min:8',
        ]);

        $medecin = User::findOrFail($id);
        $medecin->name = $validated['name'];
        $medecin->email = $validated['email'];
        $medecin->password = bcrypt($validated['password']);
        $medecin->save();

        return redirect()->route('medecin.index')->with('success', 'Médecin mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $medecin = User::findOrFail($id);
        $medecin->delete();

        return redirect()->route('medecin.index')->with('success', 'Médecin supprimé avec succès.');
    }
    
    public function services()
    {
        // $services = Service::where('medecin_id', auth()->id())->get();
        $services = Service::where('medecin_id',Auth::id())->paginate(1);
        return view('medecin.services', compact('services'));
    }
    
    public function reservations()
    {
        $reservations = Reservation::with(['service','user'])
        ->whereHas('service', function ($q) {
            // $q->where('medecin_id', auth()->id());
            $q->where('medecin_id', Auth::id());
        })
        ->get();
        return view('medecin.reservations', compact('reservations'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
        'statut' => 'required|in:confirmée,annulée,effectuée',
        ]);
        $reservation = Reservation::findOrFail($id);
        // if ($reservation->service->medecin_id != auth()->id()) {
        if ($reservation->service->medecin_id !=Auth::id()) {
            abort(403);
        }
        $reservation->update($validated);
        return back()->with('success', 'Statut mis à jour.');
    }
}
