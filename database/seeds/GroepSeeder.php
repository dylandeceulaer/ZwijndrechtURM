<?php

use Illuminate\Database\Seeder;
use App\Groep;
use App\Gebruiker;

class GroepSeeder extends Seeder
{
    private $groepcsv;
    private $delimiter;
    public function __construct()
    {
        //Testdata, kan ook gebruikt worden voor (alle) groepen in bulk te importeren. De gerefereerde gebruikers moeten wel bestaan.
        //Opmaak: geen header! groepnaam; (optioneel emailadres); groepslid (volledige naam); (optioneel meerdere groepsleden...;..;..;..)
        $this->groepcsv ="database/csv/groepen.csv";
        $this->delimiter = ';';
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(($handle = fopen(base_path($this->groepcsv), 'r')) !== FALSE){
            while(($row = fgetcsv($handle,255,$this->delimiter))!==FALSE){
                $groep = Groep::firstOrCreate(['naam'=>$row[0],'email'=>$row[1]]);
                $i = 2;
                while(array_key_exists($i, $row)){
                    $gebruiker = Gebruiker::where('naam',$row[$i])->first();
                    $groep->gebruikers()->attach($gebruiker);
                    $i++;
                }
            }
        }
    }
}
