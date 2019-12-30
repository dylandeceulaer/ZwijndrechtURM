<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Toepassingsoort extends Model
{
    protected $fillable = [
        'naam',
    ];
    public function toepassingen()
    {
        return $this->hasMany(Toepassing::class);
    }
    use SoftDeletes;
}
