<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class GestionCompteController extends Controller
{
    // gère le processus de connexion
    public function authentificationCompte(Request $request)
    {
        // vérifie si les champs 'email' et 'mot de passe' ont été remplis et modifie les messages d'erreur (messages d'erreur en anglais par défaut)
        $dataEntered = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Veuillez renseigner un email.',
            'password.required' => 'Veuillez renseigner un mot de passe.'
        ]);

        // regarde les valeurs des champs 'email' et 'mot de passe' et compare avec la BD, qui contient elle aussi les colonnes 'email' et 'mot de passe', si elle contient ces valeurs entrées
        if (auth()->attempt($dataEntered)) {
            // si tout est bon, on accède à l'accueil dédié aux utilisateurs connecté
            return redirect()->route('acc');
        } else {
            // sinon, on est renvoyé sur la page de login avec un message d'erreur
            return redirect()->route('con')->withErrors('Les identifiants sont faux.');
        }
    }

    // gère le processus d'inscription 
    public function inscriptionCompte(Request $request)
    {
        // vérifie si les champs 'Prénom NOM', 'email', 'service' et'mot de passe' ont été remplis et modifie les messages d'erreur
        $request->validate([
            'fonction' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:accounts,email', // unique:<table>,<colonne> / permet de regarder dans la base de données si cette adresse mail est unique ou non
            'select' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->symbols()] // 'confirmed' permet de regarder si les deux champs possède les mêmes chaines de caractères à condition que le name du mot de passe à confirmer (dans la view) est 'password_confirmation' / demande 8 caractères, des lettres et au minimum un symbole
        ], [
            'fonction.required' => 'Veuillez renseigner le type de compte souhaité',
            'name.required' => 'Veuillez renseigner votre Prénom et NOM',
            'email.required' => 'Veuillez renseigner un email',
            'email.unique' => 'Veuillez renseigner un email non utilisé.',
            'select.required' => 'Veuillez renseigner le service auquel vous êtes affecté',
            'password.required' => 'Veuillez renseigner un mot de passe.',
            'password.confirmed' => 'Les mots de passe entrés ne se coincident pas.',
            'password.symbols' => 'Le mot de passe doit contenir un symbole.',
        ]);

        // dd($request->all()); // -> récupère en format json
        $dataEntered = $request->all();

        // permet l'insertion des données entrées par l'utilisateur dans la BD
        try {
            $this->insertionBDAccount($dataEntered); // appel de la fonction 'insertionBDAccount' (en lien avec la BD), ajout d'un compte avec les données du formulaire
            return redirect()->route('con')->with('success', 'Compte créé');
        } catch (\Throwable $th) {
            return redirect()->route('creC')->withErrors('Une erreur est survenue, veuillez réessayer ou contacter le support');
        }
    }

    // processus de demande de réinitialisation de mot de passe
    public function mdpOublieCompte(Request $request)
    {
        // email donné sur le formulaire
        $request->validate([
            'email' => 'required|email'
        ]);
        $token = Str::random(60); // token crée de manière aléatoire, permettant l'accès à une URL unique pour le changement de mdp

        $dataEntered = array( // création d'un array avec les valeurs de ci-dessus
            'email' => $request->email,
            'token' => $token
        );

        if (DB::table('accounts')->where('email', $dataEntered['email'])->exists()) { // on regarde si dans la table 'accounts' (possédant les différents compte des utilisateurs avec ces données), l'email donné dans le formulaire est présent dans la table
            try {
                $this->insertionBDMdpReset($dataEntered); // appel de la fonction 'insertionBDMdpReset' (en lien avec la BD), ajout des tokens
                Mail::send('mail.mail-password-forgotten', ['token' => $token], function ($msg) use ($request) { // envoi d'un email (corps de l'email dans resources/views/mail/mail-password-forgotten) à l'utilisateur concerné
                    $msg->to($request->email);
                    $msg->subject('Reset Password');
                });
                return redirect()->route('con')->with('success', 'Email envoyé pour la modification de mot de passe');
            } catch (\Throwable $th) {
                return redirect()->back()->withErrors('Une erreur est survenue, veuillez réessayer ou contacter le support');
            }
        } else {
            return redirect()->back()->withErrors('Cette adresse mail n’existe pas dans notre système');
        }
    }

    // processus de réinitialisation de mot de passe
    public function reinitialisationCompte(Request $request)
    {
        // vérification formulaire
        $request->validate([
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->symbols()]
        ]);

        $dataEntered = array(
            'email' => $request->email,
            'password' => $request->password
        );

        try {
            $this->updateMdpAccount($dataEntered); // appel de la fonction 'updateMdpAccount' (en lien avec la BD), chgmt du mot de passe avec les données fournies sur le formulaire
            return redirect()->route('con')->with('success', 'Mot de passe changé');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('Un problème été identifié');
        }
    }

    // ajout d'un compte dans la BD (table accounts) via les données fournies (paramètre 'data' représentant '$dataEntered')
    public function insertionBDAccount(array $data)
    {
        DB::insert('insert into accounts (name, email, service, password, fonction, remember_token, created_at) values (?, ?, ?, ?, ?, ?, ?)', [$data['name'], $data['email'], $data['select'], Hash::make($data['password']), $data['fonction'], Str::random(60), Carbon::now('Europe/Paris')]);
    }

    // ajout d'un email + token dans la BD (table password_resets) via les données fournies (paramètre 'data' représentant '$dataEntered' de ci-dessus)
    public function insertionBDMdpReset(array $data)
    {
        DB::insert('insert into password_resets (email, token, created_at) values (?, ?, ?)', [$data['email'], $data['token'], Carbon::now('Europe/Paris')]);
    }

    // màj du mdp de l'utilisataeur dans la BD (table accounts) via les données fournies (paramètre 'data' représentant '$dataEntered' de ci-dessus)
    public function updateMdpAccount(array $data)
    {
        // DB::update('update accounts set password = ? where email = ?', [Hash::make($data['password']), $data['email']]);
        DB::table('accounts')->where('email', $data['email'])->update([
            'password' => Hash::make($data['password'])
        ]);
        DB::table('password_resets')->where(['email' => $data['email']])->delete();
    }
}
