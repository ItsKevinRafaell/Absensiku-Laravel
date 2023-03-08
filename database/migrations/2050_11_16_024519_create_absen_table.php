<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id')->cascadeOnUpdate()->cascadeOnDelete()->constrained();
            $table->string('jam_kedatangan')->nullable();
            $table->string('jam_kepulangan')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude_kepulangan')->nullable();
            $table->string('longitude_kepulangan')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('file_kedatangan')->nullable();
            $table->string('file_kepulangan')->nullable();
            $table->string('catatan')->nullable();
            $table->string('bukti')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();

            $table->foreign('siswa_id')
                ->references('id')
                ->on('siswa')
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
        Schema::dropIfExists('absen');
    }
}
