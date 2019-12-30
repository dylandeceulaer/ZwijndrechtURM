<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    private $roles;
    public function __construct()
    {
        //Effectieve roles, hardcoded, niet aanpassen (tenzij je weet wat je doet ;))!
        $this->roles = array("Administrator","Personeelsdienst","Diensthoofd","Toepassingsverantwoordelijke");
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        foreach ($this->roles as $role) {
            Role::firstOrCreate(['naam'=>$role]);
        }    
    }
}
