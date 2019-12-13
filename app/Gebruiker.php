<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;

class Gebruiker extends Authenticatable
{
    use Notifiable;
    
    protected $fillable = [
        'naam', 'inDienst', 'uitDienst','samaccountname','email','objectguid'
    ];
    protected $guarded = [
        'gebruikersprofiel',
    ];
    protected $hidden = [
        'remember_token',
    ];
    public function gebruikersprofiel(){
        return $this->belongsTo(Gebruikersprofiel::class);
    }
}
