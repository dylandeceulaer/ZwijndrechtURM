<?php

use Illuminate\Database\Seeder;
use App\Gebruikersprofiel;
use App\Team;
use App\Toepassing;
use Illuminate\Database\Eloquent\Builder;

class GebruikersprofielSeeder extends Seeder
{
    private $gebruikersprofielcsv;
    private $delimiter;
    public function __construct()
    {
        //Testdata, kan ook gebruikt worden voor (alle) gebruikersprofielen in bulk te importeren 
        //Let op de syntax! gebruikersprofiel linken met gebruikers in GebruikersTableSeeder
        //Toepassing moet al bestaan in de database via ToepassingSeeder!
        //Opmaak: geen header! gebruikersprofielnaam; team; toepassingsnaam; meer info over link toepassing<->gebruikersprofiel; (optioneel meer toepassingsnaam; meer info over link toepassing<->gebruikersprofiel;...;...;...;...)
        $this->gebruikersprofielcsv ="database/csv/Gebruikersprofielen.csv";
        $this->delimiter = ';';
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(($handle = fopen(base_path($this->gebruikersprofielcsv), 'r')) !== FALSE){
            while(($row = fgetcsv($handle,255,$this->delimiter))!==FALSE){
                $team = Team::where('naam',$row[1])->first();
                $gebruikersprofiel = Gebruikersprofiel::where('naam',$row[0])->where('team_id',$team->id)->first();
                $i = 2;

                while(array_key_exists($i, $row) && !empty($row[$i])){
                    $toepassing = Toepassing::where('naam',$row[$i])->first();
                    $toepassing->gebruikersprofielen()->attach($gebruikersprofiel,['meerInfo'=>$row[++$i]]);
                    $i++;
                }
            }
        }
    }
}
