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
            $table->string('description')->nullable();
            $table->string('paramProfileImageSize')->nullable();
//            $table->string('paramProfileImagePosition')->nullable();
            $table->string('paramProfileImageX')->nullable();
            $table->string('paramProfileImageY')->nullable();
            $table->string('paramName')->nullable();
            $table->string('paramNameSize')->nullable();
            $table->string('paramNameColor')->nullable();
            $table->string('paramNameX')->nullable();
            $table->string('paramNameY')->nullable();
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
