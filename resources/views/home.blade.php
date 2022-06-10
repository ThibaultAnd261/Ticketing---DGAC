<!-- permet de récupérer les parties communes dans chacune des pages (simplifier le code) -->
@extends('layouts/app')

@section('navbar')
    <nav class="fr-nav" id="header-navigation" role="navigation" aria-label="Menu principal">
        <ul class="fr-nav__list">
            <li class="fr-nav__item">
                <!-- {{ route('acc') }} permet de récupérer les views via les names créés dans web.php -->
                <a class="fr-nav__link" href="{{ route('acc') }}" target="_self" aria-current="page">Accueil</a>
            </li>
            @if (auth()->check())
                <li class="fr-nav__item">
                    <a class="fr-nav__link" href="{{ route('creT') }}" target="_self">Ouverture d'un ticket</a>
                </li>
                <li class="fr-nav__item">
                    <a class="fr-nav__link" href="{{ route('tic') }}" target="_self">Vos tickets</a>
                </li>
                @if (auth()->user()->fonction == 'Superviseur')
                    <li class="fr-nav__item">
                        <a class="fr-nav__link" href="{{ route('tab') }}" target="_self">Tableau de bord</a>
                    </li>
                    <li class="fr-nav__item">
                        <a class="fr-nav__link" href="{{ route('sta') }}" target="_self">Statistiques</a>
                    </li>
                @endif
            @endif
        </ul>
    </nav>
@endsection

<!-- section permettant de définir la partie dynamique du site -->
@section('content')
    <main role="maincontent" id="main">
        <section class="fr-container fr-my-10w">
            @if (auth()->check())
                <h1 class="fr-h1">Prénom Nom : {{ auth()->user()->name }}</h1>
                <h1 class="fr-h1">Email : {{ auth()->user()->email }}</h1>
                <h1 class="fr-h1">Service : {{ auth()->user()->service }}</h1>
                <h1 class="fr-h1">Fonction : {{ auth()->user()->fonction }}</h1>
                <h1 class="fr-h1">Date de création : {{ \Carbon\Carbon::parse(auth()->user()->created_at)->translatedFormat('d-m-Y H\hi') }}</h1>
                {{-- config/app.php => timezone = 'Europe/Paris' et non 'UTC'--}}
                {{-- <h1 class="fr-h1">{{ \Carbon\Carbon::now()->translatedFormat('d-m-Y H:i:s') }}</h1> --}}
                {{-- <h1 class="fr-h1">{{ \Carbon\Carbon::now()->translatedFormat('d-m-Y H:h:i') }}</h1> --}}
                {{-- <h1 class="fr-h1">{{\Carbon\Carbon::now('Europe/Paris')}}</h1>
                <h1 class="fr-h1">{{\Carbon\Carbon::now()}}</h1> --}}
            @else
                <h1 class="fr-h1">Vous êtes sur la page d'accueil</h1>
            @endif

        </section>
    </main>
@endsection
