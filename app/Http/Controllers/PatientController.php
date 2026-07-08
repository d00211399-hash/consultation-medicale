<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::all();
        return view('page.patients.index',compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('page.patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'            => 'required|string|max:20',
            'prenom'         => 'required|string|max:30',
            'date_naissance' => 'required|date|',
            'sexe'           => 'required|string|in:homme,femme,autre',
            'adresse'        => 'required|string|max:50',
            'telephone'      => 'required|string|max:20',
            'email'          => 'email|string|unique:patients,email',
        ]);
        Patient::create($validated);
        return redirect()->route('patients.index')->with('success','patient ajouté avec succès');
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
        $patient = Patient::findOrFail($id);
        return view('page.patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $patient = Patient::findOrFail($id);
        $validated = $request->validate([
            'nom'=> 'required|string',
            'prenom'=>'required|string|',
            'date_naissance' => 'required|date|',
            'sexe' => 'required|string|in:homme,femme,autre',
            'adresse' => 'required|string|',
            'telephone' => 'required|string|',
            'email' => 'email|string|unique:patients,email,'. $patient->id,
        ]);

        $patient->update($validated);
        return redirect()->route('patients.index')->with('success', 'patient modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        return redirect()->route('patients.index')->with('success','le Patient est supprimé');

    }
}
