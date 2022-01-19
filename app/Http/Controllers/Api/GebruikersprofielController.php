<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Gebruiker;
use App\Gebruikersprofiel;
use App\Team;
use App\Dienst;
use App\Http\Controllers\Controller;

class GebruikersprofielController extends Controller
{
    
    public function index(){
        $gebruikersprofielen = Gebruikersprofiel::with('team.dienst')->get();
        return $gebruikersprofielen;
    }
    public function showToepassingen($id){
        $gebruikersprofiel = Gebruikersprofiel::where('id',$id)->with('toepassingen.toepassingsoort')->first();
        return $gebruikersprofiel->toepassingen;
    }
    public function showGebruikers($id){
        $gebruikersprofiel = Gebruikersprofiel::where('id',$id)->with('gebruikers')->first();
        return $gebruikersprofiel->gebruikers;
    }
}
