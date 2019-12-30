<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gebruiker;

class GebruikerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $gebruikers = Gebruiker::all();
        return view('gebruiker',[
            'gebruikers' => $gebruikers,
        ]);
    }
    public function show($user){
        $gebruiker = Gebruiker::find($user);
        return view('gebruiker',[
            'gebruiker' => $gebruiker,
        ]);
    }
    public function showByName($userName){
        $gebruiker = Gebruiker::where("naam",$userName)->first();
        return view('gebruiker',[
            'gebruiker' => $gebruiker,
        ]);
    }
    public function create(){
       //nieuwe gebruiker 
    }
    public function store(){
     //nieuwe gebruiker opéénvolgend na create   
    }
    public function edit(){
        
    }
    public function update(){
        
    }
    public function delete(){
        
    }
}
