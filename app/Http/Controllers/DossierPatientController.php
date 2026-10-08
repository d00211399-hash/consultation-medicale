<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\Patient;

class DossierPatientController extends Controller
{
    public function show(Patient $patient){
        Gate::authorize('view', $patient);

        $consultations = $patient->consultations()->with('medecin')->latest()->get();
        return view('page.patients.dossier', compact('patient', 'consultations'));
    }
}
