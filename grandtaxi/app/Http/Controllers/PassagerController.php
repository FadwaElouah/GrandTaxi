<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trajet;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;

class PassagerController extends Controller
{
    public function dashboard()
    {
        return view('passager.dashboard');
    }

    public function listTrajets()
    {
        $trajets = Trajet::select('id', 'chauffeur_id', 'lieu_depart', 'lieu_arrivee', 'date')
            ->with(['chauffeur:id,name,photo'])
            ->where('date', '>=', now())
            ->orderBy('date')
            ->take(20)
            ->get();
        return view('passager.trajets', compact('trajets'));
    }

    public function reserver($trajet_id)
    {
        $trajet = Trajet::findOrFail($trajet_id);

        Reservation::create([
            'passager_id' => auth()->id(),
            'chauffeur_id' => $trajet->chauffeur_id,
            'trajet_id' => $trajet->id,
            'statut' => 'en attente',
            'date_reservation' => now(),
        ]);

        return redirect()->route('passager.reservations')->with('success', 'La réservation a été effectuée avec succès !');
    }

    public function reservations()
    {
        $reservations = Reservation::where('passager_id', auth()->id())
            ->with(['trajet', 'chauffeur'])
            ->get();
        return view('passager.reservations', compact('reservations'));
    }

    public function filtrerChauffeurs(Request $request)
    {
        $query = User::whereHas('roles', function($q) {
            $q->where('name', 'chauffeur');
        });

        // filter localisation
        if ($request->has('location') && $request->location) {
            $query->where('location', $request->location);
        }

        // filter disponibilité
        if ($request->has('disponible') && $request->disponible) {
            $query->whereHas('disponibilites', function($q) {
                $q->where('date', '>=', now())
                  ->where('is_available', true);
            });
        }

        $chauffeurs = $query->get();

        return view('passager.chauffeurs', compact('chauffeurs'));
    }

    public function voirChauffeur($id)
    {
        $chauffeur = User::findOrFail($id);
        $trajets = Trajet::where('chauffeur_id', $id)
            ->where('date', '>=', now())
            ->orderBy('date')
            ->get();

        return view('passager.voir-chauffeur', compact('chauffeur', 'trajets'));
    }

    public function annulerReservation($id)
    {
        $reservation = Reservation::findOrFail($id);

        // Vérifiez que la réservation appartient à l'utilisateur actuel
        if ($reservation->passager_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à annuler cette réservation');
        }

        // Vérifiez l'heure limite pour annuler
        $heureDepartTrajet = Carbon::parse($reservation->trajet->date);
        $now = now();

        if ($now->diffInHours($heureDepartTrajet) < 1) {
            return redirect()->back()->with('error', 'Il est impossible d\'annuler la réservation moins d\'une heure avant le départ');
        }

        // Annuler la réservation
        $reservation->update(['statut' => 'annulé']);

        return redirect()->route('passager.reservations')->with('success', 'Réservation annulée avec succès');
    }

    public function historiqueTrajet()
    {
        $reservations = Reservation::where('passager_id', auth()->id())
            ->where(function($query) {
                $query->where('statut', 'terminé')
                      ->orWhere('statut', 'annulé');
            })
            ->with(['trajet', 'chauffeur'])
            ->orderBy('date_reservation', 'desc')
            ->get();

        return view('passager.historique', compact('reservations'));
    }

    public function creerReservation(Request $request)
    {
        $validated = $request->validate([
            'lieu_depart' => 'required|string|max:255',
            'lieu_arrivee' => 'required|string|max:255',
            'date' => 'required|date|after:now',
            'chauffeur_id' => 'required|exists:users,id'
        ]);

        // Vérifier si le chauffeur est disponible à cette date
        $chauffeurDisponible = User::find($validated['chauffeur_id'])
            ->disponibilites()
            ->where('date', Carbon::parse($validated['date'])->format('Y-m-d'))
            ->where('is_available', true)
            ->exists();

        if (!$chauffeurDisponible) {
            return redirect()->back()->with('error', 'Le chauffeur n\'est pas disponible à cette date');
        }

        // Créer un nouveau trajet
        $trajet = Trajet::create([
            'chauffeur_id' => $validated['chauffeur_id'],
            'lieu_depart' => $validated['lieu_depart'],
            'lieu_arrivee' => $validated['lieu_arrivee'],
            'date' => $validated['date'],
        ]);

        // Créer la réservation
        Reservation::create([
            'passager_id' => auth()->id(),
            'chauffeur_id' => $validated['chauffeur_id'],
            'trajet_id' => $trajet->id,
            'statut' => 'en attente',
            'date_reservation' => now(),
        ]);

        return redirect()->route('passager.reservations')->with('success', 'Votre réservation a été créée avec succès');
    }
}

