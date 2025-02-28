<x-app-layout>
    <div class="container d-flex flex-column align-items-center justify-content-center mt-5">
        <div class="card p-4 shadow-lg border-0" style="max-width: 600px; background-color: #F5E7D7; border-left: 5px solid #D2B48C;">
            <h1 class="text-center text-dark fw-bold" style="color: #5C3D2E;">Bienvenue dans votre Dashboard</h1>
            <p class="text-center text-muted" style="color: #7D5A50;">Gérez vos réservations et consultez les trajets disponibles en toute simplicité.</p>
            <div class="text-center">
                <a href="{{ route('passager.trajets') }}" class="btn text-white fw-semibold shadow"
                   style="background-color: #A67B5B; border-radius: 8px; padding: 10px 20px; transition: 0.3s;">
                    Voir les trajets
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
