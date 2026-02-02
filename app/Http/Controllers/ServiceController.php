<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Medecin;
class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('statut', 'actif')->with('medecin')->paginate(5);
        //dd($services);
         return view('services.index', compact('services'));
    }

    public function create()
    {
        $medecins = Medecin::all();
        return view('services.create', compact('medecins'));
    }
    
    public function show($id)
    {
        $service = Service::with('medecin')->findOrFail($id);
        dd($service);
        // return view('services.show', compact('service'));
    }
}
