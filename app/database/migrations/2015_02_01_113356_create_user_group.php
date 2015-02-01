<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGroup extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_group', function($table) {
            $table->string('open_id', 32);
            $table->integer('group_id');
            $table->primary(array('open_id', 'group_id'));
            $table->foreign('open_id')
                ->references('open_id')->on('user')
                ->onDelete('cascade');
            $table->foreign('group_id')
                ->references('group_id')->on('group')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_group');
    }

}
