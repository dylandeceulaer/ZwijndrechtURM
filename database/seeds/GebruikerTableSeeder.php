<?php

use Illuminate\Database\Seeder;
use App\Gebruiker;
use App\Gebruikersprofiel;
use App\Team;
use App\Role;

class GebruikerTableSeeder extends Seeder
{
    private $gebruikercsv;
    private $delimiter;
    public function __construct()
    {
        //Testdata, kan gebruikt worden voor (alle) gebruikers te importeren samen met gebruikersprofielen
        //Dit is niet nodig om te kunnen authenticeren! Autenticatie loopt enkel via LDAP.
        //Opmaak: geen header! naam; guid; gebruikersprofielnaam; (gebruikersprofiel)organogram functienaam;dienstnaam; (optioneel rolenaam)
        $this->gebruikercsv ="database/csv/Gebruikers.csv";
        $this->delimiter = ';';
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(($handle = fopen(base_path($this->gebruikercsv), 'r')) !== FALSE){
            while(($row = fgetcsv($handle,255,$this->delimiter))!==FALSE){
                $gebruiker = Gebruiker::firstOrCreate(['naam' => $row[0], 'objectguid' => $row[1] ]);
                $gebruikersprofielTeam = Team::where('naam',$row[4])->first();
                $gebruikersprofiel = Gebruikersprofiel::firstOrCreate(['naam' => $row[2],'organogram_naam'=> $row[3]]);
                if(array_key_exists(5, $row)){
                    $role = Role::where('naam',$row[5])->first();
                    $gebruiker->roles()->attach($role);
                    
                }
                $gebruikersprofiel->team()->associate($gebruikersprofielTeam);
                $gebruikersprofiel->save();
                $gebruiker->gebruikersprofiel()->associate($gebruikersprofiel);
                $gebruiker->save();
            }
        }
                
    }
}
