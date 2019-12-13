<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Toepassing extends Model
{
    public function toepassingsverantwoordelijke(){
        //toepassingsverantwoordelijke is een gewone gebruiker, maar de foreignkey is anders om verwarring te voorkomen
        return $this->belongsTo('App\Gebruiker','toepassingsverantwoordelijke');
    }
}
