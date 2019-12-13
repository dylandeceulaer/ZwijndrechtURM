<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gebruikersprofiel extends Model
{
    protected $fillable = [
        'naam'
    ];
    public function dienst(){
        return $this->belongsTo('App\Dienst');
    }
}
