<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Adldap\Laravel\Facades\Adldap;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function username()
    {
        return 'samaccountname';
    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function attemptLogin(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        $username = $credentials[$this->username()];
        $password = $credentials['password'];

        $ldapuser = Adldap::search()->where(env('LDAP_USER_ATTRIBUTE'), '=', $username)->first();
        if ( !$ldapuser ) {
            // log error
            return false;
        }
        if(Adldap::auth()->attempt($ldapuser->distinguishedName[0], $password, $bindAsUser = true)) {
            // the user exists in the LDAP server, with the provided password

            $user = \App\Gebruiker::where($this->username(), $username)->first();
            if (!$user) {
                $user = \App\Gebruiker::where("naam", $ldapuser->cn[0])->first();
                if(!$user){
                    $user = new \App\Gebruiker();
                }
                $sync_attrs = $this->retrieveSyncAttributes($username);
                foreach ($sync_attrs as $field => $value) {
                    $user->$field = $value !== null ? $value : '';
                }
            }
            $this->updateRoleMembership($user,$ldapuser);

            $this->guard()->login($user, true);
            return true;
        }

        return false;
    }
    protected function updateRoleMembership($user,$ldapuser)
    {   
        if(!$ldapuser->memberof){
            return;
        }
        if(in_array(env('LDAP_SCOPE_ADMINS'),$ldapuser->memberof)){
            $role = \App\Role::where('naam',"Administrator")->first();
            $user->roles()->syncWithoutDetaching($role);
        }
        if(in_array(env('LDAP_SCOPE_DIENSTHOOFDEN'),$ldapuser->memberof)){
            $role = \App\Role::where('naam',"Diensthoofd")->first();
            $user->roles()->syncWithoutDetaching($role);
        }
        if(in_array(env('LDAP_SCOPE_PERSONEELSDIENST'),$ldapuser->memberof)){
            $role = \App\Role::where('naam',"Personeelsdienst")->first();
            $user->roles()->syncWithoutDetaching($role);
        }
        $user->save();
    }
    protected function retrieveSyncAttributes($username)
    {
        $ldapuser = Adldap::search()->where(env('LDAP_USER_ATTRIBUTE'), '=', $username)->first();
        if ( !$ldapuser ) {

            return false;
        }

        $ldapuser_attrs = null;

        $attrs = [];

        foreach (config('ldap_auth.sync_attributes') as $local_attr => $ldap_attr) {
            if ( $local_attr == 'username' ) {
                continue;
            }

            $method = 'get' . $ldap_attr;
            if (method_exists($ldapuser, $method)) {
                $attrs[$local_attr] = $ldapuser->$method();
                continue;
            }

            if ($ldapuser_attrs === null) {
                $ldapuser_attrs = self::accessProtected($ldapuser, 'attributes');
            }

            if (!isset($ldapuser_attrs[$ldap_attr])) {
                // an exception could be thrown
                $attrs[$local_attr] = null;
                continue;
            }

            if (!is_array($ldapuser_attrs[$ldap_attr])) {
                $attrs[$local_attr] = $ldapuser_attrs[$ldap_attr];
            }

            if (count($ldapuser_attrs[$ldap_attr]) == 0) {
                // an exception could be thrown
                $attrs[$local_attr] = null;
                continue;
            }

            $attrs[$local_attr] = $ldapuser_attrs[$ldap_attr][0];
            
        }

        return $attrs;
    }

    protected static function accessProtected ($obj, $prop)
    {
        $reflection = new \ReflectionClass($obj);
        $property = $reflection->getProperty($prop);
        $property->setAccessible(true);
        return $property->getValue($obj);
    }

}
