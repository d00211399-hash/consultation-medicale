<?php

namespace App\Models;

use App\Models\Medecin;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;

class Consulter extends Model
{
        protected $fillable = [
        'medecin_id',
        'patient_id',
        'date_consultation',
        'heure_consultation',
        'description',
        'statut',
    ];

    public function medecin()
    {
        return $this->belongsTo(Medecin::class,'medecin_id','matricule');
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class,'patient_id','id');
    }


}
