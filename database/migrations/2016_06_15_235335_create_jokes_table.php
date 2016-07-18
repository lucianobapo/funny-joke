<?php

use Illuminate\Database\Schema\Blueprint;
use ErpNET\BaseMigration\BaseMigration as Migration;

class CreateJokesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function upMigration()
    {
        Schema::create('jokes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index();
            $table->string('titleSlug')->index();
            $table->string('file')->index();
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
        Schema::drop('jokes');
    }
}
