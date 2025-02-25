<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class disponibilite extends Model
{
    use HasFactory;
    protected $filable =[
        'chauffeur_id',
        'date_debut',
        'date_fin',
        'statut',
    ];
}
