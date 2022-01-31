<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Toepassing;
use App\Toepassingsoort;
use App\Groep;

class ToepassingController extends Controller
{
    public function index(){
        $toepassingen = Toepassing::with('toepassingsoort')->with('toepassingsverantwoordelijken')->get();
        $toepassingsoorten = Toepassingsoort::all();
        $toepassingsverantwoordelijken = Groep::all();
        if (request()->ajax()) {return $toepassingen;}
        return view('administrator.toepassing.index',[
            'toepassingsverantwoordelijken' => $toepassingsverantwoordelijken,
            'toepassingsoorten' => $toepassingsoorten,
        ]);
    }
    public function store(Request $request){

        $validated = $request->validate([
            'naam' => 'required|max:255',
            'beschrijving' => 'max:255'
        ]);

        //Profiel wijzigen
        if($request->has('id') && $request->has('naam') && $request->has('beschrijving') && $request->has('toepassingsverantwoordelijkeid') && $request->has('toepassingsoortid')){
            $toepassing = Toepassing::where('id',$request['id'])->first();
            $toepassingsverantwoordelijke=Groep::where('id',$request['toepassingsverantwoordelijkeid'])->first();
            $toepassingsoort=Toepassingsoort::where('id',$request['toepassingsoortid'])->first();
            $toepassing->update(['naam' => $request['naam'],'beschrijving'=> $request['beschrijving']]);
            $toepassing->toepassingsoort()->associate($toepassingsoort);
            $toepassing->toepassingsverantwoordelijken()->associate($toepassingsverantwoordelijke);
            $toepassing->save();
            $toepassing['toepassingsverantwoordelijke'] = $toepassingsverantwoordelijke;
            $toepassing['toepassingsoort'] = $toepassingsoort;
            return response()->json($toepassing,200);
        //Nieuw profiel aanmaken
        }else if($request->has('naam') && $request->has('beschrijving') && $request->has('toepassingsverantwoordelijkeid') && $request->has('toepassingsoortid')){
            $toepassing = Toepassing::Create(['naam' => $request['naam'],'beschrijving'=> $request['beschrijving']]);
            $toepassingsverantwoordelijke=Groep::where('id',$request['toepassingsverantwoordelijkeid'])->first();
            $toepassingsoort=Toepassingsoort::where('id',$request['toepassingsoortid'])->first();
            $toepassing->toepassingsoort()->associate($toepassingsoort);
            $toepassing->toepassingsverantwoordelijken()->associate($toepassingsverantwoordelijke);
            $toepassing->save();
            $toepassing['toepassingsverantwoordelijke'] = $toepassingsverantwoordelijke;
            $toepassing['toepassingsoort'] = $toepassingsoort;
            return response()->json($toepassing,200);
        }else{
            return response()->json('Geen overeenkomstige post actie', 500);
        }
        
     }
}
