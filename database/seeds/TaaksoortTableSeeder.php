<?php

use Illuminate\Database\Seeder;
use App\Taaksoort;

class TaaksoortTableSeeder extends Seeder
{
    private $taaksoorten;
    public function __construct()
    {
        //Effectieve taaksoorten, hardcoded, niet aanpassen! (tenzij je weet wat je doet)
        $this->taaksoorten = array("inDienst","uitDienst","aanpassingRecht","nieuweToepassing");
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->taaksoorten as $taaksoort) {
            Taaksoort::firstOrCreate(['naam'=>$taaksoort]);
        }
    }
}
