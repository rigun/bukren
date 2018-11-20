<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_chats', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_pemilik');
            $table->text('pesan');
            $table->integer('status')->default(0);
            $table->string('token');
            $table->timestamps();
            $table->foreign('id_pemilik')
                ->references('id')->on('users');
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('list_chats');
    }
}
