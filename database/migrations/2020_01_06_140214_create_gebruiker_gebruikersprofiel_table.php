<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGebruikerGebruikersprofielTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gebruiker_gebruikersprofiel', function (Blueprint $table) {
            $table->integer('gebruiker_id')->unsigned()->index();
            $table->integer('gebruikersprofiel_id')->unsigned()->index();
            $table->boolean('isTweedeDienst')->default(0);
            $table->primary(['gebruiker_id','gebruikersprofiel_id','isTweedeDienst'],'gebruiker_gebruikersprofiel_primary');
            $table->foreign('gebruiker_id')->references('id')->on('gebruikers')->onDelete('cascade');
            $table->foreign('gebruikersprofiel_id')->references('id')->on('gebruikersprofiels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gebruiker_gebruikersprofiels');
    }
}
