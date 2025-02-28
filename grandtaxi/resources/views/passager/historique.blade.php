@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Historique de mes trajets</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Départ</th>
                <th>Arrivée</th>
                <th>Date</th>
                <th>Chauffeur</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservations as $reservation)
            <tr>
                <td>{{ $reservation->trajet->lieu_depart }}</td>
                <td>{{ $reservation->trajet->lieu_arrivee }}</td>
                <td>{{ $reservation->trajet->date }}</td>
                <td>{{ $reservation->chauffeur->name }}</td>
                <td>
                    @if($reservation->statut == 'terminé')
                        <span class="badge bg-success">Terminé</span>
                    @elseif($reservation->statut == 'annulé')
                        <span class="badge bg-danger">Annulé</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

