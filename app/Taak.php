<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Taak extends Model
{
    public function gebruiker(){
        return $this->belongsTo(Gebruiker::class);
    }
    public function verantwoordelijke(){
        return $this->belongsTo(Gebruiker::class,'verantwoordelijke');
    }
    public function taaksoort(){
        return $this->belongsTo(Taaksoort::class);
    }
    
    use SoftDeletes;
}
