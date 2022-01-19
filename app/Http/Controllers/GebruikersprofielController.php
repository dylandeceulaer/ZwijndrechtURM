<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gebruiker;
use App\Gebruikersprofiel;
use Illuminate\Support\Facades\Log;
use App\Team;
use App\Dienst;
use App\Toepassing;

class GebruikersprofielController extends Controller
{
    
    public function index(){
        //$this->authorize(Gebruikersprofiel::class);
        $gebruikersprofielen = Gebruikersprofiel::with('team.dienst')->get();
        if (request()->ajax()) {  return $gebruikersprofielen; }
        $diensten = Dienst::all();
        $teams = Team::all();
        return view('administrator.gebruikersprofiel.index',[
            'gebruikersprofielen' => $gebruikersprofielen,
            'diensten' => $diensten,
            'teams' => $teams,
        ]);
    }
    public function show($id){
        $gebruikersprofiel = Gebruikersprofiel::where('id',$id)->with('toepassingen')->get();
        if (request()->ajax()) {  return $gebruikersprofiel; }
        return  $gebruikersprofiel;
       
    }
    public function showToepassingen($id){
        $gebruikersprofiel = Gebruikersprofiel::where('id',$id)->with('toepassingen.toepassingsoort')->first();
        return $gebruikersprofiel->toepassingen;
    }
    public function showGebruikers($id){
        $gebruikersprofiel = Gebruikersprofiel::where('id',$id)->with('gebruikers')->first();
        return $gebruikersprofiel->gebruikers;
    }
    public function store(Request $request){
        //toepassing aan profiel toevoegen
        if ($request->has('pivot_meerInfo') && $request->has('id') && $request->has('toepassingid')) {
            $gebruikersprofiel = Gebruikersprofiel::where('id',$request['id'])->first();
            $toepassing = Toepassing::where('id',$request['toepassingid'])->first();
            $toepassing->gebruikersprofielen()->syncWithoutDetaching([$gebruikersprofiel['id'] => ['meerInfo'=>$request['pivot_meerInfo']]]);
            return response()->json(200);
        //toepassing verwijderen uit profiel
        }else if($request->has('removeToepassing') && $request->has('id') && $request->has('toepassingid')){
            $toepassing = Toepassing::where('id',$request['toepassingid'])->first();
            $toepassing->gebruikersprofielen()->where('id',$request['id'])->detach();
            return response()->json(200);
        }
        
        $validated = $request->validate([
            'naam' => 'required|max:255',
            'organogram_naam' => 'required|max:255'
        ]);

        //Profiel wijzigen
        if($request->has('id') && $request->has('naam') && $request->has('organogram_naam') && $request->has('teamid')){
            $gebruikersprofiel = Gebruikersprofiel::where('id',$request['id'])->first();
            $team=Team::where('id',$request['teamid'])->with('dienst')->first();
            $gebruikersprofiel->update(['naam' => $request['naam'],'organogram_naam'=> $request['organogram_naam']]);
            $gebruikersprofiel->team()->associate($team);
            $gebruikersprofiel->save();
            $gebruikersprofiel['team'] = $team;
            return response()->json($gebruikersprofiel,200);
        //Nieuw profiel aanmaken
        }else if($request->has('naam') && $request->has('organogram_naam') && $request->has('teamid')){
            $gebruikersprofiel = Gebruikersprofiel::Create(['naam' => $request['naam'],'organogram_naam'=> $request['organogram_naam']]);
            $team=Team::where('id',$request['teamid'])->with('dienst')->first();
            $gebruikersprofiel->team()->associate($team);
            $gebruikersprofiel->save();
            $gebruikersprofiel['team'] = $team;
            return response()->json($gebruikersprofiel,200);
        }else{
            return response()->json('Geen overeenkomstige post actie', 500);
        }
        
     }
}
