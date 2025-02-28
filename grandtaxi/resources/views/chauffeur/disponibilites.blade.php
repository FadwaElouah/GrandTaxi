@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mes disponibilités</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('chauffeur.mettreAJourDisponibilite') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="is_available">Disponible</label>
            <select name="is_available" id="is_available" class="form-control" required>
                <option value="1">Oui</option>
                <option value="0">Non</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>

    <h2>Mes disponibilités actuelles</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Disponible</th>
            </tr>
        </thead>
        <tbody>
            @foreach($disponibilites as $disponibilite)
                <tr>
                    <td>{{ $disponibilite->date }}</td>
                    <td>{{ $disponibilite->is_available ? 'Oui' : 'Non' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

