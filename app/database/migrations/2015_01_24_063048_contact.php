<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContactMigrate extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact', function($table) {
            $table->increments('id');
            $table->string('name', 10)->nullable(false);
            $table->bigInteger('phone_number')->nullable(true);
            $table->integer('short_number')->nullable(true);
            $table->integer('qq')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact');
    }

}
