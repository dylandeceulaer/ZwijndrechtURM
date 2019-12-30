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
    public function gebruikers(){
        return $this->HasMany(Gebruiker::class);
    }
    public function Toepassingen(){
        return $this->belongsToMany(Toepassing::class)
                    ->using(ToepassingGebruikersprofiel::class)
                    ->withPivot(['meerInfo',]);
    }
    use SoftDeletes;
}
