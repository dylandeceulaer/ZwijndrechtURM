<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Toepassing;

class ToepassingController extends Controller
{
    public function index(){
        $toepassingen = Toepassing::with('toepassingsoort')->get();
        if (request()->ajax()) {return $toepassingen;}
        return view('administrator.toepassing.index',[
            'toepassingen' => $toepassingen,
        ]);
    }
}
