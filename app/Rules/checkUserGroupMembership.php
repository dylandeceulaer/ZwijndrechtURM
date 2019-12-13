<?php

namespace App\Rules;

use Adldap\Laravel\Validation\Rules\Rule;
use Illuminate\Support\Facades\Log;

class checkUserGroupMembership extends Rule
{
    /**
     * Determines if the user is allowed to authenticate.
     *
     * @return bool
     */
    public function isValid()
    {

        if($this->user->inGroup(env('LDAP_SCOPE_ADMINS'), '') || $this->user->inGroup(env('LDAP_SCOPE_DIENSTHOOFDEN'), '') || $this->user->inGroup(env('LDAP_SCOPE_PERSONEELSDIENST'), '')){
            return true;
        }else{ return false;}
        
    }
}

