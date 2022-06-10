<!-- permet de récupérer les parties communes dans chacune des pages (simplifier le code) -->
@extends('layouts/app')

@section('navbar')
    <nav class="fr-nav" id="header-navigation" role="navigation" aria-label="Menu principal">
        <ul class="fr-nav__list">
            <li class="fr-nav__item">
                <a class="fr-nav__link" href="{{ route('acc') }}" target="_self">Accueil</a>
            </li>
            <li class="fr-nav__item">
                <a class="fr-nav__link" href="{{ route('creT') }}" target="_self">Ouverture d'un ticket</a>
            </li>
            <li class="fr-nav__item">
                <a class="fr-nav__link" href="{{ route('tic') }}" target="_self">Vos tickets</a>
            </li>
            @if (auth()->user()->fonction == 'Superviseur')
                <li class="fr-nav__item">
                    <a class="fr-nav__link" href="{{ route('tab') }}" target="_self" aria-current="page">Tableau de
                        bord</a>
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
        <section class="fr-container fr-my-5w">
            <h1 class="fr-h1">Tableau de bord ({{ auth()->user()->service }})</h1>
            <div class="fr-container">
                @if (session('success'))
                    <div class="fr-alert fr-alert--success fr-my-3w">
                        <p class="fr-alert__title">{{ session('success') }}</p>
                    </div>
                @endif
                <h4 class="fr-h4">Elevé
                    <button class="fr-btn" id="btn-content1" data-fr-opened="false" onclick="hide(1)">
                        Réduire
                    </button>
                </h4>
                <div class="fr-table fr-table--bordered" id="table-content1">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">N° ticket</th>
                                <th scope="col">Demandeur</th>
                                <th scope="col">Email</th>
                                <th scope="col">Date de création</th>
                                <th scope="col">Titre</th>
                                <th scope="col">Voir plus</th>
                                <th scope="col">Commentaires</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($tickets as $ticketInfo)
                                @if ($ticketInfo->priorite == 'Elevé' && $ticketInfo->serviceAffecte == auth()->user()->service && !($ticketInfo->status == 'traité'))
                                    @if ($ticketInfo->status == 'en cours')
                                        <tr class="fr-background-contrast--orange-terre-battue">
                                        @else
                                        <tr>
                                    @endif
                                    <td>{{ $ticketInfo->id }}</td>
                                    <td>{{ $ticketInfo->name }}</td>
                                    <td>{{ $ticketInfo->email }}</td>
                                    <td>{{ Carbon\Carbon::parse($ticketInfo->created_at)->translatedFormat('d-m-Y à H:i:s') }}
                                    </td>
                                    <td>{{ $ticketInfo->titre }}</td>
                                    <td><button class="fr-btn"
                                            onclick="modalData({{ $ticketInfo->id }}, '{{ $ticketInfo->status }}')"
                                            data-fr-opened="false" aria-controls="fr-modal-1">
                                            Voir plus
                                        </button></td>
                                    <td><button class="fr-btn" data-fr-opened="false"
                                            aria-controls="fr-modal-commentaire"
                                            onclick="modalCommentaire({{ $ticketInfo->id }})">Ecrire</button></td>
                                    </tr>
                                @else
                                    @if (App\Models\Ticket::where('status', '!=', 'traité')->where('priorite', 'Elevé')->where('serviceAffecte', auth()->user()->service)->count() == 0 && $loop->first)
                                        <tr>
                                            <td colspan="7">Aucun ticket inséré avec ce niveau de criticité</td>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="fr-container">
                <h4 class="fr-h4">Moyen
                    <button class="fr-btn" id="btn-content2" data-fr-opened="false" onclick="hide(2)">
                        Réduire
                    </button>
                </h4>
                <div class="fr-table fr-table--bordered" id="table-content2">
                    <table>
                        <thead>
                            <th scope="col">N° ticket</th>
                            <th scope="col">Demandeur</th>
                            <th scope="col">Email</th>
                            <th scope="col">Service du demandeur</th>
                            <th scope="col">Titre</th>
                            <th scope="col">Voir plus</th>
                            <th scope="col">Commentaires</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($tickets as $ticketInfo)
                                @if ($ticketInfo->priorite == 'Moyen' && $ticketInfo->serviceAffecte == auth()->user()->service && !($ticketInfo->status == 'traité'))
                                    @if ($ticketInfo->status == 'en cours')
                                        <tr class="fr-background-contrast--orange-terre-battue">
                                        @else
                                        <tr>
                                    @endif
                                    <td>{{ $ticketInfo->id }}</td>
                                    <td>{{ $ticketInfo->name }}</td>
                                    <td>{{ $ticketInfo->email }}</td>
                                    <td>{{ Carbon\Carbon::parse($ticketInfo->created_at)->translatedFormat('d-m-Y à H:i:s') }}
                                    </td>
                                    <td>{{ $ticketInfo->titre }}</td>
                                    <td><button class="fr-btn"
                                            onclick="modalData({{ $ticketInfo->id }}, '{{ $ticketInfo->status }}')"
                                            data-fr-opened="false" aria-controls="fr-modal-1">
                                            Voir plus
                                        </button></td>
                                    <td><button class="fr-btn" data-fr-opened="false"
                                            aria-controls="fr-modal-commentaire"
                                            onclick="modalCommentaire({{ $ticketInfo->id }})">Ecrire</button></td>
                                    </tr>
                                @else
                                    @if (App\Models\Ticket::where('status', '!=', 'traité')->where('priorite', 'Moyen')->where('serviceAffecte', auth()->user()->service)->count() == 0 && $loop->first)
                                        <tr>
                                            <td colspan="7">Aucun ticket inséré avec ce niveau de criticité</td>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="fr-container">
                <h4 class="fr-h4">Faible
                    <button class="fr-btn" id="btn-content3" data-fr-opened="false" onclick="hide(3)">
                        Réduire
                    </button>
                </h4>
                <div class="fr-table fr-table--bordered" id="table-content3">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">N° ticket</th>
                                <th scope="col">Demandeur</th>
                                <th scope="col">Email</th>
                                <th scope="col">Service du demandeur</th>
                                <th scope="col">Titre</th>
                                <th scope="col">Voir plus</th>
                                <th scope="col">Commentaires</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticketInfo)
                                @if ($ticketInfo->priorite == 'Faible' && $ticketInfo->serviceAffecte == auth()->user()->service && !($ticketInfo->status == 'traité'))
                                    @if ($ticketInfo->status == 'en cours')
                                        <tr class="fr-background-contrast--orange-terre-battue">
                                        @else
                                        <tr>
                                    @endif
                                    <td>{{ $ticketInfo->id }}</td>
                                    <td>{{ $ticketInfo->name }}</td>
                                    <td>{{ $ticketInfo->email }}</td>
                                    <td>{{ Carbon\Carbon::parse($ticketInfo->created_at)->translatedFormat('d-m-Y à H:i:s') }}
                                    </td>
                                    <td>{{ $ticketInfo->titre }}</td>
                                    <td><button class="fr-btn"
                                            onclick="modalData({{ $ticketInfo->id }}, '{{ $ticketInfo->status }}')"
                                            data-fr-opened="false" aria-controls="fr-modal-1">
                                            Voir plus
                                        </button></td>
                                    <td><button class="fr-btn" data-fr-opened="false"
                                            aria-controls="fr-modal-commentaire"
                                            onclick="modalCommentaire({{ $ticketInfo->id }})">Ecrire</button></td>
                                    </tr>
                                @else
                                    @if (App\Models\Ticket::where('status', '!=', 'traité')->where('priorite', 'Faible')->where('serviceAffecte', auth()->user()->service)->count() == 0 && $loop->first)
                                        <tr>
                                            <td colspan="7">Aucun ticket inséré avec ce niveau de criticité</td>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                        </tbody>
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

        <div class="fr-container fr-my-5w fr-form-group">
            <div class="fr-text--regular" id='radio-hint-legend'>
                <label class="fr-label fr-text--bold" for="text-input-text">
                    Demandeur</label>
                <span class="fr-hint-text">Prénom NOM du demandeur</span>
            </div>
            <div id="demandeur-nom"></div>
        </div>

        <div class="fr-container fr-my-5w fr-form-group">
            <div class="fr-text--regular" id='radio-hint-legend'>
                <label class="fr-label fr-text--bold" for="text-input-text">
                    Mail de l'agent</label>
                <span class="fr-hint-text">Mail de l'agent affecté</span>
            </div>
            <div id="demandeur-email"></div>
        </div>

        <div class="fr-container fr-my-5w fr-form-group">
            <div class="fr-text--regular" id='radio-hint-legend'>
                <label class="fr-label fr-text--bold" for="text-input-text">
                    Numéro de téléphone</label>
                <span class="fr-hint-text">Personne à contacter par téléphone</span>
            </div>
            <div id="telephone-contact"></div>
        </div>

        <div class="fr-container fr-my-5w fr-form-group">
            <div class="fr-text--regular" id='radio-hint-legend'>
                <label class="fr-label fr-text--bold" for="text-input-text">
                    Priorité de la demande</label>
                <span class="fr-hint-text">Permet à l'agent de s'organiser en fonction de la priorité
                    des demandes</span>
            </div>
            <div id="priorite-ticket"></div>
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
    <div class="fr-modal__footer">
        <ul
            class="fr-btns-group fr-btns-group--right fr-btns-group--inline-reverse fr-btns-group--inline-lg fr-btns-group--icon-left">
            <li>
                <button class="fr-btn" id="btn-statut" data-fr-opened="false" aria-controls="fr-modal-confirmation">
                </button>
            </li>
        </ul>
    </div>
@endsection

@section('modal-confirmation')
    <div class="fr-modal__content" id="modal-content">
        <h3 id="fr-modal-2-title" class="fr-tile__body">
        </h3>
    </div>
    <div class="fr-modal__footer" id="modal-footer">
        <form action="{{ route('statutTicket') }} " method="post" id="chgmt-statut" enctype="multipart/form-data">
            @csrf
            <div id="modal-textarea" class="fr-my-5w">
                <label class="fr-label" for="textarea">Si oui, veuillez renseigner la démarche que vous avez adopté
                    pour
                    résoudre le problème :
                </label>
                <textarea class="fr-input" id="textarea-commentaire" name="resolution"></textarea>
            </div>
            <ul class="fr-btns-group fr-btns-group--right fr-btns-group--inline-reverse fr-btns-group--inline-lg">
                <li>
                    <button class="fr-btn" id="btn-statut--chgmt">
                        Oui
                    </button>
                    <button class="fr-btn" data-fr-opened="false" aria-controls="fr-modal-confirmation">
                        Non
                    </button>
                </li>
            </ul>
        </form>
    </div>
@endsection

<script>
    // AJAX permettant de mettre les informations correspondantes dans la fenêtre modale en fonction de l'id, lié avec la view 'dashboard.blade.php'
    function modalData(id, status) {
        var xmlhttp =
            new XMLHttpRequest(); //requêtes HTTP qui pourra récupérer les données dans le serveur sans changer de page
        xmlhttp.open("GET", "http://localhost/larProj/public/tableau/" + id,
            true
        ); // récupère les données présentes sur l'URL qui est en méthode GET (tapé l'url avec un id valide pour voir les données) ! à définir dans routes/web.php
        xmlhttp.setRequestHeader("Content-Type", "application/json");
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // variable permettant de vérifier si ces derniers existent dans le DOM ou non
                let childImg = document.getElementById("img-Upload");
                let childModalConf1 = document.getElementById("modal-Conf--value");
                let childModalConf2 = document.getElementById("modal-Conf--status");
                let textareaModalConf = document.getElementById("modal-textarea");

                // variables pour la conversion des dates
                const weekday = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];
                const month = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre",
                    "Octobre", "Novembre", "Décembre"
                ];

                var data = JSON.parse(xmlhttp.response); // permet de manipuler les données en format JSON

                // insertion des données dans la première fenêtre modale
                document.getElementById("id-ticket").textContent = data.ticketMod
                    .id; // si on va sur l'URL http://localhost/larProj/public/tableau/1, pour accéder aux informations, nous devons faire data.ticketMod.'...'

                // document.getElementById("creation-ticket").textContent = date;

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
                    // conversion de la date présente dans la BD via Date() en JS (car sur le site web, la date est repassé en UTC)
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

                document.getElementById("demandeur-nom").textContent = data.ticketMod.name + " (" + data.ticketMod
                    .serviceDemandeur + ")";
                document.getElementById("demandeur-email").textContent = data.ticketMod.email;
                document.getElementById("telephone-contact").textContent = data.ticketMod.telContact;
                document.getElementById("priorite-ticket").textContent = data.ticketMod.priorite;
                document.getElementById("titre-ticket").textContent = data.ticketMod.titre;
                document.getElementById("description-ticket").textContent = data.ticketMod.description;

                // on regarde si une image a été donnée ou non
                if (data.ticketMod.fileUpload == 'null') {
                    document.getElementById("image-ticket").classList.remove(
                        "fr-card__img"
                    ); // on enlève la classe permettant d'afficher les images vu qu'il n'y a pas d'image fourni par l'utilisateur
                    document.getElementById("image-ticket").textContent =
                        "Aucune image a été insérée par le demandeur";
                } else {
                    if (!(document.body.contains(
                            childImg
                        ))) { // si le DOM ne possède pas la <div> ayant pour id "img-Upload", alors on le crée
                        var img = document.createElement("img");
                        img.src = "{{ url('/uploads/img/ticket') }}" + "/" + data.ticketMod
                            .fileUpload; // url permettant de retourner sur le répertoire 'public' (par défaut) de l'application et avec le chemin donné ci-joint + le nom du doc stocké dans la BD, on pourra accéder à l'image donné par l'utilisateur
                        img.id = "img-Upload";

                        document.getElementById("image-ticket").classList.add(
                            "fr-card__img"); // classe permettant un affichage propre de l'image
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

                // distinction entre les 2 premières fenêtres modales et les 2 autres fenêtres modales de confirmation
                if (status == 'non traité') {
                    document.getElementById("btn-statut").textContent = "Commencer le traitement";
                    document.getElementById("fr-modal-2-title").textContent =
                        "Voulez-vous vraiment traiter cette demande ?";
                    if (document.body.contains(textareaModalConf)) {
                        var element = document.getElementById("chgmt-statut");
                        element.removeChild(textareaModalConf);
                    }
                }
                if (status == 'en cours') {
                    document.getElementById("btn-statut").textContent = "Terminer le traitement";
                    document.getElementById("fr-modal-2-title").textContent =
                        "Voulez-vous vraiment terminer cette demande ?";
                    if (!(document.body.contains(textareaModalConf))) {
                        var div = document.createElement("div");
                        div.id = "modal-textarea";
                        div.classList.add("fr-my-5w");

                        var subtitle = document.createElement("label");
                        subtitle.classList.add("fr-label");
                        subtitle.textContent =
                            "Si oui, veuillez renseigner la démarche que vous avez adopté pour résoudre le problème :";

                        var textarea = document.createElement("textarea");
                        textarea.classList.add("fr-input");
                        textarea.id = "textarea-commentaire";
                        textarea.name = "resolution";

                        div.appendChild(subtitle);
                        div.appendChild(textarea);

                        var firstCh = document.getElementById("chgmt-statut").firstChild

                        // document.getElementById("chgmt-statut").appendChild(div);
                        document.getElementById("chgmt-statut").insertBefore(div,
                            firstCh); // placera le textarea au-dessus des boutons
                    }
                }

                // permet de créer des champs input de type 'hidden', ce qui permet au côté serveur de récupérer les valeurs nécessaires ('id' qui est donné en fonction du bouton modale cliqué et permet au serveur de faire les requêtes sur la BD en fonction de l'id; 'status' idem)
                if (!(document.body.contains(childModalConf1) && document.body.contains(
                        childModalConf2))) { // si le DOM ne contient pas ces <div>, alors on les crée
                    createInputModal(data.ticketMod.id, data.ticketMod.status); // fonction ci-dessous
                } else { // si le DOM contient ces <div>, alors on les retire et on les recrée afin d'éviter les conflits entre les différents 'input' dans les modales 
                    var element = document.getElementById("chgmt-statut");
                    var child1 = document.getElementById("modal-Conf--value");
                    var child2 = document.getElementById("modal-Conf--status");
                    element.removeChild(child1);
                    element.removeChild(child2);
                    createInputModal(data.ticketMod.id, data.ticketMod.status);
                }
            }
        }
        xmlhttp.send();
    }

    // fonction qui attend un id et status, tous deux recoltés via l'AJAX en fonction de l'id, id dépendant de la fenêtre modale cliquée
    function createInputModal(id, status) {
        var input1 = document.createElement("input");
        input1.type = "hidden";
        input1.id = "modal-Conf--value";
        input1.name = "value_modal";
        input1.value = id;
        document.getElementById("chgmt-statut").appendChild(input1);

        var input2 = document.createElement("input");
        input2.type = "hidden";
        input2.id = "modal-Conf--status";
        input2.name = "status_modal";
        input2.value = status;
        document.getElementById("chgmt-statut").appendChild(input2);
    }

    // lorsqu'un superviseur souhaite insérer un commentaire dans le ticket
    function modalCommentaire(id) {
        var input1 = document.createElement("input");
        input1.type = "hidden";
        input1.id = "modal-Conf--value";
        input1.name = "value_modal";
        input1.value = id;
        document.getElementById("commentaire-insert").appendChild(input1);
    }

    // ajouter des zéros pour la date dans les fenêtres modales (esthétique)
    function addZero(i) {
        if (i < 10) {
            i = "0" + i
        }
        return i;
    }
</script>
