<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ProfileController;
use App\Models\Location;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/register', [RegisterController::class, 'create'])
    ->middleware('guest')
    ->name('register');
Route::post('/register', [RegisterController::class, 'store'])
    ->middleware('guest');


// Route::middleware('guest')->group(function () {
//     Route::get('/register', [RegisterController::class, 'create'])->name('register');
//     Route::post('/register', [RegisterController::class, 'store']);


// });
// Driver Routes - Accessible only for drivers
Route::middleware(['auth', 'driver'])->group(function () {
    // Driver Dashboard
    Route::get('/driver-dashboard', function () {
        return view('driver-dashboard');
    })->name('driver-dashboard');

    // Driver Trip Requests
    Route::get('/trip-requests', [DriverController::class, 'tripRequests'])
        ->name('driver.trip-requests');

    // Driver Availability
    Route::get('/availability', [DriverController::class, 'showAvailability'])
        ->name('driver.availability');
    Route::post('/availability', [DriverController::class, 'updateAvailability'])
        ->name('driver.update-availability');

    // Booking Actions
    Route::post('/driver/bookings/{booking}/accept', [DriverController::class, 'acceptBooking'])
        ->name('driver.bookings.accept');
    Route::post('/driver/bookings/{booking}/reject', [DriverController::class, 'rejectBooking'])
        ->name('driver.bookings.reject');
});

// Passenger Routes - Accessible only for passengers
Route::middleware(['auth', 'passenger'])->group(function () {
    // Passenger Dashboard
    Route::get('/passenger-dashboard', function () {
        try {
            $locations = Location::all();
            return view('passenger-dashboard', compact('locations'));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    })->name('passenger-dashboard');

    // Booking Routes
    Route::get('/book-trip', [BookingController::class, 'create'])->name('book-trip');
    Route::post('/book-trip', [BookingController::class, 'store'])->name('book-trip.store');
    Route::get('/filter-drivers', [BookingController::class, 'filterDrivers'])->name('filter-drivers');
});

// Shared Routes - Accessible by both passenger and driver
Route::middleware('auth')->group(function () {
    Route::get('/trip-history', [BookingController::class, 'history'])->name('trip-history');
    Route::post('/cancel-booking/{booking}', [BookingController::class, 'cancel'])->name('cancel-booking');
});


Route::get('/dashboard', function(){
    return 'here';
})->name('admin.dashboard');


// Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
//     Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('admin.dashboard');
//     // Route::resource('users', App\Http\Controllers\UserController::class);
//     // Route::resource('drivers', App\Http\Controllers\DriverController::class);
//     // Route::resource('trips', App\Http\Controllers\TripController::class);
//     Route::resource('reviews', App\Http\Controllers\ReviewController::class);
// });
require __DIR__.'/auth.php';
