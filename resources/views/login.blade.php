<!-- permet de récupérer les parties communes dans chacune des pages (simplifier le code) -->
@extends('layouts/app')

@section('navbar')
<nav class="fr-nav" id="header-navigation" role="navigation" aria-label="Menu principal">
    <ul class="fr-nav__list">
        <li class="fr-nav__item">
            <!-- {{ route('acc') }} permet de récupérer les views via les names créés dans web.php -->
            <a class="fr-nav__link" href="{{ route('acc') }}" target="_self">Accueil</a>
        </li>
    </ul>
</nav>
@endsection

<!-- section permettant de définir la partie dynamique du site -->
@section('content')
<main role="maincontent" id="main">
    <section class="fr-container fr-my-10w">
        <!-- gestion des erreurs/succès -->
        @if (session('success'))
        <div class="fr-alert fr-alert--success fr-my-3w">
            <p class="fr-alert__title">{{ session('success') }}</p>
        </div>
        @endif

        <h1 class="fr-h1">Connexion</h1>

        @foreach ($errors->all() as $msg)
        <div class="fr-alert fr-alert--error fr-my-3w">
            <p class="fr-alert__title">Erreur : {{ $msg }}</p>
        </div>
        @endforeach

        <form action="{{ route('authentification') }}" method="post">
            <!-- @csrf -> sécurité face aux attaques cyber -->
            @csrf
            <div class="fr-my-2w">
                <div class="fr-my-2w">
                    <label class="fr-label" for="text-input-text">Votre email</label>
                    <input class="fr-input" type="email" name="email">
                </div>
                <div class="fr-my-2w">
                    <label class="fr-label" for="text-input-text">Votre mot de passe</label>
                    <input class="fr-input" type="password" name="password">
                </div>
                <div class="fr-my-2w">
                    <a class="fr-link" href="{{ route('mdp') }}">Mot de passe oublié</a>
                </div>
                <div class="fr-grid-row fr-grid-row--right">
                    <button class="fr-btn fr-fi-checkbox-circle-line fr-btn--icon-left fr-my-5w" type="submit">
                        Se connecter
                    </button>
                </div>
            </div>
        </form>
    </section>
</main>
@endsection