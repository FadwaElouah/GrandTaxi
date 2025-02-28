@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tableau de bord du chauffeur</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2>Réservations en attente</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Passager</th>
                <th>De</th>
                <th>À</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->passager->nom }} {{ $reservation->passager->prenom }}</td>
                    <td>{{ $reservation->trajet->lieu_depart }}</td>
                    <td>{{ $reservation->trajet->lieu_arrivee }}</td>
                    <td>{{ $reservation->trajet->date }}</td>
                    <td>
                        <form action="{{ route('chauffeur.accepter', $reservation->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Accepter</button>
                        </form>
                        <form action="{{ route('chauffeur.refuser', $reservation->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Refuser</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

