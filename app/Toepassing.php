<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Toepassing extends Model
{
    protected $fillable = [
        'naam','beschrijving'
    ];
    public function toepassingsverantwoordelijken(){
        return $this->belongsTo(Groep::class,'toepassingsverantwoordelijke');
    }
    public function toepassingsoort(){
        return $this->belongsTo(Toepassingsoort::class);
    }
    public function gebruikersprofielen(){
        return $this->belongsToMany(Gebruikersprofiel::class)
                    ->using(ToepassingGebruikersprofiel::class)
                    ->withPivot(['meerInfo',]);
    }
    use SoftDeletes;
}
