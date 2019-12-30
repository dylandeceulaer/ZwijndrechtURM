<?php

use Illuminate\Database\Seeder;
use App\Dienst;
use App\Team;
use App\Gebruiker;
use Illuminate\Support\Facades\Log;

class DienstTableSeeder extends Seeder
{
    private $dienstencsv;
    private $delimiter;
    
    public function __construct()
    {
        //dienstencsv path, zonder header met 4 tabellen: team, dienst, diensthoofd en diensthoofdguid met lege team tabel voor diensten zonder teams bv:
        //bilbiotheek;Cultuur;Kathleen Somers; xxxxx-xxxxx-xxxx-....
        //administratie;Cultuur;Kathleen Somers; xxxxx-xxxxx-xxxx-....
        //;Financien;Ellen De Backer; xxxxx-xxxxx-xxxx-....
        $this->dienstencsv ="database/csv/Diensten.csv";
        $this->delimiter = ';';
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(($handle = fopen(base_path($this->dienstencsv), 'r')) !== FALSE){
            while(($row = fgetcsv($handle,100,$this->delimiter))!==FALSE){
                $dienst = Dienst::firstOrCreate(['naam' => $row[1]]);
                if(!empty($row[0])){
                    $team = new Team(["naam" => $row[0]]);
                    $dienst->teams()->save($team);
                }
                $diensthoofd = Gebruiker::firstOrCreate(['naam' => $row[2], 'objectguid' => $row[3] ]);
                $diensthoofd->dienst()->save($dienst);
            }
        }
    }
}
