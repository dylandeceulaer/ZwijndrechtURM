<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToepassingGebruikersprofielTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gebruikersprofiel_toepassing', function (Blueprint $table) {
            $table->integer('toepassing_id')->unsigned();
            $table->integer('gebruikersprofiel_id')->unsigned();
            $table->string('meerInfo')->nullable();
            $table->primary(['toepassing_id','gebruikersprofiel_id'],'toepassings_gebruikersprofiel_primary');
            $table->foreign('toepassing_id')->references('id')->on('toepassings')->onDelete('cascade');
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
        Schema::dropIfExists('toepassing_gebruikersprofiel');
    }
}
