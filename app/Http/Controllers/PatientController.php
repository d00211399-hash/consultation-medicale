<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::all();

        $comptesEnAttente = User::where('role', 'patient')
         ->where('must_change_password', true)
         ->whereNotNull('temp_password')
         ->get();
        return view('page.patients.index',compact('patients', 'comptesEnAttente'));
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
        'date_naissance' => 'required|date|before:today',
        'sexe'           => 'required|string|in:M,F,autre',
        'adresse'        => 'required|string|max:50',
        'telephone'      => 'required|string|max:20',
        'email'          => 'required|email|string|unique:patients,email|unique:users,email',
    ]);

    $password = Str::random(8);

    DB::transaction(function () use ($validated, $password) {
        $user = User::create([
            'name'                 => $validated['prenom'] . ' ' . $validated['nom'],
            'email'                => $validated['email'],
            'password'             => Hash::make($password),
            'role'                 => 'patient',
            'must_change_password' => true,
            'temp_password'        => $password, // Stocker le mot de passe temporaire en clair
        ]);

        Patient::create($validated + ['user_id' => $user->id]);
    });

    return redirect()->route('patients.index')
        ->with('success', 'Patient ajouté avec succès.')
        ->with('generated_email', $validated['email'])
        ->with('generated_password', $password);
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
