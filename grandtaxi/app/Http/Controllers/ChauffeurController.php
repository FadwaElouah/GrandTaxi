<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Carbon\Carbon;

class ChauffeurController extends Controller
{
    public function dashboard()
    {
        // RChauffeurController écupérer toutes les réservations où le chauffeur n'a pas encore pris de décision
        $reservations = Reservation::where('chauffeur_id', auth()->id())
                            ->where('statut', 'pending')
                             ->get();

        return view('chauffeur.dashboard', compact('reservations'));
    }

    public function accepterReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->statut = 'accepted';
        $reservation->save();

        return redirect()->back()->with('success', '✅ La demande a été acceptée avec succès!');
    }

    public function reject($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->statut = 'rejected';
        $reservation->save();

        return redirect()->back()->with('error', '❌ La demande a été rejetée!');
    }

    public function historiqueReservations()
    {
        $reservations = Reservation::where('chauffeur_id', auth()->id())
                                   ->whereIn('statut', ['accepted', 'rejected', 'completed'])
                                   ->orderBy('created_at', 'desc')
                                   ->get();

        return view('chauffeur.historique', compact('reservations'));
    }

    public function completerReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->statut = 'completed';
        $reservation->save();

        return redirect()->back()->with('success', '✅ La réservation a été marquée comme complétée!');
    }
}

