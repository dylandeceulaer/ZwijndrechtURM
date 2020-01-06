<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gebruikersprofiel extends Model
{
    protected $fillable = [
        'naam','organogram_naam'
    ];
    public function team(){
        return $this->belongsTo(Team::class);
    }
    public function toepassingen(){
        return $this->belongsToMany(Toepassing::class)
                    ->using(ToepassingGebruikersprofiel::class)
                    ->withPivot(['meerInfo',]);
    }
    public function gebruikers(){
        return $this->belongsToMany(Gebruiker::class)
                    ->using(GebruikerGebruikersprofiel::class)
                    ->withPivot(['isTweedeDienst',]);
    }
    use SoftDeletes;
}
