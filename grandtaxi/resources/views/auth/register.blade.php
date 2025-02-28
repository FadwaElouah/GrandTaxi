
<x-guest-layout>


     @if (session('success'))
        <div class="bg-green-500 text-white p-3 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- @if ($errors->any())
        <div class="bg-red-500 text-white p-3 rounded-md mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}

    <form method="POST" action="/validation" enctype="multipart/form-data">
        @csrf

        <!-- Nom -->
        <div>
            <x-input-label for="nom" :value="__('Nom')" />
            {{-- <input id="nom" class="block mt-1 w-full" type="text" name="nom" value="{{ old('nom') }}" required> --}}
            <input id="nom"  class="block mt-1 w-full border border-gray-300 p-2 rounded"
    type="text" name="nom" value="{{ old('nom') ?? '' }}" required >


            {{-- <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom')" required autofocus autocomplete="nom" /> --}}
        </div>

        <!-- Prénom -->
        <div class="mt-4">
            <x-input-label for="prenom" :value="__('Prenom')" />
            <x-text-input id="prenom" class="block mt-1 w-full" type="text" name="prenom" :value="old('prenom')" required autocomplete="prenom" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
        </div>

        <!-- Téléphone -->
        <div class="mt-4">
            <x-input-label for="telephone" :value="__('Téléphone')" />
            <x-text-input id="telephone" class="block mt-1 w-full" type="text" name="telephone" :value="old('telephone')" required autocomplete="telephone" />
        </div>

        <!-- Photo -->
        <div class="mt-4">
            <x-input-label for="photo" :value="__('Photo de profil')" />
            <x-text-input id="photo" class="block mt-1 w-full" type="file" name="photo" accept="image/*" required />
        </div>

        <!-- Rôle -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Rôle')" />
            <select id="role" name="role" class="block mt-1 w-full" required>
                <option value="passager">Passager</option>
                <option value="chauffeur">Chauffeur</option>
            </select>
        </div>

        <!-- Disponibilité (Chauffeur uniquement) -->
        {{-- <div class="mt-4">
            <x-input-label for="disponible_de" :value="__('Disponible de')" />
            <x-text-input id="disponible_de" class="block mt-1 w-full" type="time" name="disponible_de" :value="old('disponible_de')" />
        </div>

        <div class="mt-4">
            <x-input-label for="disponible_a" :value="__('Disponible à')" />
            <x-text-input id="disponible_a" class="block mt-1 w-full" type="time" name="disponible_a" :value="old('disponible_a')" />
        </div> --}}

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Déjà inscrit ?') }}
            </a>

            <x-primary-button type='submit' class="ms-4">
                {{ __('S\'inscrire') }}
            </x-primary-button>
        </div>
    </form>


</x-guest-layout>
