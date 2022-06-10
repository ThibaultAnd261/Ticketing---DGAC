<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataRetriever extends Controller
{

    // Controller agissant principalement avec la BD afin de recueillir des informations pouvant être principalement utilisées sur tout le site
    
    
    // permet de retrouver les différents services de la DGAC présents dans la BD
    public function getEveryServices()
    {
        $service = DB::table('services')->select('nomService')->get();
        return $service->sortBy('nomService')->all();
    }

    // permet de retrouver les tickets présents dans la BD
    public function getEveryTicketsInfo()
    {
        $tickets = DB::table('tickets')->select('id', 'name', 'email', 'serviceDemandeur', 'serviceAffecte', 'priorite', 'titre', 'status', 'created_at')->get();
        return $tickets;
    }

    // permet de retrouver un ticket en particulier, présent dans la BD
    public function getTicketInfo(int $id)
    {
        $ticket  = DB::table('tickets')->select('id', 'serviceAffecte', 'priorite', 'titre', 'status', 'commentaires', 'created_at')->where('id', $id)->get();
        return $ticket;
    }

    // permet de retrouver le demandeur présents dans la BD en fonction du n° du ticket (principalement pour envoyer un email au demandeur)
    public function getApplicantEmail(int $id)
    {
        $emailDemandeur  = DB::table('tickets')->select('email')->where('id', $id)->get();
        return $emailDemandeur;
    }

    // permet de retrouver les superviseurs de chaque service via la BD
    public function getAdminService(string $service){
        $superviseur = DB::table('accounts')->where('service', $service)->where('fonction', 'Superviseur')->get();
        return $superviseur;
    }

    // retrouve les données en fonction du bouton "voir plus" cliqué dans le tableau de bord et attend un id pour ainsi chercher le ticket en fonction de l'id dans la BD
    public function modal(int $id)
    {
        // envoie en Array
        // $ticketMod  = DB::table('tickets')->select('id', 'name', 'email', 'priorite', 'titre', 'description', 'created_at')->where('id', $id)->get();
        
        // envoie en JSON
        $ticketMod = Ticket::find($id);
        if($ticketMod){
            return response()->json([
                'status'=>200,
                'ticketMod'=>$ticketMod
            ]);
        } else {
            return response()->json([
                'status'=>404,
                'ticketMod'=>"Not Found"
            ]);
        }
    }

    public function getStatsMonth(string $firstDate, string $lastDate, string $service){
        $statsCount = Ticket::where('created_at', '>=', $firstDate)->where('created_at', '<=', $lastDate)->where('serviceAffecte', '=', $service)->count();
        $statsCountSoft = Ticket::where('created_at', '>=', $firstDate)->where('created_at', '<=', $lastDate)->where('priorite', 'Faible')->count();
        $statsCountMedium = Ticket::where('created_at', '>=', $firstDate)->where('created_at', '<=', $lastDate)->where('priorite', 'Moyen')->count();
        $statsCountHigh = Ticket::where('created_at', '>=', $firstDate)->where('created_at', '<=', $lastDate)->where('priorite', 'Elevé')->count();
        $statsCountTreated = Ticket::where('created_at', '>=', $firstDate)->where('created_at', '<=', $lastDate)->where('status', 'traité')->count();
        $statsCountProgress = Ticket::where('created_at', '>=', $firstDate)->where('created_at', '<=', $lastDate)->where('status', 'en cours')->count();
        $statsCountNotTreated = Ticket::where('created_at', '>=', $firstDate)->where('created_at', '<=', $lastDate)->where('status', 'non traité')->count();
        // $statsContent = Ticket::where('created_at', '>=', $firstDate)->where('created_at', '<=', $lastDate)->get();
        if($statsCount){
            return response()->json([
                'status'=>200,
                'statsCount'=>$statsCount,
                'statsCountSoft'=>$statsCountSoft,
                'statsCountMedium'=>$statsCountMedium,
                'statsCountHigh'=>$statsCountHigh,
                'statsCountTreated'=>$statsCountTreated,
                'statsCountProgress'=>$statsCountProgress,
                'statsCountNotTreated'=>$statsCountNotTreated,
                // 'statsContent'=>$statsContent
            ]);
        } else {
            return response()->json([
                'status'=>404,
                'statsCount'=>"Not Found",
            ]);
        }
    }
}
