<?php

namespace App\Http\Controllers;

use App\Models\Consulter;
use App\Models\Medecin;
use App\Models\Patient;
use Illuminate\Http\Request;

class ConsulterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $consulters = Consulter::all();
         return view('page.consulters.index',compact('consulters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $medecins  = Medecin::all();
        $patients  = Patient::all();

        return view('page.consulters.create',compact('medecins','patients'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'medecin_id'=> 'required|exists:medecins,matricule',
            'patient_id'=> 'required|exists:patients,id',
            'date_consultation'=> 'required|date',
            'heure_consultation'=> 'required|date_format:H:i',
            'description'=> 'nullable|string|max:100',
            'statut'=> 'required|string|in:en_attente,en_cours,termine,annule',
        ]);
        Consulter::create($validated);
        return redirect()->route('consulters.index')->with('success','la consultation a été crée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $consulter = Consulter::findOrFail($id);
        $medecins = Medecin::all();
        $patients = Patient::all();
        return view('page.consulters.edit', compact('consulter', 'medecins','patients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $consulter = Consulter::findOrFail($id);
        $validated = $request->validate([

            'medecin_id' => 'required|string|exists:medecins,matricule',
            'patient_id' => 'required|string|exists:patients,id',
            'date_consultation' => 'required|date',
            'heure_consultation' => 'required|date_format:H:i',
            'description' => 'nullable|string|max:200',
            'statut' => 'required|string|in:en_attente,en_cours,termine,annule',

        ]);
        $consulter->update($validated);
        return redirect()->route('consulters.index')->with('success','consultations modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $consulter = Consulter::findOrFail($id);
        $consulter->delete();
        return redirect()->route('consulters.index')->with('success', 'voulez-vous supprimer?');
    }

     public function statut(string $id)
    {
        $consulter = Consulter::findOrFail($id);

        $consulter->statut = match($consulter->statut){
            'en_attente' => 'en_cours',
            'en_cours' => 'termine',
            'termine' => 'annule',
            'annule' => 'en_attente',
            default => 'en_attente'
        };
        $consulter->save();

        return redirect()->route('consulters.index')->with('success','statut modifié avec succès');
    }
}
