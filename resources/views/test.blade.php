<!-- permet de récupérer les parties communes dans chacune des pages (simplifier le code) -->
@extends('layouts/app')

@section('navbar')
    <nav class="fr-nav" id="header-navigation" role="navigation" aria-label="Menu principal">
        <ul class="fr-nav__list">
            <li class="fr-nav__item">
                <!-- {{ route('acc') }} permet de récupérer les views via les names créés dans web.php -->
                <a class="fr-nav__link" href="{{ route('acc') }}" target="_self" aria-current="page">Accueil</a>
            </li>
            <li class="fr-nav__item">
                <a class="fr-nav__link" href="{{ route('creT') }}" target="_self">Ouverture d'un ticket</a>
            </li>
            <li class="fr-nav__item">
                <a class="fr-nav__link" href="{{ route('tab') }}" target="_self">Tableau de bord</a>
            </li>
        </ul>
    </nav>
@endsection

<!-- section permettant de définir la partie dynamique du site -->
@section('content')
    <main role="maincontent" id="main">
        <section class="fr-container fr-my-10w">
            <h1 class="fr-h1">Prénom Nom : {{ auth()->user()->name }}</h1>
            <h1 class="fr-h1">Email : {{ auth()->user()->email }}</h1>
            <h1 class="fr-h1">Service : {{ auth()->user()->service }}</h1>
            <h1 class="fr-h1">Date de création : {{ Str::substr(auth()->user()->created_at , 0, 10) }}</h1>
            <h1 class="fr-h1">Tu es connecté</h1>

    </main>
@endsection
