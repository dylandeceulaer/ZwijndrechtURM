<?php

use Illuminate\Database\Seeder;
use App\Groep;
use App\Toepassing;
use App\Toepassingsoort;

class ToepassingSeeder extends Seeder
{
    private $toepassingcsv;
    private $delimiter;
    public function __construct()
    {
        //Testdata, kan ook gebruikt worden voor (alle) toepassingen in bulk te importeren 
        //samen met toepassingsverantwoordelijken(die moeten eerst gedefiniëerd worden in GroepSeeder)
        //Opmaak: geen header! toepassingnaam; toepassingsverantwoordelijkenaam;
        $this->toepassingcsv ="database/csv/Toepassingen.csv";
        $this->delimiter = ';';
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(($handle = fopen(base_path($this->toepassingcsv), 'r')) !== FALSE){
            while(($row = fgetcsv($handle,255,$this->delimiter))!==FALSE){
                $toepassing = Toepassing::firstOrCreate(['naam'=>$row[0],'beschrijving'=>$row[2]]);
                $groep = Groep::firstOrCreate(['naam'=>$row[1]]);
                $toepassingsoort = Toepassingsoort::where('naam',$row[3])->first();
                $groep->toepassingen()->save($toepassing);
                $toepassingsoort->toepassingen()->save($toepassing);
            }
        }
    }
}
