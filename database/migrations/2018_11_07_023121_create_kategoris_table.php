<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKategorisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('filename');
            $table->string('originalName');
            $table->timestamps();
        });

        Schema::create('kategori_buku', function (Blueprint $table) {
            $table->unsignedInteger('kategori_id');
            $table->unsignedInteger('book_id');

            $table->foreign('book_id')
                ->references('id')->on('books')
                ->onDelete('cascade');
            $table->foreign('kategori_id')
                ->references('id')->on('kategoris')
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
        Schema::dropIfExists('kategori_buku');
        Schema::dropIfExists('kategoris');
    }
}
