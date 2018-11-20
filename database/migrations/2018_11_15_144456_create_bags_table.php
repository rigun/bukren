<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bags', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('barang_id');
            $table->unsignedInteger('pemilik_id');
            $table->integer('status');
            $table->timestamps();
            $table->foreign('pemilik_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
   
            $table->foreign('barang_id')
                ->references('id')->on('books')
                ->onDelete('cascade');
        });
        Schema::create('transaksis', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bag_id');
            $table->dateTime('tanggalPeminjaman');
            $table->dateTime('tanggalPengembalian')->nullable();
            $table->integer('status');
            $table->timestamps();

            $table->foreign('bag_id')
                ->references('id')->on('bags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksis');
        Schema::dropIfExists('bags');
    }
}
