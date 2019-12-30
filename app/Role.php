<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    protected $fillable = [
        'naam',
    ];
    public function gebruikers()
    {
        return $this->hasMany(Gebruiker::class, 'role_gebruiker');
    }
    use SoftDeletes;
    
}
