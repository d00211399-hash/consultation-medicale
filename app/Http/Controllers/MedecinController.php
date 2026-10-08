<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Medecin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MedecinController extends Controller
{
    /**
     * Liste tous les médecins.
     */
    public function index() : \Illuminate\Contracts\View\View
    {
        $medecins = Medecin::all(); // Récupérer les médecins depuis la base de données

        $comptesEnAttente = User::where('role', 'medecin')
        ->where('must_change_password', true)
        ->whereNotNull('temp_password')
        ->get();
        return view('page.medecins.index', compact('medecins', 'comptesEnAttente'));
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
        'nom'        => 'required|string|max:255',
        'prenom'     => 'required|string|max:255',
        'specialite' => 'required|string|max:255',
        'email'      => 'required|email|max:255|unique:users,email|unique:medecins,email',
        'telephone'  => 'required|string|max:20',
        'statut'     => 'required|string|in:actif,inactif',
        // 'password' supprimé
    ]);

    $lettre = strtoupper(substr($validated['nom'], 0, 2));
    $numero = Medecin::count() + 1;

   do {
       $matricule = 'MED' . str_pad($numero, 3, '0', STR_PAD_LEFT) . $lettre . rand(10, 99);
     $numero++;
    } while (Medecin::where('matricule', $matricule)->exists());

    $password = Str::random(8);

    DB::transaction(function () use ($validated, $matricule, $password) {
        $user = User::create([
            'name'                 => $validated['prenom'] . ' ' . $validated['nom'],
            'email'                => $validated['email'],
            'password'             => Hash::make($password),
            'role'                 => 'medecin',
            'statut'               => $validated['statut'],
            'must_change_password' => true,
            'temp_password'        => $password, // Stocker le mot de passe temporaire en clair
        ]);

        Medecin::create([
            'matricule'  => $matricule,
            'nom'        => $validated['nom'],
            'prenom'     => $validated['prenom'],
            'specialite' => $validated['specialite'],
            'email'      => $validated['email'],
            'telephone'  => $validated['telephone'],
            'statut'     => $validated['statut'],
            'user_id'    => $user->id,
        ]);
    });

    return redirect()->route('medecins.index')
        ->with('success', 'Compte médecin créé avec succès.')
        ->with('generated_email', $validated['email'])
        ->with('generated_password', $password);
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
