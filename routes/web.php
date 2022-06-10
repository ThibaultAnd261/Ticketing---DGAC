<?php

use App\Http\Controllers\GestionTicketController;
use App\Http\Controllers\DataRetriever;
use App\Http\Controllers\HomePage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GestionCompteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ->name('..') => appeler une route dans les views est possible juste en mettant le nom donc pas besoin de mettre le chemin relatif vers le controlleur dans les href
// ->middleware('auth') => règle obligeant une authentification pour accéder aux pages

// pages pouvant être accédées sans être connecté
Route::get('/', [HomePage::class, 'index'])->name('acc');
Route::post('/deconnexion', [HomePage::class, 'deconnexionCompte'])->name('dec');
Route::get('/connexion', [HomePage::class, 'connexionCompte'])->name('con');
Route::get('/inscription', [HomePage::class, 'creationCompte'])->name('creC');
Route::get('/oublie', [HomePage::class, 'mdpOublie'])->name('mdp');
    // récupérer via send(['token'...] sur mail-password-forgotten qui lance la page)
Route::get('/reinitialisation/{token}', [HomePage::class, 'mdpChangement'])->name('reset');

// gère le processus de connexion/inscription/changement de mot de passe
Route::post('/authentificationCompte', [GestionCompteController::class, 'authentificationCompte'])->name('authentification');
Route::post('/inscriptionCompte', [GestionCompteController::class, 'inscriptionCompte'])->name('inscription');
Route::post('/mdpOublieCompte', [GestionCompteController::class, 'mdpOublieCompte'])->name('mdpoublie');
Route::post('/reinitialisationCompte', [GestionCompteController::class, 'reinitialisationCompte'])->name('rei');

// pages une fois connecté / non accessible si on tape tout l'URL mais qu'on n'est pas connecté, renvoie sur la page d'accueil (voir app/Http/Middleware/Authenticate.php)
Route::get('/creationTicket', [HomePage::class, 'creationTicket'])->name('creT')->middleware('auth');
Route::get('/tableau', [HomePage::class, 'tableauBord'])->name('tab')->middleware('auth');
Route::get('/ticket', [HomePage::class, 'ticketCree'])->name('tic')->middleware('auth');
Route::get('/statistiques', [HomePage::class, 'statistique'])->name('sta')->middleware('auth');
// possède les informations concernant le ticket cherché par l'utilisateur; {id} correspondant à l'id attendu par la fonction 'modal' dans DataRetriever et permet la recherche dans la BD pour le ticket correspondant
Route::get('/tableau/{id}', [DataRetriever::class, 'modal'])->name('mod')->middleware('auth');
// gère la création de ticket
Route::post('/ticketCree', [GestionTicketController::class, 'creationTicket'])->name('ticketing');
// gère le statut d'un ticket
Route::post('/statutTicket', [GestionTicketController::class, 'statutTicket'])->name('statutTicket');
// gère l'insertion d'un commentaire par un superviseur
Route::post('/commentaireTicket', [GestionTicketController::class, 'commentaireTicket'])->name('commentaireTicket');


Route::get('/month/{firstDate}/{lastDate}/{service}', [DataRetriever::class, 'getStatsMonth'])->name('statMonth')->middleware('auth');
