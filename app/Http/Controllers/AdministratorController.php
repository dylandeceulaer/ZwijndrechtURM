<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdministratorController extends Controller
{
    public function index(){
        Gate::authorize('isAdministrator');
        return view('administrator.index');
    }
}
