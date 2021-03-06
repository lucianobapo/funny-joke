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
            $table->string('mandante')->index();
            $table->string('title')->index();
            $table->string('description')->nullable();
            $table->string('paramProfileImageSize')->nullable();
//            $table->string('paramProfileImagePosition')->nullable();
            $table->string('paramProfileImageX')->nullable();
            $table->string('paramProfileImageY')->nullable();
            $table->string('paramName')->nullable();
            $table->string('paramFirstName')->nullable();
            $table->string('paramNameSize')->nullable();
            $table->string('paramNameColor')->nullable();
            $table->string('paramNameX')->nullable();
            $table->string('paramNameY')->nullable();
            $table->string('titleSlug')->index();
            $table->string('file');
            $table->string('file1')->nullable();
            $table->string('file2')->nullable();
            $table->string('file3')->nullable();
            $table->string('file4')->nullable();
            $table->string('file5')->nullable();
            $table->string('file6')->nullable();
            $table->string('file7')->nullable();
            $table->string('file8')->nullable();
            $table->string('file9')->nullable();
            $table->string('file10')->nullable();
            $table->string('file11')->nullable();
            $table->string('file12')->nullable();
            $table->string('file13')->nullable();
            $table->string('file14')->nullable();
            $table->string('file15')->nullable();
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
