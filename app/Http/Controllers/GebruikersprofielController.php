<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gebruiker;
use App\Gebruikersprofiel;

class GebruikersprofielController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        if()
        $gebruikersprofielen = Gebruikersprofiel::all();
        return view('gebruikersprofiel',[
            'gebruikersprofielen' => $gebruikersprofielen,
        ]);
    }
}
