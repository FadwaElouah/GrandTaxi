<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PassagerController;
use App\Http\Controllers\ChauffeurController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('register', [RegisterController::class, 'showRegisterForm']);
Route::post('validation', [RegisterController::class, 'register']);

// Routes pour le passager
Route::middleware(['auth', 'role:passager'])->group(function () {
    Route::get('/passager/dashboard', [PassagerController::class, 'dashboard'])->name('passager.dashboard');
    Route::get('/passager/trajets', [PassagerController::class, 'listTrajets'])->name('passager.trajets');
    Route::post('/passager/reserver/{trajet_id}', [PassagerController::class, 'reserver'])->name('passager.reserver');
    Route::get('/passager/reservations', [PassagerController::class, 'reservations'])->name('passager.reservations');
    Route::delete('/passager/reservations/{id}/annuler', [PassagerController::class, 'annulerReservation'])->name('passager.annulerReservation');
    Route::get('/passager/historique', [PassagerController::class, 'historiqueTrajet'])->name('passager.historique');
    Route::get('/passager/chauffeurs', [PassagerController::class, 'filtrerChauffeurs'])->name('passager.filtrerChauffeurs');
    Route::get('/passager/chauffeurs/{id}', [PassagerController::class, 'voirChauffeur'])->name('passager.voirChauffeur');
    Route::post('/passager/creer-reservation', [PassagerController::class, 'creerReservation'])->name('passager.creerReservation');
});


// Routes pour le chauffeur
Route::middleware(['auth', 'role:chauffeur'])->group(function () {
    Route::get('/chauffeur/dashboard', [ChauffeurController ::class, 'dashboard'])->name('chauffeur.dashboard');
    Route::get('/chauffeur/accepter/{id}', [ChauffeurController::class, 'accepterReservation'])->name('chauffeur.accepter');
    Route::post('/chauffeur/refuser/{id}', [ChauffeurController::class, 'refuserReservation'])->name('chauffeur.refuser');
    Route::get('/chauffeur/disponibilites', [ChauffeurController::class, 'disponibilites'])->name('chauffeur.disponibilites');
    Route::post('/chauffeur/disponibilites', [ChauffeurController::class, 'mettreAJourDisponibilite'])->name('chauffeur.mettreAJourDisponibilite');
});

require __DIR__.'/auth.php';

