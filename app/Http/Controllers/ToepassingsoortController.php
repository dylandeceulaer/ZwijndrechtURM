<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Toepassingsoort;

class ToepassingsoortController extends Controller
{
    
    public function index()
    {
        return Toepassingsoort::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'naam' => 'required|max:255'
        ]);
        if($request->has('id') && $request->has('naam')){
            $toepassingSoort = Toepassingsoort::where('id',$request['id'])->first();
            $toepassingSoort->update(['naam' => $request['naam']]);
            return response()->json($toepassingSoort,200);
        //Nieuw profiel aanmaken
        }else if($request->has('naam')){
            $toepassingSoort = Toepassingsoort::Create(['naam' => $request['naam']]);
            return response()->json($toepassingSoort,200);
        }else{
            return response()->json('Geen overeenkomstige post actie', 500);
        }
    }

}
