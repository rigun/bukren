<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filename');
            $table->string('nama');
            $table->string('pengarang');
            $table->unsignedInteger('id_pemilik');
            $table->text('deskripsi');
            $table->double('harga')->nullable();
            $table->string('type');
            $table->year('tahun');
            $table->integer('stok')->default(0);
            $table->timestamps();

            $table->foreign('id_pemilik')
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
        Schema::dropIfExists('books');
    }
}
