<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use Illuminate\Http\Request;

class MedecinController extends Controller
{
    /**
     * Liste tous les médecins.
     */
    public function index() : \Illuminate\Contracts\View\View
    {
        $medecins = Medecin::all(); // Récupérer les médecins depuis la base de données
        return view('page.medecins.index', compact('medecins'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau médecin.
     */
    public function create()
    {
        return view('page.medecins.create');
    }

    /**
     * Enregistre un nouveau médecin dans la base de données.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'nom'        => 'required|string|max:20',
            'prenom'     => 'required|string|max:30',
            'specialite' => 'required|string|max:30',
            'email'      => 'required|email|string|unique:medecins,email',
            'telephone'  => 'required|string|max:20',
            'statut'     => 'required|string|in:actif,inactif',
        ]);

        $lastId = Medecin::count() + 1;
        $lettre = strtoupper(substr($validated['nom'], 0, 2));
        $chiffre = rand(10, 99);
        $matricule = 'MED' . str_pad($lastId, 3, '0', STR_PAD_LEFT) . $lettre . $chiffre;
        $validated['matricule'] = $matricule;

        Medecin::create($validated);

        return response()->json([
            'message' => 'Médecin ' . $validated['nom'] . ' ajouté avec succès avec le matricule ' . $matricule
        ], 200);

    }

    /**
     * Affiche le médecin spécifié.
     */
    public function show(string $matricule)
    {
        $medecin = Medecin::findOrFail($matricule);
        return view('page.medecins.show', compact('medecin'));
    }

    /**
     *  Affiche le formulaire d'édition du médecin spécifié.
     */
    public function edit(string $matricule)
    {
        $medecin = Medecin::findOrFail($matricule);
        return view('page.medecins.edit', compact('medecin'));
    }

    /**
     *  Met à jour le médecin spécifié dans la base de données.
     */
    public function update(Request $request, string $matricule)
    {
        $medecin = Medecin::findOrFail($matricule);

        $validated = $request->validate([
            'nom'=> 'required|string|max:20',
            'prenom'=> 'required|string|max:30',
            'specialite'=> 'required|string|max:30',
            'email' => 'required|email|string|unique:medecins,email,'.$medecin->matricule.',matricule',
            'telephone'=> 'required|string|max:20',
            'statut'=> 'required|string|in:actif,inactif',
        ]);
        $medecin->update($validated);
        return redirect()->route('medecins.index')->with('success','médecin modifié');

    }

    /**
     *  Supprime le médecin spécifié de la base de données.
     */
    public function destroy(string $matricule)
    {
        $medecin = Medecin::findOrFail($matricule);
        $medecin->delete();
        return redirect()->route('medecins.index')->with('success','le médecin a été supprimé');
    }

    /**
     * Met à jour le statut du médecin spécifié (actif/inactif).
     */
    public function statut(string $matricule)
    {
        $medecin = Medecin::findOrFail($matricule);

        $medecin->statut = $medecin->statut ==='actif'?'inactif':'actif';
        $medecin->save();

        return redirect()->route('medecins.index')->with('success','status modifié avec succès');
    }
}
