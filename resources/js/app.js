// permet d'afficher le tableau des tâches ou non, lié avec la view 'dashboard.blade.php'
function hide(number) {
    switch (number) { // number qui est entré dans la view et permet de savoir quel bouton a été cliqué (bouton affiché le tableau élevé/moyen/faible ? ...)
        case 1:
            var tc1 = document.getElementById("table-content1"); // attrape le tableau de la catégorie 'élevé'
            var bc1 = document.getElementById("btn-content1"); // attrape le bouton Afficher/Réduire de la catégorie 'élevé'
            if (tc1.style.display === "none") { // s'il n'est pas visible
                tc1.style.display = "block"; // on le rend visible
                bc1.textContent = "Réduire"; // on change le texte 'Affiher' en 'Réduire'
            } else { // s'il est visible
                tc1.style.display = "none"; // on le rend invisible
                bc1.textContent = "Afficher"; // on change le texte 'Réduire' en 'Affiher' 
            }
            break;
        case 2:
            var tc2 = document.getElementById("table-content2");
            var bc2 = document.getElementById("btn-content2");
            if (tc2.style.display === "none") {
                tc2.style.display = "block";
                bc2.textContent = "Réduire";
            } else {
                tc2.style.display = "none";
                bc2.textContent = "Afficher";
            }
            break;

        case 3:
            var tc3 = document.getElementById("table-content3");
            var bc3 = document.getElementById("btn-content3");
            if (tc3.style.display === "none") {
                tc3.style.display = "block";
                bc3.textContent = "Réduire";
            } else {
                tc3.style.display = "none";
                bc3.textContent = "Afficher";
            }
            break;

        default:
            break;
    }
}

// // AJAX permettant de mettre les informations correspondantes dans la fenêtre modale en fonction de l'id, lié avec la view 'dashboard.blade.php'
// function modalData(id) {
//     var xmlhttp = new XMLHttpRequest(); //requêtes HTTP qui pourra récupérer les données dans le serveur sans changer de page
//     xmlhttp.open("GET", "http://localhost/larProj/public/tableau/" + id, true); // récupère les données présentes sur l'URL qui est en méthode GET (tapé l'url avec un id valide pour voir les données) ! à définir dans routes/web.php
//     xmlhttp.setRequestHeader("Content-Type", "application/json");
//     xmlhttp.onreadystatechange = function () {
//         if (this.readyState == 4 && this.status == 200) {
//             var data = JSON.parse(xmlhttp.response); // permet de manipuler les données en format JSON

//             // insertion des données dans la modale
//             document.getElementById("id-ticket").innerHTML = data.ticketMod.id;
//             document.getElementById("creation-ticket").innerHTML = (data.ticketMod.created_at).substr(0, 10);
//             document.getElementById("demandeur-nom").innerHTML = data.ticketMod.name;
//             document.getElementById("demandeur-email").innerHTML = data.ticketMod.email;
//             document.getElementById("priorite-ticket").innerHTML = data.ticketMod.priorite;
//             document.getElementById("titre-ticket").innerHTML = data.ticketMod.titre;
//             document.getElementById("description-ticket").innerHTML = data.ticketMod.description;
//             // console.log(data.ticketMod.fileUpload);
//             if (data.ticketMod.fileUpload == 'null') {
//                 document.getElementById("image-ticket").innerHTML = "Aucune image a été insérée par le demandeur";
//             } else {
//                 // console.log(url);
//                 console.log()
//             }
//         }
//     }

//     xmlhttp.send();
// }

// document.addEventListener('DOMContentLoaded', () => {
//     document.getElementById('select').addEventListener('input', choice);
// })

// function choice(e){

//     console.log(e.target);
// }


