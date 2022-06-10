<!-- permet de récupérer les parties communes dans chacune des pages (simplifier le code) -->
@extends('layouts/app')

@section('navbar')
<nav class="fr-nav" id="header-navigation" role="navigation" aria-label="Menu principal">
    <ul class="fr-nav__list">
        <li class="fr-nav__item">
            <a class="fr-nav__link" href="{{ route('acc') }}" target="_self">Accueil</a>
        </li>
        <!-- permet de savoir si l'utilisateur est connecté, si oui on peut afficher ces 2 liens, sinon ces liens sont invisibles -->
        @if (auth()->check())
        <li class="fr-nav__item">
            <a class="fr-nav__link" href="{{ route('creT') }}" target="_self">Ouverture d'un ticket</a>
        </li>
        <li class="fr-nav__item">
            <a class="fr-nav__link" href="{{ route('tab') }}" target="_self">Tableau de bord</a>
        </li>
        @endif
    </ul>
</nav>
@endsection

@section('content')
<main role="maincontent" id="main">
    <section class="fr-container fr-my-10w">
        <!-- gestion des erreurs/succès -->
        @if (session('success'))
        <h3 class="fr-h3 fr-background-alt--green-menthe fr-tile__body fr-my-3w">{{ session('success') }}</h3>
        @endif
        <h1 class="fr-h1">Réinitialisation de mot de passe</h1>

        @foreach ($errors->all() as $msg)
        <h3 class="fr-h3 fr-background-alt--red-marianne fr-tile__body fr-my-3w">{{ $msg }}</h3>
        @endforeach

        <form action="{{ route('rei') }}" method="post">
            <!-- sécurité face aux attaques -->
            @csrf
            <div class="fr-my-2w">
                <div class="fr-my-2w">
                    <label class="fr-label" for="text-input-text">Votre email</label>
                    <input class="fr-input" type="email" name="email">
                </div>
                <div class="fr-my-2w">
                    <label class="fr-label" for="text-input-text">Nouveau mot de passe :</label>
                    <input class="fr-input" type="password" name="password">
                </div>
                <div class="fr-my-2w">
                    <label class="fr-label" for="text-input-text">Retapez votre mot de passe :</label>
                    <input class="fr-input" type="password" name="password_confirmation">
                </div>
                <div class="fr-grid-row fr-grid-row--right">
                    <button class="fr-btn fr-fi-checkbox-circle-line fr-btn--icon-left fr-my-5w" type="submit">
                        Valider
                    </button>
                </div>
            </div>
        </form>
    </section>
</main>
@endsection