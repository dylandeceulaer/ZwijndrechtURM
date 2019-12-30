<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    protected $fillable = [
        "naam",
    ];
    public function gebruikersprofiels(){
        return $this->HasMany(Gebruikersprofiel::class);
    }
    use SoftDeletes;
}
