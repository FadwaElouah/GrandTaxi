@extends('layouts.admin')

@section('title', 'Tableau de Bord')

@section('content')
<div class="container-fluid">
    <!-- Cards l-foq -->
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Total Chauffeurs</h6>
                            <h2 class="mb-0">{{ $driversCount }}</h2>
                        </div>
                        <i class="fas fa-id-card fa-3x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <span>Voir les détails</span>
                    <a href="{{ route('admin.drivers.index') }}" class="text-white">
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Total Passagers</h6>
                            <h2 class="mb-0">{{ $passengersCount }}</h2>
                        </div>
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <span>Voir les détails</span>
                    <a href="{{ route('admin.users.index') }}" class="text-white">
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Réservations Aujourd'hui</h6>
                            <h2 class="mb-0">{{ $todayBookingsCount }}</h2>
                        </div>
                        <i class="fas fa-calendar-check fa-3x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <span>Voir les détails</span>
                    <a href="{{ route('admin.bookings.index') }}" class="text-white">
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Revenus Total</h6>
                            <h2 class="mb-0">{{ number_format($totalRevenue, 2) }} DH</h2>
                        </div>
                        <i class="fas fa-money-bill-wave fa-3x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <span>Voir les détails</span>
                    <a href="{{ route('admin.stats') }}" class="text-white">
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables l-taht -->
    <div class="row">
        <!-- Latest Bookings -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Dernières Réservations</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Chauffeur</th>
                                    <th>Passager</th>
                                    <th>Destination</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentBookings as $booking)
                                <tr>
                                    <td>{{ $booking->id }}</td>
                                    <td>{{ $booking->driver->user->name ?? 'N/A' }}</td>
                                    <td>{{ $booking->user->name }}</td>
                                    <td>{{ $booking->location->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($booking->status == 'pending')
                                            <span class="badge bg-warning">En attente</span>
                                        @elseif($booking->status == 'accepted')
                                            <span class="badge bg-info">Accepté</span>
                                        @elseif($booking->status == 'in_progress')
                                            <span class="badge bg-primary">En cours</span>
                                        @elseif($booking->status == 'completed')
                                            <span class="badge bg-success">Terminé</span>
                                        @elseif($booking->status == 'cancelled')
                                            <span class="badge bg-danger">Annulé</span>
                                        @endif
                                    </td>
                                    <td>{{ $booking->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Aucune réservation récente</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end mt-3">
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-primary">Voir toutes les réservations</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Reviews -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Derniers Avis</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Type</th>
                                    <th>Note</th>
                                    <th>Commentaire</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentReviews as $review)
                                <tr>
                                    <td>{{ $review->user->name }}</td>
                                    <td>
                                        @if($review->type == 'driver_review')
                                            <span class="badge bg-primary">Chauffeur</span>
                                        @else
                                            <span class="badge bg-secondary">Passager</span>
                                        @endif
                                    </td>
                                    <td>
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                    </td>
                                    <td>{{ Str::limit($review->comment, 30) }}</td>
                                    <td>{{ $review->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Aucun avis récent</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end mt-3">
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-primary">Voir tous les avis</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Locations populaires -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Destinations Populaires</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Destination</th>
                                    <th>Adresse</th>
                                    <th>Nombre de Réservations</th>
                                    <th>Prix Moyen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($popularLocations as $location)
                                <tr>
                                    <td>{{ $location->name }}</td>
                                    <td>{{ $location->address }}</td>
                                    <td>{{ $location->bookings_count }}</td>
                                    <td>{{ number_format($location->average_price, 2) }} DH</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Aucune destination disponible</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
