<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Taaksoort extends Model
{
    protected $fillable = [
        'naam',
    ];
    public function taken()
    {
        return $this->hasMany(Taak::class);
    }
    use SoftDeletes;
}
