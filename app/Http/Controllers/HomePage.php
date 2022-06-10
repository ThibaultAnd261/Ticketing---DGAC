<?php

namespace App\Http\Controllers;

use App\Http\Controllers\DataRetriever;

class HomePage extends Controller
{
    public function index()
    {
        return view('home');
    }
    public function creationTicket()
    {
        $services = (new DataRetriever)->getEveryServices();
        // $titre = (new DataRetriever)->getEveryTitles();
        return view('create', compact('services'));
    }
    public function tableauBord()
    {
        $tickets = (new DataRetriever)->getEveryTicketsInfo();
        $id = 1;
        // $ticketMod = (new DataRetriever)->modal();
        return view('dashboard', compact('tickets', 'id'));
    }
    public function statistique()
    {
        $services = (new DataRetriever)->getEveryServices();
        return view('stats', compact('services'));
    }
    public function ticketCree()
    {
        $tickets = (new DataRetriever)->getEveryTicketsInfo();
        return view('ticket-user', compact('tickets'));
    }

    public function connexionCompte()
    {
        return view('login');
    }
    public function deconnexionCompte()
    {
        auth()->logout();
        return redirect()->route('acc');
    }
    public function creationCompte()
    {
        $services = (new DataRetriever)->getEveryServices();
        return view('register', compact('services'));
    }
    public function test()
    {
        if(auth()->check()){
            return view('test');
        } else {
            return redirect()->route('acc')->withErrors('Vous devez vous connecter');
        }
    }
    public function mdpOublie()
    {
        return view('mdp-forgotten');
    }
    public function mdpChangement(){
        return view('reset-password');
    }
}