<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trajet extends Model
{
    use HasFactory;

    protected $fillable = ['chauffeur_id','lieu_depart','lieu_arrivee','date'];

    public function chauffeur()
    {
        return $this->belongsTo(User::class, 'chauffeur_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

}
