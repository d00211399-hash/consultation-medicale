<?php

namespace App\Models;

use App\Models\Consulter;
use App\Models\Medicament;
use Illuminate\Database\Eloquent\Model;

class prescrire extends Model
{
     Protected $fillable = [
        'medicament_id',
        'consulter_id',
        'posologie',
        'duree',
    ];
    public function medicament()
    {
        return $this->belongsTo(Medicament::class,'medicament_id','id' );
    }
    public function consulter()
    {
        return $this->belongsTo(Consulter::class,'consulter_id','id');
    }
}
