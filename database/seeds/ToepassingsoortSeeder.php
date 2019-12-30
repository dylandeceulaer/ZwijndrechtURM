<?php

use Illuminate\Database\Seeder;
use App\Toepassingsoort;

class ToepassingsoortSeeder extends Seeder
{
    private $toepassingsoorten;
    public function __construct()
    {
        //Effectieve toepassingsoorten, hardcoded, niet aanpassen (tenzij je weet wat je doet)!
        $this->toepassingsoorten = array("Mailbox","ADgroep","Intern","Extern");
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->toepassingsoorten as $toepassingsoort) {
            Toepassingsoort::firstOrCreate(['naam'=>$toepassingsoort]);
        }    
    }
}
