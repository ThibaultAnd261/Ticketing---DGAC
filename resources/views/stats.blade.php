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
                <a class="fr-nav__link" href="{{ route('tic') }}" target="_self">Vos tickets</a>
            </li>
            @if (auth()->user()->fonction == 'Superviseur')
                <li class="fr-nav__item">
                    <a class="fr-nav__link" href="{{ route('tab') }}" target="_self">Tableau de bord</a>
                </li>
                <li class="fr-nav__item">
                    <a class="fr-nav__link" href="{{ route('sta') }}" target="_self"
                        aria-current="page">Statistiques</a>
                </li>
            @endif
        </ul>
    </nav>
@endsection

<!-- section permettant de définir la partie dynamique du site -->
@section('content')
    <main role="maincontent" id="main">
        <section class="fr-container fr-my-10w ">
            <h1 class="fr-h1">Statistiques</h1>

            <div class="fr-container" id="filtre-container">
                <div class="fr-grid-row fr-my-5w">
                    <label class="fr-label fr-col-12">Période
                        <span class="fr-hint-text">Veuillez indiquer l'année, le mois ou la semaine qui vous intéresse
                            pour visualiser ces statistiques</span>
                    </label>
                    <select class="fr-select" id="datetime-select" name="demande-date" onchange="dateChoice()">
                        <option value="" selected disabled hidden>Selectionnez la période souhaitée</option>
                        <option value="Année">Année</option>
                        <option value="Mois">Mois</option>
                        <option value="Semaine">Semaine</option>
                    </select>
                </div>
            </div>
        </section>
    </main>
@endsection

<script>
    function dateChoice() {
        let dateChoiceValue = document.getElementById("datetime-select").value;
        let dateFilters = document.getElementById("select-date");
        let buttonConfirm = document.getElementById("stats-button")
        let divStatContent = document.getElementById("stats-month");

        if (!(document.body.contains(dateFilters))) {
            inputDate(dateChoiceValue)
        } else {
            dateFilters.remove();
            inputDate(dateChoiceValue)
            if (document.body.contains(buttonConfirm)) {
                buttonConfirm.remove();
            }
            if (document.body.contains(divStatContent)) {
                divStatContent.remove();
            }
        }
    }

    function inputDate(dateChoiceValue) {
        if (dateChoiceValue == "Année") {
            let div = document.createElement("div");
            div.className = "fr-grid-row fr-my-5w";
            div.id = "select-date"

            let label = document.createElement("label");
            label.className = "fr-label fr-col-12";
            label.textContent = "Choissisez l'année en mettant une date appartenant à l'année recherché";

            let inputYear = document.createElement("input");
            inputYear.className = "fr-input[type=date] fr-my-3w"
            inputYear.name = "date-choice"
            inputYear.id = "date-choice"
            inputYear.type = "date"
            inputYear.setAttribute("onchange", "yearChoice()");

            div.appendChild(label);
            div.appendChild(inputYear);
            document.getElementById("filtre-container").appendChild(div);
        }

        if (dateChoiceValue == "Mois") {
            let div = document.createElement("div");
            div.className = "fr-grid-row fr-my-5w";
            div.id = "select-date"

            let label = document.createElement("label");
            label.className = "fr-label fr-col-12";
            label.textContent = "Choissisez le mois qui vous intéresse";

            let inputMonth = document.createElement("input");
            inputMonth.className = "fr-input fr-my-3w"
            inputMonth.name = "date-choice"
            inputMonth.id = "date-choice"
            inputMonth.type = "month"
            inputMonth.setAttribute("onchange", "monthChoice()");

            div.appendChild(label);
            div.appendChild(inputMonth);
            document.getElementById("filtre-container").appendChild(div);
        }

        if (dateChoiceValue == "Semaine") {
            let div = document.createElement("div");
            div.className = "fr-grid-row fr-my-5w";
            div.id = "select-date"

            let label = document.createElement("label");
            label.className = "fr-label fr-col-12";
            label.textContent = "Choissisez la première date et la deuxième date";

            let inputDate1 = document.createElement("input");
            inputDate1.className = "fr-input[type=date] fr-my-3w"
            inputDate1.name = "date-choice1"
            inputDate1.id = "date-choice1"
            inputDate1.type = "date"
            inputDate1.setAttribute("onchange", "weekChoice()");

            let inputDate2 = document.createElement("input");
            inputDate2.className = "fr-input[type=date] fr-my-3w"
            inputDate2.name = "date-choice2"
            inputDate2.id = "date-choice2"
            inputDate2.type = "date"
            inputDate2.setAttribute("onchange", "weekChoice()");

            div.appendChild(label);
            div.appendChild(inputDate1);
            div.appendChild(inputDate2);
            document.getElementById("filtre-container").appendChild(div);
        }
    }

    function yearChoice() {
        var firstDate = document.getElementById("date-choice").value;
        var date = new Date(firstDate);
        var year1 = date.getFullYear();
        var year2 = year1 + 1;
        // console.log(year2);

        let buttonConfirm = document.getElementById("stats-button")

        if (!(document.body.contains(buttonConfirm))) {
            let ul = document.createElement("ul");
            ul.className =
                "fr-btns-group fr-btns-group--right fr-btns-group--inline-reverse fr-btns-group--inline-lg fr-btns-group--icon-left"

            let li = document.createElement("li");

            let button = document.createElement("button");
            button.className = "fr-btn";
            button.id = "stats-button";
            button.textContent = "Rechercher";
            button.setAttribute("onclick", "stats('" + year1 + "'," + "'" + year2 + "')");

            li.appendChild(button);
            ul.appendChild(li);
            document.getElementById("filtre-container").appendChild(ul);
        } else {
            let button = document.getElementById("stats-button");
            button.removeAttribute("onclick");
            button.setAttribute("onclick", "stats('" + year1 + "'," + "'" + year2 + "')");

            let divStatContent = document.getElementById("stats-month");
            if (document.body.contains(divStatContent)) {
                divStatContent.remove();
            }
        }
    }

    function monthChoice() {
        let buttonConfirm = document.getElementById("stats-button")

        let monthChoice = document.getElementById("date-choice").value;
        let date = new Date(monthChoice)

        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);

        var firstDayNumber = firstDay.getDate();
        var lastDayNumber = lastDay.getDate();

        var firstDate = [date.getFullYear(), date.getMonth() + 1, firstDayNumber].join('-');
        var lastDate = [date.getFullYear(), date.getMonth() + 1, lastDayNumber].join('-');

        console.log(firstDate);
        console.log(lastDate);

        if (!(document.body.contains(buttonConfirm))) {
            let ul = document.createElement("ul");
            ul.className =
                "fr-btns-group fr-btns-group--right fr-btns-group--inline-reverse fr-btns-group--inline-lg fr-btns-group--icon-left"

            let li = document.createElement("li");

            let button = document.createElement("button");
            button.className = "fr-btn";
            button.id = "stats-button";
            button.textContent = "Rechercher";
            button.setAttribute("onclick", "stats('" + firstDate + "'," + "'" + lastDate + "')");

            li.appendChild(button);
            ul.appendChild(li);
            document.getElementById("filtre-container").appendChild(ul);
        } else {
            let button = document.getElementById("stats-button");
            button.removeAttribute("onclick");
            button.setAttribute("onclick", "stats('" + firstDate + "'," + "'" + lastDate + "')");

            let divStatContent = document.getElementById("stats-month");
            if (document.body.contains(divStatContent)) {
                divStatContent.remove();
            }
        }
    }

    function weekChoice() {
        let firstDate = document.getElementById("date-choice1").value;
        let lastDate = document.getElementById("date-choice2").value;

        let buttonConfirm = document.getElementById("stats-button")

        if (!(document.body.contains(buttonConfirm))) {
            let ul = document.createElement("ul");
            ul.className =
                "fr-btns-group fr-btns-group--right fr-btns-group--inline-reverse fr-btns-group--inline-lg fr-btns-group--icon-left"

            let li = document.createElement("li");

            let button = document.createElement("button");
            button.className = "fr-btn";
            button.id = "stats-button";
            button.textContent = "Rechercher";
            button.setAttribute("onclick", "stats('" + firstDate + "'," + "'" + lastDate + "')");

            li.appendChild(button);
            ul.appendChild(li);
            document.getElementById("filtre-container").appendChild(ul);
        } else {
            let button = document.getElementById("stats-button");
            button.removeAttribute("onclick");
            button.setAttribute("onclick", "stats('" + firstDate + "'," + "'" + lastDate + "')");

            let divStatContent = document.getElementById("stats-month");
            if (document.body.contains(divStatContent)) {
                divStatContent.remove();
            }
        }
    }

    function stats(firstDate, lastDate) {
        var service = "{{ auth()->user()->service }}";
        var xmlhttp =
            new XMLHttpRequest(); //requêtes HTTP qui pourra récupérer les données dans le serveur sans changer de page
        xmlhttp.open("GET", "http://localhost/larProj/public/month/" + firstDate + "/" + lastDate + "/" + service,
            true
        ); // récupère les données présentes sur l'URL qui est en méthode GET (tapé l'url avec un id valide pour voir les données) ! à définir dans routes/web.php
        xmlhttp.setRequestHeader("Content-Type", "application/json");
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var data = JSON.parse(xmlhttp.response); // permet de manipuler les données en format JSON

                let div = document.createElement("div");
                div.className = "fr-my-5w";
                div.id = "stats-month"

                let divStat = document.getElementById("stats-month")

                if (data.status == '200' && !(document.body.contains(divStat))) {

                    let div2 = document.createElement("div");
                    div2.className = "fr-my-5w";
                    div2.id = "stats-content"
                    div2.textContent = "Nombre total de demandes reçues sur la période sélectionné : " + data
                        .statsCount

                    let div3 = document.createElement("div");
                    div3.className = "fr-my-5w";
                    div3.id = "stats-content"
                    div3.textContent = "Nombre total de demandes avec une criticité élevée : " + data
                        .statsCountHigh

                    let div4 = document.createElement("div");
                    div4.className = "fr-my-5w";
                    div4.id = "stats-content"
                    div4.textContent = "Nombre total de demandes avec une criticité moyenne : " + data
                        .statsCountMedium

                    let div5 = document.createElement("div");
                    div5.className = "fr-my-5w";
                    div5.id = "stats-content"
                    div5.textContent = "Nombre total de demandes avec une criticité faible : " + data
                        .statsCountSoft

                    let div6 = document.createElement("div");
                    div6.className = "fr-my-5w";
                    div6.id = "stats-content"
                    div6.textContent = "Nombre total de demandes traité : " + data.statsCountTreated

                    let div7 = document.createElement("div");
                    div7.className = "fr-my-5w";
                    div7.id = "stats-content"
                    div7.textContent = "Nombre total de demandes en cours de traitement : " + data
                        .statsCountProgress

                    let div8 = document.createElement("div");
                    div7.className = "fr-my-5w";
                    div7.id = "stats-content"
                    div7.textContent = "Nombre total de demandes non traité : " + data.statsCountNotTreated

                    div.appendChild(div2);
                    div.appendChild(div3);
                    div.appendChild(div4);
                    div.appendChild(div5);
                    div.appendChild(div6);
                    div.appendChild(div7);
                    document.getElementById("filtre-container").appendChild(div);
                } else if (data.status == '404' && !(document.body.contains(divStat))) {
                    let div2 = document.createElement("div");
                    div2.className = "fr-my-5w";
                    div2.id = "stats-content"
                    div2.textContent = "Aucune donnée avec ces filtres"

                    div.appendChild(div2);
                    document.getElementById("filtre-container").appendChild(div);
                }
            }
        }
        xmlhttp.send();
    }
</script>
