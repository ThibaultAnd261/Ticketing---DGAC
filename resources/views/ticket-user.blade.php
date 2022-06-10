<!-- permet de récupérer les parties communes dans chacune des pages (simplifier le code) -->
@extends('layouts/app')

@section('navbar')
    <nav class="fr-nav" id="header-navigation" role="navigation" aria-label="Menu principal">
        <ul class="fr-nav__list">
            <li class="fr-nav__item">
                <a class="fr-nav__link" href="{{ route('acc') }}" target="_self">Accueil</a>
            </li>
            <li class="fr-nav__item">
                <a class="fr-nav__link" href="{{ route('creT') }}" target="_self">Ouverture d'un
                    ticket</a>
            </li>
            <li class="fr-nav__item">
                <a class="fr-nav__link" href="{{ route('tic') }}" target="_self" aria-current="page">Vos tickets</a>
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
        <section class="fr-container fr-my-10w">
            <h1 class="fr-h1">Vos tickets</h1>
            <div class="fr-container">
                <h4 class="fr-h4">En cours de traitement
                    <button class="fr-btn" id="btn-content1" data-fr-opened="false" onclick="hide(1)">
                        Réduire
                    </button>
                </h4>
                <div class="fr-table fr-table--bordered" id="table-content1">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">N° ticket</th>
                                <th scope="col">Titre</th>
                                <th scope="col">Date de création</th>
                                <th scope="col">Voir plus</th>
                            </tr>
                        </thead>

                        @foreach ($tickets as $ticketInfo)
                            @if ($ticketInfo->status == 'en cours' && $ticketInfo->email == auth()->user()->email)
                                <tbody>
                                    <tr>
                                        <td>{{ $ticketInfo->id }}</td>
                                        <td>{{ $ticketInfo->titre }}</td>
                                        <td>{{ Carbon\Carbon::parse($ticketInfo->created_at)->translatedFormat('d-m-Y à H:i:s') }}
                                        </td>
                                        <td><button class="fr-btn" onclick="modalData({{ $ticketInfo->id }})"
                                                data-fr-opened="false" aria-controls="fr-modal-1">
                                                Voir plus
                                            </button></td>
                                    </tr>
                                </tbody>
                            @else
                                @if (App\Models\Ticket::where('status', '=', 'en cours')->where('email', auth()->user()->email)->count() == 0 && $loop->first)
                                    <tr>
                                        <td colspan="7">Aucun ticket inséré avec ce niveau de criticité</td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="fr-container">
                <h4 class="fr-h4">Non traité
                    <button class="fr-btn" id="btn-content2" data-fr-opened="false" onclick="hide(2)">
                        Réduire
                    </button>
                </h4>
                <div class="fr-table fr-table--bordered" id="table-content2">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">N° ticket</th>
                                <th scope="col">Titre</th>
                                <th scope="col">Date de création</th>
                                <th scope="col">Voir plus</th>
                            </tr>
                        </thead>

                        @foreach ($tickets as $ticketInfo)
                            @if ($ticketInfo->status == 'non traité' && $ticketInfo->email == auth()->user()->email)
                                <tbody>
                                    <tr>
                                        <td>{{ $ticketInfo->id }}</td>
                                        <td>{{ $ticketInfo->titre }}</td>
                                        <td>{{ Carbon\Carbon::parse($ticketInfo->created_at)->translatedFormat('d-m-Y à H:i:s') }}
                                        </td>
                                        <td><button class="fr-btn" onclick="modalData({{ $ticketInfo->id }})"
                                                data-fr-opened="false" aria-controls="fr-modal-1">
                                                Voir plus
                                            </button></td>
                                    </tr>
                                </tbody>
                            @else
                                @if (App\Models\Ticket::where('status', '=', 'non traité')->where('email', auth()->user()->email)->count() == 0 && $loop->first)
                                    <tr>
                                        <td colspan="7">Aucun ticket inséré avec ce niveau de criticité</td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="fr-container">
                <h4 class="fr-h4">Terminé
                    <button class="fr-btn" id="btn-content3" data-fr-opened="false" onclick="hide(3)">
                        Réduire
                    </button>
                </h4>
                <div class="fr-table fr-table--bordered" id="table-content3">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">N° ticket</th>
                                <th scope="col">Titre</th>
                                <th scope="col">Date de création</th>
                                <th scope="col">Voir plus</th>
                            </tr>
                        </thead>

                        @foreach ($tickets as $ticketInfo)
                            @if ($ticketInfo->status == 'traité' && $ticketInfo->email == auth()->user()->email)
                                <tbody>
                                    <tr>
                                        <td>{{ $ticketInfo->id }}</td>
                                        <td>{{ $ticketInfo->titre }}</td>
                                        <td>{{ Carbon\Carbon::parse($ticketInfo->created_at)->translatedFormat('d-m-Y à H:i:s') }}
                                        </td>
                                        <td><button class="fr-btn" onclick="modalData({{ $ticketInfo->id }})"
                                                data-fr-opened="false" aria-controls="fr-modal-1">
                                                Voir plus
                                            </button></td>
                                    </tr>
                                </tbody>
                            @else
                                @if (App\Models\Ticket::where('status', '=', 'traité')->where('email', auth()->user()->email)->count() == 0 && $loop->first)
                                    <tr>
                                        <td colspan="7">Aucun ticket inséré avec ce niveau de criticité</td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>

        </section>
    </main>
@endsection

@section('modal')
    <div class="fr-modal__content">
        <h1 id="fr-modal-title-modal-1" class="fr-modal__title"><span class="fr-fi-arrow-right-line fr-fi--lg"
                aria-hidden="true"></span>Ticket n°<span id="id-ticket"></span>
        </h1>

        <div class="fr-container fr-my-5w fr-form-group">
            <div class="fr-text--regular" id='radio-hint-legend'>
                <label class="fr-label fr-text--bold" for="text-input-text">
                    Statut du ticket</label>
            </div>
            <div id="statut-ticket"></div>
        </div>

        <div class="fr-container fr-my-5w fr-form-group">
            <div class="fr-text--regular" id='radio-hint-legend'>
                <label class="fr-label fr-text--bold" for="text-input-text">
                    Création du ticket</label>
            </div>
            <div id="creation-ticket"></div>
        </div>

        <div class="fr-container fr-my-5w fr-form-group">
            <div class="fr-text--regular" id='radio-hint-legend'>
                <label class="fr-label fr-text--bold" for="text-input-text">
                    Date de la dernière modification</label>
            </div>
            <div id="modification-ticket"></div>
        </div>

        <div class="fr-container fr-my-5w">
            <label class="fr-label fr-text--bold" for="text-input-text">Titre du problème</label>
            <label class="fr-label" for="text-input-text" id="titre-ticket"></label>
        </div>

        <div class="fr-container fr-input-group fr-my-5w">
            <label class="fr-label fr-text--bold" for="textarea">
                Description du problème
            </label>
            <label class="fr-label" for="text-input-text" id="description-ticket"></label>
        </div>

        <div class="fr-container fr-input-group fr-my-5w">
            <label class="fr-label fr-text--bold" for="textarea">
                Dernier commentaire inséré par le superviseur
            </label>
            <label class="fr-label" for="text-input-text" id="commentaire-ticket"></label>
        </div>

        <div class="fr-container fr-my-5w fr-form-group">
            <div class="fr-text--regular" id='radio-hint-legend'>
                <label class="fr-label fr-text--bold" for="text-input-text">
                    Image</label>
                <span class="fr-hint-text">Fichier image joint par le demandeur</span>
            </div>
            <div id="image-ticket"></div>
        </div>

    </div>
@endsection

<script>
    // AJAX permettant de mettre les informations correspondantes dans la fenêtre modale en fonction de l'id, lié avec la view 'dashboard.blade.php'
    function modalData(id) {
        var xmlhttp =
            new XMLHttpRequest(); //requêtes HTTP qui pourra récupérer les données dans le serveur sans changer de page
        xmlhttp.open("GET", "http://localhost/larProj/public/tableau/" + id,
            true
        ); // récupère les données présentes sur l'URL qui est en méthode GET (tapé l'url avec un id valide pour voir les données) ! à définir dans routes/web.php
        xmlhttp.setRequestHeader("Content-Type", "application/json");
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let child = document.getElementById("img-Upload");
                var data = JSON.parse(xmlhttp.response); // permet de manipuler les données en format JSON

                // variables pour la conversion des dates
                const weekday = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];
                const month = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre",
                    "Octobre", "Novembre", "Décembre"
                ];

                // insertion des données dans la modale
                document.getElementById("id-ticket").innerHTML = data.ticketMod.id;
                document.getElementById("statut-ticket").innerHTML = data.ticketMod.status;
                // document.getElementById("creation-ticket").innerHTML = (data.ticketMod.created_at).substr(0, 10);

                if (data.ticketMod.created_at) {
                    // conversion de la date présente dans la BD via Date() en JS (car sur le site web, la date est repassé en UTC)
                    var date = new Date(data.ticketMod.created_at);
                    var day = date.getDate();
                    let dayName = weekday[date.getDay()];
                    var monthName = month[date.getMonth()]
                    var year = date.getFullYear();

                    var hour = addZero(date.getHours());
                    var minutes = addZero(date.getMinutes());


                    var dateUpdate = dayName + ' ' + day + ' ' + monthName + ' ' + year + ' à ' + hour + 'h' +
                        minutes;
                    document.getElementById("creation-ticket").textContent = dateUpdate;
                }
                if (data.ticketMod.updated_at == null) {
                    document.getElementById("modification-ticket").textContent =
                        "Aucune modification apportée par un superviseur sur le ticket";
                } else {
                    var date = new Date(data.ticketMod.updated_at);
                    var day = date.getDate();
                    let dayName = weekday[date.getDay()];
                    var monthName = month[date.getMonth()]
                    var year = date.getFullYear();

                    var hour = addZero(date.getHours());
                    var minutes = addZero(date.getMinutes());


                    var dateUpdate = dayName + ' ' + day + ' ' + monthName + ' ' + year + ' à ' + hour + 'h' +
                        minutes;
                    document.getElementById("modification-ticket").textContent = dateUpdate;
                }
                document.getElementById("titre-ticket").innerHTML = data.ticketMod.titre;
                document.getElementById("description-ticket").innerHTML = data.ticketMod.description;

                // on regarde si une image a été donnée ou non
                if (data.ticketMod.fileUpload == 'null') {
                    document.getElementById("image-ticket").classList.remove("fr-card__img");
                    document.getElementById("image-ticket").innerHTML =
                        "Aucune image a été insérée par le demandeur";
                } else {
                    if (!(document.body.contains(child))) {
                        var img = document.createElement("img");
                        img.src = "{{ url('/uploads/img/ticket') }}" + "/" + data.ticketMod.fileUpload;
                        img.id = "img-Upload"
                        document.getElementById("image-ticket").classList.add("fr-card__img");
                        document.getElementById("image-ticket").appendChild(img);
                    }
                }

                // on regarde si un commentaire a été donnée ou non
                if (data.ticketMod.commentaires == 'null') {
                    document.getElementById("commentaire-ticket").textContent =
                        "Aucun commentaire a été inséré par un superviseur";
                } else {
                    document.getElementById("commentaire-ticket").textContent = data.ticketMod.commentaires;
                }
            }
        }
        xmlhttp.send();
    }
    // ajouter des zéros pour la date dans les fenêtres modales (esthétique)
    function addZero(i) {
        if (i < 10) {
            i = "0" + i
        }
        return i;
    }
</script>
