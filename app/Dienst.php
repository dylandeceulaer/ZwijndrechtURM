<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dienst extends Model
{
    public function teams(){
        return $this->hasMany(Team::class);
    }
    public function diensthoofd(){
        return $this->belongsTo(Gebruiker::class,'diensthoofd');
    }
    protected $fillable = [
        'naam',
    ];
    use SoftDeletes;
}
