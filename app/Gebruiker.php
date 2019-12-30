<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gebruiker extends Authenticatable
{
    use Notifiable;
    
    protected $fillable = [
        'naam','objectguid',
    ];
    protected $guarded = [
        'gebruikersprofiel',
    ];
    protected $hidden = [
        'remember_token','password'
    ];
    public function gebruikersprofiel(){
        return $this->belongsTo(Gebruikersprofiel::class);
    }
    public function dienst(){
        return $this->HasOne(Dienst::class,"diensthoofd");
    }
    public function roles(){
        return $this->belongsToMany(Role::class, 'role_gebruiker');
    }
    public function groepen(){
        return $this->belongsToMany(Groep::class, 'groep_gebruiker');
    }
    use SoftDeletes;
}