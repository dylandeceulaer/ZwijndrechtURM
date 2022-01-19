<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Toepassing;

class ToepassingController extends Controller
{
    public function index(){
        return Toepassing::with('toepassingsoort')->get();
    }
}
