@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Les Trajets Disponibles</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Destination</th>
                    <th>Date</th>
                    <th>Chauffeur</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trajets as $trajet)
                <tr>
                    <td>{{ $trajet->lieu_depart }}</td>
                    <td>{{ $trajet->lieu_arrivee }}</td>
                    <td>{{ $trajet->date }}</td>
                    <td>{{ $trajet->chauffeur->name }}</td>
                    <td>
                            <form action="{{ route('passager.reserver', $trajet->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Réserver</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
