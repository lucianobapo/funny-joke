<?php

use Illuminate\Database\Schema\Blueprint;
use ErpNET\BaseMigration\BaseMigration as Migration;

class CreateMandantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function upMigration()
    {
        Schema::create('mandantes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mandante')->index();
            $table->string('siteName')->nullable();
            $table->string('jokeName')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function downMigration()
    {
        Schema::drop('mandantes');
    }
}
