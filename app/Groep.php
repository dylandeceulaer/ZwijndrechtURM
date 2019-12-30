<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Groep extends Model
{
    protected $fillable = [
        'naam','email',
    ];
    public function gebruikers(){
        return $this->belongsToMany(Gebruiker::class,'groep_gebruiker');
    }
    public function toepassingen(){
        return $this->hasMany(Toepassing::class,'toepassingsverantwoordelijke');
    }
    use SoftDeletes;
}
