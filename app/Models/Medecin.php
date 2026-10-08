<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medecin extends Model
{
    protected $primaryKey = 'matricule';
    public $incrementing = false;
    protected $KeyType = 'string';
    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'specialite',
        'email',
        'telephone',
        'statut',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
