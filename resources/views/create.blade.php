<!-- permet de récupérer les parties communes dans chacune des pages (simplifier le code) -->
@extends('layouts/app')

@section('navbar')
    <nav class="fr-nav" id="header-navigation" role="navigation" aria-label="Menu principal">
        <ul class="fr-nav__list">
            <li class="fr-nav__item">
                <!-- {{ route('acc') }} permet de récupérer les views via les names créés dans web.php -->
                <a class="fr-nav__link" href="{{ route('acc') }}" target="_self">Accueil</a>
            </li>
            <li class="fr-nav__item">
                <a class="fr-nav__link" href="{{ route('creT') }}" target="_self" aria-current="page">Ouverture d'un
                    ticket</a>
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
        </ul>
    </nav>
@endsection

<!-- section permettant de définir la partie dynamique du site -->
@section('content')
    <main role="maincontent" id="main">
        <section class="fr-container fr-my-10w ">
            <h1 class="fr-h1">Ouverture d'un ticket</h1>
            @foreach ($errors->all() as $msg)
                <div class="fr-alert fr-alert--error">
                    <p class="fr-alert__title">Erreur : {{ $msg }}</p>
                </div>
            @endforeach

            @if (session('success'))
                <div class="fr-alert fr-alert--success fr-my-3w">
                    <p class="fr-alert__title">{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('ticketing') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="fr-container">
                    <div class="fr-grid-row fr-my-5w">
                        <label class="fr-label fr-col-12" for="text-input-icon">Service
                            <span class="fr-hint-text">Veuillez désigner le service qui devrait résoudre le
                                problème</span>
                        </label>
                        <select class="fr-select" id="select" name="select">
                            <option value="" selected disabled hidden>Selectionnez un service</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->nomService }}">{{ $service->nomService }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="fr-container fr-my-5w fr-form-group">
                    <fieldset class="fr-fieldset fr-fieldset--inline">
                        <legend class="fr-fieldset__legend fr-text--regular" id='radio-hint-legend'>
                            Priorité de la demande
                            <span class="fr-hint-text">Permet à l'agent de s'organiser en fonction de la priorité des
                                demandes</span>
                        </legend>
                        <div class="fr-fieldset__content">
                            <div class="fr-radio-group">
                                <input type="radio" id="radio-hint-1" name="radio-hint" value="Elevé">
                                <label class="fr-label" for="radio-hint-1">Elevé
                                </label>
                            </div>
                            <div class="fr-radio-group">
                                <input type="radio" id="radio-hint-2" name="radio-hint" value="Moyen">
                                <label class="fr-label" for="radio-hint-2">Moyen
                                </label>
                            </div>
                            <div class="fr-radio-group">
                                <input type="radio" id="radio-hint-3" name="radio-hint" value="Faible">
                                <label class="fr-label" for="radio-hint-3">Faible
                                </label>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="fr-container fr-my-5w" id="titre">
                    <label class="fr-label" for="text-input-text">Titre du problème</label>
                    <select class="fr-select" id="select-title" name="select-title" onchange="inputAutre()">
                        <option value="" selected disabled hidden>Selectionnez un titre</option>
                        <optgroup label="01 - Refection">
                            <option value="Mur">Mur</option>
                            <option value="Sol">Sol</option>
                            <option value="Autre">Autre</option>
                        </optgroup>
                        <optgroup label="02 - Plomberie">
                            <option value="Fuite">Fuite</option>
                            <option value="Lavabo bouché">Lavabo bouché</option>
                            <option value="Autre">Autre</option>
                        </optgroup>
                        <optgroup label="03 - Electricité">
                            <option value="Eclairage">Eclairage</option>
                            <option value="Prise">Prise</option>
                            <option value="Autre">Autre</option>
                        </optgroup>
                        <option value="Autre">Autre</option>
                    </select>
                </div>

                <div class="fr-container fr-input-group fr-my-5w">
                    <label class="fr-label" for="textarea">
                        Description du problème
                    </label>
                    <textarea class="fr-input" id="textarea" name="textarea"></textarea>
                </div>

                <div class="fr-container fr-my-5w">
                    <label class="fr-label fr-col-12" for="text-input-icon">Personne à contacter
                        <span class="fr-hint-text">Veuillez désigner le numéro de téléphone de la personne à
                            contacter</span>
                    </label>
                    <input class="fr-input" type="tel" id="phone" name="phone"
                        pattern="[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}">
                    <span class="fr-hint-text">Format : XX XX XX XX XX</span>
                </div>

                <div class="fr-container fr-upload-group fr-my-5w">
                    <label class="fr-label" for="file-upload">Ajouter un fichier
                        <span class="fr-hint-text">Taille maximale : 2 Mo. Formats supportés : jpeg, png, gif.</span>
                    </label>
                    <input class="fr-upload" type="file" id="file-upload" name="file-upload">
                </div>

                <div class="fr-container fr-my-5w fr-grid-row fr-grid-row--right">
                    <button class="fr-btn fr-fi-checkbox-circle-line fr-btn--icon-left fr-mx-1w fr-my-1w">
                        Envoyer
                    </button>
                </div>
            </form>
        </section>
    </main>
@endsection

<script>
    // fonction créant un champ de texte si le titre "Autre" est sélectionné par l'utilisateur
    function inputAutre() {
        let choice = document.getElementById('select-title')
            .value; // permet d'obtenir le choix de l'utilisateur sur la liste déroulante
        let child = document.getElementById(
            "titre-Autre"
            ); // <div> enfant de la <div> ayant pour id "titre" qui a été crée ci-dessous et permet de vérifier s'il a été créé dans le document HTML  
        if (choice == "Autre") { // Si l'utilisateur souhaite insérer un titre non présent sur les choix par défaut
            if (!(document.body.contains(
                    child
                    ))) { // on regarde si 'child' est présent dans le document HTML, si non, on crée la <div> avec les classes et id nécessaires
                let div = document.createElement("div");
                div.className = "fr-my-5w";
                div.id = "titre-Autre"

                let labeldiv = document.createElement("label");
                labeldiv.className = "fr-label";
                labeldiv.textContent = "Titre : "
                let input = document.createElement("input");
                input.type = "text";
                input.className = "fr-input";
                input.id = "text-input-text";
                input.name = "text-input-text";

                div.appendChild(labeldiv);
                div.appendChild(input);
                document.getElementById("titre").appendChild(div);
            }
        } else { // Si l'utilisateur souhaite un titre parmi les choix existants
            if (document.body.contains(
                    child
                    )) { // si oui, on enlève la classe 'child' car il n'a pas besoin d'insérer de texte vu qu'il a choisi un titre déjà existant
                document.getElementById("titre").removeChild(child);
            }
        }
    }
</script>
