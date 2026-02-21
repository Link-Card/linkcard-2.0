@extends('layouts.public')

@section('title', 'Se connecter avec ' . $profile->full_name . ' — Link-Card')
@section('meta_description', 'Ajoutez ' . $profile->full_name . ' à vos contacts Link-Card.')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12" style="background: #F7F8F4;">
    <div class="w-full max-w-sm">
        {{-- Card principale --}}
        <div class="rounded-2xl p-8 text-center" style="background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">

            {{-- Photo du profil --}}
            <div class="mb-4 flex justify-center">
                @if($profile->photo_path)
                    <img src="{{ asset('storage/' . $profile->photo_path) }}"
                         alt="{{ $profile->full_name }}"
                         class="w-20 h-20 rounded-full object-cover"
                         style="border: 3px solid #42B574;">
                @else
                    <div class="w-20 h-20 rounded-full flex items-center justify-center text-2xl font-bold text-white" style="background: linear-gradient(135deg, #42B574, #4A7FBF);">
                        {{ strtoupper(substr($profile->full_name, 0, 1)) }}
                    </div>
                @endif
            </div>

            {{-- Nom et titre --}}
            <h1 class="text-xl font-semibold mb-1" style="color: #2C2A27; font-family: 'Manrope', sans-serif;">
                {{ $profile->full_name }}
            </h1>
            @if($profile->job_title)
                <p class="text-sm mb-1" style="color: #4B5563;">{{ $profile->job_title }}</p>
            @endif
            @if($profile->company)
                <p class="text-xs mb-4" style="color: #9CA3AF;">{{ $profile->company }}</p>
            @else
                <div class="mb-4"></div>
            @endif

            {{-- Message --}}
            <p class="text-sm mb-6" style="color: #4B5563; font-family: 'Manrope', sans-serif;">
                Pour ajouter <strong>{{ $profile->full_name }}</strong> à vos contacts Link-Card, connectez-vous ou créez votre compte gratuit.
            </p>

            {{-- Boutons --}}
            <div class="space-y-3">
                {{-- Bouton Se connecter --}}
                <a href="{{ route('login', ['ref' => $username, 'action' => 'connect']) }}"
                   class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-sm font-semibold text-white transition-all duration-200"
                   style="background: #42B574; font-family: 'Manrope', sans-serif;"
                   onmouseover="this.style.background='#3DA367'"
                   onmouseout="this.style.background='#42B574'">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-8v2h8v14z"/></svg>
                    Se connecter
                </a>

                {{-- Bouton Créer un compte --}}
                <a href="{{ route('register', ['ref' => $username, 'action' => 'connect']) }}"
                   class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-sm font-semibold transition-all duration-200"
                   style="border: 2px solid #42B574; color: #42B574; background: transparent; font-family: 'Manrope', sans-serif;"
                   onmouseover="this.style.background='#F0F9F4'"
                   onmouseout="this.style.background='transparent'">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    Créer mon compte gratuitement
                </a>
            </div>
        </div>

        {{-- Lien retour --}}
        <div class="text-center mt-5">
            <a href="{{ route('profile.public', $username) }}"
               class="text-sm transition-colors duration-200"
               style="color: #9CA3AF; font-family: 'Manrope', sans-serif;"
               onmouseover="this.style.color='#4B5563'"
               onmouseout="this.style.color='#9CA3AF'">
                ← Retour au profil de {{ $profile->full_name }}
            </a>
        </div>
    </div>
</div>
@endsection
