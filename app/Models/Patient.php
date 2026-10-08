<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'sexe',
        'adresse',
        'telephone',
        'email',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function consultations()
    {
        return $this->hasMany(Consulter::class, 'patient_id', 'id');
    }
}
