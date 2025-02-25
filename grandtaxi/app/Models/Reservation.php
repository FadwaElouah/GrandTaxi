<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'passager_id',
        'chauffeur_id',
        'trajet_id',
        'statut',
        'date_reservation',
    ];
}

