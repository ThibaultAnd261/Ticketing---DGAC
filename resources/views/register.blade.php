<!-- permet de récupérer les parties communes dans chacune des pages (simplifier le code) -->
@extends('layouts/app')

@section('navbar')
    <nav class="fr-nav" id="header-navigation" role="navigation" aria-label="Menu principal">
        <ul class="fr-nav__list">
            <li class="fr-nav__item">
                <a class="fr-nav__link" href="{{ route('acc') }}" target="_self">Accueil</a>
            </li>
        </ul>
    </nav>
@endsection

<!-- section permettant de définir la partie dynamique du site -->
@section('content')
    <main role="maincontent" id="main">
        <section class="fr-container fr-my-10w">
            <h1 class="fr-h1">Inscription</h1>

            @foreach ($errors->all() as $msg)
                <div class="fr-alert fr-alert--error">
                    <p class="fr-alert__title">Erreur : {{ $msg }}</p>
                </div>
            @endforeach

            <form action="{{ route('inscription') }}" method="post">
                <!-- sécurité face aux attaques -->
                @csrf
                <div class="fr-my-2w">
                    <fieldset class="fr-fieldset fr-fieldset--inline">
                        <label class="fr-label" for="text-input-text">
                            Type de compte :
                            <span class="fr-hint-text">Est-ce que le compte créé sera pour un simple utilisateur ou alors à un superviseur ?</span>
                        </label>
                        <div class="fr-fieldset__content">
                            <div class="fr-radio-group">
                                <input type="radio" id="radio-hint-1" name="fonction" value="Utilisateur">
                                <label class="fr-label" for="radio-hint-1">Utilisateur
                                </label>
                            </div>
                            <div class="fr-radio-group">
                                <input type="radio" id="radio-hint-2" name="fonction" value="Superviseur">
                                <label class="fr-label" for="radio-hint-2">Superviseur
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    <div class="fr-my-2w">
                        <label class="fr-label" for="text-input-text">Prénom NOM :</label>
                        <input class="fr-input" type="text" name="name">
                    </div>
                    <div class="fr-my-2w">
                        <label class="fr-label" for="text-input-text">Votre email :</label>
                        <input class="fr-input" type="email" name="email">
                    </div>
                    <div class="fr-select-group fr-my-2w">
                        <label class="fr-label" for="select">
                            Service affecté :
                        </label>
                        <select class="fr-select" id="select" name="select">
                            <option value="" selected disabled hidden>Selectionnez une option</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->nomService }}">{{ $service->nomService }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="fr-my-2w">
                        <label class="fr-label" for="text-input-text">Mot de passe :</label>
                        <input class="fr-input" type="password" name="password">
                    </div>
                    <div class="fr-my-2w">
                        <label class="fr-label" for="text-input-text">Retapez votre mot de passe :</label>
                        <input class="fr-input" type="password" name="password_confirmation">
                    </div>
                    <div class="fr-grid-row fr-grid-row--right">
                        <button class="fr-btn fr-fi-checkbox-circle-line fr-btn--icon-left fr-my-5w" type="submit">
                            S'inscrire
                        </button>
                    </div>
                </div>
            </form>
        </section>
    </main>
@endsection
