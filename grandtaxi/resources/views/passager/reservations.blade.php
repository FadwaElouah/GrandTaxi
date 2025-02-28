@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Mes réservations</h1>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Départ</th>
                <th>Arrivée</th>
                <th>Date de réservation</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservations as $reservation)
            <tr>
                <td>{{ $reservation->trajet->lieu_depart }}</td>
                <td>{{ $reservation->trajet->lieu_arrivee }}</td>
                <td>{{ $reservation->date_reservation }}</td>
                <td>{{ $reservation->statut }}</td>
                <td>
                    @if($reservation->statut == 'en attente' && \Carbon\Carbon::parse($reservation->trajet->date)->diffInHours(now()) >= 1)
                    <form action="{{ route('passager.annulerReservation', $reservation->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Annuler</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

