<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DienstTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(GebruikerTableSeeder::class);
        $this->call(TaaksoortTableSeeder::class);
        $this->call(ToepassingsoortSeeder::class);
        $this->call(GroepSeeder::class);
        $this->call(ToepassingSeeder::class);
        $this->call(GebruikersprofielSeeder::class);

    }
}
