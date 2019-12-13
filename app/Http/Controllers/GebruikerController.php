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
        
        return view('gebruiker');
    }
    public function show($user){
        $gebruiker = Gebruiker::find($user);
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
