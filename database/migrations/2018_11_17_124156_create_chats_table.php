<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('id_user1');
            $table->unsignedInteger('id_user2');
            $table->string('token');
            $table->timestamps();
            $table->foreign('id_user1')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('id_user2')
                ->references('id')->on('users')
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
        Schema::dropIfExists('chats');
    }
}
