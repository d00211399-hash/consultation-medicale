<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordChangeController extends Controller
{
    public function edit()
    {
        return view('page.auths.change-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = $request->user();
        $user->password = $request->password; // hashé automatiquement par le cast
        $user->must_change_password = false;
        $user->temp_password = null; // Supprimer le mot de passe temporaire après le changement
        $user->save();

        if ($user->role === 'patient' && $user->patient) {
            return redirect()->route('patient.dossier', $user->patient->id);
        }

        return redirect()->route('dashboard');
    }
}
