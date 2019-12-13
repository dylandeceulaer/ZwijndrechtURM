<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taak extends Model
{
    public function gebruiker(){
        return $this->belongsTo('App\Gebruiker');
    }
    public function verantwoordelijke(){
        return $this->belongsTo('App\Gebruiker','verantwoordelijke');
    }
}
