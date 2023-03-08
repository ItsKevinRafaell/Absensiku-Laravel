<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswaKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswa_kelas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id')->unsigned();
            $table->unsignedBigInteger('kelas_id')->unsigned();
            $table->timestamps();

            $table->foreign('siswa_id')
            ->references('id')
            ->on('siswa')
            ->onDelete('cascade');

            $table->foreign('kelas_id')
                ->references('id')
                ->on('kelas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siswa_kelas');
    }
}
