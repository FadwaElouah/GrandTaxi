<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
      $validator = validator::make($request->all(),[
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'telephone' => 'required|string',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        'role' => 'required|string',
        'disponible_de' => 'nullable|date_format:H:i',
        'disponible_a' => 'nullable|date_format:H:i',

    ]);

    if($validator->fails()){
        return redirect()->back()->withErrors($validator)->withInput();

    }

    $photoPath = $request->file('photo')->store('photos', 'public');


    $user = User::create([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'telephone' => $request->telephone,
        'photo' => $photoPath,
        'role' => $request->role,
        'disponible_de' => $request->disponible_de,
        'disponible_a' => $request->disponible_a,
    ]);


    auth()->login($user);

    // return redirect()->route('dashboard');
    // return redirect()->route('dashboard')->with('success', 'Inscription réussie !');
    return redirect()->route('login');

}


public function store(Request $request)
{
    $request->validate([
        'nom' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $user = User::create([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'telephone' => $request->telephone,
        'role' => $request->role,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);




}
}

