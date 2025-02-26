<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
Route::post('validation', [RegisterController::class, 'store']);

// Route::middleware(['auth', 'role:chauffeur'])->group(function () {
//     Route::get('/dashboard-chauffeur', [ChauffeurController::class, 'index'])->name('chauffeur.dashboard');
// });

// Route::middleware(['auth', 'role:passager'])->group(function () {
//     Route::get('/dashboard-passager', [PassagerController::class, 'index'])->name('passager.dashboard');
// });


require __DIR__.'/auth.php';
