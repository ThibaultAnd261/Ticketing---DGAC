<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\DataRetriever;

class GestionTicketController extends Controller
{
    // gère la création du ticket, en lien avec la vue 'create.blade.php'
    public function creationTicket(Request $request)
    {
        // vérification du formulaire
        $request->validate([
            'select' => 'required',
            'radio-hint' => 'required',
            'select-title' => 'required',
            'text-input-text' => 'required_if:select-title,Autre', // permet de savoir si un titre alternatif est souhaité pour l'utilisateur et si c'est le cas, ce champ doit être rempli (possible de le savoir en regardant la valeur de select-title, si c'est "Autre", alors obligation de remplir le champ de texte)
            'textarea' => 'required',
            'phone' => 'required',
            'file-upload' => 'nullable|mimes:png,jpeg,gif'
        ],  [
            'select.required' => 'Veuillez renseigner le service concerné',
            'radio-hint.required' => 'Veuillez renseigner le niveau de priorité',
            'select-title.required' => 'Veuillez renseigner le titre du problème',
            'text-input-text.required_if' => 'Veuillez renseigner le titre du problème',
            'textarea.required' => 'Veuillez renseigner une description',
            'phone.required' => 'Veuillez renseigner un numéro de téléphone',
            'file-upload.mimes' => 'Veuillez fournir un fichier adapté'
        ]);

        $dataEntered = $request->all();
        // est-ce que le formulaire contient un fichier donné par l'utilisateur ?
        if ($request->hasFile('file-upload')) {
            // mettre dans le <form> de 'create.blade.php' un enctype="multipart/form-data" pour pouvoir accéder aux différentes valeurs (extension, nom du fichier, ...)
            $file = $request->file('file-upload'); // récupère le nom du fichier + extension
            $extension = $file->getClientOriginalExtension(); // récupère l'extension du fichier
            $fileName = $file->getClientOriginalName(); // récupère le nom du fichier 
            $fileSaved = substr($fileName, 0, 2) . time() . '.' . $extension; // récupère les 5 premiers caractères du nom du fichier et ajoute le temps auquel il a entré le fichier et ajoute aussi l'extension (permet d'avoir un fichier unique lorsqu'on devra récupérer le document dans les répertoires)

            $file->move('uploads/img/ticket', $fileSaved); // enregistre l'image donnée dans public/uploads/img/ticket (utile lorsqu'on souhaitera afficher dans la fenêtre modale l'image concernée)
            $dataEntered['file'] = $fileSaved; // ajouter une valeur à l'array avec le paramètre file et sera ajouté dans la BD
        } else {
            $dataEntered['file'] = 'null'; // désigne qu'aucun fichier n'a été donné
        }

        if ($request->filled('text-input-text')) { // si le champ ayant pour nom 'text-input-text' possède une valeur (lorsque l'utilisateur appuie sur "Autre" et création d'un input), alors on transmet aussi la valeur de ce champ à l'input ayant pour nom 'select-title', permettant ainsi de se baser que sur ce dernier lors de l'ajout des données dans la BD
            $dataEntered['select-title'] = $dataEntered['text-input-text'];
        }

        try {
            $this->insertionBDTicket($dataEntered);

            // permet de retrouver dans la BD via le modèle Ticket le dernier id inséré, ce qui permet d'afficher cet id dans l'email
            $data = Ticket::latest('id')->first();
            $lastId = $data->id;
            $dataEntered['id'] = $lastId;

            // retrouve les superviseurs du service demandé
            $superviseurs = (new DataRetriever)->getAdminService($dataEntered['select']);
            $emailDemandeur = auth()->user()->email;

            // try {
            //     // envoie un mail au(x) superviseur(s)
            //     Mail::send('mail.mail-creation-ticket-superviseur', ['dataEntered' => $dataEntered], function ($msg) use ($superviseurs) {
            //         // send('view renvoyé au destinataire par mail', ['les données envoyées à la view qui peuvent être réutilisées'], $msg referrant à Mail, use($superviseurs) afin d'accéder à la variable créer ci-dessus)
            //         foreach ($superviseurs as $superviseur) {
            //             $msg->to($superviseur->email);
            //             $msg->subject('Nouveau ticket créé par un utilisateur');
            //         }
            //     });
            // } catch (\Throwable $th) {
            //     return redirect()->back()->withErrors('Une erreur est survenue lors de l\'envoi du mail, veuillez réessayer ou contacter le support');
            // }
            // try {
            //     // envoie un mail au demandeur (laisser une trace de ce ticket créé)
            //     Mail::send('mail.mail-creation-ticket-demandeur', ['dataEntered' => $dataEntered], function ($msg) use ($emailDemandeur) {
            //         $msg->to($emailDemandeur);
            //         $msg->subject('Récapitulatif du nouveau ticket créé');
            //     });
            // } catch (\Throwable $th) {
            //     return redirect()->back()->withErrors('Une erreur est survenue lors de l\'envoi du mail, veuillez réessayer ou contacter le support');
            // }

            return redirect()->back()->with('success', 'Ticket créé avec succès');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('Une erreur est survenue, veuillez réessayer ou contacter le support');
        }
    }

    // gère le statut du ticket, en lien avec la vue 'dashboard.blade.php'
    public function statutTicket(Request $request)
    {

        $request->validate([
            'value_modal' => 'required',
            'status_modal' => 'required',
            'resolution' => 'required_if:status_modal,en cours',
        ],  [
            'value_modal.required' => 'Une erreur a été rencontrée, veuillez réessayer ou contacter le support',
            'status_modal.required' => 'Une erreur a été rencontrée, veuillez réessayer ou contacter le support',
            'resolution.required' => 'Veuillez renseigner la démarche que vous avez adopté pour résoudre le ticket',
        ]);

        
        $dataEntered = $request->all(); // récupère les value dans les balises <form>
        
        if ($request->filled('resolution')) { // si le champ ayant pour nom 'commentaire' possède une valeur, alors
            $dataEntered['resolution'] = $dataEntered['resolution'];
        }
        
        // dd($request->input('resolution'));
        
        if ($request->input('status_modal') == 'en cours' && $request->input('resolution') == null) {
            return redirect()->back()->withErrors('Veuillez renseigner la démarche adopter avant de valider le ticket');
        }
        

        try {
            // $this->updateStatutTicket($dataEntered);

            $dataTicket = (new DataRetriever)->getTicketInfo($dataEntered['value_modal']);
            $emailDemandeur = (new DataRetriever)->getApplicantEmail($dataEntered['value_modal']);
            $emailSuperviseur = auth()->user()->email;

            // foreach ($emailDemandeur as $value) {
            //     print_r($value->email);
            // }

            // envoie un mail au demandeur concernant la modification du statut de son ticket créé
            // try {
            //     Mail::send('mail.mail-chgmt-ticket-demandeur', ['dataTicket' => $dataTicket], function ($msg) use ($emailDemandeur) {
            //         foreach ($emailDemandeur as $value) {
            //             $msg->to($value->email);
            //             $msg->subject('Votre ticket a été redéfini par un superviseur');
            //         }
            //     });
            // } catch (\Throwable $th) {
            //     return redirect()->back()->withErrors('Une erreur est survenue lors de l\'envoi du mail, veuillez réessayer ou contacter le support');
            // }
            // try {
            //     Mail::send('mail.mail-chgmt-ticket-superviseur', ['dataTicket' => $dataTicket], function ($msg) use ($emailSuperviseur) {
            //         $msg->to($emailSuperviseur);
            //         $msg->subject('Vous avez changé le statut d\'un ticket');
            //     });
            // } catch (\Throwable $th) {
            //     return redirect()->back()->withErrors('Une erreur est survenue lors de l\'envoi du mail, veuillez réessayer ou contacter le support');
            // }

            return redirect()->back()->with('success', 'Modification apportée');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('Une erreur est survenue, veuillez réessayer ou contacter le support');
        }
    }

    // gère les commentaires insérés sur un ticket  
    public function commentaireTicket(Request $request)
    {
        $dataEntered = $request->all(); // utile pour la maj des commentaires
        // dd($dataEntered);
        try {
            $this->updateCommentaireTicket($dataEntered);
            $emailDemandeur = (new DataRetriever)->getApplicantEmail($dataEntered['value_modal']);
            $dataTicket = (new DataRetriever)->getTicketInfo($dataEntered['value_modal']); // utile pour les données insérées dans le mail
            $emailSuperviseur = auth()->user()->email;

            // try {
            //     // envoie un mail au demandeur concernant l'insertion d'un commentaire de la part du superviseur concerné sur le ticket créé
            //     Mail::send('mail.mail-commentaire-ticket-demandeur', ['dataTicket' => $dataTicket], function ($msg) use ($emailDemandeur) {
            //         foreach ($emailDemandeur as $value) {
            //             $msg->to($value->email);
            //             $msg->subject('Un superviseur a inséré/modifié un commentaire');
            //         }
            //     });
            // } catch (\Throwable $th) {
            //     return redirect()->back()->withErrors('Une erreur est survenue lors de l\'envoi du mail, veuillez réessayer ou contacter le support');
            // }
            // try {
            //     // envoie un mail au demandeur concernant l'insertion d'un commentaire de la part du superviseur concerné sur le ticket créé
            //     Mail::send('mail.mail-commentaire-ticket-superviseur', ['dataTicket' => $dataTicket], function ($msg) use ($emailSuperviseur) {
            //         $msg->to($emailSuperviseur);
            //         $msg->subject('Vous avez inséré/modifié un commentaire');
            //     });
            // } catch (\Throwable $th) {
            //     return redirect()->back()->withErrors('Une erreur est survenue lors de l\'envoi du mail, veuillez réessayer ou contacter le support');
            // }

            return redirect()->back()->with('success', 'Modification apportée');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('Une erreur est survenue, veuillez réessayer ou contacter le support');
        }
    }

    // ajout d'un ticket dans la BD (table tickets) via les données fournies (paramètre 'data' représentant '$dataEntered')
    public function insertionBDTicket(array $data)
    {
        DB::insert('insert into tickets (name, email, serviceDemandeur, serviceAffecte, priorite, titre, description, telContact, fileUpload, status, commentaires, resolution, created_at) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [auth()->user()->name, auth()->user()->email, auth()->user()->service, $data['select'], $data['radio-hint'], $data['select-title'], $data['textarea'], $data['phone'], $data['file'], 'non traité', 'null', 'null', Carbon::now('Europe/Paris')]);
    }

    // màj d'un ticket dans la BD (table tickets) en fonction de l'id (retrouver le ticket unique) et du status (permet de changer dynamiquement le statut du ticket en fonction de ce dernier)
    // public function updateStatutTicket(int $id, string $status)
    public function updateStatutTicket(array $data)
    {
        // if ($status == 'non traité') {
        if ($data['status_modal'] == 'non traité') {
            // DB::update('update tickets set status = ? where id = ?', ['en cours', $id]);
            DB::table('tickets')->where('id', $data['value_modal'])->update([
                'status' => 'en cours',
                'updated_at' => Carbon::now('Europe/Paris')
            ]);
        }
        if ($data['status_modal'] == 'en cours') {
            // DB::update('update tickets set status = ? where id = ?', ['traité', $id]);
            DB::table('tickets')->where('id', $data['value_modal'])->update([
                'status' => 'traité',
                'resolution' => $data['resolution'],
                'updated_at' => Carbon::now('Europe/Paris')
            ]);
        }
    }

    // màj de la colonne 'commentaires' dans la BD (table tickets) en fonction de l'id
    public function updateCommentaireTicket(array $data)
    {
        // DB::update('update tickets set commentaires = ? where id = ?', [$data['commentaire'], $data['value_modal']]);
        DB::table('tickets')->where('id', $data['value_modal'])->update([
            'commentaires' => $data['commentaire'],
            'updated_at' => Carbon::now('Europe/Paris')
        ]);
    }
}
