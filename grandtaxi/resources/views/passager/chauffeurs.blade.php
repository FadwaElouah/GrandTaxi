@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Recherche de chauffeurs</h1>

    <form action="{{ route('passager.filtrerChauffeurs') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="location">Ville</label>
                    <input type="text" name="location" class="form-control" value="{{ request('location') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="disponible">Disponible uniquement</label>
                    <select name="disponible" class="form-control">
                        <option value="">Tout</option>
                        <option value="1" {{ request('disponible') == '1' ? 'selected' : '' }}>Uniquement les disponibles</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary mt-4">Recherche</button>
            </div>
        </div>
    </form>

    <div class="row">
        @foreach($chauffeurs as $chauffeur)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $chauffeur->name }}</h5>
                    <p class="card-text">Ville: {{ $chauffeur->location }}</p>
                    <a href="{{ route('passager.voirChauffeur', $chauffeur->id) }}" class="btn btn-primary">
                        Voir les détails
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
