@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $chauffeur->name }}</h5>
                    @if($chauffeur->photo)
                        <img src="{{ asset('storage/' . $chauffeur->photo) }}" class="img-fluid rounded mb-3" alt="Photo du chauffeur">
                    @else
                        <img src="{{ asset('images/default-avatar.png') }}" class="img-fluid rounded mb-3" alt="Photo par défaut">
                    @endif
                    <p><strong>Ville:</strong> {{ $chauffeur->location }}</p>
                    <p><strong>Téléphone:</strong> {{ $chauffeur->phone }}</p>
                    <p><strong>Note:</strong>
                        @php
                            $rating = $chauffeur->evaluations()->avg('note') ?? 0;
                        @endphp
                        {{ number_format($rating, 1) }}/5
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Trajets disponibles</h5>
                </div>
                <div class="card-body">
                    @if($trajets->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Départ</th>
                                    <th>Arrivée</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trajets as $trajet)
                                <tr>
                                    <td>{{ $trajet->lieu_depart }}</td>
                                    <td>{{ $trajet->lieu_arrivee }}</td>
                                    <td>{{ $trajet->date }}</td>
                                    <td>
                                        <form action="{{ route('passager.reserver', $trajet->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm">Réserver</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Aucun trajet disponible pour ce chauffeur.</p>
                    @endif
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5>Créer une nouvelle réservation</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('passager.creerReservation') }}" method="POST">
                        @csrf
                        <input type="hidden" name="chauffeur_id" value="{{ $chauffeur->id }}">

                        <div class="mb-3">
                            <label for="lieu_depart" class="form-label">Lieu de départ</label>
                            <input type="text" class="form-control" id="lieu_depart" name="lieu_depart" required>
                        </div>

                        <div class="mb-3">
                            <label for="lieu_arrivee" class="form-label">Destination</label>
                            <input type="text" class="form-control" id="lieu_arrivee" name="lieu_arrivee" required>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date et heure</label>
                            <input type="datetime-local" class="form-control" id="date" name="date" required>
                        </div>

                        <button type="submit" class="btn btn-success">Créer une réservation</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

