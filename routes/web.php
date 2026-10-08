<?php

use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
    //return view('welcome');
});
//Route::get('/login', function(){
  //  return view('page.auths.login');
//})->name('login');

Route::get('/connexion', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('/connexion', [App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
Route::post('/deconnexion', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::get('/inscription', [App\Http\Controllers\AuthController::class, 'showRegister'])->name('register');
Route::post('/inscription', [App\Http\Controllers\AuthController::class, 'register'])->name('register.post');
// Tableau de bord

  //pout la réinitialisation du mot de passe
Route::get('/changer-mot-de-passe', [PasswordChangeController::class, 'edit'])->name('password.change');
Route::post('/changer-mot-de-passe', [PasswordChangeController::class, 'update'])->name('password.change.update');

   // pour l'admin uniquement
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/users/{user}/reinitialiser-mot-de-passe',ResetPasswordController::class)->name('users.reset-password');
});

Route::middleware(['auth', 'role:admin,medecin'])->group(function () {
   Route::get('/tableau-de-bord', function () {
        return view('page.dashboard.index');
    })->name('dashboard');
});
//Route::view('/tableau-de-bord','page.dashboard.index')->name('dashboard');

       // Routes pour les médecins
       Route::get('medecins',[App\Http\Controllers\MedecinController::class, 'index'])->name('medecins.index');
       Route::get('medecins/create',[App\Http\Controllers\MedecinController::class, 'create'])->name('medecins.create');
       Route::post('medecins',[App\Http\Controllers\MedecinController::class, 'store'])->name('medecins.store');
       Route::get('medecins/{id}',[App\Http\Controllers\MedecinController::class, 'show'])->name('medecins.show');
       Route::get('medecins/{id}/edit',[App\Http\Controllers\MedecinController::class, 'edit'])->name('medecins.edit');
       Route::put('medecins/{id}',[App\Http\Controllers\MedecinController::class, 'update'])->name('medecins.update');
       Route::delete('medecins/{id}',[App\Http\Controllers\MedecinController::class, 'destroy'])->name('medecins.destroy');
       Route::patch('medecins/{matricule}/statut',[App\Http\Controllers\MedecinController::class, 'statut'])->name('medecins.statut');

       //route des patient
       Route::get('patients',[App\Http\Controllers\PatientController::class, 'index'])->name('patients.index');
       Route::get('patients/create',[App\Http\Controllers\PatientController::class, 'create'])->name('patients.create');
       Route::post('patients',[App\Http\Controllers\PatientController::class, 'store'])->name('patients.store');
       Route::get('patients/{id}',[App\Http\Controllers\PatientController::class, 'show'])->name('patients.show');
       Route::get('patients/{id}/edit',[App\Http\Controllers\PatientController::class, 'edit'])->name('patients.edit');
       Route::put('patients/{id}',[App\Http\Controllers\PatientController::class, 'update'])->name('patients.update');
       Route::delete('patients/{id}',[App\Http\Controllers\PatientController::class, 'destroy'])->name('patients.destroy');

       //route des consultations
       Route::get('consulters',[App\Http\Controllers\ConsulterController::class, 'index'])->name('consulters.index');
       Route::get('consulters/create',[App\Http\Controllers\ConsulterController::class, 'create'])->name('consulters.create');
       Route::post('consulters',[App\Http\Controllers\ConsulterController::class, 'store'])->name('consulters.store');
       Route::get('consulters/{id}',[App\Http\Controllers\ConsulterController::class, 'show'])->name('consulters.show');
       Route::get('consulters/{id}/edit',[App\Http\Controllers\ConsulterController::class, 'edit'])->name('consulters.edit');
       Route::put('consulters/{id}',[App\Http\Controllers\ConsulterController::class, 'update'])->name('consulters.update');
       Route::delete('consulters/{id}',[App\Http\Controllers\ConsulterController::class, 'destroy'])->name('consulters.destroy');
       Route::patch('consulters/{id}/statut',[App\Http\Controllers\ConsulterController::class, 'statut'])->name('consulters.statut');

       //route des consultations
       Route::get('medicaments',[App\Http\Controllers\MedicamentController::class, 'index'])->name('medicaments.index');
       Route::get('medicaments/create',[App\Http\Controllers\MedicamentController::class, 'create'])->name('medicaments.create');
       Route::post('medicaments',[App\Http\Controllers\MedicamentController::class, 'store'])->name('medicaments.store');
       Route::get('medicaments/{id}',[App\Http\Controllers\MedicamentController::class, 'show'])->name('medicaments.show');
       Route::get('medicaments/{id}/edit',[App\Http\Controllers\MedicamentController::class, 'edit'])->name('medicaments.edit');
       Route::put('medicaments/{id}',[App\Http\Controllers\MedicamentController::class, 'update'])->name('medicaments.update');
       Route::delete('medicaments/{id}',[App\Http\Controllers\MedicamentController::class, 'destroy'])->name('medicaments.destroy');
       Route::patch('medicaments/{id}/status',[App\Http\Controllers\MedicamentController::class, 'status'])->name('medicaments.status');

       //route des consultations
       Route::get('prescrires',[App\Http\Controllers\PrescrireController::class, 'index'])->name('prescrires.index');
       Route::get('prescrires/create',[App\Http\Controllers\PrescrireController::class, 'create'])->name('prescrires.create');
       Route::post('prescrires',[App\Http\Controllers\PrescrireController::class, 'store'])->name('prescrires.store');
       Route::get('prescrires/{id}',[App\Http\Controllers\PrescrireController::class, 'show'])->name('prescrires.show');
       Route::get('prescrires/{id}/edit',[App\Http\Controllers\PrescrireController::class, 'edit'])->name('prescrires.edit');
       Route::put('prescrires/{id}',[App\Http\Controllers\PrescrireController::class, 'update'])->name('prescrires.update');
       Route::delete('prescrires/{id}',[App\Http\Controllers\PrescrireController::class, 'destroy'])->name('prescrires.destroy');

       Route::middleware('auth')->get('/dossier/patient/{patient}', [App\Http\Controllers\DossierPatientController::class, 'show'])->name('patient.dossier');
